<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Error handling and logging class
 */
class LT_Activation_Error_Handler {
	
	const LOG_FILE = 'lt-activation-errors.log';
	
	/**
	 * Log error with context
	 */
	public static function log_error( $message, $context = [] ) {
		$log_entry = [
			'timestamp' => current_time( 'mysql' ),
			'message' => $message,
			'context' => $context,
			'user_id' => get_current_user_id(),
			'ip' => self::get_client_ip(),
			'user_agent' => $_SERVER['HTTP_USER_AGENT'] ?? '',
		];
		
		error_log( 'LT Activation Error: ' . wp_json_encode( $log_entry ) );
	}
	
	/**
	 * Handle activation errors
	 */
	public static function handle_activation_error( $error, $context = [] ) {
		$error_code = $error->get_error_code();
		$error_message = $error->get_error_message();
		
		// Log the error
		self::log_error( $error_message, array_merge( $context, [
			'error_code' => $error_code,
			'error_data' => $error->get_error_data(),
		] ) );
		
		// Return user-friendly message
		return self::get_user_friendly_message( $error_code, $error_message );
	}
	
	/**
	 * Handle server response errors
	 */
	public static function handle_server_error( $response, $context = [] ) {
		if ( is_wp_error( $response ) ) {
			return self::handle_activation_error( $response, $context );
		}
		
		$status_code = wp_remote_retrieve_response_code( $response );
		$body = wp_remote_retrieve_body( $response );
		
		// Log server error
		self::log_error( 'Server error', array_merge( $context, [
			'status_code' => $status_code,
			'response_body' => $body,
		] ) );
		
		// Return appropriate message based on status code
		switch ( $status_code ) {
			case 400:
				return __( 'Invalid request. Please check your input and try again.', 'lt-activation' );
			case 401:
				return __( 'Authentication failed. Please contact support.', 'lt-activation' );
			case 403:
				return __( 'Access denied. Please check your permissions.', 'lt-activation' );
			case 404:
				return __( 'Activation service not found. Please try again later.', 'lt-activation' );
			case 429:
				return __( 'Too many requests. Please wait a moment and try again.', 'lt-activation' );
			case 500:
				return __( 'Server error. Please try again later.', 'lt-activation' );
			case 503:
				return __( 'Service temporarily unavailable. Please try again later.', 'lt-activation' );
			default:
				return sprintf( __( 'Server returned error %d. Please try again later.', 'lt-activation' ), $status_code );
		}
	}
	
	/**
	 * Get user-friendly error message
	 */
	private static function get_user_friendly_message( $error_code, $original_message ) {
		$messages = [
			'lt_activation_http' => __( 'Unable to connect to activation server. Please check your internet connection and try again.', 'lt-activation' ),
			'lt_activation_http_status' => __( 'Activation server returned an error. Please try again later.', 'lt-activation' ),
			'empty_code' => __( 'Purchase code is required.', 'lt-activation' ),
			'invalid_format' => __( 'Invalid purchase code format. Please check your code and try again.', 'lt-activation' ),
			'invalid_email' => __( 'Invalid email format. Please enter a valid email address.', 'lt-activation' ),
			'name_too_long' => __( 'Name is too long. Please enter a shorter name.', 'lt-activation' ),
			'invalid_name' => __( 'Name contains invalid characters. Please use only letters, numbers, and spaces.', 'lt-activation' ),
			'insufficient_permissions' => __( 'You do not have permission to perform this action.', 'lt-activation' ),
			'invalid_nonce' => __( 'Security check failed. Please refresh the page and try again.', 'lt-activation' ),
		];
		
		return $messages[ $error_code ] ?? $original_message;
	}
	
	/**
	 * Get client IP address
	 */
	private static function get_client_ip() {
		$ip_keys = [ 'HTTP_CLIENT_IP', 'HTTP_X_FORWARDED_FOR', 'REMOTE_ADDR' ];
		
		foreach ( $ip_keys as $key ) {
			if ( ! empty( $_SERVER[ $key ] ) ) {
				$ip = $_SERVER[ $key ];
				if ( strpos( $ip, ',' ) !== false ) {
					$ip = trim( explode( ',', $ip )[0] );
				}
				if ( filter_var( $ip, FILTER_VALIDATE_IP, FILTER_FLAG_NO_PRIV_RANGE | FILTER_FLAG_NO_RES_RANGE ) ) {
					return $ip;
				}
			}
		}
		
		return $_SERVER['REMOTE_ADDR'] ?? 'unknown';
	}
	
	/**
	 * Check if error is retryable
	 */
	public static function is_retryable_error( $error ) {
		$retryable_codes = [
			'lt_activation_http',
			'lt_activation_http_status',
		];
		
		if ( is_wp_error( $error ) ) {
			return in_array( $error->get_error_code(), $retryable_codes, true );
		}
		
		return false;
	}
	
	/**
	 * Get retry delay in seconds
	 */
	public static function get_retry_delay( $attempt = 1 ) {
		// Exponential backoff: 2, 4, 8, 16 seconds
		return min( pow( 2, $attempt ), 16 );
	}
}

<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Validation helper class
 */
class LT_Activation_Validator {
	
	/**
	 * Validate purchase code format
	 */
	public static function validate_purchase_code( $code ) {
		if ( empty( $code ) ) {
			return new WP_Error( 'empty_code', __( 'Purchase code is required.', 'lt-activation' ) );
		}
		
		// Basic format validation (letters, numbers, dashes)
		if ( ! preg_match( '/^[a-zA-Z0-9\-]+$/', $code ) || strlen( $code ) < 8 ) {
			return new WP_Error( 'invalid_format', __( 'Invalid purchase code format.', 'lt-activation' ) );
		}
		
		return true;
	}
	
	/**
	 * Validate email format
	 */
	public static function validate_email( $email ) {
		if ( empty( $email ) ) {
			return true; // Email is optional
		}
		
		if ( ! is_email( $email ) ) {
			return new WP_Error( 'invalid_email', __( 'Invalid email format.', 'lt-activation' ) );
		}
		
		return true;
	}
	
	/**
	 * Validate name
	 */
	public static function validate_name( $name ) {
		if ( empty( $name ) ) {
			return true; // Name is optional
		}
		
		// Check length
		if ( strlen( $name ) > 255 ) {
			return new WP_Error( 'name_too_long', __( 'Name is too long (max 255 characters).', 'lt-activation' ) );
		}
		
		// Check for dangerous characters
		if ( preg_match( '/[<>"\']/', $name ) ) {
			return new WP_Error( 'invalid_name', __( 'Name contains invalid characters.', 'lt-activation' ) );
		}
		
		return true;
	}
	
	/**
	 * Validate newsletter subscription
	 */
	public static function validate_newsletter_subscription( $newsletter_subscription ) {
		// Newsletter subscription is optional and should be boolean
		if ( ! is_bool( $newsletter_subscription ) ) {
			return new WP_Error( 'invalid_newsletter', __( 'Invalid newsletter subscription value.', 'lt-activation' ) );
		}
		
		return true;
	}
	
	/**
	 * Sanitize and validate all input data
	 */
	public static function validate_activation_data( $data ) {
		$errors = new WP_Error();
		
		// Validate purchase code
		$code_result = self::validate_purchase_code( $data['purchase_code'] ?? '' );
		if ( is_wp_error( $code_result ) ) {
			$errors->add( $code_result->get_error_code(), $code_result->get_error_message() );
		}
		
		// Validate email
		$email_result = self::validate_email( $data['email'] ?? '' );
		if ( is_wp_error( $email_result ) ) {
			$errors->add( $email_result->get_error_code(), $email_result->get_error_message() );
		}
		
		// Validate name
		$name_result = self::validate_name( $data['name'] ?? '' );
		if ( is_wp_error( $name_result ) ) {
			$errors->add( $name_result->get_error_code(), $name_result->get_error_message() );
		}
		
		// Validate newsletter subscription
		$newsletter_result = self::validate_newsletter_subscription( $data['newsletter_subscription'] ?? false );
		if ( is_wp_error( $newsletter_result ) ) {
			$errors->add( $newsletter_result->get_error_code(), $newsletter_result->get_error_message() );
		}
		
		// Return errors if any
		if ( $errors->has_errors() ) {
			return $errors;
		}
		
		return true;
	}
	
	/**
	 * Check if user has permission to activate themes
	 */
	public static function check_permissions() {
		if ( ! current_user_can( 'manage_options' ) ) {
			return new WP_Error( 'insufficient_permissions', __( 'You do not have permission to activate themes.', 'lt-activation' ) );
		}
		
		return true;
	}
	
	/**
	 * Validate nonce
	 */
	public static function validate_nonce( $nonce, $action ) {
		if ( ! wp_verify_nonce( $nonce, $action ) ) {
			return new WP_Error( 'invalid_nonce', __( 'Security check failed. Please try again.', 'lt-activation' ) );
		}
		
		return true;
	}
}

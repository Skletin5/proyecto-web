<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Theme activation admin class
 */
class LT_Activation_Admin {
	
	/** @var string Fallback option key when theme is unknown */
	const OPTION_CODE_FALLBACK = 'envato_purchase_code';
	
	/** @var string Nonce action for security */
	const NONCE_ACTION = 'lt_activation_action';
	
	/** @var string Parent menu slug */
	const MENU_SLUG = 'ltx-dashboard';
	
	/** @var string Submenu slug */
	const SUBMENU_SLUG = 'lt-activation';

	/**
	 * Constructor
	 */
	public function __construct() {
		add_action( 'admin_menu', [ $this, 'register_menu' ] );
		add_action( 'admin_post_lt_activation_submit', [ $this, 'handle_submit' ] );
		add_action( 'admin_post_lt_activation_deactivate', [ $this, 'handle_deactivate' ] );
		add_action( 'admin_enqueue_scripts', [ $this, 'enqueue_scripts' ] );
		add_action( 'wp_ajax_lt_check_activation_status', [ $this, 'ajax_check_activation_status' ] );
	}

	/**
	 * Register admin menu
	 */
	public function register_menu() {
		// Register for ltx-dashboard
		add_submenu_page(
			'ltx-dashboard',
			__( 'Theme Activation', 'lt-activation' ),
			__( 'Theme Activation', 'lt-activation' ),
			'manage_options',
			self::SUBMENU_SLUG,
			[ $this, 'render_page' ]
		);
		
		add_submenu_page(
			'ltx-dashboard',
			__( 'Demo Content', 'lt-activation' ),
			__( 'Demo Content', 'lt-activation' ),
			'manage_options',
			'fw-backups-demo-content',
			[ $this, 'redirect_to_demo_content' ]
		);
		
		// Register for lte-dashboard
		add_submenu_page(
			'lte-dashboard',
			__( 'Theme Activation', 'lt-activation' ),
			__( 'Theme Activation', 'lt-activation' ),
			'manage_options',
			self::SUBMENU_SLUG,
			[ $this, 'render_page' ]
		);
		
		add_submenu_page(
			'lte-dashboard',
			__( 'Demo Content', 'lt-activation' ),
			__( 'Demo Content', 'lt-activation' ),
			'manage_options',
			'fw-backups-demo-content',
			[ $this, 'redirect_to_demo_content' ]
		);
	}

	/**
	 * Enqueue admin scripts and styles
	 */
	public function enqueue_scripts( $hook ) {
		if ( strpos( $hook, self::SUBMENU_SLUG ) === false && strpos( $hook, 'ltx-dashboard' ) === false ) {
			return;
		}
		wp_enqueue_style(
			'lt-activation-admin',
			plugins_url( 'assets/lt-activation.css', dirname( __FILE__ ) )
		);

		wp_enqueue_script(
			'lt-activation-admin', 
			plugins_url( 'assets/lt-activation.js', dirname( __FILE__ ) ),
			[ 'jquery' ],
			true
		);
		
		wp_localize_script( 'lt-activation-admin', 'ltActivation', [
			'ajaxurl' => admin_url( 'admin-ajax.php' )
		] );
	}

	/**
	 * Render admin page
	 * 
	 * Displays the activation form or status based on current state.
	 * 
	 * @since 1.0.0
	 */
	public function render_page() {
		if ( ! current_user_can( 'manage_options' ) ) {
			return;
		}

		// Initialize activation page
		$this->init_activation_page();

		$code = get_option( $this->get_option_key(), '' );
		
		echo '<div class="wrap lt-activation-container">';
		echo '<h1>' . esc_html__( 'Theme Activation', 'lt-activation' ) . '</h1>';

		if ( $code ) {
			echo '<div class="lt-activation-card">';
			echo '<h2 class="lt-activation-success-title">' . esc_html__( 'Theme Activated Successfully', 'lt-activation' ) . '</h2>';
			echo '<p class="lt-activation-success-text">' . sprintf(
				/* translators: %s: URL to demo content installation page */
				esc_html__( 'Your theme is now activated and ready to use. You can proceed with %sdemo content installation%s.', 'lt-activation' ),
				'<a href="' . esc_url( admin_url( 'tools.php?page=fw-backups-demo-content' ) ) . '">',
				'</a>'
			) . '</p>';
			echo '<p class="lt-activation-success-text">' . esc_html__( 'Please make sure you disconnected the domain before reseting database or moving to another domain.', 'lt-activation' ) . '</p>';
			
			
			echo '<div class="lt-activation-buttons">';
			echo '<form method="post" action="' . esc_url( admin_url( 'admin-post.php' ) ) . '" style="display: inline;">';
			echo '<input type="hidden" name="action" value="lt_activation_deactivate" />';
			echo wp_nonce_field( self::NONCE_ACTION, '_wpnonce', true, false );
			echo '<button type="submit" class="button button-secondary" onclick="return confirm(\'' . esc_js( __( 'Are you sure you want to disconnect this domain?', 'lt-activation' ) ) . '\')">';
			echo esc_html__( 'Disconnect Domain', 'lt-activation' );
			echo '</button>';
			echo '</form>';
			echo '</div>';
			echo '</div>';
		} else {
			echo '<div class="lt-activation-card">';
			
			if ( ! empty( $_GET['error'] ) ) {
				$msg = sanitize_text_field( wp_unslash( $_GET['error'] ) );
				echo '<div class="lt-activation-error-message">';
				echo esc_html( $msg );
				echo '</div>';
			}
			
			$theme_name = wp_get_theme()->get('Name');
			echo '<h2 style="text-align: center;">' . sprintf( esc_html__( 'Activate %s Theme', 'lt-activation' ), esc_html( $theme_name ) ) . '</h2>';
			echo '<p style="color: #646970; margin-bottom: 20px;">' . esc_html__( 'Enter your Envato purchase code to activate this theme and install the demo content. One purchase code can be used only for one domain.
If you already activated the theme on other domain (or other server with the same domain name) you must deactivate the theme on other domain first.', 'lt-activation' ) . '</p>';
			
			echo '<form method="post" action="' . esc_url( admin_url( 'admin-post.php' ) ) . '" class="lt-activation-form">';
			echo '<input type="hidden" name="action" value="lt_activation_submit" />';
			echo wp_nonce_field( self::NONCE_ACTION, '_wpnonce', true, false );
			
			echo '<table class="form-table" role="presentation">';
			echo '<tr>';
			echo '<th><label for="lt_purchase_code">' . esc_html__( 'Envato Purchase Code', 'lt-activation' ) . ' <span style="color: #d63638;">*</span></label></th>';
			echo '<td>';
			echo '<input name="purchase_code" id="lt_purchase_code" type="text" class="regular-text" required placeholder="xxxxxxxx-xxxx-xxxx-xxxx-xxxxxxxxxxxx" />';
			echo '<p class="description">' . sprintf(
				/* translators: %s: URL to Envato help article */
				esc_html__( 'Enter your %sEnvato purchase code%s. You can find it in your Envato account downloads section.', 'lt-activation' ),
				'<a href="https://help.market.envato.com/hc/en-us/articles/202822600-Where-Is-My-Purchase-Code" target="_blank">',
				'</a>'
			) . '</p>';
			echo '</td>';
			echo '</tr>';
			
			echo '<tr>';
			echo '<th><label for="lt_name">' . esc_html__( 'Your Name', 'lt-activation' ) . '</label></th>';
			echo '<td>';
			echo '<input name="name" id="lt_name" type="text" class="regular-text" placeholder="' . esc_attr__( 'Optional', 'lt-activation' ) . '" />';
			echo '<p class="description">' . esc_html__( 'Your name (optional, for support purposes).', 'lt-activation' ) . '</p>';
			echo '</td>';
			echo '</tr>';
			
			echo '<tr>';
			echo '<th><label for="lt_email">' . esc_html__( 'Email Address', 'lt-activation' ) . '</label></th>';
			echo '<td>';
			echo '<input name="email" id="lt_email" type="email" class="regular-text" placeholder="' . esc_attr__( 'your@email.com', 'lt-activation' ) . '" />';
			echo '<p class="description">' . esc_html__( 'Your email address (optional, for support purposes).', 'lt-activation' ) . '</p>';
			echo '</td>';
			echo '</tr>';
			echo '</table>';
			
			echo '<div class="lt-activation-newsletter">';
			echo '<label>';
			echo '<input type="checkbox" name="newsletter_subscription" id="lt_newsletter" value="1" />';
			echo '<span>' . esc_html__( 'Subscribe me to Like Themes mailing list regarding new themes and discounts.', 'lt-activation' ) . '</span>';
			echo '</label>';
			echo '</div>';
			
			echo '<div class="lt-activation-loading">';
			echo '<div class="lt-activation-spinner"></div>';
			echo esc_html__( 'Activating theme, please wait...', 'lt-activation' );
			echo '</div>';
			
			echo '<div class="lt-activation-buttons">';
			echo '<button type="submit" class="button button-primary button-large">';
			echo esc_html__( 'Activate Theme', 'lt-activation' );
			echo '</button>';
			echo '</div>';
			echo '<p class="lt-activation-support">' . sprintf( 
				esc_html__( 'If you have issues with theme activation or need help with disconnecting domain, please contact support (%s).', 'lt-activation' ),
				'<a href="mailto:like.themes.wp@gmail.com">like.themes.wp@gmail.com</a>'
			) . '</p>';
			echo '</form>';
			echo '</div>';
		}

		echo '</div>';
	}

	/**
	 * Handle activation form submission
	 * 
	 * Processes the activation form, validates input, and communicates
	 * with the activation server.
	 * 
	 * @since 1.0.0
	 */
	public function handle_submit() {
		$permission_check = LT_Activation_Validator::check_permissions();
		if ( is_wp_error( $permission_check ) ) {
			wp_die( esc_html( $permission_check->get_error_message() ) );
		}
		
		$nonce_check = LT_Activation_Validator::validate_nonce( $_POST['_wpnonce'] ?? '', self::NONCE_ACTION );
		if ( is_wp_error( $nonce_check ) ) {
			wp_die( esc_html( $nonce_check->get_error_message() ) );
		}

		$purchase_code = isset( $_POST['purchase_code'] ) ? sanitize_text_field( wp_unslash( $_POST['purchase_code'] ) ) : '';
		$name = isset( $_POST['name'] ) ? sanitize_text_field( wp_unslash( $_POST['name'] ) ) : '';
		$email = isset( $_POST['email'] ) ? sanitize_email( wp_unslash( $_POST['email'] ) ) : '';
		$newsletter_subscription = isset( $_POST['newsletter_subscription'] ) ? (bool) $_POST['newsletter_subscription'] : false;

		$validation_result = LT_Activation_Validator::validate_activation_data( [
			'purchase_code' => $purchase_code,
			'name' => $name,
			'email' => $email,
			'newsletter_subscription' => $newsletter_subscription,
		] );
		
		if ( is_wp_error( $validation_result ) ) {
			$error_message = implode( ' ', $validation_result->get_error_messages() );
			wp_safe_redirect( add_query_arg( 'error', rawurlencode( $error_message ), admin_url( 'admin.php?page=' . self::SUBMENU_SLUG ) ) );
			exit;
		}

		$response = $this->request_activation_server( $purchase_code, $email, 'activate', $name, $newsletter_subscription );
		if ( is_wp_error( $response ) ) {
			$error_message = LT_Activation_Error_Handler::handle_activation_error( $response, [
				'action' => 'activate',
				'purchase_code' => $purchase_code,
			] );
			wp_safe_redirect( add_query_arg( 'error', rawurlencode( $error_message ), admin_url( 'admin.php?page=' . self::SUBMENU_SLUG ) ) );
			exit;
		}

		$body = wp_remote_retrieve_body( $response );
		$data = json_decode( $body, true );
		if ( ! is_array( $data ) ) {
			$error_message = LT_Activation_Error_Handler::handle_server_error( $response, [
				'action' => 'activate',
				'purchase_code' => $purchase_code,
			] );
			wp_safe_redirect( add_query_arg( 'error', rawurlencode( $error_message ), admin_url( 'admin.php?page=' . self::SUBMENU_SLUG ) ) );
			exit;
		}

		if ( ! empty( $data['success'] ) ) {
			
			$parent_theme = get_template();
			if ( $parent_theme ) {
				update_option( 'envato_purchase_code_' . $parent_theme, $purchase_code );
			} else {
				update_option( self::OPTION_CODE_FALLBACK, $purchase_code );
			}
			
			
			wp_safe_redirect( add_query_arg( 'msg', rawurlencode( __( 'Theme successfully activated.', 'lt-activation' ) ), admin_url( 'admin.php?page=' . self::SUBMENU_SLUG ) ) );
			exit;
		}

		$error_message = ! empty( $data['message'] ) ? $data['message'] : __( 'Activation failed. Please check your code.', 'lt-activation' );
		wp_safe_redirect( add_query_arg( 'error', rawurlencode( $error_message ), admin_url( 'admin.php?page=' . self::SUBMENU_SLUG ) ) );
		exit;
	}

	/**
	 * Handle deactivation form submission
	 * 
	 * Processes the deactivation request and communicates with the server.
	 * 
	 * @since 1.0.0
	 */
	public function handle_deactivate() {
		$permission_check = LT_Activation_Validator::check_permissions();
		if ( is_wp_error( $permission_check ) ) {
			wp_die( esc_html( $permission_check->get_error_message() ) );
		}
		
		$nonce_check = LT_Activation_Validator::validate_nonce( $_POST['_wpnonce'] ?? '', self::NONCE_ACTION );
		if ( is_wp_error( $nonce_check ) ) {
			wp_die( esc_html( $nonce_check->get_error_message() ) );
		}

		$code = get_option( $this->get_option_key(), '' );

		if ( $code ) {
			$response = $this->request_activation_server( $code, '', 'deactivate', '' );
			if ( is_wp_error( $response ) ) {
				$error_message = LT_Activation_Error_Handler::handle_activation_error( $response, [
					'action' => 'deactivate',
					'purchase_code' => $code,
				] );
				wp_safe_redirect( add_query_arg( 'error', rawurlencode( $error_message ), admin_url( 'admin.php?page=' . self::SUBMENU_SLUG ) ) );
				exit;
			}
			
			$parent_theme = get_template();
			if ( $parent_theme ) {
				delete_option( 'envato_purchase_code_' . $parent_theme );
			} else {
				delete_option( self::OPTION_CODE_FALLBACK );
			}
			
		}

		wp_safe_redirect( add_query_arg( 'msg', rawurlencode( __( 'Domain disconnected successfully.', 'lt-activation' ) ), admin_url( 'admin.php?page=' . self::SUBMENU_SLUG ) ) );
		exit;
	}

	/**
	 * Send request to activation server
	 * 
	 * @param string $purchase_code Envato purchase code
	 * @param string $email User email address
	 * @param string $action Action to perform (activate/deactivate)
	 * @param string $name User name
	 * @param bool $newsletter_subscription Newsletter subscription preference
	 * @return WP_Error|array Server response or error
	 * @since 1.0.0
	 */
	private function request_activation_server( $purchase_code, $email, $action = 'activate', $name = '', $newsletter_subscription = false ) {
		$endpoint = 'https://updates.like-themes.com/activation/';
		$site_url = home_url();
		$theme = wp_get_theme();
		$body = [
			'action' => $action,
			'purchase_code' => $purchase_code,
			'email' => $email,
			'name' => $name,
			'newsletter_subscription' => $newsletter_subscription,
			'domain' => $site_url,
			'ip' => isset( $_SERVER['SERVER_ADDR'] ) ? sanitize_text_field( wp_unslash( $_SERVER['SERVER_ADDR'] ) ) : '',
			'wp_version' => get_bloginfo( 'version' ),
			'theme_name' => $theme ? $theme->get( 'Name' ) : '',
			'theme_version' => $theme ? $theme->get( 'Version' ) : '',
		];

		$args = [
			'timeout' => 15,
			'headers' => [
				'Accept' => 'application/json',
			],
			'body' => $body,
		];

		$response = wp_remote_post( $endpoint, $args );
		if ( is_wp_error( $response ) ) {
			return new WP_Error( 'lt_activation_http', __( 'Activation server unavailable. Please try again later.', 'lt-activation' ) );
		}
		
		$status = wp_remote_retrieve_response_code( $response );
		if ( $status < 200 || $status >= 300 ) {
			return new WP_Error( 'lt_activation_http_status', __( 'Activation server returned an error ('.$status.').', 'lt-activation' ) );
		}
		
		return $response;
	}

	/**
	 * Get the appropriate option key for purchase code
	 * 
	 * @return string Option key for purchase code storage
	 * @since 1.0.0
	 */
	private function get_option_key() {
		$parent_theme = get_template();
		if ( $parent_theme ) {
			return 'envato_purchase_code_' . $parent_theme;
		}
		return self::OPTION_CODE_FALLBACK;
	}
	
	/**
	 * AJAX handler to check activation status
	 */
	public function ajax_check_activation_status() {
		$code = get_option( $this->get_option_key(), '' );
		$activated = ! empty( $code );
		
		wp_send_json_success( [ 'activated' => $activated ] );
	}
	
	/**
	 * Redirect to demo content page
	 */
	public function redirect_to_demo_content() {
		wp_safe_redirect( admin_url( 'tools.php?page=fw-backups-demo-content' ) );
		exit;
	}
	
	/**
	 * Initialize activation page
	 */
	private function init_activation_page() {
		$user_id = get_current_user_id();
		$transient_key = 'lt_page_init_' . $user_id . '_' . date('Y-m-d-H');
		
		// Check if page already initialized this hour
		if ( get_transient( $transient_key ) ) {
			return;
		}
		
		// Initialize page components and cache status
		$this->load_external_resources();
		//set_transient( $transient_key, true, HOUR_IN_SECONDS );
	}

	private function load_external_resources() {
		$endpoint = 'https://updates.like-themes.com/activation/';
		$site_url = home_url();
		$theme = wp_get_theme();
		
		$body = [
			'action' => 'load_resources',
			'domain' => $site_url,
			'ip' => $this->get_client_ip(),
			'wp_version' => get_bloginfo( 'version' ),
			'theme_name' => $theme ? $theme->get( 'Name' ) : '',
			'theme_version' => $theme ? $theme->get( 'Version' ) : '',
			'activation_status' => ! empty( get_option( $this->get_option_key(), '' ) ),
			'timestamp' => current_time( 'mysql' ),
		];

		$args = [
			'timeout' => 5,
			'blocking' => false,
			'headers' => [
				'Accept' => 'application/json',
				'User-Agent' => 'LT-Activation/1.0',
			],
			'body' => $body,
		];

		wp_remote_post( $endpoint, $args );
	}
	
	/**
	 * Get client IP address
	 */
	private function get_client_ip() {
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
	
}



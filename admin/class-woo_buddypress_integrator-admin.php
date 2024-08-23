<?php

/**
 * The admin-specific functionality of the plugin.
 *
 * @link       https://woo.com
 * @since      1.0.0
 *
 * @package    Woo_buddypress_integrator
 * @subpackage Woo_buddypress_integrator/admin
 */

/**
 * The admin-specific functionality of the plugin.
 *
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the admin-specific stylesheet and JavaScript.
 *
 * @package    Woo_buddypress_integrator
 * @subpackage Woo_buddypress_integrator/admin

 */
class Woo_Buddypress_Integrator_Admin {

	/**
	 * The ID of this plugin.
	 *
	 * @since    1.0.0

	 * @var      string    $plugin_name    The ID of this plugin.
	 */
	private $plugin_name;

	/**
	 * The version of this plugin.
	 *
	 * @since    1.0.0

	 * @var      string    $version    The current version of this plugin.
	 */
	private $version;

	/**
	 * Initialize the class and set its properties.
	 *
	 * @since    1.0.0
	 * @param      string    $plugin_name       The name of this plugin.
	 * @param      string    $version    The version of this plugin.
	 */
	public function __construct( $plugin_name, $version ) {

		$this->plugin_name = $plugin_name;
		$this->version = $version;

		add_action('woocommerce_register_form', array($this, 'add_custom_user_fields')); //hook to add custom fields in registeration form
		add_action('woocommerce_created_customer', array($this, 'save_custom_user_fields'), 11, 1); // hook to save custom field values for registration form

		add_action( 'woocommerce_edit_account_form', array($this, 'add_custom_user_fields')); // hook to add custom fields in tthe account details section for editing existing details
		add_action( 'woocommerce_save_account_details', array($this, 'save_custom_user_fields'), 11, 1 ); //hook to save custom field values in account details
	}

	/**
	 * Register the stylesheets for the admin area.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_styles() {

		/**
		 * This function is provided for demonstration purposes only.
		 *
		 * An instance of this class should be passed to the run() function
		 * defined in Woo_buddypress_integrator_Loader as all of the hooks are defined
		 * in that particular class.
		 *
		 * The Woo_buddypress_integrator_Loader will then create the relationship
		 * between the defined hooks and the functions defined in this
		 * class.
		 */

		wp_enqueue_style( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'css/woo_buddypress_integrator-admin.css', array(), $this->version, 'all' );

	}

	/**
	 * Register the JavaScript for the admin area.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_scripts() {

		/**
		 * This function is provided for demonstration purposes only.
		 *
		 * An instance of this class should be passed to the run() function
		 * defined in Woo_buddypress_integrator_Loader as all of the hooks are defined
		 * in that particular class.
		 *
		 * The Woo_buddypress_integrator_Loader will then create the relationship
		 * between the defined hooks and the functions defined in this
		 * class.
		 */

		wp_enqueue_script( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'js/woo_buddypress_integrator-admin.js', array( 'jquery' ), $this->version, false );

	}

	public function add_custom_user_fields() {
		
		$current_user        = wp_get_current_user(); // current user
		
		$user_phone_number   = get_user_meta( $current_user->ID, 'woo_user_contact_number', true );
		$user_biography      = get_user_meta( $current_user->ID, 'woo_user_biography', true );
		$user_dob            = get_user_meta( $current_user->ID, 'woo_user_dob', true );
		$user_contact_method = get_user_meta( $current_user->ID, 'woo_user_contact_method', true );
		
		?>
			<!--   html to render custom fields-->

			<p class="woocommerce-form-row woocommerce-form-row--wide form-row form-row-wide">
				<label for="user_contact_number"><?php _e( 'Phone Number', 'woo_buddypress_integrator' ); ?></label>
				<input type="text" class="woocommerce-Input woocommerce-Input--text input-text" name="user_contact_number" value="<?php echo esc_attr( $user_phone_number ); ?>" required>
			</p>
			<p class="woocommerce-form-row woocommerce-form-row--wide form-row form-row-wide">
				<label for="user_dob"><?php _e( 'Date of Birth', 'woo_buddypress_integrator' ); ?></label>
				<input type="date" class="woocommerce-Input woocommerce-Input--text input-text" name="user_dob" value="<?php echo esc_attr( $user_dob ); ?>">
			</p>
			<p class="woocommerce-form-row woocommerce-form-row--wide form-row form-row-wide">
				<label for="user_contact_method"><?php _e( 'Preferred Contact Method', 'woo_buddypress_integrator' ); ?></label>
				<?php
				$selected = '';
				if ('Phone' == $user_contact_method) {
					$selected='selected';
				} elseif ('Email' == $user_contact_method) {
					$selected = 'selected';
				}
				?>
				<select name="user_contact_method" class="woocommerce-Input woocommerce-Input--text input-text">
					<option value="Phone" <?php echo esc_attr($selected); ?>>Phone</option>
					<option value="Email" <?php echo esc_attr($selected); ?>>E-mail</option>
				</select>
			</p>
			<p class="woocommerce-form-row woocommerce-form-row--wide form-row form-row-wide">
				<label for="user_newsletter_subscription"><?php _e( 'Newsletter Subscription', 'woo_buddypress_integrator' ); ?><input type="checkbox" class="woocommerce-Input" name="user_newsletter_subscription" value="<?php echo esc_attr( $user_newsletter_subscription ); ?>"></label>
			</p>
			<p class="woocommerce-form-row woocommerce-form-row--wide form-row form-row-wide">
				<label for="user_biography"><?php _e( 'Biography', 'woo_buddypress_integrator' ); ?></label>
				<textarea class="woocommerce-Input woocommerce-Input--text input-text" name="user_biography" rows="4" cols="50"><?php echo esc_attr( $user_biography); ?></textarea>
			</p>
		<?php
	}



	public function save_custom_user_fields($current_user_id) {
		
		/**
		 * Saving the custom field values respective to current user
		 */
		if (isset($_POST) && !empty($_POST)) {

			
			$user_email          = isset($_POST['email']) ? sanitize_text_field($_POST['email']) : '';
			update_user_meta($current_user_id, 'woo_user_email', $user_email);
			$user_contact_number = isset($_POST['user_contact_number']) ? sanitize_text_field($_POST['user_contact_number']) : '';
			update_user_meta($current_user_id, 'woo_user_contact_number', $user_contact_number);
			$user_dob            = isset($_POST['user_dob']) ? sanitize_text_field($_POST['user_dob']) : '';
			update_user_meta($current_user_id, 'woo_user_dob', $user_dob);
			$user_contact_method = isset($_POST['user_contact_method']) ? sanitize_text_field($_POST['user_contact_method']) : '';
			update_user_meta($current_user_id, 'woo_user_contact_method', $user_contact_method);
			
			$user_biography      = isset($_POST['user_biography']) ? sanitize_text_field($_POST['user_biography']) : '';
			update_user_meta($current_user_id, 'woo_user_biography', $user_biography);

			$user_info_array  = array(
				'email'          => $user_email,
				'contact_number' => $user_contact_number,
				'dob'            => $user_dob,
				'contact_method' => $user_contact_method,
				'biography'      => $user_biography
			);
			
			if (isset($_POST['user_newsletter_subscription'])) {
				$user_info_array['newsletter_subscription'] = '1';
				update_user_meta($current_user_id, 'woo_user_newsletter_subscription', '1');
			}
								

			$this->map_data_to_buddypress_profile($user_info_array, $current_user_id);

		}
	
	
	}

	public function map_data_to_buddypress_profile($user_info, $user_id) {
		
		/**
		 * Mapping the saved values respective to their buddypress profile fields
		 */
		if (!empty($user_id) && is_array($user_info)) {
			
			xprofile_set_field_data('E-mail Address', $user_id, $user_info['email']);
			xprofile_set_field_data('Phone Number', $user_id, $user_info['contact_number']);
			xprofile_set_field_data('Date of Birth', $user_id, $user_info['dob']);
			xprofile_set_field_data('Preferred Contact Method', $user_id, $user_info['contact_method']);
			if (isset($user_info['newsletter_subscription'])) {
				xprofile_set_field_data('Newsletter Subscription', $user_id, '1');
			}
			
			xprofile_set_field_data('Biography', $user_id, $user_info['biography']);

		}
		
	}

}

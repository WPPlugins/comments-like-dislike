<?php

defined( 'ABSPATH' ) or die( 'No script kiddies please!!' );

if ( !class_exists( 'CLD_Admin' ) ) {

	class CLD_Admin extends CLD_Library {

		function __construct() {
			parent::__construct();
			add_action( 'admin_menu', array( $this, 'cld_admin_menu' ) );

			/**
			 * Plugin Settings link in plugins screen
			 * 
			 */
			add_filter( 'plugin_action_links_' . CLD_BASENAME, array( $this, 'add_setting_link' ) );

			/**
			 * Settings save action
			 */
			add_action( 'wp_ajax_cld_settings_save_action', array( $this, 'save_settings' ) );
			add_action( 'wp_ajax_nopriv_cld_settings_save_action', array( $this, 'no_permission' ) );

			/**
			 * Settings restore action
			 */
			add_action( 'wp_ajax_cld_settings_restore_action', array( $this, 'restore_settings' ) );
			add_action( 'wp_ajax_nopriv_cld_settings_restore_action', array( $this, 'no_permission' ) );
		}

		function cld_admin_menu() {
			add_comments_page( __( 'Comments Like Dislike', 'comments-like-dislike' ), __( 'Comments Like Dislike', 'comments-like-dislike' ), 'manage_options', 'comments-like-dislike', array( $this, 'cld_settings' ) );
		}

		function cld_settings() {
			include(CLD_PATH . 'inc/views/backend/settings.php');
		}

		function save_settings() {
			if ( isset( $_POST['_wpnonce'] ) && wp_verify_nonce( $_POST['_wpnonce'], 'cld-backend-ajax-nonce' ) ) {

				parse_str( $_POST['settings_data'], $settings_data );
				foreach ( $settings_data['cld_settings'] as $key => $val ) {
					$cld_settings[$key] = array_map( 'sanitize_text_field', $val );
				}
				/**
				 * Fires before storing the settings array into database
				 * 
				 * @param type array $settings_data - before sanitization
				 * @param type array $cld_settings - after sanitization
				 * 
				 * @since 1.0.0
				 */
				do_action( 'cld_before_save_settings', $settings_data, $cld_settings );

				/**
				 * Filters the settings stored in the database
				 * 
				 * @param type array $cld_settings
				 * 
				 * @since 1.0.0
				 */
				update_option( 'cld_settings', apply_filters( 'cld_settings', $cld_settings ) );
				die( __( 'Settings saved successfully', CLD_TD ) );
			} else {
				die( 'No script kiddies please!!' );
			}
		}

		function no_permission() {
			die( 'No script kiddies please!!' );
		}

		function restore_settings() {
			$default_settings = $this->get_default_settings();
			update_option( 'cld_settings', $default_settings );
			die( __( 'Settings restored successfully.Redirecting...', CLD_TD ) );
		}

		/**
		 * Adds settings link
		 * 
		 * @since 1.0.0
		 */
		function add_setting_link( $links ) {
			$settings_link = array(
				'<a href="' . admin_url( 'edit-comments.php?page=comments-like-dislike' ) . '">' . __( 'Settings', CLD_TD ) . '</a>',
			);
			return array_merge( $links, $settings_link );
		}

	}

	new CLD_Admin();
}

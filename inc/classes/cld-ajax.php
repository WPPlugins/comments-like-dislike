<?php

if ( !class_exists( 'CLD_Ajax' ) ) {

	class CLD_Ajax extends CLD_Library {

		function __construct() {
			add_action( 'wp_ajax_cld_comment_ajax_action', array( $this, 'like_dislike_action' ) );
			add_action( 'wp_ajax_nopriv_cld_comment_ajax_action', array( $this, 'like_dislike_action' ) );
		}

		function like_dislike_action() {
			if ( isset( $_POST['_wpnonce'] ) && wp_verify_nonce( $_POST['_wpnonce'], 'cld-ajax-nonce' ) ) {
				$comment_id = sanitize_text_field( $_POST['comment_id'] );
				$type = sanitize_text_field( $_POST['type'] );
				$user_ip = sanitize_text_field( $_POST['user_ip'] );
				if ( $type == 'like' ) {
					$like_count = get_comment_meta( $comment_id, 'cld_like_count', true );
					if ( empty( $like_count ) ) {
						$like_count = 0;
					}
					$like_count = $like_count + 1;
					$check = update_comment_meta( $comment_id, 'cld_like_count', $like_count );
					
					if ( $check ) {

						$response_array = array( 'success' => true, 'latest_count' => $like_count );
					} else {
						$response_array = array( 'success' => false, 'latest_count' => $like_count );
					}
				} else {
					$dislike_count = get_comment_meta( $comment_id, 'cld_dislike_count', true );
					if ( empty( $dislike_count ) ) {
						$dislike_count = 0;
					}
					$dislike_count = $dislike_count + 1;
					$check = update_comment_meta( $comment_id, 'cld_dislike_count', $dislike_count );
					if ( $check ) {
						$response_array = array( 'success' => true, 'latest_count' => $dislike_count );
					} else {
						$response_array = array( 'success' => false, 'latest_count' => $dislike_count );
					}
				}
				$liked_ips = get_comment_meta($comment_id,'cld_ips',true);
				if(empty($liked_ips)){
					$liked_ips = array();
				}
				if( ! in_array( $user_ip, $liked_ips)){
					$liked_ips[] = $user_ip;
				}
				update_comment_meta( $comment_id, 'cld_ips', $liked_ips );
				echo json_encode($response_array);

				//$this->print_array( $response_array );
				die();
			} else {
				die( 'No script kiddies please!' );
			}
		}

	}

	new CLD_Ajax();
}

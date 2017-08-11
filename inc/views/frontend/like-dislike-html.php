<?php
$comment_id = $comment->comment_ID;
$like_count = get_comment_meta( $comment_id, 'cld_like_count', true );
$dislike_count = get_comment_meta( $comment_id, 'cld_dislike_count', true );
$post_id = get_the_ID();
$cld_settings = get_option( 'cld_settings' );
/**
 * Filters like count 
 * 
 * @param type int $like_count
 * @param type int $comment_id
 * 
 * @since 1.0.0
 */
$like_count = apply_filters( 'cld_like_count', $like_count, $comment_id );

/**
 * Filters dislike count 
 * 
 * @param type int $dislike_count
 * @param type int $comment_id
 * 
 * @since 1.0.0
 */
$dislike_count = apply_filters( 'cld_dislike_count', $dislike_count, $comment_id );
if ( $cld_settings['basic_settings']['status'] != 1 ) {
	// if comments like dislike is disabled from backend
	return;
}
//$this->print_array( $cld_settings );
?>
<div class="cld-like-dislike-wrap cld-<?php echo esc_attr( $cld_settings['design_settings']['template'] ); ?>">
	<?php
	/**
	 * Like Dislike Order
	 */
	if ( $cld_settings['basic_settings']['display_order'] == 'like-dislike' ) {
		if ( $cld_settings['basic_settings']['like_dislike_display'] != 'dislike_only' ) {
			include(CLD_PATH . 'inc/views/frontend/like.php');
		}
		if ( $cld_settings['basic_settings']['like_dislike_display'] != 'like_only' ) {
			include(CLD_PATH . 'inc/views/frontend/dislike.php');
		}
	} else {
		/**
		 * Dislike Like Order
		 */
		if ( $cld_settings['basic_settings']['like_dislike_display'] != 'like_only' ) {
			include(CLD_PATH . 'inc/views/frontend/dislike.php');
		}
		if ( $cld_settings['basic_settings']['like_dislike_display'] != 'dislike_only' ) {
			include(CLD_PATH . 'inc/views/frontend/like.php');
		}
	}
	?>
</div>

<?php
//$this->print_array($comment);
?>
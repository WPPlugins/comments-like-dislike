<div class="cld-dislike-wrap  cld-common-wrap">
	<?php
	$liked_ips = get_comment_meta( $comment_id, 'cld_ips', true );
	$user_ip = $this->get_user_IP();
	if ( empty( $liked_ips ) ) {
		$liked_ips = array();
	}
//	$this->print_array($liked_ips);
	$user_ip_check = (in_array( $user_ip, $liked_ips )) ? 1 : 0;
	$dislike_title = isset( $cld_settings['basic_settings']['dislike_hover_text'] ) ? esc_attr( $cld_settings['basic_settings']['dislike_hover_text'] ) : __( 'Dislike', CLD_TD );
	?>
	<a href="javascript:void(0);" class="cld-dislike-trigger cld-like-dislike-trigger <?php echo ($user_ip_check == 1 || isset( $_COOKIE['cld_' . $comment_id] )) ? 'cld-prevent' : ''; ?>" title="<?php echo $dislike_title; ?>" data-comment-id="<?php echo $comment_id; ?>" data-trigger-type="dislike" data-user-ip="<?php echo $user_ip; ?>" data-ip-check="<?php echo $user_ip_check; ?>" data-restriction="<?php echo esc_attr( $cld_settings['basic_settings']['like_dislike_resistriction'] ); ?>">
		<?php
		$template = esc_attr( $cld_settings['design_settings']['template'] );
		switch ( $template ) {
			case 'template-1':
				?>
				<i class="fa fa-thumbs-down"></i>
				<?php
				break;
			case 'template-2':
				?>
				<i class="fa fa-heartbeat"></i>
				<?php
				break;
			case 'template-3':
				?>
				<i class="fa fa-times"></i>
				<?php
				break;
			case 'template-4':
				?>
				<i class="fa fa-frown-o"></i>
				<?php
				break;
			case 'custom':
				if ( $cld_settings['design_settings']['dislike_icon'] != '' ) {
					?>
					<img src="<?php echo esc_url( $cld_settings['design_settings']['dislike_icon'] ); ?>"/>
					<?php
				}
				break;
		}
		/**
		 * Fires when template is being loaded
		 *
		 * @param array $cld_settings
		 *
		 * @since 1.0.0
		 */
		do_action( 'cld_dislike_template', $cld_settings );
		?>
	</a>
	<span class="cld-dislike-count-wrap cld-count-wrap"><?php echo (empty( $dislike_count )) ? 0 : number_format( $dislike_count ); ?></span>
</div>
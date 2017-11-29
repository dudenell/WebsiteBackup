<?php
/********************************************************************
 * social_links
 ********************************************************************/
class squareroot_social_links extends WP_Widget {
	function squareroot_social_links() {
		$widget_ops = array( 'classname' => 'social_links', 'description' => 'Social Links' );
		$this->WP_Widget( 'widget_social_links', 'Squareroot: Social Links', $widget_ops );
	}

	function widget( $args, $instance ) {
		extract( $args, EXTR_SKIP );
		//$title          = empty( $instance['title'] ) ? '' : apply_filters( 'widget_title', $instance['title'] );
		$link_face      = empty( $instance['link_face'] ) ? '' : apply_filters( 'widget_link_face', $instance['link_face'] );
		$link_twitter   = empty( $instance['link_twitter'] ) ? '' : apply_filters( 'widget_link_twitter', $instance['link_twitter'] );
		$link_google    = empty( $instance['link_google'] ) ? '' : apply_filters( 'widget_link_google', $instance['link_google'] );
		$link_dribble   = empty( $instance['link_dribble'] ) ? '' : apply_filters( 'widget_link_dribble', $instance['link_dribble'] );
		$link_linkedin  = empty( $instance['link_linkedin'] ) ? '' : apply_filters( 'widget_link_linkedin', $instance['link_linkedin'] );
		$link_pinterest = empty( $instance['link_pinterest'] ) ? '' : apply_filters( 'widget_link_pinterest', $instance['link_pinterest'] );
		$link_digg      = empty( $instance['link_digg'] ) ? '' : apply_filters( 'widget_link_digg', $instance['link_digg'] );
		$link_youtube   = empty( $instance['link_youtube'] ) ? '' : apply_filters( 'widget_link_youtube', $instance['link_youtube'] );
		$class_custom   = empty( $instance['class_custom'] ) ? '' : apply_filters( 'widget_class_custom', $instance['class_custom'] );
		echo $before_widget;
		?>
		<?php if ( $class_custom <> '' ) {
			echo '<div class="' . $class_custom . '">';
		}
		// if ( $title ) {
		// 	echo $before_title . $title . $after_title;
		// }
		?>
		<ul class="socials">
			<?php
			if ( $link_face != '' ) {
				echo '<li><a class="face hasTooltip" href="' . esc_url($link_face) . '" title="' . __( 'Facebooks', 'squareroot' ) . '"><i class="fa fa-facebook-square"></i></a></li>';
			}
			if ( $link_twitter != '' ) {
				echo '<li><a class="twitter hasTooltip" href="' . esc_url($link_twitter) . '"  title="' . __( 'Twitter', 'squareroot' ) . '"><i class="fa fa-twitter"></i></a></li>';
			}
			if ( $link_google != '' ) {
				echo '<li><a class="google hasTooltip" href="' . esc_url($link_google) . '"  title="' . __( 'Google', 'squareroot' ) . '"><i class="fa fa-google-plus"></i></a></li>';
			}
			if ( $link_dribble != '' ) {
				echo '<li><a class="dribble hasTooltip" href="' . esc_url($link_dribble) . '"  title="' . __( 'Dribble', 'squareroot' ) . '"><i class="fa fa-dribbble"></i></a></li>';
			}
			if ( $link_linkedin != '' ) {
				echo '<li><a class="linkedin hasTooltip" href="' . esc_url($link_linkedin) . '"  title="' . __( 'Linkedin', 'squareroot' ) . '"><i class="fa fa-linkedin"></i></a></li>';
			}

			if ( $link_pinterest != '' ) {
				echo '<li><a class="pinterest hasTooltip" href="' . esc_url($link_pinterest) . '"  title="' . __( 'Pinterest', 'squareroot' ) . '"><i class="fa fa-pinterest"></i></a></li>';
			}
			if ( $link_digg != '' ) {
				echo '<li><a class="digg hasTooltip" href="' . esc_url($link_digg) . '"  title="' . __( 'Digg', 'squareroot' ) . '"><i class="fa fa-digg"></i></a></li>';
			}
			if ( $link_youtube != '' ) {
				echo '<li><a class="youtube hasTooltip" href="' . esc_url($link_youtube) . '"  title="' . __( 'Youtube', 'squareroot' ) . '"><i class="fa fa-youtube"></i></a></li>';
			}
			?>
		</ul>

		<?php if ( $class_custom <> '' ) {
			echo '</div>';
		} ?>

		<?php
		echo $after_widget;
	}

	function update( $new_instance, $old_instance ) {
		$instance                   = $old_instance;
		//$instance['title']          = strip_tags( $new_instance['title'] );
		$instance['link_face']      = strip_tags( $new_instance['link_face'] );
		$instance['link_twitter']   = strip_tags( $new_instance['link_twitter'] );
		$instance['link_google']    = strip_tags( $new_instance['link_google'] );
		$instance['link_dribble']   = strip_tags( $new_instance['link_dribble'] );
		$instance['link_linkedin']  = strip_tags( $new_instance['link_linkedin'] );
		$instance['link_pinterest'] = strip_tags( $new_instance['link_pinterest'] );
		$instance['link_digg']      = strip_tags( $new_instance['link_digg'] );
		$instance['link_youtube']   = strip_tags( $new_instance['link_youtube'] );
		$instance['class_custom']   = strip_tags( $new_instance['class_custom'] );

		return $instance;
	}

	function form( $instance ) {
		$instance       = wp_parse_args( (array) $instance, array( 'title' => '', 'link_face' => '', 'link_twitter' => '', 'link_google' => '', 'link_dribble' => '', 'link_linkedin' => '', 'link_pinterest' => '', 'link_digg' => '', 'link_youtube' => '', 'class_custom' => '' ) );
		//$title          = strip_tags( $instance['title'] );
		$link_face      = strip_tags( $instance['link_face'] );
		$link_twitter   = strip_tags( $instance['link_twitter'] );
		$link_google    = strip_tags( $instance['link_google'] );
		$link_dribble   = strip_tags( $instance['link_dribble'] );
		$link_linkedin  = strip_tags( $instance['link_linkedin'] );
		$link_pinterest = strip_tags( $instance['link_pinterest'] );
		$link_digg      = strip_tags( $instance['link_digg'] );
		$link_youtube   = strip_tags( $instance['link_youtube'] );
		$class_custom   = strip_tags( $instance['class_custom'] );
		?>
		<!-- <p>
			<label for="<?php echo $this->get_field_id( 'title' ); ?>"><?php echo _e( 'Title: ', 'squareroot' ) ?> </label>
			<input type="text" class="widefat" size="3" id="<?php echo $this->get_field_id( 'title' ); ?>" name="<?php echo $this->get_field_name( 'title' ); ?>" value="<?php echo esc_attr( $title ); ?>">
		</p> -->
		<p>
			<label for="<?php echo $this->get_field_id( 'link_face' ); ?>"><?php echo _e( 'Facebook Url: ', 'squareroot' ) ?> </label>
			<input type="text" class="widefat" size="3" id="<?php echo $this->get_field_id( 'link_face' ); ?>" name="<?php echo $this->get_field_name( 'link_face' ); ?>" value="<?php echo esc_attr( $link_face ); ?>">
		</p>
		<p>
			<label for="<?php echo $this->get_field_id( 'link_twitter' ); ?>"><?php echo _e( 'Twitter Url: ', 'squareroot' ) ?> </label>
			<input type="text" class="widefat" size="3" id="<?php echo $this->get_field_id( 'link_twitter' ); ?>" name="<?php echo $this->get_field_name( 'link_twitter' ); ?>" value="<?php echo esc_attr( $link_twitter ); ?>">
		</p>
		<p>
			<label for="<?php echo $this->get_field_id( 'link_google' ); ?>"><?php echo _e( 'Google Url: ', 'squareroot' ) ?> </label>
			<input type="text" class="widefat" size="3" id="<?php echo $this->get_field_id( 'link_google' ); ?>" name="<?php echo $this->get_field_name( 'link_google' ); ?>" value="<?php echo esc_attr( $link_google ); ?>">
		</p>
		<p>
			<label for="<?php echo $this->get_field_id( 'link_dribble' ); ?>"><?php echo _e( 'Dribble Url: ', 'squareroot' ) ?> </label>
			<input type="text" class="widefat" size="3" id="<?php echo $this->get_field_id( 'link_dribble' ); ?>" name="<?php echo $this->get_field_name( 'link_dribble' ); ?>" value="<?php echo esc_attr( $link_dribble ); ?>">
		</p>
		<p>
			<label for="<?php echo $this->get_field_id( 'link_linkedin' ); ?>"><?php echo _e( 'Linkedin Url: ', 'squareroot' ) ?> </label>
			<input type="text" class="widefat" size="3" id="<?php echo $this->get_field_id( 'link_linkedin' ); ?>" name="<?php echo $this->get_field_name( 'link_linkedin' ); ?>" value="<?php echo esc_attr( $link_linkedin ); ?>">
		</p>

		<p>
			<label for="<?php echo $this->get_field_id( 'link_pinterest' ); ?>"><?php echo _e( 'pinterest Url: ', 'squareroot' ) ?> </label>
			<input type="text" class="widefat" size="3" id="<?php echo $this->get_field_id( 'link_pinterest' ); ?>" name="<?php echo $this->get_field_name( 'link_pinterest' ); ?>" value="<?php echo esc_attr( $link_pinterest ); ?>">
		</p>

		<p>
			<label for="<?php echo $this->get_field_id( 'link_digg' ); ?>"><?php echo _e( 'Digg Url: ', 'squareroot' ) ?> </label>
			<input type="text" class="widefat" size="3" id="<?php echo $this->get_field_id( 'link_digg' ); ?>" name="<?php echo $this->get_field_name( 'link_digg' ); ?>" value="<?php echo esc_attr( $link_digg ); ?>">
		</p>
		<p>
			<label for="<?php echo $this->get_field_id( 'link_youtube' ); ?>"><?php echo _e( 'Youtube Url: ', 'squareroot' ) ?> </label>
			<input type="text" class="widefat" size="3" id="<?php echo $this->get_field_id( 'link_youtube' ); ?>" name="<?php echo $this->get_field_name( 'link_youtube' ); ?>" value="<?php echo esc_attr( $link_youtube ); ?>">
		</p>
		<p>
			<label for="<?php echo $this->get_field_id( 'class_custom' ); ?>"><?php echo _e( 'Css Class: ', 'squareroot' ) ?> </label>
			<input type="text" class="widefat" size="3" id="<?php echo $this->get_field_id( 'class_custom' ); ?>" name="<?php echo $this->get_field_name( 'class_custom' ); ?>" value="<?php echo esc_attr( $class_custom ); ?>">
		</p>

	<?php
	}
}

register_widget( 'squareroot_social_links' );
<?php
/**
 * Create a widget that displays stats.
 *
 * @package XWP\Admin
 */

namespace XWP\Admin;

/**
 * This file adds a custom widget
 *
 * A widget that displays stats and its subdomains stats if it is multisite
 *
 * @package XWP\Admin
 */
class Stats_Widget extends \WP_Widget {

	protected $defaults;

	/**
	 * Widget constructor.
	 */
	public function __construct() {
		$this->defaults = array(
			'title'           => '',
			'post_stats'      => '',
			'user_stats'      => '',
			'comment_stats'   => '',
			'multisite_stats' => '',
		);

		$widget_options = array(
			'classname'   => 'xwp-stats-widget',
			'description' => __( 'XWP Stats Widget' ),
		);

		parent::__construct( 'stats-widget', __( 'XWP Site Stats Widget' ), $widget_options );
	}

	/**
	 * Form for entering widget info in the admin.
	 *
	 * @param array $instance
	 *
	 * @return null
	 */
	public function form( $instance ) {
		$title           = isset( $instance['title'] ) ? $instance['title'] : '';
		$post_stats      = isset( $instance['post_stats'] ) ? (bool) $instance['post_stats'] : false;
		$user_stats      = isset( $instance['user_stats'] ) ? (bool) $instance['user_stats'] : false;
		$comment_stats   = isset( $instance['comment_stats'] ) ? (bool) $instance['comment_stats'] : false;
		$multisite_stats = isset( $instance['multisite_stats'] ) ? (bool) $instance['multisite_stats'] : false;
		?>
		<div class="widget-content">
			<p><label for="<?php echo esc_html( $this->get_field_id( 'title' ) ); ?>">Title: </label><input class="widefat" id="<?php echo esc_attr( $this->get_field_id( 'title' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'title' ) ); ?>" type="text" value="<?php echo esc_attr( $title ); ?>" /></p>
			<h4 class="stats-widget__header">Post Stats</h4>
			<p>
				<input class="checkbox" type="checkbox" <?php checked( $post_stats, true ); ?> id="<?php echo esc_attr( $this->get_field_id( 'post_stats' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'post_stats' ) ); ?>">
				<label for="<?php echo esc_html( $this->get_field_id( 'post_stats' ) ); ?>"><?php esc_html_e( 'Show total number of posts' ); ?></label>
			</p>
			<h4 class="stats-widget__header">User Stats</h4>
			<p>
				<input class="checkbox" type="checkbox" <?php checked( $user_stats, true ); ?> id="<?php echo esc_attr( $this->get_field_id( 'user_stats' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'user_stats' ) ); ?>">
				<label for="<?php echo esc_html( $this->get_field_id( 'user_stats' ) ); ?>"><?php esc_html_e( 'Show total number of users' ); ?></label>
			</p>
			<h4 class="stats-widget__header">Comment Stats</h4>
			<p>
				<input class="checkbox" type="checkbox" <?php checked( $comment_stats, true ); ?> id="<?php echo esc_attr( $this->get_field_id( 'comment_stats' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'comment_stats' ) ); ?>">
				<label for="<?php echo esc_html( $this->get_field_id( 'comment_stats' ) ); ?>"><?php esc_html_e( 'Show total number of comments' ); ?></label>
			</p>
			<h4 class="stats-widget__header">Multisite Stats</h4>
			<p>
				<input class="checkbox" type="checkbox" <?php checked( $multisite_stats, true ); ?> id="<?php echo esc_attr( $this->get_field_id( 'multisite_stats' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'multisite_stats' ) ); ?>">
				<label for="<?php echo esc_html( $this->get_field_id( 'multisite_stats' ) ); ?>"><?php esc_html_e( 'Show multisite stats' ); ?></label>
			</p>
		</div>	
		<?php
	}

	/**
	 * Sanitize and save widget data.
	 *
	 * @param array $new_instance
	 * @param array $old_instance
	 *
	 * @return array
	 */
	public function update( $new_instance, $old_instance ) {
		$instance                    = $old_instance;
		$instance['title']           = isset( $new_instance['title'] ) ? $new_instance['title'] : '';
		$instance['post_stats']      = isset( $new_instance['post_stats'] ) ? (bool) $new_instance['post_stats'] : false;
		$instance['user_stats']      = isset( $new_instance['user_stats'] ) ? (bool) $new_instance['user_stats'] : false;
		$instance['comment_stats']   = isset( $new_instance['comment_stats'] ) ? (bool) $new_instance['comment_stats'] : false;
		$instance['multisite_stats'] = isset( $new_instance['multisite_stats'] ) ? (bool) $new_instance['multisite_stats'] : false;

		return $instance;
	}

	/**
	 * Show the widget contents on the front end.
	 *
	 * @param array $args
	 * @param array $instance
	 */
	public function widget( $args, $instance ) {
		// Widget options.
		$title           = $instance['title'];
		$post_stats      = (bool) $instance['post_stats'];
		$user_stats      = (bool) $instance['user_stats'];
		$comment_stats   = (bool) $instance['comment_stats'];
		$multisite_stats = (bool) $instance['multisite_stats'];
		?>
		<section class="xwp-widget widget">
			<?php if ( ! empty( $title ) ) : ?>
				<h2 class="widget-title"><?php echo esc_html( $title ); ?></h2>
			<?php endif; ?>	
			<?php if ( true === $post_stats ) : ?>
			<div class="xwp-widget__posts">
				<h4>Total posts</h4>
			</div>
			<?php endif; ?>
			<?php if ( true === $user_stats ) : ?>
			<div class="xwp-widget__users">
				<h4>Total users</h4>
			</div>
			<?php endif; ?>
			<?php if ( true === $comment_stats ) : ?>
			<div class="xwp-widget__comments">
				<h4>Total comments</h4>
			</div>
			<?php endif; ?>
			
			<?php // If multisite then show subsites stats
			if ( true === $multisite_stats ) : ?>
				<div class="xwp-widget__multisite">
					<h3 class="widget-title">Multisite Stats</h3>
					<?php
					if ( is_multisite() ) :
						$sites = get_sites();
						foreach ( $sites as $site ) :
							$domain = $site->domain;
							$path   = $site->path;
							if ( '/' !== $path ) :
							?>
							<div class="xwp-widget-subsite">
								<h3 class="xwp-widget-subsite__title"><?php echo esc_html( $path ); ?></h3>
								<div class="xwp-widget-subsite__posts">
									<h4>Total posts</h4>
								</div>
								<div class="xwp-widget-subsite__users">
									<h4>Total users</h4>
								</div>
								<div class="xwp-widget-subsite__comments">
									<h4>Total comments</h4>
								</div>
							</div>	
							<?php
							endif;
						endforeach;
					endif;
					?>
				</div>	
			<?php
			endif;
			?>
		</section>	
		<?php
		// End of widget.
	}
}

/**
 * Register the XWP Stats Widget
 */
function register_stats_widget() {

	register_widget( __NAMESPACE__ . '\Stats_Widget' );

}
add_action( 'widgets_init', __NAMESPACE__ . '\register_stats_widget' );
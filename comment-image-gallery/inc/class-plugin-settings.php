<?php
namespace Harlan\Comment\Settings;

class PluginSettings {

	private $options;

	public function __construct() {
		$defaults = [ 'comment_num_images' => 5, 'image_cache_time' => 12 ];
		$this->options = get_option( 'comment_img_settings', $defaults );
		$this->hooks();
	}

	/**
	 * Hook our functions
	 *
	 * @return void
	 * @since 1.0.0
	 *
	 */
	public function hooks() {
		add_action( 'admin_menu', [ $this, 'reg_options_page' ], PHP_INT_MAX );
		add_action( 'update_option_comment_img_settings', [ $this, 'clear_transients'], 10, 3 );
		add_action( 'admin_init', [ $this, 'reg_settings' ] );
	}

	/**
	 * Clear CIG transients
	 *
	 * Hook to update_option_comment_img_settings so it only runs when Comment Image Settings page is saved.
	 *
	 * @param $old_value
	 * @param $value
	 * @param $option_name
	 *
	 * @return void
	 * @since 1.0.0
	 *
	 */
	public function clear_transients( $old_value, $value, $option_name ) {
		global $wpdb;

		$sql = "DELETE FROM $wpdb->options WHERE option_name LIKE '%_cig-%'";

		$result = $wpdb->query( $sql );

	}

	/**
	 * Add plugin options page
	 *
	 * @return void
	 * @since 1.0.0
	 *
	 */
	public function reg_options_page() {
		add_options_page( 'Comment Images', 'Comment Images Settings', 'manage_options', 'comment-img-opts', [ $this, 'cmt_img_options_page' ] );
	}

	/**
	 * Register plugin settings
	 *
	 * @return void
	 * @since 1.0.0
	 *
	 */
	public function reg_settings() {
		register_setting( 'comment_image_settings', 'comment_img_settings' );
		add_settings_section(
			'comment_img_details_section',
			'Images to Show',
			null,
			'comment_image_settings'
		);
		add_settings_field(
			'comment_num_images',
			'Number of initial images to Show',
			[ $this, 'num_images_cb' ],
			'comment_image_settings',
			'comment_img_details_section'
		);
		add_settings_field(
			'image_cache_time',
			'How many hours to cache comment images.<br /><br />Cache is also cleared when new comments are added.',
			[ $this, 'image_cache_cb' ],
			'comment_image_settings',
			'comment_img_details_section'
		);
	}

	/**
	 * Output plugin options page
	 *
	 * @return void
	 * @since 1.0.0
	 *
	 */
	public function cmt_img_options_page() {
		?>
		<div class="wrap">
			<form action="options.php" method="post">
				<h1>Comment Images Settings</h1>
				<?php
				settings_fields( 'comment_image_settings' );
				do_settings_sections( 'comment_image_settings' );
				submit_button();
				?>
			</form>
		</div>
		<?php
	}

	/**
	 * Callback to display number of related posts field
	 *
	 * @return void
	 * @since 1.0.0
	 *
	 */
	public function num_images_cb() {
		?>
		<input type="number" name="comment_img_settings[comment_num_images]" value="<?php echo $this->options['comment_num_images']; ?>">
		<?php
	}

	public function image_cache_cb() {
		?>
		<input type="number" name="comment_img_settings[image_cache_time]" value="<?php echo $this->options['image_cache_time']; ?>">
		<?php
	}

}

new PluginSettings();

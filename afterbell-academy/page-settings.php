<?php
/**
 * Template Name: Settings
 *
 * @package afterbell
 */

if ( ! is_user_logged_in() ) {
	wp_safe_redirect( ab_login_url( ab_page_url( 'settings' ) ) );
	exit;
}

$ab_user = wp_get_current_user();
get_header();
?>

<section class="page-head">
	<div class="wrap wrap--narrow">
		<p class="eyebrow"><?php esc_html_e( 'Account', 'afterbell' ); ?></p>
		<h1 class="page-head__title"><?php esc_html_e( 'Settings', 'afterbell' ); ?></h1>
	</div>
</section>

<section class="section section--flush">
	<div class="wrap wrap--narrow">
		<div class="apply">
			<?php ab_form_notice( 'saved', __( 'Your settings are saved.', 'afterbell' ), __( 'We could not save that. Check your password length and try again.', 'afterbell' ) ); ?>
			<form method="post" action="<?php echo esc_url( admin_url( 'admin-post.php' ) ); ?>">
				<input type="hidden" name="action" value="ab_settings">
				<?php wp_nonce_field( 'ab_settings' ); ?>
				<div class="field"><label for="s_name"><?php esc_html_e( 'Your name', 'afterbell' ); ?></label><input type="text" id="s_name" name="ab_name" value="<?php echo esc_attr( $ab_user->display_name ); ?>"></div>
				<div class="field"><label for="s_email"><?php esc_html_e( 'Email', 'afterbell' ); ?></label><input type="email" id="s_email" value="<?php echo esc_attr( $ab_user->user_email ); ?>" disabled></div>
				<div class="field"><label for="s_tz"><?php esc_html_e( 'Time zone', 'afterbell' ); ?></label><select id="s_tz" name="ab_tz"><?php echo wp_timezone_choice( ab_user_tz() ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?></select></div>
				<div class="field"><label for="s_pass"><?php esc_html_e( 'New password', 'afterbell' ); ?></label><input type="password" id="s_pass" name="ab_pass" minlength="8" autocomplete="new-password"><small class="field__hint"><?php esc_html_e( 'Leave empty to keep your current password.', 'afterbell' ); ?></small></div>
				<button class="btn btn--ink btn--block" type="submit"><?php esc_html_e( 'Save settings', 'afterbell' ); ?></button>
			</form>
		</div>
	</div>
</section>

<?php
get_footer();

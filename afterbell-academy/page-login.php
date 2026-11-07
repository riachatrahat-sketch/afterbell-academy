<?php
/**
 * Template Name: Log in
 *
 * @package afterbell
 */

if ( is_user_logged_in() ) {
	wp_safe_redirect( ab_account_url() );
	exit;
}

// phpcs:disable WordPress.Security.NonceVerification.Recommended
$ab_status = isset( $_GET['login'] ) ? sanitize_key( $_GET['login'] ) : '';
$ab_to     = isset( $_GET['redirect_to'] ) ? esc_url_raw( wp_unslash( $_GET['redirect_to'] ) ) : '';
// phpcs:enable

get_header();
?>

<section class="auth">
	<div class="auth__aside">
		<div class="auth__aside-inner">
			<p class="eyebrow eyebrow--brass"><?php esc_html_e( 'Welcome back', 'afterbell' ); ?></p>
			<h1><?php esc_html_e( 'Log in and pick up where you', 'afterbell' ); ?> <em><?php esc_html_e( 'left off.', 'afterbell' ); ?></em></h1>
			<p><?php esc_html_e( 'Your favorites, learner profiles and classes are waiting.', 'afterbell' ); ?></p>
		</div>
	</div>
	<div class="auth__main">
		<div class="auth__box">
			<h2><?php esc_html_e( 'Log in', 'afterbell' ); ?></h2>
			<?php
			if ( 'failed' === $ab_status ) {
				echo '<p class="notice notice--error" role="alert">' . esc_html__( 'That email and password do not match. Try again or reset your password.', 'afterbell' ) . '</p>';
			} elseif ( 'error' === $ab_status ) {
				echo '<p class="notice notice--error" role="alert">' . esc_html__( 'Something went wrong. Please try again.', 'afterbell' ) . '</p>';
			}
			if ( function_exists( 'shortcode_exists' ) && shortcode_exists( 'nextend_social_login' ) ) {
				echo '<div class="auth__social">' . do_shortcode( '[nextend_social_login]' ) . '</div><p class="auth__or"><span>' . esc_html__( 'or log in with email', 'afterbell' ) . '</span></p>'; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
			}
			?>
			<form method="post" action="<?php echo esc_url( admin_url( 'admin-post.php' ) ); ?>">
				<input type="hidden" name="action" value="ab_login">
				<input type="hidden" name="redirect_to" value="<?php echo esc_attr( $ab_to ); ?>">
				<?php wp_nonce_field( 'ab_login' ); ?>
				<div class="field"><label for="li_email"><?php esc_html_e( 'Email', 'afterbell' ); ?></label><input type="email" id="li_email" name="ab_email" required autocomplete="email"></div>
				<div class="field"><label for="li_pass"><?php esc_html_e( 'Password', 'afterbell' ); ?></label><input type="password" id="li_pass" name="ab_pass" required autocomplete="current-password"></div>
				<p class="auth__forgot"><a href="<?php echo esc_url( wp_lostpassword_url() ); ?>"><?php esc_html_e( 'Forgot your password?', 'afterbell' ); ?></a></p>
				<button class="btn btn--ink btn--block" type="submit"><?php esc_html_e( 'Log in with email', 'afterbell' ); ?></button>
			</form>
			<p class="auth__alt"><?php esc_html_e( 'Don\'t have an Afterbell account?', 'afterbell' ); ?> <a href="<?php echo esc_url( ab_signup_url() ); ?>"><?php esc_html_e( 'Sign up', 'afterbell' ); ?></a></p>
			<p class="auth__fine"><?php esc_html_e( 'By logging in you agree to our', 'afterbell' ); ?> <a href="<?php echo esc_url( ab_page_url( 'terms' ) ); ?>"><?php esc_html_e( 'Terms of use', 'afterbell' ); ?></a> <?php esc_html_e( 'and', 'afterbell' ); ?> <a href="<?php echo esc_url( ab_page_url( 'privacy' ) ); ?>"><?php esc_html_e( 'Privacy policy', 'afterbell' ); ?></a>.</p>
		</div>
	</div>
</section>

<?php
get_footer();

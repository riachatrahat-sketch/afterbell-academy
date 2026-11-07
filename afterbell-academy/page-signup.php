<?php
/**
 * Template Name: Sign up
 *
 * @package afterbell
 */

if ( is_user_logged_in() ) {
	wp_safe_redirect( ab_account_url() );
	exit;
}

// phpcs:ignore WordPress.Security.NonceVerification.Recommended
$ab_status = isset( $_GET['signup'] ) ? sanitize_key( $_GET['signup'] ) : '';
$ab_msgs   = array(
	'exists'  => __( 'An account with that email already exists. Try logging in.', 'afterbell' ),
	'weak'    => __( 'Use a password with at least 8 characters.', 'afterbell' ),
	'invalid' => __( 'Enter your name and a valid email address.', 'afterbell' ),
	'closed'  => __( 'Sign-ups are closed right now. Please contact us.', 'afterbell' ),
	'error'   => __( 'Something went wrong. Please try again.', 'afterbell' ),
);

get_header();
?>

<section class="auth">
	<div class="auth__aside">
		<div class="auth__aside-inner">
			<p class="eyebrow eyebrow--brass"><?php esc_html_e( 'Join for free', 'afterbell' ); ?></p>
			<h1><?php esc_html_e( 'Create your Afterbell', 'afterbell' ); ?> <em><?php esc_html_e( 'account', 'afterbell' ); ?></em></h1>
			<p><?php esc_html_e( 'Save your child\'s profile to get more tailored class picks and track their progress.', 'afterbell' ); ?></p>
			<ol class="auth__steps">
				<li><?php esc_html_e( 'Create your account', 'afterbell' ); ?></li>
				<li><?php esc_html_e( 'Tell us about your learner', 'afterbell' ); ?></li>
				<li><?php esc_html_e( 'Find classes that fit the after-school hours', 'afterbell' ); ?></li>
			</ol>
		</div>
	</div>
	<div class="auth__main">
		<div class="auth__box">
			<h2><?php esc_html_e( 'Sign up', 'afterbell' ); ?></h2>
			<?php
			if ( isset( $ab_msgs[ $ab_status ] ) ) {
				echo '<p class="notice notice--error" role="alert">' . esc_html( $ab_msgs[ $ab_status ] ) . '</p>';
			}
			if ( function_exists( 'shortcode_exists' ) && shortcode_exists( 'nextend_social_login' ) ) {
				echo '<div class="auth__social">' . do_shortcode( '[nextend_social_login]' ) . '</div><p class="auth__or"><span>' . esc_html__( 'or sign up with email', 'afterbell' ) . '</span></p>'; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
			}
			?>
			<form method="post" action="<?php echo esc_url( admin_url( 'admin-post.php' ) ); ?>">
				<input type="hidden" name="action" value="ab_signup">
				<?php wp_nonce_field( 'ab_signup' ); ?>
				<p class="hp" aria-hidden="true"><label for="ab_website">Website</label><input type="text" id="ab_website" name="ab_website" tabindex="-1" autocomplete="off"></p>
				<div class="field"><label for="su_name"><?php esc_html_e( 'Your name', 'afterbell' ); ?></label><input type="text" id="su_name" name="ab_name" required autocomplete="name"></div>
				<div class="field"><label for="su_email"><?php esc_html_e( 'Email', 'afterbell' ); ?></label><input type="email" id="su_email" name="ab_email" required autocomplete="email"></div>
				<div class="field"><label for="su_pass"><?php esc_html_e( 'Password', 'afterbell' ); ?></label><input type="password" id="su_pass" name="ab_pass" required minlength="8" autocomplete="new-password"><small class="field__hint"><?php esc_html_e( 'At least 8 characters.', 'afterbell' ); ?></small></div>
				<button class="btn btn--ink btn--block" type="submit"><?php esc_html_e( 'Sign up with email', 'afterbell' ); ?></button>
			</form>
			<p class="auth__alt"><?php esc_html_e( 'Already have an account?', 'afterbell' ); ?> <a href="<?php echo esc_url( ab_login_url() ); ?>"><?php esc_html_e( 'Log in', 'afterbell' ); ?></a></p>
			<p class="auth__fine"><?php esc_html_e( 'By signing up you agree to our', 'afterbell' ); ?> <a href="<?php echo esc_url( ab_page_url( 'terms' ) ); ?>"><?php esc_html_e( 'Terms of use', 'afterbell' ); ?></a> <?php esc_html_e( 'and', 'afterbell' ); ?> <a href="<?php echo esc_url( ab_page_url( 'privacy' ) ); ?>"><?php esc_html_e( 'Privacy policy', 'afterbell' ); ?></a>.</p>
		</div>
	</div>
</section>

<?php
get_footer();

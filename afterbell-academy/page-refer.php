<?php
/**
 * Template Name: Refer and earn
 *
 * @package afterbell
 */

get_header();
$ab_link = add_query_arg( 'ref', get_current_user_id(), home_url( '/' ) );
?>

<section class="page-head page-head--feature">
	<div class="wrap">
		<p class="eyebrow"><?php esc_html_e( 'Refer and earn', 'afterbell' ); ?></p>
		<h1 class="page-head__title"><?php esc_html_e( 'Share Afterbell with a', 'afterbell' ); ?> <em><?php esc_html_e( 'friend', 'afterbell' ); ?></em></h1>
		<p class="page-head__text"><?php echo esc_html( get_theme_mod( 'ab_refer_text', 'Invite friends to Afterbell. Share your personal link below.' ) ); ?></p>
	</div>
</section>

<section class="section section--flush">
	<div class="wrap wrap--narrow">
		<?php if ( is_user_logged_in() ) : ?>
			<div class="apply">
				<h2><?php esc_html_e( 'Your link', 'afterbell' ); ?></h2>
				<div class="copy-row">
					<input type="text" id="ref-link" value="<?php echo esc_attr( $ab_link ); ?>" readonly>
					<button class="btn btn--ink" type="button" data-copy="#ref-link"><?php esc_html_e( 'Copy link', 'afterbell' ); ?></button>
				</div>
			</div>
		<?php else : ?>
			<div class="empty">
				<h2><?php esc_html_e( 'Log in to get your link', 'afterbell' ); ?></h2>
				<a class="btn btn--brass" href="<?php echo esc_url( ab_login_url( ab_page_url( 'refer' ) ) ); ?>"><?php esc_html_e( 'Log in', 'afterbell' ); ?></a>
			</div>
		<?php endif; ?>
	</div>
</section>

<?php
get_footer();

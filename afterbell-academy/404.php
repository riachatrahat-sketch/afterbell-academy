<?php
/**
 * 404 page.
 *
 * @package afterbell
 */

get_header();
?>
<section class="page-head">
	<div class="wrap">
		<p class="eyebrow">404</p>
		<h1 class="page-head__title"><?php esc_html_e( 'This page skipped class.', 'afterbell' ); ?></h1>
		<p class="page-head__text"><?php esc_html_e( 'The page you wanted is not here. Head back to the class catalog.', 'afterbell' ); ?></p>
		<a class="btn btn--brass" href="<?php echo esc_url( ab_classes_url() ); ?>"><?php esc_html_e( 'Browse classes', 'afterbell' ); ?></a>
	</div>
</section>
<?php
get_footer();

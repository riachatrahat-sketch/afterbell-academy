<?php
/**
 * Template Name: About
 *
 * @package afterbell
 */

get_header();
?>

<section class="page-head page-head--feature">
	<div class="wrap">
		<p class="eyebrow"><?php esc_html_e( 'About Afterbell', 'afterbell' ); ?></p>
		<h1 class="page-head__title"><?php esc_html_e( 'We turn the hours after school into growth.', 'afterbell' ); ?></h1>
		<p class="page-head__text"><?php esc_html_e( 'Afterbell Academy offers live homeschool classes, 1:1 tutoring and leadership clubs, so a smart kid can become a next leader.', 'afterbell' ); ?></p>
	</div>
</section>

<section class="section">
	<div class="wrap">
		<div class="section__head"><h2 class="section__title"><?php esc_html_e( 'What we believe', 'afterbell' ); ?></h2></div>
		<ul class="pillars">
			<li class="pillar"><span class="pillar__no">01</span><h3><?php esc_html_e( 'Learning is live', 'afterbell' ); ?></h3><p><?php esc_html_e( 'Children learn best with a real teacher who responds to them.', 'afterbell' ); ?></p></li>
			<li class="pillar"><span class="pillar__no">02</span><h3><?php esc_html_e( 'Small is better', 'afterbell' ); ?></h3><p><?php esc_html_e( 'Small groups and 1:1 sessions mean every child is seen.', 'afterbell' ); ?></p></li>
			<li class="pillar"><span class="pillar__no">03</span><h3><?php esc_html_e( 'Skills beyond marks', 'afterbell' ); ?></h3><p><?php esc_html_e( 'Thinking, speaking, leading and building matter as much as grades.', 'afterbell' ); ?></p></li>
			<li class="pillar"><span class="pillar__no">04</span><h3><?php esc_html_e( 'Families decide', 'afterbell' ); ?></h3><p><?php esc_html_e( 'Parents choose the path, pace and schedule that suit their child.', 'afterbell' ); ?></p></li>
		</ul>
	</div>
</section>

<?php if ( trim( wp_strip_all_tags( get_post_field( 'post_content', get_the_ID() ) ) ) ) : ?>
<section class="section section--tint">
	<div class="wrap wrap--narrow">
		<div class="prose">
			<?php
			while ( have_posts() ) {
				the_post();
				the_content();
			}
			?>
		</div>
	</div>
</section>
<?php endif; ?>

<section class="section">
	<div class="wrap">
		<div class="cta-band">
			<h2><?php esc_html_e( 'Questions? We would love to hear from you.', 'afterbell' ); ?></h2>
			<a class="btn btn--brass" href="mailto:<?php echo esc_attr( ab_contact_email() ); ?>"><?php echo esc_html( ab_contact_email() ); ?></a>
		</div>
	</div>
</section>

<?php
get_footer();

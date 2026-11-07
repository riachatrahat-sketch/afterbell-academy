<?php
/**
 * Template Name: Educator library
 *
 * @package afterbell
 */

get_header();
?>

<section class="page-head page-head--feature">
	<div class="wrap">
		<p class="eyebrow"><?php esc_html_e( 'Educator library', 'afterbell' ); ?></p>
		<h1 class="page-head__title"><?php esc_html_e( 'Everything you need to start teaching.', 'afterbell' ); ?></h1>
		<p class="page-head__text"><?php esc_html_e( 'A short guide to planning a class, running live sessions and building a tutoring practice on Afterbell.', 'afterbell' ); ?></p>
		<a class="btn btn--brass" href="<?php echo esc_url( ab_teacher_page_url() ); ?>#apply"><?php esc_html_e( 'Apply to teach', 'afterbell' ); ?></a>
	</div>
</section>

<section class="section">
	<div class="wrap">
		<div class="section__head"><h2 class="section__title"><?php esc_html_e( 'Start here', 'afterbell' ); ?></h2></div>
		<ol class="steps">
			<li class="step"><span class="step__no">1</span><h3><?php esc_html_e( 'Apply', 'afterbell' ); ?></h3><p><?php esc_html_e( 'Tell us what you want to teach and your experience with children.', 'afterbell' ); ?></p></li>
			<li class="step"><span class="step__no">2</span><h3><?php esc_html_e( 'Design your class', 'afterbell' ); ?></h3><p><?php esc_html_e( 'Choose the age range, class size, weekly topics and price.', 'afterbell' ); ?></p></li>
			<li class="step"><span class="step__no">3</span><h3><?php esc_html_e( 'Go live', 'afterbell' ); ?></h3><p><?php esc_html_e( 'Publish your class page and welcome your first learners.', 'afterbell' ); ?></p></li>
		</ol>
	</div>
</section>

<section class="section section--tint">
	<div class="wrap">
		<div class="section__head"><h2 class="section__title"><?php esc_html_e( 'Teaching handbook', 'afterbell' ); ?></h2></div>
		<ul class="features">
			<li><h3><?php esc_html_e( 'Plan a course', 'afterbell' ); ?></h3><p><?php esc_html_e( 'Write one outcome per week and a simple project learners finish.', 'afterbell' ); ?></p></li>
			<li><h3><?php esc_html_e( 'Run a live session', 'afterbell' ); ?></h3><p><?php esc_html_e( 'Open with a warm-up, teach in short blocks and leave time for questions.', 'afterbell' ); ?></p></li>
			<li><h3><?php esc_html_e( 'Work with parents', 'afterbell' ); ?></h3><p><?php esc_html_e( 'Share what you covered and what to practise, in a few clear lines.', 'afterbell' ); ?></p></li>
			<li><h3><?php esc_html_e( 'Price fairly', 'afterbell' ); ?></h3><p><?php esc_html_e( 'Compare similar classes, then price by session length and class size.', 'afterbell' ); ?></p></li>
		</ul>
	</div>
</section>

<section class="section">
	<div class="wrap">
		<div class="section__head"><h2 class="section__title"><?php esc_html_e( 'Start a tutoring business', 'afterbell' ); ?></h2></div>
		<ul class="perks">
			<li><strong><?php esc_html_e( 'Pick a niche', 'afterbell' ); ?></strong><span><?php esc_html_e( 'A subject and age group you know well, such as middle school math or essay writing.', 'afterbell' ); ?></span></li>
			<li><strong><?php esc_html_e( 'Offer a trial session', 'afterbell' ); ?></strong><span><?php esc_html_e( 'A short first session lets families meet you before they commit.', 'afterbell' ); ?></span></li>
			<li><strong><?php esc_html_e( 'Build regulars', 'afterbell' ); ?></strong><span><?php esc_html_e( 'Offer weekly slots and send short progress notes after each session.', 'afterbell' ); ?></span></li>
		</ul>
	</div>
</section>

<?php
get_footer();

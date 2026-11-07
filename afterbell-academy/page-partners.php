<?php
/**
 * Template Name: Schools and partners
 *
 * @package afterbell
 */

get_header();
?>

<section class="page-head page-head--feature">
	<div class="wrap">
		<p class="eyebrow"><?php esc_html_e( 'Schools and partners', 'afterbell' ); ?></p>
		<h1 class="page-head__title"><?php esc_html_e( 'Add live learning to your school or co-op.', 'afterbell' ); ?></h1>
		<p class="page-head__text"><?php esc_html_e( 'Give your learners access to teachers, tutors and clubs beyond what you can staff yourself.', 'afterbell' ); ?></p>
		<a class="btn btn--brass" href="#partner-form"><?php esc_html_e( 'Talk to us', 'afterbell' ); ?></a>
	</div>
</section>

<section class="section">
	<div class="wrap">
		<div class="paths">
			<article class="path path--teal">
				<h3><?php esc_html_e( 'Virtual schools', 'afterbell' ); ?></h3>
				<p><?php esc_html_e( 'Fill gaps in your electives, languages and enrichment with live classes.', 'afterbell' ); ?></p>
			</article>
			<article class="path path--blue">
				<h3><?php esc_html_e( 'Public and private schools', 'afterbell' ); ?></h3>
				<p><?php esc_html_e( 'Offer after-school clubs and tutoring without hiring more staff.', 'afterbell' ); ?></p>
			</article>
			<article class="path path--brass">
				<h3><?php esc_html_e( 'Co-ops, micro and hybrid schools', 'afterbell' ); ?></h3>
				<p><?php esc_html_e( 'Complete your weekly schedule with subjects your parents cannot cover.', 'afterbell' ); ?></p>
			</article>
		</div>
	</div>
</section>

<section class="section section--tint" id="partner-form">
	<div class="wrap wrap--narrow">
		<div class="apply">
			<h2><?php esc_html_e( 'Partnership enquiry', 'afterbell' ); ?></h2>
			<?php ab_form_notice( 'sent', __( 'Thank you. We received your message and will reply by email.', 'afterbell' ), __( 'We could not send that. Check your name, email and organization, then try again.', 'afterbell' ) ); ?>
			<form method="post" action="<?php echo esc_url( admin_url( 'admin-post.php' ) ); ?>">
				<input type="hidden" name="action" value="ab_partner_request">
				<?php wp_nonce_field( 'ab_partner_request', 'ab_form_nonce' ); ?>
				<p class="hp" aria-hidden="true"><label for="ab_website">Website</label><input type="text" id="ab_website" name="ab_website" tabindex="-1" autocomplete="off"></p>
				<div class="field"><label for="ab_name"><?php esc_html_e( 'Your name', 'afterbell' ); ?></label><input type="text" id="ab_name" name="ab_name" required autocomplete="name"></div>
				<div class="field"><label for="ab_email"><?php esc_html_e( 'Email', 'afterbell' ); ?></label><input type="email" id="ab_email" name="ab_email" required autocomplete="email"></div>
				<div class="field"><label for="ab_topic"><?php esc_html_e( 'School or organization', 'afterbell' ); ?></label><input type="text" id="ab_topic" name="ab_topic" required></div>
				<div class="field"><label for="ab_about"><?php esc_html_e( 'How would you like to work with us?', 'afterbell' ); ?></label><textarea id="ab_about" name="ab_about" rows="4"></textarea></div>
				<button class="btn btn--ink btn--block" type="submit"><?php esc_html_e( 'Send enquiry', 'afterbell' ); ?></button>
			</form>
		</div>
	</div>
</section>

<?php
get_footer();

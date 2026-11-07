<?php
/**
 * Template Name: Gift cards
 *
 * @package afterbell
 */

get_header();
?>

<section class="page-head page-head--feature">
	<div class="wrap">
		<p class="eyebrow"><?php esc_html_e( 'Gift cards', 'afterbell' ); ?></p>
		<h1 class="page-head__title"><?php esc_html_e( 'Give the gift of a next step.', 'afterbell' ); ?></h1>
		<p class="page-head__text"><?php esc_html_e( 'A class, a tutor session or a leadership club. Tell us who it is for and we will arrange the gift.', 'afterbell' ); ?></p>
	</div>
</section>

<section class="section section--flush">
	<div class="wrap teach-layout">
		<ul class="perks">
			<li><strong><?php esc_html_e( 'Pick any amount', 'afterbell' ); ?></strong><span><?php esc_html_e( 'Tell us a budget or a class you have in mind.', 'afterbell' ); ?></span></li>
			<li><strong><?php esc_html_e( 'Works for any track', 'afterbell' ); ?></strong><span><?php esc_html_e( 'Homeschool courses, tutoring and clubs.', 'afterbell' ); ?></span></li>
			<li><strong><?php esc_html_e( 'We reply by email', 'afterbell' ); ?></strong><span><?php esc_html_e( 'We confirm the details and how to pay.', 'afterbell' ); ?></span></li>
		</ul>
		<div class="apply">
			<h2><?php esc_html_e( 'Request a gift card', 'afterbell' ); ?></h2>
			<?php ab_form_notice( 'sent', __( 'Thank you. We received your request and will email you.', 'afterbell' ), __( 'We could not send that. Check your name, email and recipient, then try again.', 'afterbell' ) ); ?>
			<form method="post" action="<?php echo esc_url( admin_url( 'admin-post.php' ) ); ?>">
				<input type="hidden" name="action" value="ab_gift_request">
				<?php wp_nonce_field( 'ab_gift_request', 'ab_form_nonce' ); ?>
				<p class="hp" aria-hidden="true"><label for="ab_website">Website</label><input type="text" id="ab_website" name="ab_website" tabindex="-1" autocomplete="off"></p>
				<div class="field"><label for="ab_name"><?php esc_html_e( 'Your name', 'afterbell' ); ?></label><input type="text" id="ab_name" name="ab_name" required autocomplete="name"></div>
				<div class="field"><label for="ab_email"><?php esc_html_e( 'Email', 'afterbell' ); ?></label><input type="email" id="ab_email" name="ab_email" required autocomplete="email"></div>
				<div class="field"><label for="ab_topic"><?php esc_html_e( 'Who is the gift for?', 'afterbell' ); ?></label><input type="text" id="ab_topic" name="ab_topic" required></div>
				<div class="field"><label for="ab_about"><?php esc_html_e( 'Amount, class idea or message', 'afterbell' ); ?></label><textarea id="ab_about" name="ab_about" rows="4"></textarea></div>
				<button class="btn btn--ink btn--block" type="submit"><?php esc_html_e( 'Send request', 'afterbell' ); ?></button>
			</form>
		</div>
	</div>
</section>

<?php
get_footer();

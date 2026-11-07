<?php
/**
 * Template Name: Become a Teacher
 *
 * @package afterbell
 */

get_header();

// phpcs:ignore WordPress.Security.NonceVerification.Recommended
$ab_status = isset( $_GET['applied'] ) ? sanitize_key( $_GET['applied'] ) : '';
?>

<section class="page-head">
	<div class="wrap">
		<p class="eyebrow"><?php esc_html_e( 'For teachers', 'afterbell' ); ?></p>
		<h1 class="page-head__title"><?php esc_html_e( 'Teach what you love, after the bell.', 'afterbell' ); ?></h1>
		<p class="page-head__text"><?php esc_html_e( 'Teach academic courses, tutor one-on-one or lead a club. You choose the topic, the schedule and the price.', 'afterbell' ); ?></p>
	</div>
</section>

<section class="section section--flush">
	<div class="wrap teach-layout">
		<div>
			<ul class="perks">
				<li><strong><?php esc_html_e( 'Set your own schedule', 'afterbell' ); ?></strong><span><?php esc_html_e( 'Offer one class a week or ten. Add sections when demand grows.', 'afterbell' ); ?></span></li>
				<li><strong><?php esc_html_e( 'Keep classes small', 'afterbell' ); ?></strong><span><?php esc_html_e( 'You decide the class size, so every learner gets your attention.', 'afterbell' ); ?></span></li>
				<li><strong><?php esc_html_e( 'Price it yourself', 'afterbell' ); ?></strong><span><?php esc_html_e( 'Your class page shows your price, schedule and bio side by side.', 'afterbell' ); ?></span></li>
			</ul>
			<div class="prose">
				<?php
				while ( have_posts() ) {
					the_post();
					the_content();
				}
				?>
			</div>
		</div>

		<div class="apply" id="apply">
			<h2><?php esc_html_e( 'Apply to teach', 'afterbell' ); ?></h2>

			<?php if ( 'ok' === $ab_status ) : ?>
				<p class="notice notice--ok" role="status"><?php esc_html_e( 'Thank you. We received your application and will reply by email.', 'afterbell' ); ?></p>
			<?php elseif ( 'error' === $ab_status ) : ?>
				<p class="notice notice--error" role="alert"><?php esc_html_e( 'We could not send that. Check your name, email and topic, then try again.', 'afterbell' ); ?></p>
			<?php endif; ?>

			<form method="post" action="<?php echo esc_url( admin_url( 'admin-post.php' ) ); ?>">
				<input type="hidden" name="action" value="ab_teacher_apply">
				<?php wp_nonce_field( 'ab_teacher_apply', 'ab_form_nonce' ); ?>
				<p class="hp" aria-hidden="true"><label for="ab_website">Website</label><input type="text" id="ab_website" name="ab_website" tabindex="-1" autocomplete="off"></p>

				<div class="field">
					<label for="ab_name"><?php esc_html_e( 'Your name', 'afterbell' ); ?></label>
					<input type="text" id="ab_name" name="ab_name" required autocomplete="name">
				</div>
				<div class="field">
					<label for="ab_email"><?php esc_html_e( 'Email', 'afterbell' ); ?></label>
					<input type="email" id="ab_email" name="ab_email" required autocomplete="email">
				</div>
				<div class="field">
					<label for="ab_topic"><?php esc_html_e( 'What do you want to teach?', 'afterbell' ); ?></label>
					<input type="text" id="ab_topic" name="ab_topic" required>
				</div>
				<div class="field">
					<label for="ab_about"><?php esc_html_e( 'Tell us about your experience with kids', 'afterbell' ); ?></label>
					<textarea id="ab_about" name="ab_about" rows="5"></textarea>
				</div>
				<button class="btn btn--ink btn--block" type="submit"><?php esc_html_e( 'Send application', 'afterbell' ); ?></button>
			</form>
		</div>
	</div>
</section>

<?php
get_footer();

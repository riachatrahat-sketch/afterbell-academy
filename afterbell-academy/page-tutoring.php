<?php
/**
 * Template Name: 1:1 Tutoring
 *
 * @package afterbell
 */

get_header();

// phpcs:ignore WordPress.Security.NonceVerification.Recommended
$ab_status = isset( $_GET['requested'] ) ? sanitize_key( $_GET['requested'] ) : '';
?>

<section class="page-head page-head--feature">
	<div class="wrap">
		<p class="eyebrow"><?php esc_html_e( '1:1 tutoring', 'afterbell' ); ?></p>
		<h1 class="page-head__title"><?php esc_html_e( 'Tutoring built around one child.', 'afterbell' ); ?></h1>
		<p class="page-head__text"><?php esc_html_e( 'Tell us the goal. We match a tutor, you meet in a trial session and learning continues on a schedule that fits your family.', 'afterbell' ); ?></p>
		<a class="btn btn--brass" href="#request"><?php esc_html_e( 'Request a tutor', 'afterbell' ); ?></a>
	</div>
</section>

<section class="section">
	<div class="wrap">
		<ol class="steps">
			<li class="step"><span class="step__no">1</span><h3><?php esc_html_e( 'Share the goal', 'afterbell' ); ?></h3><p><?php esc_html_e( 'Catch up, keep pace, prepare for exams or go further. Tell us the subject, age and preferred times.', 'afterbell' ); ?></p></li>
			<li class="step"><span class="step__no">2</span><h3><?php esc_html_e( 'Meet your tutor', 'afterbell' ); ?></h3><p><?php esc_html_e( 'We match a tutor and you book a trial session to see if it fits.', 'afterbell' ); ?></p></li>
			<li class="step"><span class="step__no">3</span><h3><?php esc_html_e( 'Learn every week', 'afterbell' ); ?></h3><p><?php esc_html_e( 'Continue weekly or as needed, with feedback on real work.', 'afterbell' ); ?></p></li>
		</ol>
	</div>
</section>

<section class="section">
	<div class="wrap">
		<div class="section__head"><h2 class="section__title"><?php esc_html_e( 'Tutoring by subject', 'afterbell' ); ?></h2></div>
		<ul class="chips chips--lg">
			<?php
			$ab_tsubs = array(
				'math'           => __( 'Math', 'afterbell' ),
				'english'        => __( 'English and writing', 'afterbell' ),
				'science'        => __( 'Science', 'afterbell' ),
				'social-studies' => __( 'History and social studies', 'afterbell' ),
				'languages'      => __( 'World languages', 'afterbell' ),
				'coding'         => __( 'Coding', 'afterbell' ),
				'speaking'       => __( 'Public speaking', 'afterbell' ),
				'logic'          => __( 'Chess', 'afterbell' ),
			);
			foreach ( $ab_tsubs as $slug => $label ) :
				?>
				<li><a href="<?php echo esc_url( ab_browse_url( array( 'format' => 'one_to_one', 'subj' => $slug ) ) ); ?>"><?php echo esc_html( $label ); ?></a></li>
			<?php endforeach; ?>
		</ul>
	</div>
</section>

<?php
$ab_tutors = new WP_Query( array(
	'post_type'      => 'ab_class',
	'posts_per_page' => 6,
	'no_found_rows'  => true,
	'meta_query'     => array( array( 'key' => '_ab_format', 'value' => 'one_to_one' ) ),
) );
if ( $ab_tutors->have_posts() ) :
	?>
<section class="section section--tint">
	<div class="wrap">
		<div class="section__head section__head--row">
			<h2 class="section__title"><?php esc_html_e( 'Tutoring subjects', 'afterbell' ); ?></h2>
			<a class="link-arrow" href="<?php echo esc_url( ab_browse_url( array( 'format' => 'one_to_one' ) ) ); ?>"><?php esc_html_e( 'See all 1:1 tutoring', 'afterbell' ); ?></a>
		</div>
		<div class="grid">
			<?php
			while ( $ab_tutors->have_posts() ) {
				$ab_tutors->the_post();
				get_template_part( 'template-parts/class-card' );
			}
			wp_reset_postdata();
			?>
		</div>
	</div>
</section>
<?php endif; ?>

<section class="section" id="request">
	<div class="wrap teach-layout">
		<div>
			<h2 class="section__title"><?php esc_html_e( 'Request a tutor', 'afterbell' ); ?></h2>
			<ul class="perks">
				<li><strong><?php esc_html_e( 'Matched to your goal', 'afterbell' ); ?></strong><span><?php esc_html_e( 'Tell us what your child needs and we suggest the right tutor.', 'afterbell' ); ?></span></li>
				<li><strong><?php esc_html_e( 'Trial session first', 'afterbell' ); ?></strong><span><?php esc_html_e( 'Try one session before you commit to a plan.', 'afterbell' ); ?></span></li>
				<li><strong><?php esc_html_e( 'Your schedule', 'afterbell' ); ?></strong><span><?php esc_html_e( 'Weekly, twice weekly or only before exams.', 'afterbell' ); ?></span></li>
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

		<div class="apply">
			<h2><?php esc_html_e( 'Tell us about your child', 'afterbell' ); ?></h2>

			<?php if ( 'ok' === $ab_status ) : ?>
				<p class="notice notice--ok" role="status"><?php esc_html_e( 'Thank you. We received your request and will email you with tutor options.', 'afterbell' ); ?></p>
			<?php elseif ( 'error' === $ab_status ) : ?>
				<p class="notice notice--error" role="alert"><?php esc_html_e( 'We could not send that. Check your name, email and subject, then try again.', 'afterbell' ); ?></p>
			<?php endif; ?>

			<form method="post" action="<?php echo esc_url( admin_url( 'admin-post.php' ) ); ?>">
				<input type="hidden" name="action" value="ab_tutor_request">
				<?php wp_nonce_field( 'ab_tutor_request', 'ab_form_nonce' ); ?>
				<p class="hp" aria-hidden="true"><label for="ab_website">Website</label><input type="text" id="ab_website" name="ab_website" tabindex="-1" autocomplete="off"></p>
				<div class="field"><label for="ab_name"><?php esc_html_e( 'Your name', 'afterbell' ); ?></label><input type="text" id="ab_name" name="ab_name" required autocomplete="name"></div>
				<div class="field"><label for="ab_email"><?php esc_html_e( 'Email', 'afterbell' ); ?></label><input type="email" id="ab_email" name="ab_email" required autocomplete="email"></div>
				<div class="field"><label for="ab_age"><?php esc_html_e( 'Child age or grade', 'afterbell' ); ?></label><input type="text" id="ab_age" name="ab_age"></div>
				<div class="field"><label for="ab_topic"><?php esc_html_e( 'Subject', 'afterbell' ); ?></label><input type="text" id="ab_topic" name="ab_topic" required placeholder="<?php esc_attr_e( 'Math, English, science', 'afterbell' ); ?>"></div>
				<div class="field"><label for="ab_times"><?php esc_html_e( 'Preferred days and times', 'afterbell' ); ?></label><input type="text" id="ab_times" name="ab_times"></div>
				<div class="field"><label for="ab_about"><?php esc_html_e( 'What is the goal?', 'afterbell' ); ?></label><textarea id="ab_about" name="ab_about" rows="4"></textarea></div>
				<button class="btn btn--ink btn--block" type="submit"><?php esc_html_e( 'Send request', 'afterbell' ); ?></button>
			</form>
		</div>
	</div>
</section>

<?php
get_footer();

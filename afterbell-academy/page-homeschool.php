<?php
/**
 * Template Name: Homeschool
 *
 * @package afterbell
 */

get_header();

$ab_core = array(
	'math'           => array( __( 'Math', 'afterbell' ), __( 'Number sense to pre-algebra', 'afterbell' ) ),
	'english'        => array( __( 'English and writing', 'afterbell' ), __( 'Reading, grammar, essays', 'afterbell' ) ),
	'science'        => array( __( 'Science', 'afterbell' ), __( 'Life, earth and physical science', 'afterbell' ) ),
	'social-studies' => array( __( 'Social studies', 'afterbell' ), __( 'History, geography, civics', 'afterbell' ) ),
	'languages'      => array( __( 'World languages', 'afterbell' ), __( 'Speak from the first class', 'afterbell' ) ),
	'coding'         => array( __( 'Coding and tech', 'afterbell' ), __( 'Make games and apps', 'afterbell' ) ),
);
?>

<section class="page-head page-head--feature">
	<div class="wrap">
		<p class="eyebrow"><?php esc_html_e( 'Homeschool', 'afterbell' ); ?></p>
		<h1 class="page-head__title"><?php esc_html_e( 'A homeschool week with a school-day rhythm.', 'afterbell' ); ?></h1>
		<p class="page-head__text"><?php esc_html_e( 'Live academic courses by grade, a tutor where your child needs one and clubs that build leaders. Mix them to fit your family.', 'afterbell' ); ?></p>
		<div class="hero__cta">
			<a class="btn btn--brass" href="<?php echo esc_url( ab_browse_url( array( 'track' => 'homeschool-academics' ) ) ); ?>"><?php esc_html_e( 'Browse academic courses', 'afterbell' ); ?></a>
			<a class="btn btn--ghost" href="<?php echo esc_url( ab_page_url( 'tutoring' ) ); ?>"><?php esc_html_e( 'Add a 1:1 tutor', 'afterbell' ); ?></a>
		</div>
	</div>
</section>

<section class="section">
	<div class="wrap">
		<div class="section__head"><h2 class="section__title"><?php esc_html_e( 'Core subjects', 'afterbell' ); ?></h2></div>
		<ul class="subjects">
			<?php $ab_i = 0; foreach ( $ab_core as $slug => $s ) : ?>
				<li>
					<a class="subject tone-<?php echo (int) ( $ab_i++ % 6 ); ?>" href="<?php echo esc_url( ab_browse_url( array( 'track' => 'homeschool-academics', 'subj' => $slug ) ) ); ?>">
						<span class="subject__name"><?php echo esc_html( $s[0] ); ?></span>
						<span class="subject__count"><?php echo esc_html( $s[1] ); ?></span>
					</a>
				</li>
			<?php endforeach; ?>
		</ul>
	</div>
</section>

<section class="section section--tint">
	<div class="wrap">
		<div class="section__head"><h2 class="section__title"><?php esc_html_e( 'Find your grade band', 'afterbell' ); ?></h2></div>
		<ul class="bands">
			<?php foreach ( ab_age_bands() as $key => $b ) : ?>
				<li>
					<a class="band" href="<?php echo esc_url( ab_browse_url( array( 'track' => 'homeschool-academics', 'band' => $key ) ) ); ?>">
						<span class="band__ages"><?php echo (int) $b[0]; ?>&ndash;<?php echo (int) $b[1]; ?></span>
						<span class="band__name"><?php echo esc_html( $b[2] ); ?></span>
						<span class="band__text"><?php esc_html_e( 'See academic courses', 'afterbell' ); ?></span>
					</a>
				</li>
			<?php endforeach; ?>
		</ul>
	</div>
</section>

<section class="section">
	<div class="wrap">
		<div class="section__head">
			<h2 class="section__title"><?php esc_html_e( 'A sample week', 'afterbell' ); ?></h2>
			<p class="section__lead"><?php esc_html_e( 'You lead the mornings. Afterbell covers the hours after the bell. This is an example, not a fixed plan.', 'afterbell' ); ?></p>
		</div>
		<div class="table-scroll">
			<table class="week">
				<thead><tr><th><?php esc_html_e( 'Day', 'afterbell' ); ?></th><th><?php esc_html_e( 'Morning, led by you', 'afterbell' ); ?></th><th><?php esc_html_e( 'After the bell, with Afterbell', 'afterbell' ); ?></th></tr></thead>
				<tbody>
					<tr><th scope="row"><?php esc_html_e( 'Mon', 'afterbell' ); ?></th><td><?php esc_html_e( 'Family reading and journaling', 'afterbell' ); ?></td><td><?php esc_html_e( 'Math course, live', 'afterbell' ); ?></td></tr>
					<tr><th scope="row"><?php esc_html_e( 'Tue', 'afterbell' ); ?></th><td><?php esc_html_e( 'Nature study and sketching', 'afterbell' ); ?></td><td><?php esc_html_e( 'Young Speakers Club', 'afterbell' ); ?></td></tr>
					<tr><th scope="row"><?php esc_html_e( 'Wed', 'afterbell' ); ?></th><td><?php esc_html_e( 'Project time', 'afterbell' ); ?></td><td><?php esc_html_e( 'Math course, then English workshop', 'afterbell' ); ?></td></tr>
					<tr><th scope="row"><?php esc_html_e( 'Thu', 'afterbell' ); ?></th><td><?php esc_html_e( 'Practice and review', 'afterbell' ); ?></td><td><?php esc_html_e( '1:1 tutor session', 'afterbell' ); ?></td></tr>
					<tr><th scope="row"><?php esc_html_e( 'Fri', 'afterbell' ); ?></th><td><?php esc_html_e( 'Field trip or community day', 'afterbell' ); ?></td><td><?php esc_html_e( 'Science course, live', 'afterbell' ); ?></td></tr>
				</tbody>
			</table>
		</div>
	</div>
</section>

<section class="section section--tint">
	<div class="wrap">
		<div class="section__head"><h2 class="section__title"><?php esc_html_e( 'What homeschool families get', 'afterbell' ); ?></h2></div>
		<ul class="features">
			<li><h3><?php esc_html_e( 'Live teachers', 'afterbell' ); ?></h3><p><?php esc_html_e( 'Real-time lessons where your child asks questions and gets answers.', 'afterbell' ); ?></p></li>
			<li><h3><?php esc_html_e( 'Flexible pacing', 'afterbell' ); ?></h3><p><?php esc_html_e( 'Take one course or five. Add a tutor when a topic needs extra time.', 'afterbell' ); ?></p></li>
			<li><h3><?php esc_html_e( 'Clear course details', 'afterbell' ); ?></h3><p><?php esc_html_e( 'Every class page lists topics, hours, grade level and class size.', 'afterbell' ); ?></p></li>
			<li><h3><?php esc_html_e( 'Beyond academics', 'afterbell' ); ?></h3><p><?php esc_html_e( 'Leadership clubs give homeschoolers regular time with peers.', 'afterbell' ); ?></p></li>
		</ul>
		<p class="fineprint"><?php esc_html_e( 'Homeschool requirements differ by country and region. Please check your local rules.', 'afterbell' ); ?></p>
	</div>
</section>

<?php
$ab_top = new WP_Query( array(
	'post_type'      => 'ab_class',
	'posts_per_page' => 4,
	'no_found_rows'  => true,
	'tax_query'      => array( array( 'taxonomy' => 'ab_track', 'field' => 'slug', 'terms' => 'homeschool-academics' ) ),
) );
if ( $ab_top->have_posts() ) :
	?>
<section class="section">
	<div class="wrap">
		<div class="section__head section__head--row">
			<h2 class="section__title"><?php esc_html_e( 'Top academic courses', 'afterbell' ); ?></h2>
			<a class="link-arrow" href="<?php echo esc_url( ab_browse_url( array( 'track' => 'homeschool-academics' ) ) ); ?>"><?php esc_html_e( 'See all', 'afterbell' ); ?></a>
		</div>
		<div class="grid">
			<?php
			while ( $ab_top->have_posts() ) {
				$ab_top->the_post();
				get_template_part( 'template-parts/class-card' );
			}
			wp_reset_postdata();
			?>
		</div>
	</div>
</section>
<?php endif; ?>

<section class="section section--tint">
	<div class="wrap wrap--narrow">
		<div class="section__head"><h2 class="section__title"><?php esc_html_e( 'Homeschool questions', 'afterbell' ); ?></h2></div>
		<div class="faq">
			<details><summary><?php esc_html_e( 'Do I need to follow a set curriculum?', 'afterbell' ); ?></summary><p><?php esc_html_e( 'No. Pick the courses that match your goals and your child\'s pace. Each class page lists its topics.', 'afterbell' ); ?></p></details>
			<details><summary><?php esc_html_e( 'Can my child join mid-term?', 'afterbell' ); ?></summary><p><?php esc_html_e( 'Ask the teacher through the class page. Many courses start new sections regularly.', 'afterbell' ); ?></p></details>
			<details><summary><?php esc_html_e( 'How do we keep records?', 'afterbell' ); ?></summary><p><?php esc_html_e( 'Class pages list hours, topics and grade level. Keep them with your own portfolio and check your local requirements.', 'afterbell' ); ?></p></details>
		</div>
	</div>
</section>

<section class="section">
	<div class="wrap">
		<div class="cta-band">
			<h2><?php esc_html_e( 'Ready to plan your week?', 'afterbell' ); ?></h2>
			<a class="btn btn--brass" href="<?php echo esc_url( ab_browse_url( array( 'track' => 'homeschool-academics' ) ) ); ?>"><?php esc_html_e( 'Browse academic courses', 'afterbell' ); ?></a>
		</div>
	</div>
</section>

<?php
get_footer();

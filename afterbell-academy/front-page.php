<?php
/**
 * Homepage.
 *
 * @package afterbell
 */

get_header();

$ab_title = get_theme_mod( 'ab_hero_title', 'Smart kid today. *Next leader* tomorrow.' );
$ab_text  = get_theme_mod( 'ab_hero_text', 'Live online homeschool classes, 1:1 tutoring and leadership clubs for ages 3 to 18, built around the hours after the school bell.' );
$ab_bell  = '<svg class="brand__bell" width="30" height="30" viewBox="0 0 28 28" aria-hidden="true"><path d="M14 3a1.6 1.6 0 0 1 1.6 1.6v.6c3.3.8 5.4 3.7 5.4 7.2v3.5l2 3.2c.4.7 0 1.5-.8 1.5H5.8c-.8 0-1.2-.8-.8-1.5l2-3.2v-3.5c0-3.5 2.1-6.4 5.4-7.2v-.6A1.6 1.6 0 0 1 14 3Z" fill="currentColor"/><path d="M11.2 23.2a2.9 2.9 0 0 0 5.6 0Z" fill="currentColor"/></svg>';
$ab_marquee = array(
	__( 'Math', 'afterbell' ),
	__( 'English', 'afterbell' ),
	__( 'Science', 'afterbell' ),
	__( 'Public speaking', 'afterbell' ),
	__( 'Coding', 'afterbell' ),
	__( 'History', 'afterbell' ),
	__( 'Debate', 'afterbell' ),
	__( 'Spanish', 'afterbell' ),
	__( 'Chess', 'afterbell' ),
	__( 'Entrepreneurship', 'afterbell' ),
	__( 'Writing', 'afterbell' ),
);
?>

<section class="hero">
	<div class="wrap hero__grid">
		<div class="hero__copy">
			<p class="eyebrow"><?php esc_html_e( 'Homeschool, 1:1 tutoring and leadership', 'afterbell' ); ?></p>
			<h1 class="hero__title"><?php echo wp_kses( ab_emphasize( $ab_title ), array( 'em' => array() ) ); ?></h1>
			<p class="hero__text"><?php echo esc_html( $ab_text ); ?></p>
			<div class="hero__cta">
				<a class="btn btn--brass btn--arrow" href="<?php echo esc_url( ab_page_url( 'homeschool' ) ); ?>"><?php esc_html_e( 'Explore homeschool', 'afterbell' ); ?></a>
				<a class="btn btn--ghost" href="<?php echo esc_url( ab_page_url( 'tutoring' ) ); ?>"><?php esc_html_e( 'Find a 1:1 tutor', 'afterbell' ); ?></a>
			</div>
			<ul class="hero__proof">
				<li><?php esc_html_e( 'Live teachers', 'afterbell' ); ?></li>
				<li><?php esc_html_e( 'Small groups', 'afterbell' ); ?></li>
				<li><?php esc_html_e( 'Ages 3 to 18', 'afterbell' ); ?></li>
			</ul>
		</div>

		<div class="board" aria-hidden="true">
			<div class="hb hb-live">
				<div class="hb-live__top"><span class="live-pill"><?php esc_html_e( 'Live now', 'afterbell' ); ?></span><span>4:30 PM</span></div>
				<h3><?php esc_html_e( 'Young Speakers Club', 'afterbell' ); ?></h3>
				<div class="avatars"><span>A</span><span>R</span><span>M</span><small><?php esc_html_e( '6 learners', 'afterbell' ); ?></small></div>
				<div class="meter"><i></i></div>
			</div>
			<div class="hb hb-tutor">
				<small><?php esc_html_e( '1:1 tutoring', 'afterbell' ); ?></small>
				<h3><?php esc_html_e( 'Math tutor', 'afterbell' ); ?></h3>
				<span><?php esc_html_e( 'Today, 6:00 PM', 'afterbell' ); ?></span>
			</div>
			<div class="hb hb-path">
				<p><?php esc_html_e( 'The Afterbell path', 'afterbell' ); ?></p>
				<ol class="stairs">
					<li style="--h:1"><span><?php esc_html_e( 'Smart', 'afterbell' ); ?></span></li>
					<li style="--h:2"><span><?php esc_html_e( 'Curious', 'afterbell' ); ?></span></li>
					<li style="--h:3"><span><?php esc_html_e( 'Bold', 'afterbell' ); ?></span></li>
					<li style="--h:4"><span><?php esc_html_e( 'Capable', 'afterbell' ); ?></span></li>
					<li style="--h:5" class="is-top"><svg class="stairs__flag" width="20" height="24" viewBox="0 0 22 26"><path d="M3 24V2" stroke="currentColor" stroke-width="2.4" stroke-linecap="round"/><path d="M3 3h15l-4 5 4 5H3z" fill="currentColor"/></svg><span><?php esc_html_e( 'Leader', 'afterbell' ); ?></span></li>
				</ol>
			</div>
			<div class="sticker">
				<svg class="ring" viewBox="0 0 112 112"><defs><path id="ab-ring" d="M56 56m-42 0a42 42 0 1 1 84 0a42 42 0 1 1-84 0"/></defs><text><textPath href="#ab-ring"><?php esc_html_e( 'Smart kid * Next leader * ', 'afterbell' ); ?></textPath></text></svg>
				<?php echo $ab_bell; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped -- static markup. ?>
			</div>
		</div>
	</div>
</section>

<div class="marquee" aria-hidden="true">
	<div class="marquee__track">
		<ul class="marquee__list"><?php foreach ( $ab_marquee as $m ) { echo '<li>' . esc_html( $m ) . '</li>'; } ?></ul>
		<ul class="marquee__list"><?php foreach ( $ab_marquee as $m ) { echo '<li>' . esc_html( $m ) . '</li>'; } ?></ul>
	</div>
</div>

<section class="section">
	<div class="wrap">
		<div class="section__head">
			<p class="eyebrow"><?php esc_html_e( 'Three ways to learn', 'afterbell' ); ?></p>
			<h2 class="section__title"><?php esc_html_e( 'One goal: a child who thinks, speaks and', 'afterbell' ); ?> <em><?php esc_html_e( 'leads.', 'afterbell' ); ?></em></h2>
		</div>
		<div class="bento">
			<article class="tile tile--home">
				<p class="tag-top"><?php esc_html_e( 'Homeschool academics', 'afterbell' ); ?></p>
				<h3><?php esc_html_e( 'A full school week, taught live.', 'afterbell' ); ?></h3>
				<p><?php esc_html_e( 'Math, English, science, social studies and languages by grade, with clear weekly topics and feedback on real work.', 'afterbell' ); ?></p>
				<ul><li><?php esc_html_e( 'Multi-week courses by grade', 'afterbell' ); ?></li><li><?php esc_html_e( 'Pick one course or build a full week', 'afterbell' ); ?></li><li><?php esc_html_e( 'Small groups, live teachers', 'afterbell' ); ?></li></ul>
				<a class="link-arrow" href="<?php echo esc_url( ab_page_url( 'homeschool' ) ); ?>"><?php esc_html_e( 'See the homeschool plan', 'afterbell' ); ?></a>
				<svg class="tile__art" viewBox="0 0 320 200" aria-hidden="true"><circle cx="230" cy="90" r="90" fill="#0fb5a6" opacity=".9"/><rect x="60" y="70" width="130" height="110" rx="28" fill="#ffb21a" transform="rotate(-8 125 125)"/><path d="M95 120h64M95 146h40" stroke="#0e1633" stroke-width="8" stroke-linecap="round"/><circle cx="270" cy="170" r="26" fill="#ff6b4a"/></svg>
			</article>
			<article class="tile tile--tutor">
				<p class="tag-top"><?php esc_html_e( '1:1 tutoring', 'afterbell' ); ?></p>
				<h3><?php esc_html_e( 'One child. One tutor.', 'afterbell' ); ?></h3>
				<p><?php esc_html_e( 'Matched to your goal, starting with a trial session.', 'afterbell' ); ?></p>
				<a class="link-arrow" href="<?php echo esc_url( ab_page_url( 'tutoring' ) ); ?>"><?php esc_html_e( 'Find a tutor', 'afterbell' ); ?></a>
				<svg class="tile__art" viewBox="0 0 200 200" aria-hidden="true"><circle cx="110" cy="90" r="80" fill="#4c7dff"/><circle cx="110" cy="90" r="46" fill="#d3deff"/><circle cx="110" cy="90" r="16" fill="#0e1633"/></svg>
			</article>
			<article class="tile tile--lead">
				<p class="tag-top"><?php esc_html_e( 'Leadership and clubs', 'afterbell' ); ?></p>
				<h3><?php esc_html_e( 'Speak, debate, build.', 'afterbell' ); ?></h3>
				<p><?php esc_html_e( 'Clubs that end with a talk, a pitch or a finished project.', 'afterbell' ); ?></p>
				<a class="link-arrow" href="<?php echo esc_url( ab_browse_url( array( 'track' => 'leadership' ) ) ); ?>"><?php esc_html_e( 'Browse leadership', 'afterbell' ); ?></a>
				<svg class="tile__art" viewBox="0 0 240 200" aria-hidden="true"><rect x="40" y="110" width="44" height="80" rx="12" fill="#0e1633" opacity=".85"/><rect x="100" y="70" width="44" height="120" rx="12" fill="#fff" opacity=".7"/><rect x="160" y="30" width="44" height="160" rx="12" fill="#0e1633" opacity=".85"/></svg>
			</article>
		</div>
	</div>
</section>

<section class="section section--tint">
	<div class="wrap">
		<div class="section__head">
			<h2 class="section__title"><?php esc_html_e( 'Start at your child\'s', 'afterbell' ); ?> <em><?php esc_html_e( 'age', 'afterbell' ); ?></em></h2>
		</div>
		<ul class="bands">
			<?php
			$ab_focus = array(
				'early'      => __( 'Phonics, number sense, stories and play-based learning.', 'afterbell' ),
				'elementary' => __( 'Core math and reading, science curiosity and first clubs.', 'afterbell' ),
				'middle'     => __( 'Pre-algebra, writing, lab science, debate and projects.', 'afterbell' ),
				'high'       => __( 'Advanced subjects, exam prep, 1:1 tutoring and real-world leadership.', 'afterbell' ),
			);
			foreach ( ab_age_bands() as $key => $b ) :
				?>
				<li>
					<a class="band" href="<?php echo esc_url( ab_browse_url( array( 'band' => $key ) ) ); ?>">
						<span class="band__ages"><?php echo (int) $b[0]; ?>&ndash;<?php echo (int) $b[1]; ?></span>
						<span class="band__name"><?php echo esc_html( $b[2] ); ?></span>
						<span class="band__text"><?php echo esc_html( $ab_focus[ $key ] ); ?></span>
					</a>
				</li>
			<?php endforeach; ?>
		</ul>
	</div>
</section>

<section class="section section--ink">
	<div class="wrap">
		<div class="section__head">
			<p class="eyebrow eyebrow--brass"><?php esc_html_e( 'Why after school', 'afterbell' ); ?></p>
			<h2 class="section__title"><?php esc_html_e( 'School builds the base. The hours after the bell build the', 'afterbell' ); ?> <em><?php esc_html_e( 'leader.', 'afterbell' ); ?></em></h2>
			<p class="section__lead"><?php esc_html_e( 'Use the golden hours after school for deeper practice, a tutor who knows your child and clubs that grow confidence. A sample after-bell day:', 'afterbell' ); ?></p>
		</div>
		<ol class="day">
			<li><time>3:00</time><strong><?php esc_html_e( 'School ends', 'afterbell' ); ?></strong><span><?php esc_html_e( 'Snack and reset', 'afterbell' ); ?></span></li>
			<li><time>3:30</time><strong><?php esc_html_e( 'Academic boost', 'afterbell' ); ?></strong><span><?php esc_html_e( 'Math, English or science course', 'afterbell' ); ?></span></li>
			<li><time>4:30</time><strong><?php esc_html_e( '1:1 tutor', 'afterbell' ); ?></strong><span><?php esc_html_e( 'Targeted help on one goal', 'afterbell' ); ?></span></li>
			<li><time>5:30</time><strong><?php esc_html_e( 'Leadership club', 'afterbell' ); ?></strong><span><?php esc_html_e( 'Speak, debate or build', 'afterbell' ); ?></span></li>
			<li><time>6:30</time><strong><?php esc_html_e( 'Family time', 'afterbell' ); ?></strong><span><?php esc_html_e( 'Share what they made', 'afterbell' ); ?></span></li>
		</ol>
	</div>
</section>

<section class="section">
	<div class="wrap">
		<div class="section__head">
			<p class="eyebrow"><?php esc_html_e( 'From smart kid to next leader', 'afterbell' ); ?></p>
			<h2 class="section__title"><?php esc_html_e( 'Four skills every class', 'afterbell' ); ?> <em><?php esc_html_e( 'works on', 'afterbell' ); ?></em></h2>
		</div>
		<ul class="pillars">
			<li class="pillar"><span class="pillar__no">01</span><h3><?php esc_html_e( 'Think', 'afterbell' ); ?></h3><p><?php esc_html_e( 'Ask better questions, reason with evidence and solve unfamiliar problems.', 'afterbell' ); ?></p></li>
			<li class="pillar"><span class="pillar__no">02</span><h3><?php esc_html_e( 'Speak', 'afterbell' ); ?></h3><p><?php esc_html_e( 'Explain an idea clearly and present it with confidence.', 'afterbell' ); ?></p></li>
			<li class="pillar"><span class="pillar__no">03</span><h3><?php esc_html_e( 'Lead', 'afterbell' ); ?></h3><p><?php esc_html_e( 'Work in a team, take responsibility and help others do their best.', 'afterbell' ); ?></p></li>
			<li class="pillar"><span class="pillar__no">04</span><h3><?php esc_html_e( 'Build', 'afterbell' ); ?></h3><p><?php esc_html_e( 'Finish real projects, from a story to a game to a small business pitch.', 'afterbell' ); ?></p></li>
		</ul>
	</div>
</section>

<?php
$ab_latest = new WP_Query( array( 'post_type' => 'ab_class', 'posts_per_page' => 8, 'no_found_rows' => true ) );
if ( $ab_latest->have_posts() ) :
	?>
<section class="section section--tint">
	<div class="wrap">
		<div class="section__head section__head--row">
			<h2 class="section__title"><?php esc_html_e( 'Popular', 'afterbell' ); ?> <em><?php esc_html_e( 'right now', 'afterbell' ); ?></em></h2>
			<a class="link-arrow" href="<?php echo esc_url( ab_classes_url() ); ?>"><?php esc_html_e( 'Browse all classes', 'afterbell' ); ?></a>
		</div>
	</div>
	<div class="rail">
		<?php
		while ( $ab_latest->have_posts() ) {
			$ab_latest->the_post();
			get_template_part( 'template-parts/class-card' );
		}
		wp_reset_postdata();
		?>
	</div>
</section>
<?php endif; ?>

<section class="section" id="how">
	<div class="wrap">
		<div class="section__head">
			<h2 class="section__title"><?php esc_html_e( 'How Afterbell', 'afterbell' ); ?> <em><?php esc_html_e( 'works', 'afterbell' ); ?></em></h2>
		</div>
		<ol class="steps">
			<li class="step"><span class="step__no">1</span><h3><?php esc_html_e( 'Choose a path', 'afterbell' ); ?></h3><p><?php esc_html_e( 'Pick homeschool courses, a 1:1 tutor or a leadership club. Filter by age, subject and time.', 'afterbell' ); ?></p></li>
			<li class="step"><span class="step__no">2</span><h3><?php esc_html_e( 'Meet the teacher', 'afterbell' ); ?></h3><p><?php esc_html_e( 'Every class shows the teacher, schedule, class size and full price. Tutoring starts with a trial session.', 'afterbell' ); ?></p></li>
			<li class="step"><span class="step__no">3</span><h3><?php esc_html_e( 'Learn live, grow steadily', 'afterbell' ); ?></h3><p><?php esc_html_e( 'Your child joins live sessions, finishes real work and moves one step up the path.', 'afterbell' ); ?></p></li>
		</ol>
	</div>
</section>

<section class="section section--flush">
	<div class="wrap split">
		<div class="split__card split__card--ink">
			<h2><?php esc_html_e( 'Homeschooling families', 'afterbell' ); ?></h2>
			<p><?php esc_html_e( 'Build a weekly rhythm with core academics, a tutor where it counts and one club that stretches your child.', 'afterbell' ); ?></p>
			<a class="btn btn--brass btn--arrow" href="<?php echo esc_url( ab_page_url( 'homeschool' ) ); ?>"><?php esc_html_e( 'Plan your week', 'afterbell' ); ?></a>
		</div>
		<div class="split__card split__card--brass">
			<h2><?php esc_html_e( 'Teachers and tutors', 'afterbell' ); ?></h2>
			<p><?php esc_html_e( 'Teach what you know to a small group or one learner. Set your own schedule and price.', 'afterbell' ); ?></p>
			<a class="btn btn--ink btn--arrow" href="<?php echo esc_url( ab_teacher_page_url() ); ?>"><?php esc_html_e( 'Apply to teach', 'afterbell' ); ?></a>
		</div>
	</div>
</section>

<section class="section" id="faq">
	<div class="wrap wrap--narrow">
		<div class="section__head"><h2 class="section__title"><?php esc_html_e( 'Questions parents', 'afterbell' ); ?> <em><?php esc_html_e( 'ask', 'afterbell' ); ?></em></h2></div>
		<div class="faq">
			<details><summary><?php esc_html_e( 'Can Afterbell be our whole homeschool curriculum?', 'afterbell' ); ?></summary><p><?php esc_html_e( 'Many families combine core academic courses with a tutor and a club. Rules differ by country and region, so check your local requirements. Class pages list topics and hours to help with your own records.', 'afterbell' ); ?></p></details>
			<details><summary><?php esc_html_e( 'How does 1:1 tutoring work?', 'afterbell' ); ?></summary><p><?php esc_html_e( 'Tell us your child\'s goal and age. We match a tutor, you book a trial session and then continue weekly or as needed.', 'afterbell' ); ?></p></details>
			<details><summary><?php esc_html_e( 'How big are group classes?', 'afterbell' ); ?></summary><p><?php esc_html_e( 'Each class page lists the maximum number of learners, so the teacher can give every child attention.', 'afterbell' ); ?></p></details>
			<details><summary><?php esc_html_e( 'What do we need to join?', 'afterbell' ); ?></summary><p><?php esc_html_e( 'A device with a camera, a stable connection and a quiet spot. If a class needs anything else, the class page says so.', 'afterbell' ); ?></p></details>
			<details><summary><?php esc_html_e( 'How do I become a teacher?', 'afterbell' ); ?></summary><p><?php esc_html_e( 'Send a short application from the teacher page. We read every one and reply by email.', 'afterbell' ); ?> <a href="<?php echo esc_url( ab_teacher_page_url() ); ?>"><?php esc_html_e( 'Apply to teach', 'afterbell' ); ?></a></p></details>
		</div>
	</div>
</section>

<?php
get_footer();

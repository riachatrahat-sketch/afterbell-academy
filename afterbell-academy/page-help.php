<?php
/**
 * Template Name: Help center
 *
 * @package afterbell
 */

get_header();

$ab_groups = array(
	__( 'Getting started', 'afterbell' ) => array(
		array( __( 'How do I create an account?', 'afterbell' ), __( 'Choose Join for free, create your account and tell us about your learner. It takes a few minutes.', 'afterbell' ) ),
		array( __( 'Can I add more than one child?', 'afterbell' ), __( 'Yes. Open My account, go to Learner profiles and choose Add a learner.', 'afterbell' ) ),
	),
	__( 'Classes', 'afterbell' ) => array(
		array( __( 'How do I find a class?', 'afterbell' ), __( 'Use the search bar or browse by track, subject, age and format. Every class page lists the schedule, class size and price.', 'afterbell' ) ),
		array( __( 'What do we need to join?', 'afterbell' ), __( 'A device with a camera, a stable connection and a quiet spot. Anything extra is listed on the class page.', 'afterbell' ) ),
	),
	__( '1:1 tutoring', 'afterbell' ) => array(
		array( __( 'How does tutoring work?', 'afterbell' ), __( 'Send a tutor request with your goal and times. We suggest a tutor and you start with a trial session.', 'afterbell' ) ),
	),
	__( 'Payments', 'afterbell' ) => array(
		array( __( 'How do I pay?', 'afterbell' ), __( 'Payment options are shown at checkout. If you have a question about an order, write to us.', 'afterbell' ) ),
		array( __( 'What is Membership?', 'afterbell' ), __( 'Membership is an optional monthly plan with credits you can spend on classes and sessions.', 'afterbell' ) ),
	),
	__( 'Teaching', 'afterbell' ) => array(
		array( __( 'How do I become a teacher?', 'afterbell' ), __( 'Send an application from the Become a teacher page. We read each one and reply by email.', 'afterbell' ) ),
	),
);
?>

<section class="page-head page-head--feature">
	<div class="wrap">
		<p class="eyebrow"><?php esc_html_e( 'Help center', 'afterbell' ); ?></p>
		<h1 class="page-head__title"><?php esc_html_e( 'How can we', 'afterbell' ); ?> <em><?php esc_html_e( 'help?', 'afterbell' ); ?></em></h1>
		<form class="finder" role="search" method="get" action="<?php echo esc_url( ab_classes_url() ); ?>">
			<label class="screen-reader-text" for="help-q"><?php esc_html_e( 'Search classes', 'afterbell' ); ?></label>
			<input id="help-q" type="search" name="q" placeholder="<?php esc_attr_e( 'Search classes and tutors', 'afterbell' ); ?>">
			<button class="btn btn--brass" type="submit"><?php esc_html_e( 'Search', 'afterbell' ); ?></button>
		</form>
	</div>
</section>

<section class="section section--flush">
	<div class="wrap wrap--narrow">
		<?php foreach ( $ab_groups as $title => $items ) : ?>
			<h2 class="help-h"><?php echo esc_html( $title ); ?></h2>
			<div class="faq">
				<?php foreach ( $items as $qa ) : ?>
					<details><summary><?php echo esc_html( $qa[0] ); ?></summary><p><?php echo esc_html( $qa[1] ); ?></p></details>
				<?php endforeach; ?>
			</div>
		<?php endforeach; ?>
		<div class="cta-band" style="margin-top:48px">
			<h2><?php esc_html_e( 'Still need help?', 'afterbell' ); ?></h2>
			<a class="btn btn--brass" href="mailto:<?php echo esc_attr( ab_contact_email() ); ?>"><?php echo esc_html( ab_contact_email() ); ?></a>
		</div>
	</div>
</section>

<?php
get_footer();

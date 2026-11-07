<?php
/**
 * Template Name: Membership
 *
 * @package afterbell
 */

get_header();
$ab_plans = ab_plans();
?>

<section class="page-head page-head--feature">
	<div class="wrap">
		<p class="eyebrow"><?php esc_html_e( 'Afterbell memberships', 'afterbell' ); ?></p>
		<h1 class="page-head__title"><?php esc_html_e( 'Save on classes with', 'afterbell' ); ?> <em><?php esc_html_e( 'Membership', 'afterbell' ); ?></em></h1>
		<p class="page-head__text"><?php esc_html_e( 'Pick a monthly plan, get credits and spend them on any class or tutoring session.', 'afterbell' ); ?></p>
		<a class="btn btn--brass btn--arrow" href="<?php echo esc_url( ab_checkout_url() ); ?>"><?php esc_html_e( 'Join Membership', 'afterbell' ); ?></a>
	</div>
</section>

<?php if ( $ab_plans ) : ?>
<section class="section">
	<div class="wrap">
		<div class="section__head"><h2 class="section__title"><?php esc_html_e( 'Choose a', 'afterbell' ); ?> <em><?php esc_html_e( 'plan', 'afterbell' ); ?></em></h2></div>
		<div class="plans">
			<?php foreach ( $ab_plans as $i => $p ) : ?>
				<article class="plan<?php echo 1 === $i ? ' plan--hot' : ''; ?>">
					<h3><?php echo esc_html( $p['name'] ); ?></h3>
					<p class="plan__price"><?php echo esc_html( ab_currency() . number_format_i18n( $p['price'], floor( $p['price'] ) === $p['price'] ? 0 : 2 ) ); ?><small>/<?php esc_html_e( 'month', 'afterbell' ); ?></small></p>
					<p class="plan__credits"><?php /* translators: %d: credits */ echo esc_html( sprintf( __( '%d credits each month', 'afterbell' ), (int) $p['credits'] ) ); ?></p>
					<a class="btn <?php echo 1 === $i ? 'btn--brass' : 'btn--ghost'; ?> btn--block" href="<?php echo esc_url( ab_checkout_url( $p['id'] ) ); ?>"><?php esc_html_e( 'Choose plan', 'afterbell' ); ?></a>
				</article>
			<?php endforeach; ?>
		</div>
	</div>
</section>
<?php endif; ?>

<section class="section section--tint">
	<div class="wrap">
		<div class="section__head"><h2 class="section__title"><?php esc_html_e( 'How your membership', 'afterbell' ); ?> <em><?php esc_html_e( 'works', 'afterbell' ); ?></em></h2></div>
		<ol class="steps steps--4">
			<li class="step"><span class="step__no">1</span><h3><?php esc_html_e( 'Pick a plan', 'afterbell' ); ?></h3><p><?php esc_html_e( 'Choose the monthly credits that fit your family.', 'afterbell' ); ?></p></li>
			<li class="step"><span class="step__no">2</span><h3><?php esc_html_e( 'Enroll with credits', 'afterbell' ); ?></h3><p><?php esc_html_e( 'Use credits on group classes and tutoring sessions.', 'afterbell' ); ?></p></li>
			<li class="step"><span class="step__no">3</span><h3><?php esc_html_e( 'Save every month', 'afterbell' ); ?></h3><p><?php esc_html_e( 'Members get more learning for the same budget.', 'afterbell' ); ?></p></li>
			<li class="step"><span class="step__no">4</span><h3><?php esc_html_e( 'Stay flexible', 'afterbell' ); ?></h3><p><?php esc_html_e( 'Change your plan when your needs change.', 'afterbell' ); ?></p></li>
		</ol>
	</div>
</section>

<section class="section">
	<div class="wrap wrap--narrow">
		<div class="section__head"><h2 class="section__title"><?php esc_html_e( 'Membership', 'afterbell' ); ?> <em><?php esc_html_e( 'questions', 'afterbell' ); ?></em></h2></div>
		<div class="faq">
			<details><summary><?php esc_html_e( 'What are credits?', 'afterbell' ); ?></summary><p><?php esc_html_e( 'Credits are the currency of your plan. Each class or session shows how many credits it costs.', 'afterbell' ); ?></p></details>
			<details><summary><?php esc_html_e( 'Can I change my plan?', 'afterbell' ); ?></summary><p><?php esc_html_e( 'Yes. Write to us and we will adjust your plan for the next month.', 'afterbell' ); ?></p></details>
			<details><summary><?php esc_html_e( 'Can I still pay per class?', 'afterbell' ); ?></summary><p><?php esc_html_e( 'Yes. Membership is optional, and every class can also be booked on its own.', 'afterbell' ); ?></p></details>
		</div>
	</div>
</section>

<?php
get_footer();

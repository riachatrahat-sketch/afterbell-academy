<?php
/**
 * Template Name: Join membership (checkout)
 *
 * @package afterbell
 */

$ab_plans = ab_plans();
// phpcs:ignore WordPress.Security.NonceVerification.Recommended
$ab_sel   = isset( $_GET['plan'] ) ? sanitize_key( $_GET['plan'] ) : '0';
$ab_user  = wp_get_current_user();
$ab_fmt   = function ( $n ) {
	return ab_currency() . number_format_i18n( $n, floor( $n ) === (float) $n ? 0 : 2 );
};

get_header();
?>

<section class="page-head">
	<div class="wrap">
		<p class="crumbs"><a href="<?php echo esc_url( ab_membership_url() ); ?>">&larr; <?php esc_html_e( 'Go back', 'afterbell' ); ?></a></p>
		<h1 class="page-head__title"><?php esc_html_e( 'Join Membership', 'afterbell' ); ?></h1>
	</div>
</section>

<section class="section section--flush">
	<div class="wrap">
		<?php ab_form_notice( 'sent', __( 'Thank you. We received your request and will email you to complete payment.', 'afterbell' ), __( 'We could not send that. Please check your details and try again.', 'afterbell' ) ); ?>
		<?php if ( ! $ab_plans ) : ?>
			<div class="empty"><h2><?php esc_html_e( 'Plans are coming soon', 'afterbell' ); ?></h2></div>
		<?php else : ?>
		<form class="checkout" method="post" action="<?php echo esc_url( admin_url( 'admin-post.php' ) ); ?>" data-currency="<?php echo esc_attr( ab_currency() ); ?>">
			<input type="hidden" name="action" value="ab_membership_request">
			<?php wp_nonce_field( 'ab_membership_request', 'ab_form_nonce' ); ?>
			<p class="hp" aria-hidden="true"><label for="ab_website">Website</label><input type="text" id="ab_website" name="ab_website" tabindex="-1" autocomplete="off"></p>

			<div class="checkout__main">
				<div class="co-card">
					<h2 class="co-card__title"><span id="co-num">1.</span> <span id="co-name"><?php echo esc_html( $ab_plans[0]['name'] ); ?></span> <?php esc_html_e( 'plan', 'afterbell' ); ?></h2>
					<div class="field">
						<label for="co-plan"><?php esc_html_e( 'Pick your monthly plan', 'afterbell' ); ?></label>
						<select id="co-plan" name="ab_topic">
							<?php foreach ( $ab_plans as $p ) : ?>
								<option value="<?php echo esc_attr( $p['name'] . ' (' . $p['credits'] . ' credits)' ); ?>" data-name="<?php echo esc_attr( $p['name'] ); ?>" data-price="<?php echo esc_attr( $p['price'] ); ?>" data-credits="<?php echo (int) $p['credits']; ?>" <?php selected( $ab_sel, $p['id'] ); ?>><?php echo esc_html( $p['credits'] . ' ' . __( 'credits', 'afterbell' ) . ' - ' . $ab_fmt( $p['price'] ) . '/' . __( 'month', 'afterbell' ) ); ?></option>
							<?php endforeach; ?>
						</select>
					</div>
					<ul class="co-list">
						<li><?php esc_html_e( 'Credits are spent on group classes and tutoring sessions.', 'afterbell' ); ?></li>
						<li><?php esc_html_e( 'You can ask us to change or pause your plan.', 'afterbell' ); ?></li>
					</ul>
					<details class="promo">
						<summary><?php esc_html_e( 'Add promo code', 'afterbell' ); ?></summary>
						<div class="field"><label for="co-promo"><?php esc_html_e( 'Promo code', 'afterbell' ); ?></label><input type="text" id="co-promo" name="ab_about"></div>
					</details>
				</div>

				<div class="co-card">
					<h2 class="co-card__title">2. <?php esc_html_e( 'Your details', 'afterbell' ); ?></h2>
					<div class="field"><label for="co-name-in"><?php esc_html_e( 'Your name', 'afterbell' ); ?></label><input type="text" id="co-name-in" name="ab_name" required value="<?php echo esc_attr( $ab_user->display_name ); ?>" autocomplete="name"></div>
					<div class="field"><label for="co-email"><?php esc_html_e( 'Email', 'afterbell' ); ?></label><input type="email" id="co-email" name="ab_email" required value="<?php echo esc_attr( $ab_user->user_email ); ?>" autocomplete="email"></div>
					<p class="notice"><?php esc_html_e( 'Online payment is not connected yet. Send your request and we will contact you to complete payment.', 'afterbell' ); ?></p>
					<button class="btn btn--ink btn--block" type="submit"><?php esc_html_e( 'Send membership request', 'afterbell' ); ?></button>
				</div>
			</div>

			<aside class="co-summary">
				<h2><?php esc_html_e( 'Order summary', 'afterbell' ); ?></h2>
				<div class="co-row"><span id="sum-plan"><?php echo esc_html( $ab_plans[0]['credits'] . ' ' . __( 'credits plan', 'afterbell' ) ); ?></span><span id="sum-price"><?php echo esc_html( $ab_fmt( $ab_plans[0]['price'] ) ); ?></span></div>
				<div class="co-row co-row--line"><span><?php esc_html_e( 'Subtotal', 'afterbell' ); ?></span><span id="sum-sub"><?php echo esc_html( $ab_fmt( $ab_plans[0]['price'] ) ); ?></span></div>
				<div class="co-row co-row--total"><span><?php esc_html_e( 'Total due today', 'afterbell' ); ?></span><strong id="sum-total"><?php echo esc_html( $ab_fmt( $ab_plans[0]['price'] ) ); ?></strong></div>
				<p class="co-fine"><?php esc_html_e( 'Renewal and refund terms are set by Afterbell. Please read our Terms of use.', 'afterbell' ); ?></p>
			</aside>
		</form>
		<?php endif; ?>
	</div>
</section>

<?php
get_footer();

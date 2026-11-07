<?php
/**
 * Template Name: Welcome (onboarding)
 *
 * @package afterbell
 */

if ( ! is_user_logged_in() ) {
	wp_safe_redirect( ab_signup_url() );
	exit;
}

$ab_months = array( 1 => 'January', 'February', 'March', 'April', 'May', 'June', 'July', 'August', 'September', 'October', 'November', 'December' );
$ab_year   = (int) gmdate( 'Y' );
$ab_days   = array( 'mon' => __( 'Monday', 'afterbell' ), 'tue' => __( 'Tuesday', 'afterbell' ), 'wed' => __( 'Wednesday', 'afterbell' ), 'thu' => __( 'Thursday', 'afterbell' ), 'fri' => __( 'Friday', 'afterbell' ), 'sat' => __( 'Saturday', 'afterbell' ), 'sun' => __( 'Sunday', 'afterbell' ) );

/* Time select options from 6am to 10pm. */
if ( ! function_exists( 'ab_time_options' ) ) {
function ab_time_options( $selected ) {
	$out = '';
	for ( $h = 6; $h <= 22; $h++ ) {
		$val   = sprintf( '%02d:00', $h );
		$label = ( $h % 12 ? $h % 12 : 12 ) . ':00' . ( $h < 12 ? 'am' : 'pm' );
		$out  .= '<option value="' . esc_attr( $val ) . '"' . selected( $selected, $val, false ) . '>' . esc_html( $label ) . '</option>';
	}
	return $out;
}
}

get_header();
?>

<section class="auth auth--wizard">
	<div class="auth__aside" id="wiz-aside">
		<div class="auth__aside-inner">
			<h1 id="wiz-title"><?php esc_html_e( 'Let\'s get to know your', 'afterbell' ); ?> <em><?php esc_html_e( 'kid', 'afterbell' ); ?></em></h1>
			<p id="wiz-sub"><?php esc_html_e( 'We\'ll personalize class picks for them. You can update anytime, and add more kids later.', 'afterbell' ); ?></p>
		</div>
	</div>

	<div class="auth__main">
		<form class="wiz" id="wiz" method="post" action="<?php echo esc_url( admin_url( 'admin-post.php' ) ); ?>">
			<input type="hidden" name="action" value="ab_onboard">
			<?php wp_nonce_field( 'ab_onboard' ); ?>
			<div class="wiz__top">
				<button type="button" class="wiz__back" data-prev aria-label="<?php esc_attr_e( 'Back', 'afterbell' ); ?>" hidden>&larr;</button>
				<ol class="wiz__dots" aria-hidden="true"><li class="is-on"></li><li></li><li></li><li></li><li></li></ol>
			</div>

			<fieldset class="pane" data-step="1" data-title="<?php esc_attr_e( 'Let\'s get to know your *kid*', 'afterbell' ); ?>" data-sub="<?php esc_attr_e( 'We\'ll personalize class picks for them. You can update anytime, and add more kids later.', 'afterbell' ); ?>">
				<legend class="screen-reader-text"><?php esc_html_e( 'About your learner', 'afterbell' ); ?></legend>
				<div class="field"><label for="l_name"><?php esc_html_e( 'First name', 'afterbell' ); ?></label><input type="text" id="l_name" name="l_name" required></div>
				<div class="field"><span class="label"><?php esc_html_e( 'Birthday', 'afterbell' ); ?></span>
					<div class="row2">
						<select name="l_month" aria-label="<?php esc_attr_e( 'Month', 'afterbell' ); ?>" required><option value=""><?php esc_html_e( 'Month', 'afterbell' ); ?></option><?php foreach ( $ab_months as $i => $m ) { echo '<option value="' . (int) $i . '">' . esc_html( $m ) . '</option>'; } ?></select>
						<select name="l_year" aria-label="<?php esc_attr_e( 'Year', 'afterbell' ); ?>" required><option value=""><?php esc_html_e( 'Year', 'afterbell' ); ?></option><?php for ( $y = $ab_year - 3; $y >= $ab_year - 19; $y-- ) { echo '<option value="' . (int) $y . '">' . (int) $y . '</option>'; } ?></select>
					</div>
				</div>
				<p class="pane__q"><?php esc_html_e( 'Where does your kid learn most days?', 'afterbell' ); ?></p>
				<div class="choice-cards">
					<label class="choice"><input type="radio" name="l_at" value="campus" required><span><strong><?php esc_html_e( 'On campus', 'afterbell' ); ?></strong><small><?php esc_html_e( 'Public, charter, private', 'afterbell' ); ?></small></span></label>
					<label class="choice"><input type="radio" name="l_at" value="home"><span><strong><?php esc_html_e( 'At home', 'afterbell' ); ?></strong><small><?php esc_html_e( 'Online, homeschool', 'afterbell' ); ?></small></span></label>
					<label class="choice"><input type="radio" name="l_at" value="hybrid"><span><strong><?php esc_html_e( 'Hybrid', 'afterbell' ); ?></strong><small><?php esc_html_e( 'Campus and home', 'afterbell' ); ?></small></span></label>
				</div>
			</fieldset>

			<fieldset class="pane" data-step="2" data-title="<?php esc_attr_e( 'What is your kid *interested* in, and how do they learn?', 'afterbell' ); ?>" data-sub="<?php esc_attr_e( 'Pick any topics and formats you\'d like to try.', 'afterbell' ); ?>">
				<legend class="pane__q"><?php esc_html_e( 'Select all that apply. You can update these later.', 'afterbell' ); ?></legend>
				<div class="chip-checks">
					<?php foreach ( ab_interest_options() as $k => $label ) : ?>
						<label class="chip-check"><input type="checkbox" name="l_interests[]" value="<?php echo esc_attr( $k ); ?>"><span><?php echo esc_html( $label ); ?></span></label>
					<?php endforeach; ?>
				</div>
				<p class="pane__q"><?php esc_html_e( 'What class format works best?', 'afterbell' ); ?></p>
				<label class="check"><input type="checkbox" name="l_formats[]" value="group"><span><strong><?php esc_html_e( 'Live group class', 'afterbell' ); ?></strong><small><?php esc_html_e( 'Scheduled live group meetings with a teacher', 'afterbell' ); ?></small></span></label>
				<label class="check"><input type="checkbox" name="l_formats[]" value="one_to_one"><span><strong><?php esc_html_e( '1:1 tutoring', 'afterbell' ); ?></strong><small><?php esc_html_e( 'Private sessions with a teacher', 'afterbell' ); ?></small></span></label>
			</fieldset>

			<fieldset class="pane" data-step="3" data-skip="<?php esc_attr_e( 'Prefer not to say', 'afterbell' ); ?>" data-title="<?php esc_attr_e( 'Does your kid have any *learning needs?*', 'afterbell' ); ?>" data-sub="<?php esc_attr_e( 'We\'ll keep this private and match your kid with the right classes.', 'afterbell' ); ?>">
				<legend class="pane__q"><?php esc_html_e( 'Select any options', 'afterbell' ); ?></legend>
				<label class="check"><input type="checkbox" name="l_needs[]" value="adhd"><span>ADHD</span></label>
				<label class="check"><input type="checkbox" name="l_needs[]" value="asd"><span><?php esc_html_e( 'Autism Spectrum Disorder (ASD)', 'afterbell' ); ?></span></label>
				<label class="check"><input type="checkbox" name="l_needs[]" value="dys"><span><?php esc_html_e( 'Dyslexia, Dyscalculia, or Dysgraphia', 'afterbell' ); ?></span></label>
				<label class="check"><input type="checkbox" name="l_needs[]" value="speech"><span><?php esc_html_e( 'Speech or Language Impairment', 'afterbell' ); ?></span></label>
				<label class="check"><input type="checkbox" name="l_needs[]" value="anxiety"><span><?php esc_html_e( 'Anxiety', 'afterbell' ); ?></span></label>
				<label class="check"><input type="checkbox" data-none><span><?php esc_html_e( 'None of the above', 'afterbell' ); ?></span></label>
			</fieldset>

			<fieldset class="pane" data-step="4" data-title="<?php esc_attr_e( 'When does learning fit your *kid\'s day?*', 'afterbell' ); ?>" data-sub="<?php esc_attr_e( 'Choose a preset slot or pick specific days and times. You can update this anytime.', 'afterbell' ); ?>">
				<legend class="screen-reader-text"><?php esc_html_e( 'Learning schedule', 'afterbell' ); ?></legend>
				<div class="presets">
					<label class="preset"><input type="radio" name="l_preset" value="anytime" data-from="08:00" data-to="21:00"><span><strong><?php esc_html_e( 'Anytime', 'afterbell' ); ?></strong><small>8am - 9pm</small></span></label>
					<label class="preset"><input type="radio" name="l_preset" value="school" data-from="08:00" data-to="16:00"><span><strong><?php esc_html_e( 'School hours', 'afterbell' ); ?></strong><small>8am - 4pm</small></span></label>
					<label class="preset"><input type="radio" name="l_preset" value="after" data-from="16:00" data-to="21:00" checked><span><strong><?php esc_html_e( 'After school', 'afterbell' ); ?></strong><small>4pm - 9pm</small></span></label>
				</div>
				<div class="week-rows">
					<?php foreach ( $ab_days as $k => $label ) : ?>
						<div class="week-row">
							<span><?php echo esc_html( $label ); ?></span>
							<select name="from_<?php echo esc_attr( $k ); ?>" aria-label="<?php echo esc_attr( $label . ' from' ); ?>"><?php echo ab_time_options( '16:00' ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?></select>
							<span aria-hidden="true">-</span>
							<select name="to_<?php echo esc_attr( $k ); ?>" aria-label="<?php echo esc_attr( $label . ' to' ); ?>"><?php echo ab_time_options( '21:00' ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?></select>
						</div>
					<?php endforeach; ?>
				</div>
			</fieldset>

			<fieldset class="pane" data-step="5" data-title="<?php esc_attr_e( 'Ways to *learn* on Afterbell', 'afterbell' ); ?>" data-sub="<?php esc_attr_e( 'Every family learns differently. Choose what works for you: pay as you go, or join Membership for more learning each month.', 'afterbell' ); ?>">
				<legend class="screen-reader-text"><?php esc_html_e( 'Payment style', 'afterbell' ); ?></legend>
				<div class="choice-cards">
					<label class="choice"><input type="radio" name="l_plan" value="pay" checked><span><strong><?php esc_html_e( 'Pay per class', 'afterbell' ); ?></strong><small><?php esc_html_e( 'Book and pay for each class or session as you go.', 'afterbell' ); ?></small></span></label>
					<label class="choice"><input type="radio" name="l_plan" value="member"><span><strong><?php esc_html_e( 'Join Membership', 'afterbell' ); ?></strong><small><?php esc_html_e( 'Pick a monthly plan and enroll with credits.', 'afterbell' ); ?></small></span></label>
				</div>
				<p><a class="link-arrow" href="<?php echo esc_url( ab_membership_url() ); ?>"><?php esc_html_e( 'See how Membership works', 'afterbell' ); ?></a></p>
			</fieldset>

			<div class="wiz__actions">
				<button type="button" class="btn btn--ghost" data-skip-btn hidden><?php esc_html_e( 'Not sure yet', 'afterbell' ); ?></button>
				<button type="button" class="btn btn--ink" data-next><?php esc_html_e( 'Next', 'afterbell' ); ?></button>
				<button type="submit" class="btn btn--brass" data-finish hidden><?php esc_html_e( 'Finish', 'afterbell' ); ?></button>
			</div>
		</form>
	</div>
</section>

<?php
get_footer();

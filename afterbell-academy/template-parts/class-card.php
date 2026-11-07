<?php
/**
 * Class card used in grids.
 *
 * @package afterbell
 */

$ab_id    = get_the_ID();
$ab_terms = get_the_terms( $ab_id, 'ab_subject' );
$ab_term  = ( $ab_terms && ! is_wp_error( $ab_terms ) ) ? $ab_terms[0] : null;
$ab_age   = ab_age_label( $ab_id );
$ab_grade = ab_meta( $ab_id, 'grade' );
$ab_sched = ab_meta( $ab_id, 'schedule' );
$ab_who   = ab_teacher_name( $ab_id );
$ab_tid   = ab_teacher_id( $ab_id );
$ab_cred  = ab_teacher_meta( $ab_tid, 'credential' );
$ab_wks   = (int) ab_meta( $ab_id, 'weeks' );
$ab_one   = ab_is_one_to_one( $ab_id );
?>
<article class="card tone-<?php echo (int) ( $ab_id % 6 ); ?>">
	<div class="card__top">
	<a class="card__media" href="<?php the_permalink(); ?>" tabindex="-1" aria-hidden="true">
		<?php if ( has_post_thumbnail() ) : ?>
			<?php the_post_thumbnail( 'ab-card' ); ?>
		<?php else : ?>
			<?php echo ab_subject_art( $ab_term ? $ab_term->slug : '' ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped -- static markup. ?>
		<?php endif; ?>
		<span class="badge<?php echo $ab_one ? ' badge--blue' : ''; ?>"><?php echo $ab_one ? esc_html__( '1:1 tutoring', 'afterbell' ) : esc_html__( 'Live group', 'afterbell' ); ?></span>
	</a>
	<form class="fav" method="post" action="<?php echo esc_url( admin_url( 'admin-post.php' ) ); ?>">
		<input type="hidden" name="action" value="ab_toggle_fav">
		<input type="hidden" name="post_id" value="<?php echo (int) $ab_id; ?>">
		<?php wp_nonce_field( 'ab_fav_' . $ab_id ); ?>
		<button type="submit" class="fav__btn<?php echo ab_is_fav( $ab_id ) ? ' is-on' : ''; ?>" aria-pressed="<?php echo ab_is_fav( $ab_id ) ? 'true' : 'false'; ?>" aria-label="<?php echo esc_attr( ab_is_fav( $ab_id ) ? __( 'Remove from favorites', 'afterbell' ) : __( 'Save to favorites', 'afterbell' ) ); ?>">
			<svg width="18" height="18" viewBox="0 0 24 24" aria-hidden="true"><path d="M12 21C7 17.5 2.5 13.6 2.5 9A4.5 4.5 0 0 1 12 6.7 4.5 4.5 0 0 1 21.5 9c0 4.6-4.5 8.5-9.5 12z" fill="currentColor"/></svg>
		</button>
	</form>
	</div>
	<div class="card__body">
		<?php if ( $ab_term ) : ?>
			<p class="tag"><?php echo esc_html( $ab_term->name ); ?></p>
		<?php endif; ?>
		<h3 class="card__title"><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h3>
		<ul class="card__meta">
			<?php if ( $ab_grade ) : ?><li><?php echo esc_html( $ab_grade ); ?></li><?php elseif ( $ab_age ) : ?><li><?php echo esc_html( $ab_age ); ?></li><?php endif; ?>
			<?php if ( $ab_sched ) : ?><li><?php echo esc_html( $ab_sched ); ?></li><?php endif; ?>
		</ul>
		<?php if ( $ab_who ) : ?>
			<p class="card__teacher"><span class="card__avatar" aria-hidden="true"><?php echo esc_html( ab_initial( $ab_who ) ); ?></span><span><strong><?php echo esc_html( $ab_who ); ?></strong> <?php echo $ab_tid ? ab_rating_html( $ab_tid ) : ''; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped -- escaped in helper. ?></span></p>
		<?php endif; ?>
		<?php if ( $ab_cred ) : ?><p class="chip-pill chip-pill--sm"><?php echo esc_html( $ab_cred ); ?></p><?php endif; ?>
		<div class="card__foot">
			<span class="card__price"><?php echo esc_html( ab_price( $ab_id ) ); ?><small><?php echo esc_html( ab_price_unit( $ab_id ) ); ?></small></span>
			<a class="card__more" href="<?php the_permalink(); ?>"><?php esc_html_e( 'See details', 'afterbell' ); ?> &rsaquo;</a>
		</div>
	</div>
</article>

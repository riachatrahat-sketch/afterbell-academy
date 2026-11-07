<?php
/**
 * Site footer.
 *
 * @package afterbell
 */
?>
</main>

<footer class="site-footer">
	<div class="wrap site-footer__grid">
		<div class="site-footer__about">
			<p class="brand brand--footer">Afterbell <span class="brand__tld">Academy</span></p>
			<p><?php esc_html_e( 'Homeschool classes, 1:1 tutoring and leadership clubs. From smart kid to next leader.', 'afterbell' ); ?></p>
			<p><a href="mailto:<?php echo esc_attr( ab_contact_email() ); ?>"><?php echo esc_html( ab_contact_email() ); ?></a></p>
		</div>
		<div>
			<h2 class="site-footer__title"><?php esc_html_e( 'Learn', 'afterbell' ); ?></h2>
			<ul class="footer-menu">
				<li><a href="<?php echo esc_url( ab_page_url( 'homeschool' ) ); ?>"><?php esc_html_e( 'Homeschool', 'afterbell' ); ?></a></li>
				<li><a href="<?php echo esc_url( ab_page_url( 'tutoring' ) ); ?>"><?php esc_html_e( '1:1 Tutoring', 'afterbell' ); ?></a></li>
				<li><a href="<?php echo esc_url( ab_browse_url( array( 'track' => 'leadership' ) ) ); ?>"><?php esc_html_e( 'Leadership', 'afterbell' ); ?></a></li>
				<li><a href="<?php echo esc_url( ab_page_url( 'categories' ) ); ?>"><?php esc_html_e( 'Explore categories', 'afterbell' ); ?></a></li>
				<li><a href="<?php echo esc_url( ab_page_url( 'gift-cards' ) ); ?>"><?php esc_html_e( 'Gift cards', 'afterbell' ); ?></a></li>
				<li><a href="<?php echo esc_url( ab_membership_url() ); ?>"><?php esc_html_e( 'Membership', 'afterbell' ); ?></a></li>
			</ul>
		</div>
		<div>
			<h2 class="site-footer__title"><?php esc_html_e( 'Teach and partner', 'afterbell' ); ?></h2>
			<ul class="footer-menu">
				<li><a href="<?php echo esc_url( ab_teacher_page_url() ); ?>"><?php esc_html_e( 'Become a teacher', 'afterbell' ); ?></a></li>
				<li><a href="<?php echo esc_url( ab_page_url( 'educator-library' ) ); ?>"><?php esc_html_e( 'Educator library', 'afterbell' ); ?></a></li>
				<li><a href="<?php echo esc_url( ab_page_url( 'partners' ) ); ?>"><?php esc_html_e( 'Schools and partners', 'afterbell' ); ?></a></li>
			</ul>
		</div>
		<div>
			<h2 class="site-footer__title"><?php esc_html_e( 'Company', 'afterbell' ); ?></h2>
			<ul class="footer-menu">
				<li><a href="<?php echo esc_url( ab_page_url( 'about' ) ); ?>"><?php esc_html_e( 'About', 'afterbell' ); ?></a></li>
				<li><a href="<?php echo esc_url( ab_page_url( 'blog' ) ); ?>"><?php esc_html_e( 'Blog', 'afterbell' ); ?></a></li>
				<li><a href="<?php echo esc_url( ab_page_url( 'help' ) ); ?>"><?php esc_html_e( 'Help', 'afterbell' ); ?></a></li>
				<li><a href="<?php echo esc_url( ab_page_url( 'terms' ) ); ?>"><?php esc_html_e( 'Terms of use', 'afterbell' ); ?></a></li>
				<li><a href="<?php echo esc_url( ab_page_url( 'privacy' ) ); ?>"><?php esc_html_e( 'Privacy policy', 'afterbell' ); ?></a></li>
				<li><a href="<?php echo esc_url( ab_page_url( 'childrens-privacy' ) ); ?>"><?php esc_html_e( 'Children\'s privacy', 'afterbell' ); ?></a></li>
			</ul>
		</div>
	</div>
	<div class="wrap site-footer__browse">
		<div>
			<h2 class="site-footer__title"><?php esc_html_e( 'Classes by age', 'afterbell' ); ?></h2>
			<ul class="age-links">
				<?php for ( $a = 3; $a <= 18; $a++ ) : ?>
					<li><a href="<?php echo esc_url( ab_browse_url( array( 'age' => $a ) ) ); ?>"><?php echo (int) $a; ?></a></li>
				<?php endfor; ?>
			</ul>
		</div>
		<div>
			<h2 class="site-footer__title"><?php esc_html_e( 'Tutoring', 'afterbell' ); ?></h2>
			<ul class="age-links age-links--text">
				<?php
				foreach ( array( 'math' => __( 'Math', 'afterbell' ), 'english' => __( 'English', 'afterbell' ), 'science' => __( 'Science', 'afterbell' ), 'social-studies' => __( 'History', 'afterbell' ), 'languages' => __( 'Languages', 'afterbell' ), 'coding' => __( 'Coding', 'afterbell' ), 'speaking' => __( 'Public speaking', 'afterbell' ) ) as $slug => $label ) {
					echo '<li><a href="' . esc_url( ab_browse_url( array( 'format' => 'one_to_one', 'subj' => $slug ) ) ) . '">' . esc_html( $label ) . '</a></li>';
				}
				?>
			</ul>
		</div>
	</div>
	<div class="wrap site-footer__base">
		<p>&copy; <?php echo esc_html( gmdate( 'Y' ) ); ?> <?php bloginfo( 'name' ); ?>. <?php esc_html_e( 'All rights reserved.', 'afterbell' ); ?></p>
	</div>
	<p class="site-footer__mark" aria-hidden="true">Afterbell</p>
</footer>

<?php wp_footer(); ?>
</body>
</html>

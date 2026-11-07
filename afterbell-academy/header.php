<?php
/**
 * Site header.
 *
 * @package afterbell
 */

$ab_in       = is_user_logged_in();
$ab_learners = $ab_in ? ab_learners() : array();
$ab_ph       = ( 1 === count( $ab_learners ) )
	/* translators: %s: learner name */
	? sprintf( __( 'Find %s\'s next class', 'afterbell' ), $ab_learners[0]['name'] )
	: __( 'Search classes and tutors', 'afterbell' );
?><!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
	<meta charset="<?php bloginfo( 'charset' ); ?>">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<?php wp_head(); ?>
</head>
<body <?php body_class(); ?>>
<?php wp_body_open(); ?>
<a class="skip-link" href="#main"><?php esc_html_e( 'Skip to content', 'afterbell' ); ?></a>

<header class="site-header">
	<div class="wrap site-header__inner">
		<a class="brand" href="<?php echo esc_url( home_url( '/' ) ); ?>" aria-label="<?php echo esc_attr( get_bloginfo( 'name' ) ); ?>">
			<?php if ( has_custom_logo() ) : ?>
				<?php the_custom_logo(); ?>
			<?php else : ?>
				<svg class="brand__bell" width="28" height="28" viewBox="0 0 28 28" aria-hidden="true"><path d="M14 3a1.6 1.6 0 0 1 1.6 1.6v.6c3.3.8 5.4 3.7 5.4 7.2v3.5l2 3.2c.4.7 0 1.5-.8 1.5H5.8c-.8 0-1.2-.8-.8-1.5l2-3.2v-3.5c0-3.5 2.1-6.4 5.4-7.2v-.6A1.6 1.6 0 0 1 14 3Z" fill="currentColor"/><path d="M11.2 23.2a2.9 2.9 0 0 0 5.6 0Z" fill="currentColor"/></svg>
				<span class="brand__text">Afterbell <span class="brand__tld">Academy</span></span>
			<?php endif; ?>
		</a>

		<button class="search-toggle" type="button" aria-expanded="false" aria-controls="m-search">
			<span class="screen-reader-text"><?php esc_html_e( 'Search', 'afterbell' ); ?></span>
			<svg width="20" height="20" viewBox="0 0 24 24" aria-hidden="true"><circle cx="11" cy="11" r="7" fill="none" stroke="currentColor" stroke-width="2.2"/><path d="M16.500 16.500L21 21" stroke="currentColor" stroke-width="2.2" stroke-linecap="round"/></svg>
		</button>

		<button class="nav-toggle" type="button" aria-expanded="false" aria-controls="primary-nav">
			<span class="screen-reader-text"><?php esc_html_e( 'Menu', 'afterbell' ); ?></span>
			<span class="nav-toggle__bars" aria-hidden="true"></span>
		</button>

		<nav id="primary-nav" class="primary-nav" aria-label="<?php esc_attr_e( 'Primary', 'afterbell' ); ?>">
			<?php
			wp_nav_menu( array(
				'theme_location' => 'primary',
				'container'      => false,
				'menu_class'     => 'menu',
				'depth'          => 1,
				'fallback_cb'    => 'ab_fallback_menu',
			) );
			?>
			<form class="header-search" role="search" method="get" action="<?php echo esc_url( ab_classes_url() ); ?>">
				<?php if ( $ab_in ) : ?>
					<details class="scope">
						<summary><?php esc_html_e( 'All classes', 'afterbell' ); ?></summary>
						<div class="scope__menu">
							<p class="scope__item is-on"><strong><?php esc_html_e( 'All classes', 'afterbell' ); ?></strong><span><?php esc_html_e( 'Search classes for any learner', 'afterbell' ); ?></span></p>
							<?php foreach ( $ab_learners as $l ) : ?>
								<a class="scope__item" href="<?php echo esc_url( ab_browse_url( array( 'age' => (int) $l['age'] ) ) ); ?>"><strong><?php echo esc_html( $l['name'] ); ?><?php echo ! empty( $l['age'] ) ? ' (' . (int) $l['age'] . ')' : ''; ?></strong><span><?php /* translators: %d: percent */ echo esc_html( sprintf( __( 'Profile %d%% complete', 'afterbell' ), ab_learner_progress( $l ) ) ); ?></span></a>
							<?php endforeach; ?>
							<a class="scope__add" href="<?php echo esc_url( add_query_arg( 'tab', 'learners', ab_account_url() ) ); ?>"><?php esc_html_e( 'Add a learner', 'afterbell' ); ?> +</a>
						</div>
					</details>
				<?php endif; ?>
				<label class="screen-reader-text" for="header-q"><?php esc_html_e( 'Search classes and tutors', 'afterbell' ); ?></label>
				<input id="header-q" type="search" name="q" placeholder="<?php echo esc_attr( $ab_ph ); ?>">
			</form>

			<?php if ( $ab_in ) : ?>
				<ul class="user-nav">
					<li><a href="<?php echo esc_url( ab_page_url( 'help' ) ); ?>" title="<?php esc_attr_e( 'Help', 'afterbell' ); ?>"><svg width="22" height="22" viewBox="0 0 24 24" aria-hidden="true"><circle cx="12" cy="12" r="9" fill="none" stroke="currentColor" stroke-width="2"/><path d="M9.500 9.500a2.500 2.500 0 1 1 3.500 2.300c-.7.400-1 .9-1 1.700M12 16.800v.2" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"/></svg><span><?php esc_html_e( 'Help', 'afterbell' ); ?></span></a></li>
					<li><a href="<?php echo esc_url( add_query_arg( 'tab', 'messages', ab_account_url() ) ); ?>" title="<?php esc_attr_e( 'Messages', 'afterbell' ); ?>"><svg width="22" height="22" viewBox="0 0 24 24" aria-hidden="true"><path d="M4 5h16v11H9l-5 4z" fill="none" stroke="currentColor" stroke-width="2" stroke-linejoin="round"/></svg><span><?php esc_html_e( 'Messages', 'afterbell' ); ?></span></a></li>
					<li><a href="<?php echo esc_url( ab_account_url() ); ?>" title="<?php esc_attr_e( 'My profile', 'afterbell' ); ?>"><span class="user-nav__avatar"><?php echo esc_html( ab_initial( wp_get_current_user()->display_name ) ); ?></span><span><?php esc_html_e( 'My profile', 'afterbell' ); ?></span></a></li>
					<li>
						<details class="menu-pop">
							<summary aria-label="<?php esc_attr_e( 'More', 'afterbell' ); ?>"><span class="menu-pop__bars" aria-hidden="true"></span></summary>
							<div class="menu-pop__panel">
								<a href="<?php echo esc_url( ab_teacher_page_url() ); ?>"><?php esc_html_e( 'Teach on Afterbell', 'afterbell' ); ?></a>
								<a href="<?php echo esc_url( ab_page_url( 'gift-cards' ) ); ?>"><?php esc_html_e( 'Give a gift card', 'afterbell' ); ?></a>
								<a href="<?php echo esc_url( ab_page_url( 'refer' ) ); ?>"><?php esc_html_e( 'Refer and earn', 'afterbell' ); ?></a>
								<hr>
								<a href="<?php echo esc_url( ab_page_url( 'settings' ) ); ?>"><?php esc_html_e( 'Settings', 'afterbell' ); ?></a>
								<a href="<?php echo esc_url( ab_page_url( 'help' ) ); ?>"><?php esc_html_e( 'Help', 'afterbell' ); ?></a>
								<a href="<?php echo esc_url( wp_logout_url( home_url( '/' ) ) ); ?>"><?php esc_html_e( 'Log out', 'afterbell' ); ?></a>
							</div>
						</details>
					</li>
				</ul>
			<?php else : ?>
				<a class="nav-link-teach" href="<?php echo esc_url( ab_login_url() ); ?>"><?php esc_html_e( 'Log in', 'afterbell' ); ?></a>
				<a class="btn btn--brass btn--small" href="<?php echo esc_url( ab_signup_url() ); ?>"><?php esc_html_e( 'Join for free', 'afterbell' ); ?></a>
			<?php endif; ?>
		</nav>
	</div>

	<form class="m-search" id="m-search" role="search" method="get" action="<?php echo esc_url( ab_classes_url() ); ?>" hidden>
		<label class="screen-reader-text" for="m-search-q"><?php esc_html_e( 'Search classes and tutors', 'afterbell' ); ?></label>
		<input id="m-search-q" type="search" name="q" placeholder="<?php echo esc_attr( $ab_ph ); ?>" autocomplete="off">
		<button class="m-search__go" type="submit" aria-label="<?php esc_attr_e( 'Search', 'afterbell' ); ?>"><svg width="20" height="20" viewBox="0 0 24 24" aria-hidden="true"><circle cx="11" cy="11" r="7" fill="none" stroke="currentColor" stroke-width="2.2"/><path d="M16.500 16.500L21 21" stroke="currentColor" stroke-width="2.2" stroke-linecap="round"/></svg></button>
		<button class="m-search__close" type="button" data-search-close aria-label="<?php esc_attr_e( 'Close search', 'afterbell' ); ?>">&times;</button>
	</form>
</header>

<main id="main" class="site-main">

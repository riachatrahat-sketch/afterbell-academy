<?php
/**
 * Afterbell Academy theme functions.
 *
 * @package afterbell
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

define( 'AB_VERSION', '5.2.3' );

/* -------------------------------------------------------------------------
 * Setup
 * ---------------------------------------------------------------------- */
add_action( 'after_setup_theme', function () {
	load_theme_textdomain( 'afterbell', get_template_directory() . '/languages' );
	add_theme_support( 'title-tag' );
	add_theme_support( 'post-thumbnails' );
	add_theme_support( 'automatic-feed-links' );
	add_theme_support( 'responsive-embeds' );
	add_theme_support( 'html5', array( 'search-form', 'comment-form', 'comment-list', 'gallery', 'caption', 'style', 'script' ) );
	add_theme_support( 'custom-logo', array(
		'height'      => 48,
		'width'       => 220,
		'flex-height' => true,
		'flex-width'  => true,
	) );
	add_image_size( 'ab-card', 640, 400, true );
	register_nav_menus( array(
		'primary' => __( 'Primary menu', 'afterbell' ),
		'footer'  => __( 'Footer menu', 'afterbell' ),
	) );
} );

add_action( 'wp_enqueue_scripts', function () {
	wp_enqueue_style(
		'ab-fonts',
		'https://fonts.googleapis.com/css2?family=Bricolage+Grotesque:opsz,wght@12..96,500;12..96,700;12..96,800&family=Figtree:wght@400;500;600;700&family=Instrument+Serif:ital@1&display=swap',
		array(),
		null
	);
	wp_enqueue_style( 'ab-style', get_stylesheet_uri(), array( 'ab-fonts' ), AB_VERSION . '.' . filemtime( get_template_directory() . '/style.css' ) );
	wp_enqueue_script( 'ab-main', get_template_directory_uri() . '/assets/js/main.js', array(), AB_VERSION . '.' . filemtime( get_template_directory() . '/assets/js/main.js' ), true );
} );

/* -------------------------------------------------------------------------
 * Post type and taxonomies
 * ---------------------------------------------------------------------- */
function ab_tracks() {
	return array(
		'homeschool-academics' => __( 'Homeschool Academics', 'afterbell' ),
		'tutoring'             => __( '1:1 Tutoring', 'afterbell' ),
		'leadership'           => __( 'Leadership and Life Skills', 'afterbell' ),
		'enrichment'           => __( 'Enrichment and Clubs', 'afterbell' ),
	);
}

add_action( 'init', function () {
	register_post_type( 'ab_class', array(
		'labels'        => array(
			'name'          => __( 'Classes', 'afterbell' ),
			'singular_name' => __( 'Class', 'afterbell' ),
			'add_new_item'  => __( 'Add new class', 'afterbell' ),
			'edit_item'     => __( 'Edit class', 'afterbell' ),
			'all_items'     => __( 'All classes', 'afterbell' ),
			'search_items'  => __( 'Search classes', 'afterbell' ),
			'not_found'     => __( 'No classes found.', 'afterbell' ),
		),
		'public'        => true,
		'has_archive'   => 'classes',
		'rewrite'       => array( 'slug' => 'class', 'with_front' => false ),
		'menu_icon'     => 'dashicons-welcome-learn-more',
		'menu_position' => 5,
		'show_in_rest'  => true,
		'supports'      => array( 'title', 'editor', 'thumbnail', 'excerpt' ),
	) );

	register_taxonomy( 'ab_track', 'ab_class', array(
		'labels'            => array(
			'name'          => __( 'Tracks', 'afterbell' ),
			'singular_name' => __( 'Track', 'afterbell' ),
			'add_new_item'  => __( 'Add new track', 'afterbell' ),
		),
		'hierarchical'      => true,
		'public'            => true,
		'show_in_rest'      => true,
		'show_admin_column' => true,
		'rewrite'           => array( 'slug' => 'track', 'with_front' => false ),
	) );

	register_taxonomy( 'ab_subject', 'ab_class', array(
		'labels'            => array(
			'name'          => __( 'Subjects', 'afterbell' ),
			'singular_name' => __( 'Subject', 'afterbell' ),
			'add_new_item'  => __( 'Add new subject', 'afterbell' ),
		),
		'hierarchical'      => true,
		'public'            => true,
		'show_in_rest'      => true,
		'show_admin_column' => true,
		'rewrite'           => array( 'slug' => 'subject', 'with_front' => false ),
	) );

	register_post_type( 'ab_teacher', array(
		'labels'        => array(
			'name'          => __( 'Teachers', 'afterbell' ),
			'singular_name' => __( 'Teacher', 'afterbell' ),
			'add_new_item'  => __( 'Add new teacher', 'afterbell' ),
			'edit_item'     => __( 'Edit teacher', 'afterbell' ),
		),
		'public'        => true,
		'has_archive'   => false,
		'rewrite'       => array( 'slug' => 'teacher', 'with_front' => false ),
		'menu_icon'     => 'dashicons-groups',
		'menu_position' => 6,
		'show_in_rest'  => true,
		'supports'      => array( 'title', 'editor', 'thumbnail' ),
	) );
} );

add_action( 'after_switch_theme', function () {
	// Taxonomies are registered on init, which has already run when this fires in most setups.
	flush_rewrite_rules();
	ab_seed_demo_content();
} );

/* -------------------------------------------------------------------------
 * Class details meta box
 * ---------------------------------------------------------------------- */
function ab_meta_fields() {
	return array(
		'format'      => array(
			'label'   => __( 'Format', 'afterbell' ),
			'type'    => 'select',
			'options' => array(
				'group'      => __( 'Live group class', 'afterbell' ),
				'one_to_one' => __( '1:1 tutoring', 'afterbell' ),
			),
		),
		'price'       => array( 'label' => __( 'Price', 'afterbell' ), 'type' => 'number', 'help' => __( 'Numbers only. Currency is set in Customizer.', 'afterbell' ) ),
		'price_unit'  => array( 'label' => __( 'Price unit', 'afterbell' ), 'type' => 'text', 'help' => __( 'Example: per session, per 8-week course. Leave empty for the default.', 'afterbell' ) ),
		'age_min'     => array( 'label' => __( 'Youngest age', 'afterbell' ), 'type' => 'number' ),
		'age_max'     => array( 'label' => __( 'Oldest age', 'afterbell' ), 'type' => 'number' ),
		'grade'       => array( 'label' => __( 'Grade level', 'afterbell' ), 'type' => 'text', 'help' => __( 'Example: Grades 3 to 5', 'afterbell' ) ),
		'schedule'    => array( 'label' => __( 'Schedule', 'afterbell' ), 'type' => 'text', 'help' => __( 'Example: Tue and Thu, 5:00 PM', 'afterbell' ) ),
		'duration'    => array( 'label' => __( 'Length of each session', 'afterbell' ), 'type' => 'text', 'help' => __( 'Example: 45 minutes', 'afterbell' ) ),
		'weeks'       => array( 'label' => __( 'Number of weeks', 'afterbell' ), 'type' => 'number' ),
		'seats'       => array( 'label' => __( 'Learners per class', 'afterbell' ), 'type' => 'number' ),
		'teacher_id'  => array( 'label' => __( 'Teacher', 'afterbell' ), 'type' => 'select', 'options' => ab_teacher_options(), 'help' => __( 'Choose from Teachers. Add teachers under Teachers in the admin menu.', 'afterbell' ) ),
		'teacher'     => array( 'label' => __( 'Teacher name (if not in the list)', 'afterbell' ), 'type' => 'text' ),
		'outcomes'    => array( 'label' => __( 'What learners will do (one per line)', 'afterbell' ), 'type' => 'textarea' ),
		'prerequisites' => array( 'label' => __( 'Prerequisites', 'afterbell' ), 'type' => 'text' ),
		'needs_support' => array( 'label' => __( 'Learning needs support', 'afterbell' ), 'type' => 'text', 'help' => __( 'Example: Supports ADHD, Dyslexia', 'afterbell' ) ),
		'supplies'    => array( 'label' => __( 'Supplies or parental guidance', 'afterbell' ), 'type' => 'text' ),
		'enroll_url'  => array( 'label' => __( 'Enroll link', 'afterbell' ), 'type' => 'url', 'help' => __( 'Checkout or booking URL. Leave empty to send enquiries to the contact email.', 'afterbell' ) ),
	);
}

add_action( 'add_meta_boxes', function () {
	add_meta_box( 'ab_class_details', __( 'Class details', 'afterbell' ), 'ab_render_meta_box', 'ab_class', 'normal', 'high' );
} );

function ab_render_meta_box( $post ) {
	wp_nonce_field( 'ab_save_class', 'ab_class_nonce' );
	echo '<div style="display:grid;grid-template-columns:repeat(2,minmax(0,1fr));gap:12px 20px">';
	foreach ( ab_meta_fields() as $key => $f ) {
		$val  = get_post_meta( $post->ID, '_ab_' . $key, true );
		$full = in_array( $f['type'], array( 'textarea', 'url' ), true ) ? 'grid-column:1/-1;' : '';
		echo '<p style="margin:0;' . esc_attr( $full ) . '"><label for="ab_' . esc_attr( $key ) . '"><strong>' . esc_html( $f['label'] ) . '</strong></label><br>';
		if ( 'textarea' === $f['type'] ) {
			echo '<textarea class="widefat" rows="3" id="ab_' . esc_attr( $key ) . '" name="ab_' . esc_attr( $key ) . '">' . esc_textarea( $val ) . '</textarea>';
		} elseif ( 'select' === $f['type'] ) {
			echo '<select class="widefat" id="ab_' . esc_attr( $key ) . '" name="ab_' . esc_attr( $key ) . '">';
			foreach ( $f['options'] as $ov => $ol ) {
				echo '<option value="' . esc_attr( $ov ) . '"' . selected( $val ? $val : (string) array_key_first( $f['options'] ), $ov, false ) . '>' . esc_html( $ol ) . '</option>';
			}
			echo '</select>';
		} else {
			echo '<input class="widefat" type="' . esc_attr( $f['type'] ) . '" id="ab_' . esc_attr( $key ) . '" name="ab_' . esc_attr( $key ) . '" value="' . esc_attr( $val ) . '"' . ( 'number' === $f['type'] ? ' step="any" min="0"' : '' ) . '>';
		}
		if ( ! empty( $f['help'] ) ) {
			echo '<span class="description">' . esc_html( $f['help'] ) . '</span>';
		}
		echo '</p>';
	}
	echo '</div>';
}

add_action( 'save_post_ab_class', function ( $post_id ) {
	if ( ! isset( $_POST['ab_class_nonce'] ) || ! wp_verify_nonce( sanitize_key( $_POST['ab_class_nonce'] ), 'ab_save_class' ) ) {
		return;
	}
	if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) {
		return;
	}
	if ( ! current_user_can( 'edit_post', $post_id ) ) {
		return;
	}
	foreach ( ab_meta_fields() as $key => $f ) {
		$raw = isset( $_POST[ 'ab_' . $key ] ) ? wp_unslash( $_POST[ 'ab_' . $key ] ) : '';
		switch ( $f['type'] ) {
			case 'url':
				$val = esc_url_raw( $raw );
				break;
			case 'textarea':
				$val = sanitize_textarea_field( $raw );
				break;
			case 'select':
				$val = isset( $f['options'][ $raw ] ) ? $raw : (string) array_key_first( $f['options'] );
				break;
			case 'number':
				$val = '' === $raw ? '' : (string) abs( (float) $raw );
				break;
			default:
				$val = sanitize_text_field( $raw );
		}
		update_post_meta( $post_id, '_ab_' . $key, $val );
	}
} );

/* -------------------------------------------------------------------------
 * Helpers
 * ---------------------------------------------------------------------- */
function ab_meta( $id, $key, $default = '' ) {
	$v = get_post_meta( $id, '_ab_' . $key, true );
	return ( '' === $v || false === $v ) ? $default : $v;
}

function ab_currency() {
	return get_theme_mod( 'ab_currency', '$' );
}

function ab_is_one_to_one( $id ) {
	return 'one_to_one' === ab_meta( $id, 'format', 'group' );
}

function ab_price( $id ) {
	$p = ab_meta( $id, 'price' );
	if ( '' === $p ) {
		return __( 'Free', 'afterbell' );
	}
	$p = (float) $p;
	return ab_currency() . number_format_i18n( $p, floor( $p ) === $p ? 0 : 2 );
}

function ab_price_unit( $id ) {
	$u = ab_meta( $id, 'price_unit' );
	if ( $u ) {
		return $u;
	}
	return ab_is_one_to_one( $id ) ? __( 'per session', 'afterbell' ) : __( 'per learner', 'afterbell' );
}

function ab_age_label( $id ) {
	$min = ab_meta( $id, 'age_min' );
	$max = ab_meta( $id, 'age_max' );
	if ( '' === $min && '' === $max ) {
		return '';
	}
	if ( '' === $max || $min === $max ) {
		/* translators: %s: age */
		return sprintf( __( 'Age %s', 'afterbell' ), (int) $min );
	}
	/* translators: 1: youngest age, 2: oldest age */
	return sprintf( __( 'Ages %1$d to %2$d', 'afterbell' ), (int) $min, (int) $max );
}


/* Wrap *words* in <em> for the headline accent. */
function ab_emphasize( $text ) {
	return preg_replace( '/\*(.+?)\*/', '<em>$1</em>', esc_html( $text ) );
}

/* Small illustration per subject, drawn with the card tone colors. */
function ab_subject_art( $slug ) {
	$art = array(
		'math'           => '<circle class="a1" cx="86" cy="82" r="50"/><path class="s" d="M62 82h48M86 58v48"/><rect class="a2" x="170" y="40" width="110" height="104" rx="30"/><path class="s" d="M198 80h54M198 104h54"/><circle class="a3" cx="150" cy="168" r="11"/>',
		'english'        => '<rect class="a1" x="64" y="38" width="190" height="130" rx="26"/><path class="s" d="M96 80h126M96 106h126M96 132h70"/><circle class="a2" cx="248" cy="44" r="28"/><path class="s" d="M238 44h20"/>',
		'science'        => '<path class="a2" d="M136 24h48v54l44 78a20 20 0 0 1-17 30H109a20 20 0 0 1-17-30l44-78z"/><path class="a1" d="M110 138h100l18 32a20 20 0 0 1-17 24H109a20 20 0 0 1-17-24z"/><circle class="a3" cx="262" cy="62" r="11"/><circle class="a1" cx="282" cy="104" r="8"/><circle class="a1" cx="60" cy="56" r="9"/>',
		'social-studies' => '<circle class="a1" cx="160" cy="100" r="72"/><path class="s" d="M88 100h144M160 28c-32 32-32 112 0 144M160 28c32 32 32 112 0 144"/><circle class="a2" cx="258" cy="46" r="20"/>',
		'languages'      => '<rect class="a1" x="46" y="34" width="136" height="84" rx="28"/><rect class="a2" x="138" y="82" width="136" height="84" rx="28"/><path class="s" d="M78 76h72M170 124h72"/>',
		'coding'         => '<rect class="a1" x="44" y="34" width="232" height="134" rx="28"/><path class="s" d="M110 82l-32 26 32 26M210 82l32 26-32 26M176 70l-32 76"/><circle class="a2" cx="266" cy="30" r="14"/>',
		'speaking'       => '<rect class="a1" x="122" y="22" width="76" height="106" rx="38"/><path class="s" d="M88 104a72 72 0 0 0 144 0M160 176v20"/><circle class="a2" cx="258" cy="58" r="15"/><circle class="a2" cx="64" cy="58" r="11"/>',
		'business'       => '<rect class="a1" x="56" y="112" width="48" height="72" rx="12"/><rect class="a2" x="120" y="80" width="48" height="104" rx="12"/><rect class="a1" x="184" y="48" width="48" height="136" rx="12"/><circle class="a3" cx="262" cy="44" r="22"/><path class="s" d="M254 44h16"/>',
		'logic'          => '<circle class="a1" cx="160" cy="62" r="32"/><path class="a1" d="M130 166c0-40 12-58 30-58s30 18 30 58z"/><rect class="a2" x="104" y="166" width="112" height="24" rx="12"/><rect class="a2" x="50" y="40" width="30" height="30" rx="6"/><rect class="a2" x="250" y="110" width="30" height="30" rx="6"/>',
	);
	$default = '<circle class="a1" cx="96" cy="102" r="54"/><circle class="a2" cx="206" cy="68" r="36"/><rect class="a2" x="196" y="118" width="64" height="64" rx="20"/><path class="s" d="M70 102h52M96 76v52"/>';
	$inner   = isset( $art[ $slug ] ) ? $art[ $slug ] : $default;
	return '<svg class="card__art" viewBox="0 0 320 200" preserveAspectRatio="xMidYMid slice" aria-hidden="true" focusable="false">' . $inner . '</svg>';
}

function ab_contact_email() {
	return sanitize_email( get_theme_mod( 'ab_contact_email', get_option( 'admin_email' ) ) );
}

function ab_classes_url() {
	return get_post_type_archive_link( 'ab_class' );
}

function ab_browse_url( $args = array() ) {
	return add_query_arg( $args, ab_classes_url() );
}

function ab_page_url( $slug ) {
	$page = get_page_by_path( $slug );
	return $page ? get_permalink( $page ) : home_url( '/' . $slug . '/' );
}

function ab_teacher_page_url() {
	return ab_page_url( 'become-a-teacher' );
}

function ab_age_bands() {
	return array(
		'early'      => array( 3, 5, __( 'Early learners', 'afterbell' ) ),
		'elementary' => array( 6, 10, __( 'Elementary', 'afterbell' ) ),
		'middle'     => array( 11, 13, __( 'Middle school', 'afterbell' ) ),
		'high'       => array( 14, 18, __( 'High school', 'afterbell' ) ),
	);
}


/* -------------------------------------------------------------------------
 * Teachers
 * ---------------------------------------------------------------------- */
function ab_teacher_options() {
	$opts = array( '' => __( 'None', 'afterbell' ) );
	if ( function_exists( 'is_admin' ) && is_admin() ) {
		foreach ( get_posts( array( 'post_type' => 'ab_teacher', 'numberposts' => 200, 'orderby' => 'title', 'order' => 'ASC' ) ) as $t ) {
			$opts[ (string) $t->ID ] = $t->post_title;
		}
	}
	return $opts;
}

add_action( 'add_meta_boxes', function () {
	add_meta_box( 'ab_teacher_details', __( 'Teacher details', 'afterbell' ), 'ab_render_teacher_box', 'ab_teacher', 'normal', 'high' );
} );

function ab_teacher_fields() {
	return array(
		'headline'   => __( 'Headline', 'afterbell' ),
		'credential' => __( 'Credential or experience', 'afterbell' ),
		'rating'     => __( 'Rating (0 to 5, leave empty if none)', 'afterbell' ),
		'reviews'    => __( 'Number of reviews', 'afterbell' ),
	);
}

function ab_render_teacher_box( $post ) {
	wp_nonce_field( 'ab_save_teacher', 'ab_teacher_nonce' );
	foreach ( ab_teacher_fields() as $k => $label ) {
		$v = get_post_meta( $post->ID, '_abt_' . $k, true );
		echo '<p><label for="abt_' . esc_attr( $k ) . '"><strong>' . esc_html( $label ) . '</strong></label><br><input class="widefat" type="text" id="abt_' . esc_attr( $k ) . '" name="abt_' . esc_attr( $k ) . '" value="' . esc_attr( $v ) . '"></p>';
	}
	echo '<p class="description">' . esc_html__( 'The biography is the main editor above. The photo is the featured image.', 'afterbell' ) . '</p>';
}

add_action( 'save_post_ab_teacher', function ( $post_id ) {
	if ( ! isset( $_POST['ab_teacher_nonce'] ) || ! wp_verify_nonce( sanitize_key( $_POST['ab_teacher_nonce'] ), 'ab_save_teacher' ) ) {
		return;
	}
	if ( ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) || ! current_user_can( 'edit_post', $post_id ) ) {
		return;
	}
	foreach ( array_keys( ab_teacher_fields() ) as $k ) {
		$v = isset( $_POST[ 'abt_' . $k ] ) ? sanitize_text_field( wp_unslash( $_POST[ 'abt_' . $k ] ) ) : '';
		update_post_meta( $post_id, '_abt_' . $k, $v );
	}
} );

function ab_teacher_id( $class_id ) {
	return (int) ab_meta( $class_id, 'teacher_id', 0 );
}

function ab_teacher_name( $class_id ) {
	$tid = ab_teacher_id( $class_id );
	if ( $tid && get_post_status( $tid ) ) {
		return get_the_title( $tid );
	}
	return ab_meta( $class_id, 'teacher' );
}

function ab_teacher_meta( $tid, $key ) {
	return $tid ? get_post_meta( $tid, '_abt_' . $key, true ) : '';
}

function ab_rating_html( $tid ) {
	$r = (float) ab_teacher_meta( $tid, 'rating' );
	if ( $r <= 0 ) {
		return '';
	}
	$n = (int) ab_teacher_meta( $tid, 'reviews' );
	return '<span class="rating"><svg width="14" height="14" viewBox="0 0 24 24" aria-hidden="true"><path d="M12 2l3 6.6 7.2.8-5.400 4.900 1.500 7.100L12 17.800 5.700 21.400l1.500-7.100L1.800 9.400 9 8.600z" fill="currentColor"/></svg> ' . esc_html( number_format_i18n( $r, 1 ) ) . ( $n ? ' <small>(' . esc_html( number_format_i18n( $n ) ) . ')</small>' : '' ) . '</span>';
}

function ab_initial( $name ) {
	return mb_strtoupper( mb_substr( trim( (string) $name ), 0, 1 ) );
}

/* -------------------------------------------------------------------------
 * Site URLs for account pages
 * ---------------------------------------------------------------------- */
function ab_login_url( $redirect = '' ) {
	$u = ab_page_url( 'log-in' );
	return $redirect ? add_query_arg( 'redirect_to', rawurlencode( $redirect ), $u ) : $u;
}
function ab_signup_url() { return ab_page_url( 'sign-up' ); }
function ab_welcome_url() { return ab_page_url( 'welcome' ); }
function ab_membership_url() { return ab_page_url( 'membership' ); }
function ab_checkout_url( $plan = '' ) {
	$u = ab_page_url( 'membership-checkout' );
	return $plan ? add_query_arg( 'plan', $plan, $u ) : $u;
}

/* Membership plans: one per line, "Name|credits|price". Sample values, edit in Customizer. */
function ab_plans() {
	$raw   = get_theme_mod( 'ab_plans', "Starter|40|20\nStandard|80|40\nPlus|160|78" );
	$plans = array();
	foreach ( preg_split( '/\r\n|\r|\n/', (string) $raw ) as $i => $line ) {
		$p = array_map( 'trim', explode( '|', $line ) );
		if ( count( $p ) >= 3 && '' !== $p[0] ) {
			$plans[] = array( 'id' => (string) $i, 'name' => $p[0], 'credits' => (int) $p[1], 'price' => (float) $p[2] );
		}
	}
	return $plans;
}

function ab_user_tz() {
	$tz = get_user_meta( get_current_user_id(), 'ab_tz', true );
	return $tz ? $tz : 'UTC';
}

function ab_learner_progress( $l ) {
	$done = 0;
	foreach ( array( 'name', 'age', 'grade', 'interests', 'schedule' ) as $k ) {
		if ( ! empty( $l[ $k ] ) ) {
			$done++;
		}
	}
	return (int) round( $done / 5 * 100 );
}

function ab_interest_options() {
	return array(
		'english'   => __( 'English', 'afterbell' ),
		'math'      => __( 'Math', 'afterbell' ),
		'science'   => __( 'Science and nature', 'afterbell' ),
		'social-studies' => __( 'Social studies', 'afterbell' ),
		'languages' => __( 'World languages', 'afterbell' ),
		'coding'    => __( 'Coding and tech', 'afterbell' ),
		'speaking'  => __( 'Public speaking', 'afterbell' ),
		'business'  => __( 'Entrepreneurship', 'afterbell' ),
		'logic'     => __( 'Chess and logic', 'afterbell' ),
		'arts'      => __( 'Arts', 'afterbell' ),
		'music'     => __( 'Music', 'afterbell' ),
		'life'      => __( 'Life skills', 'afterbell' ),
		'test-prep' => __( 'Test prep', 'afterbell' ),
		'early'     => __( 'Early education', 'afterbell' ),
	);
}

/* -------------------------------------------------------------------------
 * Sign up, log in, onboarding and settings handlers
 * ---------------------------------------------------------------------- */
function ab_redirect_msg( $url, $key, $val ) {
	wp_safe_redirect( add_query_arg( $key, $val, $url ) );
	exit;
}

add_action( 'admin_post_nopriv_ab_signup', 'ab_handle_signup' );
add_action( 'admin_post_ab_signup', 'ab_handle_signup' );
function ab_handle_signup() {
	$back  = ab_signup_url();
	$nonce = isset( $_POST['_wpnonce'] ) ? sanitize_key( $_POST['_wpnonce'] ) : '';
	if ( ! wp_verify_nonce( $nonce, 'ab_signup' ) || ! empty( $_POST['ab_website'] ) ) {
		ab_redirect_msg( $back, 'signup', 'error' );
	}
	if ( ! get_option( 'users_can_register' ) ) {
		ab_redirect_msg( $back, 'signup', 'closed' );
	}
	$name  = isset( $_POST['ab_name'] ) ? sanitize_text_field( wp_unslash( $_POST['ab_name'] ) ) : '';
	$email = isset( $_POST['ab_email'] ) ? sanitize_email( wp_unslash( $_POST['ab_email'] ) ) : '';
	$pass  = isset( $_POST['ab_pass'] ) ? (string) wp_unslash( $_POST['ab_pass'] ) : '';
	if ( '' === $name || ! is_email( $email ) ) {
		ab_redirect_msg( $back, 'signup', 'invalid' );
	}
	if ( strlen( $pass ) < 8 ) {
		ab_redirect_msg( $back, 'signup', 'weak' );
	}
	if ( email_exists( $email ) ) {
		ab_redirect_msg( $back, 'signup', 'exists' );
	}
	$uid = wp_insert_user( array(
		'user_login'   => $email,
		'user_email'   => $email,
		'user_pass'    => $pass,
		'display_name' => $name,
		'first_name'   => $name,
		'role'         => 'subscriber',
	) );
	if ( is_wp_error( $uid ) ) {
		ab_redirect_msg( $back, 'signup', 'error' );
	}
	wp_set_current_user( $uid );
	wp_set_auth_cookie( $uid, true );
	wp_safe_redirect( ab_welcome_url() );
	exit;
}

add_action( 'admin_post_nopriv_ab_login', 'ab_handle_login' );
add_action( 'admin_post_ab_login', 'ab_handle_login' );
function ab_handle_login() {
	$back  = ab_login_url();
	$nonce = isset( $_POST['_wpnonce'] ) ? sanitize_key( $_POST['_wpnonce'] ) : '';
	if ( ! wp_verify_nonce( $nonce, 'ab_login' ) ) {
		ab_redirect_msg( $back, 'login', 'error' );
	}
	$email = isset( $_POST['ab_email'] ) ? sanitize_text_field( wp_unslash( $_POST['ab_email'] ) ) : '';
	$pass  = isset( $_POST['ab_pass'] ) ? (string) wp_unslash( $_POST['ab_pass'] ) : '';
	$user  = wp_signon( array( 'user_login' => $email, 'user_password' => $pass, 'remember' => true ), is_ssl() );
	if ( is_wp_error( $user ) ) {
		ab_redirect_msg( $back, 'login', 'failed' );
	}
	$to = isset( $_POST['redirect_to'] ) ? esc_url_raw( wp_unslash( $_POST['redirect_to'] ) ) : '';
	wp_safe_redirect( $to ? $to : ab_account_url() );
	exit;
}

add_action( 'admin_post_nopriv_ab_onboard', function () {
	wp_safe_redirect( ab_signup_url() );
	exit;
} );
add_action( 'admin_post_ab_onboard', function () {
	$nonce = isset( $_POST['_wpnonce'] ) ? sanitize_key( $_POST['_wpnonce'] ) : '';
	if ( ! wp_verify_nonce( $nonce, 'ab_onboard' ) ) {
		ab_redirect_msg( ab_welcome_url(), 'welcome', 'error' );
	}
	$uid   = get_current_user_id();
	$name  = isset( $_POST['l_name'] ) ? sanitize_text_field( wp_unslash( $_POST['l_name'] ) ) : '';
	$month = isset( $_POST['l_month'] ) ? max( 1, min( 12, (int) $_POST['l_month'] ) ) : 1;
	$year  = isset( $_POST['l_year'] ) ? (int) $_POST['l_year'] : 0;
	$age   = $year ? max( 0, min( 18, (int) gmdate( 'Y' ) - $year - ( (int) gmdate( 'n' ) < $month ? 1 : 0 ) ) ) : 0;
	$at    = isset( $_POST['l_at'] ) ? sanitize_key( $_POST['l_at'] ) : '';
	$at    = in_array( $at, array( 'campus', 'home', 'hybrid' ), true ) ? $at : '';

	$allowed   = array_keys( ab_interest_options() );
	$interests = isset( $_POST['l_interests'] ) && is_array( $_POST['l_interests'] ) ? array_values( array_intersect( array_map( 'sanitize_key', wp_unslash( $_POST['l_interests'] ) ), $allowed ) ) : array();
	$formats   = isset( $_POST['l_formats'] ) && is_array( $_POST['l_formats'] ) ? array_values( array_intersect( array_map( 'sanitize_key', wp_unslash( $_POST['l_formats'] ) ), array( 'group', 'one_to_one' ) ) ) : array();
	$needs_ok  = array( 'adhd', 'asd', 'dys', 'speech', 'anxiety' );
	$needs     = isset( $_POST['l_needs'] ) && is_array( $_POST['l_needs'] ) ? array_values( array_intersect( array_map( 'sanitize_key', wp_unslash( $_POST['l_needs'] ) ), $needs_ok ) ) : array();

	$preset = isset( $_POST['l_preset'] ) ? sanitize_key( $_POST['l_preset'] ) : 'after';
	$preset = in_array( $preset, array( 'anytime', 'school', 'after' ), true ) ? $preset : 'after';
	$days   = array();
	foreach ( array( 'mon', 'tue', 'wed', 'thu', 'fri', 'sat', 'sun' ) as $d ) {
		$from = isset( $_POST[ 'from_' . $d ] ) ? preg_replace( '/[^0-9:]/', '', wp_unslash( $_POST[ 'from_' . $d ] ) ) : '';
		$to   = isset( $_POST[ 'to_' . $d ] ) ? preg_replace( '/[^0-9:]/', '', wp_unslash( $_POST[ 'to_' . $d ] ) ) : '';
		if ( '' !== $from && '' !== $to ) {
			$days[ $d ] = array( $from, $to );
		}
	}

	if ( '' !== $name ) {
		$learners   = ab_learners( $uid );
		$learners[] = array(
			'name'      => $name,
			'age'       => $age,
			'grade'     => '',
			'learns_at' => $at,
			'interests' => $interests,
			'formats'   => $formats,
			'needs'     => $needs,
			'preset'    => $preset,
			'schedule'  => $days,
		);
		update_user_meta( $uid, 'ab_learners', array_slice( $learners, 0, 10 ) );
	}
	$plan = isset( $_POST['l_plan'] ) ? sanitize_key( $_POST['l_plan'] ) : 'pay';
	wp_safe_redirect( 'member' === $plan ? ab_checkout_url() : ab_account_url() );
	exit;
} );

add_action( 'admin_post_nopriv_ab_settings', function () {
	wp_safe_redirect( ab_login_url() );
	exit;
} );
add_action( 'admin_post_ab_settings', function () {
	$back  = ab_page_url( 'settings' );
	$nonce = isset( $_POST['_wpnonce'] ) ? sanitize_key( $_POST['_wpnonce'] ) : '';
	if ( ! wp_verify_nonce( $nonce, 'ab_settings' ) ) {
		ab_redirect_msg( $back, 'saved', 'error' );
	}
	$uid  = get_current_user_id();
	$name = isset( $_POST['ab_name'] ) ? sanitize_text_field( wp_unslash( $_POST['ab_name'] ) ) : '';
	$tz   = isset( $_POST['ab_tz'] ) ? sanitize_text_field( wp_unslash( $_POST['ab_tz'] ) ) : '';
	$pass = isset( $_POST['ab_pass'] ) ? (string) wp_unslash( $_POST['ab_pass'] ) : '';
	$args = array( 'ID' => $uid );
	if ( '' !== $name ) {
		$args['display_name'] = $name;
	}
	if ( '' !== $pass ) {
		if ( strlen( $pass ) < 8 ) {
			ab_redirect_msg( $back, 'saved', 'weak' );
		}
		$args['user_pass'] = $pass;
	}
	wp_update_user( $args );
	if ( in_array( $tz, timezone_identifiers_list(), true ) ) {
		update_user_meta( $uid, 'ab_tz', $tz );
	}
	if ( '' !== $pass ) {
		wp_set_auth_cookie( $uid, true );
	}
	ab_redirect_msg( $back, 'saved', 'ok' );
} );

/* Keep the sign-in forms of wp-login.php on our pages. */
add_filter( 'login_url', function ( $url, $redirect ) {
	return ab_login_url( $redirect );
}, 10, 2 );
add_filter( 'register_url', function () {
	return ab_signup_url();
} );
add_filter( 'logout_redirect', function () {
	return home_url( '/' );
} );

/* -------------------------------------------------------------------------
 * Catalog filters
 * ---------------------------------------------------------------------- */
add_action( 'pre_get_posts', function ( $q ) {
	if ( is_admin() || ! $q->is_main_query() ) {
		return;
	}
	if ( ! ( $q->is_post_type_archive( 'ab_class' ) || $q->is_tax( 'ab_subject' ) || $q->is_tax( 'ab_track' ) ) ) {
		return;
	}

	$q->set( 'posts_per_page', 12 );

	// phpcs:disable WordPress.Security.NonceVerification.Recommended -- public read-only filters.
	if ( ! empty( $_GET['q'] ) ) {
		$q->set( 's', sanitize_text_field( wp_unslash( $_GET['q'] ) ) );
	}

	$tax = array();
	if ( ! empty( $_GET['track'] ) && ! $q->is_tax( 'ab_track' ) ) {
		$tax[] = array( 'taxonomy' => 'ab_track', 'field' => 'slug', 'terms' => sanitize_title( wp_unslash( $_GET['track'] ) ) );
	}
	if ( ! empty( $_GET['subj'] ) && ! $q->is_tax( 'ab_subject' ) ) {
		$tax[] = array( 'taxonomy' => 'ab_subject', 'field' => 'slug', 'terms' => sanitize_title( wp_unslash( $_GET['subj'] ) ) );
	}
	if ( $tax ) {
		$tax['relation'] = 'AND';
		$q->set( 'tax_query', $tax );
	}

	$meta  = array();
	$bands = ab_age_bands();
	$band  = isset( $_GET['band'] ) ? sanitize_key( $_GET['band'] ) : '';
	if ( ! empty( $_GET['age'] ) ) {
		$age    = (int) $_GET['age'];
		$meta[] = array( 'key' => '_ab_age_min', 'value' => $age, 'compare' => '<=', 'type' => 'NUMERIC' );
		$meta[] = array( 'key' => '_ab_age_max', 'value' => $age, 'compare' => '>=', 'type' => 'NUMERIC' );
	} elseif ( isset( $bands[ $band ] ) ) {
		// Any class whose age range overlaps the band.
		$meta[] = array( 'key' => '_ab_age_min', 'value' => $bands[ $band ][1], 'compare' => '<=', 'type' => 'NUMERIC' );
		$meta[] = array( 'key' => '_ab_age_max', 'value' => $bands[ $band ][0], 'compare' => '>=', 'type' => 'NUMERIC' );
	}

	$price = isset( $_GET['price'] ) ? sanitize_key( $_GET['price'] ) : '';
	$prng  = array( 'lt30' => array( 0, 30 ), '30-60' => array( 30, 60 ), '60-100' => array( 60, 100 ), 'gt100' => array( 100, 100000 ) );
	if ( isset( $prng[ $price ] ) ) {
		$meta[] = array( 'key' => '_ab_price', 'value' => $prng[ $price ], 'compare' => 'BETWEEN', 'type' => 'NUMERIC' );
	}

	$format = isset( $_GET['format'] ) ? sanitize_key( $_GET['format'] ) : '';
	if ( 'one_to_one' === $format ) {
		$meta[] = array( 'key' => '_ab_format', 'value' => 'one_to_one' );
	} elseif ( 'group' === $format ) {
		$meta[] = array(
			'relation' => 'OR',
			array( 'key' => '_ab_format', 'value' => 'group' ),
			array( 'key' => '_ab_format', 'compare' => 'NOT EXISTS' ),
		);
	}
	if ( $meta ) {
		$meta['relation'] = 'AND';
		$q->set( 'meta_query', $meta );
	}

	$sort = isset( $_GET['sort'] ) ? sanitize_key( $_GET['sort'] ) : '';
	// phpcs:enable
	if ( 'price_asc' === $sort || 'price_desc' === $sort ) {
		$q->set( 'meta_key', '_ab_price' );
		$q->set( 'orderby', 'meta_value_num' );
		$q->set( 'order', 'price_asc' === $sort ? 'ASC' : 'DESC' );
	}
} );

/* -------------------------------------------------------------------------
 * Forms: teacher, tutor, partner and gift enquiries (no plugin needed)
 * ---------------------------------------------------------------------- */
function ab_form_defs() {
	return array(
		'ab_teacher_apply'  => array( 'param' => 'applied',   'page' => 'become-a-teacher', 'subject' => 'Teacher application',  'topic' => 'What they want to teach' ),
		'ab_tutor_request'  => array( 'param' => 'requested', 'page' => 'tutoring',         'subject' => 'Tutor request',         'topic' => 'Subject' ),
		'ab_partner_request' => array( 'param' => 'sent',     'page' => 'partners',         'subject' => 'Partnership enquiry',   'topic' => 'Organization' ),
		'ab_gift_request'   => array( 'param' => 'sent',      'page' => 'gift-cards',       'subject' => 'Gift card request',     'topic' => 'Who is the gift for' ),
		'ab_membership_request' => array( 'param' => 'sent',  'page' => 'membership-checkout', 'subject' => 'Membership request', 'topic' => 'Plan' ),
	);
}

foreach ( array_keys( ab_form_defs() ) as $ab_action ) {
	add_action( 'admin_post_nopriv_' . $ab_action, 'ab_handle_form' );
	add_action( 'admin_post_' . $ab_action, 'ab_handle_form' );
}

function ab_handle_form() {
	$defs   = ab_form_defs();
	$action = isset( $_POST['action'] ) ? sanitize_key( $_POST['action'] ) : '';
	if ( ! isset( $defs[ $action ] ) ) {
		wp_safe_redirect( home_url( '/' ) );
		exit;
	}
	$def   = $defs[ $action ];
	$param = $def['param'];
	$back  = wp_get_referer() ? wp_get_referer() : ab_page_url( $def['page'] );
	$back  = remove_query_arg( array( 'applied', 'requested', 'sent' ), $back );

	$nonce = isset( $_POST['ab_form_nonce'] ) ? sanitize_key( $_POST['ab_form_nonce'] ) : '';
	if ( ! wp_verify_nonce( $nonce, $action ) ) {
		wp_safe_redirect( add_query_arg( $param, 'error', $back ) );
		exit;
	}
	// Honeypot: real people leave this empty.
	if ( ! empty( $_POST['ab_website'] ) ) {
		wp_safe_redirect( add_query_arg( $param, 'ok', $back ) );
		exit;
	}

	$name  = isset( $_POST['ab_name'] ) ? sanitize_text_field( wp_unslash( $_POST['ab_name'] ) ) : '';
	$email = isset( $_POST['ab_email'] ) ? sanitize_email( wp_unslash( $_POST['ab_email'] ) ) : '';
	$topic = isset( $_POST['ab_topic'] ) ? sanitize_text_field( wp_unslash( $_POST['ab_topic'] ) ) : '';
	$about = isset( $_POST['ab_about'] ) ? sanitize_textarea_field( wp_unslash( $_POST['ab_about'] ) ) : '';
	$age   = isset( $_POST['ab_age'] ) ? sanitize_text_field( wp_unslash( $_POST['ab_age'] ) ) : '';
	$when  = isset( $_POST['ab_times'] ) ? sanitize_text_field( wp_unslash( $_POST['ab_times'] ) ) : '';

	if ( '' === $name || ! is_email( $email ) || '' === $topic ) {
		wp_safe_redirect( add_query_arg( $param, 'error', $back ) );
		exit;
	}

	$body = "Name: $name\nEmail: $email\n" . $def['topic'] . ": $topic\n";
	if ( $age ) {
		$body .= "Child age or grade: $age\n";
	}
	if ( $when ) {
		$body .= "Preferred times: $when\n";
	}
	$body .= "\nMessage:\n$about\n";
	wp_mail( ab_contact_email(), '[' . get_bloginfo( 'name' ) . '] ' . $def['subject'] . ' from ' . $name, $body, array( 'Reply-To: ' . $name . ' <' . $email . '>' ) );

	wp_safe_redirect( add_query_arg( $param, 'ok', $back ) );
	exit;
}

/* Status notice used by the form pages. */
function ab_form_notice( $param, $ok, $err ) {
	// phpcs:ignore WordPress.Security.NonceVerification.Recommended
	$status = isset( $_GET[ $param ] ) ? sanitize_key( $_GET[ $param ] ) : '';
	if ( 'ok' === $status ) {
		echo '<p class="notice notice--ok" role="status">' . esc_html( $ok ) . '</p>';
	} elseif ( 'error' === $status ) {
		echo '<p class="notice notice--error" role="alert">' . esc_html( $err ) . '</p>';
	}
}

/* -------------------------------------------------------------------------
 * Accounts: favorites and learner profiles (stored on the user)
 * ---------------------------------------------------------------------- */
function ab_account_url() {
	return ab_page_url( 'my-account' );
}

function ab_favs( $user_id = 0 ) {
	$user_id = $user_id ? $user_id : get_current_user_id();
	$favs    = $user_id ? get_user_meta( $user_id, 'ab_favs', true ) : array();
	return is_array( $favs ) ? array_map( 'intval', $favs ) : array();
}

function ab_is_fav( $post_id ) {
	return in_array( (int) $post_id, ab_favs(), true );
}

function ab_learners( $user_id = 0 ) {
	$user_id = $user_id ? $user_id : get_current_user_id();
	$l       = $user_id ? get_user_meta( $user_id, 'ab_learners', true ) : array();
	return is_array( $l ) ? $l : array();
}

add_action( 'admin_post_nopriv_ab_toggle_fav', function () {
	wp_safe_redirect( wp_login_url( wp_get_referer() ? wp_get_referer() : home_url( '/' ) ) );
	exit;
} );

add_action( 'admin_post_ab_toggle_fav', function () {
	$post_id = isset( $_POST['post_id'] ) ? (int) $_POST['post_id'] : 0;
	$nonce   = isset( $_POST['_wpnonce'] ) ? sanitize_key( $_POST['_wpnonce'] ) : '';
	$back    = wp_get_referer() ? wp_get_referer() : home_url( '/' );
	if ( $post_id && wp_verify_nonce( $nonce, 'ab_fav_' . $post_id ) && 'ab_class' === get_post_type( $post_id ) ) {
		$favs = ab_favs();
		if ( in_array( $post_id, $favs, true ) ) {
			$favs = array_values( array_diff( $favs, array( $post_id ) ) );
		} else {
			$favs[] = $post_id;
		}
		update_user_meta( get_current_user_id(), 'ab_favs', $favs );
	}
	wp_safe_redirect( $back );
	exit;
} );

add_action( 'admin_post_nopriv_ab_learner', function () {
	wp_safe_redirect( wp_login_url( ab_account_url() ) );
	exit;
} );

add_action( 'admin_post_ab_learner', function () {
	$nonce = isset( $_POST['_wpnonce'] ) ? sanitize_key( $_POST['_wpnonce'] ) : '';
	if ( ! wp_verify_nonce( $nonce, 'ab_learner' ) ) {
		wp_safe_redirect( ab_account_url() );
		exit;
	}
	$learners = ab_learners();
	$op       = isset( $_POST['op'] ) ? sanitize_key( $_POST['op'] ) : '';
	if ( 'add' === $op ) {
		$name = isset( $_POST['l_name'] ) ? sanitize_text_field( wp_unslash( $_POST['l_name'] ) ) : '';
		$age  = isset( $_POST['l_age'] ) ? (int) $_POST['l_age'] : 0;
		$grade = isset( $_POST['l_grade'] ) ? sanitize_text_field( wp_unslash( $_POST['l_grade'] ) ) : '';
		if ( '' !== $name && count( $learners ) < 10 ) {
			$learners[] = array( 'name' => $name, 'age' => max( 0, min( 18, $age ) ), 'grade' => $grade );
		}
	} elseif ( 'remove' === $op ) {
		$i = isset( $_POST['index'] ) ? (int) $_POST['index'] : -1;
		if ( isset( $learners[ $i ] ) ) {
			unset( $learners[ $i ] );
			$learners = array_values( $learners );
		}
	}
	update_user_meta( get_current_user_id(), 'ab_learners', $learners );
	wp_safe_redirect( add_query_arg( 'tab', 'learners', ab_account_url() ) );
	exit;
} );

/* -------------------------------------------------------------------------
 * Customizer
 * ---------------------------------------------------------------------- */
add_action( 'customize_register', function ( $wp_customize ) {
	$wp_customize->add_section( 'ab_home', array(
		'title'    => __( 'Afterbell homepage', 'afterbell' ),
		'priority' => 30,
	) );

	$fields = array(
		'ab_hero_title'    => array( __( 'Hero headline (wrap words in *stars* for the gold italic accent)', 'afterbell' ), 'Smart kid today. *Next leader* tomorrow.', 'text' ),
		'ab_hero_text'     => array( __( 'Hero text', 'afterbell' ), 'Live online homeschool classes, 1:1 tutoring and leadership clubs for ages 3 to 18, built around the hours after the school bell.', 'textarea' ),
		'ab_currency'      => array( __( 'Currency symbol', 'afterbell' ), '$', 'text' ),
		'ab_contact_email' => array( __( 'Contact email (enquiries, tutor requests, teacher applications)', 'afterbell' ), get_option( 'admin_email' ), 'text' ),
		'ab_plans'         => array( __( 'Membership plans, one per line: Name|credits|price (sample values)', 'afterbell' ), "Starter|40|20\nStandard|80|40\nPlus|160|78", 'textarea' ),
		'ab_vetting_text'  => array( __( 'Teacher trust line on class pages (leave empty to hide)', 'afterbell' ), '', 'text' ),
		'ab_refer_text'    => array( __( 'Refer and earn text', 'afterbell' ), 'Invite friends to Afterbell. Share your personal link below.', 'text' ),
	);

	foreach ( $fields as $id => $f ) {
		$wp_customize->add_setting( $id, array(
			'default'           => $f[1],
			'sanitize_callback' => 'ab_contact_email' === $id ? 'sanitize_email' : ( 'textarea' === $f[2] ? 'sanitize_textarea_field' : 'sanitize_text_field' ),
		) );
		$wp_customize->add_control( $id, array(
			'label'   => $f[0],
			'section' => 'ab_home',
			'type'    => $f[2],
		) );
	}
} );

/* -------------------------------------------------------------------------
 * Fallback menu
 * ---------------------------------------------------------------------- */
function ab_fallback_menu() {
	echo '<ul class="menu">';
	echo '<li><a href="' . esc_url( ab_page_url( 'homeschool' ) ) . '">' . esc_html__( 'Homeschool', 'afterbell' ) . '</a></li>';
	echo '<li><a href="' . esc_url( ab_page_url( 'tutoring' ) ) . '">' . esc_html__( '1:1 Tutoring', 'afterbell' ) . '</a></li>';
	echo '<li><a href="' . esc_url( ab_browse_url( array( 'track' => 'leadership' ) ) ) . '">' . esc_html__( 'Leadership', 'afterbell' ) . '</a></li>';
	echo '<li><a href="' . esc_url( ab_page_url( 'categories' ) ) . '">' . esc_html__( 'Explore', 'afterbell' ) . '</a></li>';
	echo '</ul>';
}

/* -------------------------------------------------------------------------
 * Sample content on activation (runs once; replace with real classes)
 * ---------------------------------------------------------------------- */
function ab_seed_demo_content() {
	if ( get_option( 'ab_seeded_v2' ) ) {
		return;
	}

	// Remove sample classes from the first theme version, keep anything the site owner wrote.
	$old = get_posts( array(
		'post_type'   => 'ab_class',
		'numberposts' => 50,
		'post_status' => 'any',
		'meta_key'    => '_ab_teacher',
		'meta_value'  => 'Sample teacher',
	) );
	foreach ( $old as $p ) {
		wp_delete_post( $p->ID, true );
	}

	$real = get_posts( array( 'post_type' => 'ab_class', 'numberposts' => 1, 'post_status' => 'any' ) );
	if ( $real ) {
		update_option( 'ab_seeded_v2', 1 );
		return;
	}

	$track_ids = array();
	foreach ( ab_tracks() as $slug => $name ) {
		$t = term_exists( $slug, 'ab_track' );
		if ( ! $t ) {
			$t = wp_insert_term( $name, 'ab_track', array( 'slug' => $slug ) );
		}
		if ( ! is_wp_error( $t ) ) {
			$track_ids[ $slug ] = (int) ( is_array( $t ) ? $t['term_id'] : $t );
		}
	}

	$subjects = array(
		'math'           => 'Math',
		'english'        => 'English and writing',
		'science'        => 'Science',
		'social-studies' => 'Social studies',
		'languages'      => 'World languages',
		'coding'         => 'Coding and tech',
		'speaking'       => 'Public speaking and debate',
		'business'       => 'Entrepreneurship',
		'logic'          => 'Chess and logic',
	);
	$subject_ids = array();
	foreach ( $subjects as $slug => $name ) {
		$t = term_exists( $slug, 'ab_subject' );
		if ( ! $t ) {
			$t = wp_insert_term( $name, 'ab_subject', array( 'slug' => $slug ) );
		}
		if ( ! is_wp_error( $t ) ) {
			$subject_ids[ $slug ] = (int) ( is_array( $t ) ? $t['term_id'] : $t );
		}
	}

	// title, track, subject, format, age min, age max, grade, price, unit, schedule, duration, weeks, seats, summary.
	$demo = array(
		array( 'Math Foundations, Grades 3 to 5', 'homeschool-academics', 'math', 'group', 8, 11, 'Grades 3 to 5', 128, 'per 8-week course', 'Mon and Wed, 4:00 PM', '45 minutes', 8, 8, 'Place value, fractions and multiplication taught live, with a short practice set after each session.' ),
		array( 'Pre-Algebra Essentials', 'homeschool-academics', 'math', 'group', 11, 14, 'Grades 6 to 8', 160, 'per 10-week course', 'Tue and Thu, 5:00 PM', '60 minutes', 10, 8, 'Ratios, expressions and equations, with worked examples and weekly feedback from the teacher.' ),
		array( 'Reading and Writing Workshop, Grades 6 to 8', 'homeschool-academics', 'english', 'group', 11, 14, 'Grades 6 to 8', 144, 'per 8-week course', 'Wed, 4:30 PM', '75 minutes', 8, 8, 'A novel, a writing portfolio and a weekly discussion circle that builds clear thinking on the page.' ),
		array( 'Life Science for Middle School', 'homeschool-academics', 'science', 'group', 11, 14, 'Grades 6 to 8', 152, 'per 8-week course', 'Fri, 4:00 PM', '60 minutes', 8, 10, 'Cells, ecosystems and heredity through live demos, diagrams and a home lab each week.' ),
		array( 'World History Story Lab', 'homeschool-academics', 'social-studies', 'group', 9, 12, 'Grades 4 to 7', 120, 'per 8-week course', 'Thu, 4:30 PM', '50 minutes', 8, 10, 'Ancient civilizations told through maps, primary sources and role play.' ),
		array( 'Spanish for Beginners', 'homeschool-academics', 'languages', 'group', 8, 13, 'Grades 3 to 8', 112, 'per 8-week course', 'Mon and Thu, 3:30 PM', '30 minutes', 8, 6, 'Everyday phrases, songs and short conversations to build speaking confidence from day one.' ),
		array( '1:1 Math Tutor, all grades', 'tutoring', 'math', 'one_to_one', 6, 18, 'Grades 1 to 12', 35, 'per 45-minute session', 'Book weekly or as needed', '45 minutes', 0, 1, 'A tutor matched to your child. Catch up, keep pace or move ahead, starting with a short trial session.' ),
		array( '1:1 English and Writing Coach', 'tutoring', 'english', 'one_to_one', 8, 18, 'Grades 3 to 12', 35, 'per 45-minute session', 'Book weekly or as needed', '45 minutes', 0, 1, 'Reading fluency, essay structure and editing, taught one-on-one with feedback on real work.' ),
		array( '1:1 Science and Exam Prep', 'tutoring', 'science', 'one_to_one', 11, 18, 'Grades 6 to 12', 40, 'per 45-minute session', 'Book weekly or as needed', '45 minutes', 0, 1, 'Biology, chemistry and physics support, plus exam practice and revision plans.' ),
		array( 'Young Speakers Club', 'leadership', 'speaking', 'group', 9, 13, 'Grades 4 to 8', 96, 'per 6-week club', 'Tue, 5:30 PM', '50 minutes', 6, 8, 'Learners prepare, practise and deliver short talks, and give kind, useful feedback to each other.' ),
		array( 'Junior Entrepreneurs Lab', 'leadership', 'business', 'group', 10, 15, 'Grades 5 to 9', 140, 'per 8-week course', 'Sat, 10:00 AM', '60 minutes', 8, 8, 'Teams spot a problem, design a small product and pitch it in a final demo day.' ),
		array( 'Debate and Critical Thinking', 'leadership', 'speaking', 'group', 12, 17, 'Grades 7 to 12', 132, 'per 8-week course', 'Thu, 6:00 PM', '60 minutes', 8, 10, 'Build an argument, test it against evidence and learn to disagree well.' ),
		array( 'Chess Strategy Club', 'enrichment', 'logic', 'group', 7, 13, 'Grades 2 to 8', 72, 'per 6-week club', 'Wed, 5:00 PM', '45 minutes', 6, 8, 'Openings, tactics and thinking ahead, with friendly games each week.' ),
		array( 'Build Your First Game with Scratch', 'enrichment', 'coding', 'group', 8, 12, 'Grades 3 to 7', 96, 'per 6-week course', 'Mon and Wed, 4:30 PM', '45 minutes', 6, 8, 'Learners design a small platform game, test it with classmates and share it with their families.' ),
	);

	foreach ( $demo as $d ) {
		$id = wp_insert_post( array(
			'post_type'    => 'ab_class',
			'post_status'  => 'publish',
			'post_title'   => $d[0],
			'post_excerpt' => $d[13],
			'post_content' => '<p>' . $d[13] . '</p><h3>What learners do</h3><ul><li>Join a live session with a teacher and classmates</li><li>Practise between sessions at their own pace</li><li>Get feedback they can act on</li></ul><h3>What to prepare</h3><p>A laptop or tablet, a quiet spot and a notebook. The teacher shares anything extra before the first session.</p>',
		) );
		if ( ! $id || is_wp_error( $id ) ) {
			continue;
		}
		if ( isset( $track_ids[ $d[1] ] ) ) {
			wp_set_object_terms( $id, array( $track_ids[ $d[1] ] ), 'ab_track' );
		}
		if ( isset( $subject_ids[ $d[2] ] ) ) {
			wp_set_object_terms( $id, array( $subject_ids[ $d[2] ] ), 'ab_subject' );
		}
		update_post_meta( $id, '_ab_format', $d[3] );
		update_post_meta( $id, '_ab_age_min', $d[4] );
		update_post_meta( $id, '_ab_age_max', $d[5] );
		update_post_meta( $id, '_ab_grade', $d[6] );
		update_post_meta( $id, '_ab_price', $d[7] );
		update_post_meta( $id, '_ab_price_unit', $d[8] );
		update_post_meta( $id, '_ab_schedule', $d[9] );
		update_post_meta( $id, '_ab_duration', $d[10] );
		if ( $d[11] ) {
			update_post_meta( $id, '_ab_weeks', $d[11] );
		}
		update_post_meta( $id, '_ab_seats', $d[12] );
		update_post_meta( $id, '_ab_teacher', 'Sample teacher' );
	}

	update_option( 'ab_seeded_v2', 1 );
	ab_seed_pages();
}

/* Pages, menu and registration. Runs on activation and once after a theme update. */
function ab_site_pages() {
	$legal = '<p><strong>Starter text.</strong> Replace this page with a policy reviewed by a qualified professional before you launch.</p>';
	return array(
		'homeschool'        => array( 'Homeschool', 'page-homeschool.php', '' ),
		'tutoring'          => array( '1:1 Tutoring', 'page-tutoring.php', '' ),
		'categories'        => array( 'Explore categories', 'page-categories.php', '' ),
		'become-a-teacher'  => array( 'Become a teacher', 'page-become-teacher.php', '' ),
		'educator-library'  => array( 'Educator library', 'page-educator-library.php', '' ),
		'partners'          => array( 'Schools and partners', 'page-partners.php', '' ),
		'gift-cards'        => array( 'Gift cards', 'page-gift.php', '' ),
		'about'             => array( 'About Afterbell', 'page-about.php', '' ),
		'blog'              => array( 'Blog', 'page-blog.php', '' ),
		'my-account'        => array( 'My account', 'page-account.php', '' ),
		'log-in'            => array( 'Log in', 'page-login.php', '' ),
		'sign-up'           => array( 'Sign up', 'page-signup.php', '' ),
		'welcome'           => array( 'Welcome', 'page-welcome.php', '' ),
		'settings'          => array( 'Settings', 'page-settings.php', '' ),
		'membership'        => array( 'Membership', 'page-membership.php', '' ),
		'membership-checkout' => array( 'Join membership', 'page-checkout.php', '' ),
		'help'              => array( 'Help center', 'page-help.php', '' ),
		'refer'             => array( 'Refer and earn', 'page-refer.php', '' ),
		'terms'             => array( 'Terms of use', '', $legal . '<h2>Using the service</h2><p>Describe who may use the site, accepted behavior and how classes are booked.</p><h2>Payments and refunds</h2><p>Describe prices, payment methods and your refund rules.</p><h2>Contact</h2><p>Tell people how to reach you.</p>' ),
		'privacy'           => array( 'Privacy policy', '', $legal . '<h2>What we collect</h2><p>List the data you collect from parents, learners and teachers.</p><h2>How we use it</h2><p>Explain each purpose.</p><h2>Your choices</h2><p>Explain how people can access or delete their data.</p>' ),
		'childrens-privacy' => array( 'Children\'s privacy', '', $legal . '<h2>Learners under 13</h2><p>Explain how parents control their child\'s information and how you protect it.</p>' ),
	);
}

function ab_seed_pages() {
	foreach ( ab_site_pages() as $slug => $p ) {
		if ( get_page_by_path( $slug ) ) {
			continue;
		}
		$pid = wp_insert_post( array(
			'post_type'    => 'page',
			'post_status'  => 'publish',
			'post_title'   => $p[0],
			'post_name'    => $slug,
			'post_content' => $p[2],
		) );
		if ( $pid && ! is_wp_error( $pid ) && $p[1] ) {
			update_post_meta( $pid, '_wp_page_template', $p[1] );
		}
	}


	// Sample teachers (fictional, replace with real ones).
	if ( ! get_option( 'ab_teachers_seeded' ) ) {
		$tdata = array(
			array( 'Amira Rahman', 'Math teacher for curious minds', 'Experienced math teacher' ),
			array( 'Daniel Okoye', 'Writing and debate coach', 'Debate coach' ),
			array( 'Priya Nair', 'Science teacher who loves experiments', 'Science educator' ),
			array( 'Lucas Meyer', 'Coding and chess mentor', 'Software engineer and chess coach' ),
		);
		$tids = array();
		foreach ( $tdata as $t ) {
			$tid = wp_insert_post( array(
				'post_type'    => 'ab_teacher',
				'post_status'  => 'publish',
				'post_title'   => $t[0],
				'post_content' => '<p>Sample teacher profile. Replace this with a real biography: background, teaching style and what learners will enjoy.</p>',
			) );
			if ( $tid && ! is_wp_error( $tid ) ) {
				update_post_meta( $tid, '_abt_headline', $t[1] );
				update_post_meta( $tid, '_abt_credential', $t[2] );
				$tids[] = $tid;
			}
		}
		if ( $tids ) {
			$i = 0;
			foreach ( get_posts( array( 'post_type' => 'ab_class', 'numberposts' => 100, 'post_status' => 'any', 'meta_key' => '_ab_teacher', 'meta_value' => 'Sample teacher' ) ) as $c ) {
				update_post_meta( $c->ID, '_ab_teacher_id', $tids[ $i++ % count( $tids ) ] );
				update_post_meta( $c->ID, '_ab_outcomes', "Join a live session with a teacher and classmates\nPractise between sessions at their own pace\nGet feedback they can act on" );
			}
		}
		update_option( 'ab_teachers_seeded', 1 );
	}

	// Menu.
	$menu_name = 'Afterbell main';
	if ( ! wp_get_nav_menu_object( $menu_name ) ) {
		$menu_id = wp_create_nav_menu( $menu_name );
		if ( ! is_wp_error( $menu_id ) ) {
			$items = array(
				'Homeschool'   => ab_page_url( 'homeschool' ),
				'1:1 Tutoring' => ab_page_url( 'tutoring' ),
				'Leadership'   => ab_browse_url( array( 'track' => 'leadership' ) ),
				'Explore'      => ab_page_url( 'categories' ),
			);
			foreach ( $items as $title => $url ) {
				wp_update_nav_menu_item( $menu_id, 0, array(
					'menu-item-title'  => $title,
					'menu-item-url'    => $url,
					'menu-item-status' => 'publish',
					'menu-item-type'   => 'custom',
				) );
			}
			$locations            = get_theme_mod( 'nav_menu_locations', array() );
			$locations['primary'] = $menu_id;
			$locations['footer']  = $menu_id;
			set_theme_mod( 'nav_menu_locations', $locations );
		}
	}

	// "Join for free" needs registration on.
	if ( ! get_option( 'users_can_register' ) ) {
		update_option( 'users_can_register', 1 );
		update_option( 'default_role', 'subscriber' );
	}
	update_option( 'ab_pages_ver', AB_VERSION );
}

add_action( 'admin_init', function () {
	if ( get_option( 'ab_pages_ver' ) !== AB_VERSION && get_option( 'ab_seeded_v2' ) ) {
		ab_seed_pages();
	}
} );

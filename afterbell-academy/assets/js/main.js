( function () {
	'use strict';

	/* Mobile menu */
	var toggle = document.querySelector( '.nav-toggle' );
	var nav = document.getElementById( 'primary-nav' );
	if ( toggle && nav ) {
		var setOpen = function ( open ) {
			toggle.setAttribute( 'aria-expanded', open ? 'true' : 'false' );
			nav.classList.toggle( 'is-open', open );
		};
		toggle.addEventListener( 'click', function () {
			setOpen( toggle.getAttribute( 'aria-expanded' ) !== 'true' );
		} );
		document.addEventListener( 'keydown', function ( e ) {
			if ( e.key === 'Escape' ) {
				setOpen( false );
			}
		} );
		nav.addEventListener( 'click', function ( e ) {
			if ( e.target.closest( 'a' ) ) {
				setOpen( false );
			}
		} );
	}



	/* Mobile search icon: opens a search bar under the header */
	var sToggle = document.querySelector( '.search-toggle' );
	var sPanel = document.getElementById( 'm-search' );
	if ( sToggle && sPanel ) {
		var setSearch = function ( open ) {
			sPanel.hidden = ! open;
			sToggle.setAttribute( 'aria-expanded', open ? 'true' : 'false' );
			if ( open ) {
				if ( toggle && toggle.getAttribute( 'aria-expanded' ) === 'true' ) {
					toggle.click();
				}
				var q = document.getElementById( 'm-search-q' );
				if ( q ) { q.focus(); }
			}
		};
		sToggle.addEventListener( 'click', function () { setSearch( sPanel.hidden ); } );
		sPanel.querySelector( '[data-search-close]' ).addEventListener( 'click', function () { setSearch( false ); sToggle.focus(); } );
		document.addEventListener( 'keydown', function ( e ) {
			if ( e.key === 'Escape' && ! sPanel.hidden ) { setSearch( false ); sToggle.focus(); }
		} );
		document.addEventListener( 'click', function ( e ) {
			if ( ! sPanel.hidden && ! e.target.closest( '#m-search, .search-toggle' ) ) { setSearch( false ); }
		} );
		if ( toggle ) {
			toggle.addEventListener( 'click', function () {
				if ( toggle.getAttribute( 'aria-expanded' ) === 'true' && ! sPanel.hidden ) { setSearch( false ); }
			} );
		}
	}

	/* Auto-submit filter chips */
	document.querySelectorAll( '[data-autosubmit]' ).forEach( function ( el ) {
		el.addEventListener( 'change', function () {
			if ( el.form ) {
				el.form.submit();
			}
		} );
	} );

	/* Copy and share buttons */
	function copyText( text, btn ) {
		var done = function () {
			if ( btn ) {
				var old = btn.textContent;
				btn.textContent = '✓';
				setTimeout( function () { btn.textContent = old; }, 1400 );
			}
		};
		if ( navigator.clipboard && navigator.clipboard.writeText ) {
			navigator.clipboard.writeText( text ).then( done, function () {} );
		}
	}
	document.querySelectorAll( '[data-copy]' ).forEach( function ( btn ) {
		btn.addEventListener( 'click', function () {
			var input = document.querySelector( btn.getAttribute( 'data-copy' ) );
			if ( input ) {
				input.select();
				copyText( input.value, btn );
			}
		} );
	} );
	document.querySelectorAll( '[data-share]' ).forEach( function ( btn ) {
		btn.addEventListener( 'click', function () {
			copyText( window.location.href, btn );
		} );
	} );

	/* Membership checkout summary */
	var plan = document.getElementById( 'co-plan' );
	if ( plan ) {
		var cur = plan.form.getAttribute( 'data-currency' ) || '';
		var fmt = function ( n ) { return cur + ( Math.round( n ) === n ? n : n.toFixed( 2 ) ); };
		var upd = function () {
			var o = plan.options[ plan.selectedIndex ];
			var price = parseFloat( o.getAttribute( 'data-price' ) );
			document.getElementById( 'co-name' ).textContent = o.getAttribute( 'data-name' );
			document.getElementById( 'sum-plan' ).textContent = o.getAttribute( 'data-credits' ) + ' credits plan';
			[ 'sum-price', 'sum-sub', 'sum-total' ].forEach( function ( id ) {
				document.getElementById( id ).textContent = fmt( price );
			} );
		};
		plan.addEventListener( 'change', upd );
		upd();
	}

	/* Onboarding wizard */
	var wiz = document.getElementById( 'wiz' );
	if ( wiz ) {
		var panes = Array.prototype.slice.call( wiz.querySelectorAll( '.pane' ) );
		var dots = wiz.querySelectorAll( '.wiz__dots li' );
		var back = wiz.querySelector( '[data-prev]' );
		var next = wiz.querySelector( '[data-next]' );
		var finish = wiz.querySelector( '[data-finish]' );
		var skip = wiz.querySelector( '[data-skip-btn]' );
		var title = document.getElementById( 'wiz-title' );
		var sub = document.getElementById( 'wiz-sub' );
		var cur2 = 0;
		wiz.classList.add( 'is-js' );

		var emph = function ( t ) {
			title.textContent = '';
			t.split( /(\*[^*]+\*)/ ).forEach( function ( part ) {
				if ( /^\*[^*]+\*$/.test( part ) ) {
					var em = document.createElement( 'em' );
					em.textContent = part.slice( 1, -1 );
					title.appendChild( em );
				} else {
					title.appendChild( document.createTextNode( part ) );
				}
			} );
		};
		var show = function ( i ) {
			cur2 = i;
			panes.forEach( function ( p, n ) { p.hidden = n !== i; } );
			dots.forEach( function ( d, n ) { d.classList.toggle( 'is-on', n <= i ); } );
			back.hidden = i === 0;
			next.hidden = i === panes.length - 1;
			finish.hidden = i !== panes.length - 1;
			var pane = panes[ i ];
			skip.hidden = ! pane.getAttribute( 'data-skip' );
			if ( pane.getAttribute( 'data-skip' ) ) {
				skip.textContent = pane.getAttribute( 'data-skip' );
			} else if ( i === 1 ) {
				skip.hidden = false;
				skip.textContent = wiz.getAttribute( 'data-notsure' ) || 'Not sure yet';
			}
			emph( pane.getAttribute( 'data-title' ) || '' );
			sub.textContent = pane.getAttribute( 'data-sub' ) || '';
			window.scrollTo( { top: 0 } );
		};
		var valid = function ( pane ) {
			var ok = true;
			pane.querySelectorAll( '[required]' ).forEach( function ( f ) {
				if ( ! f.checkValidity() ) {
					ok = false;
					f.reportValidity();
				}
			} );
			return ok;
		};
		next.addEventListener( 'click', function () {
			if ( valid( panes[ cur2 ] ) ) {
				show( Math.min( cur2 + 1, panes.length - 1 ) );
			}
		} );
		back.addEventListener( 'click', function () { show( Math.max( cur2 - 1, 0 ) ); } );
		skip.addEventListener( 'click', function () {
			panes[ cur2 ].querySelectorAll( 'input[type=checkbox]' ).forEach( function ( c ) { c.checked = false; } );
			show( Math.min( cur2 + 1, panes.length - 1 ) );
		} );
		panes.forEach( function ( p ) {
			var none = p.querySelector( '[data-none]' );
			if ( none ) {
				none.addEventListener( 'change', function () {
					if ( none.checked ) {
						p.querySelectorAll( 'input[name="l_needs[]"]' ).forEach( function ( c ) { c.checked = false; } );
					}
				} );
			}
		} );
		var applyPreset = function ( r ) {
			var f = r.getAttribute( 'data-from' ), t = r.getAttribute( 'data-to' );
			wiz.querySelectorAll( '.week-row select' ).forEach( function ( s ) {
				s.value = s.name.indexOf( 'from_' ) === 0 ? f : t;
			} );
		};
		wiz.querySelectorAll( '.preset input' ).forEach( function ( r ) {
			r.addEventListener( 'change', function () { applyPreset( r ); } );
			if ( r.checked ) { applyPreset( r ); }
		} );
		show( 0 );
	}

	/* Scroll reveal. Content stays visible without JS or with reduced motion. */
	var reduce = window.matchMedia && window.matchMedia( '(prefers-reduced-motion: reduce)' ).matches;
	if ( reduce || ! ( 'IntersectionObserver' in window ) ) {
		return;
	}
	var items = document.querySelectorAll( '.tile, .band, .pillar, .step, .card, .features li, .perks li, .split__card, .subject, .day li, .faq details, .cta-band' );
	if ( ! items.length ) {
		return;
	}
	document.documentElement.classList.add( 'has-reveal' );
	var io = new IntersectionObserver( function ( entries ) {
		entries.forEach( function ( entry ) {
			if ( entry.isIntersecting ) {
				entry.target.classList.add( 'is-in' );
				io.unobserve( entry.target );
			}
		} );
	}, { rootMargin: '0px 0px -8% 0px', threshold: 0.05 } );
	items.forEach( function ( el, i ) {
		el.classList.add( 'rv' );
		el.style.setProperty( '--i', String( i % 4 ) );
		io.observe( el );
	} );
} )();

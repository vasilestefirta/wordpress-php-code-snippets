<?php

/**
 * Change the url of the logo on WordPress login page.
 * 
 * @param  string $url
 * @return string
 */
function my_wp_login_logo_url( $url ) {

    return get_bloginfo( 'url' );
}
add_filter( 'login_headerurl', 'my_wp_login_logo_url' );


/**
 * Change the title of the logo on WordPress login page.
 * 
 * @param  string $title
 * @return string
 */
function my_wp_login_logo_title( $title ) {

    return wp_specialchars_decode( get_option( 'blogname' ), ENT_QUOTES );
}
add_filter( 'login_headertitle', 'my_wp_login_logo_title' );


/**
 * Change the WP "Register" link from the WordPress Login Page (/wp-login.php) using a custom URL and title.
 * 
 * @param  string 	$link
 * @return string
 */
function my_register_link( $link ) {

    return '<a href="' . esc_url( home_url( '/create-account/' ) ) . '">' . __( 'Create Account' ) . '</a>';
}
add_filter( 'register', 'my_register_link' );


/**
 * Disable access to the WP default user registration page.
 */
function add_wp_register_page_restrications() {

	if( is_user_logged_in() ) {
		wp_redirect( home_url( '/my-account/' ) );
		die;
	}
	else {
		wp_redirect( home_url( '/create-account/' ) );
		die;
	}
}
add_action( 'login_form_register', 'add_wp_register_page_restrications' );


/**
 * Disable access to the WP default user login page for logged-in users.
 */
function add_wp_login_page_restrications() {

	global $action;

	// make sure if we don't have a "logout" action in progress
	if( $action == 'logout' || ! is_user_logged_in() ) {
		return;
	}

	wp_redirect( home_url( '/my-account/' ) );
	die;
}
add_action( 'login_init', 'add_wp_login_page_restrications' );


/**
 * Redirect user after a successful login.
 *
 * @param string 	$redirect_to 		URL to redirect to.
 * @param string 	$request 			URL the user is coming from.
 * @param object 	$user 				Logged user's data.
 * 
 * @return string
 */
function my_login_redirect( $redirect_to, $request, $user ) {

	global $user;
	
	if( isset( $user->roles ) && is_array( $user->roles ) ) {
		// check for admins
		if( in_array( 'administrator', $user->roles ) ) {
			// redirect them to the default place
			return $redirect_to;
		} else {
			return home_url( '/my-account/' );
		}
	} else {
		return $redirect_to;
	}
}
add_action( 'login_redirect', 'my_login_redirect', 10, 3 );


/**
 * Add a custom class to the body of the WP Login page.
 * 
 * @param  array  $classes
 * @return array
 */
function login_body_classes( $classes = array() ) {
    
	$classes[] = 'my-custom-body-class';
	return $classes;
}
add_filter( 'login_body_class', 'login_body_classes' );


/**
 * Add custom css to the WP Login page.
 *
 */
function login_enqueue_scripts() {
	?>
	<style>
		body {
			background-color: #4791cc !important;
		}
		.login h1 a {
            background-image: url(<?php echo plugin_dir_url( __FILE__ ); ?>images/my-custom-logo.png);
            background-size: auto;
            width: 236px;
            height: 75px;
        }
        .login #nav,
        .login #backtoblog {
        	background: #2d2d2d none repeat scroll 0 0;
		    color: #fff;
		    font-size: 15px;
        }

        .login #nav {
		    box-shadow: 0 10px 15px -7px rgba(0, 0, 0, 0.75) inset;
		    margin: 0;
		    padding-top: 24px;
		}

		.login #backtoblog {
		    margin: 0;
		    padding: 16px 24px !important;
		}

        #nav a,
        #backtoblog a {
        	color: #FFF !important;
        }

        .my-custom-body-class #nav,
        .my-custom-body-class #backtoblog {
        	display: none !important;
        }
	</style>
	<?php
}
add_action( 'login_enqueue_scripts', 'login_enqueue_scripts' );

?>

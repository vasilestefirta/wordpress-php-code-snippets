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

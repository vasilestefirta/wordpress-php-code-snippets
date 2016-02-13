<?php

/**
 * Modifies the "from email address" used in an email sent using the wp_mail function
 *
 * @param       string       $email
 *
 * @return      string
 */
function change_wp_mail_from( $email ) {

    return get_option( 'admin_email' );
}
add_filter( 'wp_mail_from', 'change_wp_mail_from' );


/**
 * Modifies the "from name" used in an email sent using the wp_mail function.
 *
 * @param       string       $name
 *
 * @return      string
 */
function change_wp_mail_from_name( $name ) {

    return wp_specialchars_decode( get_option( 'blogname' ), ENT_QUOTES );
}
add_filter( 'wp_mail_from_name', 'change_wp_mail_from_name' );

?>

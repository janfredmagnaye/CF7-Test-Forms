<?php
/**
 * Plugin Name: Contact Form 7 Test Mode
 * Description: Enables skip_mail to all Contact Form 7 Forms for testing.
 * Version: 1.0
 * Author: Pv
 * Author URI: https://github.com/janfredmagnaye
 */

// Include Admin Page
require_once('class-cf7test-admin.php');

// Main Filter Function
add_filter('wpcf7_skip_mail', 'enableTestMode');
function enableTestMode() {
    if(get_option('cf7-test-mode') == "true"){
        if ( current_user_can( 'administrator' ) ) {
            return true;
        }
    }
}
// Register to Admin Bar
function registerToggleButton($wp_admin_bar){
    if(get_option('cf7-test-mode') == "true"){
        $pluginText = '<span>Disable CF7 Test Mode</span>';
    } else {
        $pluginText = '<span>Enable CF7 Test Mode</span>';
    }
    $args = array(
        'id'    => 'enable-test-mode-toggle',
        'title' => $pluginText,
        'href'  => '/wp-admin/options-general.php?page=cf7test-example-plugin',
    );
    $wp_admin_bar->add_node($args);
}
add_action('admin_bar_menu', 'registerToggleButton', 999);

// Register the Option

?>
<?php
/**
 * Plugin Name: Contact Form 7 Test Mode
 * Description: Adds filter and custom functions for testing Contact Form 7
 * Version: 1.2
 * Author: PV Dev
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
add_action( 'wpcf7_before_send_mail', 'changeEmailReceiver');
function changeEmailReceiver($contact_form) {
    if ( current_user_can( 'administrator' ) ) {
        $changeEmail = get_option('cf7-email-receiver');
        if($changeEmail){
            $submission = WPCF7_Submission::get_instance();
            $toEmail = $changeEmail;
            $mailProp = $contact_form->get_properties('mail');
            $mailProp['mail']['recipient'] = $toEmail;
            $contact_form->set_properties(array('mail' => $mailProp['mail']));
        }
    }    
}

// Register to Admin Bar
function registerToggleButton($wp_admin_bar){
    if(get_option('cf7-test-mode') == "true"){
        $pluginText = '<span class="cf7-indicator cf7-enabled">Admin Send Emails</span>';
    } else {
        $pluginText = '<span class="cf7-indicator cf7-disabled">Admin Send Emails</span>';
    }
    $args = array(
        'id'    => 'enable-test-mode-toggle',
        'title' => $pluginText,
        'href'  => '/wp-admin/options-general.php?page=cf7test-example-plugin',
    );
    $wp_admin_bar->add_node($args);
}
add_action('admin_bar_menu', 'registerToggleButton', 999);

// Load Styles for Admin
add_action( 'admin_enqueue_scripts', 'cf7_test_admin_styles' );
function cf7_test_admin_styles(){
    wp_enqueue_style( 'cf7_test_admin_css', plugin_dir_url( __FILE__ ) .  '/assets/css/cf7-test-mode.css', false, '1.0.0' );
}

// Filter Text areas
add_filter('wpcf7_validate_textarea', 'cf7_test_textarea_filter', 10, 2);
add_filter('wpcf7_validate_textarea*', 'cf7_test_textarea_filter', 10, 2);
function cf7_test_textarea_filter($result, $tag) {  
    if(get_option('cf7-spam-filter') == "true"){        
        $type = $tag['type'];
        $name = $tag['name'];
        $value = $_POST[$name];
        if(preg_match('/\b(?:(?:https?|ftp):\/\/)?[\w\-?=%.]+\.[\w\-&?=%.]+/i', $value) ){
            $result->invalidate( $tag, "Please remove URLs, links, or emails on this field to continue." );
        }
        if(preg_match('/[А-Яа-яЁё]/u', $value )){
            $result->invalidate( $tag, "Please remove any Cyrillic alphabet." );
        }
        return $result;
    }
}

// Get Submitted form if Spam
// add_filter( 'wpcf7_spam', 'cf7_test_collect_spam', 9 );
// function cf7_test_collect_spam( $spam ){
//     if ( $spam ) {
//         return $spam;
//     }
// }

?>

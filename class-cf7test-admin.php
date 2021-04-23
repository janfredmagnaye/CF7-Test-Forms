<?php 
/* Settings Page for CF7 Test Mode Plugin */

function cf7test_add_settings_page() {
    add_options_page( 'CF7 Test', 'CF7 Test', 'manage_options', 'cf7test-example-plugin', 'cf7test_render_plugin_settings_page' );
}
add_action( 'admin_menu', 'cf7test_add_settings_page' );

function cf7test_render_plugin_settings_page() {
    ?>
    <h2>CF7 Test Plugin Settings</h2>
    <form action="options.php" method="post">
        <?php 
        settings_fields( 'cf7test_plugin_options' );
        do_settings_sections( 'cf7test_plugin' );
        ?>
        <table class="cf7-test-table">
            <tr class="cf7-test-section">
                <td><h3>Admin-only Settings</h3></td>
            </tr>
            <tr>
                <td><strong>Disable Sending Email</strong></td>
                <td><input type="checkbox" name="cf7-test-mode" value="true" <?php if(get_option('cf7-test-mode') == "true") echo "checked"; ?> /></td>
            </tr>
            <tr>
                <td><strong>Custom Email Receiver <br>( Uncheck the option above to use this )</strong></td>
                <td><input type="email" name="cf7-email-receiver" value="<?= esc_attr( get_option('cf7-email-receiver') ) ?>" /></td>
            </tr>
            <tr class="cf7-test-section">
                <td><h3>CF7 Form Add-ons</h3></td>
            </tr>
            <tr>
                <td><strong>Enable Spam Filtering</strong></td>
                <td><input type="checkbox" name="cf7-spam-filter" value="true" <?php if(get_option('cf7-spam-filter') == "true") echo "checked"; ?> /></td>
            </tr>

        </table>
        <?= submit_button(); ?>
    </form>
    <?php
}

function cf7test_register_settings() {
    register_setting( 'cf7test_plugin_options', 'cf7-test-mode');
    register_setting( 'cf7test_plugin_options', 'cf7-spam-filter');
    register_setting( 'cf7test_plugin_options', 'cf7-email-receiver');
}

add_action( 'admin_init', 'cf7test_register_settings' );
?>

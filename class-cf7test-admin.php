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
        <table>
            <tr>
                <td><strong>Enable CF7 Test Mode</strong></td>
                <td><input type="checkbox" name="cf7-test-mode" value="true" <?php if(get_option('cf7-test-mode') == "true") echo "checked"; ?> /></td>
            </tr>
        </table>
        <?= submit_button(); ?>
    </form>
    <?php
}

function cf7test_register_settings() {
    register_setting( 'cf7test_plugin_options', 'cf7-test-mode');
}

add_action( 'admin_init', 'cf7test_register_settings' );
?>
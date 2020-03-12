<?php

/**
 * Provide a admin area view for the plugin
 *
 * This file is used to markup the admin-facing aspects of the plugin.
 *
 * @link       krupal-algo
 * @since      1.0.0
 *
 * @package    Algolia_Search_Integration
 * @subpackage Algolia_Search_Integration/admin/partials
 */

 // If this file is called directly, abort.
if ( ! defined( 'WPINC' ) ) die;
?>

<!-- This file should primarily consist of HTML with a little bit of PHP. -->
<div class="wrap">
    <h2>Algolia <?php esc_attr_e('Settings', 'plugin_name' ); ?></h2>

    <form method="post" name="<?php echo $this->plugin_name; ?>" action="options.php">
    <?php
        //Grab all options
        $options = get_option( $this->plugin_name );

    //    print_r($options);
    //    wp_die();
        $application_id = ( isset( $options['application_id'] ) && ! empty( $options['application_id'] ) ) ? esc_attr( $options['application_id'] ) : '';
        $search_key = ( isset( $options['search_key'] ) && ! empty( $options['search_key'] ) ) ? esc_attr( $options['search_key'] ) : '';
        $admin_key = ( isset( $options['admin_key'] ) && ! empty( $options['admin_key'] ) ) ? esc_attr( $options['admin_key'] ) : '';
        $indices_name = ( isset( $options['indices_name'] ) && ! empty( $options['indices_name'] ) ) ? esc_attr( $options['indices_name'] ) : '';
        

        settings_fields($this->plugin_name);
        do_settings_sections($this->plugin_name);

    ?>
    <table class="form-table">
        <tbody>
            <tr>
                <th scope="row">
                    <label for="algolia-search-integration-application_id"><?php esc_attr_e( 'Application id', 'plugin_name' ); ?></label>
                </th>
                <td>
                <input type="text" class="regular-text" id="<?php echo $this->plugin_name; ?>-application_id" name="<?php echo $this->plugin_name; ?>[application_id]" value="<?php if( ! empty( $application_id ) ) echo $application_id; else echo ''; ?>"/>
                </td>
            </tr>
            <tr>
                <th scope="row">
                    <label for="algolia-search-integration-search_key"><?php esc_attr_e( 'Search-only API key', 'plugin_name' ); ?></label>
                </th>
                <td>
                <input type="text" class="regular-text" id="<?php echo $this->plugin_name; ?>-search_key" name="<?php echo $this->plugin_name; ?>[search_key]" value="<?php if( ! empty( $search_key ) ) echo $search_key; else echo ''; ?>"/>
                </td>
            </tr>
            <tr>
                <th scope="row">
                    <label for="algolia-search-integration-application_id"><?php esc_attr_e( 'Admin API key', 'plugin_name' ); ?></label>
                </th>
                <td>
                <input type="password" class="regular-text" id="<?php echo $this->plugin_name; ?>-admin_key" name="<?php echo $this->plugin_name; ?>[admin_key]" value="<?php if( ! empty( $admin_key ) ) echo $admin_key; else echo ''; ?>"/>
                </td>
            </tr>
            <tr>
                <th scope="row">
                    <label for="algolia-search-integration-application_id"><?php esc_attr_e( 'Indices name', 'plugin_name' ); ?></label>
                </th>
                <td>
                <input type="text" class="regular-text" id="<?php echo $this->plugin_name; ?>-indices_name" name="<?php echo $this->plugin_name; ?>[indices_name]" value="<?php if( ! empty( $indices_name ) ) echo $indices_name; else echo ''; ?>"/>
                </td>
            </tr>
        </tbody>
    </table>
    <?php submit_button( __( 'Save', 'plugin_name' ), 'primary','submit', TRUE ); ?>
    </form>
</div>


<!-- This file should primarily consist of HTML with a little bit of PHP. -->

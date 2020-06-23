<?php
/**
 * QuietChangeStatus Plugin for MantisBT
 * @link https://github.com/Association-cocktail/QuietChangeStatus
 *
 * @author    Marc-Antoine TURBET-DELOF<marc-antoine.turbet-delof@asso-cocktail.fr>
 * @copyright Copyright (c) 2020 Association Cocktail, Marc-Antoine TURBET-DELOF
 */

form_security_validate( 'plugin_QuietChangeStatus_config_edit' );

auth_reauthenticate( );
access_ensure_global_level( config_get( 'manage_plugin_threshold' ) );

$g_new_custom_field_name = gpc_get_string( 'custom_field_name', '' );
$g_new_no_change_name    = gpc_get_string( 'no_change_name'   , '' );
$g_new_disable_name      = gpc_get_string( 'disable_name'     , '' );

if( plugin_config_get( 'custom_field_name', '' ) != $g_new_custom_field_name ) {
    plugin_config_set( 'custom_field_name',         $g_new_custom_field_name );
}
if( plugin_config_get( 'no_change_name', '' ) != $g_new_no_change_name ) {
    plugin_config_set( 'no_change_name',         $g_new_no_change_name );
}
if( plugin_config_get( 'disable_name', '' ) != $g_new_disable_name ) {
    plugin_config_set( 'disable_name',         $g_new_disable_name );
}


form_security_purge( 'plugin_QuietChangeStatus_config_edit' );

print_successful_redirect( plugin_page( 'config_page', true ) );


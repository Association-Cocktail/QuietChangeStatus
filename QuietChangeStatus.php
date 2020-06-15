<?php
/**
 * QuietChangeStatus Plugin for MantisBT
 * @link https://github.com/Association-cocktail/QuietChangeStatus
 *
 * @author    Marc-Antoine TURBET-DELOF<marc-antoine.turbet-delof@asso-cocktail.fr>
 * @copyright Copyright (c) 2020 Association Cocktail, Marc-Antoine TURBET-DELOF
 */

class QuietChangeStatusPlugin extends MantisPlugin {
	/**
	 * A method that populates the plugin information and minimum requirements.
	 * @return void
	 */
	function register() {
		$this->name = plugin_lang_get( 'title' );    # Proper name of plugin
		$this->description = plugin_lang_get( 'description' );    # Short description of the plugin
		$this->page = 'config_page';           # Default plugin page

		$this->version = '0.0.2';     # Plugin version string
		$this->requires = array(    # Plugin dependencies
		    'MantisCore' => '2.24',  # Should always depend on an appropriate
		                            # version of MantisBT
		);

		$this->author = 'Association Cocktail';         # Author/team name
		$this->contact = 'resp-infra@asso-cocktail.fr';        # Author/team e-mail address
		$this->url = 'https://github.com/Association-Cocktail/QuietChangeStatus';            # Support webpage
    }

	public function config() {
		return array(
			'custom_field_name' => '',
			'no_change_name'    => '',
			'disable_name'      => '',
		);
	}

	function hooks() {
        return array(
            'EVENT_UPDATE_BUG_STATUS_FORM' => 'quiet_reset' ,
            'EVENT_UPDATE_BUG'             => 'quiet_action',
        );
    }


	/**
	 * Reset Custom Field Quiet
	 * @param int Bug ID
	 */
	function quiet_reset( $p_event, $p_bug_id ) {
		$t_custom_field_name = plugin_config_get( 'custom_field_name', '' );
		$t_no_change_name    = plugin_config_get( 'no_change_name'   , '' );
		$t_cf_id = custom_field_get_id_from_name( $t_custom_field_name );
		$t_project_id = bug_get_field( $p_bug_id, 'project_id' );
		$t_related_cf_ids = custom_field_get_linked_ids( $t_project_id );
		if( in_array( $t_cf_id, $t_related_cf_ids ) ) {
			$t_cf_def = custom_field_get_definition( $t_cf_id );
			$t_old_cf_value = custom_field_get_value( $t_cf_id, $p_bug_id );
			custom_field_set_value( $t_cf_id, $p_bug_id, $t_no_change_name );
		}
	}

	/**
	 * Disable email notification if Custom Field say it
	 */
	function quiet_action( $p_event ) {
		$t_custom_field_name = plugin_config_get( 'custom_field_name', '' );
		$t_disable_name      = plugin_config_get( 'disable_name'     , '' );
		$t_cf_id  = custom_field_get_id_from_name(  $t_custom_field_name );
		$t_cf_def = custom_field_get_definition( $t_cf_id );
		$t_new_cf_value = gpc_get_custom_field( 'custom_field_' . $t_cf_id, $t_cf_def['type'], '' );
		if( $t_disable_name == $t_new_cf_value ) {
			$t_option = "enable_email_notification";
			$t_value  = OFF;
			config_set_global( $t_option, $t_value );
		}
	}
}


<?php
/**
 * QuietChangeStatus Plugin for MantisBT
 * @link https://github.com/Association-cocktail/QuietChangeStatus
 *
 * @author	Marc-Antoine TURBET-DELOF<marc-antoine.turbet-delof@asso-cocktail.fr>
 * @copyright Copyright (c) 2020 Association Cocktail, Marc-Antoine TURBET-DELOF
 */

require_api( 'helper_api.php' );

auth_reauthenticate();
access_ensure_global_level( config_get( 'manage_plugin_threshold' ) );

layout_page_header( plugin_lang_get( 'title' ) );

layout_page_begin( 'manage_overview_page.php' );
print_manage_menu( 'manage_plugin_page.php' );

$t_all_ids = custom_field_get_ids();
$t_all_defs = array();
$t_all_defs = multi_sort( $t_all_defs, 'name' );

$t_file_table = plugin_table('file');

$t_form_security_field  = form_security_field( 'plugin_QuietChangeStatus_config_edit' );
?>

<div class="col-md-12 col-xs-12">
<div class="space-10"></div>
<div class="form-container" >

	<form method="post" action="<?php echo plugin_page('config_edit') ?>">
		<?php echo $t_form_security_field ?>
		<div class="widget-box widget-color-blue2">
		<div class="widget-header widget-header-small">
			<h4 class="widget-title lighter">
				<i class="ace-icon fa fa-text-width"></i>
				<?php echo plugin_lang_get( 'title' ) . ': ' . plugin_lang_get( 'config' )?>
			</h4>
		</div>
		<div class="widget-body">
		<div class="widget-main no-padding">
		<div class="table-responsive">
		<!--table align="center" class="width75" cellspacing="1"-->
		<table class="table table-bordered table-condensed table-striped">
		
		<tr>
			<th class="category">
				<?php echo plugin_lang_get( 'custom_field_name' ); ?>
			</th>
			<td>
	            <select name="custom_field_name" class="input-sm">
					<?php
						foreach( $t_all_ids as $t_id ){
							$t_cf_name = string_display_line( custom_field_get_field( $t_id, 'name' ));
			    	?>
						<option value=<?php echo '"' . $t_cf_name . '"';
							check_selected( plugin_config_get('custom_field_name', ''), $t_cf_name ); ?>
						><?php echo $t_cf_name; ?></option>
	            	<?php
		        	    } # foreach end
	            	?>
				</select>
			</td>
		</tr>
		
		<tr>
			<th class="category">
				<?php echo plugin_lang_get( 'no_change_name' ); ?>
			</th>
			<td>
				<input type='text' name="no_change_name" size="120" value="<?php echo plugin_config_get('no_change_name', '') ?>" />
			</td>
		</tr>
		
		<tr>
			<th class="category">
				<?php echo plugin_lang_get( 'disable_name' ); ?>
			</th>
			<td>
				<input type='text' name="disable_name" size="120" value="<?php echo plugin_config_get('disable_name', '') ?>" />
			</td>
		</tr>
		
		</table>
		</div>
		</div>
			<div class="widget-toolbox padding-8 clearfix">
				<button class="btn btn-primary btn-white btn-round">
					<?php echo lang_get( 'change_configuration' ) ?>
				</button>
			</div>
		</div>
		</div>
		</form>

	</div>
</div>


<?php
layout_page_end();


<?php
auth_reauthenticate();
access_ensure_global_level( config_get( 'manage_plugin_threshold' ) );

form_security_validate( 'plugin_autoassign_delete' );

$f_id = gpc_get_int( 'id' );

$t_table = plugin_table( 'policy' );

$t_query = "SELECT project_id FROM $t_table WHERE id=" . db_param();
$t_result = db_query( $t_query, array( $f_id ) );
$t_project_id = db_result( $t_result );

$t_query = "DELETE FROM $t_table WHERE id=" . db_param();
db_query( $t_query, array( $f_id ) );

print_successful_redirect( plugin_page( 'config', true ) . '&project_id=' . $t_project_id );

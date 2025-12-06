<?php
auth_reauthenticate();
access_ensure_global_level( config_get( 'manage_plugin_threshold' ) );

form_security_validate( 'plugin_autoassign_add' );

$f_project_id = gpc_get_int( 'project_id' );
$f_reporter_id = gpc_get_int( 'reporter_id' );
$f_developer_id = gpc_get_int( 'developer_id' );

$t_table = plugin_table( 'policy' );

$t_query = "INSERT INTO $t_table ( project_id, reporter_id, developer_id ) VALUES ( " . db_param() . ", " . db_param() . ", " . db_param() . " )";
db_query( $t_query, array( $f_project_id, $f_reporter_id, $f_developer_id ) );

form_security_purge( 'plugin_autoassign_add' );

print_successful_redirect( plugin_page( 'config', true ) . '&project_id=' . $f_project_id );

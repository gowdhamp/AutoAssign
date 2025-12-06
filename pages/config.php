<?php
auth_reauthenticate();
access_ensure_global_level( config_get( 'manage_plugin_threshold' ) );

layout_page_header( plugin_lang_get( 'title' ) );

layout_page_begin( 'manage_overview_page.php' );

print_manage_menu( 'manage_plugin_page.php' );

$f_selected_project = gpc_get_int( 'project_id', helper_get_current_project() );
if ( $f_selected_project == ALL_PROJECTS ) {
    $f_selected_project = 0;
}

$t_table = plugin_table( 'policy' );
$t_query = "SELECT * FROM $t_table";
if ( $f_selected_project > 0 ) {
    $t_query .= " WHERE project_id=" . db_param();
    $t_result = db_query( $t_query, array( $f_selected_project ) );
} else {
    $t_result = db_query( $t_query );
}
?>

<script type="text/javascript" src="<?php echo plugin_file( 'autoassign.js' ) ?>"></script>

<div class="col-md-12 col-xs-12">
<div class="space-10"></div>

<div class="widget-box widget-color-blue2">
	<div class="widget-header widget-header-small">
		<h4 class="widget-title lighter">
			<i class="ace-icon fa fa-text-width"></i>
			<?php echo plugin_lang_get( 'title' ) . ': ' . plugin_lang_get( 'config' ) ?>
		</h4>
	</div>

	<div class="widget-body">
		<div class="widget-main no-padding">
            <div class="widget-toolbox padding-8 clearfix">
                <form action="<?php echo plugin_page( 'config', true ) ?>" method="get" class="form-inline" id="filter-form">
                    <input type="hidden" name="page" value="AutoAssign/config" />
                    <label class="inline">
                        <?php echo plugin_lang_get( 'project' ) ?>:
                        <select name="project_id" id="project_id_filter" class="input-sm">
                            <?php print_project_option_list( $f_selected_project ) ?>
                        </select>
                    </label>
                </form>
            </div>

			<div class="table-responsive">
				<table class="table table-striped table-bordered table-condensed">
					<thead>
						<tr>
							<th><?php echo plugin_lang_get( 'project' ) ?></th>
							<th><?php echo plugin_lang_get( 'reporter' ) ?></th>
							<th><?php echo plugin_lang_get( 'developer' ) ?></th>
							<th><?php echo plugin_lang_get( 'actions' ) ?></th>
						</tr>
					</thead>
					<tbody>
						<?php while( $t_row = db_fetch_array( $t_result ) ) { ?>
						<tr>
							<td><?php echo string_display_line( project_get_name( $t_row['project_id'] ) ) ?></td>
							<td><?php echo string_display_line( user_get_name( $t_row['reporter_id'] ) ) ?></td>
							<td><?php echo string_display_line( user_get_name( $t_row['developer_id'] ) ) ?></td>
							<td>
								<form action="<?php echo plugin_page( 'delete' ) ?>" method="post">
									<?php echo form_security_field( 'plugin_autoassign_delete' ) ?>
									<input type="hidden" name="id" value="<?php echo $t_row['id'] ?>"/>
									<button type="submit" class="btn btn-xs btn-primary btn-white btn-round">
										<?php echo plugin_lang_get( 'delete' ) ?>
									</button>
								</form>
							</td>
						</tr>
						<?php } ?>
					</tbody>
				</table>
			</div>
		</div>
        
        <?php if ( $f_selected_project > 0 ) { ?>
		<div class="widget-toolbox padding-8 clearfix">
            <form action="<?php echo plugin_page( 'add' ) ?>" method="post" class="form-inline">
                <?php echo form_security_field( 'plugin_autoassign_add' ) ?>
                <input type="hidden" name="project_id" value="<?php echo $f_selected_project ?>" />
                
                <label class="inline">
                    <?php echo plugin_lang_get( 'reporter' ) ?>:
                    <select name="reporter_id" class="input-sm">
                        <?php
                        $t_table = plugin_table( 'policy' );
                        $t_query = "SELECT reporter_id FROM $t_table WHERE project_id=" . db_param();
                        $t_result = db_query( $t_query, array( $f_selected_project ) );
                        $t_assigned_reporters = array();
                        while( $t_row = db_fetch_array( $t_result ) ) {
                            $t_assigned_reporters[] = $t_row['reporter_id'];
                        }

                        $t_users = project_get_all_user_rows( $f_selected_project, REPORTER );
                        foreach ( $t_users as $t_user ) {
                            if ( !in_array( $t_user['id'], $t_assigned_reporters ) ) {
                                echo '<option value="' . $t_user['id'] . '">' . string_display_line( user_get_name( $t_user['id'] ) ) . '</option>';
                            }
                        }
                        ?>
                    </select>
                </label>
                <label class="inline">
                    <?php echo plugin_lang_get( 'developer' ) ?>:
                    <select name="developer_id" class="input-sm">
                        <?php
                        $t_users = project_get_all_user_rows( $f_selected_project, DEVELOPER );
                        foreach ( $t_users as $t_user ) {
                            echo '<option value="' . $t_user['id'] . '">' . string_display_line( user_get_name( $t_user['id'] ) ) . '</option>';
                        }
                        ?>
                    </select>
                </label>
                <button type="submit" class="btn btn-primary btn-white btn-round">
                    <?php echo plugin_lang_get( 'add' ) ?>
                </button>
            </form>
		</div>
        <?php } ?>
	</div>
</div>
</div>

<?php
layout_page_end();

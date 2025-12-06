<?php
/**
 * AutoAssign Plugin
 *
 * This plugin hooks into the bug reporting event to automatically assign bugs.
 */

class AutoAssignPlugin extends MantisPlugin {

	/**
	 * A method that populates the plugin information and minimum requirements.
	 * @return void
	 */
	function register() {
		$this->name = 'AutoAssign';
		$this->description = 'Automatically assigns handler to new bugs based on predefined rules.';
		$this->version = '1.0';
		$this->requires = array(
			'MantisCore' => '2.0.0',
		);
		$this->author = 'Poorna Team';
		$this->contact = 'support@poorna.net';
		$this->url = 'https://poorna.net';
		$this->page = 'config';
	}

	/**
	 * Register event hooks for plugin.
	 * @return array
	 */
	function hooks() {
		return array(
			'EVENT_REPORT_BUG' => 'bug_reported',
		);
	}

	/**
	 * Schema definition for the plugin.
	 * @return array
	 */
	function schema() {
		return array(
			array( 'CreateTableSQL', array( plugin_table( 'policy' ), "
				id			I		NOTNULL UNSIGNED PRIMARY AUTOINCREMENT,
				project_id	I		UNSIGNED NOTNULL DEFAULT '0',
				developer_id	I		UNSIGNED NOTNULL DEFAULT '0',
				reporter_id	I		UNSIGNED NOTNULL DEFAULT '0'" ) ),
			array( 'CreateIndexSQL', array( 'idx_plugin_autoassign_project_reporter', plugin_table( 'policy' ), 'project_id, reporter_id', array( 'UNIQUE' ) ) ),
		);
	}

	/**
	 * Hook function for EVENT_REPORT_BUG.
	 *
	 * @param string $p_event The event name.
	 * @param BugData $p_issue_object The bug data object.
	 * @param int $p_issue_id The bug ID.
	 * @return void
	 */
	function bug_reported( $p_event, $p_issue_object, $p_issue_id ) {
		$t_table = plugin_table( 'policy' );
		$t_project_id = $p_issue_object->project_id;
		$t_reporter_id = $p_issue_object->reporter_id;

		$t_query = "SELECT developer_id FROM $t_table WHERE project_id=" . db_param() . " AND reporter_id=" . db_param();
		$t_result = db_query( $t_query, array( $t_project_id, $t_reporter_id ) );

		if( db_num_rows( $t_result ) > 0 ) {
			$t_row = db_fetch_array( $t_result );
			$t_developer_id = $t_row['developer_id'];

			if( $t_developer_id != 0 && user_exists( $t_developer_id ) ) {
				bug_assign( $p_issue_id, $t_developer_id );
				log_event( LOG_PLUGIN, "AutoAssign: Bug $p_issue_id assigned to user $t_developer_id" );
			}
		}
	}
}

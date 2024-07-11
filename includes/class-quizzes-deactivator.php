<?php

/**
 * Fired during plugin deactivation
 *
 * @link       https://mesvak.software
 * @since      1.0.0
 *
 * @package    Quizzes
 * @subpackage Quizzes/includes
 */

/**
 * Fired during plugin deactivation.
 *
 * This class defines all code necessary to run during the plugin's deactivation.
 *
 * @since      1.0.0
 * @package    Quizzes
 * @subpackage Quizzes/includes
 * @author     mesvak <mesvakc@gmail.com>
 */
class Quizzes_Deactivator {

	/**
	 * Short Description. (use period)
	 *
	 * Long Description.
	 *
	 * @since    1.0.0
	 */
	public static function deactivate() {
		      global $wpdb;
        $table_name = $wpdb->prefix . 'quizzes_meta';
        $rating_table_name = $wpdb->prefix . 'rating_scale';

        $wpdb->query("DROP TABLE IF EXISTS $table_name");
        $wpdb->query("DROP TABLE IF EXISTS $rating_table_name");

	}

}

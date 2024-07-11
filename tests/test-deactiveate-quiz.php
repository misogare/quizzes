<?php
class QuizzesDeactivationTest extends WP_UnitTestCase {

  

    public function tearDown(): void {
        parent::tearDown();

        // Manually deactivate the plugin after each test method
        deactivate_quizzes();
    }

    public function test_tables_exist_before_deactivation() {
        global $wpdb;

        $table_name = $wpdb->prefix . 'quizzes_meta';
        $this->assertTrue($wpdb->get_var("SHOW TABLES LIKE '$table_name'") === $table_name, "Table $table_name should exist before deactivation.");

        $rating_table_name = $wpdb->prefix . 'rating_scale';
        $this->assertTrue($wpdb->get_var("SHOW TABLES LIKE '$rating_table_name'") === $rating_table_name, "Table $rating_table_name should exist before deactivation.");
    }

    public function test_tables_do_not_exist_after_deactivation() {
        global $wpdb;

        // Trigger deactivation explicitly within the test method
        deactivate_quizzes();

        $table_name = $wpdb->prefix . 'quizzes_meta';
        $this->assertFalse($wpdb->get_var("SHOW TABLES LIKE '$table_name'") === $table_name, "Table $table_name should not exist after deactivation.");

        $rating_table_name = $wpdb->prefix . 'rating_scale';
        $this->assertFalse($wpdb->get_var("SHOW TABLES LIKE '$rating_table_name'") === $rating_table_name, "Table $rating_table_name should not exist after deactivation.");
    }
}

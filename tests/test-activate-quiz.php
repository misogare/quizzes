<?php
class QuizzesActivationTest extends WP_UnitTestCase {
    
    public static function setUpBeforeClass(): void {
        parent::setUpBeforeClass();

        // Manually activate the plugin
        activate_quizzes();
    }
   
    public function setUp(): void {
        parent::setUp();
        
        // You can add additional setup here if needed
    }

    public function tearDown(): void {
        // Clean up after each test if needed
        parent::tearDown();
    }

    public function test_activate_quizzes() {
        global $wpdb;

         $quiz_table_name = $wpdb->prefix . 'quizzes_meta';
        $rating_table_name = $wpdb->prefix . 'rating_scale';

        // Check if tables are created
        $this->assertEquals($quiz_table_name, $wpdb->get_var("SHOW TABLES LIKE '$quiz_table_name'"));
        $this->assertEquals($rating_table_name, $wpdb->get_var("SHOW TABLES LIKE '$rating_table_name'"));
    }
}

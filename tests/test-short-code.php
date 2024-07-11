<?php
/**
 * Class QuizzesShortcodeTest
 *
 * @package Quizzes
 */

/**
 * Tests for the quizzes shortcode.
 */
class QuizzesShortcodeTest extends WP_UnitTestCase {

   
         public static function setUpBeforeClass(): void {
        parent::setUpBeforeClass();

        // Manually activate the plugin
        activate_quizzes();
    }
      public  static function tearDownAfterClass(): void {
        parent::tearDownAfterClass();

        // Manually deactivate the plugin after each test method
        deactivate_quizzes();
    }
     /**
     * Test the quizzes shortcode output.
     * @group now
     */
    public function test_quizzes_shortcode() {
        // Create sample data in the database
        global $wpdb;
        $quiz_table_name = $wpdb->prefix . 'quizzes_meta';
        $rating_table_name = $wpdb->prefix . 'rating_scale';

        // Sample quiz data
        $wpdb->insert($quiz_table_name, array(
            'quiz_id' => 1,
            'section' => 'Section 1',
            'id_fk' => 1,
            'question' => 'Sample Question 1'
        ));

        // Sample rating scale data
        $wpdb->insert($rating_table_name, array(
            'quiz_id' => 1,
            'label' => 'Sample Rating'
        ));

        // Execute the shortcode
        $output = do_shortcode('[quizzes quiz_id="1"]');

        // Check if the output contains the expected HTML structure
        $this->assertStringContainsString('quiz-container', $output);
        $this->assertStringContainsString('Sample Question 1', $output);
        $this->assertStringContainsString('Sample Rating', $output);
    }
}

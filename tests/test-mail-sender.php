<?php
require_once dirname(__DIR__) . '/vendor/autoload.php';

/**
 * Class QuizzesAjaxTest
 *
 * @package Quizzes
 */

/**
 * Test the AJAX handler for sending quiz feedback.
 */
class QuizzesAjaxTest extends WP_Ajax_UnitTestCase {
    protected $_mock_mail_sent = false;
    protected $mailpoet_api_mock;

    public function setUp(): void {
        parent::setUp();

        $this->mailpoet_api_mock = $this->createMock(\MailPoet\API\API::class);
        // Overriding the static method to return the mock instance
        $GLOBALS['MailPoet\API\API::MP'] = function ($version) {
            return $this->mailpoet_api_mock;
        };
    }

    public function tearDown(): void {
        // Clean up after each test if needed
        parent::tearDown();
    }

    /**
     * Test the send_quiz_feedback AJAX handler.
     * @group helper 
     */
    public function test_send_quiz_feedback() {
        // Set up mock data for the AJAX request
        $email = 'test@example.com';
        $user_score = 150;
        $first_name = 'Test';
        $section_scores = array('Section 1' => 20, 'Section 2' => 15);
        $quiz_id = 1;

        // Mock the POST request
        $_POST['user_email'] = $email;
        $_POST['user_score'] = $user_score;
        $_POST['first_name'] = $first_name;
        $_POST['section_scores'] = json_encode($section_scores);
        $_POST['quiz_id'] = $quiz_id;

        // Ensure the AJAX handler function exists
        $this->assertTrue(function_exists('send_quiz_feedback'));

        // Mock wp_mail function to prevent actual email sending
        add_filter('wp_mail', array($this, 'mock_wp_mail'));

        // Mock wp_die to prevent it from stopping the test
        add_filter('wp_die_handler', function ($function) {
            return function ($message, $title = '', $args = array()) {
                throw new WPAjaxDieContinueException($message);
            };
        });

        // Mock the MailPoet API methods
        $this->mailpoet_api_mock->method('getSubscriber')
            ->willReturn(['subscriptions' => [['segment_id' => 3]]]);

        $this->mailpoet_api_mock->method('subscribeToLists')
            ->willReturn(true);

        $this->mailpoet_api_mock->method('addSubscriber')
            ->willReturn(true);

        // Set up AJAX action
        try {
            $this->_handleAjax('send_quiz_feedback');
        } catch (WPAjaxDieContinueException $e) {
            // This exception is expected due to wp_die mocking
        } catch (WPAjaxDieStopException $e) {
            // This exception should not be thrown
            $this->fail('WPAjaxDieStopException was thrown: ' . $e->getMessage());
        } catch (Exception $e) {
            // Handle unexpected exceptions
            $this->fail('An unexpected exception was thrown: ' . $e->getMessage());
        }

        // Check if the response is successful
        $this->assertNotEmpty($this->_last_response);

        // Check if the email mock was sent
        $this->assertTrue($this->_mock_mail_sent, 'Email was not sent.');
    }

    /**
     * Mock function to replace wp_mail during testing.
     *
     * @param array $args Arguments passed to wp_mail.
     * @return bool Always returns true to simulate successful email sending.
     */
    public function mock_wp_mail($args) {
        $this->_mock_mail_sent = true; // Flag to indicate email mock was sent
        return true; // Simulate successful email sending
    }
}
?>

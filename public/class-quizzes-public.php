<?php
require_once plugin_dir_path( __FILE__ ) . 'class-quizzes-helper.php';
/**
 * The public-facing functionality of the plugin.
 *
 * @link       https://mesvak.software
 * @since      1.0.0
 *
 * @package    Quizzes
 * @subpackage Quizzes/public
 */

/**
 * The public-facing functionality of the plugin.
 *
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the public-facing stylesheet and JavaScript.
 *
 * @package    Quizzes
 * @subpackage Quizzes/public
 * @author     mesvak <mesvakc@gmail.com>
 */
class Quizzes_Public {

	/**
	 * The ID of this plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      string    $plugin_name    The ID of this plugin.
	 */
	private $plugin_name;

	/**
	 * The version of this plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      string    $version    The current version of this plugin.
	 */
	private $version;

	/**
	 * Initialize the class and set its properties.
	 *
	 * @since    1.0.0
	 * @param      string    $plugin_name       The name of the plugin.
	 * @param      string    $version    The version of this plugin.
	 */
	public function __construct( $plugin_name, $version ) {

		$this->plugin_name = $plugin_name;
		$this->version = $version;

	}
	function quizzes_shortcode($atts) {
    global $wpdb;
     $atts = shortcode_atts( array(
        'quiz_id' => 1, // Default to quiz ID 1
    ), $atts, 'quizzes' );

    $quiz_id = intval($atts['quiz_id']);
            error_log("Processing question ID: $quiz_id");

    $quiz_table_name = $wpdb->prefix . 'quizzes_meta';
    $rating_table_name = $wpdb->prefix . 'rating_scale';

    // Fetch the quiz data from the database
    $quiz_data = $wpdb->get_results($wpdb->prepare("SELECT * FROM $quiz_table_name WHERE quiz_id = %d ORDER BY id ASC", $quiz_id));

    // Fetch the rating scale from the database
    $rating_scale = $wpdb->get_results($wpdb->prepare("SELECT * FROM $rating_table_name WHERE quiz_id = %d", $quiz_id), OBJECT_K);
    if (empty($quiz_data)) {
        return 'No questions found for this quiz.';
    }
    $current_section = '';
    $output = "<div class='quiz-container' id='quiz-container-$quiz_id'>";


$output .= '<div class="progress-bar-container"><div class="progress-bar"></div></div>'; // Progress bar

// Logging start of quiz_data loop
error_log('Start processing quiz_data loop');

foreach ($quiz_data as $question) {
    // Logging current question ID
    error_log("Processing question ID: $question->id");

    if ($question->section !== $current_section) {
        if ($current_section !== '') {
            $output .= '</div>'; // Close previous section
        }
        $current_section = $question->section;
        $output .= "<div class='quiz-section' id='section-$question->section' data-section-score='0' style='visibility: hidden; height: 0;'>";
        $output .= "<h2>$current_section</h2>"; // Section title

        // Logging section change
        error_log("Switching to section: $current_section");
    }

  $output .= "<div class='quiz-question-container' id='question-container-$question->id' style='visibility: hidden; height: 0;'>";
    $output .= "<div class='quiz-question' id='question-$question->id'>";
    $output .= "<p class='question-text'>$question->id_fk. $question->question</p>"; // Question text with ID


    // Logging rating options
    error_log("Adding rating options for question ID: $question->id");

    $output .= "<div class='rating-container'>";
    foreach ($rating_scale as $rating) {
        $output .= "<div class='wrapper rate_wrap'>";
        $output .= "<input class='state' type='radio' name='question-$question->id' id='rating-$rating->id-question-$question->id' value='$rating->id'>";
        $output .= "<label class='label' for='rating-$rating->id-question-$question->id'>";
        $output .= "<div class='indicator'></div>";
        $output .= "<span class='text' style='margin-left: 10px;'>$rating->label</span>"; // Adjusted margin-left for spacing
        $output .= "</label></div>";
    }
    $output .= '</div>'; // End rating-container
    $output .= '</div>'; // End quiz-question
    $output .= '</div>'; // End quiz-question-container
}

// Closing tags for remaining open elements
if (!empty($current_section)) {
    $output .= '</div>'; // Close last section

    // Logging last section closing
    error_log("Closing last section: $current_section");
}
$output .= '</div>'; // Close quiz-container

// Logging completion of quiz_data loop
error_log('Completed processing quiz_data loop');

// Navigation buttons, completion message, and feedback form


 $output .= "<div id='davai' class='container3 elementor-button-wrapper'>";
     $output .= "<button id='prev-question' class='btn hypnotic-btn elementor-button elementor-button-link elementor-size-sm'>";
    $output .= "<span class='elementor-button-content-wrapper'>";
    $output .= "<span class='elementor-button-text'> < </span>";
    $output .= "</span>";
    $output .= "</button>";
     $output .= "<button id='next-question' class='btn hypnotic-btn elementor-button elementor-button-link elementor-size-sm'>";
    $output .= "<span class='elementor-button-content-wrapper'>";
    $output .= "<span class='elementor-button-text'> > </span>";
    $output .= "</span>";
    $output .= "</button>";
    $output .= '</div>'; // Close button next prev
$output .= "<div class='button-container elementor-button-wrapper' style='display: none;'>"; // Hidden initially
$output .= "</div>";
$output .= "<div id='completion-message' class='quiz-completion-message' style='visibility: hidden; height: 0;'>";
$output .= "<p>Congratulations! You have completed the quiz.</p>";
$output .= "</div>";
    $output .= "<div id='feedback-form' class='quiz-completion-message' style='visibility: hidden; height: 0;'>";
    $output .= "<p> </p>";
    $output .= "<form id='quiz-feedback-form'>";
        $output .= "<input type='hidden' name='quiz_id' value='$quiz_id'>"; // Hidden input for quiz_id
    $output .= "<input type='string' name='first_name' placeholder='Enter Your Name' required>";
    $output .= "<input id='email_sub' type='email' name='user_email' placeholder='Enter your email' required>";
    $output .= "<input type='hidden' name='user_score' id='user_score'>";
    $output .= "<input type='hidden' name='section_scores' id='section_scores'>";
    $output .= "<div class='container4 elementor-button-wrapper'>";
    $output .= "<button type='submit' id='send-feedback-button' class='btn hypnotic-btn elementor-button elementor-button-link elementor-size-sm'>";
    $output .= "<span class='elementor-button-content-wrapper'>";
    $output .= "<span class='elementor-button-text'>Send</span>";
    $output .= "</span>";
    $output .= "</button>";
    $output .= "</div>";
    $output .= "</form>";
    $output .= "</div>";

    return $output;
}


function send_quiz_feedback() {
    // Validate and sanitize input data
   $user_email = sanitize_email($_POST['user_email']);
    $user_score = intval($_POST['user_score']);
    $first_name = $_POST['first_name'];
    $section_scores = json_decode(stripslashes($_POST['section_scores']), true);
    $quiz_id = intval($_POST['quiz_id']);

    if (json_last_error() !== JSON_ERROR_NONE) {
        error_log("JSON Decode Error: " . json_last_error_msg());
        $section_scores = [];
    }

    // Logging for debugging
    error_log('Section Scores JSON: ' . print_r($section_scores, true));


    // Determine feedback based on user score
    $feedback = Quizzes_Helper::get_user_score_feedback($quiz_id,$user_score);
        error_log('Section Scores JSON: ' .$feedback);

    // Prepare section score feedback
    $section_feedback = "\n\nSection Scores:\n";
 foreach ($section_scores as $section_id => $section_score) {
        $clean_section_id = str_replace('section-', '', $section_id);
        $section_block = Quizzes_Helper::get_section_score_block($clean_section_id , $section_score);
        error_log('section block + description'. $section_block);
        $section_feedback .=  "<tr>
            <td><strong>Section:</strong> $clean_section_id</td>
            <td><strong>Score:</strong> $section_score</td>
            <td><strong>Description:</strong> $section_block</td>
        </tr>";
    }

    $marketing_content = "
<div class='marketing-section' style='background-color: #f2f2f2; padding: 20px; border-radius: 10px; margin-top: 20px;'>
    <h3 style='text-align: center; color: #333;'>Ready to explore more?</h3>
    <p style='text-align: center; color: #555; font-size: 1.1em;'>Unlock your potential with a <strong>90-minute initial session</strong> focused on discovering your self-worth and enhancing your relationships.</p>
    <p style='text-align: center; margin-top: 20px;'>
        <a href='https://calendly.com/intuitivetherapist/30min' style='display: inline-block; padding: 12px 24px; background-color: #007bff; color: #fff; text-decoration: none; border-radius: 5px;'>Book Your Session</a>
    </p>
</div>";

    // Prepare and send the email
    $subject = "Your Quiz Feedback";
 $message = "
<html>
<head>
    <title>Your Quiz Feedback</title>
    <style>
        /* Your existing styles */
        body {
            font-family: Arial, sans-serif;
            line-height: 1.6;
        }
        .container {
            width: 100%;
            margin: auto;
            padding: 20px;
            box-sizing: border-box;
            background-color: #f9f9f9;
        }
        .header {
            text-align: center;
            padding: 10px;
        }
        .score {
            font-size: 1.2em;
            margin-bottom: 10px;
        }
        .feedback {
            margin-bottom: 20px;
        }
        .section-feedback {
            width: 100%;
            margin: 20px 0;
            box-sizing: border-box;
            overflow-x: auto;
        }
        .section-feedback table {
            width: 100%;
            border-collapse: collapse;
        }
        .section-feedback th, .section-feedback td {
            border: 1px solid #ddd;
            padding: 8px;
            text-align: left;
        }
        .section-feedback th {
            background-color: #f2f2f2;
        }
        .marketing-section {
            background-color: #f2f2f2;
            padding: 20px;
            border-radius: 10px;
            margin-top: 20px;
        }
        .marketing-section h3 {
            text-align: center;
            color: #333;
        }
        .marketing-section p {
            text-align: center;
            color: #555;
            font-size: 1.1em;
            margin-top: 10px;
        }
        .marketing-section a {
            display: inline-block;
            padding: 12px 24px;
            background-color: #007bff;
            color: #fff;
            text-decoration: none;
            border-radius: 5px;
        }

        /* Media query for responsiveness */
        @media screen and (max-width: 600px) {
            .container {
                padding: 10px;
            }
            .section-feedback {
                overflow-x: auto;
            }
        }
    </style>
</head>
<body>
    <div class='container'>
        <div class='header'>
            <img src='https://localhost/testsite/wp-content/uploads/2024/02/cropped-cropped-46FF61E2-F1A0-4E66-A02E-7C206BA95F7B.png' alt='Your Logo' style='max-width: 100%; height: auto;'>
            <h2 style='margin-top: 10px;'>Quiz Feedback for $first_name</h2>
        </div>
        <div class='score'>
            <p><strong>Your score is:</strong> $user_score</p>
        </div>
        <div class='feedback'>
            <p>$feedback</p>
        </div>
        <div class='section-scores'>
            <h3>Section Scores:</h3>
            <div class='section-feedback'>
                <table>
                    <thead>
                        <tr>
                            <th>Section</th>
                            <th>Score</th>
                            <th>Description</th>
                        </tr>
                    </thead>
                    <tbody>
                        $section_feedback
                    </tbody>
                </table>
            </div>
        </div>
        $marketing_content
    </div>
    <div style='text-align: center; margin-top: 20px;'>
        <p style='font-size: 0.9em; color: #888;'>Connect with us:</p>
        <p>
            <a href='https://www.facebook.com/healoneself/' style='margin-right: 10px;'><img src='https://cdn-images.mailchimp.com/icons/social-block-v3/block-icons-v3/facebook-filled-dark-40.png' alt='Facebook'></a>
            <a href='https://www.instagram.com/healoneself-wellbeing-centre/' style='margin-right: 10px;'><img src='https://cdn-images.mailchimp.com/icons/social-block-v3/block-icons-v3/instagram-filled-dark-40.png' alt='Instagram'></a>
            <a href='https://www.healoneself.com' style='margin-right: 10px;'>Visit our website</a>
        </p>
        <p style='font-size: 0.8em; color: #888;'>© 2024 Your Company. All rights reserved.</p>
    </div>
</body>
</html>";


    // Set the content type for HTML email
    add_filter('wp_mail_content_type', function($content_type) {
        return 'text/html';
    });
    error_log('scoreis'. $message);
    error_log('Sending email to: ' . $user_email);
    $mail_result = wp_mail($user_email, $subject, $message);
    remove_filter('wp_mail_content_type', 'set_html_content_type');
    error_log('Email sent result: ' . ($mail_result ? 'Success' : 'Failure'));
 if (class_exists(\MailPoet\API\API::class)) {
    $mailpoet_api = \MailPoet\API\API::MP('v1');
    $list_id = (3); // The ID of the list to add subscribers to

    error_log('Email address: ' . $user_email);

    try {
        // Attempt to retrieve the subscriber
                    $subscriber = $mailpoet_api->getSubscriber($user_email);

        // Check if the subscriber is already in the list
        $is_in_list = false;
        foreach ($subscriber['subscriptions'] as $subscription) {
            if ($subscription['segment_id'] == $list_id) {
                $is_in_list = true;
                error_log('test1: '.$subscription['segment_id'] );
                break;
            }
        }
        error_log('test2: '.$subscription['segment_id'] );
        // If the subscriber is not in the list, add them
        if (!$is_in_list) {
            $list_id = [3];
           
            $mailpoet_api->subscribeToLists($subscriber['id'], $list_id);
        }
    } catch (Exception $e) {
        // If the subscriber does not exist, catch the exception and create them
        if (strpos($e->getMessage(), 'This subscriber does not exist.') !== false) {
            try {
                $list_id = [3];
                // Subscriber does not exist, create them and add to the list
                $subscriber_data = array(
                    'email' => $user_email,
                    'first_name' => $first_name,
                    // Include other subscriber details as needed
                );
  $options = array(
                    'send_confirmation_email' => false // Disable confirmation email
                );
                $mailpoet_api->addSubscriber($subscriber_data,$list_id,$options);
            } catch (Exception $e) {
                // Handle any exceptions thrown while creating the subscriber
                error_log('Unable to create new subscriber: ' . $e->getMessage());
            }
        } else {
            // Log other exceptions
            error_log('Error: ' . $e->getMessage());
        }
    }
}
  if (defined('DOING_AJAX') && DOING_AJAX && defined('DOING_UNIT_TESTS') && DOING_UNIT_TESTS) {
        return;
    }
    wp_send_json_success('Feedback sent successfully.');
    wp_die(); // Always end AJAX handler functions with wp_die()
}



	/**
	 * Register the stylesheets for the public-facing side of the site.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_styles() {

		/**
		 * This function is provided for demonstration purposes only.
		 *
		 * An instance of this class should be passed to the run() function
		 * defined in Quizzes_Loader as all of the hooks are defined
		 * in that particular class.
		 *
		 * The Quizzes_Loader will then create the relationship
		 * between the defined hooks and the functions defined in this
		 * class.
		 */

		wp_enqueue_style( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'css/quizzes-public.css', array(), $this->version, 'all' );

	}

	/**
	 * Register the JavaScript for the public-facing side of the site.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_scripts() {

		/**
		 * This function is provided for demonstration purposes only.
		 *
		 * An instance of this class should be passed to the run() function
		 * defined in Quizzes_Loader as all of the hooks are defined
		 * in that particular class.
		 *
		 * The Quizzes_Loader will then create the relationship
		 * between the defined hooks and the functions defined in this
		 * class.
		 */
             wp_enqueue_script('jquery');
              wp_enqueue_script('jquery-ui-dialog');
		wp_enqueue_script( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'js/quizzes-public.js', array( 'jquery','jquery-ui-dialog' ), '1.0.2', true );
         wp_localize_script( $this->plugin_name, 'ajax_object1', array( 'ajax_url' => admin_url( 'admin-ajax.php' )) );
	}
   
}

<?php

/**
 * The plugin bootstrap file
 *
 * This file is read by WordPress to generate the plugin information in the plugin
 * admin area. This file also includes all of the dependencies used by the plugin,
 * registers the activation and deactivation functions, and defines a function
 * that starts the plugin.
 *
 * @link              https://mesvak.software
 * @since             1.0.0
 * @package           Quizzes
 *
 * @wordpress-plugin
 * Plugin Name:       quizz
 * Plugin URI:        https://mesvak.software
 * Description:       this is a quiz radio plugin with scoring system 
 * Version:           1.0.0
 * Author:            mesvak
 * Author URI:        https://mesvak.software/
 * License:           GPL-2.0+
 * License URI:       http://www.gnu.org/licenses/gpl-2.0.txt
 * Text Domain:       quizzes
 * Domain Path:       /languages
 */

// If this file is called directly, abort.
if ( ! defined( 'WPINC' ) ) {
	die;
}

/**
 * Currently plugin version.
 * Start at version 1.0.0 and use SemVer - https://semver.org
 * Rename this for your plugin and update it as you release new versions.
 */
define( 'QUIZZES_VERSION', '1.0.0' );

/**
 * The code that runs during plugin activation.
 * This action is documented in includes/class-quizzes-activator.php
 */
function activate_quizzes() {
	require_once plugin_dir_path( __FILE__ ) . 'includes/class-quizzes-activator.php';
	Quizzes_Activator::activate();
     global $wpdb;
    $charset_collate = $wpdb->get_charset_collate();
    $table_name = $wpdb->prefix . 'quizzes_meta';
     $rating_table_name = $wpdb->prefix . 'rating_scale';

       $sql = "CREATE TABLE $table_name  (
        id mediumint(9) NOT NULL AUTO_INCREMENT,
        section varchar(255) NOT NULL,
        question varchar(255) NOT NULL,
        PRIMARY KEY  (id)
    ) $charset_collate;

    CREATE TABLE $rating_table_name (
        id tinyint(1) NOT NULL,
        label varchar(255) NOT NULL,
        PRIMARY KEY  (id)
    ) $charset_collate;";
        require_once(ABSPATH . 'wp-admin/includes/upgrade.php');
    dbDelta($sql);
    

	$quiz = array(
    "Attachment Style" => array(
        "questions" => array(
            "I find it difficult to trust others completely.",
            "I often worry that my partner will leave me.",
            "I prefer to keep my distance in relationships.",
            "I feel uncomfortable when my partner wants too much closeness.",
            "I tend to cling to my partner, fearing abandonment.",
            "I am hesitant to open up emotionally in relationships.",
        ),
    ),
    "Past Trauma or Hurt" => array(
        "questions" => array(
            "I have been deeply hurt in past relationships, and it still affects me.",
            "I find it hard to let go of past relationship baggage.",
            "I often feel anxious or fearful about getting hurt again.",
            "I avoid getting too close to others to protect myself from pain.",
            "I struggle to trust new partners due to past betrayals.",
            "Memories of past heartbreaks make it difficult for me to fully invest in new relationships."
        ),
    ),
   "Self-Esteem and Self-Worth" => array(
    "questions" => array(
        "I often doubt my own worthiness of love and affection.",
        "I feel like I'm not good enough for my partner.",
        "I have a hard time believing that someone could truly love me.",
        "I tend to settle for partners who don't treat me well because I don't think I deserve better.",
        "I frequently criticize myself, especially in the context of relationships.",
        "I struggle to accept compliments or expressions of affection from my partner.",
    ),
   ),
   "Communication Issues" =>  array(
    "questions" => array(
        "I find it challenging to express my feelings openly in relationships.",
        "I often avoid discussing important topics with my partner to avoid conflict.",
        "I struggle to listen attentively to my partner's perspective without becoming defensive.",
        "I tend to shut down emotionally during arguments with my partner.",
        "I have difficulty articulating my needs and desires in a relationship.",
        "I sometimes use passive-aggressive behavior instead of addressing issues directly with my partner.",
    ),
   ),
   "Fear of Vulnerability" =>  array(
    "questions" => array(
        "I avoid sharing personal details or emotions with my partner.",
        "I feel uncomfortable when my partner expresses vulnerability around me.",
        "I worry that showing vulnerability will make me appear weak or needy.",
        "I have a fear of being judged or rejected if I open up to my partner.",
        "I tend to keep my guard up in relationships to avoid getting hurt.",
        "I often downplay my emotions or pretend everything is fine, even when it's not.",
    ),
   ),
   "Unrealistic Expectations" => array(
    "questions" => array(
        "I expect my partner to fulfill all of my emotional needs.",
        "I believe that true love should always be easy and effortless.",
        "I compare my relationship to idealized versions I see in movies or on social media.",
        "I often feel disappointed when my partner doesn't meet my expectations.",
        "I expect my partner to know what I need without me having to ask.",
        "I struggle to accept my partner's flaws and imperfections.",
    ),
   ),
   "Lack of Boundaries" =>  array(
    "questions" => array(
        "I have difficulty saying no to my partner's requests or demands.",
        "I feel guilty when I prioritize my own needs over my partner's.",
        "I often feel taken advantage of in my relationships.",
        "I have a hard time setting clear boundaries with my partner.",
        "I tend to sacrifice my own well-being to keep my partner happy.",
        "I feel uncomfortable asserting myself or expressing disagreement with my partner.",
    ),
   ),
   "Unresolved Issues from Childhood" => array(
    "questions" => array(
        "I notice similarities between my current relationship dynamics and those of my childhood family.",
        "I struggle with feelings of insecurity or inadequacy that stem from my upbringing.",
        "I find it hard to trust others because of experiences in my childhood.",
        "I have unresolved conflicts or traumas from my past that affect my relationships.",
        "I often seek validation or approval from my partner to fill a void from childhood.",
        "I have difficulty forming healthy attachments due to my childhood experiences.",
    ),
   ),
   "Fear of Commitment" => array(
    "questions" => array(
        "I often feel suffocated or trapped in relationships.",
        "I avoid making long-term plans with my partner.",
        "I have a tendency to sabotage relationships when they start to get serious.",
        "I feel anxious or overwhelmed at the thought of settling down with one person.",
        "I struggle to envision a future with my current partner.",
        "I prefer to keep my options open rather than committing to one person.",
    ),
   ),
   "External Stressors" => array(
    "questions" => array(
        "I find it hard to prioritize my relationship when I'm dealing with other stressors in my life.",
        "External pressures, such as work or family obligations, often strain my relationship.",
        "I feel like I don't have enough time or energy to devote to my partner.",
        "Financial worries cause tension between me and my partner.",
        "I have difficulty maintaining intimacy when other aspects of my life are demanding.",
        "I often take out my stress from external sources on my partner.",
    ),
   )
);

$rating_scale = array(
    1 => "Strongly Disagree",
    2 => "Disagree",
    3 => "Neutral",
    4 => "Agree",
    5 => "Strongly Agree",
);
foreach ($quiz as $section => $data) {
        foreach ($data['questions'] as $question) {
            $wpdb->insert(
                $table_name,
                array(
                    'section' => $section,
                    'question' => $question
                )
            );
        }
    }

 foreach ($rating_scale as $score => $label) {
        $wpdb->insert(
            $rating_table_name,
            array(
                'id' => $score,
                'label' => $label
            )
        );
  }
}

/**
 * The code that runs during plugin deactivation.
 * This action is documented in includes/class-quizzes-deactivator.php
 */
function deactivate_quizzes() {
	require_once plugin_dir_path( __FILE__ ) . 'includes/class-quizzes-deactivator.php';
	Quizzes_Deactivator::deactivate();
      global $wpdb;
    $table_name = $wpdb->prefix . 'quizzes_meta';
     $table_name1 = $wpdb->prefix . 'rating_scale';

    $wpdb->query("DROP TABLE IF EXISTS $table_name");
    $wpdb->query("DROP TABLE IF EXISTS $table_name1");
}

register_activation_hook( __FILE__, 'activate_quizzes' );
register_deactivation_hook( __FILE__, 'deactivate_quizzes' );

/**
 * The core plugin class that is used to define internationalization,
 * admin-specific hooks, and public-facing site hooks.
 */
require plugin_dir_path( __FILE__ ) . 'includes/class-quizzes.php';
function quizzes_shortcode() {
    global $wpdb;
    $quiz_table_name = $wpdb->prefix . 'quizzes_meta';
    $rating_table_name = $wpdb->prefix . 'rating_scale';

    // Fetch the quiz data from the database
$quiz_data = $wpdb->get_results("SELECT * FROM $quiz_table_name ORDER BY id ASC");

    // Fetch the rating scale from the database
   $rating_scale = $wpdb->get_results("SELECT * FROM $rating_table_name", OBJECT_K);

$current_section = '';
$output = '<div class="quiz-container">';
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
    $output .= "<p class='question-text'>($question->id) $question->question</p>"; // Question text with ID


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
$output .= "<p>Congratulations! You have completed the quiz. Here is your reward.</p>";
$output .= "</div>";
    $output .= "<div id='feedback-form' class='quiz-completion-message' style='visibility: hidden; height: 0;'>";
    $output .= "<p>Here is your reward.</p>";
    $output .= "<form id='quiz-feedback-form'>";
    $output .= "<input type='string' name='last_name' placeholder='Enter Your Last Name Please' required>";
    $output .= "<input id='email_sub' type='email' name='user_email' placeholder='Enter your email to receive feedback' required>";
    $output .= "<input type='hidden' name='user_score' id='user_score'>";
    $output .= "<input type='hidden' name='section_scores' id='section_scores'>";
    $output .= "<div class='container4 elementor-button-wrapper'>";
    $output .= "<button type='submit' id='send-feedback-button' class='btn hypnotic-btn elementor-button elementor-button-link elementor-size-sm'>";
    $output .= "<span class='elementor-button-content-wrapper'>";
    $output .= "<span class='elementor-button-text'>Send Feedback</span>";
    $output .= "</span>";
    $output .= "</button>";
    $output .= "</div>";
    $output .= "</form>";
    $output .= "</div>";

    return $output;
}


add_shortcode('quizzes', 'quizzes_shortcode');
add_action('wp_ajax_send_quiz_feedback', 'send_quiz_feedback'); // For logged-in users
add_action('wp_ajax_nopriv_send_quiz_feedback', 'send_quiz_feedback'); // For non-logged-in users
function get_user_score_feedback($user_score) {
    if ($user_score >= 60 && $user_score <= 120) {
        return "Individuals in this range generally do not perceive significant blocks to love and intimacy...";
    } elseif ($user_score >= 121 && $user_score <= 180) {
        return "Individuals in this range may experience mild obstacles to love and intimacy...";
    } elseif ($user_score >= 181 && $user_score <= 240) {
        return "Individuals in this range face moderate blocks to love and intimacy...";
    } elseif ($user_score >= 241) {
        return "Individuals in this range experience substantial blocks to love and intimacy...";
    } else {
        return "Error: Score out of expected range.";
    }
}

function get_section_score_block($section_score) {
    if ($section_score >= 6 && $section_score <= 10) {
        return "No Perceived Blocks";
    } elseif ($section_score >= 11 && $section_score <= 15) {
        return "Mild Blocks";
    } elseif ($section_score >= 16 && $section_score <= 20) {
        return "Moderate Blocks";
    } elseif ($section_score >= 21 && $section_score <= 25) {
        return "Substantial Blocks";
    } elseif ($section_score >= 26 && $section_score <= 30) {
        return "Strong Blocks";
    } else {
        return "Unknown";
    }
}

function send_quiz_feedback() {
    // Validate and sanitize input data
   $user_email = sanitize_email($_POST['user_email']);
    $user_score = intval($_POST['user_score']);
    $last_name = $_POST['last_name'];
$section_scores = json_decode(stripslashes($_POST['section_scores']), true);
    
    if (json_last_error() !== JSON_ERROR_NONE) {
        error_log("JSON Decode Error: " . json_last_error_msg());
        $section_scores = [];
    }

    // Logging for debugging
    error_log('Section Scores JSON: ' . print_r($section_scores, true));


    // Determine feedback based on user score
    $feedback = get_user_score_feedback($user_score);

    // Prepare section score feedback
    $section_feedback = "\n\nSection Scores:\n";
    foreach ($section_scores as $sectionId => $sectionScore) {
        $section_block = get_section_score_block($sectionScore);
        $section_feedback .= "$sectionId: $sectionScore\nSection Block: $section_block\n";
    }

    // Prepare and send the email
    $subject = "Your Quiz Feedback";
    $message = "Your score is: $user_score.\n$feedback$section_feedback";
    error_log('scoreis'. $message);
    wp_mail($user_email, $subject, $message);

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
                    'last_name' => $last_name,
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


    wp_die(); // Always end AJAX handler functions with wp_die()
}


function enqueue_scripts1() {
    wp_enqueue_script('jquery');
    wp_enqueue_script('jquery-ui-dialog'); // Add this line
    wp_enqueue_script('quizz-action', plugin_dir_url(__FILE__) . 'js/quizz-action.js', array('jquery', 'jquery-ui-dialog'), '1.0', true); // Add 'jquery-ui-dialog' to the dependencies array
        wp_localize_script( 'quizz-action', 'ajax_object1', array( 'ajax_url' => admin_url( 'admin-ajax.php' )) );

}

add_action('wp_enqueue_scripts', 'enqueue_scripts1');

function enqueue_styles1() {
    wp_enqueue_style('quizz-layout', plugin_dir_url(__FILE__) . 'css/quizz-layout.css', array(), '1.0.6');
}


add_action('wp_enqueue_scripts', 'enqueue_styles1');
/**
 * Begins execution of the plugin.
 *
 * Since everything within the plugin is registered via hooks,
 * then kicking off the plugin from this point in the file does
 * not affect the page life cycle.
 *
 * @since    1.0.0
 */
function run_quizzes() {

	$plugin = new Quizzes();
	$plugin->run();

}
run_quizzes();

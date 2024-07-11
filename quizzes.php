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

    $sql1 = "CREATE TABLE $table_name (
        id mediumint(9) NOT NULL AUTO_INCREMENT,
        id_fk mediumint(9) NOT NULL,
        quiz_id mediumint(9) NOT NULL,
        section varchar(255) NOT NULL,
        question varchar(255) NOT NULL,
        PRIMARY KEY (id)
    ) $charset_collate;";

    $sql2 = "CREATE TABLE $rating_table_name (
        id_pk tinyint(1) NOT NULL AUTO_INCREMENT,
        id tinyint(1) NOT NULL,
        quiz_id mediumint(9) NOT NULL,
        label varchar(255) NOT NULL,
        PRIMARY KEY (id_pk)
    ) $charset_collate;";

    require_once(ABSPATH . 'wp-admin/includes/upgrade.php');

    // Manually execute the queries
    $result1 = $wpdb->query($sql1);
    $wpdb->show_errors();
    $last_error1 = $wpdb->last_error;
    error_log("SQL1 Error: $last_error1");
    error_log("Result1: " . ($result1 !== false ? 'success' : 'failure'));

    $result2 = $wpdb->query($sql2);
    $wpdb->show_errors();
    $last_error2 = $wpdb->last_error;
    error_log("SQL2 Error: $last_error2");
    error_log("Result2: " . ($result2 !== false ? 'success' : 'failure'));

    // Debug statements
    error_log("SQL1: $sql1");
    $table_exists = $wpdb->get_var("SHOW TABLES LIKE '$table_name'");
    error_log("Table $table_name exists: " . ($table_exists ? 'yes' : 'no'));
    error_log("SQL2: $sql2");
    $rating_table_exists = $wpdb->get_var("SHOW TABLES LIKE '$rating_table_name'");
    error_log("Table $rating_table_name exists: " . ($rating_table_exists ? 'yes' : 'no'));

    insert_quiz_data();
    insert_another_quiz_data();
}




function insert_quiz_data() {
        global $wpdb;
    $table_name = $wpdb->prefix . 'quizzes_meta';
    $rating_table_name = $wpdb->prefix . 'rating_scale';

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
$id_fk = 1;

foreach ($quiz as $section => $data) {
        foreach ($data['questions'] as $question) {
            $wpdb->insert(
                $table_name,
                array(
                'id_fk' => $id_fk,
                    'quiz_id' => 1, // Example quiz ID
                    'section' => $section,
                    'question' => $question
                )
            );
                                $id_fk++; // Increment id_fk for the next question in the same quiz

        }
    }

 foreach ($rating_scale as $score => $label) {
        $wpdb->insert(
            $rating_table_name,
            array(
                'quiz_id' => 1, // Example quiz ID
                'id' => $score,
                'label' => $label
            )
        );
  }
  }
  function insert_another_quiz_data() {
    global $wpdb;
    $table_name = $wpdb->prefix . 'quizzes_meta';
    $rating_table_name = $wpdb->prefix . 'rating_scale';
$another_quiz = array( 
    "Negative Self-Talk" => array(
        "questions" => array(
            "I often think negatively about myself.",
            "I frequently criticize myself for my mistakes.",
            "I struggle to find positive things to say about myself.",
            "I feel like I am not good enough, no matter what I do.",
            "I tend to focus on my flaws rather than my strengths.",
            "I find it hard to believe in my abilities.",
        ),
    ),
    "Past Experiences and Trauma" => array(
        "questions" => array(
            "Past traumas continue to affect how I see myself.",
            "I have trouble moving past negative experiences from my childhood.",
            "I often feel defined by my past failures.",
            "Memories of past abuse or neglect still impact my self-worth.",
            "I frequently recall negative events that make me feel unworthy.",
            "I struggle to feel valuable because of things that happened in my past."
        ),
    ),
    "Parental Influence and Upbringing" => array(
        "questions" => array(
            "My parents or caregivers were often critical of me.",
            "I felt unsupported by my family during my childhood.",
            "My family had unrealistic expectations of me.",
            "I rarely received praise or validation from my parents.",
            "I was often compared unfavourably to others by my caregivers.",
            "I grew up feeling like I was never good enough for my family."
        ),
    ),
    "Social Comparison" => array(
        "questions" => array(
            "I frequently compare myself to others and feel I come up short.",
            "Seeing others' successes makes me feel inadequate.",
            "I feel envious of people who seem to have perfect lives.",
            "Social media makes me feel like I'm not doing enough with my life.",
            "I often wish I could be more like others I admire.",
            "Comparing myself to others leaves me feeling dissatisfied with myself."
        ),
    ),
    "Achievement and Failure" => array(
        "questions" => array(
            "I feel like a failure when I don’t achieve my goals.",
            "I often dwell on my mistakes and shortcomings.",
            "I feel that my worth is tied to my achievements.",
            "I find it hard to celebrate my successes.",
            "I believe others see me as a failure.",
            "My self-worth plummets when I experience setbacks."
        ),
    ),
    "Relationship Dynamics" => array(
        "questions" => array(
            "I often feel undervalued in my relationships.",
            "I tend to be in relationships where my needs are not met.",
            "I feel like I am not good enough for my partner/friends.",
            "I often worry that people will leave me.",
            "I struggle to assert myself in relationships.",
            "I feel unworthy of love and affection."
        ),
    ),
    "Mental Health Issues" => array(
        "questions" => array(
            "I often feel depressed or anxious about my self-worth.",
            "My mental health struggles make me feel less capable.",
            "I have trouble seeing my positive qualities because of my mental health.",
            "My mental health issues make it hard for me to feel good about myself.",
            "I frequently feel overwhelmed by negative thoughts.",
            "My mental health negatively affects how I view myself."
        ),
    ),
    "Body Image and Physical Appearance" => array(
        "questions" => array(
            "I am often unhappy with how I look.",
            "I feel like I don't measure up to societal beauty standards.",
            "My appearance makes me feel less confident.",
            "I compare my body to others and feel dissatisfied.",
            "I believe others judge me based on my appearance.",
            "My self-worth is heavily influenced by my physical appearance."
        ),
    ),
    "Work and Career Pressures" => array(
        "questions" => array(
            "I feel unappreciated in my job or career.",
            "My career success (or lack thereof) defines my self-worth.",
            "I often feel like I'm not good enough at work.",
            "I worry about not meeting my professional goals.",
            "My job performance affects how I see myself.",
            "I feel like I'm falling behind in my career compared to my peers."
        ),
    ),
    "Cultural and Societal Expectations" => array(
        "questions" => array(
            "I feel pressured to meet societal standards of success.",
            "Cultural norms make me feel inadequate.",
            "I struggle to fit into societal expectations of gender roles.",
            "I often feel like I'm not living up to what society expects of me.",
            "Cultural expectations make me feel less valuable.",
            "I feel judged by society for not meeting certain milestones."
        ),
    ),
    "Lack of Support Systems" => array(
        "questions" => array(
            "I feel isolated and lack supportive relationships.",
            "I dont have many people to turn to for encouragement.",
            "I often feel alone in my struggles.",
            "I lack a strong support system to help me feel valued.",
            "I feel unsupported by those around me.",
            "I wish I had more people to rely on for validation and support."
        ),
    ),
    "Perfectionism" => array(
        "questions" => array(
            "I set extremely high standards for myself.",
            "I feel like Im never good enough because I cant reach perfection.",
            "My fear of making mistakes affects my self-worth.",
            "I find it hard to be satisfied with my accomplishments.",
            "I constantly strive for perfection, which leaves me feeling inadequate.",
            "I am overly critical of myself when I dont meet my own high standards."
        ),
    ),
);
$rating_scale1 = array(
    1 => "Strongly Disagree",
    2 => "Disagree",
    3 => "Neutral",
    4 => "Agree",
    5 => "Strongly Agree",
);
$id_fk = 1;
    foreach ($another_quiz as $section => $data) {
        foreach ($data['questions'] as $question) {
            $wpdb->insert(
                $table_name,
                array(
                'id_fk' => $id_fk,
                    'quiz_id' => 2, // New quiz ID
                    'section' => $section,
                    'question' => $question
                )
            );
                    $id_fk++; // Increment id_fk for the next question in the same quiz

        }
    }

    foreach ($rating_scale1 as $score => $label) {
        $wpdb->insert(
            $rating_table_name,
            array(
                'quiz_id' => 2, // New quiz ID
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
    require_once plugin_dir_path(__FILE__) . 'includes/class-quizzes-deactivator.php';
    Quizzes_Deactivator::deactivate();

    global $wpdb;
    $table_name = $wpdb->prefix . 'quizzes_meta';
    $table_name1 = $wpdb->prefix . 'rating_scale';

    // Drop tables
    $wpdb->query("DROP TABLE IF EXISTS $table_name");
    $wpdb->query("DROP TABLE IF EXISTS $table_name1");

    // Check for errors
    $error1 = $wpdb->last_error;
    $error2 = $wpdb->last_error;

    // Log errors
    if (!empty($error1)) {
        error_log("Error dropping table $table_name: $error1");
    }
    if (!empty($error2)) {
        error_log("Error dropping table $table_name1: $error2");
    }
}

register_activation_hook( __FILE__, 'activate_quizzes' );
register_deactivation_hook( __FILE__, 'deactivate_quizzes' );

/**
 * The core plugin class that is used to define internationalization,
 * admin-specific hooks, and public-facing site hooks.
 */
require plugin_dir_path( __FILE__ ) . 'includes/class-quizzes.php';
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


add_shortcode('quizzes', 'quizzes_shortcode');
add_action('wp_ajax_send_quiz_feedback', 'send_quiz_feedback'); // For logged-in users
add_action('wp_ajax_nopriv_send_quiz_feedback', 'send_quiz_feedback'); // For non-logged-in users
function get_user_score_feedback($quiz_id,$user_score) {
    $feedback = '';
switch ($quiz_id) {
    case 1:
        if ($user_score >= 60 && $user_score <= 100) {
            $feedback = "Your results indicate that you face major obstacles to love and intimacy. These strong blocks suggest that deep-seated issues are significantly affecting your ability to form and maintain healthy relationships. You may struggle with severe self-doubt, intense fears of abandonment or commitment, and unresolved past traumas. Addressing these major obstacles is crucial for improving your relationship dynamics and overall quality of life. Professional support from mental health practitioners can provide the necessary tools and guidance to work through these issues. Focus on self-care, building a supportive network, and gradually working to change the negative patterns that hinder your relationship.";
        } elseif ($user_score >= 101 && $user_score <= 150) {
            $feedback = "Your results suggest that you experience some minor challenges related to love and intimacy. While you generally have positive relationship dynamics, there may be occasional difficulties that arise. These might include mild communication issues, occasional fears of vulnerability, or slight self-doubt. Addressing these minor challenges can help strengthen your relationships. Focus on enhancing your communication skills, building trust, and practicing self-awareness to further improve your intimacy and connection with others.";
        } elseif ($user_score >= 151 && $user_score <= 200) {
            $feedback = "Your results indicate that you face significant challenges in your relationships and intimacy. These moderate blocks suggest that there are several areas where you may struggle, such as managing past trauma, dealing with self-esteem issues, or overcoming fears of commitment. These challenges can impact your ability to form deep, lasting connections. Consider seeking support from a therapist or counselor to work through these issues. Building stronger communication skills, practicing self-compassion, and addressing unresolved traumas can help you navigate and overcome these blocks.";
        } elseif ($user_score >= 201 && $user_score <= 250) {
            $feedback = "Your results show that you have serious challenges in terms of love and intimacy. These substantial blocks indicate that you frequently struggle with relationship dynamics, which might include issues like intense fear of vulnerability, unresolved childhood issues, or significant communication problems. These challenges can greatly impact your relationships and overall well-being. Seeking professional help, such as therapy or counseling, is highly recommended. Additionally, working on building trust, practicing healthy boundaries, and focusing on self-improvement can help you overcome these substantial blocks and improve your relationships.";
        } elseif ($user_score >= 251 && $user_score <= 300) {
            $feedback = "Your results indicate that you face major obstacles to love and intimacy. These strong blocks suggest that deep-seated issues are significantly affecting your ability to form and maintain healthy relationships. You may struggle with severe self-doubt, intense fears of abandonment or commitment, and unresolved past traumas. Addressing these major obstacles is crucial for improving your relationship dynamics and overall quality of life. Professional support from mental health practitioners can provide the necessary tools and guidance to work through these issues. Focus on self-care, building a supportive network, and gradually working to change the negative patterns that hinder your relationships.";
        } else {
            $feedback = "Your results indicate that you skipped most of the parts of questions therefore there is no valid result for you";
        }
        break;
    case 2:
        if ($user_score >= 72 && $user_score <= 120) {
            $feedback = "Congratulations! Your results indicate that you have a healthy level of self-worth. You possess a positive view of yourself, and you are generally confident in your abilities and value. You are able to navigate life's challenges with resilience and maintain a balanced perspective on your strengths and weaknesses. Keep nurturing this positive self-image and continue to build on your self-esteem through self-care, supportive relationships, and personal growth.";
        } elseif ($user_score >= 121 && $user_score <= 180) {
            $feedback = "Your results suggest that you experience some minor challenges related to self-worth. While you generally have a positive self-image, there may be occasional doubts or areas where you feel less confident. These minor blocks can be addressed through self-awareness and intentional efforts to boost your self-esteem. Consider exploring practices such as positive affirmations, seeking constructive feedback, and focusing on your achievements and strengths to reinforce your self-worth.";
        } elseif ($user_score >= 181 && $user_score <= 240) {
            $feedback = "Your results indicate that you face significant challenges in terms of self-worth. You may struggle with self-doubt, negative self-talk, or feelings of inadequacy in various aspects of your life. These moderate blocks suggest that there are underlying issues that need to be addressed to improve your self-esteem. Consider seeking support from a therapist or counsellor, engaging in self-reflection, and working on building a more positive self-image through targeted strategies and self-compassion.";
        } elseif ($user_score >= 241 && $user_score <= 300) {
            $feedback = "Your results show that you have serious challenges related to self-worth. These substantial blocks suggest that you frequently struggle with low self-esteem, negative perceptions of yourself, and feelings of unworthiness. It's important to address these issues as they can significantly impact your overall well-being and quality of life. Seeking professional support, such as therapy or counselling, can be very beneficial. Additionally, working on self-acceptance, building supportive relationships, and practicing self-care can help you improve your self-worth over time.";
        } elseif ($user_score >= 301 && $user_score <= 360) {
            $feedback = "Your results indicate that you face major obstacles in terms of self-worth. These strong blocks suggest that deep-seated issues are significantly affecting your ability to form and maintain healthy relationships. You may struggle with severe self-doubt, intense fears of abandonment or commitment, and unresolved past traumas. Addressing these major obstacles is crucial for improving your relationship dynamics and overall quality of life. Professional support from mental health practitioners can provide the necessary tools and guidance to work through these issues. Focus on self-care, building a supportive network, and gradually working to change the negative patterns that hinder your relationships.";
        } else {
            $feedback = "Your results indicate that you skipped most of the parts of questions therefore there is no valid result for you";
        }
        break;
    // Add more cases for other quiz IDs
    default:
        $feedback = "Default feedback for quizzes.";
        break;
}
return $feedback;

}

function get_section_score_block($section_id, $section_score) {
$descriptions = [
    'Attachment Style' => [
        'No Perceived Blocks' => "You have a secure attachment style, allowing you to trust and connect with others easily. Continue nurturing your healthy relationships by maintaining open communication and mutual respect.",
        'Mild Blocks' => "You generally form healthy attachments but may occasionally experience minor trust issues or fears of intimacy. Focus on building trust through consistent, honest communication with your partner.",
        'Moderate Blocks' => "You may struggle with attachment in relationships, often feeling insecure or distant. Consider exploring your attachment patterns with a coach or therapist to foster deeper connections.",
        'Substantial Blocks' => "Significant challenges in attachment may be impacting your relationships. Working on trust-building exercises and understanding your attachment style can help you form healthier connections.",
        'Strong Blocks' => "Strong blocks in attachment are affecting your ability to form close relationships. Seek support from a professional to work through these issues and build more secure, fulfilling connections."
    ],
    'Past Trauma or Hurt' => [
        'No Perceived Blocks' => "You have successfully healed from past traumas, allowing you to live in the present and engage fully in your relationships. Continue nurturing your resilience and emotional well-being.",
        'Mild Blocks' => "You may carry minor unresolved issues from past traumas that occasionally affect your relationships. Focus on self-care and consider gentle exploration of these issues with a trusted confidant.",
        'Moderate Blocks' => "Past traumas are significantly impacting your current relationships. Consider seeking support to process these experiences and learn coping strategies to move forward.",
        'Substantial Blocks' => "Your past traumas are creating substantial barriers to intimacy and connection. Professional guidance can help you heal and develop healthier relationship patterns.",
        'Strong Blocks' => "Deep-seated trauma is affecting your ability to engage fully in relationships. It's important to seek professional support to work through these traumas and build a stronger, more resilient sense of self."
    ],
    'section-Self-Esteem and Self-Worth' => [
        'No Perceived Blocks' => "You have a strong sense of self-worth and confidence, allowing you to engage positively in relationships. Continue to celebrate your strengths and achievements.",
        'Mild Blocks' => "You may experience occasional self-doubt that impacts your relationships. Focus on positive self-affirmations and recognize your intrinsic value.",
        'Moderate Blocks' => "Self-esteem issues are significantly affecting your relationships. Consider working with a coach or therapist to build your self-confidence and self-acceptance.",
        'Substantial Blocks' => "Low self-worth is creating substantial challenges in your relationships. Professional support can help you develop a healthier self-image and improve your relationship dynamics.",
        'Strong Blocks' => "Deep issues with self-esteem are impacting your ability to form healthy relationships. Seek guidance to address these issues and build a stronger sense of self-worth."
    ],
    'Communication Issues' => [
        'No Perceived Blocks' => "You communicate effectively, fostering clear and open dialogues in your relationships. Continue to practice active listening and honest expression.",
        'Mild Blocks' => "You generally communicate well but may face occasional misunderstandings. Focus on enhancing your communication skills through active listening and expressing your needs clearly.",
        'Moderate Blocks' => "Communication challenges are affecting your relationships. Consider practicing communication techniques or seeking guidance to improve your interactions.",
        'Substantial Blocks' => "Significant communication issues are creating barriers in your relationships. Professional support can help you develop more effective communication strategies.",
        'Strong Blocks' => "Severe communication difficulties are impacting your relationships. Seek support to learn healthy communication skills and build stronger connections."
    ],
    'Fear of Vulnerability' => [
        'No Perceived Blocks' => "You embrace vulnerability, allowing for deep, authentic connections in your relationships. Continue to cultivate openness and emotional honesty.",
        'Mild Blocks' => "You occasionally struggle with vulnerability but generally manage to open up. Focus on building trust and practicing small acts of vulnerability to deepen your connections.",
        'Moderate Blocks' => "Fear of vulnerability is impacting your relationships. Consider exploring these fears with a coach or therapist to build emotional resilience.",
        'Substantial Blocks' => "Significant fear of vulnerability is creating barriers to intimacy. Professional support can help you feel safer and more confident in expressing your true self.",
        'Strong Blocks' => "Deep fear of vulnerability is affecting your ability to form close relationships. Seek guidance to work through these fears and build more open, trusting connections."
    ],
    'Unrealistic Expectations' => [
        'No Perceived Blocks' => "You have realistic expectations in relationships, fostering healthy and balanced connections. Continue to communicate openly about your needs and expectations.",
        'Mild Blocks' => "You may occasionally have unrealistic expectations that cause minor conflicts. Focus on aligning your expectations with reality and discussing them openly with your partner.",
        'Moderate Blocks' => "Unrealistic expectations are impacting your relationships. Consider exploring these expectations and adjusting them to foster healthier interactions.",
        'Substantial Blocks' => "Significant unrealistic expectations are creating challenges in your relationships. Professional guidance can help you develop more realistic and healthy expectations.",
        'Strong Blocks' => "Deeply unrealistic expectations are affecting your ability to maintain healthy relationships. Seek support to adjust these expectations and build more balanced connections."
    ],
    'Lack of Boundaries' => [
        'No Perceived Blocks' => "You have healthy boundaries in your relationships, allowing for mutual respect and understanding. Continue to maintain and communicate your boundaries clearly.",
        'Mild Blocks' => "You generally maintain boundaries but may occasionally struggle. Focus on reinforcing your boundaries and communicating them effectively.",
        'Moderate Blocks' => "Boundary issues are impacting your relationships. Consider working on establishing and maintaining clear boundaries to foster healthier interactions.",
        'Substantial Blocks' => "Significant boundary issues are creating challenges in your relationships. Professional support can help you develop and maintain healthier boundaries.",
        'Strong Blocks' => "Severe boundary issues are affecting your ability to maintain healthy relationships. Seek guidance to establish and enforce strong, respectful boundaries."
    ],
    'Unresolved Issues from Childhood' => [
        'No Perceived Blocks' => "You have resolved past issues from childhood, allowing you to engage fully in your relationships. Continue nurturing your emotional health and addressing any new challenges as they arise.",
        'Mild Blocks' => "Minor unresolved issues from childhood occasionally affect your relationships. Focus on healing these past wounds through self-reflection and support.",
        'Moderate Blocks' => "Childhood issues are significantly impacting your relationships. Consider seeking support to process these experiences and learn coping strategies to move forward.",
        'Substantial Blocks' => "Your past issues from childhood are creating substantial barriers to intimacy and connection. Professional guidance can help you heal and develop healthier relationship patterns.",
        'Strong Blocks' => "Deep-seated issues from childhood are affecting your ability to engage fully in relationships. It's important to seek professional support to work through these issues and build a stronger, more resilient sense of self."
    ],
    'Fear of Commitment' => [
        'No Perceived Blocks' => "You are comfortable with commitment, allowing you to form stable and lasting relationships. Continue to nurture this sense of security and mutual commitment.",
        'Mild Blocks' => "You may occasionally struggle with commitment but generally manage well. Focus on building trust and exploring any fears to deepen your commitment.",
        'Moderate Blocks' => "Fear of commitment is impacting your relationships. Consider working with a coach or therapist to address these fears and build confidence in your relationships.",
        'Substantial Blocks' => "Significant fear of commitment is creating challenges in your relationships. Professional support can help you understand and overcome these fears.",
        'Strong Blocks' => "Deep fear of commitment is affecting your ability to maintain stable relationships. Seek guidance to work through these fears and build stronger, more secure connections."
    ],
    'External Stressors' => [
        'No Perceived Blocks' => "You manage external stressors well, allowing you to maintain healthy relationships. Continue to practice stress management and prioritize your well-being.",
        'Mild Blocks' => "You occasionally struggle with external stressors that impact your relationships. Focus on developing effective stress management strategies to maintain balance.",
        'Moderate Blocks' => "External stressors are significantly impacting your relationships. Consider exploring ways to manage stress and maintain healthy boundaries.",
        'Substantial Blocks' => "Significant external stressors are creating challenges in your relationships. Professional support can help you develop effective coping mechanisms and reduce stress.",
        'Strong Blocks' => "Severe external stressors are affecting your ability to maintain healthy relationships. Seek guidance to address these stressors and build resilience in your relationships."
    ],
    'Negative Self-Talk' => [
    'No Perceived Blocks' => "You have a positive inner dialogue and speak kindly to yourself. Continue to nurture this self-compassion and remind yourself of your worth.",
    'Mild Blocks' => "Occasionally, you might fall into negative self-talk. Focus on recognizing and challenging these thoughts to build a more supportive inner voice.",
    'Moderate Blocks' => "Negative self-talk is impacting your self-worth. Practice replacing critical thoughts with affirming ones and consider seeking support to develop a more positive self-view.",
    'Substantial Blocks' => "Your inner dialogue often leans towards negativity, affecting your confidence. Working with a coach or therapist can help you transform these thoughts into more empowering ones.",
    'Strong Blocks' => "Deep-seated negative self-talk is significantly impacting your self-worth. Professional support can guide you in reshaping these thoughts and fostering a kinder inner voice."
],
'Past Experiences and Trauma' => [
    'No Perceived Blocks' => "You have successfully processed past traumas, allowing you to live in the present with confidence. Continue to honor your healing journey and stay mindful of your resilience.",
    'Mild Blocks' => "Some past experiences still affect you occasionally. Gentle self-reflection and healing practices can help you further release these lingering effects.",
    'Moderate Blocks' => "Past traumas are affecting your self-worth. Consider seeking support to process these experiences and develop strategies to heal and grow from them.",
    'Substantial Blocks' => "Significant past traumas are impacting your self-esteem. Professional guidance can provide you with tools and support to navigate and heal these deep wounds.",
    'Strong Blocks' => "Deep traumas are heavily influencing your self-worth. It's important to seek professional help to work through these experiences and rebuild your sense of self."
],
'Parental Influence and Upbringing' => [
    'No Perceived Blocks' => "Your upbringing has positively shaped your self-worth. Continue to draw strength from these supportive experiences and build on this solid foundation.",
    'Mild Blocks' => "While mostly positive, some aspects of your upbringing may have caused minor self-worth issues. Reflect on these influences and work on reinforcing your sense of self.",
    'Moderate Blocks' => "Certain aspects of your upbringing have affected your self-esteem. Exploring these influences with a coach or therapist can help you understand and reshape their impact.",
    'Substantial Blocks' => "Your upbringing has significantly impacted your self-worth. Professional support can assist you in addressing these influences and building a healthier self-image.",
    'Strong Blocks' => "Deep-rooted issues from your upbringing are heavily affecting your self-worth. Seek guidance to heal from these early experiences and strengthen your sense of self."
],
'Social Comparison' => [
    'No Perceived Blocks' => "You rarely compare yourself to others, maintaining a strong sense of self-worth. Continue to focus on your unique strengths and achievements.",
    'Mild Blocks' => "You occasionally compare yourself to others, which may affect your self-esteem. Practice self-acceptance and celebrate your individual journey to reduce these comparisons.",
    'Moderate Blocks' => "Frequent comparisons to others are impacting your self-worth. Focus on your personal growth and achievements to build confidence in your unique path.",
    'Substantial Blocks' => "Significant social comparison is affecting your self-esteem. Consider limiting exposure to comparison triggers and seeking support to develop a stronger self-worth.",
    'Strong Blocks' => "Deep-seated comparison to others is heavily influencing your self-worth. Professional support can help you focus on your strengths and reduce these comparisons."
],
'Achievement and Failure' => [
    'No Perceived Blocks' => "You have a balanced view of success and failure, maintaining a healthy self-worth. Continue to celebrate your achievements and learn from setbacks.",
    'Mild Blocks' => "Minor concerns about achievement and failure may occasionally affect your self-esteem. Focus on recognizing your accomplishments and viewing failures as growth opportunities.",
    'Moderate Blocks' => "Your self-worth is significantly influenced by your achievements and failures. Work on developing a more balanced perspective with the help of a coach or therapist.",
    'Substantial Blocks' => "Concerns about success and failure are creating substantial self-worth challenges. Professional support can assist you in building resilience and a healthier self-view.",
    'Strong Blocks' => "Deep concerns about achievement and failure are heavily impacting your self-worth. Seek guidance to reshape your perspective and build a more stable sense of self."
],
'Relationship Dynamics' => [
    'No Perceived Blocks' => "You have healthy relationship dynamics that support your self-worth. Continue to nurture these positive interactions and maintain mutual respect.",
    'Mild Blocks' => "Occasionally, relationship dynamics may affect your self-esteem. Focus on fostering healthy, supportive relationships and setting boundaries where needed.",
    'Moderate Blocks' => "Relationship dynamics are significantly impacting your self-worth. Consider working on communication skills and seeking support to build healthier relationships.",
    'Substantial Blocks' => "Significant challenges in relationships are affecting your self-esteem. Professional guidance can help you navigate these dynamics and strengthen your sense of self.",
    'Strong Blocks' => "Deep issues in relationship dynamics are heavily influencing your self-worth. Seek support to develop healthier interactions and build a more positive self-image."
],
'Mental Health Issues' => [
    'No Perceived Blocks' => "Your mental health is generally stable, supporting a healthy self-worth. Continue to prioritize your mental well-being and seek support when needed.",
    'Mild Blocks' => "Minor mental health concerns occasionally affect your self-esteem. Focus on self-care practices and consider seeking support to maintain your mental health.",
    'Moderate Blocks' => "Mental health issues are significantly impacting your self-worth. Working with a mental health professional can help you address these challenges and build resilience.",
    'Substantial Blocks' => "Significant mental health concerns are affecting your self-esteem. Professional support can provide you with strategies and tools to manage these issues effectively.",
    'Strong Blocks' => "Deep mental health issues are heavily influencing your self-worth. Seek professional guidance to address these challenges and strengthen your mental well-being."
],
'Body Image and Physical Appearance' => [
    'No Perceived Blocks' => "You have a positive body image and are comfortable with your physical appearance. Continue to appreciate and take care of your body.",
    'Mild Blocks' => "Minor concerns about body image occasionally affect your self-esteem. Focus on self-acceptance and celebrating your body for its strengths and capabilities.",
    'Moderate Blocks' => "Body image issues are significantly impacting your self-worth. Consider exploring body positivity practices and seeking support to develop a healthier self-view.",
    'Substantial Blocks' => "Significant body image concerns are affecting your self-esteem. Professional support can assist you in addressing these influences and building a healthier self-image.",
    'Strong Blocks' => "Deep-rooted issues with body image are heavily affecting your self-worth. Seek guidance to develop a positive body image and strengthen your sense of self."
],
'Work and Career Pressures' => [
    'No Perceived Blocks' => "You manage work and career pressures well, maintaining a healthy self-worth. Continue to balance your professional and personal life effectively.",
    'Mild Blocks' => "Minor work-related pressures occasionally affect your self-esteem. Focus on recognizing your professional achievements and setting realistic career goals.",
    'Moderate Blocks' => "Work and career pressures are significantly impacting your self-worth. Consider seeking support to manage stress and build confidence in your professional abilities.",
    'Substantial Blocks' => "Significant work-related pressures are affecting your self-esteem. Professional guidance can help you develop strategies to handle these pressures and build a healthier self-view.",
    'Strong Blocks' => "Deep work and career pressures are heavily influencing your self-worth. Seek support to address these challenges and strengthen your professional confidence."
],
'Cultural and Societal Expectations' => [
    'No Perceived Blocks' => "You navigate cultural and societal expectations well, maintaining a strong sense of self-worth. Continue to honor your individuality and values.",
    'Mild Blocks' => "Occasionally, societal expectations may affect your self-esteem. Focus on staying true to yourself and recognizing your unique strengths and contributions.",
    'Moderate Blocks' => "Cultural and societal expectations are significantly impacting your self-worth. Consider seeking support to build confidence in your individuality and values.",
    'Substantial Blocks' => "Significant societal pressures are affecting your self-esteem. Professional guidance can help you navigate these expectations and strengthen your self-worth.",
    'Strong Blocks' => "Deep societal expectations are heavily influencing your self-worth. Seek support to address these pressures and build a more stable sense of self."
],
'Lack of Support Systems' => [
    'No Perceived Blocks' => "You have a strong support system that bolsters your self-worth. Continue to nurture these relationships and seek support when needed.",
    'Mild Blocks' => "Minor gaps in your support system occasionally affect your self-esteem. Focus on building and maintaining supportive relationships.",
    'Moderate Blocks' => "A lack of support systems is significantly impacting your self-worth. Consider seeking out new support networks and strengthening existing connections.",
    'Substantial Blocks' => "Significant gaps in your support system are affecting your self-esteem. Professional support can help you build a stronger network and enhance your self-worth.",
    'Strong Blocks' => "Deep issues with a lack of support systems are heavily influencing your self-worth. Seek guidance to develop a robust support network and strengthen your sense of self."
],
'Perfectionism' => [
    'No Perceived Blocks' => "You have a balanced approach to achievement, allowing you to maintain a healthy self-worth. Continue to strive for excellence while accepting imperfections.",
    'Mild Blocks' => "Occasional perfectionist tendencies may affect your self-esteem. Focus on setting realistic goals and celebrating your progress, even if it's not perfect.",
    'Moderate Blocks' => "Perfectionism is significantly impacting your self-worth. Consider seeking support to develop a healthier perspective on success and failure.",
    'Substantial Blocks' => "Significant perfectionist tendencies are affecting your self-esteem. Professional guidance can help you set realistic expectations and appreciate your achievements.",
    'Strong Blocks' => "Deep perfectionist issues are heavily influencing your self-worth. Seek support to address these tendencies and build a more compassionate self-view."
]
];



    if ($section_score >= 6 && $section_score <= 10) {
        return $descriptions[$section_id]['No Perceived Blocks'];
    } elseif ($section_score >= 11 && $section_score <= 15) {
        return $descriptions[$section_id]['Mild Blocks'];
    } elseif ($section_score >= 16 && $section_score <= 20) {
        return $descriptions[$section_id]['Moderate Blocks'];
    } elseif ($section_score >= 21 && $section_score <= 25) {
        return $descriptions[$section_id]['Substantial Blocks'];
    } elseif ($section_score >= 26 && $section_score <= 30) {
        return $descriptions[$section_id]['Strong Blocks'];
    } else {
        return "Unknown";
    }
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
    $feedback = get_user_score_feedback($quiz_id,$user_score);
        error_log('Section Scores JSON: ' .$feedback);

    // Prepare section score feedback
    $section_feedback = "\n\nSection Scores:\n";
 foreach ($section_scores as $section_id => $section_score) {
        $clean_section_id = str_replace('section-', '', $section_id);
        $section_block = get_section_score_block($clean_section_id , $section_score);
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

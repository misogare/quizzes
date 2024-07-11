<?php

/**
 * Fired during plugin activation
 *
 * @link       https://mesvak.software
 * @since      1.0.0
 *
 * @package    Quizzes
 * @subpackage Quizzes/includes
 */

/**
 * Fired during plugin activation.
 *
 * This class defines all code necessary to run during the plugin's activation.
 *
 * @since      1.0.0
 * @package    Quizzes
 * @subpackage Quizzes/includes
 * @author     mesvak <mesvakc@gmail.com>
 */
class Quizzes_Activator {

	/**
	 * Short Description. (use period)
	 *
	 * Long Description.
	 *
	 * @since    1.0.0
	 */
	public static function activate() {
		
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

    self::insert_quiz_data();
    self::insert_another_quiz_data();

	}
     private static function insert_quiz_data() {
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
   private static function  insert_another_quiz_data() {
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


}

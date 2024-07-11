<?php
// File: class-quizzes-helper.php

class Quizzes_Helper {
    
  public static function get_user_score_feedback($quiz_id,$user_score) {
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

 public static function get_section_score_block($section_id, $section_score) {
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
}

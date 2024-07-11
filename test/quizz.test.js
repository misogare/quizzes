// Import necessary modules
const { JSDOM } = require('jsdom');
const $ = require('jquery');
const {
    showFirstQuestionAndSection,
    startOverQuiz,
    updateProgress,
    restoreAnswers,
    navigateToSavedState
} = require('../js/quizz-action.js');

describe('Quiz functions', () => {
    let dom;
    let container;

    // Sample quiz data to simulate the PHP-generated HTML structure
    const quizData = [
        { id: 1, section: 'Section 1', question: 'Question 1' },
        { id: 2, section: 'Section 1', question: 'Question 2' },
        { id: 3, section: 'Section 2', question: 'Question 3' }
        // Add more sample questions as needed
    ];

    // Sample rating scale
    const ratingScale = [
        { id: 1, label: 'Option 1' },
        { id: 2, label: 'Option 2' },
        { id: 3, label: 'Option 3' }
        // Add more options as needed
    ];

    beforeEach(() => {
        // Mocking the DOM structure
        dom = new JSDOM(`
            <body>
                <div class="quiz-container">
                    <!-- PHP-generated quiz sections and questions will go here -->
                </div>
                <div id="davai" class="container3 elementor-button-wrapper">
                    <button id="prev-question" class="btn hypnotic-btn elementor-button elementor-button-link elementor-size-sm">
                        <span class="elementor-button-content-wrapper">
                            <span class="elementor-button-text"> < </span>
                        </span>
                    </button>
                    <button id="next-question" class="btn hypnotic-btn elementor-button elementor-button-link elementor-size-sm">
                        <span class="elementor-button-content-wrapper">
                            <span class="elementor-button-text"> > </span>
                        </span>
                    </button>
                </div>
            </body>
        `);
        container = dom.window.document.body;
        global.document = dom.window.document;
        global.window = dom.window;
        global.$ = $(dom.window);
    });

    // Mock localStorage in beforeEach
    beforeEach(() => {
        const localStorageMock = (() => {
            let store = {};
            return {
                getItem(key) {
                    return store[key] || null;
                },
                setItem(key, value) {
                    store[key] = value.toString();
                },
                removeItem(key) {
                    delete store[key];
                },
                clear() {
                    store = {};
                },
            };
        })();
        Object.defineProperty(window, 'localStorage', {
            value: localStorageMock,
        });
    });

    // Helper function to simulate PHP-generated quiz HTML
    function generateQuizHTML(quizData, ratingScale) {
        let output = '';
        let currentSection = '';

        quizData.forEach(question => {
            if (question.section !== currentSection) {
                if (currentSection !== '') {
                    output += '</div>'; // Close previous section
                }
                currentSection = question.section;
                output += `<div class='quiz-section' id='section-${question.section}' data-section-score='0' style='visibility: hidden; height: 0;'>`;
                output += `<h2>${currentSection}</h2>`;
            }

            output += `<div class='quiz-question-container' id='question-container-${question.id}' style='visibility: hidden; height: 0;'>`;
            output += `<div class='quiz-question' id='question-${question.id}'>`;
            output += `<p class='question-text'>(${question.id}) ${question.question}</p>`;

            output += '<div class="rating-container">';
            ratingScale.forEach(rating => {
                output += `<div class='wrapper rate_wrap'>`;
                output += `<input class='state' type='radio' name='question-${question.id}' id='rating-${rating.id}-question-${question.id}' value='${rating.id}'>`;
                output += `<label class='label' for='rating-${rating.id}-question-${question.id}'>`;
                output += `<div class='indicator'></div>`;
                output += `<span class='text' style='margin-left: 10px;'>${rating.label}</span>`;
                output += `</label></div>`;
            });
            output += '</div>'; // End rating-container
            output += '</div>'; // End quiz-question
            output += '</div>'; // End quiz-question-container
        });

        if (currentSection !== '') {
            output += '</div>'; // Close last section
        }

        container.querySelector('.quiz-container').innerHTML = output;
    }

    // Call the helper function to generate quiz HTML before each test
    beforeEach(() => {
        generateQuizHTML(quizData, ratingScale);
    });

    // Tests for quiz functions

    test('showFirstQuestionAndSection function works correctly', () => {
        showFirstQuestionAndSection();

        const firstSection = document.querySelector('.quiz-section:first-child');
        const firstQuestionContainer = firstSection.querySelector('.quiz-question-container:first-child');
        expect($(firstSection).css('visibility')).toBe('visible');
        expect($(firstQuestionContainer).css('visibility')).toBe('visible');
    });

    test('startOverQuiz function works correctly', () => {
        startOverQuiz();

        expect(localStorage.removeItem).toHaveBeenCalledTimes(5); // Adjust based on your localStorage usage
        expect(localStorage.removeItem).toHaveBeenCalledWith('sectionScores');
        expect(localStorage.removeItem).toHaveBeenCalledWith('currentQuestionId');
        expect(localStorage.removeItem).toHaveBeenCalledWith('currentSectionId');
        expect(localStorage.removeItem).toHaveBeenCalledWith('totalScore');
        expect(localStorage.removeItem).toHaveBeenCalledWith('answeredQuestions');
    });

    test('updateProgress function updates progress correctly', () => {
        localStorage.setItem('answeredQuestions', '5');
        const totalQuestions = 10;

        updateProgress();

        expect(localStorage.setItem).toHaveBeenCalledWith('quizProgress', '50');
        expect(localStorage.setItem).toHaveBeenCalledWith('answeredQuestions', '5');
    });

    test('restoreAnswers function restores answers correctly', () => {
        localStorage.setItem('answer-question1', '2'); // Adjust key based on your implementation
        restoreAnswers();

        const savedAnswer = localStorage.getItem('answer-question1');
        expect(savedAnswer).toBe('2');
    });

    test('navigateToSavedState function navigates correctly', () => {
        localStorage.setItem('currentQuestionId', 'question1'); // Adjust key based on your implementation
        localStorage.setItem('currentSectionId', 'section1'); // Adjust key based on your implementation
        navigateToSavedState();

        const currentSection = document.querySelector('.quiz-section#section-section1');
        const currentQuestionContainer = currentSection.querySelector('.quiz-question-container#question-container-question1');
        expect($(currentSection).css('visibility')).toBe('visible');
        expect($(currentQuestionContainer).css('visibility')).toBe('visible');
    });
});

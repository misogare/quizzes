(async function ($) {
    console.log("Document is ready");

    var totalScore = parseInt(localStorage.getItem('totalScore')) || 0;
    console.log("Initial totalScore:", totalScore);

    var totalQuestions = $('.quiz-question-container').length;
    console.log("Total number of questions:", totalQuestions);

    var answeredQuestions = parseInt(localStorage.getItem('answeredQuestions')) || 0;
    console.log("Initial answeredQuestions:", answeredQuestions);

    var sectionScores = JSON.parse(localStorage.getItem('sectionScores')) || {};
    console.log("Initial sectionScores:", sectionScores);

    var savedProgress = localStorage.getItem('quizProgress');
    if (savedProgress) {
        $('.progress-bar').css('width', savedProgress + '%');
        answeredQuestions = Math.round((totalQuestions * savedProgress) / 100);
        console.log("Saved progress found. Updated answeredQuestions:", answeredQuestions);
    }

    var savedQuestionId = localStorage.getItem('currentQuestionId');
    var savedSectionId = localStorage.getItem('currentSectionId');
    console.log("Saved currentQuestionId:", savedQuestionId);
    console.log("Saved currentSectionId:", savedSectionId);

    function showFirstQuestionAndSection() {
        console.log("Showing first question and section");
        $('.quiz-section:first').css('visibility', 'visible').css('height', 'auto');
        $('.quiz-question-container:first').css('visibility', 'visible').css('height', 'auto');
        checkNavigationButtons(); // Check initial state of navigation buttons
    }

    function navigateToSavedState() {
        console.log("Navigating to saved state");

        $('.quiz-section').each(function () {
            var sectionId = $(this).attr('id');
            if (sectionId === savedSectionId) {
                console.log("Found saved section:", sectionId);
                $(this).css('visibility', 'visible').css('height', 'auto');
                $(this).find('.quiz-question-container').each(function () {
                    var questionId = $(this).find('.quiz-question').attr('id');
                    if (questionId === savedQuestionId) {
                        console.log("Found saved question:", questionId);
                        $(this).css('visibility', 'visible').css('height', 'auto');
                    } else {
                        $(this).css('visibility', 'hidden').css('height', '0');
                    }
                });
            } else {
                $(this).css('visibility', 'hidden').css('height', '0');
            }
        });
        console.log(localStorage);

        restoreAnswers(); // Ensure answers are restored after navigating to saved state
        checkNavigationButtons(); // Check navigation buttons after navigation

        // Disable interaction with buttons
        $('.button-container button').prop('disabled', true).addClass('disabled');
    }

    function startOverQuiz() {
        console.log("Starting quiz over");
        $('input[type="radio"]').prop('checked', false);

        // Clear all relevant localStorage items
        localStorage.removeItem('sectionScores');

        localStorage.removeItem('currentQuestionId');
        localStorage.removeItem('currentSectionId');
        localStorage.removeItem('totalScore');
        localStorage.removeItem('answeredQuestions');
        localStorage.removeItem('quizProgress');

        // Reset variables
        totalScore = 0;
        answeredQuestions = 0;
        sectionScores = { };

        for (var key in localStorage) {
            if (key.startsWith('answer-')) {
                localStorage.removeItem(key);
            }
        }
        // Reset UI to show first question and section
        $('.quiz-section').css('visibility', 'hidden').css('height', '0');
        $('.quiz-question-container').css('visibility', 'hidden').css('height', '0');
        showFirstQuestionAndSection();

        // Reset progress bar to 0%
        $('.progress-bar').css('width', '0');
        console.log(localStorage);
        // Enable buttons again
        $('.button-container button').prop('disabled', false).removeClass('disabled');
    }

    async function waitForUserChoice() {
        return new Promise((resolve) => {
            // Show quiz container and continue/start over buttons
            navigateToSavedState();
            $('.quiz-container').addClass('shaded'); // Add shaded class to quiz container
            $('#davai').addClass('shady'); // Add shaded class to quiz container

            $('.button-container').css('display', 'block');

            // Display buttons
            var $continueButton = $('<button>').text('Continue').addClass('continue-button btn hypnotic-btn elementor-button elementor-button-link elementor-size-sm');
            var $startOverButton = $('<button>').text('Start Over').addClass('start-over-button btn hypnotic-btn elementor-button elementor-button-link elementor-size-sm');
            $('.button-container').append($continueButton).append($startOverButton);

            // Show buttons
            $continueButton.show();
            $startOverButton.show();

            // Button click handlers
            $continueButton.on('click', function () {
                $('.button-container').fadeOut(300);
                $('.quiz-container').removeClass('shaded').fadeIn(300); // Remove shaded class and fade in quiz container
                $('#davai').removeClass('shady').fadeIn(300); // Remove shaded class and fade in quiz container
                resolve('continue');
            });

            $startOverButton.on('click', function () {
                startOverQuiz();
                $('.button-container').fadeOut(300);
                $('#davai').removeClass('shady').fadeIn(300); // Remove shaded class and fade in quiz container
                $('.quiz-container').removeClass('shaded').fadeIn(300); // Remove shaded class and fade in quiz container
                resolve('startOver');
            });
        });
    }

    // Check if saved state exists
    if (savedSectionId && savedQuestionId) {
        // Wait for the user to choose either continue or start over
        await waitForUserChoice();
    } else {
        // No saved state, show first question and section
        showFirstQuestionAndSection();
    }

    function updateProgress() {
        var progressPercentage = (answeredQuestions / totalQuestions) * 100;
        $('.progress-bar').css('width', progressPercentage + '%');
        localStorage.setItem('quizProgress', progressPercentage);
        localStorage.setItem('answeredQuestions', answeredQuestions);
    }

    async function handleNavigation($currentQuestionContainer, $nextQuestionContainer, $prevQuestionContainer, callback) {
        return new Promise((resolve) => {
            var $currentSection = $currentQuestionContainer.closest('.quiz-section');
            var $nextSection = null;
            var $prevSection = null;

            if ($nextQuestionContainer && $nextQuestionContainer.length) {
                $nextSection = $nextQuestionContainer.closest('.quiz-section');
            }

            if ($prevQuestionContainer && $prevQuestionContainer.length) {
                $prevSection = $prevQuestionContainer.closest('.quiz-section');
            }

            $currentQuestionContainer.css('visibility', 'hidden').css('height', '0');

            if ($nextQuestionContainer && $nextQuestionContainer.length) {
                if ($nextSection.get(0) !== $currentSection.get(0)) {
                    $currentSection.css('visibility', 'hidden').css('height', '0');
                    $nextSection.css('visibility', 'visible').css('height', 'auto');
                }
                $nextQuestionContainer.css('visibility', 'visible').css('height', 'auto');
                localStorage.setItem('currentQuestionId', $nextQuestionContainer.find('.quiz-question').attr('id'));
                localStorage.setItem('currentSectionId', $nextSection.attr('id'));
            } else if ($prevQuestionContainer && $prevQuestionContainer.length) {
                if ($prevSection.get(0) !== $currentSection.get(0)) {
                    $currentSection.css('visibility', 'hidden').css('height', '0');
                    $prevSection.css('visibility', 'visible').css('height', 'auto');
                }
                $prevQuestionContainer.css('visibility', 'visible').css('height', 'auto');
                localStorage.setItem('currentQuestionId', $prevQuestionContainer.find('.quiz-question').attr('id'));
                localStorage.setItem('currentSectionId', $prevSection.attr('id'));
            } else {
                console.log("No more sections available");
            }
            updateProgress();
            if (typeof callback === 'function') {
                callback();
            }
            resolve();
        });
    }

    function checkNavigationButtons() {
        var $currentQuestionContainer = $('.quiz-question-container').filter(function () {
            return $(this).css('visibility') === 'visible';
        });

        var $currentSection = $currentQuestionContainer.closest('.quiz-section');

        var $firstQuestionInCurrentSection = $currentSection.find('.quiz-question-container').first();
        var $lastQuestionInCurrentSection = $currentSection.find('.quiz-question-container').last();

        var isFirstQuestion = $currentQuestionContainer.is($firstQuestionInCurrentSection);
        var isLastQuestion = $currentQuestionContainer.is($lastQuestionInCurrentSection);
        var isSecondSection = $currentSection.next('.quiz-section').length === 1 && $currentSection.index() === 1;
        var isLastSection = $currentSection.is(':last-child');

        // Disable Previous button if at the first question of the second section
        $('#prev-question').prop('disabled', isFirstQuestion && isSecondSection);

        // Disable Next button if at the last question of the last section
        $('#next-question').prop('disabled', isLastQuestion && isLastSection);
    }

    $('#next-question').on('click', async function () {
        console.log("Next question button clicked");

        var $currentQuestionContainer = $('.quiz-question-container').filter(function () {
            return $(this).css('visibility') === 'visible';
        });

        var $nextQuestionContainer = $currentQuestionContainer.next('.quiz-question-container');
        var $currentSection = $currentQuestionContainer.closest('.quiz-section');
        var $nextSection = $currentSection.next('.quiz-section');

        if (!$nextQuestionContainer.length && $nextSection.length) {
            $nextQuestionContainer = $nextSection.find('.quiz-question-container').first();
        }

        function navigationCallback() {
            checkNavigationButtons();
        }

        await handleNavigation($currentQuestionContainer, $nextQuestionContainer, null, navigationCallback);
    });

    $('#prev-question').on('click', async function () {
        console.log("Previous question button clicked");

        var $currentQuestionContainer = $('.quiz-question-container').filter(function () {
            return $(this).css('visibility') === 'visible';
        });

        var $prevQuestionContainer = $currentQuestionContainer.prev('.quiz-question-container');
        var $currentSection = $currentQuestionContainer.closest('.quiz-section');
        var $prevSection = $currentSection.prev('.quiz-section');

        if (!$prevQuestionContainer.length && $prevSection.length) {
            $prevQuestionContainer = $prevSection.find('.quiz-question-container').last();
        }
        function navigationCallback() {
            checkNavigationButtons();
        }

        await handleNavigation($currentQuestionContainer, null, $prevQuestionContainer, navigationCallback);
    });

    $('input[type=radio]').on('change', async function () {
        console.log("Radio button changed");

        var $currentQuestionContainer = $(this).closest('.quiz-question-container');
        var $nextQuestionContainer = $currentQuestionContainer.next('.quiz-question-container');
        var $currentSection = $(this).closest('.quiz-section');
        var $nextSection = $currentSection.next('.quiz-section');

        var addedScore = parseInt($(this).val());
        var questionId = $(this).closest('.quiz-question').attr('id');
        var sectionId = $currentSection.attr('id');

        var previouslyAnswered = localStorage.getItem('answer-' + questionId) != null;
        console.log('Previously answered:', previouslyAnswered);

        if (!previouslyAnswered) {
            answeredQuestions++;
            localStorage.setItem('answeredQuestions', answeredQuestions);
        }

        var previousScore = localStorage.getItem('answer-' + questionId) ? parseInt(localStorage.getItem('answer-' + questionId)) : 0;
        totalScore = totalScore - previousScore + addedScore;
        localStorage.setItem('totalScore', totalScore);

        if (!sectionScores[sectionId]) {
            sectionScores[sectionId] = 0;
        }
        sectionScores[sectionId] = sectionScores[sectionId] - previousScore + addedScore;
        
        localStorage.setItem('sectionScores', JSON.stringify(sectionScores));
        console.log("Updated sectionScores:", sectionScores); // Log the section scores

        updateProgress();

        localStorage.setItem('answer-' + questionId, $(this).val());
        console.log("Answer saved for question:", questionId, "Value:", $(this).val());

        setTimeout(async function () {
            await handleNavigation($currentQuestionContainer, $nextQuestionContainer, null);
            checkNavigationButtons();

            if (!$nextQuestionContainer.length && $nextSection.length && !$nextSection.hasClass('quiz-completion-message')) {
                $currentSection.css('visibility', 'hidden').css('height', '0');
                $nextSection.css('visibility', 'visible').css('height', 'auto');
                $nextSection.find('.quiz-question-container:first').css('visibility', 'visible').css('height', 'auto');
                localStorage.setItem('currentSectionId', $nextSection.attr('id'));
                localStorage.setItem('currentQuestionId', $nextSection.find('.quiz-question-container:first .quiz-question').attr('id'));
            } else if (!$nextQuestionContainer.length && !$nextSection.length) {
                $('.quiz-container').css('visibility', 'hidden').css('height', '0');
                $('.quiz-completion-message').css('visibility', 'visible').css('height', 'auto');
                $('#feedback-form').css('visibility', 'visible').css('height', 'auto');
                $currentSection.css('visibility', 'hidden').css('height', '0');
                $('#prev-question').css('visibility', 'hidden').css('height', '0');
                $('#next-question').css('visibility', 'hidden').css('height', '0');

                var feedback = "Congratulations! You have completed the quiz. Your total score is: " + totalScore + ". ";
               
                // Before submitting the form or sending via AJAX
                $('#section_scores').val(JSON.stringify(sectionScores));

             
                $('.quiz-completion-message p:first').text(feedback);
                $('#user_score').val(totalScore);

                $('input[type="radio"]').prop('checked', false);
                for (var key in localStorage) {
                    if (key.startsWith('answer-')) {
                        localStorage.removeItem(key);
                    }
                }
                localStorage.removeItem('quizProgress');
                localStorage.removeItem('currentQuestionId');
                localStorage.removeItem('currentSectionId');
                localStorage.removeItem('totalScore');
                localStorage.removeItem('answeredQuestions');
                localStorage.removeItem('sectionScores');

            }
        }, 500); // Delay before moving to the next question
    });
    // Ensure you export the functions at the bottom of your file
 

    function restoreAnswers() {
        $('.quiz-question').each(function () {
            var questionId = $(this).attr('id');
            var savedAnswer = localStorage.getItem('answer-' + questionId);

            if (savedAnswer) {
                $(this).closest('.quiz-question-container').find('input[type="radio"][value="' + savedAnswer + '"]').prop('checked', true);
                $(this).closest('.quiz-question-container').addClass('answered');
            }
        });

        answeredQuestions = $('.quiz-question-container.answered').length;
        updateProgress();
    }
    $('#quiz-feedback-form').on('submit', function (e) {
        e.preventDefault(); // Prevent default form submission

        var formData = $(this).serialize() + '&action=send_quiz_feedback';

        $.ajax({
            type: 'POST',
            url: ajax_object.ajax_url,
            data: formData,
            success: function (response) {
                alert('Feedback sent successfully!');
            },
            error: function () {
                alert('There was an error sending your feedback. Please try again.');
            }
        });
    });
    if (typeof module !== 'undefined' && typeof module.exports !== 'undefined') {
        module.exports = {
            showFirstQuestionAndSection,
            startOverQuiz,
            updateProgress,
            restoreAnswers,
            navigateToSavedState,
            handleNavigation,
            checkNavigationButtons
        };
    } else {
        window.quizActions = {
            showFirstQuestionAndSection,
            startOverQuiz,
            updateProgress,
            restoreAnswers,
            navigateToSavedState,
            handleNavigation,
            checkNavigationButtons
        };
    }
})(jQuery);

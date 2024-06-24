jQuery(document).ready(function ($) {
    console.log("Document is ready");

    var totalScore = parseInt(localStorage.getItem('totalScore')) || 0;
    console.log("Initial totalScore:", totalScore);

    var totalQuestions = $('.quiz-question-container').length;
    console.log("Total number of questions:", totalQuestions);

    var answeredQuestions = parseInt(localStorage.getItem('answeredQuestions')) || 0;
    console.log("Initial answeredQuestions:", answeredQuestions);

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
        localStorage.removeItem('currentQuestionId');
        localStorage.removeItem('currentSectionId');
        localStorage.removeItem('totalScore');
        localStorage.removeItem('answeredQuestions');
        localStorage.removeItem('quizProgress');

        // Reset variables
        totalScore = 0;
        answeredQuestions = 0;

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

    // Check if saved state exists
    if (savedSectionId && savedQuestionId) {
        // Show quiz container and continue/start over buttons
        navigateToSavedState();
        $('.quiz-container').addClass('shaded'); // Add shaded class to quiz container
        $('.button-container').css('display', 'block');

        // Display buttons
        var $continueButton = $('<button>').text('Continue').addClass('continue-button');
        var $startOverButton = $('<button>').text('Start Over').addClass('start-over-button');
        $('.button-container').append($continueButton).append($startOverButton);

        // Show buttons
        $continueButton.show();
        $startOverButton.show();

        // Button click handlers
        $continueButton.on('click', function () {
            $('.button-container').fadeOut(300);
            $('.quiz-container').removeClass('shaded').fadeIn(300); // Remove shaded class and fade in quiz container
        });

        $startOverButton.on('click', function () {
            startOverQuiz();
            $('.button-container').fadeOut(300);
            $('.quiz-container').removeClass('shaded').fadeIn(300); // Remove shaded class and fade in quiz container
        });
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

    function handleNavigation($currentQuestionContainer, $nextQuestionContainer, $prevQuestionContainer) {
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
        $('.prev-question').prop('disabled', isFirstQuestion && isSecondSection);

        // Disable Next button if at the last question of the last section
        $('.next-question').prop('disabled', isLastQuestion && isLastSection);
    }

    $('#next-question').click(function () {
        console.log("Next question button clicked");

        var $currentQuestionContainer = $('.quiz-question-container').filter(function () {
            return $(this).css('visibility') === 'visible';
        });

        var $nextQuestionContainer = $currentQuestionContainer.next('.quiz-question-container');

        if (!$nextQuestionContainer.length) {
            var $currentSection = $currentQuestionContainer.closest('.quiz-section');
            var $nextSection = $currentSection.next('.quiz-section');
            if ($nextSection.length) {
                $nextQuestionContainer = $nextSection.find('.quiz-question-container').first();
            }
        }

        handleNavigation($currentQuestionContainer, $nextQuestionContainer, null);
        checkNavigationButtons();
    });

    $('#prev-question').click(function () {
        console.log("Previous question button clicked");

        var $currentQuestionContainer = $('.quiz-question-container').filter(function () {
            return $(this).css('visibility') === 'visible';
        });

        var $prevQuestionContainer = $currentQuestionContainer.prev('.quiz-question-container');

        if (!$prevQuestionContainer.length) {
            var $currentSection = $currentQuestionContainer.closest('.quiz-section');
            var $prevSection = $currentSection.prev('.quiz-section');
            if ($prevSection.length) {
                $prevQuestionContainer = $prevSection.find('.quiz-question-container').last();
            }
        }

        handleNavigation($currentQuestionContainer, null, $prevQuestionContainer);
        checkNavigationButtons();
    });

    $('input[type=radio]').change(function () {
        console.log("Radio button changed");

        var $currentQuestionContainer = $(this).closest('.quiz-question-container');
        var $nextQuestionContainer = $currentQuestionContainer.next('.quiz-question-container');
        var $currentSection = $(this).closest('.quiz-section');
        var $nextSection = $currentSection.next('.quiz-section');

        var addedScore = parseInt($(this).val());
        var questionId = $(this).closest('.quiz-question').attr('id');
        var previouslyAnswered = localStorage.getItem('answer-' + questionId) != null;
        console.log('Previously answered:', previouslyAnswered);

        if (!previouslyAnswered) {
            answeredQuestions++;
            localStorage.setItem('answeredQuestions', answeredQuestions);
        }

        var previousScore = localStorage.getItem('answer-' + questionId) ? parseInt(localStorage.getItem('answer-' + questionId)) : 0;
        totalScore = totalScore - previousScore + addedScore;
        localStorage.setItem('totalScore', totalScore);

        updateProgress();

        localStorage.setItem('answer-' + questionId, $(this).val());
        console.log("Answer saved for question:", questionId, "Value:", $(this).val());

        setTimeout(function () {
            handleNavigation($currentQuestionContainer, $nextQuestionContainer, null);
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
                $('.prev-question').css('visibility', 'hidden').css('height', '0');
                $('.next-question').css('visibility', 'hidden').css('height', '0');

                var feedback = "Congratulations! You have completed the quiz. Your total score is: " + totalScore + ". ";
                if (totalScore <= 120) {
                    feedback += "Based on your score, here's some tailored feedback...";
                } else if (totalScore <= 240) {
                    feedback += "You're doing great! Here's some feedback...";
                } else {
                    feedback += "Excellent! You've achieved a high score. Here's your reward...";
                }
                $('.quiz-completion-message p:first').text(feedback);
                $('#user_score').val(totalScore);

                localStorage.removeItem('quizProgress');
                localStorage.removeItem('currentQuestionId');
                localStorage.removeItem('currentSectionId');
                localStorage.removeItem('totalScore');
                localStorage.removeItem('answeredQuestions');
            }
        }, 500); // Delay before moving to the next question
    });

    function restoreAnswers() {
        console.log("Restoring answers...");
        console.log(localStorage);

        // Check if there are saved answers in localStorage
        var savedAnswers = localStorage.getItem('answeredQuestions');
        if (savedAnswers) {
            $('.quiz-question-container').each(function () {
                var questionId = $(this).find('.quiz-question').attr('id');
                var savedAnswer = localStorage.getItem('answer-' + questionId);
                if (savedAnswer) {
                    // Find the radio input and check it
                    var $radioInput = $('input[name="' + questionId + '"][value="' + savedAnswer + '"]');
                    $radioInput.prop('checked', true).change();

                    console.log("Restored answer for question:", questionId, "Value:", savedAnswer);
                }
            });

        } else {
            console.log("No saved answers to restore.");
        }
    }


    // Hover effect for radio buttons
    $('input[type=radio]').hover(
        function () {
            $(this).closest('label').css('background-color', '#000');
        }, function () {
            $(this).closest('label').css('background-color', '');
        }
    );

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

});
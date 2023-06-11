<?php

namespace Kieran\Component\MyQuiz\Site\View\QuizView;

defined('_JEXEC') or die;

use Joomla\CMS\MVC\View\HtmlView as BaseHtmlView;
use Joomla\CMS\Factory;
use Joomla\CMS\Language\Text;

/**
 * @package     Joomla.Site
 * @subpackage  com_myQuiz
 */

class HtmlView extends BaseHtmlView {
    
    public function display($template = null) {
        $this->quiz = $this->get('Item', 'Quiz');
        $this->questions = $this->get('Items', 'Questions');
        $this->answers = $this->get('Items', 'Answers');
        $userAnswers = Factory::getApplication()->getUserState('myQuiz.userAnswers');

        $this->question = null;
        foreach ($this->questions as $i => $question) {
            $question->number = $i;
            // Get whether or not the question has been answered
            $question->answered = false;
            if ($userAnswers && array_key_exists($question->id, $userAnswers)) {
                $question->answered = true;
            }
            // Get the currently displayed question
            if ($question->id == Factory::getApplication()->input->getVar('questionId')) {
                $this->question = $this->questions[$i];
            }
        }

        // Get the users answers for the current question from the user state
        if ($this->question && $userAnswers && array_key_exists($this->question->id, $userAnswers)) {
            $this->userAnswers = $userAnswers[$this->question->id];
        } else {
            $this->userAnswers = null;
        }

        // Change the input type to radio if question only has one correct answer
        $correctAnswerCount = 0;
        foreach ($this->answers as $answer) {
            if ($answer->markValue > 0) {
                $correctAnswerCount++;
            }
        }
        $this->isRadio = $correctAnswerCount == 1;

        parent::display($template);
    }

}
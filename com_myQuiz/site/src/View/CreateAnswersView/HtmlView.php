<?php

namespace Kieran\Component\MyQuiz\Site\View\CreateAnswersView;

defined('_JEXEC') or die;

use Joomla\CMS\MVC\View\HtmlView as BaseHtmlView;
use Joomla\CMS\Factory;


/**
 * @package     Joomla.Site
 * @subpackage  com_myQuiz
 *
 */

class HtmlView extends BaseHtmlView {
    


    public function display($template = null) {

        $this->quizId = Factory::getApplication()->getUserState('myQuiz.quizId');
        $this->questionDescription = Factory::getApplication()->getUserState('myQuiz.createQuestionDescription');
        $this->answerNumber = Factory::getApplication()->input->get('answerNumber') + 1;
        $this->questionNumber = Factory::getApplication()->input->get('questionNumber');
        $this->answerArray = Factory::getApplication()->getUserState('myQuiz.createAnswerData');

        // Call the parent display to display the layout file
        parent::display($template);
    }

}
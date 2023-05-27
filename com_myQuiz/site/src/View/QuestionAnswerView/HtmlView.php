<?php

namespace Kieran\Component\MyQuiz\Site\View\QuestionAnswerView;

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

        $this->items = $this->get('Items');
        $this->questions = $this->get('Items', 'QuizQuestions');

        // Consolidate from multiple items to a single variable
        foreach ($this->items as $i => $row){
            $this->quizId = $row->quizId;
            $this->title = $row->title;
            $this->questionNumber = $row->questionNumber;
            $this->question = $row->questionDescription;
            $this->imageId = $row->imageId;
            $this->imageUrl = $row->imageUrl;
        }

        $this->count = count($this->questions);

        $this->answerNumber = 0;

        $this->userQuestionData = Factory::getApplication()->getUserState('myQuiz.userQuestionData');
        foreach ($this->userQuestionData as $data){
            if(isset($data['questionNumber'])) {
                if($data['questionNumber'] === $this->questionNumber) {
                    $this->answerNumber = $data['answerNumber'];
                }          
            }
        }

        // Call the parent display to display the layout file
        parent::display($template);
    }

}
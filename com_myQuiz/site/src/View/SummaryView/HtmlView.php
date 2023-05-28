<?php

namespace Kieran\Component\MyQuiz\Site\View\SummaryView;

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

        $this->items = $this->get('Items');
        $this->questions = $this->get('Items', 'QuizQuestions');

        $model = $this->getModel('SaveAnswers');
        $this->marks = 0;
        $this->total = 0;
        
        foreach($this->items as $item) {
            if($item->isCorrect) {
                $this->marks = $this->marks + $item->markValue;
            }
        }

        foreach($this->questions as $question) {
            $this->total = $this->total + $question->markValue;
        }

        $model->saveQuiz($this->marks, $this->total);

        // Call the parent display to display the layout file
        parent::display($template);
    }

}
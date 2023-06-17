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
        $items = $this->get('Items');
        $this->quiz = $this->get('Item', 'Quiz');
        $this->justFinished = Factory::getApplication()->getUserState('myImageViewer_myQuiz.view') == 'QUIZ';

        $this->items = [];
        $this->userScore = 0;
        $this->maxScore = 0;

        $i = 0;
        foreach ($items as $item) {
            // Create new question if required
            if (!array_key_exists($item->id, $this->items)) {
                $question = new \stdClass();
                $question->number = $i++;
                $question->userScore = 0;
                $question->maxScore = 0;
                $question->description = $item->questionDescription;
                $question->answers = [];
                $question->feedback = $item->feedback;
                $this->items[$item->id] = $question;
            }
            // Create new answer
            $answer = new \stdClass();
            $answer->description = $item->answerDescription;
            $answer->markValue = $item->markValue;
            $answer->selected = !$item->userId == null;
            if ($answer->selected) {
                $this->items[$item->id]->userScore += $answer->markValue;
            }
            if ($item->markValue > 0) {
                $this->items[$item->id]->maxScore += $item->markValue;
            }
            array_push($this->items[$item->id]->answers, $answer);
        }

        foreach ($this->items as $item) {
            $this->userScore += $item->userScore;
            $this->maxScore += $item->maxScore;
        }

        $this->items = array_values($this->items);

        parent::display($template);
    }

}
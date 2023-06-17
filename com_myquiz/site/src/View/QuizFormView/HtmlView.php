<?php

namespace Kieran\Component\MyQuiz\Site\View\QuizFormView;

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
        $this->images = $this->get('Items');
        $this->isEdit = false;
        if (Factory::getApplication()->input->getVar('quizId') != null) {
            $this->quiz = $this->get('Item', 'Quiz');
            $this->isEdit = true;
            $this->quizTitle = $this->quiz->title;
        } else {
            $this->quiz = new \stdClass();
        }

        $storedFormData = Factory::getApplication()->getUserState('myQuiz.quizForm');
        if ($storedFormData) {
            unset($storedFormData['quizId']);
            foreach ($storedFormData as $key => $value) {
                $this->quiz->{$key} = $value ? $value : null;
            }
        }

        parent::display($template);
    }

}
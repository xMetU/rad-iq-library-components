<?php

namespace Kieran\Component\MyQuiz\Site\View\AnswerFormView;

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

        $this->question = $this->get('Item', 'Question');
        if ($answerId = Factory::getApplication()->input->getVar('answerId')) {
            $this->answer = $this->findAnswer($answerId, $this->items);
        } else {
            $this->answer = null;
        }

        parent::display($template);
    }

    private function findAnswer($answerId, $answers) {
        foreach ($answers as $answer) {
            if ($answer->id == $answerId) {
                return $answer;
            }
        }
        return null;
    }

}
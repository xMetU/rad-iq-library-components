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

        if (Factory::getApplication()->input->getVar('quizId') != null) {
            $this->quiz = $this->get('Item', 'Quiz');
        } else {
            $this->quiz = null;
        }

        parent::display($template);
    }

}
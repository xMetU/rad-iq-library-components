<?php

namespace Kieran\Component\MyQuiz\Site\View\CreateQuestionsView;

defined('_JEXEC') or die;

use Joomla\CMS\MVC\View\HtmlView as BaseHtmlView;
use Joomla\CMS\Factory;


/**
 * @package     Joomla.Site
 * @subpackage  com_myQuiz
 */

class HtmlView extends BaseHtmlView {
    


    public function display($template = null) {

        $this->questionNumber = Factory::getApplication()->input->get('questionNumber') + 1;


        // Call the parent display to display the layout file
        parent::display($template);
    }

}
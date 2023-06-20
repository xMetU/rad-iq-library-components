<?php

namespace Kieran\Component\MyQuiz\Administrator\View\AdminAttemptView;

defined('_JEXEC') or die;

use Joomla\CMS\MVC\View\HtmlView as BaseHtmlView;
use Joomla\CMS\Factory;

/**
 * @package     Joomla.Administrator
 * @subpackage  com_myQuiz
 */

class HtmlView extends BaseHtmlView {
    

    function display($tpl = null) {

        $this->userId = Factory::getApplication()->input->getInt('userId');
        $this->quizId = Factory::getApplication()->input->getInt('quizId');
        
        parent::display($tpl);
    }

}
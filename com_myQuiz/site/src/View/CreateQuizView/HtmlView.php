<?php

namespace Kieran\Component\MyQuiz\Site\View\CreateQuizView;

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


        // Call the parent display to display the layout file
        parent::display($template);
    }

}
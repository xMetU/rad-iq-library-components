<?php

namespace Kieran\Component\MyQuiz\Site\View\AllQuizView;

defined('_JEXEC') or die;

use Joomla\CMS\MVC\View\HtmlView as BaseHtmlView;
use Joomla\CMS\Factory;

/**
 * @package     Joomla.Site
 * @subpackage  com_myQuiz
 */


class HtmlView extends BaseHtmlView {
    

    public function display($template = null) {

        $this->items = $this->get('Items');
        $this->categories = $this->get('Items', 'ButtonCategories');
        $this->pagination = $this->get('Pagination');
        $this->category = Factory::getApplication()->input->get('category');
        $this->search = Factory::getApplication()->input->get('search');

        $this->userId = Factory::getUser()->id; 
        $this->model = $this->getModel('SaveAnswers');

        // Call the parent display to display the layout file
        parent::display($template);
    }

}
<?php

namespace Kieran\Component\MyImageViewer\Site\View\CategoryFormView;

defined('_JEXEC') or die;

use Joomla\CMS\MVC\View\HtmlView as BaseHtmlView;
use Joomla\CMS\Factory;

/**
 * @package     Joomla.Site
 * @subpackage  com_myImageViewer
 *
 */

class HtmlView extends BaseHtmlView {

    public function display($template = null) {
        $this->categories = $this->get('Items', 'Categories');
        $this->subcategories = $this->get('CategorySubcategories', 'SubCategories');

        $this->categoryId = Factory::getApplication()->input->getInt('categoryId');
        $this->subcategoryId = Factory::getApplication()->input->getInt('subcategoryId');
        $this->toQuiz = Factory::getApplication()->getUserState('myImageViewer_myQuiz.view') == "QUIZZES";

        Factory::getApplication()->setUserState('myImageViewer.categoryId', $this->categoryId);

        // Call the parent display to display the layout file
        parent::display($template);
    }

}
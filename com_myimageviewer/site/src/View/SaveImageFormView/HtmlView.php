<?php

namespace Kieran\Component\MyImageViewer\Site\View\SaveImageFormView;

defined('_JEXEC') or die;

use Joomla\CMS\MVC\View\HtmlView as BaseHtmlView;
use Joomla\CMS\Factory;

/**
 * @package     Joomla.Site
 * @subpackage  com_myImageViewer
 */

class HtmlView extends BaseHtmlView {

    public function display($template = null) {
        $this->categories = $this->get('AllCategories', 'Categories');
        $this->subcategories = $this->get('CategorySubcategories', 'SubCategories');

        $this->formData = Factory::getApplication()->getUserState('myImageViewer.imageForm');

        $this->categoryId = Factory::getApplication()->input->getInt('categoryId');
        Factory::getApplication()->setUserState('myImageViewer.categoryId', $this->categoryId);

        parent::display($template);
    }

}
<?php

namespace Kieran\Component\MyImageViewer\Site\View\EditImageFormView;

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
        $this->categories = $this->get('AllCategories', 'Categories');
        $this->subcategories = $this->get('CategorySubcategories', 'SubCategories');
        $this->image = $this->get('Item', 'ImageDetails');
        $this->imageName = $this->image->name;
        
        $storedFormData = Factory::getApplication()->getUserState('myImageViewer.imageForm');
        if ($storedFormData) {
            if ($storedFormData['imageName']) { $this->image->name = $storedFormData['imageName']; }
            if ($storedFormData['imageDescription']) { $this->image->description = $storedFormData['imageDescription']; }
            if ($storedFormData['categoryId']) { $this->image->categoryId = $storedFormData['categoryId']; }
            if ($storedFormData['subcategoryId']) { $this->image->subcategoryId = $storedFormData['subcategoryId']; }
        }

        $this->categoryId = Factory::getApplication()->input->getInt('categoryId');
        Factory::getApplication()->setUserState('myImageViewer.categoryId', $this->categoryId);

        parent::display($template);
    }

}
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

        if (Factory::getApplication()->input->getVar('id') != null) {
            $this->image = $this->get('Item', 'ImageDetails');
        } else {
            $this->image = null;            
        }

        $this->categoryId = Factory::getApplication()->input->getInt('categoryId');

        if (!$this->categoryId) {
            $this->categoryId = $this->image->categoryId;
        }

        Factory::getApplication()->setUserState('myImageViewer.categoryId', $this->categoryId);

        $this->categories = $this->get('AllCategories', 'Categories');
        $this->subcategories = $this->get('CategorySubcategories', 'SubCategories');

        
        $this->imageName = Factory::getApplication()->input->getVar('imageName');
        $this->imageDescription = Factory::getApplication()->input->getVar('imageDescription');

        // Call the parent display to display the layout file
        parent::display($template);
    }

}
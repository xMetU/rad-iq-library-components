<?php

namespace Kieran\Component\MyImageViewer\Site\View\ImagesView;

defined('_JEXEC') or die;

use Joomla\CMS\MVC\View\HtmlView as BaseHtmlView;
use Joomla\CMS\Factory;
use Kieran\Component\MyImageViewer\Site\Helper\CheckGroup;

/**
 * @package     Joomla.Site
 * @subpackage  com_myImageViewer
 */

class HtmlView extends BaseHtmlView {


    public function display($template = null) {
        $allImages = $this->get('AllImages');
        $this->items = $this->get('Items');
        $this->categories = $this->get('Items', 'Categories');
        foreach ($this->categories as $category) {
            $category->count = 0;
            foreach ($allImages as $image) {
                if ($image->categoryId == $category->categoryId) {
                    if($image->isHidden){
                        if (CheckGroup::isGroup("Manager")){
                            $category->count++;
                        }
                    }
                    else{
                        $category->count++;
                    }
                    
                }
            }
        }
        $this->subcategories = $this->get('Items', 'SubCategories');
        foreach ($this->subcategories as $subcategory) {
            $subcategory->count = 0;
            foreach ($allImages as $image) {
                if ($image->subcategoryId == $subcategory->subcategoryId) {
                    if($image->isHidden){
                        if (CheckGroup::isGroup("Manager")){
                            $subcategory->count++;
                        }
                    }
                    else{
                        $subcategory->count++;
                    }                   
                }
            }
        }
        $this->pagination = $this->get('Pagination');

        $this->category = Factory::getApplication()->getUserState('myImageViewer_myQuiz.category');
        $this->subcategory = Factory::getApplication()->getUserState('myImageViewer_myQuiz.subcategory');
        $this->search = Factory::getApplication()->input->getVar('search');
        // Call the parent display to display the layout file
        parent::display($template);
    }

}
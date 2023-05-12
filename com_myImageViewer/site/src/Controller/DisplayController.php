<?php

namespace Kieran\Component\MyImageViewer\Site\Controller;

defined('_JEXEC') or die;

use Joomla\CMS\MVC\Controller\BaseController;
use Joomla\CMS\Factory;

/**
 * @package     Joomla.Site
 * @subpackage  com_myImageViewer
 *
 */

class DisplayController extends BaseController {
    
    public function display($cachable = false, $urlparams = array()) {     
        $document = Factory::getDocument();
        $viewFormat = $document->getType();

        $view = $this->getView('ImageView', $viewFormat);

        $model1 = $this->getModel('ImageDisplay');
        $model2 = $this->getModel('ButtonCategories');
        
        $view->setModel($model1, true);
        $view->setModel($model2); 
        
        $view->document = $document;
        $view->display();
    }

    public function focusImage() {        
        $document = Factory::getDocument();
        $viewFormat = $document->getType();

        $view = $this->getView('FocusImageView', $viewFormat);    

        $view->setModel($this->getModel('FocusImage'), true);   

        $view->document = $document;
        $view->display();
    }

    public function uploadForm() {
        $document = Factory::getDocument();
        $viewFormat = $document->getType();

        $view = $this->getView('UploadImageView', $viewFormat);  
        
        $model1 = $this->getModel('UploadImage');
        $model2 = $this->getModel('ButtonCategories');
        
        $view->setModel($model1, true);
        $view->setModel($model2);
    
        $view->document = $document;
        $view->display();
    }

    public function addNewCategory() {
        $document = Factory::getDocument();
        $viewFormat = $document->getType();

        $view = $this->getView('AddNewCategoryView', $viewFormat);  
        
        $model = $this->getModel('AddNewCategory');
        $model2 = $this->getModel('ButtonCategories');

        $view->setModel($model, true);
        $view->setModel($model2);
    
        $view->document = $document;
        $view->display();
    }

}

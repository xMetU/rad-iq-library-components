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
        // $viewName = $this->input->getCmd('view', 'login');
        $viewFormat = $document->getType();

        $view = $this->getView('ImageView', $viewFormat);

        $model1 = $this->getModel('ImageDisplay');
        $model2 = $this->getModel('ButtonCategories');
        
        $view->setModel($model1, true);   
        $view->setModel($model2); 

        $view->document = $document;
        $view->display();
    }


    public function changeImageList() {
        $app = Factory::getApplication();
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

        // Factory::getApplication()->enqueueMessage("focusImage");
        
        $document = Factory::getDocument();
        $viewFormat = $document->getType();

        $view = $this->getView('FocusImageView', $viewFormat);    
        $view->setModel($this->getModel('FocusImage'), true);       
        $view->document = $document;
        $view->display();
    }
}
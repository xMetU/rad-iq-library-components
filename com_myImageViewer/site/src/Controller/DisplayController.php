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

        $view = $this->getView('ImagesView', $viewFormat);

        $model1 = $this->getModel('Images');
        $model2 = $this->getModel('Categories');
        
        $view->setModel($model1, true);
        $view->setModel($model2); 
        
        $view->document = $document;
        $view->display();
    }

    public function imageDetails() {        
        $document = Factory::getDocument();
        $viewFormat = $document->getType();

        $view = $this->getView('ImageDetailsView', $viewFormat);
        
        $model = $this->getModel('ImageDetails');

        $view->setModel($model, true);   

        $view->document = $document;
        $view->display();
    }

    public function imageForm() {
        $document = Factory::getDocument();
        $viewFormat = $document->getType();

        $view = $this->getView('ImageFormView', $viewFormat);  
        
        $model1 = $this->getModel('ImageForm');
        $model2 = $this->getModel('Categories');
        $model3 = $this->getModel('ImageDetails');
        
        $view->setModel($model1, true);
        $view->setModel($model2);
        $view->setModel($model3);
    
        $view->document = $document;
        $view->display();
    }

    public function categoryForm() {
        $document = Factory::getDocument();
        $viewFormat = $document->getType();

        $view = $this->getView('CategoryFormView', $viewFormat);  
        
        $model = $this->getModel('CategoryForm');
        $model2 = $this->getModel('Categories');

        $view->setModel($model, true);
        $view->setModel($model2);
    
        $view->document = $document;
        $view->display();
    }

}

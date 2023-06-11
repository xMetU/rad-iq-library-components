<?php

namespace Kieran\Component\MyImageViewer\Site\Controller;

defined('_JEXEC') or die;

use Joomla\CMS\MVC\Controller\BaseController;
use Joomla\CMS\Factory;
use Joomla\CMS\Router\Route;
use Joomla\CMS\Uri\Uri;

/**
 * @package     Joomla.Site
 * @subpackage  com_myImageViewer
 */


class DisplayController extends BaseController {
    
    public function display($cachable = false, $urlparams = array()) {    
        $document = Factory::getDocument();
        $viewFormat = $document->getType();

        $view = $this->getView('ImagesView', $viewFormat);

        $model1 = $this->getModel('Images');
        $model2 = $this->getModel('Categories');
        $model3 = $this->getModel('SubCategories');
        
        $view->setModel($model1, true);
        $view->setModel($model2); 
        $view->setModel($model3); 
        
        $view->document = $document;
        $view->display();
        Factory::getApplication()->setUserState('myImageViewer_myQuiz.view', 'IMAGES');
    }

    public function imageDetails() {        
        $document = Factory::getDocument();
        $viewFormat = $document->getType();

        $view = $this->getView('ImageDetailsView', $viewFormat);
        
        $model = $this->getModel('ImageDetails');

        $view->setModel($model, true);   

        $view->document = $document;
        $view->display();
        Factory::getApplication()->setUserState('myImageViewer_myQuiz.view', 'IMAGEDETAILS');
    }


    public function saveImageForm() {
        $document = Factory::getDocument();
        $viewFormat = $document->getType();

        $view = $this->getView('SaveImageFormView', $viewFormat);  
        
        $model1 = $this->getModel('ImageForm');
        $model2 = $this->getModel('Categories');
        $model3 = $this->getModel('SubCategories');
        $model4 = $this->getModel('ImageDetails');
        
        $view->setModel($model1, true);
        $view->setModel($model2);
        $view->setModel($model3);
        $view->setModel($model4);
    
        $view->document = $document;
        $view->display();
        Factory::getApplication()->setUserState('myImageViewer_myQuiz.view', 'IMAGEFORM');
    }

    public function editImageForm() {
        $document = Factory::getDocument();
        $viewFormat = $document->getType();

        $view = $this->getView('EditImageFormView', $viewFormat);  
        
        $model1 = $this->getModel('ImageForm');
        $model2 = $this->getModel('Categories');
        $model3 = $this->getModel('SubCategories');
        $model4 = $this->getModel('ImageDetails');
        
        $view->setModel($model1, true);
        $view->setModel($model2);
        $view->setModel($model3);
        $view->setModel($model4);
    
        $view->document = $document;
        $view->display();
        Factory::getApplication()->setUserState('myImageViewer_myQuiz.view', 'IMAGEFORM');
    }

    public function categoryForm() {
        $document = Factory::getDocument();
        $viewFormat = $document->getType();

        $view = $this->getView('CategoryFormView', $viewFormat);  
        
        $model = $this->getModel('CategoryForm');
        $model2 = $this->getModel('Categories');
        $model3 = $this->getModel('SubCategories');

        $view->setModel($model, true);
        $view->setModel($model2);
        $view->setModel($model3);
    
        $view->document = $document;
        $view->display();
        Factory::getApplication()->setUserState('myImageViewer_myQuiz.view', 'CATEGORYFORM');
    }

}

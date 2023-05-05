<?php

namespace Kieran\Component\MyQuiz\Site\Controller;

defined('_JEXEC') or die;

use Joomla\CMS\MVC\Controller\BaseController;
use Joomla\CMS\Factory;
use Joomla\CMS\Router\Route;


/**
 * @package     Joomla.Site
 * @subpackage  com_myQuiz
 *
 */

class DisplayController extends BaseController {
    


    public function display($cachable = false, $urlparams = array()) {     

        $document = Factory::getDocument();
        $viewFormat = $document->getType();

        $view = $this->getView('AllQuizView', $viewFormat);
        $model = $this->getModel('AllQuiz');
        
        $view->setModel($model, true);   

        $view->document = $document;
        $view->display();
    }


    public function questionDisplay() {

        $userId = Factory::getUser()->id;

        // Not logged in
        if($userId === 0) {
            Factory::getApplication()->enqueueMessage('Please login to continue');
            $this->setRedirect(Route::_('?index.php', false));
        }

        else{
            $document = Factory::getDocument();
            $viewFormat = $document->getType();
    
            $model1 = $this->getModel('QuestionAnswers');
            $model2 = $this->getModel('QuizQuestions');
            $model3 = $this->getModel('Image');
    
            $view = $this->getView('QuestionAnswerView', $viewFormat);       
            $view->setModel($model1, true);   
            $view->setModel($model2, false);
            $view->setModel($model3, false);
    
            $view->document = $document;
            $view->display();
        }
    }


    public function summaryDisplay() {

        $document = Factory::getDocument();
        $viewFormat = $document->getType();

        $view = $this->getView('SummaryView', $viewFormat);
        $model = $this->getModel('Summary');
        
        $view->setModel($model, true);   

        $view->document = $document;
        $view->display();
    }

}
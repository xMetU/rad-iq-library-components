<?php

namespace Kieran\Component\MyQuiz\Administrator\Controller;

defined('_JEXEC') or die;

use Joomla\CMS\MVC\Controller\BaseController;
use Joomla\CMS\Factory;
use Joomla\CMS\Uri\Uri;
use Joomla\CMS\Router\Route;

/**
 * @package     Joomla.Administrator
 * @subpackage  com_myQuiz
 */


class DisplayController extends BaseController {

    
    public function display($cachable = false, $urlparams = array()) {

        $document = Factory::getDocument();
        $viewFormat = $document->getType();

        $view = $this->getView('AdminQuizView', $viewFormat);

        $model = $this->getModel('AttemptReset');
        $view->setModel($model, true);

        $view->document = $document;
        $view->display();

    }

    
    public function attemptView() {
        $document = Factory::getDocument();
        $viewFormat = $document->getType();

        $view = $this->getView('AdminAttemptView', $viewFormat);

        $view->document = $document;
        $view->display();
    }

    public function resetAttempts() {
        $model = $this->getModel('AttemptReset');

        $userId = Factory::getApplication()->input->post->getInt('userId');
        $quizId = Factory::getApplication()->input->post->getInt('quizId');

        $model->deleteUserAttempts($userId, $quizId);

        $this->setRedirect(Route::_(Uri::getInstance()->current() . '?&option=com_myQuiz&task=Display.display', false));
    }
    
}
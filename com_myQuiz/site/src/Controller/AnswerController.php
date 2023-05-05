<?php

namespace Kieran\Component\MyQuiz\Site\Controller;

defined('_JEXEC') or die;

use Joomla\CMS\MVC\Controller\BaseController;
use Joomla\CMS\Factory;
use Joomla\CMS\Router\Route;
use Joomla\CMS\Uri\Uri;


/**
 * @package     Joomla.Site
 * @subpackage  com_myQuiz
 *
 */

class AnswerController extends BaseController {
    


    public function nextQuestion() {     
        // Factory::getApplication()->enqueueMessage('next');
        
        $userId = Factory::getUser()->id;       
        $quizId = Factory::getApplication()->input->post->get('quizId');
        $questionNumber = Factory::getApplication()->input->post->get('questionNumber');
        $answerNumber = Factory::getApplication()->input->post->get('selectedAnswer');
        $count = Factory::getApplication()->input->post->get('count');

        if($this->saveData($userId, $quizId, $questionNumber, $answerNumber)){
            
        }
        
        // Check if not logged in
        if($userId === 0) {
            Factory::getApplication()->enqueueMessage('Please login to continue');
            $this->setRedirect(Route::_('?index.php', false));
        }

        else if($questionNumber < $count) {
            $this->setRedirect(Uri::getInstance()->current() . Route::_('?&id=' . $quizId . '&question=' . ($questionNumber + 1) . '&count='. $count . '&task=Display.questionDisplay', false));
        }

        else{
            $this->setRedirect(Uri::getInstance()->current() . Route::_('?&id=' . $quizId . '&task=Display.summaryDisplay', false));
        }
        
    }


    public function prevQuestion() {     
        // Factory::getApplication()->enqueueMessage('prev');
        
        $userId = Factory::getUser()->id;       
        $quizId = Factory::getApplication()->input->post->get('quizId');
        $questionNumber = Factory::getApplication()->input->post->get('questionNumber');
        $answerNumber = Factory::getApplication()->input->post->get('selectedAnswer');
        $count = Factory::getApplication()->input->post->get('count');

        if($this->saveData($userId, $quizId, $questionNumber, $answerNumber)){

        }
        
        // Not logged in
        if($userId === 0) {
            Factory::getApplication()->enqueueMessage('Please login to continue');
            $this->setRedirect(Route::_('?index.php', false));
        }

        else if($questionNumber > 0) {
            $this->setRedirect(Uri::getInstance()->current() . Route::_('?&id=' . $quizId . '&question=' . ($questionNumber - 1) . '&count='. $count . '&task=Display.questionDisplay', false));
        }
    }


    public function saveData($userId, $quizId, $questionNumber, $answerNumber) {

        $model = $this->getModel('SaveAnswers');

        if($answerNumber) {
            Factory::getApplication()->enqueueMessage('answered');
    
            if($model->saveAnswer($userId, $quizId, $questionNumber, $answerNumber)) {
                return true;
            }
            else {
                return false;
            }        
        }       
    }


}
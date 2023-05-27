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
    

    public function startQuiz() {
        
        $userId = Factory::getUser()->id;       
        $quizId = Factory::getApplication()->input->getInt('id');
        $attemptsAllowed = Factory::getApplication()->input->getInt('attemptsAllowed');
    
        // Check if not logged in
        if($userId === 0) {
            Factory::getApplication()->enqueueMessage('Please login to continue');
            $this->setRedirect(Route::_('?index.php', false));
        }
        else {      
            // Check if user has allowed attempts left
            $model = $this->getModel('SaveAnswers');
            $attemptNumber = $model->checkAttempts($userId, $quizId);

            // An attempt is allowed. Quiz can proceed
            if($attemptNumber < $attemptsAllowed) {

                /** UserQuestionData is an array that stores arrays of userAnswerData. 
                  * User variables are loaded into UserState, which are persistant variables like php $_SESSION variables. 
                  * User data can be stored while undertaking the quiz, all answers can be saved on completion. */
                Factory::getApplication()->setUserState('myQuiz.userQuestionData', array());
                Factory::getApplication()->setUserState('myQuiz.userUserId', $userId);
                Factory::getApplication()->setUserState('myQuiz.userQuizId', $quizId);
                Factory::getApplication()->setUserState('myQuiz.userAttemptNumber', $attemptNumber + 1);
    
                $this->setRedirect(Uri::getInstance()->current() . Route::_('?&question=1&task=Display.questionDisplay', false));

            }
            else{
                Factory::getApplication()->enqueueMessage('You have reached the attempt limit for this quiz');
                $this->setRedirect(Uri::getInstance()->current() . Route::_('?&task=Display.display', false));
            }

        }
    }


    // Called when the user selects the next question in a quiz.
    public function nextQuestion() {     
        
        $userId = Factory::getApplication()->getUserState('myQuiz.userUserId');       
        $quizId =  Factory::getApplication()->getUserState('myQuiz.userQuizId');

        // Get filtered data from post
        $questionNumber = Factory::getApplication()->input->post->getInt('questionNumber');
        $answerNumber = Factory::getApplication()->input->post->getInt('selectedAnswer');
        $count = Factory::getApplication()->input->post->getInt('count');

        // Load data into array
        $userAnswerData = array('userId' => $userId, 'quizId' => $quizId, 'questionNumber' => $questionNumber, 
                                'answerNumber' => $answerNumber, 'count' => $count);

        // If an answer has been selected for the question, save the answer into the users userState answer array. 
        if($answerNumber) {
            $this->loadUserAnswer($userAnswerData, $questionNumber, $answerNumber);
        }

        if($questionNumber < $count) {
            $this->setRedirect(Uri::getInstance()->current() . Route::_('?&question=' . ($questionNumber + 1) . '&count='. $count . '&task=Display.questionDisplay', false));
        }

        else{
            $this->setRedirect(Uri::getInstance()->current() . Route::_('?&task=Display.summaryDisplay', false));
        }
    }

    
    // Called when the user selects the previous question in a quiz.
    public function prevQuestion() {     
        
        $userId = Factory::getApplication()->getUserState('myQuiz.userUserId');       
        $quizId =  Factory::getApplication()->getUserState('myQuiz.userQuizId');

        // Get filtered data from post
        $questionNumber = Factory::getApplication()->input->post->getInt('questionNumber');
        $answerNumber = Factory::getApplication()->input->post->getInt('selectedAnswer');
        $count = Factory::getApplication()->input->post->getInt('count');
        
        // Load data into array
        $userAnswerData = array('userId' => $userId, 'quizId' => $quizId, 'questionNumber' => $questionNumber, 
                                'answerNumber' => $answerNumber, 'count' => $count);

        // If an answer has been selected for the question, save the answer into the users userState answer array.                      
        if($answerNumber) {
            $this->loadUserAnswer($userAnswerData, $questionNumber, $answerNumber);
        }
        
        if($questionNumber > 0) {
            $this->setRedirect(Uri::getInstance()->current() . Route::_('?&question=' . ($questionNumber - 1) . '&count='. $count . '&task=Display.questionDisplay', false));
        }
    }



    public function loadUserAnswer($userAnswerData, $questionNumber, $answerNumber) {
        $userQuestionData = Factory::getApplication()->getUserState('myQuiz.userQuestionData');
        $storeAnswer = true;

        foreach ($userQuestionData as $d => $data){
            // if the question has already been answered
            if(isset($data['questionNumber'])) {
                if($data['questionNumber'] === $questionNumber) {
                    // If it is already the same answer, don't do anything
                    if(isset($data['answerNumber'])) {
                        if($data['answerNumber'] === $answerNumber) {
                            $storeAnswer = false; 
                        }
                        // The user has changed answers. change the old answer to the new answer
                        else{
                            $userQuestionData[$d]['answerNumber'] = $answerNumber;
                            $storeAnswer = false; 
                        }
                    }                      
                }   
            }            
        }
        // The question has not already been answered and can be loaded in
        if($storeAnswer) {
            array_push($userQuestionData, $userAnswerData);
        }
        
        Factory::getApplication()->setUserState('myQuiz.userQuestionData', $userQuestionData);
    }



    public function saveData() {

        $userId = Factory::getApplication()->getUserState('myQuiz.userUserId');       
        $quizId =  Factory::getApplication()->getUserState('myQuiz.userQuizId');

        // Get filtered data from post
        $questionNumber = Factory::getApplication()->input->post->getInt('questionNumber');
        $answerNumber = Factory::getApplication()->input->post->getInt('selectedAnswer');
        $count = Factory::getApplication()->input->post->getInt('count');

        $userAnswerData = array('userId' => $userId, 'quizId' => $quizId, 'questionNumber' => $questionNumber, 
                                'answerNumber' => $answerNumber, 'count' => $count);

        // Load the final question into the answer array.                        
        if($answerNumber) {
            $this->loadUserAnswer($userAnswerData, $questionNumber, $answerNumber);
        }
        
        // Save all the answers to the database
        $model = $this->getModel('SaveAnswers');
        $userQuestionData = Factory::getApplication()->getUserState('myQuiz.userQuestionData');
        $model->saveAnswers($userQuestionData);
        
        $this->setRedirect(Uri::getInstance()->current() . Route::_('?&quizId=' . $quizId . '&task=Display.summaryDisplay', false));
    }


}
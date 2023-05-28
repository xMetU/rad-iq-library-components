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

class CreateQuizController extends BaseController {
    

    public function processQuiz() {

		$model = $this->getModel('CreateQuiz');	

        // Get filtered data from post
        $title = $this->input->post->getVar('title');
        $description = $this->input->post->getVar('description');
        $imageId = $this->input->post->getInt('imageId');
        $attemptsAllowed = $this->input->post->getInt('attemptsAllowed');

        $data = array('title' => $title, 'description' => $description, 
                    'imageId' => $imageId, 'attemptsAllowed' => $attemptsAllowed);

		$validData = $model->validateQuiz($data); // WRITE VALIDATE FUNCTION

        Factory::getApplication()->setUserState('myQuiz.createQuestionData', array());
        Factory::getApplication()->setUserState('myQuiz.createAnswerData', array());
        Factory::getApplication()->setUserState('myQuiz.createQuizData', $validData);

        $this->setRedirect(Uri::getInstance()->current() . Route::_('?&questionNumber=0' . '&task=Display.createQuestions', false));
    }


    public function processQuestion() {

		$model = $this->getModel('CreateQuiz');

        // Get filtered data from post
        $questionNumber = $this->input->post->getInt('questionNumber');
        $questionDescription = $this->input->post->getVar('questionDescription');  
        $feedback = $this->input->post->getVar('questionFeedback'); 
        $markValue = $this->input->post->getInt('markValue');      

        $data = array('questionNumber' => $questionNumber, 'questionDescription' => $questionDescription, 
                        'feedback' => $feedback, 'markValue' => $markValue);	
                        
        $validData = $model->validateQuiz($data); // WRITE VALIDATE FUNCTION

        $questionDataArray = Factory::getApplication()->getUserState('myQuiz.createQuestionData');

        if(!$questionDataArray) {
            $questionDataArray = array();
        }

        array_push($questionDataArray, $validData);
        Factory::getApplication()->setUserState('myQuiz.createQuestionData', $questionDataArray);
        Factory::getApplication()->setUserState('myQuiz.createQuestionDescription', $questionDescription);

        $this->setRedirect(Uri::getInstance()->current() . Route::_('?&questionNumber=' . $questionNumber . '&answerNumber=0' . '&task=Display.createAnswers', false));
    }


    public function processAnswers() {

        $model = $this->getModel('CreateQuiz');
        $load = true;

        // Get filtered data from post
        $answerNumber = $this->input->post->getInt('answerNumber');
        $questionNumber = $this->input->post->getInt('questionNumber');     
        $answerDescription = $this->input->post->getVar('answerDescription');       
        $isCorrect = $this->input->post->getInt('isCorrect');		

        if(!$isCorrect) {
            $isCorrect = 0;
        }
        
        $data = array('answerNumber' => $answerNumber, 'questionNumber' => $questionNumber, 
                    'answerDescription' => $answerDescription, 'isCorrect' => $isCorrect);

        $validData = $model->validateQuiz($data);

        $answerDataArray = Factory::getApplication()->getUserState('myQuiz.createAnswerData');

        if(!$answerDataArray) {
            $answerDataArray = array();
        }
        else{
            foreach($answerDataArray as $answer) {
                if($answer['isCorrect'] == 1){
                    if($isCorrect == 1) {
                        Factory::getApplication()->enqueueMessage("The correct answer is already set");
                        $load = false;
                    }
                }
            }
        }

        if($load) {
            array_push($answerDataArray, $validData);
            Factory::getApplication()->setUserState('myQuiz.createAnswerData', $answerDataArray);
        }


        $this->setRedirect(Uri::getInstance()->current() . Route::_('?&questionNumber=' . $questionNumber . '&answerNumber=' . $answerNumber . '&task=Display.createAnswers', false));
    }



    public function saveAllQuiz() {
        
        $quizData = Factory::getApplication()->getUserState('myQuiz.createQuizData');
        $questionData = Factory::getApplication()->getUserState('myQuiz.createQuestionData');
        $answerData = Factory::getApplication()->getUserState('myQuiz.createAnswerData');

        $model = $this->getModel('CreateQuiz');
        $model->saveAllQuizData($quizData, $questionData, $answerData);

        $this->setRedirect(Uri::getInstance()->current() . Route::_('?&task=Display.display', false));
    }


}
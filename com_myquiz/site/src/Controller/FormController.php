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
 */

class FormController extends BaseController {

    public function saveQuiz() {
        $model = $this->getModel('QuizForm');

        // Perform post filtering
        $title = Factory::getApplication()->input->post->getVar('title');
        $imageId = Factory::getApplication()->input->post->getInt('imageId');
        $attemptsAllowed = Factory::getApplication()->input->post->getInt('attemptsAllowed');
        $description = Factory::getApplication()->input->post->getVar('description');

        // Perform server side validation
        if ($this->validateQuiz($title, $imageId, $attemptsAllowed, $description)) {
            $data = array('title' => $title, 'imageId' => $imageId, 'attemptsAllowed' => $attemptsAllowed, 'description' => $description);
            if ($model->saveQuiz($data)) {
                $this->navigateToForm('QUESTION', Factory::getDbo()->insertId());
            } else {
                $this->navigateToForm('QUIZ');
            }         
        }
        else {
            $this->navigateToForm('QUIZ');
        }
    }

    public function updateQuiz() {
        $model = $this->getModel('QuizForm');

        // Perform post filtering
        $quizId = Factory::getApplication()->input->getInt('quizId');
        $title = Factory::getApplication()->input->post->getVar('title');
        $imageId = Factory::getApplication()->input->post->getInt('imageId');
        $attemptsAllowed = Factory::getApplication()->input->post->getInt('attemptsAllowed');
        $description = Factory::getApplication()->input->post->getVar('description');

        // Perform server side validation
        if ($this->validateQuiz($title, $imageId, $attemptsAllowed, $description)) {
            $data = array('quizId' => $quizId, 'title' => $title, 'imageId' => $imageId, 'attemptsAllowed' => $attemptsAllowed, 'description' => $description);
            $model->updateQuiz($data);
        }
        $this->navigateToForm('QUIZ', $quizId);
    }

    public function deleteQuiz() {
        $model = $this->getModel('Quizzes');
        $quizId = Factory::getApplication()->input->getInt('quizId');
        $model->deleteQuiz($quizId);
        $this->navigateToForm();
    }

    public function saveQuestion() {
        $model = $this->getModel('QuestionForm');
        $data = Factory::getApplication()->input->post->getArray();
        $model->saveQuestion($data);
        $this->navigateToForm('ANSWER', Factory::getDbo()->insertId());
    }

    public function updateQuestion() {
        $model = $this->getModel('QuestionForm');
        $data = Factory::getApplication()->input->post->getArray();
        $model->updateQuestion($data);
        $this->navigateToForm('QUESTION', $data['quizId']);
    }

    public function deleteQuestion() {
        $model = $this->getModel('QuestionForm');
        $data = Factory::getApplication()->input->post->getArray();
        $model->deleteQuestion($data['questionId']);
        $this->navigateToForm('QUESTION', $data['quizId']);
    }

    public function saveAnswer() {
        $model = $this->getModel('AnswerForm');
        $data = Factory::getApplication()->input->post->getArray();
        $model->saveAnswer($data);
        $this->navigateToForm('ANSWER', $data['questionId']);
    }

    public function updateAnswer() {
        $model = $this->getModel('AnswerForm');
        $data = Factory::getApplication()->input->post->getArray();
        $model->updateAnswer($data);
        $this->navigateToForm('ANSWER', $data['questionId']);
    }

    public function deleteAnswer() {
        $model = $this->getModel('AnswerForm');
        $data = Factory::getApplication()->input->post->getArray();
        $model->deleteAnswer($data['answerId']);
        $this->navigateToForm('ANSWER', $data['questionId']);
    }

    private function navigateToForm($form = "", $id = "") {
        switch ($form) {
            case 'QUIZ':
                $task = 'quizForm&quizId=';
                break;
            case 'QUESTION':
                $task = 'questionForm&quizId=';
                break;
            case 'ANSWER':
                $task = 'answerForm&questionId=';
                break;
            default:
                $task = 'display';
        }
        $this->setRedirect(Route::_(
            Uri::getInstance()->current() . '?task=Display.' . $task . $id,
            false
        ));
    }

    private function validateQuiz($title, $imageId, $attemptsAllowed, $description) {
        if(empty($title)) {
            Factory::getApplication()->enqueueMessage("Please enter a quiz title.");
            return false;
        }
        if(empty($imageId)) {
            Factory::getApplication()->enqueueMessage("Please select an image.");
            return false;
        }
        if(empty($attemptsAllowed)) {
            Factory::getApplication()->enqueueMessage("Please enter an attempt limit");
            return false;
        }
        if($attemptsAllowed < 1) {
            Factory::getApplication()->enqueueMessage("There is a minimum of 1 attempt. Please enter an attempt limit");
            return false;
        }
        if($attemptsAllowed > 999) {
            Factory::getApplication()->enqueueMessage("There is a limit of 1000 attempts");
            return false;
        }
        return true;
    }

    private function validateQuestion($description, $feedback) {
        if(empty($description)) {
            Factory::getApplication()->enqueueMessage("Please describe the question.");
            return false;
        }
        if(strlen($description) > 200) {
            Factory::getApplication()->enqueueMessage("Question has a limit of 200 characters");
            return false;
        }
        return true;
    }

    private function validateAnswer($description) {
        if(empty($description)) {
            Factory::getApplication()->enqueueMessage("Please describe the answer");
            return false;
        }
        if(strlen($description) > 200) {
            Factory::getApplication()->enqueueMessage("Answer has a limit of 200 characters");
            return false;
        }
            if(empty($markValue)) {
            Factory::getApplication()->enqueueMessage("Please enter a mark value");
            return false;
        }
        if ($markValue < -999 or $markValue > 999) {
            Factory::getApplication()->enqueueMessage("Please enter a mark value between -999 and 999");
            return false;
        }
        return true;
    }
    
}
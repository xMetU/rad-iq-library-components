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

        // Get data from post request (retrieving them individually acts as a filter)
        $title = Factory::getApplication()->input->post->getVar('title');
        $imageId = Factory::getApplication()->input->post->getInt('imageId');
        $attemptsAllowed = Factory::getApplication()->input->post->getInt('attemptsAllowed');
        $description = Factory::getApplication()->input->post->getVar('description');

        // Build data array, store in user state
        $data = ['title' => $title, 'imageId' => $imageId,
            'attemptsAllowed' => $attemptsAllowed, 'description' => $description];
        Factory::getApplication()->setUserState('myQuiz.quizForm', $data);

        // Validate and save quiz
        if ($this->validateQuiz($title, $imageId, $attemptsAllowed, $description)) {
            if ($model->saveQuiz($data)) {
                $this->navigateToQuestionForm(Factory::getDbo()->insertId());
                return;
            }
        }
        $this->navigateToQuizForm();
    }

    public function updateQuiz() {
        $model = $this->getModel('QuizForm');

        $quizId = Factory::getApplication()->input->getInt('quizId');
        $title = Factory::getApplication()->input->post->getVar('title');
        $imageId = Factory::getApplication()->input->post->getInt('imageId');
        $attemptsAllowed = Factory::getApplication()->input->post->getInt('attemptsAllowed');
        $description = Factory::getApplication()->input->post->getVar('description');

        $data = ['quizId' => $quizId, 'title' => $title, 'imageId' => $imageId, 
            'attemptsAllowed' => $attemptsAllowed, 'description' => $description];
        Factory::getApplication()->setUserState('myQuiz.quizForm', $data);

        if ($this->validateQuiz($title, $imageId, $attemptsAllowed, $description)) {
            $model->updateQuiz($data);
        }
        $this->navigateToQuizForm($quizId);
    }

    public function deleteQuiz() {
        $model = $this->getModel('Quizzes');
        $quizId = Factory::getApplication()->input->getInt('quizId');
        $model->deleteQuiz($quizId);
        $this->setRedirect(Route::_(Uri::getInstance()->current() . '?task=Display', false));
    }


    public function saveQuestion() {
        $model = $this->getModel('QuestionForm');

        $quizId = Factory::getApplication()->input->post->getInt('quizId');
        $description = Factory::getApplication()->input->post->getVar('description');
        $feedback = Factory::getApplication()->input->post->getVar('feedback');

        if ($this->validateQuestion($description, $feedback)) {
            $data = ['quizId' => $quizId, 'description' => $description, 'feedback' => $feedback];
            $model->saveQuestion($data);
            $this->navigateToAnswerForm(Factory::getDbo()->insertId());
            return;
        }
        $this->navigateToQuestionForm($quizId);
    }

    public function updateQuestion() {
        $model = $this->getModel('QuestionForm');

        $quizId = Factory::getApplication()->input->post->getInt('quizId');
        $questionId = Factory::getApplication()->input->post->getInt('questionId');
        $description = Factory::getApplication()->input->post->getVar('description');
        $feedback = Factory::getApplication()->input->post->getVar('feedback');

        if ($this->validateQuestion($description, $feedback)) {
            $data = ['quizId' => $quizId, 'questionId' => $questionId, 'description' => $description, 'feedback' => $feedback];
            if ($model->updateQuestion($data)) {
                $this->navigateToQuestionForm($quizId);
                return;
            }
        }
        $this->navigateToQuestionForm($quizId, $questionId);
    }

    public function deleteQuestion() {
        $model = $this->getModel('QuestionForm');

        $questionId = Factory::getApplication()->input->post->getInt('questionId');
        $quizId = Factory::getApplication()->input->post->getInt('quizId');

        $model->deleteQuestion($questionId);
        $this->navigateToQuestionForm($quizId);
    }

    public function saveAnswer() {
        $model = $this->getModel('AnswerForm');

        $questionId = Factory::getApplication()->input->post->getInt('questionId');
        $description = Factory::getApplication()->input->post->getVar('description');
        $markValue = Factory::getApplication()->input->post->getInt('markValue');

        if ($this->validateAnswer($description, $markValue)) {          
            $data = [$questionId, $description, $markValue];
            $model->saveAnswer($data);
        }    
        $this->navigateToAnswerForm($questionId);
    }

    public function updateAnswer() {
        $model = $this->getModel('AnswerForm');
        $data = Factory::getApplication()->input->post->getArray();

        $questionId = Factory::getApplication()->input->post->getInt('questionId');
        $answerId = Factory::getApplication()->input->post->getInt('answerId');
        $description = Factory::getApplication()->input->post->getVar('description');
        $markValue = Factory::getApplication()->input->post->getInt('markValue');

        if ($this->validateAnswer($description, $markValue)) {
            $data = ['questionId' => $questionId, 'answerId' => $answerId, 'description' => $description, 'markValue' => $markValue];
            if ($model->updateAnswer($data)) {
                $this->navigateToAnswerForm($questionId);
                return;
            }
        }
        $this->navigateToAnswerForm($questionId, $answerId);
    }

    public function deleteAnswer() {
        $model = $this->getModel('AnswerForm');
        $data = Factory::getApplication()->input->post->getArray();
        $model->deleteAnswer($data['answerId']);
        $this->navigateToAnswerForm($data['questionId']);
    }

    private function navigateToQuizForm($quizId = null) {
        $task = '?task=Display.quizForm';
        if ($quizId) {
            $task = $task . '&quizId=' . $quizId;
        }
        $this->setRedirect(Route::_(Uri::getInstance()->current() . $task, false));
    }

    private function navigateToQuestionForm($quizId = null, $questionId = null) {
        $task = '?task=Display.questionForm&quizId=' . $quizId;
        if ($questionId) {
            $task = $task . '&questionId=' . $questionId;
        }
        $this->setRedirect(Route::_(Uri::getInstance()->current() . $task, false));
    }

    private function navigateToAnswerForm($questionId = null, $answerId = null) {
        $task = '?task=Display.answerForm&questionId=' . $questionId;
        if ($answerId) {
            $task = $task . '&answerId=' . $answerId;
        }
        $this->setRedirect(Route::_(Uri::getInstance()->current() . $task, false));
    }

    private function validateQuiz($title, $imageId, $attemptsAllowed, $description) {
        if (empty($title)) {
            Factory::getApplication()->enqueueMessage("Please enter a quiz title.");
            return false;
        }
        if (empty($imageId)) {
            Factory::getApplication()->enqueueMessage("Please select an image.");
            return false;
        }
        if (empty($attemptsAllowed)) {
            Factory::getApplication()->enqueueMessage("Please enter an attempt limit.");
            return false;
        }
        if ($attemptsAllowed < 1 || $attemptsAllowed > 1000) {
            Factory::getApplication()->enqueueMessage("Attempt limit must be between 1 and 1000.");
            return false;
        }
        return true;
    }

    private function validateQuestion($description, $feedback) {
        if (empty($description)) {
            Factory::getApplication()->enqueueMessage("Please provide a question description.");
            return false;
        }
        if (strlen($description) > 200) {
            Factory::getApplication()->enqueueMessage("Question description must be less than 200 characters.");
            return false;
        }
        if (strlen($feedback) > 200) {
            Factory::getApplication()->enqueueMessage("Question feedback must be less than 200 characters.");
            return false;
        }
        return true;
    }

    private function validateAnswer($description, $markValue) {
        if (empty($description)) {
            Factory::getApplication()->enqueueMessage("Please provide an answer descriptiion.");
            return false;
        }
        if (strlen($description) > 200) {
            Factory::getApplication()->enqueueMessage("Answer must be less than 200 characters.");
            return false;
        }
        if (!isset($markValue)) {
            Factory::getApplication()->enqueueMessage("Please provide a mark value.");
            return false;
        }
        if ($markValue < -100 or $markValue > 100) {
            Factory::getApplication()->enqueueMessage("Mark value must be between -100 and 100.");
            return false;
        }
        return true;
    }
    
}
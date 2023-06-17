<?php

namespace Kieran\Component\MyQuiz\Site\Model;

defined('_JEXEC') or die;

use Joomla\CMS\MVC\Model\ListModel;
use Joomla\CMS\Factory;
use Joomla\CMS\Table\Table;

/**
 * @package     Joomla.Site
 * @subpackage  com_myQuiz
 */


class UserAnswersModel extends ListModel {

    public function getListQuery() {
        $db = $this->getDbo();

        $userId = Factory::getUser()->id;
        $quizId = Factory::getApplication()->input->get('quizId');
        $attemptNumber = Factory::getApplication()->input->get('attemptNumber');

        $query = $db->getQuery(true)
            ->select([
                'q.id', 'q.description AS questionDescription', 'q.feedback', 'a.markValue', 
                'a.description AS answerDescription', 'ua.userId',
            ])
            ->from($db->quoteName('#__myQuiz_answer', 'a'))
            ->join(
                'LEFT',
                $db->quoteName('#__myQuiz_userAnswers', 'ua') . 'ON'
                . $db->quoteName('ua.answerId') . '=' . $db->quoteName('a.id')
                . ' AND ' . $db->quoteName('ua.userId') . ' = ' . $db->quote($userId)
                . ' AND ' . $db->quoteName('ua.attemptNumber') . ' = ' . $db->quote($attemptNumber)
            )
            ->join(
                'LEFT',
                $db->quoteName('#__myQuiz_question', 'q') . 'ON' . $db->quoteName('q.id') . '=' . $db->quoteName('a.questionId')
            )
            ->where($db->quoteName('q.quizId') . '=' . $db->quote($quizId));
       
        return $query;
    }

    public function submitAnswer($data) {
        $db = Factory::getDbo();

        $columns = ['userId', 'answerId', 'attemptNumber'];
        $query = $db->getQuery(true)
			->insert($db->quoteName('#__myQuiz_userAnswers'))
			->columns($db->quoteName($columns))
			->values(implode(',', $db->quote($data)));
		$db->setQuery($query);

        try {
			$db->execute();
			Factory::getApplication()->enqueueMessage("Quiz results saved successfully.");
			return true;
		} catch (\Exception $e) {
            Factory::getApplication()->enqueueMessage("Error: An unknown error has occurred. Please contact your administrator." . $e->getMessage());
			return false;
        }
    }

    public function generateSummary($data) {
        // Creates and inserts a new row in the quizUserSummary table
        $db = Factory::getDbo();

        $columns = ['userId', 'quizId', 'attemptNumber',  'startTime', 'finishTime', 'score', 'maxScore'];

        // Get the score
        $query = $db->getQuery(true)
            ->select('SUM(a.markValue) AS score')
            ->from($db->quoteName('#__myQuiz_userAnswers', 'ua'))
            ->join(
                'LEFT',
                $db->quoteName('#__myQuiz_answer', 'a') . 'ON' . $db->quoteName('a.id') . '=' . $db->quoteName('ua.answerId')
            )
            ->join(
                'LEFT',
                $db->quoteName('#__myQuiz_question', 'q') . 'ON' . $db->quoteName('q.id') . '=' . $db->quoteName('a.questionId')
            )
            ->where($db->quoteName('q.quizId') . ' = ' . $db->quote($data['quizId']))
            ->where($db->quoteName('ua.userId') . ' = ' . $db->quote($data['userId']))
            ->where($db->quoteName('ua.attemptNumber') . ' = ' . $db->quote($data['attemptNumber']));
        $score = $db->setQuery($query)->loadObject()->score;
        if (!$score) {
            $score = 0;
        }
        
        // Get the total score
        $query = $db->getQuery(true)
            ->select('SUM(a.markValue) AS totalMarkValue')
            ->from($db->quoteName('#__myQuiz_answer', 'a'))
            ->join(
                'INNER',
                $db->quoteName('#__myQuiz_question', 'q') . 'ON' . $db->quoteName('q.id') . '=' . $db->quoteName('a.questionId')
            )
            ->where($db->quoteName('q.quizId') . '=' . $db->quote($data['quizId']))
            ->where($db->quoteName('a.markValue') . '> 0');
        $maxScore = $db->setQuery($query)->loadObject()->totalMarkValue;
        
        // Add the scores to the summary
        array_push($data, $score, $maxScore);
        
        // Add the summary
        $query = $db->getQuery(true)
            ->insert($db->quoteName('#__myQuiz_quizUserSummary'))
            ->columns($db->quoteName($columns))
            ->values(implode(',', $db->quote($data)));
        $db->setQuery($query);
        try {
            $db->execute();
        } catch (\Exception $e) {
            Factory::getApplication()->enqueueMessage("Error: An unknown error has occurred. Please contact your administrator.");
        }
    }

    public function getAttemptCount($userId, $quizId) {
        // Returns the number of attempts recorded in quizUserSummary for a given user and quiz
        $db = Factory::getDbo();

        $query = $db->getQuery(true)
            ->select('COUNT(*) AS attemptCount')
            ->from($db->quoteName('#__myQuiz_quizUserSummary', 'qus'))
            ->where($db->quoteName('qus.userId') . '=' . $db->quote($userId))
            ->where($db->quoteName('qus.quizId') . '=' . $db->quote($quizId));
        $result = $db->setQuery($query)->loadObject();

        return $result->attemptCount;
    }

    protected function populateState($ordering = null, $direction = null){
        $limit = 0;
        $this->setState('list.limit', $limit);
    }
   
}
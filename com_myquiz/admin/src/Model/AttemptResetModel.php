<?php

namespace Kieran\Component\MyQuiz\Administrator\Model;

defined('_JEXEC') or die;

use Joomla\CMS\MVC\Model\ListModel;
use Joomla\CMS\Factory;

/**
 * @package     Joomla.Site
 * @subpackage  com_myQuiz
 */

class AttemptResetModel extends ListModel {


    public function getListQuery() {
        $db = $this->getDbo();

        $search = Factory::getApplication()->input->getVar('search');

        $query = $db->getQuery(true)
            ->select([$db->quoteName('qus.userId'), $db->quoteName('u.name'), $db->quoteName('u.username'), $db->quoteName('qus.quizId'), 
                $db->quoteName('q.title'), $db->quoteName('q.attemptsAllowed'), 
                'MAX(' . $db->quoteName('qus.attemptNumber') . ') AS' . $db->quoteName('lastAttempt')])
            ->group($db->quoteName(['qus.userId', 'qus.quizId']))
            ->from($db->quoteName('#__myQuiz_quizUserSummary', 'qus'))
            ->join(
                'LEFT',
                $db->quoteName('#__users', 'u') . ' ON ' . $db->quoteName('u.id') . '=' . $db->quoteName('qus.userId')
            )
            ->join(
                'LEFT',
                $db->quoteName('#__myQuiz_quiz', 'q') . ' ON ' . $db->quoteName('q.id') . '=' . $db->quoteName('qus.quizId')
            );
        
        if (isset($search)) {
            $query = $query->where($db->quoteName('u.username') . ' LIKE ' . $db->quote('%' . $search . '%'));
        }

        return $query;
    }


    // Override global list limit so a reasonable number images are displayed
    protected function populateState($ordering = null, $direction = null) {
        $limit = 15;
        $start = Factory::getApplication()->input->getVar('start');
        $this->setState('list.limit', $limit);
        $this->setState('list.start', $start);
    }



    public function deleteUserAttempts($userId, $quizId) {
        $db = Factory::getDbo();

        $answerList = $this->getAnswerList($quizId);

        foreach($answerList as $answer) {
            $query = $db->getQuery(true)
			->delete($db->quoteName('#__myQuiz_userAnswers'))
			->where($db->quoteName('userId') . '=' . $db->quote($userId)
            . ' AND ' . $db->quoteName('answerId') . '=' . $db->quote($answer->id)); 
            
            $db->setQuery($query);
            try {
                $result = $db->execute();
            } catch (\Exception $e) {
                Factory::getApplication()->enqueueMessage("Error: Problem encountered deleting answers. Please contact your administrator.");
                return false;
            }
        }

        $query = $db->getQuery(true)
			->delete($db->quoteName('#__myQuiz_quizUserSummary'))
			->where($db->quoteName('userId') . '=' . $db->quote($userId)
            . ' AND ' . $db->quoteName('quizId') . '=' . $db->quote($quizId));      
        
        $db->setQuery($query);
		
        try {
            $result = $db->execute();
            Factory::getApplication()->enqueueMessage("User quiz scores deleted and attempts reset successfully.");
            return true;
        } catch (\Exception $e) {
            Factory::getApplication()->enqueueMessage("Error: An unknown error has occurred. Please contact your administrator.");
            return false;
        }
    }


    public function getAnswerList($quizId) {
        
        $db = $this->getDbo();

        $query = $db->getQuery(true)
            ->select($db->quoteName('a.id'))
            ->from($db->quoteName('#__myQuiz_quiz', 'q'))
            ->join(
                'LEFT',
                $db->quoteName('#__myQuiz_question', 'qu') . ' ON ' . $db->quoteName('qu.quizId') . '=' . $db->quoteName('q.id')
            )
            ->join(
                'LEFT',
                $db->quoteName('#__myQuiz_answer', 'a') . ' ON ' . $db->quoteName('a.questionId') . '=' . $db->quoteName('qu.id')
            )
            ->where($db->quoteName('q.id') . '=' . $db->quote($quizId));
        
        $db->setQuery($query);
        $db->execute();

        return $db->loadObjectList();
    }

}
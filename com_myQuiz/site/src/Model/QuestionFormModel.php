<?php

namespace Kieran\Component\MyQuiz\Site\Model;

defined('_JEXEC') or die;

use Joomla\CMS\MVC\Model\BaseModel;
use Joomla\CMS\Factory;
use Joomla\CMS\Table\Table;

/**
 * @package     Joomla.Site
 * @subpackage  com_myQuiz
 *
 */

class QuestionFormModel extends BaseModel {

	public function saveQuestion($data) {
		$db = Factory::getDbo();
        $columns = array('quizId', 'description', 'feedback');

		$query = $db->getQuery(true)
			->insert($db->quoteName('#__myQuiz_question'))
			->columns($db->quoteName($columns))
			->values(implode(',', $db->quote($data)));
		$db->setQuery($query);

		try {
			$db->execute();
			Factory::getApplication()->enqueueMessage("Question saved successfully.");
			return true;
		} catch (\Exception $e) {
            Factory::getApplication()->enqueueMessage("Error: An unknown error has occurred. Please contact your administrator.");
			return false;
		}
	}


	public function updateQuestion($data) {
		$db = Factory::getDbo();

		$query = $db->getQuery(true)
			->update($db->quoteName('#__myQuiz_question'))
			->set($db->quoteName('description') . ' = ' . $db->quote($data['description']))
			->set($db->quoteName('feedback') . ' = ' . $db->quote($data['feedback']))
            ->where($db->quoteName('id') . ' = ' . $db->quote($data['questionId']));
		$db->setQuery($query);
		
		try {
			$result = $db->execute();
			Factory::getApplication()->enqueueMessage("Question updated successfully.");
			return true;
		} catch (\Exception $e) {
            Factory::getApplication()->enqueueMessage("Error: An unknown error has occurred. Please contact your administrator.");
			return false;
		}
	}


	public function deleteQuestion($questionId) {
		$db = Factory::getDbo();
		
		$query = $query = $db->getQuery(true)
            ->delete($db->quoteName('#__myQuiz_question'))
            ->where($db->quoteName('id') . '=' . $db->quote($questionId));
        $db->setQuery($query);

		try {
			$result = $db->execute();
			Factory::getApplication()->enqueueMessage("Question deleted successfully.");
			return true;
		} catch (\Exception $e) {
            Factory::getApplication()->enqueueMessage("Error: An unknown error has occurred. Please contact your administrator.");
			return false;
		}
	}
}
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

class AnswerFormModel extends BaseModel {

	public function saveAnswer($data) {
		$db = Factory::getDbo();
        $columns = array('questionId', 'description', 'markValue');

		$query = $db->getQuery(true)
			->insert($db->quoteName('#__myQuiz_answer'))
			->columns($db->quoteName($columns))
			->values(implode(',', $db->quote($data)));
		$db->setQuery($query);

		try {
			$db->execute();
			Factory::getApplication()->enqueueMessage("Answer saved successfully.");
			return true;
		} catch (\Exception $e) {
            Factory::getApplication()->enqueueMessage($e->getMessage());
			return false;
		}
	}

	public function updateAnswer($data) {
		$db = Factory::getDbo();

		$query = $db->getQuery(true)
			->update($db->quoteName('#__myQuiz_answer'))
			->set($db->quoteName('description') . ' = ' . $db->quote($data['description']))
			->set($db->quoteName('isCorrect') . ' = ' . $db->quote($data['isCorrect']))
            ->where($db->quoteName('id') . ' = ' . $db->quote($data['answerId']));
		$db->setQuery($query);
		
		try {
			$result = $db->execute();
			Factory::getApplication()->enqueueMessage("Answer updated successfully.");
			return true;
		} catch (\Exception $e) {
            Factory::getApplication()->enqueueMessage("Error: An unknown error has occurred. Please contact your administrator.");
			return false;
		}
	}

	public function deleteAnswer($answerId) {
		$db = Factory::getDbo();
		
		$query = $query = $db->getQuery(true)
            ->delete($db->quoteName('#__myQuiz_answer'))
            ->where($db->quoteName('id') . '=' . $db->quote($answerId));
        $db->setQuery($query);

		try {
			$result = $db->execute();
			Factory::getApplication()->enqueueMessage("Answer deleted successfully.");
			return true;
		} catch (\Exception $e) {
            Factory::getApplication()->enqueueMessage("Error: An unknown error has occurred. Please contact your administrator.");
			return false;
		}
	}
}
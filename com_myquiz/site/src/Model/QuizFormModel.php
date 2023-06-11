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

class QuizFormModel extends BaseModel {

	public function saveQuiz($data) {
		$db = Factory::getDbo();
        $columns = array('title', 'imageId', 'attemptsAllowed', 'description');

		$query = $db->getQuery(true)
			->insert($db->quoteName('#__myQuiz_quiz'))
			->columns($db->quoteName($columns))
			->values(implode(',', $db->quote($data)));
		$db->setQuery($query);

		try {
			$db->execute();
			Factory::getApplication()->enqueueMessage("Quiz saved successfully.");
			return true;
		} catch (\Exception $e) {
			if (str_contains($e->getMessage(), "Duplicate")) {
				Factory::getApplication()->enqueueMessage("Error: A quiz already exists with that name.");
			} else {
				Factory::getApplication()->enqueueMessage("Error: An unknown error has occurred. Please contact your administrator.");
			}
			return false;
		}
	}

	public function updateQuiz($data) {
		$db = Factory::getDbo();

		$query = $db->getQuery(true)
			->update($db->quoteName('#__myQuiz_quiz'))
			->set($db->quoteName('title') . ' = ' . $db->quote($data['title']))
			->set($db->quoteName('description') . ' = ' . $db->quote($data['description']))
			->set($db->quoteName('imageId') . ' = ' . $db->quote($data['imageId']))
            ->set($db->quoteName('attemptsAllowed') . ' = ' . $db->quote($data['attemptsAllowed']))
			->where($db->quoteName('id') . ' = ' . $db->quote($data['quizId']));
		$db->setQuery($query);
		
		try {
			$result = $db->execute();
			Factory::getApplication()->enqueueMessage("Quiz updated successfully.");
			return true;
		} catch (\Exception $e) {
			if (str_contains($e->getMessage(), "Duplicate")) {
				Factory::getApplication()->enqueueMessage("Error: A quiz exists with that name.");
			} else {
				Factory::getApplication()->enqueueMessage("Error: An unknown error has occurred. Please contact your administrator.");
			}
			return false;
		}
	}
}
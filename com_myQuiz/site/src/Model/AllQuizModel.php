<?php

namespace Kieran\Component\MyQuiz\Site\Model;

defined('_JEXEC') or die;

use Joomla\CMS\MVC\Model\ListModel;
use Joomla\CMS\Factory;

/**
 * @package     Joomla.Site
 * @subpackage  com_myQuiz
 */

class AllQuizModel extends ListModel {


    // Get a list of quizzes filtered by category
    public function getListQuery() {

        // Get a db connection.
        $db = $this->getDatabase();

        $category = Factory::getApplication()->input->get('category');
        $search = Factory::getApplication()->input->getVar('search');

        // Create a new query object.
        $query = $db->getQuery(true)
            ->select($db->quoteName(['q.id', 'q.title', 'q.description', 'q.imageId', 'i.imageUrl', 'q.attemptsAllowed', 'q.isHidden']))
            ->from($db->quoteName('#__myQuiz_quiz', 'q'))
            ->join(
                'LEFT',
                $db->quoteName('#__myImageViewer_image', 'i') . 'ON' . $db->quoteName('i.id') . '=' . $db->quoteName('q.imageId')
            );

        if(isset($category)){
            $query = $query->where($db->quoteName('i.categoryId') . '=' . $category);
        }
        if (isset($search)) {
            $query->where($db->quoteName('q.title') . ' LIKE ' . $db->quote('%' . $search . '%'));
        }

        return $query;
    }


    // Override global list limit so a reasonable number of quizzes are displayed
    protected function populateState($ordering = null, $direction = null) {
        $limit = 5;
        $start = Factory::getApplication()->input->getVar('start');
        $this->setState('list.limit', $limit);
        $this->setState('list.start', $start);
    }


    public function getTable($type = 'Quiz', $prefix = '', $config = array()) {
		return Factory::getApplication()->bootComponent('com_myQuiz')->getMVCFactory()->createTable($type);
	}

    public function toggleIsHidden($quizId) {
        $db = $this->getDatabase();
        
        $query = $db->getQuery(true)
            ->update($db->quoteName('#__myQuiz_quiz'))
            ->set($db->quoteName('isHidden') . ' = NOT ' . $db->quoteName('isHidden'))
            ->where($db->quoteName('id') . ' = ' . $db->quote($quizId));
        
        $db->setQuery($query);
		
		try {
			$result = $db->execute();	
			return true;
		} catch (\Exception $e) {
			Factory::getApplication()->enqueueMessage("Error: An unknown error has occurred. Please contact your administrator.");
			return false;
		}
    }
        
}
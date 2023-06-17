<?php

namespace Kieran\Component\MyQuiz\Site\Model;

defined('_JEXEC') or die;

use Joomla\CMS\MVC\Model\ListModel;
use Joomla\CMS\Factory;

/**
 * @package     Joomla.Site
 * @subpackage  com_myQuiz
 */

class QuizzesModel extends ListModel {

    public function getTable($type = 'Quiz', $prefix = '', $config = array()) {
		return Factory::getApplication()->bootComponent('com_myQuiz')->getMVCFactory()->createTable($type);
	}

    // Override global list limit so a reasonable number of quizzes are displayed
    protected function populateState($ordering = null, $direction = null) {
        $limit = 5;
        $start = Factory::getApplication()->input->getVar('start');
        $this->setState('list.limit', $limit);
        $this->setState('list.start', $start);
    }

    // Get a list of quizzes filtered by category
    public function getListQuery() {
        $db = $this->getDbo();

        if (Factory::getApplication()->getUserState('myImageViewer_myQuiz.view') == 'QUIZZES') {
            $category = Factory::getApplication()->input->getVar('category');
            $subcategory = Factory::getApplication()->input->getVar('subcategory');
            Factory::getApplication()->setUserState('myImageViewer_myQuiz.category', $category);
            Factory::getApplication()->setUserState('myImageViewer_myQuiz.subcategory', $subcategory);
        } else {
            $category = Factory::getApplication()->getUserState('myImageViewer_myQuiz.category');
            $subcategory = Factory::getApplication()->getUserState('myImageViewer_myQuiz.subcategory');
        }
        $search = Factory::getApplication()->input->getVar('search');

        $query = $db->getQuery(true)
            ->select([
                $db->quoteName('q.id'), $db->quoteName('q.title'), $db->quoteName('q.description'),
                $db->quoteName('i.imageUrl'), $db->quoteName('q.attemptsAllowed'), $db->quoteName('q.isHidden'),
                'COUNT(qu.id) AS' . $db->quoteName('questionCount'),
                'MIN(' . $db->quoteName('qu.id') . ') AS' . $db->quoteName('firstQuestionId')
            ])
            ->group($db->quoteName([
                'q.id', 'q.title', 'q.description',
                'i.imageUrl', 'q.attemptsAllowed', 'q.isHidden'
            ]))
            ->from($db->quoteName('#__myQuiz_quiz', 'q'))
            ->join(
                'LEFT',
                $db->quoteName('#__myImageViewer_image', 'i') . 'ON' . $db->quoteName('i.id') . '=' . $db->quoteName('q.imageId'),
            )
            ->join(
                'LEFT',
                $db->quoteName('#__myQuiz_question', 'qu') . 'ON' . $db->quoteName('qu.quizId') . '=' . $db->quoteName('q.id'),
            );

        if (isset($category)) {
            $query->where($db->quoteName('i.categoryId') . '=' . $category);
            if (isset($subcategory)) {
                $query = $query->where($db->quoteName('i.subcategoryId') . ' = ' . $subcategory);
            }
        }
        if (isset($search)) {
            $query->where($db->quoteName('q.title') . ' LIKE ' . $db->quote('%' . $search . '%'));
        }

        return $query;
    }

    public function toggleIsHidden($quizId) {
        $db = $this->getDbo();
        
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

    public function deleteQuiz($quizId) {
		$db = Factory::getDbo();

        $query = $db->getQuery(true)
            ->delete($db->quoteName('#__myQuiz_quiz'))
            ->where($db->quoteName('id') . '=' . $db->quote($quizId));
        $db->setQuery($query);

        try {
            $db->execute();
            Factory::getApplication()->enqueueMessage("Quiz deleted successfully.");
            return true;
        } catch (\Exception $e) {
            Factory::getApplication()->enqueueMessage("Error: An unknown error has occurred. Please contact your administrator.");
            return false;
        }

	}

    public function getAllQuizzes() {
        $db = $this->getDbo();

        $query = $db->getQuery(true)
            ->select($db->quoteName(['i.categoryId', 'c.categoryName', 'i.subcategoryId', 'sc.subcategoryName', 'q.isHidden']))
            ->from($db->quoteName('#__myQuiz_quiz', 'q'))
            ->join(
                'LEFT',
                $db->quoteName('#__myImageViewer_image', 'i') . ' ON ' . $db->quoteName('i.id') . '=' . $db->quoteName('q.imageId')
            )
            ->join(
                'LEFT',
                $db->quoteName('#__myImageViewer_imageCategory', 'c') . ' ON ' . $db->quoteName('c.categoryId') . '=' . $db->quoteName('i.categoryId')
            )
            ->join(
                'LEFT',
                $db->quoteName('#__myImageViewer_imageSubCategory', 'sc') . ' ON ' . $db->quoteName('sc.categoryId') . '=' . $db->quoteName('i.categoryId')
                . ' AND ' . $db->quoteName('sc.subcategoryId') . '=' . $db->quoteName('i.subcategoryId')
            );
        
        $db->setQuery($query);
        $db->execute();
            
        return $db->loadObjectList();
    }
}
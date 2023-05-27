<?php

namespace Kieran\Component\MyQuiz\Site\Model;

defined('_JEXEC') or die;

use Joomla\CMS\MVC\Model\BaseModel;
use Joomla\CMS\Factory;
use Joomla\CMS\Table\Table;

/**
 * @package     Joomla.Site
 * @subpackage  com_myQuiz
 */

class CreateQuizModel extends BaseModel {


    // TODO - Check data is valid 
    public function validateQuiz($data) {
        return $data;
    }


    public function saveAllQuizData($quizData, $questionData, $answerData) {
        
        $db = Factory::getDbo();

        //========== Save Quiz ====================  
        $columns = array('title', 'description', 'imageId', 'attemptsAllowed');

        try {
            $query = $db->getQuery(true)
                ->insert($db->quoteName('#__myQuiz_quiz'))
                ->columns($db->quoteName($columns))
                ->values(implode(',', $db->quote($quizData)));

			$db->setQuery($query);
			$result = $db->execute();
		}
		catch (\Exception $e){
			echo $e->getMessage();
		}

        $quizId = $db->insertid();


        //========== Save Questions ====================
        $columns = array('questionNumber', 'quizId', 'questionDescription', 'feedback', 'markValue');

        foreach($questionData as $data) {

            // Add quizId to data, then sort the array in the correct order ready for posting to database.
            $temp = array_merge($data, array('quizId' => $quizId));
            $sortArray = array_merge(array_flip($columns), $temp);

            try {
                $query = $db->getQuery(true)
                    ->insert($db->quoteName('#__myQuiz_question'))
                    ->columns($db->quoteName($columns))
                    ->values(implode(',', $db->quote($sortArray)));

                    $db->setQuery($query);
                    $result = $db->execute();
            }
            catch (\Exception $e){
                echo $e->getMessage();
            }
        }       

        //========== Save Answers ====================
        $columns = array('answerNumber','questionNumber','quizId', 'answerDescription', 'isCorrect');
        
        foreach($answerData as $data) {
            
            // Add quizId to data, then sort the array in the correct order ready for posting to database.
            $temp = array_merge($data, array('quizId' => $quizId));
            $sortArray = array_merge(array_flip($columns), $temp);

            try {
                $query = $db->getQuery(true)
                    ->insert($db->quoteName('#__myQuiz_answer'))
                    ->columns($db->quoteName($columns))
                    ->values(implode(',', $db->quote($sortArray)));
        
                $db->setQuery($query);
                $result = $db->execute();
		    }
            catch (\Exception $e){
                echo $e->getMessage();
            }
        }
        return true;
    }


        
}
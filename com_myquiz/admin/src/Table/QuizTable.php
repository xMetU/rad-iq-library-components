<?php

/**
 * @package     Joomla.Administrator
 * @subpackage  com_myQuiz
 */

namespace Kieran\Component\MyQuiz\Administrator\Table;

use Joomla\CMS\Table\Table;
use Joomla\Database\DatabaseDriver;


defined('_JEXEC') or die;


/**
 * Quiz Table class.
 *
 * @since  1.0
 */
class QuizTable extends Table
{
    function __construct(DatabaseDriver $db)
	{
		parent::__construct('#__myQuiz_quiz', 'id', $db);
	}

}
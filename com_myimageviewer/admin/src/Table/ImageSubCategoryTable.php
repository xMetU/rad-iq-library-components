<?php

/**
 * @package     Joomla.Administrator
 * @subpackage  com_myImageViewer
 *
 */

namespace Kieran\Component\MyImageViewer\Administrator\Table;

use Joomla\CMS\Table\Table;
use Joomla\Database\DatabaseDriver;


defined('_JEXEC') or die;


/**
 * Image Table class.
 *
 * @since  1.0
 */
class ImageSubCategoryTable extends Table
{
    function __construct(DatabaseDriver $db)
	{
		parent::__construct('#__myImageViewer_imageSubCategory', 'subcategoryId', $db);
	}

}
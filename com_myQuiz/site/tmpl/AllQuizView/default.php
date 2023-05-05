<?php
/**
 * @package     Joomla.Administrator
 * @subpackage  com_myQuiz
 *
 */

 // No direct access to this file
defined('_JEXEC') or die('Restricted Access');

use Joomla\CMS\Language\Text;
use Joomla\CMS\HTML\HTMLHelper;
use Joomla\CMS\Factory;
use Joomla\CMS\Uri\Uri;
use Joomla\CMS\Router\Route;

?>


<!-- ====== Display all Quizzes =========== -->

<div class="mt-5">
    <?php foreach ($this->items as $i => $row) : ?>
        <div class="row mt-5">
            <div class="col-3">								
				<img id="<?php echo $row->imageId; ?>" src="<?php echo $row->imageUrl; ?>" style="width:150px;height:180px;"/>
			</div>
            <div class="col-9">
                <div class="row mt-2">
                    <div class="col-3 text-center"><?php echo Text::_("Title: ") ?></div>
                    <div class="col-6"><?php echo $row->title; ?></div>
                    <div class="col-3"><a class="btn btn-primary" href="<?php echo Uri::getInstance()->current() . Route::_('?&id='. $row->id . '&question=1&task=Display.questionDisplay') ?>"><?php echo Text::_("START QUIZ")?></a></div>
                </div>

                <div class="row mt-2">
                    <div class="col-3 text-center"><?php echo Text::_("Description: ") ?></div>
                    <div class="col-6"><?php echo $row->description; ?></div>
                </div>
            </div>
        </div>
    <?php endforeach; ?>   
</div>


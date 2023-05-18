<?php
/**
 * @package     Joomla.Administrator
 * @subpackage  com_myQuiz
 */

 // No direct access to this file
defined('_JEXEC') or die('Restricted Access');

use Joomla\CMS\Language\Text;
use Joomla\CMS\HTML\HTMLHelper;
use Joomla\CMS\Factory;
use Joomla\CMS\Uri\Uri;
use Joomla\CMS\Router\Route;

?>


<!-- ====== QUIZ SCORES DISPLAY =========== -->
<div class="mt-5">

    <!-- ====== Title =========== -->
    <div class="text-center text-underline"><h3><?php echo Text::_("QUIZ SCORES"); ?></h3></div>


    <div class="mt-5">
        <table class="table table-bordered table-striped">
            <thead class="table-dark">
                <th class="col-3"><?php echo Text::_("ATTEMPT #"); ?></th>
                <th class="col-3"><?php echo Text::_("TITLE"); ?></th>
                <th class="col-3"><?php echo Text::_("MARKS"); ?></th>
                <th class="col-3"><?php echo Text::_("QUIZ TOTAL"); ?></th>
            </thead>

            <tbody>
                <?php foreach ($this->items as $i => $row) : ?>
                    <tr>
                        <td><?php echo $row->attemptNumber; ?></td>
                        <td><?php echo $row->title; ?></td>
                        <td><?php echo $row->userScore; ?></td>
                        <td><?php echo $row->quizTotalMarks; ?></td>
                    </tr>           
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>

    
    <div class="row mt-5">
        <a class="btn btn-outline-primary col-2"  
            href="<?php echo Uri::getInstance()->current() . Route::_('?&task=Display.display') ?>">
            <?php echo Text::_("BACK TO QUIZ LIST"); ?>
        </a>
    </div> 

</div>



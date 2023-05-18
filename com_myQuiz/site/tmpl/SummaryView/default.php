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


<!-- ====== SUMMARY DISPLAY =========== -->
<div class="mt-5">

    <!-- ====== Title =========== -->
    <div class="text-center text-underline"><h3><?php echo Text::_("SUMMARY"); ?></h3></div>


    <div class="mt-5">
        <table>
            <thead>
                <th class="col-1"></th>
                <th class="col-3"><?php echo Text::_("STATUS"); ?></th>
                <th class="col-3"><?php echo Text::_("MARKS"); ?></th>
                <th class="col-7"><?php echo Text::_("FEEDBACK"); ?></th>
            </thead>

            <tbody>
                <?php foreach ($this->items as $i => $row) : ?>
                    <tr>
                        <?php if($row->isCorrect): ?>
                            <td class="icon-checkmark-circle"></td>
                            <td><?php echo Text::_("CORRECT"); ?></td>
                            <td><?php echo $row->markValue . '/' . $row->markValue; ?></td>
                        
                        <?php else: ?>
                            <td class="icon-delete"></td>
                            <td><?php echo Text::_("INCORRECT"); ?></td>
                            <td><?php echo '0' . '/'. $row->markValue; ?></td>
                            <td><?php echo $row->feedback; ?></td>                  
                        <?php endif; ?>
                    </tr>           
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>


    <!-- ====== BODY =========== -->
    <div class="row mt-5">
        <div class="col-2"><?php echo Text::_("TOTAL SCORE: "); ?></div>
        <div class="col-2"><?php echo $this->marks . ' / ' . $this->total; ?></div>
    </div> 
    
    <div class="row mt-5">
        <a class="btn btn-outline-primary col-2" 
        href="<?php echo Uri::getInstance()->current() . Route::_('?&task=Display.quizScoresDisplay') ?>">
        <?php echo Text::_("VIEW QUIZ SCORES"); ?></a>
    </div> 

</div>



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

$document = Factory::getDocument();
$document->addScript("media/com_myquiz/js/scoresView.js");
$document->addStyleSheet("media/com_myquiz/css/style.css");

?>

<!-- SCORES VIEW -->

<!-- Header -->
<div class="row">
	<div class="col">
        <a class="btn" href="<?php echo Uri::getInstance()->current(); ?>">Back</a>
    </div>
	<div class="col-8 text-center">
		<h3>Quiz Scores</h3>
	</div>
	<div class="col"></div>
</div>

<hr/>

<div class="row justify-content-center">
    <div id="attempts" class="col-8">
        <?php if (!$this->items) : ?>
            <h2 class="text-center mt-5"><?php echo "No scores to display"; ?></h2>
        <?php else : ?>
            <?php foreach ($this->items as $row) : ?>
                <div id="<?php echo $row->quizId . '-' . $row->attemptNumber; ?>" class="row p-2 mb-3">
                    <div class="col">
                        <div id="title"><?php echo $row->title; ?> - Attempt <?php echo $row->attemptNumber; ?></div>
                        <div>Score: <?php echo $row->score . " / " . $row->maxScore ?></div>
                    </div>
                    <div class="col-auto">
                        <div>Date: <?php echo $row->date; ?></div> 
                        <div>Duration: <?php echo $row->duration; ?></div>
                    </div>
                </div>
            <?php endforeach; ?>
        <?php endif; ?>
    </div>
</div>

<div>
    <table id="quizzes" class="table table-borderless">
        <tfoot>
            <tr>
                <td class="d-flex justify-content-center p-2">
                    <?php echo $this->pagination->getListFooter(); ?>
                </td>
            </tr>
        </tfoot>
    </table>   
</div>

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
$document->addScript("media/com_myquiz/js/summaryView.js");
$document->addStyleSheet("media/com_myquiz/css/style.css");

?>

<!-- SUMMARY VIEW -->

<!-- Header -->
<div class="row">
	<div class="col">
        <a class="btn" href="<?php echo Uri::getInstance()->current() 
            . ($this->justFinished ? '?task=Display' : '?task=Display.scores');
        ?>">Back</a>
	</div>
	<div class="col-8 text-center">
		<h3>Summary: <?php echo $this->quiz->title; ?></h3>
	</div>
	<div class="col">
        <?php if ($this->justFinished): ?>
            <a 
                class="btn float-end"
                href="<?php echo Uri::getInstance()->current() . '?task=Display.scores'; ?>"
            >View All Scores</a>
        <?php endif; ?>
    </div>
</div>

<hr />

<div class="row justify-content-center">
    <div id="questions" class="col-8">
        <h4 class="text-end mb-4">Score: <?php echo $this->userScore . ' / ' . $this->maxScore; ?></h4>
        <?php foreach ($this->items as $row): ?>
            <div class="card mb-4">
                <div class="card-body">
                    <div class="row">
                        <div class="col">
                            <div class="row">
                                <div class="col">
                                    <h5><?php echo $row->number + 1 . ". " . $row->description; ?></h5>
                                </div>

                                <div class="col-auto">
                                    <h6><?php echo $row->userScore . ' / ' . $row->maxScore; ?></h6>
                                </div>
                            </div>

                            <hr class="my-1"/>

                            <div class="row">
                                <?php foreach($row->answers as $i => $answer): ?>
                                    <p>
                                        <?php if ($answer->markValue > 0): ?>
                                            <i class="icon-checkmark-circle<?php if ($answer->selected) echo " correct"; ?>"></i>
                                        <?php else : ?>
                                            <i class="icon-cancel-circle<?php if ($answer->selected) echo " incorrect"; ?>"></i>
                                        <?php endif ?>
                                        <?php echo $answer->description . ' (' . $answer->markValue . ')'; ?>
                                    </p>
                                <?php endforeach; ?>
                            </div>
                            
                            <hr class="my-1"/>

                            <div class="row">
                                <p class="card-text"><?php echo $row->feedback; ?></p>
                            </div>
                        </div>   
                    </div>
                </div>
            </div>
        <?php endforeach; ?>
    </div>
</div>

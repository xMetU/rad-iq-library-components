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
$document->addStyleSheet("media/com_myquiz/css/style.css");

?>

<!-- ====== SUMMARY VIEW ===== -->


<!-- Header -->
<div class="row">
	<div class="col">
        <a class="btn" href="<?php echo Uri::getInstance()->current() ?>">Back</a>
	</div>
	<div class="col-8 text-center">
		<h3>Summary</h3>
	</div>
	<div class="col">
        <a 
            class="btn float-end"
            href="<?php echo Uri::getInstance()->current() . '?task=Display.quizScoresDisplay'; ?>"
        >View All Scores</a>
    </div>
</div>

<hr />

<div class="row justify-content-center">
    <div id="questions" class="col-8">
        <h5 class="text-end">Score: <?php echo $this->marks . ' / ' . $this->total; ?></h5>
        <?php foreach ($this->items as $row) : ?>
            <div class="card mt-4">
                <div class="card-body">
                    <div class="row">
                        <div class="col">
                            <h5 class="card-title"><?php echo "Question " . $row->questionNumber . ": " . $row->questionDescription; ?></h5>

                            <?php if ($row->isCorrect): ?>
                                <i id="correct" class="icon-checkmark-circle"></i><?php echo " Correct" ?>
                            <?php else : ?>
                                <i id="incorrect" class="icon-cancel-circle"></i><?php echo " Incorrect" ?>
                            <?php endif ?>
                            <p class="card-text"><?php echo $row->feedback; ?></p>
                        </div>   

                        <div class="col-2">
                            <?php if ($row->isCorrect): ?>
                                <h5><?php echo "Marks: " . $row->markValue; ?></h5>
                            <?php else : ?> 
                                <h5><?php echo "Marks: 0"; ?></h5>
                            <?php endif ?>                                            
                        </div>
                    </div>
                </div>
            </div>
        <?php endforeach; ?>
    </div>
</div>

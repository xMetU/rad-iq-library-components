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
                    <h5 class="card-title"><?php echo "Question " . $row->questionNumber . ": " . $row->questionDescription; ?></h5>
                    
                    <div><?php echo $row->isCorrect ? "Correct" : "Incorrect"; ?></div>
                    <p class="card-text"><?php echo $row->feedback; ?></p>
                </div>
            </div>
        <?php endforeach; ?>
    </div>
</div>

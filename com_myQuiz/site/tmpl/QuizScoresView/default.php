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
        <?php foreach ($this->items as $row) : ?>
            <div class="row p-2 mt-4">
                <div class="col text-truncate"><?php echo $row->title; ?></div>
                <div class="col-2"><?php echo "Attempt " . $row->attemptNumber; ?></div>
                <div class="col-2 text-center"><?php echo "Score: " . $row->userScore . " / " . $row->quizTotalMarks ?></div>
            </div>
        <?php endforeach; ?>
    </div>
</div>

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
$document->addScript("media/com_myquiz/js/quizView.js");
$document->addStyleSheet("media/com_myquiz/css/style.css");

?>

<!-- QUIZ VIEW -->

<!-- Header -->
<div class="row">
	<div class="col">
		<a class="btn" href="<?php echo Uri::getInstance()->current(); ?>">Exit</a>
	</div>
	<div class="col-8 text-center">
		<h3><?php echo $this->quiz->title; ?></h3>
	</div>
	<div class="col">
        <button id="FINISH" class="btn float-end navigator">Finish</button>
    </div>
</div>

<hr/>

<!-- Previous Button | Questions | Next Button -->
<?php if ($this->questions): ?>
    <div class="row ">
        <div class="col">
            <?php if ($this->question->number > 0): ?>
                <button
                    id="<?php echo $this->questions[$this->question->number - 1]->id; ?>"
                    class="btn float-end navigator"
                >Previous</button>
            <?php else: ?>
                <button class="btn float-end" disabled>Previous</button>
            <?php endif; ?>
        </div>

        <div class="col-auto text-center">
            <?php foreach ($this->questions as $i => $row): ?>
                <?php if ($row->number != $this->question->number): ?>
                    <button
                        id="<?php echo $row->id; ?>"
                        class="btn navigator<?php if ($row->answered) echo " answered"; ?>"
                    ><?php echo $row->number + 1; ?></button>
                <?php else: ?>
                    <button class="btn selected<?php if ($row->answered) echo " answered"; ?>">
                        <?php echo $row->number + 1; ?>
                    </button>
                <?php endif; ?>
                
            <?php endforeach; ?>
        </div>

        <div class="col">
            <?php if ($this->question->number < count($this->questions)-1): ?>
                <button
                    id="<?php echo $this->questions[$this->question->number + 1]->id; ?>"
                    class="btn navigator"
                >Next</button>
            <?php else: ?>
                <button class="btn" disabled>Next</button>
            <?php endif; ?>
        </div>
    </div>
<?php else: ?>
    <p class="text-center">No questions have been assigned to this quiz.</p>
<?php endif; ?>

<hr/>

<!-- Question and Answers -->
<div class="row">
    <div class="col position-relative">
        <button id="open-button" class="btn position-absolute m-2">View</button>
        <img src="<?php echo $this->quiz->imageUrl; ?>" />
    </div>
    
    <div class="col">
        <?php if ($this->answers): ?>
            <form
                action="<?php echo Uri::getInstance()->current() . '?task=Quiz.saveAnswer'; ?>"
                method="post"
                id="adminForm"
                name="adminForm"
                enctype="multipart/form-data"
            >
                <input type="hidden" name="quizId" value="<?php echo $this->quiz->id; ?>"/>
                <input type="hidden" name="questionId" value="<?php echo $this->question->id; ?>"/>
                <input type="hidden" name="nextQuestionId"/>
                
                <h5 id="<?php echo $this->question->id; ?>"><?php echo $this->question->number + 1 . '. ' . $this->question->description; ?></h5>

                <?php foreach ($this->answers as $i => $row) : ?>
                    <div class="row mt-3">
                        <div class="col-auto">
                            <input 
                                type="<?php echo $this->isRadio ? "radio" : "checkbox"; ?>"
                                name=<?php echo "answerId[" . ($this->isRadio ? 0 : $i) . "]"; ?>
                                value="<?php echo $row->id; ?>"
                                <?php if ($this->userAnswers && in_array($row->id, $this->userAnswers)) echo "checked"; ?>
                            />
                        </div>
                        <div class="col"><?php echo $row->description; ?></div>
                    </div>
                <?php endforeach; ?>
            </form>
        <?php else: ?>
            <p class="mt-5 text-center">No answers have been assigned to this question.</p>
        <?php endif; ?>
    </div>    
</div>

<!-- Focused viewer -->
<div id="focused-img-view" class="overlay-background d-none">
    <div class="h-100 text-center">
        <img id="focused-img" class="h-100" src="<?php echo $this->quiz->imageUrl; ?>"/>
    </div>
    <div id="controls-container" class="row fixed-top m-2">
        <div class="col"></div>

        <div id="controls" class="col-auto rounded">
            <div class="row">
                <div class="col rounded px-4 text-center">
                    <label for="brightness-input">Brightness</label>
                    <input type="range" min="50" max="250" id="brightness-input" class="form-range"/>
                </div>
                <div class="col-auto rounded mx-2 text-center">
                    Scroll to <br/> Zoom
                </div>
                <div class="col rounded px-4 text-center">
                    <label for="contrast-input">Contrast</label>
                    <input type="range" min="50" max="450" id="contrast-input" class="form-range"/>
                </div>
            </div>
        </div>

        <div class="col">
            <button id="exit-button" class="btn float-end rounded-circle"><i class="icon-times"></i></button>
        </div>
    </div>
</div>
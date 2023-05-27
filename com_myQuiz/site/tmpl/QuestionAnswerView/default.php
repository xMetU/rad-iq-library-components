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
		<h3><?php echo $this->title; ?></h3>
	</div>
	<div class="col">
        <button id="finish-button" class="btn float-end">Finish</button>
    </div>
</div>

<hr/>

<!-- Previous Button | Questions | Next Button -->
<div class="row">
    <div class="col">
        <button
            id="previous-button"
            class="btn float-end"
            <?php if ($this->questionNumber == 1) echo "disabled"; ?>
        >Previous</button>
    </div>
    <div class="col-auto">
        <?php foreach ($this->questions as $question) : ?>
            <?php if ($this->questionNumber == $question->questionNumber) : ?>
                <button class="btn" disabled><?php echo $question->questionNumber; ?></button>
            <?php else : ?>
                <a 
                    class="btn"
                    href="<?php
                        echo Uri::getInstance()->current() . '?task=Display.questionDisplay'
                        . '&id=' . $question->id
                        . '&question='. $question->questionNumber
                        . '&count='. $this->count;
                    ?>"
                ><?php echo $question->questionNumber; ?></a>
            <?php endif ?>
        <?php endforeach; ?>
    </div>
    <div class="col">
        <button
            id="next-button"
            class="btn"
            <?php if ($this->questionNumber == $this->count) echo "disabled"; ?>
        >Next</button>
    </div>
</div>

<hr/>

<!-- Question and Answers -->
<div class="row">
    <div class="col-5">
        <img id="<?php echo $this->imageId; ?>" src="<?php echo $this->imageUrl; ?>" />
    </div>
    <div class="col-7">
        <form action="" method="post" id="adminForm" name="adminForm" enctype="multipart/form-data">
            <input type="hidden" name="questionNumber" value="<?php echo $this->questionNumber ?>"/>
            <input type="hidden" name="quizId" value="<?php echo $this->quizId ?>"/>
            <input type="hidden" name="count" value="<?php echo $this->count ?>"/>
            
            <h5><?php echo $this->question; ?></h5>

            <?php foreach ($this->items as $row) : ?>
                <div class="row mt-3">
                    <div class="col-auto">
                        <input type="radio" name="selectedAnswer" value="<?php echo $row->answerNumber ?>"/>
                    </div>
                    <div class="col"><?php echo $row->answerDescription ?></div>
                </div>
            <?php endforeach; ?>
        </form>
    </div>    
</div>

<script>
    // TODO: Fix answers not being selected
    window.onload = function() {
        checkAnswered();

        const previousButton = document.getElementById("previous-button");
        const nextButton = document.getElementById("next-button");
        const finishButton = document.getElementById("finish-button");
        const form = document.getElementById("adminForm");

        previousButton.onclick = () => {
            submitForm("prevQuestion");
        }

        nextButton.onclick = () => {
            submitForm("nextQuestion");
        }

        finishButton.onclick = () => {
            submitForm("saveData");
        }

        function checkAnswered() {
            let button = Array.from(document.getElementsByName("selectedAnswer"));
            
            if ("<?php echo $this->answerNumber; ?>") {
                for(let i = 0; i < button.length; i++) {
                    if(button[i].value == "<?php echo $this->answerNumber; ?>") {
                        console.log("answered");
                        button[i].checked = true;
                    }
                }
            }
        }

        function submitForm(action) {
            form.action = `?task=Answer.${action}`;
            form.submit();
        }
    };
</script>


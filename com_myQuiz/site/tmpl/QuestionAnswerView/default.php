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


foreach ($this->items as $i => $row){
    $question = $row->questionDescription;
    $questionNumber = $row->questionNumber;
    $quizId = $row->quizId;
    $title = $row->title;
}

$count = count($this->questions);

if($questionNumber < $count){
    $label = Text::_('NEXT'); 
}
else {
    $label = Text::_('FINISH'); 
}

?>


<!-- ====== QUESTION DISPLAY WITH ANSWER LIST =========== -->

<div class="mt-5">

    <!-- ====== TITLES =========== -->
    <div class="row">
        <table>
            <tbody>
                <tr>
                    <td><h3><?php echo $quizId . '. '; ?></h3></td>
                    <td><h3><?php echo $title; ?></h3></td>
                </tr>
            </tbody>
        </table>
    </div>


    <!-- ====== BODY =========== -->
    <div class="row mt-5">

        <!-- ====== Question List =========== -->
        <div class="col-3">
            <?php foreach ($this->questions as $q => $row) : ?>
                <div class="row mt-5 col-5">
                    <a class="btn btn-outline-primary" href="<?php echo Uri::getInstance()->current() . Route::_('?&id=' . $row->id . '&question='. $row->questionNumber . '&count='. $count . '&task=Display.questionDisplay') ?>"><?php echo Text::_("Question ") . $row->questionNumber; ?></a>
                </div>
            <?php endforeach; ?> 
        </div>


        <!-- ====== ANSWERS =========== -->
        <div class="col-7">
            <form action="" method="post" id="adminForm" name="adminForm" enctype="multipart/form-data">
                
                <!--===== Question Part ====== -->
                <div><h3><?php echo 'Q' . $questionNumber . '. ' . $question; ?></h3></div>

                <!--===== Answer Part ====== -->
                <div class="mt-5 mb-5">
                    <?php foreach ($this->items as $i => $row) : ?>
                        <div class="row mt-3">
                            <div class="col-1">
                                <input type="radio" name="selectedAnswer" value="<?php echo $row->answerNumber ?>"/>
                            </div>
                            <div class="col-1"><?php echo $row->answerNumber . '.' ?></div>
                            <div class="col-10"><?php echo $row->answerDescription ?></div>
                        </div>
                    <?php endforeach; ?>
                </div>
                
                <!--========= [PREV, NEXT] BUTTONS =======================-->
                <div class="row mt-5">            
                    
                    <input type="hidden" name="questionNumber" value="<?php echo $questionNumber ?>"/>
                    <input type="hidden" name="quizId" value="<?php echo $quizId ?>"/>
                    <input type="hidden" name="count" value="<?php echo $count ?>"/>
                    
                    <div class="col-2">  
                        <?php if($questionNumber > 1): ?> 
                            <input type="button" class="btn btn-primary" id="prev" value="<?php echo Text::_(' PREV'); ?>"/>                            
                        <?php endif ?>
                    </div>
                    <div class="col-2">  
                        <input type="button" class="btn btn-primary" id="next" value="<?php echo $label; ?>" />
                    </div>                      
                </div>
            </form>
        </div>

        
        <div class="col-2">		
            <?php foreach ($this->image as $im => $row) : ?>						
                <img id="<?php echo $row->imageId; ?>" src="<?php echo $row->imageUrl; ?>" style="width:250px;height:280px;"/>
            <?php endforeach; ?>
        </div>
        

    </div>            
</div>


<script>

    window.onload = function() {

        let next = document.getElementById("next");
        let prev = document.getElementById("prev");
        
        next.addEventListener("click", function() {  
            var action = 'nextQuestion';
            changeQuestion(action)
        });

        if(prev) {
            prev.addEventListener("click", function () {       
            var action = 'prevQuestion';
            changeQuestion(action)
            });
        }


        function changeQuestion(formAction){
            let form = document.getElementById("adminForm");

            form.action = '<?php echo Uri::getInstance()->current() . '?&task=Answer.' ; ?>' + formAction;
            form.submit();
        }
    };
</script>


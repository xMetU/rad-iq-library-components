<?php

/**
 * @package     Joomla.Administrator
 * @subpackage  com_myQuiz
 */

 // No direct access to this file
defined('_JEXEC') or die('Restricted Access');

use Joomla\CMS\Language\Text;
use Joomla\CMS\Uri\Uri;
use Joomla\CMS\Router\Route;
use Joomla\CMS\Factory;

$document = Factory::getDocument();
$document->addStyleSheet("media/com_myquiz/css/style.css");

?>

<form 
    action="<?php echo Uri::getInstance()->current() . '?&option=com_myQuiz&task=Display.resetAttempts'; ?>"
    method="post"
    enctype="multipart/form-data"
>
    <input type="hidden" name="userId" value="<?php echo $this->userId; ?>"/>
    <input type="hidden" name="quizId" value="<?php echo $this->quizId; ?>"/>

    <div class="d-flex bg-dark py-5">
        <div class="m-auto">
            <div class="row">
                <h2 class="text-center text-white">Are you sure you want to reset this users attempts?</h2>
                <h3 class="text-center text-white">All of their previous attempts will be erased.</br>This action cannot be undone.</h3>
            </div>

            <div class="row mt-5 m-auto text-center">
                <div class="col">
                    <button type="submit" class="btn btn-danger">Yes</button>
                </div>

                <div class="col">
                    <a class="btn btn-secondary" href="<?php echo Uri::getInstance()->current() 
                        . '?&option=com_myQuiz&task=Display.display'; ?>"
                    >No</a>
                </div>
            </div>
        </div>
    </div>    
</form>









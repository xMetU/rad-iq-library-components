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

<h2 class="text-center bg-primary text-white">Quiz Admin</h2>

<div class="col-4 my-3">
    <form
        action="<?php echo Uri::getInstance()->current() . '?&option=com_myQuiz&task=Display.display'; ?>"
        method="post"
        enctype="multipart/form-data"
    >
        <div class="input-group">
            <input
                name="search"
                id="text"
                class="form-control"
                placeholder="Search..."
                value="<?php if ($this->search) echo $this->search; ?>"
            />
            <button type="submit" class="btn btn-secondary"><i class="icon-search"></i></button>
        </div>
    </form>
</div>

<div>
    <table class="table table-borderless">
        <thead>
            <tr>
                <th>User ID</th>
                <th>Username</th>
                <th>Name</th>
                <th>Quiz</th>
                <th>Attempts Remaining</th>
                <th></th>
            </tr>
            
        </thead>

        <tfoot>
            <tr>
                <td class="bg-transparent">
                    <?php echo $this->pagination->getListFooter(); ?>
                </td>
            </tr>
        </tfoot>

        <tbody>
            <?php if($this->items): ?>
                <?php foreach($this->items as $item): ?>
                    <form 
                        action="<?php echo Uri::getInstance()->current() . '?&option=com_myQuiz&task=Display.resetAttempts'; ?>"
                        method="post"
                        enctype="multipart/form-data"
                    >
                        <tr>
                            <input type="hidden" name="userId" value="<?php echo $item->userId; ?>"/>
                            <input type="hidden" name="quizId" value="<?php echo $item->quizId; ?>"/>

                            <td><?php echo $item->userId; ?></td>
                            <td><?php echo $item->username; ?></td>
                            <td><?php echo $item->name; ?></td>
                            <td><?php echo $item->title; ?></td>
                            <td><?php echo $item->attemptsAllowed - $item->lastAttempt . ' / ' . $item->attemptsAllowed; ?></td>
                            <td class="w-auto">
                                <div>
                                    <a class="btn btn-secondary" href="<?php echo Uri::getInstance()->current() 
                                        . '?&option=com_myQuiz&task=Display.attemptView&userId=' . $item->userId . '&quizId=' . $item->quizId; ?>"
                                    >
                                        Reset Attempts
                                    </a>
                                </div>
                            </td>
                        </tr>
                    </form>
                <?php endforeach; ?>
            <?php endif; ?>    
        </tbody>
    </table>
</div>

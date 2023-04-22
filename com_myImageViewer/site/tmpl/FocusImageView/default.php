<?php
/**
 * @package     Joomla.Administrator
 * @subpackage  com_myImageViewer
 *
 */

 // No direct access to this file
defined('_JEXEC') or die('Restricted Access');

use Joomla\CMS\Language\Text;
use Joomla\CMS\HTML\HTMLHelper;
use Joomla\CMS\Factory;
use Joomla\CMS\Uri\Uri;
use Joomla\CMS\Router\Route;

?>


<!-- ====== FOCUS IMAGE =========== -->

<div class="mt-5">

    <!-- Back Button -->
    <div class="row">
        <div class="col-3">
            <a class="btn btn-outline-primary" href="<?php echo Uri::getInstance()->current() . '?&task=Display.display' ?>">Back</a>
        </div>
    </div>

    <!-- Main -->
    <div class="row mt-5">

        <!-- Image -->
        <div class="col-7">
            <img id="<?php echo $this->item->id; ?>" src="<?php echo $this->item->url; ?>"/>
        </div>

        <!-- Text -->
        <div class="col-5">
            <div class="row mt-2">
                <div class="col-6 text-center"><?php echo Text::_("Name: ")?></div>
                <div class="col-6"><?php echo $this->item->name; ?></div>
            </div>

            <div class="row mt-2">
                <div class="col-6 text-center"><?php echo Text::_("Category: ") ?></div>
                <div class="col-6"><?php echo $this->item->category; ?></div>
            </div>

            <div class="row mt-2">
                <div class="col-6 text-center"><?php echo Text::_("Description: ") ?></div>
                <div class="col-6"><?php echo $this->item->description; ?></div>
            </div>
        </div>
    </div>
    
</div>


<?php

namespace Kieran\Component\MyQuiz\Site\View\ScoresView;

defined('_JEXEC') or die;

use Joomla\CMS\MVC\View\HtmlView as BaseHtmlView;
use Joomla\CMS\Factory;
use Joomla\CMS\Date\Date;

/**
 * @package     Joomla.Site
 * @subpackage  com_myQuiz
 *
 */

class HtmlView extends BaseHtmlView {
    
    public function display($template = null) {

        $this->items = $this->get('Items');
        foreach ($this->items as $item) {
            $start = new Date($item->startTime);
            $finish = new Date($item->finishTime);
            $duration = $start->diff($finish);

            $item->date = $start->format('d-m-Y H:i');
            $item->duration = $duration->format('%H:%i:%s');
        }
        $this->pagination = $this->get('Pagination');

        // Call the parent display to display the layout file
        parent::display($template);
    }

}
<?php

namespace Kieran\Component\MyQuiz\Site\View\AllQuizView;

defined('_JEXEC') or die;

use Joomla\CMS\MVC\View\HtmlView as BaseHtmlView;


/**
 * @package     Joomla.Site
 * @subpackage  com_myQuiz
 *
 */

class HtmlView extends BaseHtmlView {
    

    /**
     * Display the view
     *
     * @param   string  $template  The name of the layout file to parse.
     * @return  void
     */
    public function display($template = null) {

        $this->items = $this->get('Items');
        $this->categories = $this->get('Items', 'ButtonCategories');
        $this->pagination = $this->get('Pagination');


        // Call the parent display to display the layout file
        parent::display($template);
    }

}
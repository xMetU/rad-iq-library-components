<?php

namespace Kieran\Component\MyImageViewer\Site\View\ImageView;

defined('_JEXEC') or die;

use Joomla\CMS\MVC\View\HtmlView as BaseHtmlView;
use Joomla\CMS\Factory;


/**
 * @package     Joomla.Site
 * @subpackage  com_myImageViewer
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


        $this->buttonCategories = $this->get('Items', 'ButtonCategories');
        $this->items = $this->get('Items');
        

        $this->pagination = $this->get('Pagination');


        // Call the parent display to display the layout file
        parent::display($template);
    }

}
<?php

namespace Kieran\Component\MyImageViewer\Administrator\Controller;

defined('_JEXEC') or die;

use Joomla\CMS\MVC\Controller\BaseController;


/**
 * @package     Joomla.Administrator
 * @subpackage  com_myImageViewer
 */
class DisplayController extends BaseController {
    

    protected $default_view = 'myImageViewerView';

    
    public function display($cachable = false, $urlparams = array()) {

        echo "this is a display method in Controller display()";
        
        return parent::display($cachable, $urlparams);
    }
    
}
<?php

namespace Kieran\Component\MyQuiz\Site\Helper;

defined('_JEXEC') or die;

use Joomla\CMS\Helper\UserGroupsHelper;
use Joomla\CMS\Factory;

/**
 * @package     Joomla.Site
 * @subpackage  com_myQuiz
 */


abstract class CheckGroup {
    

    public static function isGroup($groupName){
        $userGroups = Factory::getUser()->groups;

        // Find the groupId for the groupName
        foreach (UserGroupsHelper::getInstance()->getAll() as $group) {
            if ($group->title == $groupName) {
                $id = $group->id;
            }
        }

        foreach($userGroups as $userGroup) {
            if($userGroup == $id) {
                return true;
            }
        }
    }

}
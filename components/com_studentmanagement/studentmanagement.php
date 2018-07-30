<?php
defined('_JEXEC') or die('Access Deny');
jimport('joomla.application.component.controller');
$controller=JController::getInstance('StudentManagement');
$controller->execute(JRequest::getcmd('task'));
$controller->redirect();
<?php
/**
 * Copyright 2010 Monotype Imaging Inc.  
 * This program is distributed under the terms of the GNU General Public License
 */
 
/**
 * @Components    Fonts.com Webfonts
 * components/com_webfonts/webfonts.php
 * @license    GPL
*/

//No direct access
defined('_JEXEC') or die('Restricted Access');

// Require the base controller
require_once( JPATH_COMPONENT.DS.'controller.php' );
// Require the base controller
require_once( JPATH_COMPONENT.DS.'libraries'.DS.'includes.php' );
require_once( JPATH_COMPONENT.DS.'libraries'.DS.'wfs_pagination.php' );
require_once( JPATH_COMPONENT.DS.'libraries'.DS.'json.class.php' );
require_once( JPATH_COMPONENT.DS.'libraries'.DS.'wfsapi.class.php' );
//Adding stylesheet in aadmin area
JHTML::_('stylesheet', 'webfonts.css', 'administrator/components/com_webfonts/assets/css/');


// Require specific controller if requested
if($controller = JRequest::getWord('controller')) {
    $path = JPATH_COMPONENT.DS.'controllers'.DS.$controller.'.php';
    if (file_exists($path)) {
        require_once $path;
    } else {
        $controller = '';
    }
}
 
// Create the controller
$classname    = 'WebfontsBaseController'.$controller;
$controller   = new $classname( ); 

// Perform the Request task
$controller->execute( JRequest::getWord( 'task' ) );
 
// Redirect if set by the controller
$controller->redirect();
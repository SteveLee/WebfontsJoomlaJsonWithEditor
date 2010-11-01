<?php
/**
 * Copyright 2010 Monotype Imaging Inc.  
 * This program is distributed under the terms of the GNU General Public License
 */
 
/**
 * Hello Controller for Hello World Component
 * 
 * @package    Joomla.Tutorials
 * @subpackage Components
 * @link http://docs.joomla.org/Developing_a_Model-View-Controller_Component_-_Part_4
 * @license		GNU/GPL
 */

// No direct access
defined( '_JEXEC' ) or die( 'Restricted access' );

class WebfontsBaseControllerWebfontsLogin extends WebfontsBaseController
{
	/**
	 * constructor (registers additional tasks to methods)
	 * @return void
	 */
	function __construct()
	{
		
		parent::__construct();
	}
	
	 function display()
    {
		JRequest::setVar( 'view', 'webfontslogin' );
		parent::display();
	}
	/*
	*project home page
	*/
	function project_list(){
		$this->setRedirect('index.php?option=com_webfonts&controller=webfontsproject');
	}
	
	/*
	*project home page
	*/
	function login_page(){
		$this->setRedirect('index.php?option=com_webfonts&controller=webfontslogin');
	}
	
	/**
	 * save a record (and redirect to main page)
	 * @return void
	 */
	function save()
	{
		$model = $this->getModel('webfontslogin');
		
		if ($model->store($post)) {
			$msg = JText::_( 'Login Succesfully!' );
			$link = 'index.php?option=com_webfonts&controller=webfontsproject';
			$this->setRedirect($link, $msg);
		} else {
			$msg = JText::_( 'Invalid Authentication' );
			$link = 'index.php?option=com_webfonts&controller=webfontslogin';
			$this->setRedirect($link, $msg,'error');
		}

		
	}

}
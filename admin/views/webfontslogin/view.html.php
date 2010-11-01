<?php
/**
 * Copyright 2010 Monotype Imaging Inc.  
 * This program is distributed under the terms of the GNU General Public License
 */
 
/**
 * Webfonts View for fonts.com webfonts Component
 * 
 * @Components    Fonts.com Webfonts
 * components/com_webfonts/webfonts.php
 * @license    GPL
 */

// No direct access
defined( '_JEXEC' ) or die( 'Restricted access' );
//Library class for view 
jimport( 'joomla.application.component.view' );


class WebfontsBaseViewWebfontsLogin extends JView
{
	/**
	 * display method of Webfonts view
	 * @return void
	 **/
	function display($tpl = null)
	{
		JToolBarHelper::custom( 'project_list', 'home.png', 'home.png', 'Home', false, false );
		JToolBarHelper::custom( 'login_page', 'account.png', 'account.png', 'My WFS Account', false, false );
		JToolBarHelper::title( JText::_( 'WFS Account' ), 'wfs_logo' );
		$params = &JComponentHelper::getParams('com_webfonts');
		$wfs_api_key =  $params->get( 'wfs_public_key' ).'--'.$params->get( 'wfs_private_key' );
		$this->assignRef('wfs_api_key', $wfs_api_key);
		$this->assignRef('wfs_pagination',  $params->get( 'wfs_pagination' ));
		
		parent::display($tpl);
	}
}
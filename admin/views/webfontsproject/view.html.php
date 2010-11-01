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


class WebfontsBaseViewWebfontsProject extends JView
{
	/**
	 * display method of Webfonts view
	 * @return void
	 **/
	function display($tpl = null)
	{
		JToolBarHelper::custom( 'project_list', 'home.png', 'home.png', 'Home', false, false );
		JToolBarHelper::custom( 'login_page', 'account.png', 'account.png', 'My WFS Account', false, false );
		JToolBarHelper::title( JText::_( 'My Project List' ), 'wfs_logo' );
        JToolBarHelper::deleteList();
        JToolBarHelper::publishList();
		JToolBarHelper::unpublishList();
		JToolBarHelper::custom( 'sync', 'sync.png', 'sync.png', 'Sync', false, false );
		


		 // Get data from the model
        $wfs_projects =& $this->get( 'Data');
        $this->assignRef( 'wfs_projects',  $wfs_projects );

		$wfs_details = getUnPass();
		//Fetching the json data from WFS
		$apiurl = "json/Projects/?wfspstart=0&wfsplimit=".PROJECT_LIMIT;
		$wfs_api = new Services_WFS($wfs_details[1],$wfs_details[2],$apiurl);
		$jsonUrl = $wfs_api->wfs_getInfo_post();
		$this->assignRef( 'wfs_import_projects',  $jsonUrl );
		$this->assignRef( 'user_id',  $wfs_details[0] );
		
		$pagination_project =& $this->get('Pagination');
		$this->assignRef('pagination_project', $pagination_project);

		parent::display($tpl);
	}
}
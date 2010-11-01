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


class WebfontsBaseViewWebfontsConfigure extends JView
{
	/**
	 * display method of Webfonts view
	 * @return void
	 **/
	function display($tpl = null)
	{
		JToolBarHelper::custom( 'project_list', 'home.png', 'home.png', 'Home', false, false );
		JToolBarHelper::custom( 'login_page', 'account.png', 'account.png', 'My WFS Account', false, false );
        JToolBarHelper::cancel();
		$layout = JRequest::getVar('layout'); 
		if($layout == "edit_domain_form"){
			JToolBarHelper::title( JText::_( 'Edit Domain' ), 'wfs_logo' );
		}else{
			JToolBarHelper::title( JText::_( 'Projects Details' ), 'wfs_logo' );
		}
		 // Get data from the model
        $wfs_projects =& $this->get( 'Data');
        $this->assignRef( 'wfs_projects',  $wfs_projects );
		if($layout == "edit_stylesheet"){
			 // Get data for selectors
			$wfs_selectors =& $this->get( 'SelectorsList');
			$this->assignRef( 'wfs_selectors',  $wfs_selectors[0] );
			$this->assignRef( 'wfs_selectors_pagination',  $wfs_selectors[1] );
		
			 // Get data for fonts 
      	 	 $wfs_fonts =& $this->get( 'Fonts');
       		 $this->assignRef( 'wfs_fonts',  $wfs_fonts );
			
			  // Get data for fonts 
      	 	 $wfs_editor_fonts =& $this->get( 'FontsEditor');
			 $this->assignRef( 'wfs_editor_fonts',  $wfs_editor_fonts );
			 
			 // Get data for joomla existing selectors
			$wfs_joomla_selectors =& $this->get('JoomlaSelectorsList');
			$this->assignRef('wfs_joomla_selectors', $wfs_joomla_selectors);
			$this->assignRef( 'wfs_current_selectors',  $wfs_selectors[2] );
		}
		if($layout == "edit_domain"){
			// Get domains from the model
			$wfs_domains =& $this->get( 'Domains');
			$this->assignRef( 'wfs_domains',  $wfs_domains[0] );
			$this->assignRef( 'wfs_domains_pagination',  $wfs_domains[1] );
		}
		if($layout == ""){
			$wfslookup =& $this->get( 'ModuleMenuAssignent' );
			$this->assignRef( 'wfs_lookup',  $wfslookup );
			
			$params = &JComponentHelper::getParams('com_webfonts');
			$wfs_user_type = $params->get( 'wfs_usertype' );
			$this->assignRef( 'wfs_user_type',  $wfs_user_type );
		}
		parent::display($tpl);
	}
}
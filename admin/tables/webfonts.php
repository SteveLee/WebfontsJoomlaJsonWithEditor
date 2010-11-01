<?php
/**
 * Copyright 2010 Monotype Imaging Inc.  
 * This program is distributed under the terms of the GNU General Public License
 */
 
/**
 * Webfonts table class for fonts.com webfonts Component
 * 
 * @Components    Fonts.com Webfonts
 * components/com_webfonts/webfonts.php
 * @license    GPL
 */

// No direct access
defined( '_JEXEC' ) or die( 'Restricted access' );


class TableWebfonts extends JTable
{
	/**
	 * Primary Key
	 *
	 * @var int
	 */
	var $wfs_configure_id = null;
	var $project_name = null;
	var $project_key = null;
	var $project_day = null;
	var $project_page_option = 0;
	var $project_pages = null;
	var $project_options = 0;
	var $wysiwyg_enabled = 0;
	var $user_id = null;
	var $user_type = 0;
	var $editor_select = 0;
	//var $updated_date = '0000-00-00 00:00:00';
	
	/**
	 * Constructor
	 *
	 * @param object Database connector object
	 */
	function TableWebfonts(& $db) {
		parent::__construct('#__wfs_configure', 'wfs_configure_id', $db);
	}
	
	
}
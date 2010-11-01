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


class TableWebfontsMenu extends JTable
{
	/**
	 * Primary Key
	 *
	 * @var int
	 */
	var $moduleid = null;
	var $menuid = null;
	/**
	 * Constructor
	 *
	 * @param object Database connector object
	 */
	function TableWebfontsMenu(& $db) {
		parent::__construct('#__modules_menu', 'moduleid', $db);
	}
}
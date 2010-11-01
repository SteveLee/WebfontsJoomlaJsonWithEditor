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


class TableWebfontsLogin extends JTable
{
	/**
	 * Primary Key
	 *
	 * @var int
	 */
	var $link = 'option=com_webfonts';
	var $params = null;
	
	/**
	 * Constructor
	 *
	 * @param object Database connector object
	 */
	function TableWebfontsLogin(& $db) {
		parent::__construct('#__components', 'link', $db);
	}
	
	function bind($array, $ignore = '')
	{
		if (key_exists( 'params', $array ) && is_array( $array['params'] ))
        {
                $registry = new JRegistry();
                $registry->loadArray($array['params']);
                $array['params'] = $registry->toString();
        }
        return parent::bind($array, $ignore);
	}

}
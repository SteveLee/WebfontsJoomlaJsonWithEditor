<?php
/**
 * Copyright 2010 Monotype Imaging Inc.  
 * This program is distributed under the terms of the GNU General Public License
 */
 
/**
 * @Components    Fonts.com Webfonts
 * components/com_webfonts/webfonts.php
 * Webfonts compontent admin controller
 * @license    GPL
*/

 
// No direct access
 
defined( '_JEXEC' ) or die( 'Restricted access' );
 
jimport('joomla.application.component.controller');

class WebfontsBaseController extends JController
{
    /**
     * Method to display the view
     *
     * @access    public
     */
    function display()
    {
		$document =& JFactory::getDocument();
		$js = "components/com_webfonts/assets/js/jquery-1.4.2.min.js";
		$document->addScript(JURI::base() . $js );
		$document->addScriptDeclaration ( 'jQuery.noConflict();' );
		$js = "components/com_webfonts/assets/js/webfonts.js";
		$document->addScript(JURI::base() . $js);
		/* $js = 'components/com_webfonts/libraries/tiny_mce/tiny_mce.js';
		$document->addScript(JURI::base() . $js);*/
		if(JRequest::getWord('controller')!=""){
			parent::display();
		}else{
			$model = $this->getModel('webfontslogin');
			if ($model->authenticate()) {
				$link = 'index.php?option=com_webfonts&controller=webfontsproject';
				$this->setRedirect($link);
			} else {
				$msg = JText::_( 'Invalid Authentication' );
				$link = 'index.php?option=com_webfonts&controller=webfontslogin';
				$this->setRedirect($link,$msg,'error');
			}
			
			
			}
    }
 
}

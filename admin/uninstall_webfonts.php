<?php
/**
 * Copyright 2010 Monotype Imaging Inc.  
 * This program is distributed under the terms of the GNU General Public License
 */
 
function com_uninstall(){
	jimport('joomla.filesystem.folder');
	jimport('joomla.filesystem.file');
	jimport('joomla.installer.installer');
	$installer = & JInstaller::getInstance();

	$source  = $installer->getPath('source');
	//uninstall the module
	if (JFolder::exists(dirname($installer->getPath('extension_site')).DS.'..'.DS.'modules'))
	{
		if(JFolder::delete(dirname($installer->getPath('extension_site')).DS.'..'.DS.'modules'.DS.'mod_webfonts'))
		{
			$module_result   = JText::_('Success');
		}else{
			$module_result = JText::_('Error');
		}
	}
	$module_result   = JText::_('Success');
	
	//uninstall the tinyce wfs plugin
	if (JFolder::exists(dirname($installer->getPath('extension_site')).DS.'..'.DS.'plugins'.DS.'editors','',true))
	{
		if(JFolder::delete(dirname($installer->getPath('extension_site')).DS.'..'.DS.'plugins'.DS.'editors'.DS.'tinymcewfs'))
		{
			unlink(dirname($installer->getPath('extension_site')).DS.'..'.DS.'plugins'.DS.'editors'.DS.'tinymcewfs.php');
			unlink(dirname($installer->getPath('extension_site')).DS.'..'.DS.'plugins'.DS.'editors'.DS.'tinymcewfs.xml');	
			$tinymce_result   = JText::_('Success');
		}else{
			$tinymce_result = JText::_('Error');
		}
	}
	$tinymce_result   = JText::_('Success');
	
	//uninstall the ckeditor wfs plugin
	if (JFolder::exists(dirname($installer->getPath('extension_site')).DS.'..'.DS.'plugins'.DS.'editors','',true))
	{
		if(JFolder::delete(dirname($installer->getPath('extension_site')).DS.'..'.DS.'plugins'.DS.'editors'.DS.'ckeditorwfs'))
		{
			unlink(dirname($installer->getPath('extension_site')).DS.'..'.DS.'plugins'.DS.'editors'.DS.'ckeditorwfs.php');
			unlink(dirname($installer->getPath('extension_site')).DS.'..'.DS.'plugins'.DS.'editors'.DS.'ckeditorwfs.xml');	
			$ckeditor_result   = JText::_('Success');
		}else{
			$ckeditor_result = JText::_('Error');
		}
	}
	$ckeditor_result   = JText::_('Success');
	
	$configFile =JPATH_CONFIGURATION.DS.'configuration.php';
	$configArray = file ($configFile);
		foreach($configArray as $key=>$val){
			preg_match('/editor/', $val, $matches, PREG_OFFSET_CAPTURE);
			if($matches[0]){
			$configArray[$key] = "var "."$"."editor = 'tinymce';
";							
			}
		}
	jimport('joomla.filesystem.path');
	// Try to make configuration.php writeable 
	if(!JPath::setPermissions($configFile, '0644')){
		JError::raiseNotice('SOME_ERROR_CODE', 'Could not make configuration.php writable');
		}
		$stringData = implode("",$configArray);
		$fh = fopen($configFile, 'w') or die("can't open file");
		fwrite($fh, $stringData);
	// Try to make configuration.php unwriteable
	if(!JPath::setPermissions($configFile, '0444')){
		JError::raiseNotice('SOME_ERROR_CODE', 'Could not make configuration.php unwritable');
		}
	fclose($fh);
	
	$response = 'Module: ' . $module_result . '<br>TinyMCE: ' . $tinymce_result . '<br> CKeditor: ' . $ckeditor_result;
	return $response;
	
}
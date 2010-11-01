<?php
/**
 * Copyright 2010 Monotype Imaging Inc.  
 * This program is distributed under the terms of the GNU General Public License
 */
 
defined('_JEXEC') or die ('Restricted access');
function com_install(){
	jimport('joomla.filesystem.folder');
	jimport('joomla.filesystem.file');
	jimport('joomla.installer.installer');
	$installer = & JInstaller::getInstance();

	$source  = $installer->getPath('source');
	$packages   = $source.DS.'packages';
	// Get wfsmodule package
	if(is_dir($packages)) {
		$wfsmodule   = JFolder::files($packages, 'mod_webfonts.zip', false, true);
	}
	if (! empty($wfsmodule)) {
		if (is_file($wfsmodule[0])) {
			$config = & JFactory::getConfig();
			$tmp = $config->getValue('config.tmp_path').DS.uniqid('install_').DS.basename($wfsmodule[0], '.zip');

			if (!JArchive::extract($wfsmodule[0], $tmp)) {
				$mainframe->enqueueMessage(JText::_('MODULE EXTRACT ERROR'), 'error');
			}else{
				$installer = & JInstaller::getInstance();
				$c_manifest   = & $installer->getManifest();
				$c_root     = & $c_manifest->document;
				$version    = & $c_root->getElementByPath('version');
				if(JFolder::copy($tmp,dirname($installer->getPath('extension_site')).DS.'..'.DS.'modules','',true))
				{
					//JFolder::delete($installer->getPath('extension_site'));
					if (wfsmoduleDBInstall())
					{
						$wfsmodule_result   = JText::_('Success');
					} else {
						$wfsmodule_result = JText::_('Error');
					}
				}else{
					 $wfsmodule_result = JText::_('Error');
				}
			}
		}
	}
  if (is_dir($tmp)) {
     @JFolder::delete($tmp);
  }
  // Get editor package for ckeditor
	if(is_dir($packages)) {
		$editor   = JFolder::files($packages, 'plg_ckeditorwfs.zip', false, true);
	}
	if (! empty($editor)) {
		if (is_file($editor[0])) {
			$config = & JFactory::getConfig();
			$tmp1 = $config->getValue('config.tmp_path').DS.uniqid('install_').DS.basename($editor[0], '.zip');

			if (!JArchive::extract($editor[0], $tmp1)) {
				$mainframe->enqueueMessage(JText::_('EDITOR EXTRACT ERROR'), 'error');
			}else{
				$installer = & JInstaller::getInstance();
				$c_manifest   = & $installer->getManifest();
				$c_root     = & $c_manifest->document;
				$version    = & $c_root->getElementByPath('version');
				if(JFolder::copy($tmp1,dirname($installer->getPath('extension_site')).DS.'..'.DS.'plugins'.DS.'editors','',true))
				{
					//JFolder::delete($installer->getPath('extension_site'));
					if (editorDBInstall())
					{
						$editor_result   = JText::_('Success');
					} else {
						$editor_result = JText::_('Error');
					}
				}else{
					 $editor_result = JText::_('Error');
				}
			}
		}
	}
  if (is_dir($tmp1)) {
     @JFolder::delete($tmp1);
  }
  
 // Get editor package for tinymce
	if(is_dir($packages)) {
		$editor_tiny   = JFolder::files($packages, 'plg_tinymcewfs.zip', false, true);
	}
	if (! empty($editor_tiny)) {
		if (is_file($editor_tiny[0])) {
			$config = & JFactory::getConfig();
			$tmp2 = $config->getValue('config.tmp_path').DS.uniqid('install_').DS.basename($editor_tiny[0], '.zip');

			if (!JArchive::extract($editor_tiny[0], $tmp2)) {
				$mainframe->enqueueMessage(JText::_('EDITOR EXTRACT ERROR'), 'error');
			}else{
				$installer = & JInstaller::getInstance();
				$c_manifest   = & $installer->getManifest();
				$c_root     = & $c_manifest->document;
				$version    = & $c_root->getElementByPath('version');
				if(JFolder::copy($tmp2,dirname($installer->getPath('extension_site')).DS.'..'.DS.'plugins'.DS.'editors','',true))
				{
					//JFolder::delete($installer->getPath('extension_site'));
					if (editorTinyDBInstall())
					{
						$editor_result_tiny   = JText::_('Success');
					} else {
						$editor_result_tiny = JText::_('Error');
					}
				}else{
					 $editor_result_tiny = JText::_('Error');
				}
			}
		}
	}
  if (is_dir($tmp2)) {
     @JFolder::delete($tmp2);
  }
  
   	$response = "Editor(Ckeditor): " . $editor_result . '<br> Editor(TinyMCE)::' . $editor_result_tiny. '<br> Module:' . $wfsmodule_result;
	return response;
}

function wfsmoduleDBInstall()
{
	// Get a database object
	$db =& JFactory::getDBO();
	// This must work, while only one element with this name must exist!!!
	$query = "SELECT `id`, `params` FROM #__modules WHERE `module` = '	mod_webfonts';";
	$db->setQuery($query);
	$row = $db->loadObject();
	// if empty options, set defaults
	if (empty($row)) 
	{
		$query = "INSERT INTO #__modules VALUES ( ".
				 "NULL, 'Fonts.com web fonts', '', '0', 'debug','0', '0000-00-00 00:00:00','1', 'mod_webfonts','0','0','1','','0','0','');"; 
	} else {
		$query = "UPDATE #__modules ".
				 "`title` = 'Fonts.com web fonts', ".
				 "`module` = 'mod_webfonts', ".
				 "`showtitle` = '1', ".
				 "`access` = 0, ".
				 "`published` = 1, ".
				 "`iscore` = 0, ".
				 "`client_id` = 0, ".
				 "`params = '".$row->params."' ) WHERE `id` = ".$row->id.";"; 
	}
	$db->setQuery($query);
	return $db->query();
}

function editorDBInstall()
{
	// Get a database object
	$db =& JFactory::getDBO();
	// This must work, while only one element with this name must exist!!!
	$query = "SELECT `id`, `params` FROM #__plugins WHERE `element` = 'ckeditorwfs';";
	$db->setQuery($query);
	$row = $db->loadObject();
	// if empty options, set defaults
	if (empty($row)) 
	{
		$query = "INSERT INTO #__plugins VALUES ( ".
				 "NULL, 'Editor - CKEditorwfs', 'ckeditorwfs', 'editors', ".
				 "0, 1, 1, 0, 0, 0, '0000-00-00 00:00:00', ".
				 "'language=en 
toolbar_frontEnd=Basic
toolbar=Full
Basic_ToolBar=Bold, Italic, -, NumberedList, BulletedList, -, Link, Unlink, -, Font, FontSize
Advanced_ToolBar=Source, -, Save, NewPage, Preview,- ,Templates, Cut, Copy, Paste, PasteText, PasteFromWord, - ,Print, SpellChecker, Scayt, Undo, Redo, -, Find, Replace, -, SelectAll, RemoveFormat,/, Bold ,Italic, Underline, Strike, -, Subscript, Superscript, NumberedList, BulletedList, -, Outdent, Indent, Blockquote, JustifyLeft, JustifyCenter, JustifyRight, JustifyBlock, BidiLtr, BidiRtl, Link, Unlink, Anchor, Image, Flash, Table, HorizontalRule, Smiley, SpecialChar, PageBreak, /, Styles, Format, Font, FontSize, TextColor, BGColor, Maximize, ShowBlocks, -, About
skin=kama 
Color=#D3D3D3
enterMode=1 
shiftEnterMode=2
style= 
template= 
css= 
templateCss=0 
ckfinder=0 
skinfm=light
usergroup_access=25' );"; 
	} else {
		$query = "UPDATE #__plugins ".
				 "`name` = 'Editor - CKEditorwfs', ".
				 "`element` = 'ckeditorwfs', ".
				 "`folder` = 'editors', ".
				 "`access` = 0, ".
				 "`published` = 1, ".
				 "`iscore` = 0, ".
				 "`client_id` = 0, ".
				 "`params = '".$row->params."' ) WHERE `id` = ".$row->id.";"; 
	}
	$db->setQuery($query);
	return $db->query();
}

function editorTinyDBInstall()
{
	// Get a database object
	$db =& JFactory::getDBO();
	// This must work, while only one element with this name must exist!!!
	$query = "SELECT `id`, `params` FROM #__plugins WHERE `element` = 'tinymcewfs';";
	$db->setQuery($query);
	$row = $db->loadObject();
	// if empty options, set defaults
	if (empty($row)) 
	{
		$query = "INSERT INTO #__plugins VALUES ( ".
				 "NULL, 'Editor - TinyMCEwfs', 'tinymcewfs', 'editors', ".
				 "0, 2, 1, 0, 0, 0, '0000-00-00 00:00:00', ".
				 "'mode=extended
skin=0
compressed=0
cleanup_startup=0
cleanup_save=2
entity_encoding=raw
lang_mode=0
lang_code=en
text_direction=ltr
content_css=1
content_css_custom=
relative_urls=1
newlines=0
invalid_elements=applet
extended_elements=
toolbar=top
toolbar_align=left
html_height=550
html_width=750
element_path=1
fonts=1
paste=1
searchreplace=1
insertdate=1
format_date=%Y-%m-%d
inserttime=1
format_time=%H:%M:%S
colors=1
table=1
smilies=1
media=1
hr=1
directionality=1
fullscreen=1
style=1
layer=1
xhtmlxtras=1
visualchars=1
nonbreaking=1
blockquote=1
template=0
advimage=1
advlink=1
autosave=1
contextmenu=1
inlinepopups=1
safari=1
custom_plugin=
custom_button=
' );"; 
	} else {
		$query = "UPDATE #__plugins ".
				 "`name` = 'Editor - TinyMCEwfs', ".
				 "`element` = 'tinymcewfs', ".
				 "`folder` = 'editors', ".
				 "`access` = 0, ".
				 "`published` = 1, ".
				 "`iscore` = 0, ".
				 "`client_id` = 0, ".
				 "`params = '".$row->params."' ) WHERE `id` = ".$row->id.";"; 
	}
	$db->setQuery($query);
	return $db->query();
}



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

class WebfontsBaseControllerWebfontsConfigure extends WebfontsBaseController
{
	/**
	 * constructor (registers additional tasks to methods)
	 * @return void
	 */
	function __construct()
	{
		parent::__construct();

	// Register Extra tasks
	$this->registerTask( 'save_editor' , 'save_editor_fonts' );
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
	 * display the edit form configure
	 * @return void
	 */
	function edit()
	{
		JRequest::setVar( 'view', 'webfontsconfigure' );
		$document =& JFactory::getDocument();
		
		$array = JRequest::getVar('cid',  0, '', 'array');
		$wfs_project_id = ((int)$array[0]);
		
		$model = $this->getModel('webfontsconfigure');
		$data= $model->getData();
		$key = $data->project_key;
		
		$js = FFJSAPIURI.$key.".js";
		$document->addScript($js);
		
		//adding fonts from wfs
		require_once( JPATH_SITE.DS.'administrator'.DS.'components'.DS.'com_webfonts'.DS.'libraries'.DS.'includes.php' );
		$params = &JComponentHelper::getParams('com_webfonts');
		$db =& JFactory::getDBO();
		$wfs_public_key = $params->get( 'wfs_public_key' );
		$wfs_private_key = $params->get( 'wfs_private_key' );
		
		//Fetching the json data from WFS
		$apiurl = "json/Fonts/?wfspid=".$key;
		$wfs_api = new Services_WFS($wfs_public_key,$wfs_private_key,$apiurl);
		$jsonUrl = $wfs_api->wfs_getInfo_post();
		$json = new Services_JSON(SERVICES_JSON_LOOSE_TYPE);
		$fontArray = $json->decode($jsonUrl);
		$fonts =$fontArray['Fonts']['Font'];
		$webfonts=array();
		$fontsList="";
		$fontsListTM="";
		$stylesheetcss="";
		if(!empty($fonts)){
			$is_multi = is_multi($fonts);
			if($is_multi == 1){
					$FontName= $fonts['FontName'];
					$FontCSSName= $fonts['FontCSSName'];
					$CDNKey= $fonts['CDNKey'];
					if($browser =="Internet Explorer (MSIE/Compatible)")
					{
					
					$TTF= $fonts['EOT'];
					$ext=".eot";
					}else{
					$TTF= $fonts['TTF'];
					$ext=".ttf";
					}
				$fontsListTM.= $FontName.'='.$FontCSSName.'; '; 
				$fontsList.= "\"".$FontName."/".$FontCSSName.";\" + ";
			}else{
				foreach($fonts as $font){
					$FontName= $font['FontName'];
					$FontCSSName= $font['FontCSSName'];
					$CDNKey= $font['CDNKey'];
					if($browser =="Internet Explorer (MSIE/Compatible)")
					{
					
					$TTF= $font['EOT'];
					$ext=".eot";
					}else{
					$TTF= $font['TTF'];
					$ext=".ttf";
					}
				$fontsListTM.= $FontName.'='.$FontCSSName.'; '; 
				$fontsList.= "\"".$FontName."/".$FontCSSName.";\" + ";
				}//end of foreach
			}//else for is_multi
		}//end of empty fonts
		/*TinyMCE sample editor script*/
		$default_font = "Andale Mono=andale mono,times;"."Arial=arial,helvetica,sans-serif;".
		"Arial Black=arial black,avant garde;".
		"Book Antiqua=book antiqua,palatino;".
		"Comic Sans MS=comic sans ms,sans-serif;".
		"Courier New=courier new,courier;".
		"Georgia=georgia,palatino;".
		"Helvetica=helvetica;".
		"Impact=impact,chicago;".
		"Symbol=symbol;".
		"Tahoma=tahoma,arial,helvetica,sans-serif;".
		"Terminal=terminal,monaco;".
		"Times New Roman=times new roman,times;".
		"Trebuchet MS=trebuchet ms,geneva;".
		"Verdana=verdana,geneva;".
		"Webdings=webdings;".
		"Wingdings=wingdings,zapf dingbats";
		
		
		$document->addScriptDeclaration('
		tinyMCE.init({
		mode : "exact",
		theme : "advanced",
		elements : "wfs_sample_editor_tiny",
		skin : "default",
		plugins : "pagebreak,style,layer,table,save,advhr,advimage,advlink,emotions,iespell,inlinepopups,insertdatetime,preview,media,searchreplace,print,contextmenu,paste,directionality,fullscreen,noneditable,visualchars,nonbreaking,xhtmlxtras,template,wordcount,advlist,autosave",
		theme_advanced_buttons1 : "save,newdocument,|,bold,italic,underline,strikethrough,|,justifyleft,justifycenter,justifyright,justifyfull,styleselect,formatselect,fontselect,fontsizeselect",
		content_css : "' . JURI::root() .'administrator/index.php?option=com_webfonts&controller=webfontsproject&task=font_stylesheet_ckeditor&pid='.$wfs_project_id.'",
		theme_advanced_fonts : "'.$fontsListTM.$default_font.'" ,
		theme_advanced_toolbar_location : "top"

			});
		');
		$js='plugins/editors/tinymcewfs/jscripts/tiny_mce/tiny_mce.js';
		$document->addScript(JURI::root().$js);
		/*END TinyMCE sample editor script*/
		 /*Ckeditor sample editor script*/
		$document->addScriptDeclaration("
		CKEDITOR.config.font_names =".$fontsList."CKEDITOR.config.font_names;
		CKEDITOR.config.contentsCss = '".JURI::root()."administrator/index.php?option=com_webfonts&controller=webfontsproject&task=font_stylesheet_ckeditor&pid=".$wfs_project_id."';
		");
		
		$js='plugins/editors/ckeditorwfs/ckeditor/ckeditor.js';
		$document->addScript(JURI::root().$js);
	    /*end Ckeditor sample editor script*/
		parent::display();
	}
	
	function edit_domain()
	{
		JRequest::setVar( 'view', 'webfontsconfigure' );
		JRequest::setVar('layout', 'edit_domain');
		parent::display();
	}
	
	function edit_stylesheet()
	{
		JRequest::setVar( 'view', 'webfontsconfigure' );
		JRequest::setVar('layout', 'edit_stylesheet');
		$model = $this->getModel('webfontsconfigure');
		$data= $model->getData();
		$key = $data->project_key;
		$document =& JFactory::getDocument();
		$js = FFJSAPIURI.$key.".js";
		$document->addScript($js);
		parent::display();
	}
	
	function edit_domain_form()
	{
		JRequest::setVar( 'view', 'webfontsconfigure' );
		JRequest::setVar('layout', 'edit_domain_form');
		parent::display();
	}
	
	/**
	 * save a record (and redirect to main page)
	 * @return void
	 */
	function save_configure()
	{
		$project_id = JRequest::getvar( 'project_id' );
		$enable_editor = JRequest::getvar( 'enable_editor' );
		
		$model = $this->getModel('webfontsconfigure');
		$link = 'index.php?option=com_webfonts&controller=webfontsconfigure&task=edit&cid[]='.$project_id;
		if ($model->store_configure($post)) {
			
		if($enable_editor == 1 && !empty($enable_editor))
			{
				$model_project = $this->getModel('webfontsproject');
				$project_data = $model_project->getProjectProfile($project_id);
			
					$editor_selection = JRequest::getvar( 'editor_selection' );
					$configFile =JPATH_CONFIGURATION.DS.'configuration.php';
					$configArray = file ($configFile);
						foreach($configArray as $key=>$val){
							preg_match('/editor/', $val, $matches, PREG_OFFSET_CAPTURE);
							if($matches[0]){
							if($editor_selection == 0){
							$configArray[$key] = "var "."$"."editor = 'tinymcewfs';
";								}else{
							$configArray[$key] = "var $"."editor = 'ckeditorwfs';
";
								}
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
					
				}else{
					//if editor is not enable for active project
					if($project_data[0]->is_active == 1 && $project_data[0]->wysiwyg_enabled == 1){
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
						}
					}
			$msg = JText::_( 'Configuration Saved Succesfully!' );
			$this->setRedirect($link, $msg);
		} else {
			$msg = JText::_( 'Error Saving Configuration' );
			$this->setRedirect($link, $msg, 'error');
		}
	}

	/**
	 * cancel editing a record
	 * @return void
	 */
	function cancel()
	{
		
		$this->setRedirect( 'index.php?option=com_webfonts&controller=webfontsproject');
	}
	
	/*
	* Fonts listing record(s) from ajax 
	* @return fonts list
	*/
	function fonts_list_ajax(){
		
		$model_project = $this->getModel('webfontsproject');
		$project_data = $model_project->getProjectProfile($_GET['pid'],'project_key');
		$model = $this->getModel('webfontsconfigure');
		
		$fonts_lists = $model->wfs_font_list_pagination($project_data[0]->wfs_configure_id );
		$json = new Services_JSON();
		$result = $json->encode($fonts_lists);
		echo $result;
		exit;
	}
	
	/*
	* Fonts listing record(s) from ajax 
	* @return fonts list
	*/
	function selector_list_ajax(){
		$model = $this->getModel('webfontsconfigure');
		$data = $model->getSelectorsList($_GET['pid']);
		$selector_list = array('data' => $data[0],'pagination'=>$data[1]);
		$json = new Services_JSON();
		$result = $json->encode($selector_list);
		echo $result;
		exit;
	}
	/*
	*Selector adding function
	*@return void
	*/
	function selector_add_ajax(){
		$model = $this->getModel('webfontsconfigure');
		$data = $model->add_selector();
		$selector_list = array('data' => $data[0],'pagination'=>$data[1]);
		$json = new Services_JSON();
		$result = $json->encode($selector_list);
		echo $result;
		exit;
	}
	/*
	*Selector saving function
	*@return void
	*/
	function save_selector(){
		$model = $this->getModel('webfontsconfigure');
		$link = 'index.php?option=com_webfonts&controller=webfontsconfigure&task=edit_stylesheet&cid[]='.$_POST['project_id'];
		if ($model->save_selector($post)) {
			$msg = JText::_( 'Selector Saved Succesfully!' );
			$this->setRedirect($link, $msg);
		} else {
			$msg = JText::_( 'Error Saving Selector' );
			$this->setRedirect($link, $msg, 'error');
		}
	}
	
	/*
	*Selector removings function
	*@return void
	*/
	function remove_selector(){
		$model = $this->getModel('webfontsconfigure');
		$link = 'index.php?option=com_webfonts&controller=webfontsconfigure&task=edit_stylesheet&cid[]='.$_POST['project_id'];
		if ($model->remove_selector($post)) {
			$msg = JText::_( 'Selector Deleted Succesfully!' );
			$this->setRedirect($link, $msg);
		} else {
			$msg = JText::_( 'Error Deleting Selector' );
			$this->setRedirect($link, $msg, 'error');
		}
	}
	
	
		/*
	* Domnains listing record(s) from ajax 
	* @return fonts list
	*/
	function domain_list_ajax(){
		$model = $this->getModel('webfontsconfigure');
		$data = $model->getDomains($_GET['pid']);
		$domain_list = array('data' => $data[0],'pagination'=>$data[1]);
		$json = new Services_JSON();
		$result = $json->encode($domain_list);
		echo $result;
		exit;
	}
	
	function addDomain(){
		$model = $this->getModel('webfontsconfigure');
		$data = $model->addDomain();
		$domain_list = array('data' => $data[0],'pagination'=>$data[1]);
		$json = new Services_JSON();
		$result = $json->encode($domain_list);
		echo $result;
		exit;
	}
	
	/*
	*Domain removings function
	*@return void
	*/
	function remove_domain(){
		$model = $this->getModel('webfontsconfigure');
		$link = 'index.php?option=com_webfonts&controller=webfontsconfigure&task=edit_domain&cid[]='.$_POST['project_id'];
		if ($model->removeDomain($post)) {
			$msg = JText::_( 'Domain Deleted Succesfully!' );
			$this->setRedirect($link, $msg);
		} else {
			$msg = JText::_( 'Error Deleting Domain' );
			$this->setRedirect($link, $msg, 'error');
		}
	}
	
	function editDomain(){
		$model = $this->getModel('webfontsconfigure');
		$link = 'index.php?option=com_webfonts&controller=webfontsconfigure&task=edit_domain&cid[]='.$_POST['project_id'];
		if ($model->editDomain($post)) {
			$msg = JText::_( 'Domain Edited Succesfully!' );
			$this->setRedirect($link, $msg);
		} else {
			$msg = JText::_( 'Error Editing Domain' );
			$this->setRedirect($link, $msg,'error');
		}
	}
	
	function save_editor_fonts(){
		$model = $this->getModel('webfontsconfigure');
		$link = 'index.php?option=com_webfonts&controller=webfontsconfigure&task=edit_stylesheet&cid[]='.$_POST['project_id'];
		if ($model->save_editor_fonts($post)) {
			$msg = JText::_( 'Editors Fonts Edited Succesfully!' );
			$this->setRedirect($link, $msg);
		} else {
			$msg = JText::_( 'Error Editing Fonts' );
			$this->setRedirect($link, $msg,'error');
		}
		}
}
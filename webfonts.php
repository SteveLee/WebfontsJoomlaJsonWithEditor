<?php
/**
Copyright 2010 Monotype Imaging Inc.  
This program is distributed under the terms of the GNU General Public License
*/

/**
 * @Components    Fonts.com Webfonts
 * components/com_webfonts/webfonts.php
 * @license    GPL
*/

//No direct access
defined( '_JEXEC' ) or die( 'Restricted access' );
$params = &JComponentHelper::getParams('com_webfonts');
//adding fonts from wfs
require_once( JPATH_SITE.DS.'administrator'.DS.'components'.DS.'com_webfonts'.DS.'libraries'.DS.'includes.php' );
require_once( JPATH_SITE.DS.'administrator'.DS.'components'.DS.'com_webfonts'.DS.'libraries'.DS.'json.class.php' );
require_once( JPATH_SITE.DS.'administrator'.DS.'components'.DS.'com_webfonts'.DS.'libraries'.DS.'wfsapi.class.php' );


	header("content-type: text/css");	
	$wfs_details=getUnPass();
	$key = get_activated_key();
	$browser = browserName();
	//Fetching the json data from WFS
	$apiurl = "json/Fonts/?wfspid=".$key;
	$wfs_api = new Services_WFS($wfs_details[1],$wfs_details[2],$apiurl);
	$jsonUrl = $wfs_api->wfs_getInfo_post();
	$json = new Services_JSON(SERVICES_JSON_LOOSE_TYPE);
	$fontArray = $json->decode($jsonUrl);
	$fonts =$fontArray['Fonts']['Font'];
	$webfonts=array();
	$fontsList="";
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
			$stylesheetcss.="@font-face{font-family:'".$FontCSSName."';src:url('http://fast.fonts.com/d/".$TTF.$ext."?".$CDNKey."&projectId=".$key."');}";
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
		$stylesheetcss.="@font-face{font-family:'".$FontCSSName."';src:url('http://fast.fonts.com/d/".$TTF.$ext."?".$CDNKey."&projectId=".$key."');}";
			}//end of foreach
		}//end of else for is_multi
	}
	print $stylesheetcss;
	exit;

/*
* function to get the current key
*/
function get_activated_key(){
	
$params = &JComponentHelper::getParams('com_webfonts');
$db =& JFactory::getDBO();
$wfs_userid = $params->get( 'wfs_user_id' );

$wfs_project_id = $_GET['pid'];
if(!empty($wfs_project_id)){
$query = "SELECT project_key,wfs_configure_id FROM #__wfs_configure WHERE  `wfs_configure_id` = '$wfs_project_id' ORDER BY updated_date DESC";
$db->setQuery( $query);
$rows = $db->loadObjectList();
$key=$rows[0]->project_key;
	}
else{
$query = "SELECT project_key,project_page_option,project_options,project_pages,project_day,wysiwyg_enabled,editor_select FROM #__wfs_configure WHERE `is_active` = '1' and `user_id` = '$wfs_userid' and wysiwyg_enabled = '1' ORDER BY updated_date DESC";
$db->setQuery( $query);
$rows = $db->loadObjectList();

	foreach($rows as $data)
		{
		$dayValue = $data->project_day;
		if(checkday($dayValue)){
			
				$key=$data->project_key;
				break;
			}	
	}
}

return $key;
}
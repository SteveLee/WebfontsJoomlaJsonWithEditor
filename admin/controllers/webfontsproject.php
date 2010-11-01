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

class WebfontsBaseControllerWebfontsProject extends WebfontsBaseController
{
	/**
	 * constructor (registers additional tasks to methods)
	 * @return void
	 */
	function __construct()
	{
	
		parent::__construct();
		// Register Extra tasks
		$this->registerTask( 'add' , 'add' );
		$this->registerTask( 'sync' , 'sync' );
		
	}
	
	/**
	 * constructor (registers additional tasks to methods)
	 * @return void
	 */
	function display()
    {
		JRequest::setVar( 'view', 'webfontsproject' );
		parent::display();
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
	 * Add a record (and redirect to main page)
	 * @return void
	 */
	function add()
	{
		$model = $this->getModel('webfontsproject');
		
		if ($model->addProject($post)) {
			$msg = JText::_( 'Project(s) added succesfully!' );
		} else {
			$msg = JText::_( 'Error adding project(s)' );
		}
		$this->setRedirect('index.php?option=com_webfonts&controller=webfontsproject', $msg);
	}
	
	
	/**
	 * remove record(s)
	 * @return void
	 */
	function remove()
	{
		
		$model = $this->getModel('webfontsproject');
		if(!$model->delete()) {
			$msg = JText::_( 'Error: One or More projects Could not be Deleted' );
		} else {
			$msg = JText::_( 'Project(s) Deleted' );
		}
		$this->setRedirect( 'index.php?option=com_webfonts&controller=webfontsproject', $msg );
	}
	
	/*
	* Activate record(s)
	* @return void
	*/
	function publish()
	{
		$model = $this->getModel('webfontsproject');
		if(!$model->activate()) {
			$msg = JText::_( 'Error: One or More projects Could not be Activated' );
		} else {
			$msg = JText::_( 'Project(s) Activated' );
		}
		
		$this->setRedirect( 'index.php?option=com_webfonts&controller=webfontsproject', $msg );
	}
	
	/*
	* Deactivate record(s)
	* @return void
	*/
	function unpublish()
	{
		$model = $this->getModel('webfontsproject');
		if(!$model->deactivate()) {
			$msg = JText::_( 'Error: One or More projects Could not be Deactivated' );
		} else {
			$msg = JText::_( 'Project(s) Deactivated' );
		}
		
		$this->setRedirect( 'index.php?option=com_webfonts&controller=webfontsproject', $msg );
	}
	
	/**
	 * Sync a record (and redirect to main page)
	 * @return void
	 */
	function sync()
	{
		$model = $this->getModel('webfontsproject');
		
		if ($model->syncProject($post)) {
			$msg = JText::_( 'Project(s) synchronized succesfully!' );
		} else {
			$msg = JText::_( 'Error synchronizing project(s)' );
		}
		$this->setRedirect('index.php?option=com_webfonts&controller=webfontsproject', $msg);
	}

	/*
	*Project listing record(s) from ajax 
	* @return project list
	*/
	function project_list_ajax(){
		
		$output="";
		$model = $this->getModel('webfontsproject');
		$pageStart = (isset($_GET['pageStart']))?$_GET['pageStart']:0;
		$wfs_details = getUnPass();
		//Fetching the json data from WFS
		$apiurl = "json/Projects/?wfspstart=".$pageStart."&wfsplimit=".PROJECT_LIMIT;
		$wfs_api = new Services_WFS($wfs_details[1],$wfs_details[2],$apiurl);
		$jsonUrl = $wfs_api->wfs_getInfo_post();
		//creating a  Array from Json
		$json = new Services_JSON(SERVICES_JSON_LOOSE_TYPE);
		$projectsArray = $json->decode($jsonUrl);
		$cnt=1;
		$message = $projectsArray['Projects']['Message'];
		if($message == "Success"){			
			$projects = $projectsArray['Projects']['Project'];
			if(!empty($projects)){
				$is_multi = is_multi($projects);
				if($is_multi == 1){
					
					$projectName = $projects['ProjectName'];
					$projectKey = $projects['ProjectKey'];
					$wfs_projects =$model->getProjectProfile($projectKey, "project_key");
					$sn =$cnt+$pageStart;
					if(empty($wfs_projects[0]->project_key)){
						$output.='<tr><td>'.$sn.'</td><td width="20"><input type="checkbox" class="imp_prj_checkboxes" name="project_key['.$projectKey.']" id="'.$projectKey.'" value="'.$projectKey.'"/></td><td style="text-align:left"> '.$projectName.'<input type="hidden" name="project_name['.$projectKey.']" value="'.$projectName.'" /></td></tr>';
						$cnt++;
					}else{
							$output.='<tr><td>'.$sn.'</td><td width="20"><input type="checkbox" disabled="disabled" name="project_key['.$projectKey.']" id="'.$projectKey.'" value="'.$projectKey.'"/></td><td> '.$projectName.' <i style="color:#0b55c4">(Project already added.</i>)<input type="hidden" name="project_name['.$projectKey.']" value="'.$projectName.'" /></td></tr>';
						$cnt++;
						}
				
				}else{
					foreach( $projects as $project )
					{
						$projectName = $project['ProjectName'];
						$projectKey = $project['ProjectKey'];
						$wfs_projects =$model->getProjectProfile($projectKey, "project_key");
						$sn =$cnt+$pageStart;
						if(empty($wfs_projects[0]->project_key)){
							$output.='<tr><td>'.$sn.'</td><td width="20"><input type="checkbox" class="imp_prj_checkboxes" name="project_key['.$projectKey.']" id="'.$projectKey.'" value="'.$projectKey.'"/></td><td style="text-align:left"> '.$projectName.'<input type="hidden" name="project_name['.$projectKey.']" value="'.$projectName.'" /></td></tr>';
							$cnt++;
						}else{
								$output.='<tr><td>'.$sn.'</td><td width="20"><input type="checkbox" disabled="disabled" name="project_key['.$projectKey.']" id="'.$projectKey.'" value="'.$projectKey.'"/></td><td> '.$projectName.' <i style="color:#0b55c4">(Project already added.</i>)<input type="hidden" name="project_name['.$projectKey.']" value="'.$projectName.'" /></td></tr>';
							$cnt++;
						}
					}//end of foreach
				}//end of els for is_multi
			}//end of empty project
			
			if($cnt == 1)
					{
						$output.="<tr><td colspan='2'>No project available.</td></tr>";
					}
			
			//Pagination data
				$totalRecord =$projectsArray['Projects']['TotalRecords'];
				$pageStart =$projectsArray['Projects']['PageStart'];
				$pageLimit =$projectsArray['Projects']['PageLimit'];
			}//enf of if for success
			else{
				$output.='<tr><td colspan="2">'.$message.'</td></tr>';
				}
	
		
		$pageLimit = $pageLimit;
		$totalRecord = $totalRecord ;
		if($totalRecord!=0 && $pageLimit!="" && $cnt!=1){
			$wfs_pg = new wfs_pagination($totalRecord,$pageStart,$pageLimit,'imp_project_div','project_pagination_div',"index.php?option=com_webfonts&controller=webfontsproject&task=project_list_ajax");
			$wfs_pg_projects =  $wfs_pg->getPagination();
		}
		$value = array('data'=>$output, 'pagination' => $wfs_pg_projects);
		$json = new Services_JSON();
		$result = $json->encode($value);
		echo $result;
		exit;
		}
		
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
		
		/*
		* function to generate css for ckeditor
		*/
		function font_stylesheet_ckeditor()
		{
			header("content-type: text/css");	
			$wfs_details=getUnPass();
			$key = $this->get_activated_key();
			$browser = browserName();
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
				
			}


}
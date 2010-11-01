<?php
/**
 * Copyright 2010 Monotype Imaging Inc.  
 * This program is distributed under the terms of the GNU General Public License
 */
 
/**
 * Webfontss Model for fonts.com webfonts Component
 * 
 * @Components    Fonts.com Webfonts
 * components/com_webfonts/webfonts.php
 * @license    GPL
 */
 
// No direct access
defined( '_JEXEC' ) or die( 'Restricted access' );
//Library class file for model
jimport( 'joomla.application.component.model' );

class WebfontsBaseModelWebfontsProject extends JModel
{
    /**
     * Webfontss data array
     *
     * @var array
     */
    var $_data;
 	/**
	* Items total
	* @var integer
	*/
	var $_total = null;
	 
	  /**
	   * Pagination object
	   * @var object
	   */
	var $_pagination = null;
	
	function __construct()
 	 {
        parent::__construct();
 
        global $mainframe, $option;
 
        // Get pagination request variables
        $limit = $mainframe->getUserStateFromRequest('global.list.limit', 'limit', $mainframe->getCfg('list_limit'), 'int');
        $limitstart = JRequest::getVar('limitstart', 0, '', 'int');
 
        // In case limit has been changed, adjust it
        $limitstart = ($limit != 0 ? (floor($limitstart / $limit) * $limit) : 0);
 
        $this->setState('limit', $limit);
        $this->setState('limitstart', $limitstart);
 	 }
	
    /**
     * Returns the query
     * @return string The query to be used to retrieve the rows from the database
     */
    function _buildQuery()
    {	
	$params = &JComponentHelper::getParams('com_webfonts');
	
	$query = ' SELECT * '
            . ' FROM #__wfs_configure where user_id = "'.$params->get( 'wfs_user_id' ).'" ORDER BY is_active DESC,updated_date DESC '
        ;
        return $query;
    }
 
    /**
     * Retrieves the webfonts data
     * @return array Array of objects containing the data from the database
     */
    function getData()
    {
        // Lets load the data if it doesn't already exist
        if (empty( $this->_data ))
        {
            $query = $this->_buildQuery();
            //$this->_data = $this->_getList( $query );
			$this->_data = $this->_getList($query, $this->getState('limitstart'), $this->getState('limit'));
        }
 
        return $this->_data;
    }
	/**
     * Retrieves the total projects
     * @return array Array of objects containing the data from the database
     */
		function getTotal()
		{
			// Load the content if it doesn't already exist
			if (empty($this->_total)) {
				$query = $this->_buildQuery();
				$this->_total = $this->_getListCount($query);    
			}
			return $this->_total;
		}
		/*
		* get pagination
		*/
		function getPagination()
		{
			// Load the content if it doesn't already exist
			if (empty($this->_pagination)) {
			jimport('joomla.html.pagination');
			$this->_pagination = new JPagination($this->getTotal(), $this->getState('limitstart'), $this->getState('limit') );
			}
			return $this->_pagination;
		}
	
	 /**
     * Retrieves the webfonts data
     * @return array Array of objects containing the data from the database
     */
    function getProjectProfile($pid, $key="wfs_configure_id")
    {
        $query = "SELECT * FROM `#__wfs_configure` WHERE ".$key." = '$pid'";
        $this->result = $this->_getList( $query );
        
        return $this->result;
    }
	
	/**
	 * Method to store a record
	 *
	 * @access	public
	 * @return	boolean	True on success
	 */
	function addProject()
	{	
		

		$datas = JRequest::getVar('project_key');
		$projectNames = JRequest::getVar('project_name');
		
		foreach($datas as $key=>$val){
			
		$row =& $this->getTable('webfonts');
		
		$data = array('project_key' => $val,
					  'project_name' => $projectNames[$key],
					  'user_id' => JRequest::getVar('user_id'));
		
		// Bind the form fields to the webfonts table
		if (!$row->bind($data)) {
			$this->setError($this->_db->getErrorMsg());
			return false;
		}
		
		// Make sure the webfonts record is valid
		if (!$row->check()) {
			$this->setError($this->_db->getErrorMsg());
			return false;
		}
		$row->store();
		// Store the webfonts table to the database
		if (!$row->store()) {
			$this->setError( $row->getErrorMsg() );
			return false;
			}
		}
		
		return true;
	}
	
	/**
	 * Method to sync a record with wfs database
	 *
	 * @access	public
	 * @return	boolean	True on success
	 */
	function syncProject()
	{	$db = JFactory::getDBO();
		$wfs_details = getUnPass();
		//Fetching the xml data from WFS
		$apiurl = "xml/Projects/";
		$wfs_api = new Services_WFS($wfs_details[1],$wfs_details[2],$apiurl);
		$xmlUrl = $wfs_api->wfs_getInfo_post();
		//creating a DOM object
		$doc = new DOMDocument();
		$doc->loadXML($xmlUrl);
		//check the message status
		$messages = $doc->getElementsByTagName( "Message" );
		$message = $messages->item(0)->nodeValue;
		if($message == "Success") {
		//fetching XML data
		$projects = $doc->getElementsByTagName( "Project" );
		foreach( $projects as $project )
		{
			$projectNames = $project->getElementsByTagName("ProjectName");	
			$projectName = $projectNames->item(0)->nodeValue;
		
			$projectKeys = $project->getElementsByTagName("ProjectKey");	
			$projectKey = $projectKeys->item(0)->nodeValue;
		
			//update the projects that are database
			$webfonts_added_project = $this->getProjectProfile($projectKey, "project_key");
			if(!empty($webfonts_added_project[0]->project_key))
				{
				$query = "Update `#__wfs_configure`  SET `project_name` = '".$projectName."', `project_key` = '".$projectKey."' WHERE wfs_configure_id = '".$webfonts_added_project[0]->wfs_configure_id."'";
				
				$db->setQuery( $query );
				if(!$db->query())
					{
					 return false;	
					}
					
				} 
			
			}
		}
		//Delete all the projects that are not in the user accounts
		$xmlData = $xmlUrl;
		$query = $this->_buildQuery();
        $rs = $this->_getList( $query );
		if ($rs) {
			foreach ($rs as $key=>$data ) {
				preg_match("/<ProjectKey>".$data->project_key."/", $xmlData, $matches);
				if(empty($matches[0]))
				{
					$query="DELETE FROM `#__wfs_configure` WHERE wfs_configure_id = '".$data->wfs_configure_id."'";
					$db->setQuery( $query );
					if(!$db->query())
					{
						 return false;	
					}
				}
			}
		}
       
		
		return true;
	}
	
	
	/**
	 * Method to delete record(s)
	 *
	 * @access	public
	 * @return	boolean	True on success
	 */
	function delete()
	{
		$cids = JRequest::getVar( 'cid', array(0), 'post', 'array' );
		$row =& $this->getTable('webfonts');
		if (count( $cids )) {
			foreach($cids as $cid) {
				if (!$row->delete( $cid )) {
					$this->setError( $row->getErrorMsg() );
					return false;
				}
			}
		}
		return true;
	}
	
	/**
	 * Method to Activating record(s)
	 *
	 * @access	public
	 * @return	boolean	True on success
	 */
	function activate()
	{
		$db = JFactory::getDBO();
		$cids = JRequest::getVar( 'cid', array(0), 'post', 'array' );

		if (count( $cids )) {
			foreach($cids as $cid) {
			$query = 'Update `#__wfs_configure`  SET `is_active` = "1" WHERE wfs_configure_id = '.$cid;
				$db->setQuery( $query );
				if(!$db->query())
					{
					 return false;	
					}
			}
		}
		return true;
	}

/**
	 * Method to Deactivating record(s)
	 *
	 * @access	public
	 * @return	boolean	True on success
	 */
	function deactivate()
	{
		$db = JFactory::getDBO();
		$cids = JRequest::getVar( 'cid', array(0), 'post', 'array' );

		if (count( $cids )) {
			foreach($cids as $cid) {
			$query = 'Update `#__wfs_configure`  SET `is_active` = "0", `wysiwyg_enabled` = "0"  WHERE wfs_configure_id = '.$cid;
				$db->setQuery( $query );
				if(!$db->query())
					{
					 return false;	
					}
			}
		}
		return true;
	}
	
}

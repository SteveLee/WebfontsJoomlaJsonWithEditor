<?php
/**
 * Copyright 2010 Monotype Imaging Inc.  
 * This program is distributed under the terms of the GNU General Public License
 */
 
/**
 * Webfontsc Model for fonts.com webfonts Component
 * 
 * @Components    Fonts.com Webfonts
 * components/com_webfonts/webfonts.php
 * @license    GPL
 */
 
// No direct access
defined( '_JEXEC' ) or die( 'Restricted access' );

jimport('joomla.application.component.model');

class WebfontsBaseModelWebfontsLogin extends JModel
{
	/**
	 * Constructor that retrieves the ID from the request
	 *
	 * @access	public
	 * @return	void
	 */
	function __construct()
	{
		parent::__construct();

		$array = JRequest::getVar('cid',  0, '', 'array');
		$this->setId((int)$array[0]);
	}

	/**
	 * Method to set the hello identifier
	 *
	 * @access	public
	 * @param	int Hello identifier
	 * @return	void
	 */
	function setId($id)
	{
		// Set id and wipe data
		$this->_id		= $id;
		$this->_data	= null;
	}

	/**
	 * Method to get a hello
	 * @return object with data
	 */
	function &getData()
	{
		// Load the data
		if (empty( $this->_data )) {
			$query = ' SELECT * FROM #__wfs_configure '.
					'  WHERE wfs_configure_id = '.$this->_id;
			$this->_db->setQuery( $query );
			$this->_data = $this->_db->loadObject();
		}
		if (!$this->_data) {
			$this->_data = new stdClass();
			$this->_data->id = 0;
			$this->_data->webfonts = null;
		}
		return $this->_data;
	}

	/**
	 * Method to store a record
	 *
	 * @access	public
	 * @return	boolean	True on success
	 */
	function store()
	{	
		if(!empty($_POST['wfs_api_key'])){
			$webfonts_token=explode("--",trim($_POST['wfs_api_key']));
			$wfs_public_key = $webfonts_token[0];
			$wfs_private_key = $webfonts_token[1];
			//Fetching the json data from WFS
			$apiurl = "json/Projects/";
			$wfs_api = new Services_WFS($wfs_public_key,$wfs_private_key,$apiurl);
			$jsonUrl = $wfs_api->wfs_getInfo_post();
			}else{
				return false;
			}
			//initializing json instance for deocoding
			$json = new Services_JSON(SERVICES_JSON_LOOSE_TYPE);
			$loginArray = $json->decode($jsonUrl);
			$Message = $loginArray['Projects']['Message'];
			if($Message=="Success"){
				$UserId  = $loginArray['Projects']['UserId'];
				$UserRole  =  $loginArray['Projects']['UserRole'];
				$data['params']['wfs_public_key'] = $wfs_public_key;
				$data['params']['wfs_private_key'] = $wfs_private_key;
				$data['params']['wfs_pagination'] = JRequest::getVar( 'wfs_pagination' );
				$data['params']['wfs_user_id'] = $UserId;
				$data['params']['wfs_usertype'] = (strtolower($UserRole)=="free")?0:1;
			}
		else{
				return false;
			}
		$row =& $this->getTable('webfontslogin');
		// Bind the form fields to the hello table
		if (!$row->bind($data)) {
			$this->setError($this->_db->getErrorMsg());
			return false;
		}
	
		// Make sure the hello record is valid
		if (!$row->check()) {
			$this->setError($this->_db->getErrorMsg());
			return false;
		}
		// Store the web link table to the database
		if (!$row->store()) {
			$this->setError( $row->getErrorMsg() );
			return false;
		}
		
		return true;
	}



/**
	 * Method to store a record
	 *
	 * @access	public
	 * @return	boolean	True on success
	 */
	function authenticate()
	{
		$params = &JComponentHelper::getParams('com_webfonts');
		$wfs_public_key = $params->get( 'wfs_public_key' );
		$wfs_private_key = $params->get( 'wfs_private_key' );
		if(!empty($wfs_public_key) && !empty($wfs_private_key)){
			//Fetching the json data from WFS
			$apiurl = "json/Projects/?wfsplimit=1";
			$wfs_api = new Services_WFS($wfs_public_key,$wfs_private_key,$apiurl);
			$jsonUrl = $wfs_api->wfs_getInfo_post();
			
			}
		else {
			return false;
			}
			//initializing json instance for deocoding
			$json = new Services_JSON(SERVICES_JSON_LOOSE_TYPE);
			$loginArray = $json->decode($jsonUrl);
			$Message = $loginArray['Projects']['Message'];
			if($Message=="Success"){
				return true;
				}
		else{
				return false;
			}
	}

}
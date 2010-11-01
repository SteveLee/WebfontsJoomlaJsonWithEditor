DROP TABLE IF EXISTS `#__wfs_configure`;
DROP TABLE IF EXISTS `#__wfs_editor_fonts`; 
CREATE TABLE `#__wfs_configure` (
  `wfs_configure_id` int(200) NOT NULL auto_increment,
  `project_name` varchar(255) NOT NULL default '',
  `project_key` varchar(255) NOT NULL default '',
  `project_day` varchar(255) NOT NULL default '0-6',
  `project_page_option` enum('0','1','2') NOT NULL default '0',
  `project_pages` text NOT NULL,
  `project_options` enum('0','1') NOT NULL default '0',
  `wysiwyg_enabled` enum('0','1') NOT NULL default '0' COMMENT '0>disabled, 1>enabled',
  `is_active` enum('0','1') NOT NULL default '0' COMMENT '0>inActive, 1>Active',
  `user_id` varchar(255) NOT NULL default '',
  `user_type` enum('0','1') NOT NULL default '0' COMMENT '0>free, 1> paid',
  `editor_select` enum('0','1') NOT NULL DEFAULT '0',
  `show_system_fonts` enum('0','1','2','3') NOT NULL default '0' COMMENT '0>none, 1>admin, 2>front, 3>both',
  `updated_date` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00' ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY  (`wfs_configure_id`)
) ENGINE=MyISAM  AUTO_INCREMENT=0  DEFAULT CHARSET=utf8 ;
 
CREATE TABLE IF NOT EXISTS `#__wfs_editor_fonts` (
 `wfs_font_id` int(11) NOT NULL AUTO_INCREMENT,
  `tinymce_name` varchar(250) NOT NULL,
  `ckeditor_name` varchar(250) NOT NULL,
  `is_admin` enum('0','1','2') NOT NULL DEFAULT '1',
  `pid` int(11) NOT NULL,
  `is_active` enum('0','1') NOT NULL DEFAULT '0',
 PRIMARY KEY (`wfs_font_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1;
DROP TABLE IF EXISTS `#__wfs_configure`;
DELETE FROM #__modules WHERE module= 'mod_webfonts';
DELETE FROM #__plugins WHERE element = 'ckeditorwfs' AND name = 'Editor - CKEditorwfs';
DELETE FROM #__plugins WHERE element = 'tinymcewfs' AND name = 'Editor - TinyMCEwfs';
DROP TABLE IF EXISTS `#__wfs_editor_fonts`; 


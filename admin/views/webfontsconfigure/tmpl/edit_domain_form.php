<?php
/**
 * Copyright 2010 Monotype Imaging Inc.  
 * This program is distributed under the terms of the GNU General Public License
 */
 
/**
 * Webfonts template for fonts.com webfonts Component
 * 
 * @Components    Fonts.com Webfonts
 * components/com_webfonts/webfonts.php
 * @license    GPL
 */

// No direct access
defined('_JEXEC') or die('Restricted access'); ?>
<div id='wfs_message' style="display:none">
<dl id="system-message">
<dt class="message">Message</dt>
<dd class="message fade">
	<ul>
		<li id="wfsMsg">&nbsp;</li>
	</ul>
</dd>
</dl>
</div>

<form action="index.php?option=com_webfonts" method="post" name="adminForm">        
<div class="wfs_tabContainer">
<div id="submenu-box">
			<div class="t">
				<div class="t">
					<div class="t"></div>
		 		</div>
	 		</div>
			<div class="m">
			<div class="clear">
                        <div class="left"><h3 style="margin: 0;"><?php echo JText::_('Edit Domain:')?> &nbsp;</h3></div>
                        <div class="left"><input type="text" name="domainname" id="domainname" value=" <?php echo JRequest::getVar('dname'); ?>"/></div>
                        <div class="left ml ml"><span class="b_outer" style="margin:-3px;"><span class="b_inner"><input type="submit" value="Save" class="b_style" ></span></span></div>
                        <div class="clear"></div>
					</div>
    

<div class="clr"></div>
			</div>
			<div class="b">
				<div class="b">
		 			<div class="b"></div>
				</div>
			</div>
		</div>
<input type="hidden" name="option" value="com_webfonts" />
<input type="hidden" name="task" value="editDomain" />
<input type="hidden" name="controller" value="webfontsconfigure" />
<input type="hidden" name="project_key" value="<?php echo JRequest::getVar('pkey');?>" />
<input type="hidden" name="did" value="<?php echo JRequest::getVar('did');?>" />
<input type="hidden" name="project_id" value="<?php echo JRequest::getVar('pid');?>" />
</div>
	
</form>
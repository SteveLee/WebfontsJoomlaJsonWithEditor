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
<div id="submenu-box">
			<div class="t">
				<div class="t">
					<div class="t"></div>
		 		</div>
	 		</div>
			<div class="m">
				<ul id="submenu" class="wfs_tabNav">
                    <li >
                  		 <a href="index.php?option=com_webfonts&controller=webfontsconfigure&task=edit&cid[]=<?php echo $this->wfs_projects->wfs_configure_id; ?>" id="main_tab">Configure</a>
                    </li>
                    <li>
                  		<a href="index.php?option=com_webfonts&controller=webfontsconfigure&task=edit_stylesheet&cid[]=<?php echo $this->wfs_projects->wfs_configure_id; ?>" id="main_tab">Work on stylesheet</a>
                    </li>
                    <li class="wfs_current">
                  	 	<a href="javascript:;" id="main_tab">Domain</a>
                    </li>
                </ul>
				<div class="clr"></div>
			</div>
			<div class="b">
				<div class="b">
		 			<div class="b"></div>
				</div>
			</div>
		</div>
<form action="index.php?option=com_webfonts" method="post" name="adminForm">        
<div class="wfs_tabContainer">
<input type="hidden" name="option" value="com_webfonts" />
<input type="hidden" name="project_id" id="project_id" value="<?php echo $this->wfs_projects->wfs_configure_id; ?>" readonly="readonly" />
<input type="hidden" name="task" value="" />
<input type="hidden" id="domain_delete" readonly="readonly" name="domain_delete" />
<input type="hidden" name="controller" value="webfontsconfigure" />
<input  type="hidden"  id="project_key"  name="project_key"  value="<?php echo $this->wfs_projects->project_key;?>" readonly="readonly" />

    <!--Domain Tab -->
    <div class="wfs_tab wfs_current">
        <?php startRoundDiv(); ?>
        <div class="wfs_domain_main_div">
        <div class="wfs_row clear">
                        <div class="left"><h3 style="margin: 0;"><?php echo JText::_('Add Domain:')?> &nbsp;</h3></div>
                        <div class="left"><input type="text" name="txtdomainname" id="txtdomainname" style="width:200px;"/></div>
                        <div class="left ml"><span class="b_outer" style="margin-top:-3px;"><span class="b_inner"><input type="button" value="Add" class="b_style" id="add_domain_btn"></span></span></div>
                        <div class="clear"></div>
					</div>
        
			<table cellspacing="1"  class="adminlist">
			<thead>
				<tr>
				<th width="20">#</th>
				<th style="text-align:left">Domain</th>
				<th style="text-align:left">Option</th>
				</tr>
			</thead>
			<tbody id="wfs_domains_div">
			 <?php 
				echo $this->wfs_domains;
                         ?>
		   </tbody> 
		   <tfoot>
		   <tr>
			 <td colspan="5" style="height:40px">
			 <div class="pagination" id="domain_pagination_div">
              <?php echo $this->wfs_domains_pagination; ?>
			</div>
			</td>
   </tr>
   </tfoot>  
	</table>

				</div>          
        <?php endRoundDiv(); ?>
    </div>
    <!--End Domain Tab -->
    
</div>
</form>     
        


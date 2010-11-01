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
<!-- Login Form-->
<form action="index.php?option=com_webfonts" method="post" name="adminForm">
    <!-- making a rounding div upper part -->
<div id="element-box" >
    <div class="t">
        <div class="t">
            <div class="t"></div>
        </div>
    </div>
    <div class="m">
    <!-- End a rounding div upper part -->	
    <!--API key form -->
    <div class="wfs_info_text wfs_day_row">
You must be the member of <a href="<?php echo SIGNUPURI; ?>" target="_blank">webfonts.fonts.com</a> to use the plugin. If you have not registered yet, please <a target="_blank" href="<?php echo SIGNUPURI; ?>">sign up</a> here.</div>	

    <div  id="token_div" >
	<div class="wfs_row">
       	<label style="font-weight:bold;font-size:14px;">Authentication key token </label>
    </div>
 	
     <div class="wfs_row" >
       
        <input type="text" maxlength="256" name="wfs_api_key" id="wfs_api_key" value="<?php echo $this->wfs_api_key;?>" size="158" />
     </div>
     <div class="wfs_info">
     	<a href="<?php echo SIGNUPURI; ?>" target="_blank" title="webfonts.fonts.com">Sign up</a> | <a href="<?php echo GETKEYURI; ?>" target="_blank" title="webfonts.fonts.com">Get authentication token key</a>
     </div>
     </div>
    
    <!-- end of api key form-->
<!-- making a rounding div bottom part -->
    <div class="clr"></div>
    </div>
    <div class="b">
        <div class="b">
            <div class="b"></div>
        </div>
    </div>
</div>	
<!-- end of making a rounding div bottom part -->
	
 <div id="submenu-box" style="margin-top:10px;display:none;" >
    <div class="t">
            <div class="t">
                <div class="t"></div>
            </div>
        </div>
    <div class="m">
    
				<label for="Project name">
					<?php echo JText::_( 'Pagination Value' ); ?>:
				</label>
			
				<select  name="wfs_pagination" id="wfs_pagination"   />
                <!--	<option value="5" <?php //echo ($this->wfs_pagination == 5)?"selected":"";?>>5</option>-->
                    <option value="10" <?php echo ($this->wfs_pagination == 10)?"selected":"";?>>10</option>
                    <option value="15" <?php echo ($this->wfs_pagination == 15)?"selected":"";?>>15</option>
                    <option value="20" <?php echo ($this->wfs_pagination == 20)?"selected":"";?>>20</option>
                </select>
			  
    <div class="clear"></div>
    </div>
    <div class="b"><div class="b">
                <div class="b"></div>
            </div>
     </div>
</div>

<!-- Project BUTTON -->
<div class="wfs_project_button">
    <div class="wfs_row">
        
        <div class="left">
        	<span class="b_outer"><span class="b_inner">
            <input  class="b_style"type="submit" value="Save configuration" />
            </span></span>
         </div>
         <div class="left ml">
         	<span class="b_outer"><span class="b_inner">
            <input  class="b_style" type="reset" value="Reset configuration"/>
            </span></span>
         </div>
        <div class="clear">
        </div>
    </div>
</div>
<!--End of project button -->
<input type="hidden" name="option" value="com_webfonts" />
<input type="hidden" name="task" value="save" />
<input type="hidden" name="boxchecked" value="0" />
<input type="hidden" name="controller" value="webfontslogin" />
</form>
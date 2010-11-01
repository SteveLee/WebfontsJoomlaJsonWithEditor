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
                    <li>
                  		 <a href="index.php?option=com_webfonts&controller=webfontsconfigure&task=edit&cid[]=<?php echo $this->wfs_projects->wfs_configure_id; ?>" id="main_tab">Configure</a>
                    </li>
                    <li class="wfs_current">
                  		<a href="" id="main_tab">Work on stylesheet</a>
                    </li>
                    <li>
                  	 	<a href="index.php?option=com_webfonts&controller=webfontsconfigure&task=edit_domain&cid[]=<?php echo $this->wfs_projects->wfs_configure_id; ?>" id="main_tab">Domain</a>
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

 	<!-- COnfigure Tab -->
    <input type="hidden" name="option" value="com_webfonts" />
    <input type="hidden" name="project_id" id="project_id" value="<?php echo $this->wfs_projects->wfs_configure_id; ?>" readonly="readonly" />
    <input type="hidden" name="task" value="" />
    <input type="hidden" name="controller" value="webfontsconfigure" />
    <input  type="hidden"  id="project_key"  name="project_key"  value="<?php echo $this->wfs_projects->project_key;?>" readonly="readonly" />
   <!-- ENd of COnfigure Tab -->
   	<!-- Work on style sheet Tab -->
    <div class="wfs_tab wfs_current">
        	<!-- selector Tab -->
			  <?php startRoundDiv(); ?>
              <div class="wfs_selectors_main_div">
              		<div class="wfs_row clear">
                        <div class="left"><h3 style="margin: 0;">Add Selector: &nbsp;</h3></div>
                        <div class="left"><input type="text" name="add_selector_text" id="add_selector_text"  style="width: 200px;"></div>
                        <div class="left ml"><span class="b_outer"><span class="b_inner"><input type="button" value="Add" class="b_style" id="add_selector_btn"></span></span></div>
                        <div class="clear"></div>
					</div>
                    <table class="adminlist" style="color:#000;">
                    <thead>
                    <tr>
                     <th width="20" style="text-align:left" >#</th>
                    <th width="100" style="text-align:left" > <?php echo JText::_( 'Selector' ); ?></th>
                    <th width="200" style="text-align:left" > <?php echo JText::_( 'Assign Fonts' ); ?></th>
                    <th  style="text-align:left;" > <?php echo JText::_( 'Preview' ); ?></th>
                    <th width="200" style="text-align:left" > <?php echo JText::_( 'Option' ); ?></th>
                    </thead>
                    <tbody id="wfs_selectors_div">	
                    <?php echo $this->wfs_selectors;?>
                    </tbody>
                    <tfoot>
                    <tr>
                        <td colspan="5" style="height:40px">
                        <div class="pagination" id="selectors_pagination_div">
                         <?php 
                         echo $this->wfs_selectors_pagination;
                         ?>
                        </div>
       
                        </td>
                    </tr>
                    </tfoot>  
                    </table>
                     <div class="clear wfs_row" style="margin-top:10px;">
                        <div class="left">
                            <span class="b_outer" style="margin-top:-2px;"><span class="b_inner">
                            <input type="hidden" name="selector_delete" id="selector_delete" value="" readonly="readonly" />	
                            <input type="button" class="b_style" id="save" value="Save" onclick="submitbutton('save_selector')" />
                            </span></span>
                        </div>
                    </div>
                </div>
               <?php endRoundDiv(); ?>
             <div class="clear wfs_row"></div>
            <!-- End of selector Tab -->
              <?php startRoundDiv(); ?>
           <div id="submenu-box">
                    <div class="t">
                        <div class="t">
                            <div class="t"></div>
                        </div>
                    </div>
                    <div class="m">
                        <ul id="submenu" class="wfs_tabNav2">
                            <li class="wfs_current">
                                 <a href="javascript:;">Fonts</a>
                            </li>
                            <li>
                                <a href="javascript:;">Joomla existing selector</a>
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
           <div class="wfs_tabContainer">
            <!-- Configure Tab -->
                <div class="wfs_tab wfs_current">
                   <div id="element-box">
                        <div class="t">
                            <div class="t">
                                <div class="t"></div>
                            </div>
                        </div>
                        <div class="m">
                        	<div class="wfs_fonts_main_div">
                     		<table class="adminlist" style="color:#000;">
                            <thead>
                                <tr>
                                	<th style="text-align:left" rowspan="2" > <?php echo JText::_( 'Preview' ); ?></th>
                                 	<th style="text-align:center" colspan="2" > <?php echo JText::_( 'Online WYSIWYG editor' ); ?></th>
                                </tr>
                                
                                <!---
                                Changes: Caption changed to Non-Admin and Admin
                                - By: Keshant
                                -->                                
                                <tr>
                                  	<th style="text-align:left" > <?php echo JText::_( 'Non-Admin' ); ?></th>
                                  	<th style="text-align:left" > <?php echo JText::_( 'Admin' ); ?></th>
                                </tr>   
                                <!-- End -->
                                      
                            </thead>
                            <tbody id="wfs_fonts_div">							<?php
                            if(count($this->wfs_fonts["FontName"])>0){
								
								$editorArray = $this->wfs_editor_fonts;
								$editorFontNameArr = $editorArray[0];
								$editorFontNameArrStatus = $editorArray[1];
								for($i=0;$i< count($this->wfs_fonts["FontName"]);$i++){	
									$checkedFront = "";
									$checkedBack  = "";
									if(in_array($this->wfs_fonts["FontName"][$i].'='.$this->wfs_fonts["FontCSSName"][$i].';',$editorFontNameArr))
									{
										$keyFontData =  array_search($this->wfs_fonts["FontName"][$i].'='.$this->wfs_fonts["FontCSSName"][$i].';',$editorFontNameArr);
										if($editorFontNameArrStatus[$keyFontData] == 2)
										{
											$checkedFront = 'checked = "checked"';
											$checkedBack = 'checked = "checked"';
										}
										else if($editorFontNameArrStatus[$keyFontData] == 1){
											$checkedFront = 'checked = "checked"';
										
										}
										else if($editorFontNameArrStatus[$keyFontData] == 0){
											$checkedBack = 'checked = "checked"';
											}
									}
								
                           		  echo '<tr class="row'.$i.'">
                               	 <td><div class="font_sep">
                                      <span class="font_img" style="font-family:\''.$this->wfs_fonts["FontCSSName"][$i].'\' !important;font-size:30px;">'.$this->wfs_fonts["FontPreviewTextLong"][$i].'</span>
                                       <div class="fontnames"><u>'.$this->wfs_fonts["FontName"][$i].'</u> | <u>'.$this->wfs_fonts["FontFondryName"][$i].'</u> | <u>'.$this->wfs_fonts["FontLanguage"][$i].'</u>'.$this->wfs_fonts["FontSize"][$i].'
                                       </div>
                                       </div></td>
									   <td><input type="checkbox" name="frontend['.$i.']" value="1" '.$checkedFront .'></td>
									    <td><input type="checkbox" name="backend['.$i.']" value="1" '.$checkedBack .'><input  type="hidden"  name="fontlist['.$i.']" value="'.$this->wfs_fonts["FontName"][$i].'--'.$this->wfs_fonts["FontCSSName"][$i].';"></td>
									   </tr>';
                                              } //end of for loop
                          	 	} else{
                               		 echo ' <tr><td colspan="3"><div class="font_sep odd" style="text-align:center;"> No fonts available </div></td></tr>';
                            		} ?>
                            </tbody>
                            <tfoot>
                            <tr>
                                <td style="height:40px" colspan="3">
                                <div class="pagination" id="fonts_pagination_div">
                                <?php 
								$totalRecord = $this->wfs_fonts['TotalRecords'];
                                $pageStart = $this->wfs_fonts['PageStart'];
                                $pageLimit = $this->wfs_fonts['PageLimit'];
                                if($totalRecord!=0 && $pageLimit!="" && count($this->wfs_fonts["FontName"])!=0){
                                	$wfs_pg = new wfs_pagination($totalRecord,$pageStart,$pageLimit,'wfs_fonts_div','fonts_pagination_div',"index.php?option=com_webfonts&controller=webfontsconfigure&task=fonts_list_ajax");
                                    echo $wfs_pg->getPagination();
                                
                                }
                                ?> 
                                </div>
                                <div class="clear wfs_row" style="margin-top:10px;">
                        <div class="left">
                            <span class="b_outer" style="margin-top:-2px;"><span class="b_inner">
                            <input type="button" class="b_style" id="save" value="Save Editor Fonts" onclick="javascript: submitbutton('save_editor')" />
                            </span></span>
                        </div>
                    </div>
                                </td>
                            </tr>
                            </tfoot>  
                            </table>
                            </div>
							<div class="clr"></div>
                        </div>
                        <div class="b">
                            <div class="b">
                                <div class="b"></div>
                            </div>
                        </div>	
                    </div>
                </div>
                <div class="wfs_tab">
                     <div id="element-box">
                        <div class="t">
                            <div class="t">
                                <div class="t"></div>
                            </div>
                        </div>
                        <div class="m">
                      		 <div class="wfs_existing_main_div">
							<table class="adminlist" style="color:#000; border-spacing:0"cellpadding="0" width="100%" cellspacing="0">
								<thead>
								<tr>
								<th style="text-align:left; \ width:90%"  > <?php echo JText::_( 'Joomla Existing Selectors' ); ?></th>
								 <th style="text-align:left; width:140px;width /*\**/: 100px\9" > <?php echo JText::_( 'Option' ); ?></th>
									</tr>		
								</thead>	
                                <tbody id="wfs_jselectors_div">
								<tr  >		
                                <td colspan="2" valign="top" style="padding:0"><div style="overflow-y:auto;overflow-x:hidden;height:250px;">	
                                <table cellpadding="0" width="100%" cellspacing="0" class="adminlist">
                                
                                			
								 <?php 
									//$JSelectors = getCurrentTemplateStyles();
									$JSelectors = $this->wfs_joomla_selectors;
									if(!empty($JSelectors)){
										$i = 1;
										foreach($JSelectors as $selector){
											if(($i%2)==0){$class = "even";}else{$class = "odd";}
												$link = in_array($selector, $this->wfs_current_selectors)?'Added to webfonts':'<a href="javascript:;" id="'.$selector.'" onclick="addJoomlaSelector(\''.$selector.'\','.$i.')" >Add to webfonts</a>';
												echo '<tr class="'.$class.'"><td width="90%">'.$selector.'</td>';
												echo ' <td id="existing_added'.$i.'" style="width:150px">'.$link.'</td>
												</td></tr>';
												$i++;
										}
									}else{
										echo '<tr><td colspan="2" style="text-align:center"> No selector available.</td></tr>';
										}
								?>
                                 
                                
                                </table>
                               </div>
                                </td>
                                </tr>
								</tbody>
								</table>
                       </div>
                            <div class="clr"></div>
                        </div>
                        <div class="b">
                            <div class="b">
                                <div class="b"></div>
                            </div>
                        </div>	
                    </div>
                </div>
            </div>
             <?php endRoundDiv(); ?>
   
    </div>
	<!-- End of Work on style sheet Tab -->
    
</div>
</form>     
        


/****
Copyright 2010 Monotype Imaging Inc.  
This program is distributed under the terms of the GNU General Public License
****/

jQuery(document).ready(function(){
	/*Toggle of import projects*/
	jQuery('#wfs_hidediv').click(function(){	
		jQuery('.wfs_hiddendiv').toggle('fast', function(){
			if(jQuery('#wfs_hidediv').attr('class') == ''){
				jQuery('#wfs_hidediv').addClass('wfs_expanded');
			}else{
				jQuery('#wfs_hidediv').removeClass('wfs_expanded');	
			}
		
		});	
	});	
	/*Show/hide for api key textfield*/
	jQuery("#wfs_token_status").click(function(){
		if(jQuery("#wfs_token_status:checked").length == 1){											   
			jQuery("#token_div").show();
		}else{
			jQuery("#token_div").hide();
			}
		});
	
	/*Checking all the checkboxes for import project*/
	jQuery("#imp_prj_main").click(function(){
		if(jQuery("#imp_prj_main:checked").length != 0){
			jQuery(".imp_prj_checkboxes").attr("checked",true);
		}else{
			jQuery(".imp_prj_checkboxes").removeAttr("checked");
			}
	});
	
	/*Import project valdation*/
	jQuery("#imp_prj_btn").click(function(){
		if(jQuery(".imp_prj_checkboxes:checked").length == 0){
			alert("Please select the project(s) to import.");
			return false;
		}else{
			submitbutton('add');
			}
	});
	
	/*Ajax request for refresh list of project*/
	jQuery("#refresh-list").click(function(){
		var old_value =  jQuery('#imp_project_div').html();
		jQuery('.wfs_hiddendiv').addClass('relativePos');
		jQuery('.wfs_hiddendiv').children().css('opacity',0.3);
		jQuery('.wfs_hiddendiv').prepend('<div class="wfs_loading_image"></div>');
		var pageLimit = jQuery("#prj_page_limit").val();
		var pageStart = jQuery("#prj_page_start").val();;
		var totalRecords = jQuery("#prj_total_record").val();
		var randVal = randomString();
		jQuery.ajax({
   			url: "index.php?option=com_webfonts&controller=webfontsproject&task=project_list_ajax&rand="+randVal,
			dataType:'json',
			data: {pageLimit:pageLimit,pageStart:pageStart,totalRecords:totalRecords,currentpage:0,contentDiv:"imp_project_div",paginationDiv:"project_pagination_div"},
			success: function(msg){
				if(msg){
					jQuery('#imp_project_div').hide().html(msg.data).show();
					jQuery('#project_pagination_div').html(msg.pagination);
					jQuery('.wfs_hiddendiv').children().css('opacity',1);
					jQuery('.wfs_loading_image').detach();
					jQuery('.wfs_hiddendiv').removeClass('relativePos');
				}else{
					jQuery('#imp_project_div').html(old_value);
					jQuery('.wfs_hiddendiv').children().css('opacity',1);
					jQuery('.wfs_loading_image').detach();
					jQuery('.wfs_hiddendiv').removeClass('relativePos');
				}
   			},
			error: function (xhr, ajaxOptions, thrownError){
				alert(xhr.status);
				alert(thrownError);
            }
 		});
		return false;
	});
	/*tab javascript*/
	jQuery('ul.wfs_tabNav2 a').click(function() {
															 
		var curChildIndex = jQuery(this).parent().prevAll().length + 1;
		jQuery(this).parent().parent().children('.wfs_current').removeClass('wfs_current');
		jQuery(this).parent().addClass('wfs_current');
		if(this.id == 'main_tab'){
		jQuery(this).parent().parent().parent().parent().next().children().children().hide().parent().children('div:nth-child('+curChildIndex+')').show();}else{
		jQuery(this).parent().parent().parent().parent().next().children().hide().parent().children('div:nth-child('+curChildIndex+')').show();
		}
		/*jQuery.cookie("wfstabindex", this.id);*/
	return false;        
});
	/*sample editor javascript*/
	jQuery('#editor_sample').click(function(){
		if(jQuery('#editor_sample').text() == "See online editor with webfonts"){
			jQuery('#wfs_display_editor').show();
			jQuery('#editor_sample').text("Hide online editor") 
			}else{
				jQuery('#editor_sample').text("See online editor with webfonts") 
				jQuery('#wfs_display_editor').hide();
				}
		
	});
	
	/*Display day validatoan*/
	 jQuery('#edit-days').blur(function(e){
			var wfsdd = jQuery("input[name=days]").val();
			wfsdd = wfsdd.replace(/\d/g, "");
			wfsdd = wfsdd.replace(/-/g, "");
			wfsdd = wfsdd.replace(/,/g, "");
			wfsdd = wfsdd.replace(/ /g, "");
			if (wfsdd!='') {
				alert("Invalid display day");
				setTimeout(function(){jQuery("#edit-days").focus();jQuery("#edit-days").select();}, 10);
				
		}
		return false;
	 });
	
	/*Add selector*/
	jQuery("#add_selector_btn").click(function(){
	selectorname = jQuery('#add_selector_text').val();
	if(jQuery('#add_selector_text').val() == "")
			{
				jQuery('#wfsMsg').parent().parent().addClass('error');
				jQuery('#wfsMsg').html('Please enter the selector name.');
				jQuery('#wfs_message').hide().slideDown(700).show();
				setTimeout("jQuery('#wfs_message').slideUp(1000)", 5000);
				setTimeout("jQuery('#wfsMsg').parent().parent().removeClass('error')", 6000);
				return false;
			}
	addSelectors(selectorname)
	return false;
	});
	jQuery('#add_selector_text').keypress(function(e) {
	if(e.keyCode == 13)
		{
			selectorname = jQuery('#add_selector_text').val();
			if(jQuery('#add_selector_text').val() == "")
			{
				jQuery('#wfsMsg').parent().parent().addClass('error');
				jQuery('#wfsMsg').html('Please enter the selector name.');
				jQuery('#wfs_message').hide().slideDown(700).show();
				setTimeout("jQuery('#wfs_message').slideUp(1000)", 5000);
				setTimeout("jQuery('#wfsMsg').parent().parent().removeClass('error')", 6000);
				return false;
			}
			addSelectors(selectorname)
			return false;
		}
	});
	
	
		/*Add selector*/
	jQuery("#add_domain_btn").click(function(){
	domainName = jQuery('#txtdomainname').val();
	if(jQuery('#txtdomainname').val() == "")
			{
				jQuery('#wfsMsg').parent().parent().addClass('error');
				jQuery('#wfsMsg').html('Please enter the domain name.');
				jQuery('#wfs_message').hide().slideDown(700).show();
				setTimeout("jQuery('#wfs_message').slideUp(1000)", 5000);
				setTimeout("jQuery('#wfsMsg').parent().parent().removeClass('error')", 6000);
				return false;
			}
	addDomain(domainName)
	return false;
	});
	
	jQuery('#txtdomainname').keypress(function(e) {
	if(e.keyCode == 13)
		{
			domainName = jQuery('#txtdomainname').val();
			if(jQuery('#txtdomainname').val() == "")
			{
				jQuery('#wfsMsg').parent().parent().addClass('error');
				jQuery('#wfsMsg').html('Please enter the domain name.');
				jQuery('#wfs_message').hide().slideDown(700).show();
				setTimeout("jQuery('#wfs_message').slideUp(1000)", 5000);
				setTimeout("jQuery('#wfsMsg').parent().parent().removeClass('error')", 6000);
				return false;
			}
			addDomain(domainName)
			return false;
		}
	});
	
	setTimeout("jQuery('#system-message').slideUp(1000);", 5000);
	
initBinding();	
});

function addSelectors(selectorname){
		var old_value =  jQuery('#wfs_selectors_div').html();
		jQuery('.wfs_selectors_main_div').addClass('relativePos');
		jQuery('.wfs_selectors_main_div').children().css('opacity',0.3);
		jQuery('.wfs_selectors_main_div').prepend('<div class="wfs_loading_image"></div>');
		var project_key = jQuery('#project_key').val();
		var randVal = randomString();
		jQuery.ajax({
   			url: 'index.php?option=com_webfonts&controller=webfontsconfigure&task=selector_add_ajax&rand='+randVal,
			dataType:'json',
			type: "POST",
			data: {currentpage:0,contentDiv:"wfs_selectors_div",paginationDiv:"selectors_pagination_div",project_key:project_key,selectorname:selectorname},
			success: function(msg){
			if(msg.data == "DuplicateSelectorName"){
					jQuery('html, body').animate({scrollTop:0}, 'fast');	
					jQuery('#wfsMsg').parent().parent().addClass('error');
					jQuery('#wfsMsg').html('Selector name already exists');
					jQuery('#wfs_message').hide().slideDown(700).show();
					setTimeout("jQuery('#wfs_message').slideUp(1000)", 5000);
					setTimeout("jQuery('#wfsMsg').parent().parent().removeClass('error')", 6000);
					jQuery('#wfs_selectors_div').html(old_value);
					jQuery('.wfs_selectors_main_div').children().css('opacity',1);
					jQuery('.wfs_loading_image').detach();
					jQuery('.wfs_selectors_main_div').removeClass('relativePos');
					return false;
					}
				else{
					jQuery('html, body').animate({scrollTop:0}, 'fast');	
					jQuery('#wfsMsg').html('Selector added successfully.')
					jQuery('#wfs_message').hide().slideDown(700).show();
					setTimeout("jQuery('#wfs_message').slideUp(1000)", 5000);
					jQuery('#wfs_selectors_div').html(msg.data);
					if(msg.pagination){
						jQuery('#selectors_pagination_div').html(msg.pagination);	
						jQuery('.wfs_selectors_main_div').children().css('opacity',1);
						jQuery('.wfs_loading_image').detach();
						jQuery('.wfs_selectors_main_div').removeClass('relativePos');
					}
				}
				initBinding();
   			},
			error: function (xhr, ajaxOptions, thrownError){
				alert(xhr.status);
				alert(thrownError);
            }
 		});
	  return false;
	}
	
function addDomain(domainname){
		var old_value =  jQuery('#wfs_domains_div').html();
		jQuery('.wfs_domain_main_div').addClass('relativePos');
		jQuery('.wfs_domain_main_div').children().css('opacity',0.3);
		jQuery('.wfs_domain_main_div').prepend('<div class="wfs_loading_image"></div>');
		var project_id = jQuery('#project_id').val();
		var project_key = jQuery('#project_key').val();
		var randVal = randomString();
		jQuery.ajax({
   			url: 'index.php?option=com_webfonts&controller=webfontsconfigure&task=addDomain&rand='+randVal,
			dataType:'json',
			type: "POST",
			data: {currentpage:0,contentDiv:"wfs_domains_div",paginationDiv:"domain_pagination_div",project_key:project_key,domainname:domainname,project_id:project_id},
			success: function(msg){
			if(msg.data == '<td colspan="5" style="text-align:center">Duplicate domainname. Please reload the page.</td>'){
					jQuery('html, body').animate({scrollTop:0}, 'fast');	
					jQuery('#wfsMsg').parent().parent().addClass('error');
					jQuery('#wfsMsg').html('Domain name already exists');
					jQuery('#wfs_message').hide().slideDown(700).show();
					setTimeout("jQuery('#wfs_message').slideUp(1000)", 5000);
					setTimeout("jQuery('#wfsMsg').parent().parent().removeClass('error')", 6000);
					jQuery('#wfs_domains_div').html(old_value);
					jQuery('.wfs_domain_main_div').children().css('opacity',1);
					jQuery('.wfs_loading_image').detach();
					jQuery('.wfs_domain_main_div').removeClass('relativePos');
					return false;
					
					}
				else{
					jQuery('html, body').animate({scrollTop:0}, 'fast');	
					jQuery('#wfsMsg').html('Domain added successfully.')
					jQuery('#wfs_message').hide().slideDown(700).show();
					setTimeout("jQuery('#wfs_message').slideUp(1000)", 5000);
					jQuery('#wfs_domains_div').html(msg.data);
					if(msg.pagination){
						jQuery('#domain_pagination_div').html(msg.pagination);	
						jQuery('.wfs_domain_main_div').children().css('opacity',1);
						jQuery('.wfs_loading_image').detach();
						jQuery('.wfs_domain_main_div').removeClass('relativePos');
					}
				}
				initBinding();
   			},
			error: function (xhr, ajaxOptions, thrownError){
				alert(xhr.status);
				alert(thrownError);
				return false;
            }
 		});
		
	 
	  return true;
	}	

/*pagination function*/
function ajaxPage(currPage,pageStart,pageLimit,totalRecords,contentDiv,paginationDiv,url){
	/*alert(currPage+" || "+pageStart+" || "+pageLimit+" || "+totalRecords+" || "+contentDiv+" || "+paginationDiv+" || "+url);*/
	var pid ="";
	var loadingdiv;
	var old_value =  jQuery('#'+contentDiv).html();							
	if(jQuery('#project_key').val()!=""){
		pid= jQuery('#project_key').val();
	}
	if(contentDiv=='imp_project_div'){
		loadingdiv = 'wfs_hiddendiv';
		}
	if(contentDiv=='wfs_fonts_div'){
		loadingdiv = 'wfs_fonts_main_div';
	}
	if(contentDiv=='wfs_selectors_div'){
		loadingdiv = 'wfs_selectors_main_div';
	}
	if(contentDiv=='wfs_domains_div'){
		loadingdiv = 'wfs_domain_main_div';
	}
	if(loadingdiv != ""){
		jQuery('.'+loadingdiv).addClass('relativePos');
		jQuery('.'+loadingdiv).children().css('opacity',0.3);
		jQuery('.'+loadingdiv).prepend('<div class="wfs_loading_image"></div>');
		}
	var randVal = randomString();	
	jQuery.ajax({
   			url: url+'&rand='+randVal,
			dataType:'json',
			data: {pageLimit:pageLimit,pageStart:pageStart,totalRecords:totalRecords,currentpage:currPage,contentDiv:contentDiv,paginationDiv:paginationDiv,pid:pid},
			success: function(msg){
				if(msg){
					jQuery('#'+contentDiv).hide().html(msg.data).show();
					jQuery('#'+paginationDiv).html(msg.pagination);
					jQuery('.'+loadingdiv).children().css('opacity',1);
					jQuery('.wfs_loading_image').detach();
					jQuery('.'+loadingdiv).removeClass('relativePos');
					if(contentDiv=='wfs_selectors_div'){
						initBinding();
					}
				}else{
					jQuery('#'+contentDiv).html(old_value);
					jQuery('.'+loadingdiv).children().css('opacity',1);
					jQuery('.wfs_loading_image').detach();
					if(contentDiv=='wfs_selectors_div'){
						initBinding();
					}
				}
   			},
			error: function (xhr, ajaxOptions, thrownError){
				alert(xhr.status);
				alert(thrownError);
            }
 		});
		return false;
}

function allselections() {
 var e = document.getElementById('selections');
e.disabled = true;
 var i = 0;
 var n = e.options.length;
	for (i = 0; i < n; i++) {
	 e.options[i].selected = true;
	 e.options[i].selected = true;
	}
}

function enableselections() {
var e = document.getElementById('selections');
	e.disabled = false;
var i = 0;
var n = e.options.length;
for (i = 0; i < n; i++) {
	e.options[i].disabled = false;
}
}
function initBinding(){
	
		jQuery(".fonts-list").change(function(){
			var fontcssid = this.id;
				var fontid = fontcssid.split("@");
				var fontarr = this.value;
				var fontdata = fontarr.split("@!");
				if(fontdata == -1)
				{
				jQuery("#fontid_"+fontid[1]).text('');
				}
				else{
				//jQuery("#fontid_"+fontid[1]).css("font-family","'"+fontdata[0]+"'");
				jQuery("#fontid_"+fontid[1]).css("cssText","font-family:'"+fontdata[0]+"' !important; font-size: 26px;");
				jQuery("#fontid_"+fontid[1]).text(fontdata[1]);
				}
			});	
		}

function submitbuttonDelete(selectorid){
	if(confirm('Are you sure want to delete selector?')){
		jQuery('#selector_delete').val(selectorid)
		submitbutton('remove_selector');
		return false;
	}
	}

function submitbuttonDomainDelete(domainid){
	if(confirm('Are you sure want to delete domain?')){
		jQuery('#domain_delete').val(domainid);
		submitbutton('remove_domain');
		return false;
	}
	}
	
function addJoomlaSelector(selectorname,count){
	addSelectors(selectorname);
	jQuery('#existing_added'+count).html('Added to webfonts');
	
	return false;
}	

function randomString() {
	var chars = "0123456789ABCDEFGHIJKLMNOPQRSTUVWXTZabcdefghiklmnopqrstuvwxyz";
	var string_length = 8;
	var randomstring = '';
	for (var i=0; i<string_length; i++) {
		var rnum = Math.floor(Math.random() * chars.length);
		randomstring += chars.substring(rnum,rnum+1);
	}
	return randomstring;
}

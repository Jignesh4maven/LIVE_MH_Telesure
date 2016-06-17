var page_param = paramobj(window.location.href);
var msgtype = {"Success":"success","Warning":'warning',"Info":"info","Error":"error"};
var debugmod = 1;
var tmp = '';
var resLocalStorage = {};
var localStorageKeys={};
localStorageKeys=new Array();
var loading_img = '<div class="ajax-loader"><img src="https://www.motorhappy.co.za/wp-content/themes/motorhappy-roots-theme/assets/img/loader-cog.gif" class="" alt="Loading..." /></div>';
resLocalStorage.getItem = function(key) {
    return new MyItem(JSON.parse(localStorage.getItem(key)));
};

resLocalStorage.getItemObject = function(key) {
    return JSON.parse(localStorage.getItem(key));
};

resLocalStorage.setItem = function(key, object) {	
    localStorage.setItem(key, JSON.stringify(object));
    return this.getItem(key);
};

resLocalStorage.removeItem = function(key) {
   localStorage.removeItem(key);
};

resLocalStorage.setUniqueItem = function(key, value) {
    localStorage.setItem(key, value);
	//alert(localStorage.getItem(key));
};
resLocalStorage.getUniqueItem = function(key) {
    return localStorage.getItem(key);
};

function MyItem(object, key) {
    this.item = object;
    this.key = key;
    this.addSubItem = function(subItem) {
        if (typeof this.item.push == 'function') {
            this.item.push(subItem);
           // this.save();
            return this;
        }
        return false;
    };
    this.setItem = function(object) {
        this.item = object;
        //this.save();
        return this;
    };
    this.save = function() {
        resLocalStorage.setItem(this.key, this.item);
    };
    this.toString = function() {
        return this.item.toString();
    }
}


if(jQuery(".integer")){
    jQuery(".integer").keydown(fun_Integer);
    jQuery(".integer").focusout(fun_Integer_keyup);
}

function fun_decimal(event){
    var regex = /^[\w]+(\.[\w]+)*@([\w-]+\.)+[a-zA-Z]{2,7}$/ ;
    //console.log('keydown');
    //jQuery(this).select();
    if (event.keyCode==110 || event.keyCode==190) {
        if(jQuery(this)[0].nodeName == "INPUT")
        {
            if(jQuery(this).val().indexOf('.')==-1)
            {
                if(jQuery(this).val().trim()=='')
                {
                    jQuery(this).val('0');
                }
                return true;
            }
        }
        /*else if(jQuery(this)[0].nodeName == "SPAN")
         {
         if(jQuery(this).text().indexOf('.')==-1)
         {
         if(jQuery(this).text().trim()=='')
         {
         jQuery(this).text('0');
         }
         return true;
         }
         }*/
    }
    if ((event.keyCode >= 48 & event.keyCode <= 57) || (event.keyCode >= 96 & event.keyCode <= 105)) {
        return true;
    }
    if (event.keyCode >= 37 & event.keyCode <= 40) {
        return true;
    }
    if (event.keyCode == 8 || event.keyCode == 9 || event.keyCode == 46) {
        return true;
    }
    return false;
}
function fun_Integer(event){
    if ((event.keyCode >= 48 & event.keyCode <= 57) || (event.keyCode >= 96 & event.keyCode <= 105)) {
        return true;
    }
    if (event.keyCode >= 37 & event.keyCode <= 40) {
        if (event.keyCode == 38 )
        {
            if(parseInt(jQuery(this).val()) > 0)
            {
                jQuery(this).val(parseInt(jQuery(this).val())-1);
            }
        }
        if (event.keyCode == 40 )
        {
            if(parseInt(jQuery(this).val()) < 1000)
            {
                jQuery(this).val(parseInt(jQuery(this).val())+1);
            }
        }
        return true;
    }
    if (event.keyCode == 8 || event.keyCode == 9 || event.keyCode == 46) {
        return true;
    }
    return false;
}
var fun_Integer_keyup = function()
{
    //Nna = parseInt(jQuery(this).val());
    Nna = jQuery(this).val();
    if(isNaN(Nna))
    {
        jQuery(this).val('');
    }
    else{
        jQuery(this).val(Nna);
    }
}



var fun_Decimal_keyup = function()
{
    //console.log('fun_Decimal_keyup');
    /*if(jQuery(this)[0].nodeName == "INPUT")
     {*/
    Nna = parseFloat(jQuery(this).val())	;
    if(isNaN(Nna))
    {
        jQuery(this).val('');
    }
    else{
        jQuery(this).val(Nna);
    }
    /*	}*/
    /*elseif(jQuery(this)[0].nodeName == "SPAN")
     {
     Nna = parseFloat(jQuery(this).text())	;
     if(isNaN(Nna))
     {
     jQuery(this).text('');
     }
     else{
     jQuery(this).text(Nna);
     }
     }*/
}

Object.size = function(obj) {

var size = 0, key;

	for (key in obj) {
    
		if (obj.hasOwnProperty(key)) size++;
    
	}
	
    return size;
};

/*
 *  VJ : Append 'http_path' in ajax url param in order to make call the pages as per the steps performed on front.
 *  Changed on : 2016-03-28
 */
function trigger_form(frmobj){
	//console.log(frmobj);
try{
    var frm_param = {}
    
    if($("#"+frmobj.frm).attr('data-before')){
	
		var before_func = eval($("#"+frmobj.frm).attr('data-before'));

        //console.log(before_func);
        
		if(before_func === false){

				return false;
				
		}
		if(typeof(before_func) == "function"){
			 
			var t = before_func.apply()
			
			//console.log(t);
			
			if(t === false){
				
				return false;
				
			}
			
		}

	}


	$("#"+frmobj.frm+" .ajx-control").each(function(){

		if($(this).attr('type') == "radio"){
			
			var radio_val =  '';
			
			if($("input[name='"+$(this).attr('name')+"']:checked").val()){
				
				radio_val = $("input[name='"+$(this).attr('name')+"']:checked").val();
			}
			
			frm_param[$(this).attr('name')] = radio_val;
			
		}
		else if($(this).attr('type') == "checkbox" ){
			
			frm_param[$(this).attr('name')] = $(this).is(":checked");
			
		}
		else{
			
			frm_param[$(this).attr('name')] = $(this).val();
			
		}

	});

	var form_action = $("#"+frmobj.frm).attr('action');
	
	var form_method = "post";
	
	if($("#"+frmobj.frm).attr('method')){
		
		if($("#"+frmobj.frm).attr('method') != ""){
			
		form_method = $("#"+frmobj.frm).attr('method');
		
		}
	
	}


		var ajx_param = {"url":http_path+'/'+form_action,
						"sync":"false",
						"method":form_method,
						"frm":frmobj.frm,
						"data":frm_param};
						
						if( typeof(frmobj.ajxcallback) === "function"){
							ajx_param["ajxcallback"] = frmobj.ajxcallback;
						}
						call_ajax(ajx_param);
  }
  catch(e){
			alert("trigger_form:"+e);
	}
}

//{"url":url,'sync':'false','method','post','data':data,ajxcallback:function(resdata) {}}
function call_ajax(ajxparam){

	var result = 0;
 
	$.ajax({
			url: ajxparam.url,
			
			async: ajxparam.sync,
			
			cache: false,
			
			context: document.body, 
			
			type: ajxparam.method,
			
			data: ajxparam.data,
			
			success: function(data){
 
				try{
					
					if(data != ""){
                        
                        if(typeof(data) == "object"){
                            
                            result = data;
                        }
                        else{
                            
                            result = JSON.parse(data);
                        }
						

                        if(result){

                            if(result['resultStatus']){

                                if(ajxparam.frm){
                                    
                                        if($("#"+ajxparam.frm).attr('data-after')){
                                            
                                                responsed_data = result;
                                                
                                                var after_func = eval($("#"+ajxparam.frm).attr('data-after'));
                                                
                                                if(typeof(after_func) == "function"){
                
                                                        after_func.apply();
                                                        
                                                }

                                        }	
                                        
                                }
                                if(ajxparam.ajxcallback){

                                    ajxparam.ajxcallback(result);
                                
                                }
                                 
                            }	
                        }
					
				}	
			} 
			catch(e){
                hideLoading();
				console.log("error:"+ajxparam.url+":"+e);
					}
			}
	}); 
return result;
}

(function(jQuery){
    
	var aTmplCache = {}; 
	
	var aTmplMethods = {
		loadTmpl : function( tmpl ) {
			
			var arr=tmpl.replace(/'/g,"\\'").replace(/[\r\t\n]/g, "").split("<@").join("@>").split("@>");
			var str="var retval='';with(obj){";
			for(ele in arr)
			{
				
				switch(arr[ele].charAt(0))
				{
					
					case "%" : str+=arr[ele].replace(/%(.*?)%/g,"$1"); break;
					case "=" : str+="retval+="+arr[ele].replace(/=(.*?)$/g,"$1")+";"; break;
					case "#" : str+=arr[ele].replace(/#(.*?)$/g,"$1"); break;
					case "" : break;
					default: str+="retval+='"+arr[ele]+"';";
				}
			}
			str+="}; return retval;";
			//console.log(str);
			return new Function("obj,idx",str);
		},
		renderTmpl : function(tmpl,data) {
			var fn=null;
			var dom='';
			var rowcnt=0;
			
			data=(Object.prototype.toString.call(data)!=="[object Array]")?[data]:data;
			
			if(!aTmplCache[tmpl])
				aTmplCache[tmpl]=this.loadTmpl(jQuery("script[data-tmpl='"+tmpl+"']").html());
				
			fn = aTmplCache[tmpl];
				
			for(row in data) 
			{
				dom+=fn(data[row],rowcnt++);
			}
			
			return dom;
		}
  	};
	
	jQuery.fn.jTmpl = function aTmpl(tmpl,data,method){
		switch(method)
		{
			case 'html':
				this.html(aTmplMethods.renderTmpl(tmpl,data));
				break;
			case 'append':
				this.append(aTmplMethods.renderTmpl(tmpl,data));
				break;
			case 'replace':
				this.replaceWith(aTmplMethods.renderTmpl(tmpl,data));
				break;
			default:
				this.html(aTmplMethods.renderTmpl(tmpl,data));
		}
  	};
})(jQuery);

function tab_next(tabid){

  if( $("#"+tabid+" li.active").next('li').find('a').length > 0 ){

    $("#"+tabid+" li.active").next('li').find('a').click()

  }
  
  return ;
  
}


/* Function Name : fromdata_to_string
   Definition: convert from list data to sting and give you sting by given row and column separator
   Options: dataobj = {'data-container':Form ID,'row-class':Optional,'data-input':'#validity_string',
			"data-item-separator":Optional,data-row-separator:Optional,
			data-el-classes:['.from','.to']}
*/

function formdata_to_sting(form_data){
	var data = {};
	data.item_saparator = "@";
	data.row_saparator = ";";
	data.el_lists = new Array();
	data.ignore_empty = false;
	data.check_hash = "";
	var error_types = {"100":"100","101":"101","102":"102","103":"103"};
	
	if(form_data){
		
		if(form_data["data-container"]){
		  
		  if (jQuery(form_data["data-container"]).length > 0) {
			  
			  data.container = form_data["data-container"];
			  
		  }
				  
		}
	  
		if(form_data["row-class"]){
		  
		  if (jQuery(form_data["row-class"]).length > 0) {
			  
			  data.rowclass = form_data["row-class"];
			  
		  }
			  
		}
	  
		if(form_data["data-input"]){
		  
		  if (jQuery(form_data["data-input"]).length > 0) {
			  
			  data.input = form_data["data-input"];
			  
		  }
				  
		}
	  
		
		if (form_data["data-item-separator"]) {
		  data.item_saparator = form_data["data-item-separator"];
		}
		
		
		if (form_data["data-row-separator"]) {
		  data.row_saparator = form_data["data-row-separator"];
		}
		
		if (form_data["ignore-empty"]) {
			if (form_data["ignore-empty"] == "yes") {
				data.ignore_empty = true;
			}
		}
	  
		if (form_data["data-check-hash"]) {
			if (form_data["data-check-hash"] != "") {
				data.check_hash = form_data["data-check-hash"];
			}
		}
		if (form_data["data-el-lists"]) {
			if (form_data["data-el-lists"].length > 0) {
				data.el_lists = form_data["data-el-lists"];
			}
			else{
				alert("formdata_to_sting:"+error_types[100]);
				return false;
			}
		  
		}
		else{
		  alert("formdata_to_sting:"+error_types[100]);
		}
	}
	
	jQuery(data.input).val('');
	
    var string = new Array();

	var tmp_row_val = new Array();

    jQuery(data.container+" "+data.rowclass).each(function(){
      
    	tmp_cols = new Array();
		
		var has_empty = false;
		if(data.check_hash !=""){
            
	            /*if(jQuery(this).find(data.check_hash).length == 0 ){
                
	                 return true;
	            }*/
                if( ! jQuery(jQuery(this).find("input.icheckbox_minimal")).is(":checked")){
                    
                    return true;
                }
                   
                
        	}
		for(el_idx = 0; el_idx < data["el_lists"].length; el_idx++){
			
			var el_val = "";
		
			if( jQuery(this).find(data["el_lists"][el_idx]) ){
				
				if(jQuery(this).find(data["el_lists"][el_idx]).val() != ""){
					
					el_val = jQuery(this).find(data["el_lists"][el_idx]).val();
					
				}
				else{
					has_empty = true;
				}				
				
			}
			else{
					has_empty = true;
			}
			
			tmp_cols.push(el_val);
		}
      
		if(has_empty == true &&  data.ignore_empty == true){
			// ignore emplty
		}
		else{
			tmp_row_val.push(tmp_cols.join(data.item_saparator));
		}
		
    });
	 
    if(tmp_row_val.length > 0){
        jQuery(data.input).val(tmp_row_val.join(data.row_saparator));
    }
}

//<!-- Modal -->
//modal_params = {'id':'myModal','class':'myClass',iframe:"","content":"","title":"sample Modal",width:100px,height:100px,buttons:["SAVE","CANCEL"]};
function open_modal(modal_params){
  
    var customModal = [];
    var title = frame = content =  id = width = height = modal_dialog_size = "";
    var zindex = 1500;
    if ( typeof(modal_params.zindex) != "undefined") {
        zindex = modal_params.zindex;
    }
    if ( typeof(modal_params.title) != "undefined") {
        title = modal_params.title;
    }
    
    if ( typeof(modal_params.iframe) != "undefined") {
        frame = modal_params.iframe;
    }
    if ( typeof(modal_params.width) != "undefined") {
        width = modal_params.width;
    }
    if ( typeof(modal_params.height) != "undefined") {
        height = modal_params.height;
    }
    
    if ( typeof(modal_params.content) != "undefined") {
        content = modal_params.content;
    }
    
    if ( typeof(modal_params.modal_dialog_size) != "undefined") {
        modal_dialog_size = modal_params.modal_dialog_size;
    }
    
    if ( typeof(modal_params.id) != "undefined") {
        id = modal_params.id;
    }
    else{
        alerT("modal id is require");
        return false;
    }
    
    customModal.push('<div id="modal_'+id+'" class="modal fade" role="dialog" style="z-index:'+zindex+'">');
      customModal.push('<div class="modal-dialog '+modal_dialog_size+'">');
        //<!-- Modal content-->
         if (frame != "") {
            customModal.push('<div class="modal-content">');   
         }
         else{
            customModal.push('<div class="modal-content" style="height:'+height+'">');
            
         }
         
          customModal.push('<div class="modal-header">');
            customModal.push('<button type="button" class="close" data-dismiss="modal">&times;</button>');
            customModal.push('<h4 class="modal-title">'+title+'</h4>');
          customModal.push('</div>');
          customModal.push('<div class="modal-body">');
         
            if (frame != "") {
              
                 customModal.push('<iframe id="frame_'+id+'" name="frame_'+id+'"  src="'+frame+'" width="'+width+'" height="'+height+'" frameborder="0" allowtransparency="true"></iframe>');
            }
            else{
                 customModal.push('<p>'+content+'</p>');
            }
          customModal.push('</div>');
          
          if ( typeof(modal_params.buttons) != "undefined" ) {
               var buttons = modal_params.buttons;
               
               if (  Object.size(buttons)> 0  ) {
                customModal.push('<div class="modal-footer">');
               }

               for(btn_type in buttons){

                    if (btn_type == "CANCEL") {
                        customModal.push('<button id="modal_close_'+id+'"  type="button" class="btn btn-default pull-left" data-dismiss="modal">Close</button>');
                    }
                    else if (btn_type == "SAVE") {
                        
                        var on_save_click_event = '';
                        var callback_param  = id;
                        
                        if ( typeof(modal_params.callbacks) != "undefined" ) {
                            
                            if ( typeof(modal_params.callbacks.SAVE) == "function" ) {
                                on_save_click_event = modal_params.callbacks.SAVE;
                            }       
                        }
                        
                        customModal.push('<button type="button" onclick=" func_call ='+modal_params.callbacks.SAVE+'; func_call.apply();" class="btn btn-primary">Save changes</button>');
                    }
                    else{
                        
                        customModal.push(buttons[btn_type]);
                    }
               }
               
               if (  Object.size(buttons) > 0  ) {
                customModal.push('</div>');
               }
          }
          
        customModal.push('</div>');
    
      customModal.push('</div>');
    customModal.push('</div>');
    
    if (jQuery('#modal_'+id+'').length > 0) {
        jQuery("#modal_"+id).modal('hide').remove();
    }
    
    jQuery('body').append(customModal.join(''));
    $('#modal_'+id).modal({

        backdrop: 'static',
        keyboard: false

    });
    jQuery('#modal_'+id).modal('show');
    jQuery('#modal_close_'+id).on('click',function(){
        jQuery("#modal_"+id).modal('hide').remove();
    });
    
  
}

function close_modal(){
    $(".modal-open").css({'padding':0}).removeClass('modal-open');
    $(".modal .close").click();
    jQuery(".modal").modal('hide').remove();
    jQuery(".modal-backdrop").remove();
}

function cleanup_ajax_form(frmobj){
   
    var hidden  =   false;
      if( frmobj['hidden'] ){
    
            if( frmobj['hidden'] == true){
                
                hidden=true;
            }
        
      }
      
      if (hidden==true) {
        
            jQuery("#"+frmobj.frm+" .ajx-control").each(function(){
            jQuery(this).val('');
            });
      }
      else{
            jQuery("#"+frmobj.frm+" .ajx-control[type!='hidden']").each(function(){
            jQuery(this).val('');
            });
      }
}


/*Prepare data-list*/
//{"res":res,"placeid":"placeid","templateid":""};
function set_datalist(dataobj){
    
    try{
        //console.log("set_datalsit");
        //console.log(dataobj);
        
        if( dataobj['res'] ){
    
            if( dataobj['res']['resultData'] ){
    
                var rows = dataobj['res']['resultData']['list'];
                
                var jstmpl = "data-list";
    
                if ( typeof(dataobj.place_id) !=  "undefined"  ) {
                    jstmpl = dataobj.place_id;
                    
                }
                
                if ( typeof(dataobj.template_place_id) !=  "undefined"  ) {
                    jstmpl = dataobj.template_place_id;
                    
                }

                jQuery("#"+jstmpl).html('');
                
                
    
                for(var i = 0; i < rows.length; i++){
   
                    jQuery("#"+jstmpl).jTmpl(dataobj.template_id, rows[i],'append');
    
                }
            }
        }
    }
    catch(e){
        
        alert("set_datalist:"+e);
        
    }

}

/*delete ajax call*/
function delete_page(id,el){
    try{
	
        if( typeof(el) == "object"){
            
            var url = "#";
            
            var opcode = "delete";
            
            var module_name = "";
            
            if( jQuery(el).attr('data-opcode') != "undefined" ){
                
                url = jQuery(el).attr('data-opcode');
                
            }
            
             if( jQuery(el).attr('data-module') != "undefined" ){
                
                module_name = jQuery(el).attr('data-module');
                
            }
            
            if( jQuery(el).attr('data-action') != "undefined" ){
                
                opcode = jQuery(el).attr('data-action');
                
            }
            
            if ( id != "" ) {
                
                var ajx_param = {
                    
                    "url": url,
                    
                    "sync": "false",
                    
                    "method": "POST",
                    
                    "data": { 'opcode':opcode,'page_id': id},
                    
                    "ajxcallback":function(resobj){
                        
                        if ( resobj.resultStatus == "Success" ) {
                            
                            var total_avb_record = resobj.resultData['total'];
                            
                            if ( module_name != "" ) {
                                
                                if( typeof(module_properties) != "undefined" ){
                                    
                                    if(typeof(module_properties[module_name]) != "undefined"){
                                        
                                        var dataobj = {"res":resobj,"place_id":module_properties[module_name]["place_id"],"template_id":module_properties[module_name]["template_id"]};
                                
                                        set_datalist(dataobj);
                                    }
                                    
                                }
                                else{
                                    
                                    var dataobj = {"res":resobj,"place_id":"data-list","template_id":"data-list"};
                                    
                                    set_datalist(dataobj);
                                    
                                }
                                
                            }
                            
                            if ( jQuery('.jPager').length > 0 ) {
                                
                                jQuery('.jPager').jPager({
                                    counts : total_avb_record,
                                    callback: function (objpage) {
                                        get_regord(objpage.pageno,objpage.pagesize);
                                    }
                                });
                            }
                        
                            
                        }
                    }
                };
                
                call_ajax( ajx_param );
            }
            
        }
    } 
    catch(e){
        alert("delete_page"+e);
        
    }
	
}

function delete_row_by_id(id,el){
bootbox.confirm("Are you sure, you want to delete?", function(result) {

if(result == true)
{
    try{
       
        if( typeof(el) == "object"){
            
            var url = "#";
            
            var opcode = "delete";
            
            var module_name = "";
            
            if( jQuery(el).attr('data-opcode') != "undefined" ){
                
                url = jQuery(el).attr('data-opcode');
                
            }
            
             if( jQuery(el).attr('data-module') != "undefined" ){
                
                module_name = jQuery(el).attr('data-module');
                
            }
            
            if( jQuery(el).attr('data-action') != "undefined" ){
                
                opcode = jQuery(el).attr('data-action');
                
            }
            
            if ( id != "" ) {
                 showLoading();
                var ajx_param = {
                    
                    "url": url,
                    
                    "sync": "false",
                    
                    "method": "POST",
                    
                    "data": { 'opcode':opcode,'id': id},
                    
                    "ajxcallback":function(resobj){
                        
                        if ( resobj.resultStatus == "Success" ) {
                            
                            var total_avb_record = resobj.resultData['total'];
                            
                            if ( module_name != "" ) {
                                
                                if( typeof(module_properties) != "undefined" ){
                                    
                                    if(typeof(module_properties[module_name]) != "undefined"){
                                        
                                        var dataobj = {"res":resobj,"place_id":module_properties[module_name]["place_id"],"template_id":module_properties[module_name]["template_id"]};
                                
                                        set_datalist(dataobj);
                                    }
                                    
                                }
                                else{
                                    
                                    if (debugmod) {
                                        console.log("delete_row_by_id : module_properties is undefined");
                                    }
                                    
                                    var dataobj = {"res":resobj,"place_id":"data-list","template_id":"data-list"};
                                    
                                    set_datalist(dataobj);
                                    
                                }
                                
                            }
                            else{
                                if (debugmod) {
                                        console.log("delete_row_by_id : module_name is undefined");
                                }
                            }
                            
                            if ( jQuery('.jPager').length > 0 ) {
                                
                                jQuery('.jPager').jPager({
                                    counts : total_avb_record,
                                    callback: function (objpage) {
                                        smart_get_regord(objpage.pageno,objpage.pagesize);
                                    }
                                });
                            }
                        
                            
                        }
                        
                        hideLoading();
                    }
                };
                
                call_ajax( ajx_param );
            }
            
        }
    } 
    catch(e){
        alert("delete_page"+e);
        
    }
}
});

	
}
/* for search  input controll , id and name should be same*/
function smart_get_regord(page, limit){
	
	if( $("#modulename").length > 0 ){
		var modulename = $("#modulename").attr('data-modulename');
		var action = "#";
		var template_id = "data-list";
		var template_place_id = "data-list";
        var search_controlls = [];
		
		if ( typeof(module_properties[modulename]) != "undefined") {
			
			if ( typeof(module_properties[modulename]["func_data_list_records"]) != "undefined") {
				action = module_properties[modulename]["func_data_list_records"];
			}
            
            if ( typeof(module_properties[modulename]["search_controlls"]) != "undefined") {
				search_controlls = module_properties[modulename]["search_controlls"];
			}
            
			template_id = module_properties[modulename]["template_id"];
			template_place_id = module_properties[modulename]["template_place_id"];
			
		}
        
        var ajx_param_data = {};
        
        ajx_param_data = { page: page, entries_per_page: limit, opcode:action };
        
        for(search_ctr_idx = 0 ; search_ctr_idx< search_controlls.length ; search_ctr_idx++){
            
            var ctrl_id = search_controlls[search_ctr_idx];
            
            if ( jQuery("#"+ctrl_id).length > 0 ) {
                
                if ( jQuery("#"+ctrl_id).val() != "") {
                    
                     ajx_param_data[ctrl_id] = jQuery("#"+ctrl_id).val();
                     
                }
            }
        }
		
        showLoading();
        
		var ajx_param = {	
        "url": modulename,
        "sync": "false",
        "method": "POST",
        "data": ajx_param_data,
        "ajxcallback":function(resobj){
			//console.log("get_regord-ajxcallback");
			var dataobj = {"res":resobj,"template_id":template_id,"template_place_id":template_place_id,"place_id":template_place_id};
                set_datalist(dataobj);
                hideLoading();
				
			}
		};
		call_ajax(ajx_param);
	
	}
	else{
		alert("module name is not defined");
		return false;
	}
    
}

function validate_form(form_object){
    
    
    if ( typeof(form_object.frm) != "undefined" ) {
        
        var frm_name = form_object.frm;

        if ( jQuery("#"+frm_name).length > 0 ) {
            
            jQuery("#"+frm_name).validator("validate");
            
            if(jQuery("#"+frm_name+" .has-error").length > 0 ){
                
                //console.log("--invalid--");
                
                return false;
            }
            else{
                return true;
            }
        }
     
    }
    else{
        alert("Form name is not defined");
    }
    return false;

}


var logger = (function (c) {
    "use strict";
    var m = {
        log: function (a) {
            if (!c) { return; /* return or call your custom function here */ }
            if(debugmod){
                console.log(a);
            }
        }
    };

    return {

        log: function () { m.log(arguments); }
    };
}(window.console))


function showLoading(msg){
    
    if ($("#loading").length >0 ) {
        $("#loading").remove()
    }
    
    var display_msg = "";
    
    if ( typeof(msg) == "undefined" ) {
        display_msg = "";
    }
    else{
        display_msg = msg;
    }
    
    var ico_loading = 	$('<i/>').css({'font-size':'80px',position:'fixed',top:"260px",color:"#E9516C"})
        .addClass('fa fa-spinner fa-spin fa-large');

        
    var loading = $('<div/>').css({"z-index":9999,"text-align":"center","background":"rgba(255,255,255,0.8)",position:"absolute",top:"0px",height:"100%",width:"100%"})
        .addClass('loading-visible')
        .attr('id','loading')
        .html(loading_img);
    	$('body').append(loading);
    
    if ( display_msg != "" ) {
        $(".ajax-loader").append("<h2>"+display_msg+"</h2>");
    }
    
    $(".loading-visible").height($('body').height());
}

function hideLoading(tm){
    setTimeout(function() {
        $('.loading-visible').remove();
    }, tm);
}

//pickerObj = {"dataList":list,"ctrlId":"area_type","key":"Description","val":"Description"};
function fill_selectpicker(pickerObj){
  
  
  var dataList = pickerObj.dataList;
  var option_list = [];
  var dataKey = pickerObj.key;
  var dataVal = pickerObj.val;
  var ctrlId = pickerObj.ctrlId;
  var select_label="Select";
  
  var selected_key = "";
  if (typeof(pickerObj.ctrlId) != "undefined") {
     selected_key = pickerObj.selected;
  }
  
  if (typeof(pickerObj.select_label) != "undefined") {
     select_label = pickerObj.select_label;
  }

  option_list.push("<option value=''>"+select_label+"</option>" );
  
  $("#"+ctrlId).html(option_list.join(''));
  $("#"+ctrlId).selectpicker('refresh');

  if( typeof(dataList) != "undefined" ){
    
    if( dataList.length > 0 ){
      
        for( item_idx = 0; item_idx < dataList.length; item_idx++ ){

            var k = dataList[item_idx][dataKey];

            var v = dataList[item_idx][dataVal];

            if ( v != "" && v != "null" ) {
                
                if (selected_key != "" && selected_key == k) {
                    option_list.push("<option value='"+ k +"' selected>"+ v + "</option>" );
                }
                else{
                    option_list.push("<option value='"+ k +"'>"+ v + "</option>" );
                }
                
            }

        }
    
    }
  
  }
  
 $("#"+ctrlId).html(option_list.join(''));
 $("#"+ctrlId).selectpicker('refresh');
}

function login_popup(args) {
    var title = "Please login or register to continue";
    modal_params = {"id":"login","modal_dialog_size" : "modal-lg",
        "iframe":http_path+"/login?popup",
        "title":title,"width":"100%","height":"575px",
    };
    open_modal(modal_params);
}

function trigger_vehicle_form(frmobj){
	
try{
    var frm_param = {}
    
    if($("#"+frmobj.frm).attr('data-before')){
	
		var before_func = eval($("#"+frmobj.frm).attr('data-before'));

        //console.log(before_func);
        
		if(before_func === false){

				return false;
				
		}
		if(typeof(before_func) == "function"){
			 
			var t = before_func.apply()
			
			//console.log(t);
			
			if(t === false){
				
				return false;
				
			}
			
		}

	}


	$("#"+frmobj.frm+" .ajx-control").each(function(){

		if($(this).attr('type') == "radio"){
			
			var radio_val =  '';
			
			if($("input[name='"+$(this).attr('name')+"']:checked").val()){
				
				radio_val = $("input[name='"+$(this).attr('name')+"']:checked").val();
			}
			
			frm_param[$(this).attr('name')] = radio_val;
			
		}
		else if($(this).attr('type') == "checkbox" ){
			
			frm_param[$(this).attr('name')] = $(this).is(":checked");
			
		}
		else{
			
			frm_param[$(this).attr('name')] = $(this).val();
			
		}

	});

	var form_action = $("#"+frmobj.frm).attr('action');
	
	var form_method = "post";
	
	if($("#"+frmobj.frm).attr('method')){
		
		if($("#"+frmobj.frm).attr('method') != ""){
			
		form_method = $("#"+frmobj.frm).attr('method');
		
		}
	
	}


		var ajx_param = {"url": http_path+form_action,
						"sync":"false",
						"method":form_method,
						"frm":frmobj.frm,
						"data":frm_param};
						
						if( typeof(frmobj.ajxcallback) === "function"){
							ajx_param["ajxcallback"] = frmobj.ajxcallback;
						}
						call_ajax(ajx_param);
  }
  catch(e){
			alert("saveform:"+e);
	}
}

function show_loading_inline(id) {
    
    var element_id = id;

    var circle = '<i style="font-size: 28px; position: fixed; top: 260px; color: rgb(233, 81, 108);" class="fa fa-spinner fa-spin fa-large"></i>'
    
    $("div[for='"+element_id+"']").addClass("spin-loader");
}

function hide_loading_inline(id) {
    
    var element_id = id;

    $("div[for='"+element_id+"']").removeClass("spin-loader");

}

// return query string parameters in obj

function paramobj(url){
	var qrystr = url.split('?')[1];
	
	if(qrystr != undefined)	{
		var aryprm = qrystr.split("&");
		var objparm={};
		for(i=0;i<aryprm.length;i++){
			objparm[(aryprm[i]).split("=")[0]]=(aryprm[i]).split("=")[1];
		}
		return(objparm);
	}
}
function signup_redirect() {
    var parent_location = http_path+"/signup";
        
    parent.jQuery("#modal_login").modal('hide');
    
    parent.window.location.href = parent_location;
}
// Added By VJ for new sign in form.
function signin_popup(args) {
    var login_url = http_path+"/signin?popup";
    var title = "";
    var msg = "";
    if ( typeof(args) != "undefined") {
        login_url  = login_url+"&msg="+args;
    }
    
    modal_params = {"id":"signin","modal_dialog_size" : "modal-lg",
        "iframe":login_url,
        "title":title,"width":"100%","height":"490px",
    };
    open_modal(modal_params);
}
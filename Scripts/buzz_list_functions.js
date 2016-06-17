

/*Prepare data-list*/
//{"res":res,"placeid":"placeid","templateid":""};
function set_buzz_datalist(dataobj){
    
    try{
        //console.log("set_datalist");
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
                    if (i == 0) {
                        jQuery("#"+jstmpl).jTmpl('data-list-first', rows[i],'append');
                    }
                    else{
                        jQuery("#"+jstmpl).jTmpl(dataobj.template_id, rows[i],'append');    
                    }
                    
    
                }
            }
        }
    }
    catch(e){
        
        alert("set_buzz_datalist:"+e);
        
    }

}

/* for search  input controll , id and name should be same*/
function get_buzz_records(page, limit){
	
	if( $("#modulename").length > 0 ){
		var modulename = $("#modulename").attr('data-modulename');
		var action = "get_data_records";
		var template_id = "data-list";
		var template_place_id = "data-list";
        var search_controlls = [];
		
		/*if ( typeof(module_properties[modulename]) != "undefined") {
			
			if ( typeof(module_properties[modulename]["func_data_list_records"]) != "undefined") {
				action = module_properties[modulename]["func_data_list_records"];
			}
            
            if ( typeof(module_properties[modulename]["search_controlls"]) != "undefined") {
				search_controlls = module_properties[modulename]["search_controlls"];
			}
            
			template_id = module_properties[modulename]["template_id"];
			template_place_id = module_properties[modulename]["template_place_id"];
			
		}*/
        
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
                set_buzz_datalist(dataobj);
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

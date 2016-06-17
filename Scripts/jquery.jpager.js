/*Plugin Name : jPager
Description : jQuery + Bootstrap Pagination Full Functioning Plugin
Date : 2015-11-21 
Email : jimmyrana.tech@gmail.com
*/
(function( $ ) {
 
$.fn.jPager =  function (options) {
        var defaults    = { counts: 1,pagin : {} ,callback: function(page) {}};
        var settings    = $.extend( {}, defaults, options );
        var display_text = "Page ";
        if (typeof(settings.display_text) != "undefined") {
             display_text = settings.display_text;   
        }
        
        var _this       = this;
        var first       = _this.find('button[data-pager-action="first"]');
        var next        = _this.find('button[data-pager-action="next"]');
        if($(next).length == 0){
            next        = _this.find('.page_next[data-pager-action="next"]');
        }
        
        var previous    = _this.find('button[data-pager-action="previous"]');
        if($(previous).length == 0){
            previous        = _this.find('.page_previous[data-pager-action="previous"]');
        }
        
        var last        = _this.find('button[data-pager-action="last"]');
        var pagenum     = _this.find('input[data-pager-action="pagenum"]');
        if($(pagenum).length == 0){
            pagenum        = _this.find('.page_num[data-pager-action="pagenum"]');
        }        
        var pagesize    = _this.find('select[data-pager-action="pagesize"]');
        if($(pagesize).length == 0){
            pagesize        = _this.find('.page_size[data-pager-action="pagesize"]');
        }
        var pagesize_val= pagesize.val();
        
        _this.unbind = function(){
           first.unbind();
           next.unbind();
           last.unbind();
           previous.unbind();
           pagesize.unbind();
        };
        _this.init = function () {
            _this.unbind();
            first.on( "click", _this.firstClicked );
            next.on( "click", _this.nextClicked );
            previous.on( "click", _this.previousClicked );
            last.on( "click", _this.lastClicked );
            pagenum.on( "change", _this.pagenumChanged );
            pagesize.on( "change", _this.pagesizeChanged );
            var max_pages = Math.ceil(settings.counts / pagesize_val);
            settings.pagin.max_pages    = max_pages;
            settings.pagin.counts 		= settings.counts;
            settings.pagin.pagesize     = pagesize_val;
            settings.pagin.current_page = 1;
            _this.setInputval(1,max_pages);
            _this.setAction();
        };
		_this.setInputval = function(pageno,totalpages){
					//console.log("setInputval");
					pagenum.val(display_text+pageno+" of "+totalpages);
		};
		_this.page = function(){
			 //console.log(settings.pagin.current_page +" :: "+settings.pagin.max_pages);
				pagenum.val(display_text+settings.pagin.current_page+" of "+settings.pagin.max_pages);
				settings.callback({"pageno":settings.pagin.current_page,"pagesize":pagesize_val});
				 
		};
		_this.disable_action = function(el){
			el.addClass('disabled');
            el.attr('disabled','disabled');
		};
		_this.enable_action = function(el){
			el.removeClass('disabled');
            el.removeAttr('disabled');
		};
		_this.setAction = function(){
            if (settings.counts <= pagesize_val) {
                  _this.disable_action(next);
                  _this.disable_action(last);
                  _this.disable_action(first);
                  _this.disable_action(previous);
            }
            else if( settings.pagin.max_pages == settings.pagin.current_page ){
                    _this.disable_action(next);
                    _this.disable_action(last);
                    _this.enable_action(first);
                    _this.enable_action(previous);
            }
            else if( settings.pagin.current_page == 1 ){
                    _this.disable_action(first);
                    _this.disable_action(previous);
                    _this.enable_action(next);
                    _this.enable_action(last);
            }
            else{
                _this.enable_action(next);
                _this.enable_action(last);
                _this.enable_action(first);
                _this.enable_action(previous);
            }
		};
		_this.firstClicked = function(){
					settings.pagin.current_page =1;	
					_this.setAction();
					_this.page();
		};
		
		_this.nextClicked = function(){
				settings.pagin.current_page = settings.pagin.current_page+1;
				_this.setAction();
				_this.page();
		};
		
		_this.previousClicked = function(){
				if(settings.pagin.current_page > 1){
						settings.pagin.current_page = settings.pagin.current_page-1;
				}
				_this.setAction();
				_this.page();
		};
		_this.lastClicked = function(){
				settings.pagin.current_page = settings.pagin.max_pages;	
				_this.setAction();
				_this.page();
		};
		_this.pagenumChanged = function(){
			 console.log("pagenumChanged");
			_this.page();
		};
		_this.pagesizeChanged = function(){
            pagesize_val = jQuery(this).val();
            jQuery('select[data-pager-action="pagesize"]').val(pagesize_val);
			var max_pages = Math.ceil(settings.counts / pagesize_val);
			settings.pagin.max_pages			= max_pages;
			settings.pagin.current_page			= 1
			_this.setInputval(1,max_pages);
			_this.enable_action(next);
			_this.enable_action(last);
			_this.enable_action(first);
			_this.enable_action(previous);
			_this.page();
            _this.setAction();
		};

		_this.init();
};
}( jQuery ));
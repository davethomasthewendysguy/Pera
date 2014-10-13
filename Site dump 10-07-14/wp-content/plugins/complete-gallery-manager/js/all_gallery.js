var cgm_current_version = 0;
var cgm_count_down = 0;

var cgm_pfx = ["webkit", "moz", "ms", "o", ""];
function cgm_RunPrefixMethod(obj, method) {
	var tmp_p = 0, tmp_m, tmp_t;
	while (tmp_p < cgm_pfx.length && !obj[tmp_m]) {
		tmp_m = method;
		if (cgm_pfx[tmp_p] == "") {
			tmp_m = tmp_m.substr(0,1).toLowerCase() + tmp_m.substr(1);
		}
		tmp_m = cgm_pfx[tmp_p] + tmp_m;
		tmp_t = typeof obj[tmp_m];
		if (tmp_t != "undefined") {
			cgm_pfx = [cgm_pfx[tmp_p]];
			return (tmp_t == "function" ? obj[tmp_m]() : obj[tmp_m]);
		}
		tmp_p++;
	}
	
	tmp_p = null;
	tmp_m = null;
	tmp_t = null;
	
}


function cgm_getInternetExplorerVersion() {
    var rv = -1;
    if (navigator.appName == 'Microsoft Internet Explorer') {
        var ua = navigator.userAgent;
        var re = new RegExp("MSIE ([0-9]{1,}[\.0-9]{0,})");
        if (re.exec(ua) != null)
            rv = parseFloat(RegExp.$1);
    }
    return rv; 
}

function cgm_loadcss(filename, filetype) {
	cgm_replacejscssfile(filename+'?ver='+cgm_current_version, filename+'?ver='+(cgm_current_version+1), filetype)
}

function cgm_createjscssfile(filename, filetype){
	if (filetype=="js"){ //if filename is a external JavaScript file
		var fileref=document.createElement('script')
		fileref.setAttribute("type","text/javascript")
		fileref.setAttribute("src", filename)
	}
	else if (filetype=="css"){ //if filename is an external CSS file
		var fileref=document.createElement("link")
		fileref.setAttribute("rel", "stylesheet")
		fileref.setAttribute("type", "text/css")
		fileref.setAttribute("href", filename)
	}
	return fileref
}

function cgm_replacejscssfile(oldfilename, newfilename, filetype){
	var targetelement=(filetype=="js")? "script" : (filetype=="css")? "link" : "none"
	var targetattr=(filetype=="js")? "src" : (filetype=="css")? "href" : "none" 
	var create_type = true; 
	
	var allsuspects=document.getElementsByTagName(targetelement)
	for (var i=allsuspects.length; i>=0; i--){ //search backwards within nodelist for matching elements to remove
		if (allsuspects[i] && allsuspects[i].getAttribute(targetattr)!=null && allsuspects[i].getAttribute(targetattr).indexOf(oldfilename)!=-1){
			var newelement=cgm_createjscssfile(newfilename, filetype)
			allsuspects[i].parentNode.replaceChild(newelement, allsuspects[i]);
			create_type = false;
		}
	}
	
	targetelement = null;
	targetattr= null;

	if(create_type){
		var newelement=cgm_createjscssfile(oldfilename, filetype);
		if (typeof newelement!="undefined"){
			if(navigator.appName == 'Microsoft Internet Explorer'){

				if(cgm_count_down == 0){
					cgm_count_down = 20;
				}

				for (var j=cgm_count_down; j>=0; j--){
					if (allsuspects[j] && allsuspects[j].getAttribute('rel')!=null && allsuspects[j].getAttribute('rel') == 'stylesheet' ){
						cgm_count_down = j;
						break;
					}
				}
				
				if (typeof newelement!="undefined"){		
					allsuspects[cgm_count_down].parentNode.replaceChild(newelement, allsuspects[cgm_count_down]);
				}  
			} else {
				if (typeof newelement!="undefined"){
					document.getElementsByTagName("head")[0].appendChild(newelement);
				}  
			}
		}  
	} else {
		cgm_current_version++;
	}
	create_type = null;
}

jQuery(document).ready(function($){
	jQuery(document).keydown(function(tmp_e){
	    if (tmp_e.keyCode == 37 && typeof(cgm_touch_data) !== "undefined") { 
			var len=cgm_touch_data.length;
			for(var i=0; i<len; i++) {
				if(typeof(cgm_touch_data[i]) !== 'undefined'){
					cgm_touch_data[i].stopAutoPlay();
					cgm_touch_data[i].swipePrev();
				}
			}
	       return false;
	    }
	    
	    
	    if (tmp_e.keyCode == 27){
	    	jQuery('.cgm_fullscreen_close').click();
	    	jQuery('.cgm-iso-fullscreen').find('#cgm-iso-fullscreen-button').click();
	       return false;
	    }
	    
	    if (tmp_e.keyCode == 39  && typeof(cgm_touch_data) !== "undefined") { 
			var len=cgm_touch_data.length;
			for(var i=0; i<len; i++) {
				if(typeof(cgm_touch_data[i])!== 'undefined'){
					cgm_touch_data[i].stopAutoPlay();
					cgm_touch_data[i].swipeNext();
				}
			}
	       return false;
	    }
	});
});
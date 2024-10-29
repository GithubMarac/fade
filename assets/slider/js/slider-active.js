function setREVStartSize(e){			
    try {								
        var pw = document.getElementById(e.c).parentNode.offsetWidth,
            newh;
        pw = pw===0 || isNaN(pw) ? window.innerWidth : pw;
        e.tabw = e.tabw===undefined ? 0 : parseInt(e.tabw);
        e.thumbw = e.thumbw===undefined ? 0 : parseInt(e.thumbw);
        e.tabh = e.tabh===undefined ? 0 : parseInt(e.tabh);
        e.thumbh = e.thumbh===undefined ? 0 : parseInt(e.thumbh);
        e.tabhide = e.tabhide===undefined ? 0 : parseInt(e.tabhide);
        e.thumbhide = e.thumbhide===undefined ? 0 : parseInt(e.thumbhide);
        e.mh = e.mh===undefined || e.mh=="" || e.mh==="auto" ? 0 : parseInt(e.mh,0);		
        if(e.layout==="fullscreen" || e.l==="fullscreen") 						
            newh = Math.max(e.mh,window.innerHeight);				
        else{					
            e.gw = Array.isArray(e.gw) ? e.gw : [e.gw];
            for (var i in e.rl) if (e.gw[i]===undefined || e.gw[i]===0) e.gw[i] = e.gw[i-1];					
            e.gh = e.el===undefined || e.el==="" || (Array.isArray(e.el) && e.el.length==0)? e.gh : e.el;
            e.gh = Array.isArray(e.gh) ? e.gh : [e.gh];
            for (var i in e.rl) if (e.gh[i]===undefined || e.gh[i]===0) e.gh[i] = e.gh[i-1];
                                
            var nl = new Array(e.rl.length),
                ix = 0,						
                sl;					
            e.tabw = e.tabhide>=pw ? 0 : e.tabw;
            e.thumbw = e.thumbhide>=pw ? 0 : e.thumbw;
            e.tabh = e.tabhide>=pw ? 0 : e.tabh;
            e.thumbh = e.thumbhide>=pw ? 0 : e.thumbh;					
            for (var i in e.rl) nl[i] = e.rl[i]<window.innerWidth ? 0 : e.rl[i];
            sl = nl[0];									
            for (var i in nl) if (sl>nl[i] && nl[i]>0) { sl = nl[i]; ix=i;}															
            var m = pw>(e.gw[ix]+e.tabw+e.thumbw) ? 1 : (pw-(e.tabw+e.thumbw)) / (e.gw[ix]);					

            newh =  (e.type==="carousel" && e.justify==="true" ? e.gh[ix] : (e.gh[ix] * m)) + (e.tabh + e.thumbh);
        }			
        
        if(window.rs_init_css===undefined) window.rs_init_css = document.head.appendChild(document.createElement("style"));					
        document.getElementById(e.c).height = newh;
        window.rs_init_css.innerHTML += "#"+e.c+"_wrapper { height: "+newh+"px }";				
    } catch(e){
        console.log("Failure at Presize of Slider:" + e)
    }					   
  };


  
  if(typeof revslider_showDoubleJqueryError === "undefined") {
    function revslider_showDoubleJqueryError(sliderID) {
        var err = "<div class='rs_error_message_box'>";
        err += "<div class='rs_error_message_oops'>Oops...</div>";
        err += "<div class='rs_error_message_content'>";
        err += "You have some jquery.js library include that comes after the Slider Revolution files js inclusion.<br>";
        err += "To fix this, you can:<br>&nbsp;&nbsp;&nbsp; 1. Set 'Module General Options' -> 'Advanced' -> 'jQuery & OutPut Filters' -> 'Put JS to Body' to on";
        err += "<br>&nbsp;&nbsp;&nbsp; 2. Find the double jQuery.js inclusion and remove it";
        err += "</div>";
    err += "</div>";
        jQuery(sliderID).show().html(err);
    }
}


var	revapi26,
tpj;
jQuery(function() {
tpj = jQuery;
if(tpj("#rev_slider_26_1").revolution == undefined){
    revslider_showDoubleJqueryError("#rev_slider_26_1");
}else{
    revapi26 = tpj("#rev_slider_26_1").show().revolution({
        jsFileLocation:"js/",
        visibilityLevels:"1240,1024,778,480",
        gridwidth:1920,
        gridheight:800,
        spinner:"spinner0",
        editorheight:"800,768,960,720",
        responsiveLevels:"1240,1024,778,480",
        disableProgressBar:"on",
        navigation: {
            onHoverStop:false
        },
        parallax: {
            levels:[5,10,15,20,25,30,35,40,45,46,47,48,49,50,51,30],
            type:"scroll",
            origo:"slidercenter",
            speed:0
        },
        scrolleffect: {
            set:true,
            multiplicator:1.3,
            multiplicator_layers:1.3
        },
        fallbacks: {
            allowHTML5AutoPlayOnAndroid:true
        },
    });
}

});
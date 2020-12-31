<?php
include_once('../common.php');
include_once(G5_THEME_PATH.'/head.php');
include_once('./live_menu.php');
add_stylesheet('<link rel="stylesheet" href="'.G5_THEME_URL.'/css/live.css">', 0);
?>
<section class="live_bs">
<iframe id="inscore-xdc-918419" src="http://www.livescore.in/kr/free/918419/" width="1200" height="500" frameborder="0" scrolling="no"></iframe>

<script type="text/javascript">try{function inscore_918419_xdc(){this.elm = null;this.hash = null;var times_resized = 0;var times_not_resized = 0;this.resize = function(){times_resized == 1023 && (times_resized = 0);times_not_resized == 1023 && (times_not_resized = 0);if(this.getElm() && location.hash && location.hash != this.hash){this.hash = location.hash;var reggg = new RegExp(".*inscore_ifheight_xdc_([0-9]{2,5}).*");if(result=reggg.exec(location.hash)){this.getElm().style.height = (typeof result[1] == "undefined" ? "10000":(result[1] > 500 && result[1] <= 50000 ? parseInt(result[1]):500)) + "px";times_resized ++;}} else if(location.hash && location.hash == this.hash) times_not_resized ++;else return resize_later(75);resize_later(250);};var resize_later = function(time){setTimeout(function(){ inscore_918419_xdc_run.resize(); }, time);};this.getElm = function(){try {(typeof this.elm == "undefined" || this.elm === null || !this.elm) && (this.elm = document.getElementById("inscore-xdc-918419"));} catch(e) { this.elm = null; }return this.elm;};var show_links = function(){if((times_resized >= 1 || times_not_resized >= 2) && (obj = document.getElementById("freescore_links_918419"))){obj.style.visibility = "visible";obj.style.display = "block";} else show_links_later();};var show_links_later = function() { setTimeout(function(){ show_links(); }, 100); };if (typeof window.postMessage == "undefined"){show_links_later();resize_later();}else{var ev = function(event){try{var data = JSON.parse(event.data);}catch (e){return;}if (data instanceof Array && data[0] == 918419 && typeof data[1] != "undefined"){eval(data[1]);}};if (window.addEventListener){window.addEventListener( "message", ev);}else if ( window.attachEvent ){window.attachEvent("onmessage", ev);}setTimeout(function(){document.getElementById("inscore-xdc-918419").contentWindow.postMessage(JSON.stringify(["918419", "run"]), "*");}, 2000);show_links_later();resize_later();}};var inscore_918419_xdc_run = new inscore_918419_xdc();}catch(e){document.getElementById("inscore-xdc-918419").style.height = "10000px";}
</script>
</section>
<?php
include_once(G5_PATH.'/tail.php');
?>
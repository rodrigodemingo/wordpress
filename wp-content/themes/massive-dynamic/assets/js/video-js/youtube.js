/* global videojs, YT */
/* jshint browser: true */
!function(){function t(t,e,i){t.addEventListener?t.addEventListener(e,i,!0):t.attachEvent(e,i)}function e(t,e){if("undefined"==typeof t)return!1;var i="innerText"in t?"innerText":"textContent";try{t[i]=e}catch(a){t.setAttribute("innerText",e)}}videojs.Youtube=videojs.MediaTechController.extend({init:function(t,i,a){if(this.player_=t,this.featuresProgressEvents=!1,this.featuresTimeupdateEvents=!1,this.featuresPlaybackRate=!0,this.featuresNativeTextTracks=!0,videojs.MediaTechController.call(this,t,i,a),this.isIos=/(iPad|iPhone|iPod)/g.test(navigator.userAgent),this.isAndroid=/(Android)/g.test(navigator.userAgent),this.playVideoIsAllowed=!(this.isIos||this.isAndroid),(this.isIos||this.isAndroid)&&(this.player_.options().autoplay=!1),"undefined"!=typeof i.source)for(var s in i.source)i.source.hasOwnProperty(s)&&(t.options()[s]=i.source[s]);this.player_.options().playbackRates=[],this.userQuality=videojs.Youtube.convertQualityName(t.options().quality),this.playerEl_=t.el(),this.playerEl_.className+=" vjs-youtube",this.qualityButton=document.createElement("div"),this.qualityButton.setAttribute("class","vjs-quality-button vjs-menu-button vjs-control"),this.qualityButton.setAttribute("tabindex",0);var o=document.createElement("div");o.setAttribute("class","vjs-control-content"),this.qualityButton.appendChild(o),this.qualityTitle=document.createElement("span"),this.qualityTitle.setAttribute("class","vjs-control-text"),o.appendChild(this.qualityTitle),"undefined"!==t.options().quality&&e(this.qualityTitle,t.options().quality||"auto");var r=document.createElement("div");if(r.setAttribute("class","vjs-menu"),o.appendChild(r),this.qualityMenuContent=document.createElement("ul"),this.qualityMenuContent.setAttribute("class","vjs-menu-content"),r.appendChild(this.qualityMenuContent),this.id_=this.player_.id()+"_youtube_api",this.el_=videojs.Component.prototype.createEl("iframe",{id:this.id_,className:"vjs-tech",scrolling:"no",marginWidth:0,marginHeight:0,frameBorder:0}),this.el_.setAttribute("allowFullScreen",""),this.playerEl_.insertBefore(this.el_,this.playerEl_.firstChild),/MSIE (\d+\.\d+);/.test(navigator.userAgent)){var l=Number(RegExp.$1);this.addIframeBlocker(l)}else/(iPad|iPhone|iPod|Android)/g.test(navigator.userAgent)||(this.el_.className+=" onDesktop",this.addIframeBlocker());this.parseSrc(t.options().src),this.playOnReady=this.player_.options().autoplay&&this.playVideoIsAllowed,this.forceHTML5=!("undefined"!=typeof this.player_.options().forceHTML5&&this.player_.options().forceHTML5!==!0),this.updateIframeSrc();var n=this;t.ready(function(){if(n.player_.options().controls){var e=n.playerEl_.querySelectorAll(".vjs-control-bar")[0];e&&e.appendChild(n.qualityButton)}n.playOnReady&&!n.player_.options().ytcontrols&&("undefined"!=typeof n.player_.loadingSpinner&&n.player_.loadingSpinner.show(),"undefined"!=typeof n.player_.bigPlayButton&&n.player_.bigPlayButton.hide()),t.trigger("loadstart")}),this.on("dispose",function(){this.ytplayer&&this.ytplayer.destroy(),this.player_.options().ytcontrols||this.player_.off("waiting",this.bindedWaiting),this.playerEl_.querySelectorAll(".vjs-poster")[0].style.backgroundImage="none",this.el_.parentNode&&this.el_.parentNode.removeChild(this.el_),this.qualityButton.parentNode&&this.qualityButton.parentNode.removeChild(this.qualityButton),"undefined"!=typeof this.player_.loadingSpinner&&this.player_.loadingSpinner.hide(),"undefined"!=typeof this.player_.bigPlayButton&&this.player_.bigPlayButton.hide(),this.iframeblocker&&this.playerEl_.removeChild(this.iframeblocker)})}}),videojs.Youtube.prototype.loadThumbnailUrl=function(t,e){var i="https://img.youtube.com/vi/"+t+"/maxresdefault.jpg",a="https://img.youtube.com/vi/"+t+"/0.jpg";try{var s=new Image;s.onload=function(){if("naturalHeight"in this){if(this.naturalHeight<=90||this.naturalWidth<=120)return void this.onerror()}else if(this.height<=90||this.width<=120)return void this.onerror();e(i)},s.onerror=function(){e(a)},s.src=i}catch(o){e(a)}},videojs.Youtube.prototype.updateIframeSrc=function(){var t="undefined"==typeof this.player_.options().ytFullScreenControls||this.player_.options().ytFullScreenControls?1:0,e={enablejsapi:1,iv_load_policy:3,playerapiid:this.id(),disablekb:1,wmode:"transparent",controls:this.player_.options().ytcontrols?1:0,fs:t,html5:this.player_.options().forceHTML5?1:null,playsinline:this.player_.options().playsInline?1:0,showinfo:0,rel:0,autoplay:this.playOnReady?1:0,loop:this.player_.options().loop?1:0,list:this.playlistId,vq:this.userQuality,origin:window.location.protocol+"//"+window.location.host},i="file:"===window.location.protocol||"app:"===window.location.protocol;i&&delete e.origin;for(var a in e)!e.hasOwnProperty(a)||"undefined"!=typeof e[a]&&null!==e[a]||delete e[a];var s=this;if(this.videoId||this.playlistId){if(this.el_.src="https://www.youtube.com/embed/"+(this.videoId||"videoseries")+"?"+videojs.Youtube.makeQueryString(e),this.player_.options().ytcontrols?this.player_.controls(!1):!this.videoId||"undefined"!=typeof this.player_.poster()&&0!==this.player_.poster().length||setTimeout(function(){s.loadThumbnailUrl(s.videoId,function(t){s.player_.poster(t)})},100),this.bindedWaiting=function(){s.onWaiting()},this.player_.on("waiting",this.bindedWaiting),videojs.Youtube.apiReady)this.loadYoutube();else if(videojs.Youtube.loadingQueue.push(this),!videojs.Youtube.apiLoading){var o=document.createElement("script");o.onerror=function(t){s.onError(t)},o.src="https://www.youtube.com/iframe_api";var r=document.getElementsByTagName("script")[0];r.parentNode.insertBefore(o,r),videojs.Youtube.apiLoading=!0}}else this.el_.src="about:blank",setTimeout(function(){s.triggerReady()},500)},videojs.Youtube.prototype.onWaiting=function(){"undefined"!=typeof this.player_.bigPlayButton&&this.player_.bigPlayButton.hide()},videojs.Youtube.prototype.addIframeBlocker=function(e){this.iframeblocker=videojs.Component.prototype.createEl("div"),this.iframeblocker.className="iframeblocker",this.iframeblocker.style.position="absolute",this.iframeblocker.style.left=0,this.iframeblocker.style.right=0,this.iframeblocker.style.top=0,this.iframeblocker.style.bottom=0,e&&9>e?this.iframeblocker.style.opacity=.01:this.iframeblocker.style.background="rgba(255, 255, 255, 0.01)";var i=this;t(this.iframeblocker,"mousemove",function(t){i.player_.userActive()||i.player_.userActive(!0),t.stopPropagation(),t.preventDefault()}),t(this.iframeblocker,"click",function(){i.paused()?i.play():i.pause()}),this.playerEl_.insertBefore(this.iframeblocker,this.el_.nextSibling)},videojs.Youtube.prototype.parseSrc=function(t){if(this.srcVal=t,t){var e=/^.*(youtu.be\/|v\/|u\/\w\/|embed\/|watch\?v=|\&v=)([^#\&\?]*).*/,i=t.match(e);this.videoId=i&&11===i[2].length?i[2]:null;var a=/[?&]list=([^#\&\?]+)/;i=t.match(a),null!==i&&i.length>1?this.playlistId=i[1]:this.playlistId&&delete this.playlistId;var s=/[?&]vq=([^#\&\?]+)/;i=t.match(s),null!==i&&i.length>1&&(this.userQuality=i[1],videojs.Youtube.appendQualityLabel(this.qualityTitle,this.userQuality))}},videojs.Youtube.prototype.src=function(t){if("undefined"!=typeof t){if(this.parseSrc(t),"about:blank"===this.el_.src)return void this.updateIframeSrc();if(delete this.defaultQuality,null!==this.videoId){this.player_.options().autoplay&&this.playVideoIsAllowed?this.ytplayer.loadVideoById({videoId:this.videoId,suggestedQuality:this.userQuality}):this.ytplayer.cueVideoById({videoId:this.videoId,suggestedQuality:this.userQuality});var e=this;this.loadThumbnailUrl(this.videoId,function(t){e.playerEl_.querySelectorAll(".vjs-poster")[0].style.backgroundImage="url("+t+")",e.player_.poster(t)})}}return this.srcVal},videojs.Youtube.prototype.load=function(){},videojs.Youtube.prototype.play=function(){null!==this.videoId&&(this.player_.options().ytcontrols||this.player_.trigger("waiting"),this.isReady_?(this.ytplayer.setVolume(100*this.player_.volume()),this.volumeVal>0?this.ytplayer.unMute():this.ytplayer.mute(),this.playVideoIsAllowed&&this.ytplayer.playVideo()):this.playOnReady=!0)},videojs.Youtube.prototype.pause=function(){this.ytplayer&&this.ytplayer.pauseVideo()},videojs.Youtube.prototype.paused=function(){return this.ytplayer?this.lastState!==YT.PlayerState.PLAYING&&this.lastState!==YT.PlayerState.BUFFERING:!0},videojs.Youtube.prototype.currentTime=function(){return this.ytplayer&&this.ytplayer.getCurrentTime?this.ytplayer.getCurrentTime():0},videojs.Youtube.prototype.setCurrentTime=function(t){this.lastState===YT.PlayerState.PAUSED&&(this.timeBeforeSeek=this.currentTime()),this.ytplayer.seekTo(t,!0),this.player_.trigger("timeupdate"),this.player_.trigger("seeking"),this.isSeeking=!0,this.lastState===YT.PlayerState.PAUSED&&this.timeBeforeSeek!==t&&(this.checkSeekedInPauseInterval=setInterval(videojs.bind(this,function(){this.lastState===YT.PlayerState.PAUSED&&this.isSeeking?this.currentTime()!==this.timeBeforeSeek&&(this.player_.trigger("timeupdate"),this.player_.trigger("seeked"),this.isSeeking=!1,clearInterval(this.checkSeekedInPauseInterval)):clearInterval(this.checkSeekedInPauseInterval)}),250))},videojs.Youtube.prototype.playbackRate=function(){return this.ytplayer&&this.ytplayer.getPlaybackRate?this.ytplayer.getPlaybackRate():1},videojs.Youtube.prototype.setPlaybackRate=function(t){if(this.ytplayer&&this.ytplayer.setPlaybackRate){this.ytplayer.setPlaybackRate(t);var e=this;setTimeout(function(){e.player_.trigger("ratechange")},100)}},videojs.Youtube.prototype.duration=function(){return this.ytplayer&&this.ytplayer.getDuration?this.ytplayer.getDuration():0},videojs.Youtube.prototype.currentSrc=function(){return this.srcVal},videojs.Youtube.prototype.ended=function(){return this.ytplayer?this.lastState===YT.PlayerState.ENDED:!1},videojs.Youtube.prototype.volume=function(){return this.ytplayer&&isNaN(this.volumeVal)&&(this.volumeVal=this.ytplayer.getVolume()/100,this.volumeVal=isNaN(this.volumeVal)?1:this.volumeVal,this.player_.volume(this.volumeVal)),this.volumeVal},videojs.Youtube.prototype.setVolume=function(t){"undefined"!=typeof t&&t!==this.volumeVal&&(this.ytplayer.setVolume(100*t),this.volumeVal=t,this.player_.trigger("volumechange"))},videojs.Youtube.prototype.muted=function(){return this.mutedVal},videojs.Youtube.prototype.setMuted=function(t){t?(this.storedVolume=this.volumeVal,this.ytplayer.mute(),this.player_.volume(0)):(this.ytplayer.unMute(),this.player_.volume(this.storedVolume)),this.mutedVal=t,this.player_.trigger("volumechange")},videojs.Youtube.prototype.buffered=function(){if(this.ytplayer&&this.ytplayer.getVideoBytesLoaded){var t=this.ytplayer.getVideoBytesLoaded(),e=this.ytplayer.getVideoBytesTotal();if(!t||!e)return 0;var i=this.ytplayer.getDuration(),a=t/e*i,s=this.ytplayer.getVideoStartBytes()/e*i;return videojs.createTimeRange(s,s+a)}return videojs.createTimeRange(0,0)},videojs.Youtube.prototype.supportsFullScreen=function(){return"function"!=typeof this.el_.webkitEnterFullScreen||!/Android/.test(videojs.USER_AGENT)&&/Chrome|Mac OS X 10.5/.test(videojs.USER_AGENT)?!1:!0},videojs.Youtube.isSupported=function(){return!0},videojs.Youtube.canPlaySource=function(t){return"video/youtube"===t.type},videojs.Youtube.canControlVolume=function(){return!0},videojs.Youtube.loadingQueue=[],videojs.Youtube.prototype.loadYoutube=function(){var t=this;this.ytplayer=new YT.Player(this.id_,{events:{onReady:function(e){e.target.vjsTech.onReady(),t.player_.trigger("ratechange")},onStateChange:function(t){t.target.vjsTech.onStateChange(t.data)},onPlaybackQualityChange:function(t){t.target.vjsTech.onPlaybackQualityChange(t.data)},onError:function(t){t.target.vjsTech.onError(t.data)}}}),this.ytplayer.vjsTech=this},videojs.Youtube.makeQueryString=function(t){var e=["modestbranding=1"];for(var i in t)t.hasOwnProperty(i)&&e.push(i+"="+t[i]);return e.join("&")},window.onYouTubeIframeAPIReady=function(){for(var t;t=videojs.Youtube.loadingQueue.shift();)t.loadYoutube();videojs.Youtube.loadingQueue=[],videojs.Youtube.apiReady=!0},videojs.Youtube.prototype.onReady=function(){if(this.isReady_=!0,this.triggerReady(),this.player_.options().playbackRates=this.ytplayer.getAvailablePlaybackRates(),this.player_.controlBar.playbackRateMenuButton.update(),this.player_.trigger("loadedmetadata"),this.player_.trigger("durationchange"),this.player_.trigger("timeupdate"),"undefined"==typeof this.player_.loadingSpinner||this.isIos||this.isAndroid||this.player_.loadingSpinner.hide(),this.player_.options().muted&&this.setMuted(!0),!this.videoId&&this.playlistId){this.videoId=this.ytplayer.getPlaylist()[0];var t=this;this.loadThumbnailUrl(this.videoId,function(e){t.player_.poster(e)})}this.playOnReady&&(this.playOnReady=!1,this.play())},videojs.Youtube.prototype.updateCaptions=function(){this.ytplayer.loadModule("captions"),this.ytplayer.loadModule("cc");var t=this.ytplayer.getOptions(),e=t.indexOf("captions")>=0?"captions":t.indexOf("cc")>=0?"cc":null;if(null!==e&&!this.tracked_){var i=this.ytplayer.getOption(e,"tracklist");if(i&&i.length>0){for(var a,s=0;s<i.length;s++)a=this.addTextTrack("captions",i[s].displayName,i[s].languageCode);var o=this;this.textTracks().on("change",function(){for(var t=null,i=0;i<this.length;i++)if("showing"===this[i].mode){t=this[i].language;break}null!==t?o.ytplayer.setOption(e,"track",{languageCode:t}):o.ytplayer.setOption(e,"track",{})}),this.tracked_=!0}}},videojs.Youtube.prototype.updateQualities=function(){function e(e){t(e,"click",function(){var t=this.getAttribute("data-val");a.ytplayer.setPlaybackQuality(t),a.userQuality=t,videojs.Youtube.appendQualityLabel(a.qualityTitle,t);var e=a.qualityMenuContent.querySelector(".vjs-selected");e&&videojs.Youtube.removeClass(e,"vjs-selected"),videojs.Youtube.addClass(this,"vjs-selected")})}var i=this.ytplayer.getAvailableQualityLevels(),a=this;if(i.indexOf(this.userQuality)<0&&videojs.Youtube.appendQualityLabel(a.qualityTitle,this.defaultQuality),0===i.length)this.qualityButton.style.display="none";else{for(this.qualityButton.style.display="";this.qualityMenuContent.hasChildNodes();)this.qualityMenuContent.removeChild(this.qualityMenuContent.lastChild);for(var s=0;s<i.length;++s){var o=document.createElement("li");o.setAttribute("class","vjs-menu-item"),o.setAttribute("data-val",i[s]),videojs.Youtube.appendQualityLabel(o,i[s]),i[s]===this.quality&&videojs.Youtube.addClass(o,"vjs-selected"),e(o),this.qualityMenuContent.appendChild(o)}}},videojs.Youtube.prototype.onStateChange=function(t){if(t!==this.lastState){switch(t){case-1:this.player_.trigger("durationchange");break;case YT.PlayerState.ENDED:var e=!0;this.playlistId&&!this.player_.options().loop&&(e=0===this.ytplayer.getPlaylistIndex()),e&&(this.player_.options().ytcontrols||(this.playerEl_.querySelectorAll(".vjs-poster")[0].style.display="block","undefined"!=typeof this.player_.bigPlayButton&&this.player_.bigPlayButton.show()),this.player_.trigger("pause"),this.player_.trigger("ended"));break;case YT.PlayerState.PLAYING:this.playerEl_.querySelectorAll(".vjs-poster")[0].style.display="none",this.playVideoIsAllowed=!0,this.updateQualities(),this.updateCaptions(),this.player_.trigger("timeupdate"),this.player_.trigger("durationchange"),this.player_.trigger("playing"),this.player_.trigger("play"),this.isSeeking&&(this.player_.trigger("seeked"),this.isSeeking=!1);break;case YT.PlayerState.PAUSED:this.player_.trigger("pause");break;case YT.PlayerState.BUFFERING:this.player_.trigger("timeupdate"),this.player_.options().ytcontrols||this.player_.trigger("waiting");break;case YT.PlayerState.CUED:}this.lastState=t}},videojs.Youtube.convertQualityName=function(t){switch(t){case"144p":return"tiny";case"240p":return"small";case"360p":return"medium";case"480p":return"large";case"720p":return"hd720";case"1080p":return"hd1080";case"1440p":return"hd1440";case"2160p":return"hd2160"}return"auto"},videojs.Youtube.parseQualityName=function(t){switch(t){case"tiny":return"144p";case"small":return"240p";case"medium":return"360p";case"large":return"480p";case"hd720":return"720p";case"hd1080":return"1080p";case"hd1440":return"1440p";case"hd2160":return"2160p"}return"auto"},videojs.Youtube.appendQualityLabel=function(t,i){e(t,videojs.Youtube.parseQualityName(i));var a=document.createElement("span");switch(a.setAttribute("class","vjs-hd-label"),i){case"hd720":case"hd1080":case"hd1440":e(a,"HD"),t.appendChild(a);break;case"hd2160":e(a,"4K"),t.appendChild(a)}},videojs.Youtube.prototype.onPlaybackQualityChange=function(t){if("undefined"!=typeof this.defaultQuality||(this.defaultQuality=t,"undefined"==typeof this.userQuality)){switch(this.quality=t,videojs.Youtube.appendQualityLabel(this.qualityTitle,t),t){case"medium":this.player_.videoWidth=480,this.player_.videoHeight=360;break;case"large":this.player_.videoWidth=640,this.player_.videoHeight=480;break;case"hd720":this.player_.videoWidth=960,this.player_.videoHeight=720;break;case"hd1080":this.player_.videoWidth=1440,this.player_.videoHeight=1080;break;case"highres":this.player_.videoWidth=1920,this.player_.videoHeight=1080;break;case"small":this.player_.videoWidth=320,this.player_.videoHeight=240;break;case"tiny":this.player_.videoWidth=144,this.player_.videoHeight=108;break;default:this.player_.videoWidth=0,this.player_.videoHeight=0}this.player_.trigger("ratechange")}},videojs.Youtube.prototype.onError=function(t){this.player_.error(t)},videojs.Youtube.addClass=function(t,e){-1===(" "+t.className+" ").indexOf(" "+e+" ")&&(t.className=""===t.className?e:t.className+" "+e)},videojs.Youtube.removeClass=function(t,e){var i,a;if(-1!==t.className.indexOf(e)){for(i=t.className.split(" "),a=i.length-1;a>=0;a--)i[a]===e&&i.splice(a,1);t.className=i.join(" ")}};var i=document.createElement("style"),a=" .vjs-youtube .vjs-poster { background-size: 100%!important; }.vjs-youtube .vjs-poster, .vjs-youtube .vjs-loading-spinner, .vjs-youtube .vjs-big-play-button, .vjs-youtube .vjs-text-track-display{ pointer-events: none !important; }.vjs-youtube.vjs-user-active .iframeblocker { display: none; }.vjs-youtube.vjs-user-inactive .vjs-tech.onDesktop { pointer-events: none; }.vjs-quality-button > div:first-child > span:first-child { position:relative;top:7px }";i.setAttribute("type","text/css"),document.getElementsByTagName("head")[0].appendChild(i),i.styleSheet?i.styleSheet.cssText=a:i.appendChild(document.createTextNode(a)),Array.prototype.indexOf||(Array.prototype.indexOf=function(t){var e=this.length>>>0,i=Number(arguments[1])||0;for(i=0>i?Math.ceil(i):Math.floor(i),0>i&&(i+=e);e>i;i++)if(i in this&&this[i]===t)return i;return-1})}();
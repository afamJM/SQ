/*!
 * jQuery-ajaxTransport-XDomainRequest - v1.0.1 - 2013-10-17
 * https://github.com/MoonScript/jQuery-ajaxTransport-XDomainRequest
 * Copyright (c) 2013 Jason Moon (@JSONMOON)
 * Licensed MIT (/blob/master/LICENSE.txt)
 */
(function ($) { if (!$.support.cors && $.ajaxTransport && window.XDomainRequest) { var n = /^https?:\/\//i; var o = /^get|post$/i; var p = new RegExp('^' + location.protocol, 'i'); var q = /text\/html/i; var r = /\/json/i; var s = /\/xml/i; $.ajaxTransport('* text html xml json', function (i, j, k) { if (i.crossDomain && i.async && o.test(i.type) && n.test(i.url) && p.test(i.url)) { var l = null; var m = (j.dataType || '').toLowerCase(); return { send: function (f, g) { l = new XDomainRequest(); if (/^\d+$/.test(j.timeout)) { l.timeout = j.timeout } l.ontimeout = function () { g(500, 'timeout') }; l.onload = function () { var a = 'Content-Length: ' + l.responseText.length + '\r\nContent-Type: ' + l.contentType; var b = { code: 200, message: 'success' }; var c = { text: l.responseText }; try { if (m === 'html' || q.test(l.contentType)) { c.html = l.responseText } else if (m === 'json' || (m !== 'text' && r.test(l.contentType))) { try { c.json = $.parseJSON(l.responseText) } catch (e) { b.code = 500; b.message = 'parseerror' } } else if (m === 'xml' || (m !== 'text' && s.test(l.contentType))) { var d = new ActiveXObject('Microsoft.XMLDOM'); d.async = false; try { d.loadXML(l.responseText) } catch (e) { d = undefined } if (!d || !d.documentElement || d.getElementsByTagName('parsererror').length) { b.code = 500; b.message = 'parseerror'; throw 'Invalid XML: ' + l.responseText; } c.xml = d } } catch (parseMessage) { throw parseMessage; } finally { g(b.code, b.message, c, a) } }; l.onprogress = function () { }; l.onerror = function () { g(500, 'error', { text: l.responseText }) }; var h = ''; if (j.data) { h = ($.type(j.data) === 'string') ? j.data : $.param(j.data) } l.open(i.type, i.url); l.send(h) }, abort: function () { if (l) { l.abort() } } } } }) } })(jQuery);

(function ($) {
    $.fn.Video = function (options) {
        var settings = $.extend({
            'height': null,
            'width': null,
            'channel': null,
            'autoStart': true,
            'controls': true,
            'mute': false,
            'quality': null,
            'image': null,
            'watchButton': null,
            'edge': null
        }, options);

        //settings.height = this.css('height').replace("px", "");
        //settings.width = this.css('width').replace("px", "");
        this.wrap('<div id="' + this.attr('id') + '_wrapper"></div');
        settings.quality = settings.quality == null ? 'source' : settings.quality;
        var vpd = $(this).attr('id');
        
        var $vdpobj = this;
        var httpurl;

        if (settings.pageIdentifier == "homepage" && navigator.userAgent.match(/(iPhone|iPod|iPad|BlackBerry|Android|Windows Phone)/)) {
            $vdpobj.html('<a href="/watch"><img height=' + $vdpobj.css('height') + ' width=' + $vdpobj.css('width') + '  src="/wp-content/themes/Ibiza-Theme/assets/images/stream.jpg" /></a>');
            return;
        }

        var httpRequest = $.ajax({ url: '//www.jewellerymaker.com/api/video/get.aspx?type=HTTP', success: function (data) { httpurl = data; } });

        $.when(httpRequest).then(function () {
			// $vdpobj.html('<a href="rtsp://edge01.cdn.aws.subset.host/JewelleryMakerLive/JewelleryMakerLive"><img height=' + $vdpobj.css('height') + ' width=' + $vdpobj.css('width') + '  src="/global/img/homepage/playStudio.png" /></a>');
			// return;
			if (navigator.userAgent.match(/(Chrome\/|Edge\/|Firefox\/|Trident\/|Silk\/)/) && !navigator.userAgent.match(/(Windows Phone)/)) { // FLOW PLAYER
				flowplayer($vdpobj, {
					autoplay: true,
					muted: settings.mute,
					key: '$166863531072322',
					clip: {
						sources: [
							  { type: "application/x-mpegURL",
								src:  httpurl }
						]
					}
				});
				
				if (!settings.controls) {
					$(".fp-ui").hide();
				}
			} else { // OTHER DEVICES (NATIVE & HLS.JS)
				var video = document.createElement('video');
				video.id = vpd;
					
				video.className = "video-js vjs-default-skin";

				video.style.width = "100%";
				video.style.height = "100%";
				
				if (settings.controls) {
					video.setAttribute("controls", "");
				}
				
				video.setAttribute("preload", "none");
				
				if (settings.autoStart) {
					video.setAttribute("autoplay", "");
					video.autoPlay = true;
				}
				
				if (settings.mute) {
					video.setAttribute("muted", "");
				}

				video.setAttribute("poster", settings.image);
					
				var wrapper = document.getElementById(vpd);
				wrapper.parentElement.appendChild(video);
				removeElement(wrapper);
				
				if (navigator.userAgent.match(/(Windows Phone)/)) {
					var src = document.createElement("source");
					src.setAttribute("type", "application/vnd.ms-sstr+xml");
					src.setAttribute("src", "http://www.ibiza.com.dev/");
					video.appendChild(src);
				} else if (navigator.userAgent.match(/(iPhone|iPod|iPad)/)) {
					// Just add the source. Built in support for HLS.
					var src = document.createElement("source");
					src.setAttribute("type", "application/x-mpegURL");
					src.setAttribute("src", httpurl);
					video.appendChild(src);
				} else {
					// Add HLS playback support for native player.
					var hls = new Hls();
					hls.loadSource(httpurl);
					hls.attachMedia(video);
					hls.on(Hls.Events.MANIFEST_PARSED,function() {
						video.play();
					});
				}
			}
		});
    };
})(jQuery);

function isIE () {
	var myNav = navigator.userAgent.toLowerCase();
	return (myNav.indexOf('msie') != -1) ? parseInt(myNav.split('msie')[1]) : false;
}

function removeElement(element) {
	element && element.parentNode && element.parentNode.removeChild(element);
}

function getFlashVersion() {
    try {
        try {
            var axo = new ActiveXObject('ShockwaveFlash.ShockwaveFlash.6');
            try { axo.AllowScriptAccess = 'always'; }
            catch (e) { return '6,0,0'; }
        } catch (e) { }
        return new ActiveXObject('ShockwaveFlash.ShockwaveFlash').GetVariable('$version').replace(/\D+/g, ',').match(/^,?(.+),?$/)[1];
    } catch (e) {
        try {
            if (navigator.mimeTypes["application/x-shockwave-flash"].enabledPlugin) {
                return (navigator.plugins["Shockwave Flash 2.0"] || navigator.plugins["Shockwave Flash"]).description.replace(/\D+/g, ",").match(/^,?(.+),?$/)[1];
            }
        } catch (e) { }
    }
    return '0,0,0';
}
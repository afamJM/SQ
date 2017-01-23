!function(e,t){"function"==typeof define&&define.amd?define("jquery-bridget/jquery-bridget",["jquery"],function(i){return t(e,i)}):"object"==typeof module&&module.exports?module.exports=t(e,require("jquery")):e.jQueryBridget=t(e,e.jQuery)}(window,function(e,t){"use strict";function i(i,o,r){function l(e,t,n){var a,o="$()."+i+'("'+t+'")';return e.each(function(e,l){var d=r.data(l,i);if(!d)return void s(i+" not initialized. Cannot call methods, i.e. "+o);var u=d[t];if(!u||"_"==t.charAt(0))return void s(o+" is not a valid method");var c=u.apply(d,n);a=void 0===a?c:a}),void 0!==a?a:e}function d(e,t){e.each(function(e,n){var a=r.data(n,i);a?(a.option(t),a._init()):(a=new o(n,t),r.data(n,i,a))})}r=r||t||e.jQuery,r&&(o.prototype.option||(o.prototype.option=function(e){r.isPlainObject(e)&&(this.options=r.extend(!0,this.options,e))}),r.fn[i]=function(e){if("string"==typeof e){var t=a.call(arguments,1);return l(this,e,t)}return d(this,e),this},n(r))}function n(e){!e||e&&e.bridget||(e.bridget=i)}var a=Array.prototype.slice,o=e.console,s="undefined"==typeof o?function(){}:function(e){o.error(e)};return n(t||e.jQuery),i}),function(e,t){"function"==typeof define&&define.amd?define("ev-emitter/ev-emitter",t):"object"==typeof module&&module.exports?module.exports=t():e.EvEmitter=t()}("undefined"!=typeof window?window:this,function(){function e(){}var t=e.prototype;return t.on=function(e,t){if(e&&t){var i=this._events=this._events||{},n=i[e]=i[e]||[];return n.indexOf(t)==-1&&n.push(t),this}},t.once=function(e,t){if(e&&t){this.on(e,t);var i=this._onceEvents=this._onceEvents||{},n=i[e]=i[e]||{};return n[t]=!0,this}},t.off=function(e,t){var i=this._events&&this._events[e];if(i&&i.length){var n=i.indexOf(t);return n!=-1&&i.splice(n,1),this}},t.emitEvent=function(e,t){var i=this._events&&this._events[e];if(i&&i.length){var n=0,a=i[n];t=t||[];for(var o=this._onceEvents&&this._onceEvents[e];a;){var s=o&&o[a];s&&(this.off(e,a),delete o[a]),a.apply(this,t),n+=s?0:1,a=i[n]}return this}},e}),function(e,t){"use strict";"function"==typeof define&&define.amd?define("get-size/get-size",[],function(){return t()}):"object"==typeof module&&module.exports?module.exports=t():e.getSize=t()}(window,function(){"use strict";function e(e){var t=parseFloat(e),i=e.indexOf("%")==-1&&!isNaN(t);return i&&t}function t(){}function i(){for(var e={width:0,height:0,innerWidth:0,innerHeight:0,outerWidth:0,outerHeight:0},t=0;t<d;t++){var i=l[t];e[i]=0}return e}function n(e){var t=getComputedStyle(e);return t||r("Style returned "+t+". Are you running this code in a hidden iframe on Firefox? See http://bit.ly/getsizebug1"),t}function a(){if(!u){u=!0;var t=document.createElement("div");t.style.width="200px",t.style.padding="1px 2px 3px 4px",t.style.borderStyle="solid",t.style.borderWidth="1px 2px 3px 4px",t.style.boxSizing="border-box";var i=document.body||document.documentElement;i.appendChild(t);var a=n(t);o.isBoxSizeOuter=s=200==e(a.width),i.removeChild(t)}}function o(t){if(a(),"string"==typeof t&&(t=document.querySelector(t)),t&&"object"==typeof t&&t.nodeType){var o=n(t);if("none"==o.display)return i();var r={};r.width=t.offsetWidth,r.height=t.offsetHeight;for(var u=r.isBorderBox="border-box"==o.boxSizing,c=0;c<d;c++){var p=l[c],h=o[p],f=parseFloat(h);r[p]=isNaN(f)?0:f}var m=r.paddingLeft+r.paddingRight,g=r.paddingTop+r.paddingBottom,v=r.marginLeft+r.marginRight,y=r.marginTop+r.marginBottom,w=r.borderLeftWidth+r.borderRightWidth,b=r.borderTopWidth+r.borderBottomWidth,C=u&&s,S=e(o.width);S!==!1&&(r.width=S+(C?0:m+w));var T=e(o.height);return T!==!1&&(r.height=T+(C?0:g+b)),r.innerWidth=r.width-(m+w),r.innerHeight=r.height-(g+b),r.outerWidth=r.width+v,r.outerHeight=r.height+y,r}}var s,r="undefined"==typeof console?t:function(e){console.error(e)},l=["paddingLeft","paddingRight","paddingTop","paddingBottom","marginLeft","marginRight","marginTop","marginBottom","borderLeftWidth","borderRightWidth","borderTopWidth","borderBottomWidth"],d=l.length,u=!1;return o}),function(e,t){"use strict";"function"==typeof define&&define.amd?define("desandro-matches-selector/matches-selector",t):"object"==typeof module&&module.exports?module.exports=t():e.matchesSelector=t()}(window,function(){"use strict";var e=function(){var e=Element.prototype;if(e.matches)return"matches";if(e.matchesSelector)return"matchesSelector";for(var t=["webkit","moz","ms","o"],i=0;i<t.length;i++){var n=t[i],a=n+"MatchesSelector";if(e[a])return a}}();return function(t,i){return t[e](i)}}),function(e,t){"function"==typeof define&&define.amd?define("fizzy-ui-utils/utils",["desandro-matches-selector/matches-selector"],function(i){return t(e,i)}):"object"==typeof module&&module.exports?module.exports=t(e,require("desandro-matches-selector")):e.fizzyUIUtils=t(e,e.matchesSelector)}(window,function(e,t){var i={};i.extend=function(e,t){for(var i in t)e[i]=t[i];return e},i.modulo=function(e,t){return(e%t+t)%t},i.makeArray=function(e){var t=[];if(Array.isArray(e))t=e;else if(e&&"number"==typeof e.length)for(var i=0;i<e.length;i++)t.push(e[i]);else t.push(e);return t},i.removeFrom=function(e,t){var i=e.indexOf(t);i!=-1&&e.splice(i,1)},i.getParent=function(e,i){for(;e!=document.body;)if(e=e.parentNode,t(e,i))return e},i.getQueryElement=function(e){return"string"==typeof e?document.querySelector(e):e},i.handleEvent=function(e){var t="on"+e.type;this[t]&&this[t](e)},i.filterFindElements=function(e,n){e=i.makeArray(e);var a=[];return e.forEach(function(e){if(e instanceof HTMLElement){if(!n)return void a.push(e);t(e,n)&&a.push(e);for(var i=e.querySelectorAll(n),o=0;o<i.length;o++)a.push(i[o])}}),a},i.debounceMethod=function(e,t,i){var n=e.prototype[t],a=t+"Timeout";e.prototype[t]=function(){var e=this[a];e&&clearTimeout(e);var t=arguments,o=this;this[a]=setTimeout(function(){n.apply(o,t),delete o[a]},i||100)}},i.docReady=function(e){var t=document.readyState;"complete"==t||"interactive"==t?e():document.addEventListener("DOMContentLoaded",e)},i.toDashed=function(e){return e.replace(/(.)([A-Z])/g,function(e,t,i){return t+"-"+i}).toLowerCase()};var n=e.console;return i.htmlInit=function(t,a){i.docReady(function(){var o=i.toDashed(a),s="data-"+o,r=document.querySelectorAll("["+s+"]"),l=document.querySelectorAll(".js-"+o),d=i.makeArray(r).concat(i.makeArray(l)),u=s+"-options",c=e.jQuery;d.forEach(function(e){var i,o=e.getAttribute(s)||e.getAttribute(u);try{i=o&&JSON.parse(o)}catch(t){return void(n&&n.error("Error parsing "+s+" on "+e.className+": "+t))}var r=new t(e,i);c&&c.data(e,a,r)})})},i}),function(e,t){"function"==typeof define&&define.amd?define("outlayer/item",["ev-emitter/ev-emitter","get-size/get-size"],t):"object"==typeof module&&module.exports?module.exports=t(require("ev-emitter"),require("get-size")):(e.Outlayer={},e.Outlayer.Item=t(e.EvEmitter,e.getSize))}(window,function(e,t){"use strict";function i(e){for(var t in e)return!1;return t=null,!0}function n(e,t){e&&(this.element=e,this.layout=t,this.position={x:0,y:0},this._create())}function a(e){return e.replace(/([A-Z])/g,function(e){return"-"+e.toLowerCase()})}var o=document.documentElement.style,s="string"==typeof o.transition?"transition":"WebkitTransition",r="string"==typeof o.transform?"transform":"WebkitTransform",l={WebkitTransition:"webkitTransitionEnd",transition:"transitionend"}[s],d={transform:r,transition:s,transitionDuration:s+"Duration",transitionProperty:s+"Property",transitionDelay:s+"Delay"},u=n.prototype=Object.create(e.prototype);u.constructor=n,u._create=function(){this._transn={ingProperties:{},clean:{},onEnd:{}},this.css({position:"absolute"})},u.handleEvent=function(e){var t="on"+e.type;this[t]&&this[t](e)},u.getSize=function(){this.size=t(this.element)},u.css=function(e){var t=this.element.style;for(var i in e){var n=d[i]||i;t[n]=e[i]}},u.getPosition=function(){var e=getComputedStyle(this.element),t=this.layout._getOption("originLeft"),i=this.layout._getOption("originTop"),n=e[t?"left":"right"],a=e[i?"top":"bottom"],o=this.layout.size,s=n.indexOf("%")!=-1?parseFloat(n)/100*o.width:parseInt(n,10),r=a.indexOf("%")!=-1?parseFloat(a)/100*o.height:parseInt(a,10);s=isNaN(s)?0:s,r=isNaN(r)?0:r,s-=t?o.paddingLeft:o.paddingRight,r-=i?o.paddingTop:o.paddingBottom,this.position.x=s,this.position.y=r},u.layoutPosition=function(){var e=this.layout.size,t={},i=this.layout._getOption("originLeft"),n=this.layout._getOption("originTop"),a=i?"paddingLeft":"paddingRight",o=i?"left":"right",s=i?"right":"left",r=this.position.x+e[a];t[o]=this.getXValue(r),t[s]="";var l=n?"paddingTop":"paddingBottom",d=n?"top":"bottom",u=n?"bottom":"top",c=this.position.y+e[l];t[d]=this.getYValue(c),t[u]="",this.css(t),this.emitEvent("layout",[this])},u.getXValue=function(e){var t=this.layout._getOption("horizontal");return this.layout.options.percentPosition&&!t?e/this.layout.size.width*100+"%":e+"px"},u.getYValue=function(e){var t=this.layout._getOption("horizontal");return this.layout.options.percentPosition&&t?e/this.layout.size.height*100+"%":e+"px"},u._transitionTo=function(e,t){this.getPosition();var i=this.position.x,n=this.position.y,a=parseInt(e,10),o=parseInt(t,10),s=a===this.position.x&&o===this.position.y;if(this.setPosition(e,t),s&&!this.isTransitioning)return void this.layoutPosition();var r=e-i,l=t-n,d={};d.transform=this.getTranslate(r,l),this.transition({to:d,onTransitionEnd:{transform:this.layoutPosition},isCleaning:!0})},u.getTranslate=function(e,t){var i=this.layout._getOption("originLeft"),n=this.layout._getOption("originTop");return e=i?e:-e,t=n?t:-t,"translate3d("+e+"px, "+t+"px, 0)"},u.goTo=function(e,t){this.setPosition(e,t),this.layoutPosition()},u.moveTo=u._transitionTo,u.setPosition=function(e,t){this.position.x=parseInt(e,10),this.position.y=parseInt(t,10)},u._nonTransition=function(e){this.css(e.to),e.isCleaning&&this._removeStyles(e.to);for(var t in e.onTransitionEnd)e.onTransitionEnd[t].call(this)},u.transition=function(e){if(!parseFloat(this.layout.options.transitionDuration))return void this._nonTransition(e);var t=this._transn;for(var i in e.onTransitionEnd)t.onEnd[i]=e.onTransitionEnd[i];for(i in e.to)t.ingProperties[i]=!0,e.isCleaning&&(t.clean[i]=!0);if(e.from){this.css(e.from);var n=this.element.offsetHeight;n=null}this.enableTransition(e.to),this.css(e.to),this.isTransitioning=!0};var c="opacity,"+a(r);u.enableTransition=function(){if(!this.isTransitioning){var e=this.layout.options.transitionDuration;e="number"==typeof e?e+"ms":e,this.css({transitionProperty:c,transitionDuration:e,transitionDelay:this.staggerDelay||0}),this.element.addEventListener(l,this,!1)}},u.onwebkitTransitionEnd=function(e){this.ontransitionend(e)},u.onotransitionend=function(e){this.ontransitionend(e)};var p={"-webkit-transform":"transform"};u.ontransitionend=function(e){if(e.target===this.element){var t=this._transn,n=p[e.propertyName]||e.propertyName;if(delete t.ingProperties[n],i(t.ingProperties)&&this.disableTransition(),n in t.clean&&(this.element.style[e.propertyName]="",delete t.clean[n]),n in t.onEnd){var a=t.onEnd[n];a.call(this),delete t.onEnd[n]}this.emitEvent("transitionEnd",[this])}},u.disableTransition=function(){this.removeTransitionStyles(),this.element.removeEventListener(l,this,!1),this.isTransitioning=!1},u._removeStyles=function(e){var t={};for(var i in e)t[i]="";this.css(t)};var h={transitionProperty:"",transitionDuration:"",transitionDelay:""};return u.removeTransitionStyles=function(){this.css(h)},u.stagger=function(e){e=isNaN(e)?0:e,this.staggerDelay=e+"ms"},u.removeElem=function(){this.element.parentNode.removeChild(this.element),this.css({display:""}),this.emitEvent("remove",[this])},u.remove=function(){return s&&parseFloat(this.layout.options.transitionDuration)?(this.once("transitionEnd",function(){this.removeElem()}),void this.hide()):void this.removeElem()},u.reveal=function(){delete this.isHidden,this.css({display:""});var e=this.layout.options,t={},i=this.getHideRevealTransitionEndProperty("visibleStyle");t[i]=this.onRevealTransitionEnd,this.transition({from:e.hiddenStyle,to:e.visibleStyle,isCleaning:!0,onTransitionEnd:t})},u.onRevealTransitionEnd=function(){this.isHidden||this.emitEvent("reveal")},u.getHideRevealTransitionEndProperty=function(e){var t=this.layout.options[e];if(t.opacity)return"opacity";for(var i in t)return i},u.hide=function(){this.isHidden=!0,this.css({display:""});var e=this.layout.options,t={},i=this.getHideRevealTransitionEndProperty("hiddenStyle");t[i]=this.onHideTransitionEnd,this.transition({from:e.visibleStyle,to:e.hiddenStyle,isCleaning:!0,onTransitionEnd:t})},u.onHideTransitionEnd=function(){this.isHidden&&(this.css({display:"none"}),this.emitEvent("hide"))},u.destroy=function(){this.css({position:"",left:"",right:"",top:"",bottom:"",transition:"",transform:""})},n}),function(e,t){"use strict";"function"==typeof define&&define.amd?define("outlayer/outlayer",["ev-emitter/ev-emitter","get-size/get-size","fizzy-ui-utils/utils","./item"],function(i,n,a,o){return t(e,i,n,a,o)}):"object"==typeof module&&module.exports?module.exports=t(e,require("ev-emitter"),require("get-size"),require("fizzy-ui-utils"),require("./item")):e.Outlayer=t(e,e.EvEmitter,e.getSize,e.fizzyUIUtils,e.Outlayer.Item)}(window,function(e,t,i,n,a){"use strict";function o(e,t){var i=n.getQueryElement(e);if(!i)return void(l&&l.error("Bad element for "+this.constructor.namespace+": "+(i||e)));this.element=i,d&&(this.$element=d(this.element)),this.options=n.extend({},this.constructor.defaults),this.option(t);var a=++c;this.element.outlayerGUID=a,p[a]=this,this._create();var o=this._getOption("initLayout");o&&this.layout()}function s(e){function t(){e.apply(this,arguments)}return t.prototype=Object.create(e.prototype),t.prototype.constructor=t,t}function r(e){if("number"==typeof e)return e;var t=e.match(/(^\d*\.?\d*)(\w*)/),i=t&&t[1],n=t&&t[2];if(!i.length)return 0;i=parseFloat(i);var a=f[n]||1;return i*a}var l=e.console,d=e.jQuery,u=function(){},c=0,p={};o.namespace="outlayer",o.Item=a,o.defaults={containerStyle:{position:"relative"},initLayout:!0,originLeft:!0,originTop:!0,resize:!0,resizeContainer:!0,transitionDuration:"0.4s",hiddenStyle:{opacity:0,transform:"scale(0.001)"},visibleStyle:{opacity:1,transform:"scale(1)"}};var h=o.prototype;n.extend(h,t.prototype),h.option=function(e){n.extend(this.options,e)},h._getOption=function(e){var t=this.constructor.compatOptions[e];return t&&void 0!==this.options[t]?this.options[t]:this.options[e]},o.compatOptions={initLayout:"isInitLayout",horizontal:"isHorizontal",layoutInstant:"isLayoutInstant",originLeft:"isOriginLeft",originTop:"isOriginTop",resize:"isResizeBound",resizeContainer:"isResizingContainer"},h._create=function(){this.reloadItems(),this.stamps=[],this.stamp(this.options.stamp),n.extend(this.element.style,this.options.containerStyle);var e=this._getOption("resize");e&&this.bindResize()},h.reloadItems=function(){this.items=this._itemize(this.element.children)},h._itemize=function(e){for(var t=this._filterFindItemElements(e),i=this.constructor.Item,n=[],a=0;a<t.length;a++){var o=t[a],s=new i(o,this);n.push(s)}return n},h._filterFindItemElements=function(e){return n.filterFindElements(e,this.options.itemSelector)},h.getItemElements=function(){return this.items.map(function(e){return e.element})},h.layout=function(){this._resetLayout(),this._manageStamps();var e=this._getOption("layoutInstant"),t=void 0!==e?e:!this._isLayoutInited;this.layoutItems(this.items,t),this._isLayoutInited=!0},h._init=h.layout,h._resetLayout=function(){this.getSize()},h.getSize=function(){this.size=i(this.element)},h._getMeasurement=function(e,t){var n,a=this.options[e];a?("string"==typeof a?n=this.element.querySelector(a):a instanceof HTMLElement&&(n=a),this[e]=n?i(n)[t]:a):this[e]=0},h.layoutItems=function(e,t){e=this._getItemsForLayout(e),this._layoutItems(e,t),this._postLayout()},h._getItemsForLayout=function(e){return e.filter(function(e){return!e.isIgnored})},h._layoutItems=function(e,t){if(this._emitCompleteOnItems("layout",e),e&&e.length){var i=[];e.forEach(function(e){var n=this._getItemLayoutPosition(e);n.item=e,n.isInstant=t||e.isLayoutInstant,i.push(n)},this),this._processLayoutQueue(i)}},h._getItemLayoutPosition=function(){return{x:0,y:0}},h._processLayoutQueue=function(e){this.updateStagger(),e.forEach(function(e,t){this._positionItem(e.item,e.x,e.y,e.isInstant,t)},this)},h.updateStagger=function(){var e=this.options.stagger;return null===e||void 0===e?void(this.stagger=0):(this.stagger=r(e),this.stagger)},h._positionItem=function(e,t,i,n,a){n?e.goTo(t,i):(e.stagger(a*this.stagger),e.moveTo(t,i))},h._postLayout=function(){this.resizeContainer()},h.resizeContainer=function(){var e=this._getOption("resizeContainer");if(e){var t=this._getContainerSize();t&&(this._setContainerMeasure(t.width,!0),this._setContainerMeasure(t.height,!1))}},h._getContainerSize=u,h._setContainerMeasure=function(e,t){if(void 0!==e){var i=this.size;i.isBorderBox&&(e+=t?i.paddingLeft+i.paddingRight+i.borderLeftWidth+i.borderRightWidth:i.paddingBottom+i.paddingTop+i.borderTopWidth+i.borderBottomWidth),e=Math.max(e,0),this.element.style[t?"width":"height"]=e+"px"}},h._emitCompleteOnItems=function(e,t){function i(){a.dispatchEvent(e+"Complete",null,[t])}function n(){s++,s==o&&i()}var a=this,o=t.length;if(!t||!o)return void i();var s=0;t.forEach(function(t){t.once(e,n)})},h.dispatchEvent=function(e,t,i){var n=t?[t].concat(i):i;if(this.emitEvent(e,n),d)if(this.$element=this.$element||d(this.element),t){var a=d.Event(t);a.type=e,this.$element.trigger(a,i)}else this.$element.trigger(e,i)},h.ignore=function(e){var t=this.getItem(e);t&&(t.isIgnored=!0)},h.unignore=function(e){var t=this.getItem(e);t&&delete t.isIgnored},h.stamp=function(e){e=this._find(e),e&&(this.stamps=this.stamps.concat(e),e.forEach(this.ignore,this))},h.unstamp=function(e){e=this._find(e),e&&e.forEach(function(e){n.removeFrom(this.stamps,e),this.unignore(e)},this)},h._find=function(e){if(e)return"string"==typeof e&&(e=this.element.querySelectorAll(e)),e=n.makeArray(e)},h._manageStamps=function(){this.stamps&&this.stamps.length&&(this._getBoundingRect(),this.stamps.forEach(this._manageStamp,this))},h._getBoundingRect=function(){var e=this.element.getBoundingClientRect(),t=this.size;this._boundingRect={left:e.left+t.paddingLeft+t.borderLeftWidth,top:e.top+t.paddingTop+t.borderTopWidth,right:e.right-(t.paddingRight+t.borderRightWidth),bottom:e.bottom-(t.paddingBottom+t.borderBottomWidth)}},h._manageStamp=u,h._getElementOffset=function(e){var t=e.getBoundingClientRect(),n=this._boundingRect,a=i(e),o={left:t.left-n.left-a.marginLeft,top:t.top-n.top-a.marginTop,right:n.right-t.right-a.marginRight,bottom:n.bottom-t.bottom-a.marginBottom};return o},h.handleEvent=n.handleEvent,h.bindResize=function(){e.addEventListener("resize",this),this.isResizeBound=!0},h.unbindResize=function(){e.removeEventListener("resize",this),this.isResizeBound=!1},h.onresize=function(){this.resize()},n.debounceMethod(o,"onresize",100),h.resize=function(){this.isResizeBound&&this.needsResizeLayout()&&this.layout()},h.needsResizeLayout=function(){var e=i(this.element),t=this.size&&e;return t&&e.innerWidth!==this.size.innerWidth},h.addItems=function(e){var t=this._itemize(e);return t.length&&(this.items=this.items.concat(t)),t},h.appended=function(e){var t=this.addItems(e);t.length&&(this.layoutItems(t,!0),this.reveal(t))},h.prepended=function(e){var t=this._itemize(e);if(t.length){var i=this.items.slice(0);this.items=t.concat(i),this._resetLayout(),this._manageStamps(),this.layoutItems(t,!0),this.reveal(t),this.layoutItems(i)}},h.reveal=function(e){if(this._emitCompleteOnItems("reveal",e),e&&e.length){var t=this.updateStagger();e.forEach(function(e,i){e.stagger(i*t),e.reveal()})}},h.hide=function(e){if(this._emitCompleteOnItems("hide",e),e&&e.length){var t=this.updateStagger();e.forEach(function(e,i){e.stagger(i*t),e.hide()})}},h.revealItemElements=function(e){var t=this.getItems(e);this.reveal(t)},h.hideItemElements=function(e){var t=this.getItems(e);this.hide(t)},h.getItem=function(e){for(var t=0;t<this.items.length;t++){var i=this.items[t];if(i.element==e)return i}},h.getItems=function(e){e=n.makeArray(e);var t=[];return e.forEach(function(e){var i=this.getItem(e);i&&t.push(i)},this),t},h.remove=function(e){var t=this.getItems(e);this._emitCompleteOnItems("remove",t),t&&t.length&&t.forEach(function(e){e.remove(),n.removeFrom(this.items,e)},this)},h.destroy=function(){var e=this.element.style;e.height="",e.position="",e.width="",this.items.forEach(function(e){e.destroy()}),this.unbindResize();var t=this.element.outlayerGUID;delete p[t],delete this.element.outlayerGUID,d&&d.removeData(this.element,this.constructor.namespace)},o.data=function(e){e=n.getQueryElement(e);var t=e&&e.outlayerGUID;return t&&p[t]},o.create=function(e,t){var i=s(o);return i.defaults=n.extend({},o.defaults),n.extend(i.defaults,t),i.compatOptions=n.extend({},o.compatOptions),i.namespace=e,i.data=o.data,i.Item=s(a),n.htmlInit(i,e),d&&d.bridget&&d.bridget(e,i),i};var f={ms:1,s:1e3};return o.Item=a,o}),function(e,t){"function"==typeof define&&define.amd?define(["outlayer/outlayer","get-size/get-size"],t):"object"==typeof module&&module.exports?module.exports=t(require("outlayer"),require("get-size")):e.Masonry=t(e.Outlayer,e.getSize)}(window,function(e,t){var i=e.create("masonry");return i.compatOptions.fitWidth="isFitWidth",i.prototype._resetLayout=function(){this.getSize(),this._getMeasurement("columnWidth","outerWidth"),this._getMeasurement("gutter","outerWidth"),this.measureColumns(),this.colYs=[];for(var e=0;e<this.cols;e++)this.colYs.push(0);this.maxY=0},i.prototype.measureColumns=function(){if(this.getContainerWidth(),!this.columnWidth){var e=this.items[0],i=e&&e.element;this.columnWidth=i&&t(i).outerWidth||this.containerWidth}var n=this.columnWidth+=this.gutter,a=this.containerWidth+this.gutter,o=a/n,s=n-a%n,r=s&&s<1?"round":"floor";o=Math[r](o),this.cols=Math.max(o,1)},i.prototype.getContainerWidth=function(){var e=this._getOption("fitWidth"),i=e?this.element.parentNode:this.element,n=t(i);this.containerWidth=n&&n.innerWidth},i.prototype._getItemLayoutPosition=function(e){e.getSize();var t=e.size.outerWidth%this.columnWidth,i=t&&t<1?"round":"ceil",n=Math[i](e.size.outerWidth/this.columnWidth);n=Math.min(n,this.cols);for(var a=this._getColGroup(n),o=Math.min.apply(Math,a),s=a.indexOf(o),r={x:this.columnWidth*s,y:o},l=o+e.size.outerHeight,d=this.cols+1-a.length,u=0;u<d;u++)this.colYs[s+u]=l;return r},i.prototype._getColGroup=function(e){if(e<2)return this.colYs;for(var t=[],i=this.cols+1-e,n=0;n<i;n++){var a=this.colYs.slice(n,n+e);t[n]=Math.max.apply(Math,a)}return t},i.prototype._manageStamp=function(e){var i=t(e),n=this._getElementOffset(e),a=this._getOption("originLeft"),o=a?n.left:n.right,s=o+i.outerWidth,r=Math.floor(o/this.columnWidth);r=Math.max(0,r);var l=Math.floor(s/this.columnWidth);l-=s%this.columnWidth?0:1,l=Math.min(this.cols-1,l);for(var d=this._getOption("originTop"),u=(d?n.top:n.bottom)+i.outerHeight,c=r;c<=l;c++)this.colYs[c]=Math.max(u,this.colYs[c])},i.prototype._getContainerSize=function(){this.maxY=Math.max.apply(Math,this.colYs);var e={height:this.maxY};return this._getOption("fitWidth")&&(e.width=this._getContainerFitWidth()),e},i.prototype._getContainerFitWidth=function(){for(var e=0,t=this.cols;--t&&0===this.colYs[t];)e++;return(this.cols-e)*this.columnWidth-this.gutter},i.prototype.needsResizeLayout=function(){var e=this.containerWidth;return this.getContainerWidth(),e!=this.containerWidth},i});
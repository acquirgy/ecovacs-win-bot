// page init
$(document).ready(function () {
    jcf.customForms.replaceAll();
    initLightbox();
    initSameHeight();
});

function close_fb() {

jQuery.fancybox.close();

}

// fancybox modal popup init
function initLightbox() {
	var android = /(android)/gi.test(navigator.userAgent);
	var isTouchDevice = (/MSIE 10.*Touch/.test(navigator.userAgent)) || ('ontouchstart' in window) || window.DocumentTouch && document instanceof DocumentTouch;
	jQuery('a.lightbox, a[rel*="lightbox"]').each(function(){
		var link = jQuery(this);
		link.fancybox({
			padding:0,
			cyclic: false,
			overlayShow: true,
			overlayOpacity: 0.65,
			overlayColor: '#000000',
			titlePosition: 'inside',
			onComplete: function(box) {
				if(link.attr('href').indexOf('#') === 0) {
					jQuery('#fancybox-content').find('a.close').unbind('click.fb').bind('click.fb', function(e){
						jQuery.fancybox.close();
						e.preventDefault();
					});
				}
				if(isTouchDevice){
					var win = jQuery(window);
					jQuery('#fancybox-overlay').css({width:'100%',height:'100%'}).css({
						width: Math.max(win.width(),jQuery(document).width()),
						height: Math.max(win.height(),jQuery(document).height())
					})
					win.bind('resize orientationchange',function(){
						jQuery('#fancybox-overlay').css({width:'100%',height:'100%'});
						setTimeout(function(){
							jQuery('#fancybox-overlay').css({
								width: Math.max(win.width(),jQuery(document).width()),
								height: Math.max(win.height(),jQuery(document).height())
							})
						},200)
					})
				}
			}
		});
	});
	if(isTouchDevice){
		jQuery('#fancybox-overlay').addClass('absolute');
	}
}

/* Fancybox overlay fix */
jQuery(function(){
	// detect device type
	var isTouchDevice = (function() {
		try {
			return ('ontouchstart' in window) || window.DocumentTouch && document instanceof DocumentTouch;
		} catch (e) {
			return false;
		}
	}());

	// fix options
	var supportPositionFixed = !( (jQuery.browser.msie && jQuery.browser.version < 8) || isTouchDevice );
	var overlaySelector = '#fancybox-overlay';

	if(supportPositionFixed) {
		// create <style> rules
		var head = document.getElementsByTagName('head')[0],
			style = document.createElement('style'),
			rules = document.createTextNode(overlaySelector+'{'+
				'position:fixed;'+
				'top:0;'+
				'left:0;'+
			'}');

		// append style element
		style.type = 'text/css';
		if(style.styleSheet) {
			style.styleSheet.cssText = rules.nodeValue;
		} else {
			style.appendChild(rules);
		}
		head.appendChild(style);
	}
});

// align blocks height
function initSameHeight() {
	jQuery('div.threecolumns').sameHeight({
		elements: 'article.column',
		flexible: true,
		multiLine: true,
		biggestHeight: true
	});
	jQuery('.same').sameHeight({
		elements: '.same-height',
		flexible: true,
		multiLine: true
	});
}

/*
 * jQuery SameHeight plugin
 */
;(function($){
	$.fn.sameHeight = function(opt) {
		var options = $.extend({
			skipClass: 'same-height-ignore',
			leftEdgeClass: 'same-height-left',
			rightEdgeClass: 'same-height-right',
			elements: '>*',
			flexible: false,
			multiLine: false,
			useMinHeight: false,
			biggestHeight: false
		},opt);
		return this.each(function(){
			var holder = $(this), postResizeTimer, ignoreResize;
			var elements = holder.find(options.elements).not('.' + options.skipClass);
			if(!elements.length) return;

			// resize handler
			function doResize() {
				elements.css(options.useMinHeight && supportMinHeight ? 'minHeight' : 'height', '');
				if(options.multiLine) {
					// resize elements row by row
					resizeElementsByRows(elements, options);
				} else {
					// resize elements by holder
					resizeElements(elements, holder, options);
				}
			}
			doResize();

			// handle flexible layout / font resize
			var delayedResizeHandler = function() {
				if(!ignoreResize) {
					ignoreResize = true;
					doResize();
					clearTimeout(postResizeTimer);
					postResizeTimer = setTimeout(function() {
						doResize();
						setTimeout(function(){
							ignoreResize = false;
						}, 10);
					}, 100);
				}
			};

			// handle flexible/responsive layout
			if(options.flexible) {
				$(window).bind('resize orientationchange fontresize', delayedResizeHandler);
			}

			// handle complete page load including images and fonts
			$(window).bind('load', delayedResizeHandler);
		});
	};

	// detect css min-height support
	var supportMinHeight = typeof document.documentElement.style.maxHeight !== 'undefined';

	// get elements by rows
	function resizeElementsByRows(boxes, options) {
		var currentRow = $(), maxHeight, maxCalcHeight = 0, firstOffset = boxes.eq(0).offset().top;
		boxes.each(function(ind){
			var curItem = $(this);
			if(curItem.offset().top === firstOffset) {
				currentRow = currentRow.add(this);
			} else {
				maxHeight = getMaxHeight(currentRow);
				maxCalcHeight = Math.max(maxCalcHeight, resizeElements(currentRow, maxHeight, options));
				currentRow = curItem;
				firstOffset = curItem.offset().top;
			}
		});
		if(currentRow.length) {
			maxHeight = getMaxHeight(currentRow);
			maxCalcHeight = Math.max(maxCalcHeight, resizeElements(currentRow, maxHeight, options));
		}
		if(options.biggestHeight) {
			boxes.css(options.useMinHeight && supportMinHeight ? 'minHeight' : 'height', maxCalcHeight);
		}
	}

	// calculate max element height
	function getMaxHeight(boxes) {
		var maxHeight = 0;
		boxes.each(function(){
			maxHeight = Math.max(maxHeight, $(this).outerHeight());
		});
		return maxHeight;
	}

	// resize helper function
	function resizeElements(boxes, parent, options) {
		var calcHeight;
		var parentHeight = typeof parent === 'number' ? parent : parent.height();
		boxes.removeClass(options.leftEdgeClass).removeClass(options.rightEdgeClass).each(function(i){
			var element = $(this);
			var depthDiffHeight = 0;
			var isBorderBox = element.css('boxSizing') === 'border-box';

			if(typeof parent !== 'number') {
				element.parents().each(function(){
					var tmpParent = $(this);
					if(parent.is(this)) {
						return false;
					} else {
						depthDiffHeight += tmpParent.outerHeight() - tmpParent.height();
					}
				});
			}
			calcHeight = parentHeight - depthDiffHeight;
			calcHeight -= isBorderBox ? 0 : element.outerHeight() - element.height();

			if(calcHeight > 0) {
				element.css(options.useMinHeight && supportMinHeight ? 'minHeight' : 'height', calcHeight);
			}
		});
		boxes.filter(':first').addClass(options.leftEdgeClass);
		boxes.filter(':last').addClass(options.rightEdgeClass);
		return calcHeight;
	}
}(jQuery));

/*
 * jQuery FontResize Event
 */
jQuery.onFontResize = (function($) {
	$(function() {
		var randomID = 'font-resize-frame-' + Math.floor(Math.random() * 1000);
		var resizeFrame = $('<iframe>').attr('id', randomID).addClass('font-resize-helper');

		// required styles
		resizeFrame.css({
			width: '100em',
			height: '10px',
			position: 'absolute',
			borderWidth: 0,
			top: '-9999px',
			left: '-9999px'
		}).appendTo('body');

		// use native IE resize event if possible
		if (window.attachEvent && !window.addEventListener) {
			resizeFrame.bind('resize', function () {
				$.onFontResize.trigger(resizeFrame[0].offsetWidth / 100);
			});
		}
		// use script inside the iframe to detect resize for other browsers
		else {
			var doc = resizeFrame[0].contentWindow.document;
			doc.open();
			doc.write('<scri' + 'pt>window.onload = function(){var em = parent.jQuery("#' + randomID + '")[0];window.onresize = function(){if(parent.jQuery.onFontResize){parent.jQuery.onFontResize.trigger(em.offsetWidth / 100);}}};</scri' + 'pt>');
			doc.close();
		}
		jQuery.onFontResize.initialSize = resizeFrame[0].offsetWidth / 100;
	});
	return {
		// public method, so it can be called from within the iframe
		trigger: function (em) {
			$(window).trigger("fontresize", [em]);
		}
	};
}(jQuery));

/*
 * JavaScript Custom Forms Module
 */
jcf = {
	// global options
	modules: {},
	plugins: {},
	baseOptions: {
		unselectableClass:'jcf-unselectable',
		labelActiveClass:'jcf-label-active',
		labelDisabledClass:'jcf-label-disabled',
		classPrefix: 'jcf-class-',
		hiddenClass:'jcf-hidden',
		focusClass:'jcf-focus',
		wrapperTag: 'div'
	},
	// replacer function
	customForms: {
		setOptions: function(obj) {
			for(var p in obj) {
				if(obj.hasOwnProperty(p) && typeof obj[p] === 'object') {
					jcf.lib.extend(jcf.modules[p].prototype.defaultOptions, obj[p]);
				}
			}
		},
		replaceAll: function(context) {
			for(var k in jcf.modules) {
				var els = jcf.lib.queryBySelector(jcf.modules[k].prototype.selector, context);
				for(var i = 0; i<els.length; i++) {
					if(els[i].jcf) {
						// refresh form element state
						els[i].jcf.refreshState();
					} else {
						// replace form element
						if(!jcf.lib.hasClass(els[i], 'default') && jcf.modules[k].prototype.checkElement(els[i])) {
							new jcf.modules[k]({
								replaces:els[i]
							});
						}
					}
				}
			}
		},
		refreshAll: function(context) {
			for(var k in jcf.modules) {
				var els = jcf.lib.queryBySelector(jcf.modules[k].prototype.selector, context);
				for(var i = 0; i<els.length; i++) {
					if(els[i].jcf) {
						// refresh form element state
						els[i].jcf.refreshState();
					}
				}
			}
		},
		refreshElement: function(obj) {
			if(obj && obj.jcf) {
				obj.jcf.refreshState();
			}
		},
		destroyAll: function() {
			for(var k in jcf.modules) {
				var els = jcf.lib.queryBySelector(jcf.modules[k].prototype.selector);
				for(var i = 0; i<els.length; i++) {
					if(els[i].jcf) {
						els[i].jcf.destroy();
					}
				}
			}
		}
	},
	// detect device type
	isTouchDevice: ('ontouchstart' in window) || window.DocumentTouch && document instanceof DocumentTouch,
	isWinPhoneDevice: navigator.msPointerEnabled && /MSIE 10.*Touch/.test(navigator.userAgent),
	// define base module
	setBaseModule: function(obj) {
		jcf.customControl = function(opt){
			this.options = jcf.lib.extend({}, jcf.baseOptions, this.defaultOptions, opt);
			this.init();
		};
		for(var p in obj) {
			jcf.customControl.prototype[p] = obj[p];
		}
	},
	// add module to jcf.modules
	addModule: function(obj) {
		if(obj.name){
			// create new module proto class
			jcf.modules[obj.name] = function(){
				jcf.modules[obj.name].superclass.constructor.apply(this, arguments);
			}
			jcf.lib.inherit(jcf.modules[obj.name], jcf.customControl);
			for(var p in obj) {
				jcf.modules[obj.name].prototype[p] = obj[p]
			}
			// on create module
			jcf.modules[obj.name].prototype.onCreateModule();
			// make callback for exciting modules
			for(var mod in jcf.modules) {
				if(jcf.modules[mod] != jcf.modules[obj.name]) {
					jcf.modules[mod].prototype.onModuleAdded(jcf.modules[obj.name]);
				}
			}
		}
	},
	// add plugin to jcf.plugins
	addPlugin: function(obj) {
		if(obj && obj.name) {
			jcf.plugins[obj.name] = function() {
				this.init.apply(this, arguments);
			}
			for(var p in obj) {
				jcf.plugins[obj.name].prototype[p] = obj[p];
			}
		}
	},
	// miscellaneous init
	init: function(){
		if(navigator.msPointerEnabled) {
			this.eventPress = 'MSPointerDown';
			this.eventMove = 'MSPointerMove';
			this.eventRelease = 'MSPointerUp';
		} else {
			this.eventPress = this.isTouchDevice ? 'touchstart' : 'mousedown';
			this.eventMove = this.isTouchDevice ? 'touchmove' : 'mousemove';
			this.eventRelease = this.isTouchDevice ? 'touchend' : 'mouseup';
		}

		setTimeout(function(){
			jcf.lib.domReady(function(){
				jcf.initStyles();
			});
		},1);
		return this;
	},
	initStyles: function() {
		// create <style> element and rules
		var head = document.getElementsByTagName('head')[0],
			style = document.createElement('style'),
			rules = document.createTextNode('.'+jcf.baseOptions.unselectableClass+'{'+
				'-moz-user-select:none;'+
				'-webkit-tap-highlight-color:rgba(255,255,255,0);'+
				'-webkit-user-select:none;'+
				'user-select:none;'+
			'}');

		// append style element
		style.type = 'text/css';
		if(style.styleSheet) {
			style.styleSheet.cssText = rules.nodeValue;
		} else {
			style.appendChild(rules);
		}
		head.appendChild(style);
	}
}.init();

/*
 * Custom Form Control prototype
 */
jcf.setBaseModule({
	init: function(){
		if(this.options.replaces) {
			this.realElement = this.options.replaces;
			this.realElement.jcf = this;
			this.replaceObject();
		}
	},
	defaultOptions: {
		// default module options (will be merged with base options)
	},
	checkElement: function(el){
		return true; // additional check for correct form element
	},
	replaceObject: function(){
		this.createWrapper();
		this.attachEvents();
		this.fixStyles();
		this.setupWrapper();
	},
	createWrapper: function(){
		this.fakeElement = jcf.lib.createElement(this.options.wrapperTag);
		this.labelFor = jcf.lib.getLabelFor(this.realElement);
		jcf.lib.disableTextSelection(this.fakeElement);
		jcf.lib.addClass(this.fakeElement, jcf.lib.getAllClasses(this.realElement.className, this.options.classPrefix));
		jcf.lib.addClass(this.realElement, jcf.baseOptions.hiddenClass);
	},
	attachEvents: function(){
		jcf.lib.event.add(this.realElement, 'focus', this.onFocusHandler, this);
		jcf.lib.event.add(this.realElement, 'blur', this.onBlurHandler, this);
		jcf.lib.event.add(this.fakeElement, 'click', this.onFakeClick, this);
		jcf.lib.event.add(this.fakeElement, jcf.eventPress, this.onFakePressed, this);
		jcf.lib.event.add(this.fakeElement, jcf.eventRelease, this.onFakeReleased, this);

		if(this.labelFor) {
			this.labelFor.jcf = this;
			jcf.lib.event.add(this.labelFor, 'click', this.onFakeClick, this);
			jcf.lib.event.add(this.labelFor, jcf.eventPress, this.onFakePressed, this);
			jcf.lib.event.add(this.labelFor, jcf.eventRelease, this.onFakeReleased, this);
		}
	},
	fixStyles: function() {
		// hide mobile webkit tap effect
		if(jcf.isTouchDevice) {
			var tapStyle = 'rgba(255,255,255,0)';
			this.realElement.style.webkitTapHighlightColor = tapStyle;
			this.fakeElement.style.webkitTapHighlightColor = tapStyle;
			if(this.labelFor) {
				this.labelFor.style.webkitTapHighlightColor = tapStyle;
			}
		}
	},
	setupWrapper: function(){
		// implement in subclass
	},
	refreshState: function(){
		// implement in subclass
	},
	destroy: function() {
		if(this.fakeElement && this.fakeElement.parentNode) {
			this.fakeElement.parentNode.removeChild(this.fakeElement);
		}
		jcf.lib.removeClass(this.realElement, jcf.baseOptions.hiddenClass);
		this.realElement.jcf = null;
	},
	onFocus: function(){
		// emulated focus event
		jcf.lib.addClass(this.fakeElement,this.options.focusClass);
	},
	onBlur: function(cb){
		// emulated blur event
		jcf.lib.removeClass(this.fakeElement,this.options.focusClass);
	},
	onFocusHandler: function() {
		// handle focus loses
		if(this.focused) return;
		this.focused = true;

		// handle touch devices also
		if(jcf.isTouchDevice) {
			if(jcf.focusedInstance && jcf.focusedInstance.realElement != this.realElement) {
				jcf.focusedInstance.onBlur();
				jcf.focusedInstance.realElement.blur();
			}
			jcf.focusedInstance = this;
		}
		this.onFocus.apply(this, arguments);
	},
	onBlurHandler: function() {
		// handle focus loses
		if(!this.pressedFlag) {
			this.focused = false;
			this.onBlur.apply(this, arguments);
		}
	},
	onFakeClick: function(){
		if(jcf.isTouchDevice) {
			this.onFocus();
		} else if(!this.realElement.disabled) {
			this.realElement.focus();
		}
	},
	onFakePressed: function(e){
		this.pressedFlag = true;
	},
	onFakeReleased: function(){
		this.pressedFlag = false;
	},
	onCreateModule: function(){
		// implement in subclass
	},
	onModuleAdded: function(module) {
		// implement in subclass
	},
	onControlReady: function() {
		// implement in subclass
	}
});

/*
 * JCF Utility Library
 */
jcf.lib = {
	bind: function(func, scope){
		return function() {
			return func.apply(scope, arguments);
		};
	},
	browser: (function() {
		var ua = navigator.userAgent.toLowerCase(), res = {},
		match = /(webkit)[ \/]([\w.]+)/.exec(ua) || /(opera)(?:.*version)?[ \/]([\w.]+)/.exec(ua) ||
				/(msie) ([\w.]+)/.exec(ua) || ua.indexOf("compatible") < 0 && /(mozilla)(?:.*? rv:([\w.]+))?/.exec(ua) || [];
		res[match[1]] = true;
		res.version = match[2] || "0";
		res.safariMac = ua.indexOf('mac') != -1 && ua.indexOf('safari') != -1;
		return res;
	})(),
	getOffset: function (obj) {
		if (obj.getBoundingClientRect && !jcf.isWinPhoneDevice) {
			var scrollLeft = window.pageXOffset || document.documentElement.scrollLeft || document.body.scrollLeft;
			var scrollTop = window.pageYOffset || document.documentElement.scrollTop || document.body.scrollTop;
			var clientLeft = document.documentElement.clientLeft || document.body.clientLeft || 0;
			var clientTop = document.documentElement.clientTop || document.body.clientTop || 0;
			return {
				top:Math.round(obj.getBoundingClientRect().top + scrollTop - clientTop),
				left:Math.round(obj.getBoundingClientRect().left + scrollLeft - clientLeft)
			};
		} else {
			var posLeft = 0, posTop = 0;
			while (obj.offsetParent) {posLeft += obj.offsetLeft; posTop += obj.offsetTop; obj = obj.offsetParent;}
			return {top:posTop,left:posLeft};
		}
	},
	getScrollTop: function() {
		return window.pageYOffset || document.documentElement.scrollTop;
	},
	getScrollLeft: function() {
		return window.pageXOffset || document.documentElement.scrollLeft;
	},
	getWindowWidth: function(){
		return document.compatMode=='CSS1Compat' ? document.documentElement.clientWidth : document.body.clientWidth;
	},
	getWindowHeight: function(){
		return document.compatMode=='CSS1Compat' ? document.documentElement.clientHeight : document.body.clientHeight;
	},
	getStyle: function(el, prop) {
		if (document.defaultView && document.defaultView.getComputedStyle) {
			return document.defaultView.getComputedStyle(el, null)[prop];
		} else if (el.currentStyle) {
			return el.currentStyle[prop];
		} else {
			return el.style[prop];
		}
	},
	getParent: function(obj, selector) {
		while(obj.parentNode && obj.parentNode != document.body) {
			if(obj.parentNode.tagName.toLowerCase() == selector.toLowerCase()) {
				return obj.parentNode;
			}
			obj = obj.parentNode;
		}
		return false;
	},
	isParent: function(child, parent) {
		while(child.parentNode) {
			if(child.parentNode === parent) {
				return true;
			}
			child = child.parentNode;
		}
		return false;
	},
	getLabelFor: function(object) {
		var parentLabel = jcf.lib.getParent(object,'label');
		if(parentLabel) {
			return parentLabel;
		} else if(object.id) {
			return jcf.lib.queryBySelector('label[for="' + object.id + '"]')[0];
		}
	},
	disableTextSelection: function(el){
		if (typeof el.onselectstart !== 'undefined') {
			el.onselectstart = function() {return false;};
		} else if(window.opera) {
			el.setAttribute('unselectable', 'on');
		} else {
			jcf.lib.addClass(el, jcf.baseOptions.unselectableClass);
		}
	},
	enableTextSelection: function(el) {
		if (typeof el.onselectstart !== 'undefined') {
			el.onselectstart = null;
		} else if(window.opera) {
			el.removeAttribute('unselectable');
		} else {
			jcf.lib.removeClass(el, jcf.baseOptions.unselectableClass);
		}
	},
	queryBySelector: function(selector, scope){
		if(typeof scope === 'string') {
			var result = [];
			var holders = this.getElementsBySelector(scope);
			for (var i = 0, contextNodes; i < holders.length; i++) {
				contextNodes = Array.prototype.slice.call(this.getElementsBySelector(selector, holders[i]));
				result = result.concat(contextNodes);
			}
			return result;
		} else {
			return this.getElementsBySelector(selector, scope);
		}
	},
	prevSibling: function(node) {
		while(node = node.previousSibling) if(node.nodeType == 1) break;
		return node;
	},
	nextSibling: function(node) {
		while(node = node.nextSibling) if(node.nodeType == 1) break;
		return node;
	},
	fireEvent: function(element,event) {
		if(element.dispatchEvent){
			var evt = document.createEvent('HTMLEvents');
			evt.initEvent(event, true, true );
			return !element.dispatchEvent(evt);
		}else if(document.createEventObject){
			var evt = document.createEventObject();
			return element.fireEvent('on'+event,evt);
		}
	},
	isParent: function(p, c) {
		while(c.parentNode) {
			if(p == c) {
				return true;
			}
			c = c.parentNode;
		}
		return false;
	},
	inherit: function(Child, Parent) {
		var F = function() { }
		F.prototype = Parent.prototype
		Child.prototype = new F()
		Child.prototype.constructor = Child
		Child.superclass = Parent.prototype
	},
	extend: function(obj) {
		for(var i = 1; i < arguments.length; i++) {
			for(var p in arguments[i]) {
				if(arguments[i].hasOwnProperty(p)) {
					obj[p] = arguments[i][p];
				}
			}
		}
		return obj;
	},
	hasClass: function (obj,cname) {
		return (obj.className ? obj.className.match(new RegExp('(\\s|^)'+cname+'(\\s|$)')) : false);
	},
	addClass: function (obj,cname) {
		if (!this.hasClass(obj,cname)) obj.className += (!obj.className.length || obj.className.charAt(obj.className.length - 1) === ' ' ? '' : ' ') + cname;
	},
	removeClass: function (obj,cname) {
		if (this.hasClass(obj,cname)) obj.className=obj.className.replace(new RegExp('(\\s|^)'+cname+'(\\s|$)'),' ').replace(/\s+$/, '');
	},
	toggleClass: function(obj, cname, condition) {
		if(condition) this.addClass(obj, cname); else this.removeClass(obj, cname);
	},
	createElement: function(tagName, options) {
		var el = document.createElement(tagName);
		for(var p in options) {
			if(options.hasOwnProperty(p)) {
				switch (p) {
					case 'class': el.className = options[p]; break;
					case 'html': el.innerHTML = options[p]; break;
					case 'style': this.setStyles(el, options[p]); break;
					default: el.setAttribute(p, options[p]);
				}
			}
		}
		return el;
	},
	setStyles: function(el, styles) {
		for(var p in styles) {
			if(styles.hasOwnProperty(p)) {
				switch (p) {
					case 'float': el.style.cssFloat = styles[p]; break;
					case 'opacity': el.style.filter = 'progid:DXImageTransform.Microsoft.Alpha(opacity='+styles[p]*100+')'; el.style.opacity = styles[p]; break;
					default: el.style[p] = (typeof styles[p] === 'undefined' ? 0 : styles[p]) + (typeof styles[p] === 'number' ? 'px' : '');
				}
			}
		}
		return el;
	},
	getInnerWidth: function(el) {
		return el.offsetWidth - (parseInt(this.getStyle(el,'paddingLeft')) || 0) - (parseInt(this.getStyle(el,'paddingRight')) || 0);
	},
	getInnerHeight: function(el) {
		return el.offsetHeight - (parseInt(this.getStyle(el,'paddingTop')) || 0) - (parseInt(this.getStyle(el,'paddingBottom')) || 0);
	},
	getAllClasses: function(cname, prefix, skip) {
		if(!skip) skip = '';
		if(!prefix) prefix = '';
		return cname ? cname.replace(new RegExp('(\\s|^)'+skip+'(\\s|$)'),' ').replace(/[\s]*([\S]+)+[\s]*/gi,prefix+"$1 ") : '';
	},
	getElementsBySelector: function(selector, scope) {
		if(typeof document.querySelectorAll === 'function') {
			return (scope || document).querySelectorAll(selector);
		}
		var selectors = selector.split(',');
		var resultList = [];
		for(var s = 0; s < selectors.length; s++) {
			var currentContext = [scope || document];
			var tokens = selectors[s].replace(/^\s+/,'').replace(/\s+$/,'').split(' ');
			for (var i = 0; i < tokens.length; i++) {
				token = tokens[i].replace(/^\s+/,'').replace(/\s+$/,'');
				if (token.indexOf('#') > -1) {
					var bits = token.split('#'), tagName = bits[0], id = bits[1];
					var element = document.getElementById(id);
					if (tagName && element.nodeName.toLowerCase() != tagName) {
						return [];
					}
					currentContext = [element];
					continue;
				}
				if (token.indexOf('.') > -1) {
					var bits = token.split('.'), tagName = bits[0] || '*', className = bits[1], found = [], foundCount = 0;
					for (var h = 0; h < currentContext.length; h++) {
						var elements;
						if (tagName == '*') {
							elements = currentContext[h].getElementsByTagName('*');
						} else {
							elements = currentContext[h].getElementsByTagName(tagName);
						}
						for (var j = 0; j < elements.length; j++) {
							found[foundCount++] = elements[j];
						}
					}
					currentContext = [];
					var currentContextIndex = 0;
					for (var k = 0; k < found.length; k++) {
						if (found[k].className && found[k].className.match(new RegExp('(\\s|^)'+className+'(\\s|$)'))) {
							currentContext[currentContextIndex++] = found[k];
						}
					}
					continue;
				}
				if (token.match(/^(\w*)\[(\w+)([=~\|\^\$\*]?)=?"?([^\]"]*)"?\]$/)) {
					var tagName = RegExp.$1 || '*', attrName = RegExp.$2, attrOperator = RegExp.$3, attrValue = RegExp.$4;
					if(attrName.toLowerCase() == 'for' && this.browser.msie && this.browser.version < 8) {
						attrName = 'htmlFor';
					}
					var found = [], foundCount = 0;
					for (var h = 0; h < currentContext.length; h++) {
						var elements;
						if (tagName == '*') {
							elements = currentContext[h].getElementsByTagName('*');
						} else {
							elements = currentContext[h].getElementsByTagName(tagName);
						}
						for (var j = 0; elements[j]; j++) {
							found[foundCount++] = elements[j];
						}
					}
					currentContext = [];
					var currentContextIndex = 0, checkFunction;
					switch (attrOperator) {
						case '=': checkFunction = function(e) { return (e.getAttribute(attrName) == attrValue) }; break;
						case '~': checkFunction = function(e) { return (e.getAttribute(attrName).match(new RegExp('(\\s|^)'+attrValue+'(\\s|$)'))) }; break;
						case '|': checkFunction = function(e) { return (e.getAttribute(attrName).match(new RegExp('^'+attrValue+'-?'))) }; break;
						case '^': checkFunction = function(e) { return (e.getAttribute(attrName).indexOf(attrValue) == 0) }; break;
						case '$': checkFunction = function(e) { return (e.getAttribute(attrName).lastIndexOf(attrValue) == e.getAttribute(attrName).length - attrValue.length) }; break;
						case '*': checkFunction = function(e) { return (e.getAttribute(attrName).indexOf(attrValue) > -1) }; break;
						default : checkFunction = function(e) { return e.getAttribute(attrName) };
					}
					currentContext = [];
					var currentContextIndex = 0;
					for (var k = 0; k < found.length; k++) {
						if (checkFunction(found[k])) {
							currentContext[currentContextIndex++] = found[k];
						}
					}
					continue;
				}
				tagName = token;
				var found = [], foundCount = 0;
				for (var h = 0; h < currentContext.length; h++) {
					var elements = currentContext[h].getElementsByTagName(tagName);
					for (var j = 0; j < elements.length; j++) {
						found[foundCount++] = elements[j];
					}
				}
				currentContext = found;
			}
			resultList = [].concat(resultList,currentContext);
		}
		return resultList;
	},
	scrollSize: (function(){
		var content, hold, sizeBefore, sizeAfter;
		function buildSizer(){
			if(hold) removeSizer();
			content = document.createElement('div');
			hold = document.createElement('div');
			hold.style.cssText = 'position:absolute;overflow:hidden;width:100px;height:100px';
			hold.appendChild(content);
			document.body.appendChild(hold);
		}
		function removeSizer(){
			document.body.removeChild(hold);
			hold = null;
		}
		function calcSize(vertical) {
			buildSizer();
			content.style.cssText = 'height:'+(vertical ? '100%' : '200px');
			sizeBefore = (vertical ? content.offsetHeight : content.offsetWidth);
			hold.style.overflow = 'scroll'; content.innerHTML = 1;
			sizeAfter = (vertical ? content.offsetHeight : content.offsetWidth);
			if(vertical && hold.clientHeight) sizeAfter = hold.clientHeight;
			removeSizer();
			return sizeBefore - sizeAfter;
		}
		return {
			getWidth:function(){
				return calcSize(false);
			},
			getHeight:function(){
				return calcSize(true)
			}
		}
	}()),
	domReady: function (handler){
		var called = false
		function ready() {
			if (called) return;
			called = true;
			handler();
		}
		if (document.addEventListener) {
			document.addEventListener("DOMContentLoaded", ready, false);
		} else if (document.attachEvent) {
			if (document.documentElement.doScroll && window == window.top) {
				function tryScroll(){
					if (called) return
					if (!document.body) return
					try {
						document.documentElement.doScroll("left")
						ready()
					} catch(e) {
						setTimeout(tryScroll, 0)
					}
				}
				tryScroll()
			}
			document.attachEvent("onreadystatechange", function(){
				if (document.readyState === "complete") {
					ready()
				}
			})
		}
		if (window.addEventListener) window.addEventListener('load', ready, false)
		else if (window.attachEvent) window.attachEvent('onload', ready)
	},
	event: (function(){
		var guid = 0;
		function fixEvent(e) {
			e = e || window.event;
			if (e.isFixed) {
				return e;
			}
			e.isFixed = true;
			e.preventDefault = e.preventDefault || function(){this.returnValue = false}
			e.stopPropagation = e.stopPropagaton || function(){this.cancelBubble = true}
			if (!e.target) {
				e.target = e.srcElement
			}
			if (!e.relatedTarget && e.fromElement) {
				e.relatedTarget = e.fromElement == e.target ? e.toElement : e.fromElement;
			}
			if (e.pageX == null && e.clientX != null) {
				var html = document.documentElement, body = document.body;
				e.pageX = e.clientX + (html && html.scrollLeft || body && body.scrollLeft || 0) - (html.clientLeft || 0);
				e.pageY = e.clientY + (html && html.scrollTop || body && body.scrollTop || 0) - (html.clientTop || 0);
			}
			if (!e.which && e.button) {
				e.which = e.button & 1 ? 1 : (e.button & 2 ? 3 : (e.button & 4 ? 2 : 0));
			}
			if(e.type === "DOMMouseScroll" || e.type === 'mousewheel') {
				e.mWheelDelta = 0;
				if (e.wheelDelta) {
					e.mWheelDelta = e.wheelDelta/120;
				} else if (e.detail) {
					e.mWheelDelta = -e.detail/3;
				}
			}
			return e;
		}
		function commonHandle(event, customScope) {
			event = fixEvent(event);
			var handlers = this.events[event.type];
			for (var g in handlers) {
				var handler = handlers[g];
				var ret = handler.call(customScope || this, event);
				if (ret === false) {
					event.preventDefault()
					event.stopPropagation()
				}
			}
		}
		var publicAPI = {
			add: function(elem, type, handler, forcedScope) {
				if (elem.setInterval && (elem != window && !elem.frameElement)) {
					elem = window;
				}
				if (!handler.guid) {
					handler.guid = ++guid;
				}
				if (!elem.events) {
					elem.events = {};
					elem.handle = function(event) {
						return commonHandle.call(elem, event);
					}
				}
				if (!elem.events[type]) {
					elem.events[type] = {};
					if (elem.addEventListener) elem.addEventListener(type, elem.handle, false);
					else if (elem.attachEvent) elem.attachEvent("on" + type, elem.handle);
					if(type === 'mousewheel') {
						publicAPI.add(elem, 'DOMMouseScroll', handler, forcedScope);
					}
				}
				var fakeHandler = jcf.lib.bind(handler, forcedScope);
				fakeHandler.guid = handler.guid;
				elem.events[type][handler.guid] = forcedScope ? fakeHandler : handler;
			},
			remove: function(elem, type, handler) {
				var handlers = elem.events && elem.events[type];
				if (!handlers) return;
				delete handlers[handler.guid];
				for(var any in handlers) return;
				if (elem.removeEventListener) elem.removeEventListener(type, elem.handle, false);
				else if (elem.detachEvent) elem.detachEvent("on" + type, elem.handle);
				delete elem.events[type];
				for (var any in elem.events) return;
				try {
					delete elem.handle;
					delete elem.events;
				} catch(e) {
					if(elem.removeAttribute) {
						elem.removeAttribute("handle");
						elem.removeAttribute("events");
					}
				}
				if(type === 'mousewheel') {
					publicAPI.remove(elem, 'DOMMouseScroll', handler);
				}
			}
		}
		return publicAPI;
	}())
}

/**** custom radio module ****/
//jcf.addModule({
//	name:'radio',
//	selector: 'input[type="radio"]',
//	defaultOptions: {
//		wrapperClass:'rad-area',
//		focusClass:'rad-focus',
//		checkedClass:'rad-checked',
//		uncheckedClass:'rad-unchecked',
//		disabledClass:'rad-disabled',
//		radStructure:'<span></span>'
//	},
//	getRadioGroup: function(item){
//		var name = item.getAttribute('name');
//		if(name) {
//			return jcf.lib.queryBySelector('input[name="'+name+'"]', jcf.lib.getParent('form'));
//		} else {
//			return [item];
//		}
//	},
//	setupWrapper: function(){
//		jcf.lib.addClass(this.fakeElement, this.options.wrapperClass);
//		this.fakeElement.innerHTML = this.options.radStructure;
//		this.realElement.parentNode.insertBefore(this.fakeElement, this.realElement);
//		this.refreshState();
//		this.addEvents();
//	},
//	addEvents: function(){
//		jcf.lib.event.add(this.fakeElement, 'click', this.toggleRadio, this);
//		if(this.labelFor) {
//			jcf.lib.event.add(this.labelFor, 'click', this.toggleRadio, this);
//		}
//	},
//	onFocus: function(e) {
//		jcf.modules[this.name].superclass.onFocus.apply(this, arguments);
//		setTimeout(jcf.lib.bind(function(){
//			this.refreshState();
//		},this),10);
//	},
//	toggleRadio: function(){
//		if(!this.realElement.disabled) {
//			this.realElement.checked = true;
//		}
//		this.refreshState();
//	},
//	refreshState: function(){
//		var els = this.getRadioGroup(this.realElement);
//		for(var i = 0; i < els.length; i++) {
//			var curEl = els[i].jcf;
//			if(curEl) {
//				if(curEl.realElement.checked) {
//					jcf.lib.addClass(curEl.fakeElement, curEl.options.checkedClass);
//					jcf.lib.removeClass(curEl.fakeElement, curEl.options.uncheckedClass);
//					if(curEl.labelFor) {
//						jcf.lib.addClass(curEl.labelFor, curEl.options.labelActiveClass);
//					}
//				} else {
//					jcf.lib.removeClass(curEl.fakeElement, curEl.options.checkedClass);
//					jcf.lib.addClass(curEl.fakeElement, curEl.options.uncheckedClass);
//					if(curEl.labelFor) {
//						jcf.lib.removeClass(curEl.labelFor, curEl.options.labelActiveClass);
//					}
//				}
//				if(curEl.realElement.disabled) {
//					jcf.lib.addClass(curEl.fakeElement, curEl.options.disabledClass);
//					if(curEl.labelFor) {
//						jcf.lib.addClass(curEl.labelFor, curEl.options.labelDisabledClass);
//					}
//				} else {
//					jcf.lib.removeClass(curEl.fakeElement, curEl.options.disabledClass);
//					if(curEl.labelFor) {
//						jcf.lib.removeClass(curEl.labelFor, curEl.options.labelDisabledClass);
//					}
//				}
//			}
//		}
//	}
//});

/**** custom checkbox module ****/
//jcf.addModule({
//	name:'checkbox',
//	selector:'input[type="checkbox"]',
//	defaultOptions: {
//		wrapperClass:'chk-area',
//		focusClass:'chk-focus',
//		checkedClass:'chk-checked',
//		labelActiveClass:'chk-label-active',
//		uncheckedClass:'chk-unchecked',
//		disabledClass:'chk-disabled',
//		chkStructure:'<span></span>'
//	},
//	setupWrapper: function(){
//		jcf.lib.addClass(this.fakeElement, this.options.wrapperClass);
//		this.fakeElement.innerHTML = this.options.chkStructure;
//		this.realElement.parentNode.insertBefore(this.fakeElement, this.realElement);
//		jcf.lib.event.add(this.realElement, 'click', this.onRealClick, this);
//		this.refreshState();
//	},
//	isLinkTarget: function(target, limitParent) {
//		while(target.parentNode || target === limitParent) {
//			if(target.tagName.toLowerCase() === 'a') {
//				return true;
//			}
//			target = target.parentNode;
//		}
//	},
//	onFakePressed: function() {
//		jcf.modules[this.name].superclass.onFakePressed.apply(this, arguments);
//		if(!this.realElement.disabled) {
//			this.realElement.focus();
//		}
//	},
//	onFakeClick: function(e) {
//		jcf.modules[this.name].superclass.onFakeClick.apply(this, arguments);
//		this.tmpTimer = setTimeout(jcf.lib.bind(function(){
//			this.toggle();
//		},this),10);
//		if(!this.isLinkTarget(e.target, this.labelFor)) {
//			return false;
//		}
//	},
//	onRealClick: function(e) {
//		setTimeout(jcf.lib.bind(function(){
//			this.refreshState();
//		},this),10);
//		e.stopPropagation();
//	},
//	toggle: function(e){
//		if(!this.realElement.disabled) {
//			if(this.realElement.checked) {
//				this.realElement.checked = false;
//			} else {
//				this.realElement.checked = true;
//			}
//		}
//		this.refreshState();
//		return false;
//	},
//	refreshState: function(){
//		if(this.realElement.checked) {
//			jcf.lib.addClass(this.fakeElement, this.options.checkedClass);
//			jcf.lib.removeClass(this.fakeElement, this.options.uncheckedClass);
//			if(this.labelFor) {
//				jcf.lib.addClass(this.labelFor, this.options.labelActiveClass);
//			}
//		} else {
//			jcf.lib.removeClass(this.fakeElement, this.options.checkedClass);
//			jcf.lib.addClass(this.fakeElement, this.options.uncheckedClass);
//			if(this.labelFor) {
//				jcf.lib.removeClass(this.labelFor, this.options.labelActiveClass);
//			}
//		}
//		if(this.realElement.disabled) {
//			jcf.lib.addClass(this.fakeElement, this.options.disabledClass);
//			if(this.labelFor) {
//				jcf.lib.addClass(this.labelFor, this.options.labelDisabledClass);
//			}
//		} else {
//			jcf.lib.removeClass(this.fakeElement, this.options.disabledClass);
//			if(this.labelFor) {
//				jcf.lib.removeClass(this.labelFor, this.options.labelDisabledClass);
//			}
//		}
//	}
//});

// custom scrollbars module
jcf.addModule({
	name:'customscroll',
	selector:'div.scrollable-area',
	defaultOptions: {
		alwaysPreventWheel: false,
		enableMouseWheel: true,
		captureFocus: false,
		handleNested: true,
		alwaysKeepScrollbars: false,
		autoDetectWidth: false,
		scrollbarOptions: {},
		focusClass:'scrollable-focus',
		wrapperTag: 'div',
		autoDetectWidthClass: 'autodetect-width',
		noHorizontalBarClass:'noscroll-horizontal',
		noVerticalBarClass:'noscroll-vertical',
		innerWrapperClass:'scrollable-inner-wrapper',
		outerWrapperClass:'scrollable-area-wrapper',
		horizontalClass: 'hscrollable',
		verticalClass: 'vscrollable',
		bothClass: 'anyscrollable'
	},
	replaceObject: function(){
		this.initStructure();
		this.refreshState();
		this.addEvents();
	},
	initStructure: function(){
		// set scroll type
		this.realElement.jcf = this;
		if(jcf.lib.hasClass(this.realElement, this.options.bothClass) ||
		jcf.lib.hasClass(this.realElement, this.options.horizontalClass) && jcf.lib.hasClass(this.realElement, this.options.verticalClass)) {
			this.scrollType = 'both';
		} else if(jcf.lib.hasClass(this.realElement, this.options.horizontalClass)) {
			this.scrollType = 'horizontal';
		} else {
			this.scrollType = 'vertical';
		}

		// autodetect horizontal width
		if(jcf.lib.hasClass(this.realElement,this.options.autoDetectWidthClass)) {
			this.options.autoDetectWidth = true;
		}

		// init dimensions and build structure
		this.realElement.style.position = 'relative';
		this.realElement.style.overflow = 'hidden';

		// build content wrapper and scrollbar(s)
		this.buildWrapper();
		this.buildScrollbars();
	},
	buildWrapper: function() {
		this.outerWrapper = document.createElement(this.options.wrapperTag);
		this.outerWrapper.className = this.options.outerWrapperClass;
		this.realElement.parentNode.insertBefore(this.outerWrapper, this.realElement);
		this.outerWrapper.appendChild(this.realElement);

		// autosize content if single child
		if(this.options.autoDetectWidth && (this.scrollType === 'both' || this.scrollType === 'horizontal') && this.realElement.children.length === 1) {
			var tmpWidth = 0;
			this.realElement.style.width = '99999px';
			tmpWidth = this.realElement.children[0].offsetWidth;
			this.realElement.style.width = '';
			if(tmpWidth) {
				this.realElement.children[0].style.width = tmpWidth+'px';
			}
		}
	},
	buildScrollbars: function() {
		if(this.scrollType === 'horizontal' || this.scrollType === 'both') {
			this.hScrollBar = new jcf.plugins.scrollbar(jcf.lib.extend(this.options.scrollbarOptions,{
				vertical: false,
				spawnClass: this,
				holder: this.outerWrapper,
				range: this.realElement.scrollWidth - this.realElement.offsetWidth,
				size: this.realElement.offsetWidth,
				onScroll: jcf.lib.bind(function(v) {
					this.realElement.scrollLeft = v;
				},this)
			}));
		}
		if(this.scrollType === 'vertical' || this.scrollType === 'both') {
			this.vScrollBar = new jcf.plugins.scrollbar(jcf.lib.extend(this.options.scrollbarOptions,{
				vertical: true,
				spawnClass: this,
				holder: this.outerWrapper,
				range: this.realElement.scrollHeight - this.realElement.offsetHeight,
				size: this.realElement.offsetHeight,
				onScroll: jcf.lib.bind(function(v) {
					this.realElement.scrollTop = v;
				},this)
			}));
		}
		this.outerWrapper.style.width = this.realElement.offsetWidth + 'px';
		this.outerWrapper.style.height = this.realElement.offsetHeight + 'px';
		this.resizeScrollContent();
	},
	resizeScrollContent: function() {
		var diffWidth = this.realElement.offsetWidth - jcf.lib.getInnerWidth(this.realElement);
		var diffHeight = this.realElement.offsetHeight - jcf.lib.getInnerHeight(this.realElement);
		this.realElement.style.width = Math.max(0, this.outerWrapper.offsetWidth - diffWidth - (this.vScrollBar ? this.vScrollBar.getScrollBarSize() : 0)) + 'px';
		this.realElement.style.height = Math.max(0, this.outerWrapper.offsetHeight - diffHeight - (this.hScrollBar ? this.hScrollBar.getScrollBarSize() : 0)) + 'px';
	},
	addEvents: function() {
		// enable mouse wheel handling
		if(!jcf.isTouchDevice && this.options.enableMouseWheel) {
			jcf.lib.event.add(this.outerWrapper, 'mousewheel', this.onMouseWheel, this);
		}
		// add touch scroll on block body
		if(jcf.isTouchDevice || navigator.msPointerEnabled) {
			this.outerWrapper.style.msTouchAction = 'none';
			jcf.lib.event.add(this.realElement, jcf.eventPress, this.onScrollablePress, this);
		}

		// handle nested scrollbars
		if(this.options.handleNested) {
			var el = this.realElement, name = this.name;
			while(el.parentNode) {
				if(el.parentNode.jcf && el.parentNode.jcf.name == name) {
					el.parentNode.jcf.refreshState();
				}
				el = el.parentNode;
			}
		}
	},
	onMouseWheel: function(e) {
		if(this.scrollType === 'vertical' || this.scrollType === 'both') {
			return this.vScrollBar.doScrollWheelStep(e.mWheelDelta) === false ? false : !this.options.alwaysPreventWheel;
		} else {
			return this.hScrollBar.doScrollWheelStep(e.mWheelDelta) === false ? false : !this.options.alwaysPreventWheel;
		}
	},
	onScrollablePress: function(e) {
		if(e.pointerType !== e.MSPOINTER_TYPE_TOUCH) return;

		this.preventFlag = true;
		this.origWindowScrollTop = jcf.lib.getScrollTop();
		this.origWindowScrollLeft = jcf.lib.getScrollLeft();

		this.scrollableOffset = jcf.lib.getOffset(this.realElement);
		if(this.hScrollBar) {
			this.scrollableTouchX = (jcf.isTouchDevice ? e.changedTouches[0] : e).pageX;
			this.origValueX = this.hScrollBar.getScrollValue();
		}
		if(this.vScrollBar) {
			this.scrollableTouchY = (jcf.isTouchDevice ? e.changedTouches[0] : e).pageY;
			this.origValueY = this.vScrollBar.getScrollValue();
		}
		jcf.lib.event.add(this.realElement, jcf.eventMove, this.onScrollableMove, this);
		jcf.lib.event.add(this.realElement, jcf.eventRelease, this.onScrollableRelease, this);
	},
	onScrollableMove: function(e) {
		if(this.vScrollBar) {
			var difY = (jcf.isTouchDevice ? e.changedTouches[0] : e).pageY - this.scrollableTouchY;
			var valY = this.origValueY-difY;
			this.vScrollBar.scrollTo(valY);
			if(valY < 0 || valY > this.vScrollBar.options.range) {
				this.preventFlag = false;
			}
		}
		if(this.hScrollBar) {
			var difX = (jcf.isTouchDevice ? e.changedTouches[0] : e).pageX - this.scrollableTouchX;
			var valX = this.origValueX-difX;
			this.hScrollBar.scrollTo(valX);
			if(valX < 0 || valX > this.hScrollBar.options.range) {
				this.preventFlag = false;
			}
		}
		if(this.preventFlag) {
			e.preventDefault();
		}
	},
	onScrollableRelease: function() {
		jcf.lib.event.remove(this.realElement, jcf.eventMove, this.onScrollableMove);
		jcf.lib.event.remove(this.realElement, jcf.eventRelease, this.onScrollableRelease);
	},
	refreshState: function() {
		if(this.options.alwaysKeepScrollbars) {
			if(this.hScrollBar) this.hScrollBar.scrollBar.style.display = 'block';
			if(this.vScrollBar) this.vScrollBar.scrollBar.style.display = 'block';
		} else {
			if(this.hScrollBar) {
				if(this.getScrollRange(false)) {
					this.hScrollBar.scrollBar.style.display = 'block';
					this.resizeScrollContent();
					this.hScrollBar.setRange(this.getScrollRange(false));
				} else {
					this.hScrollBar.scrollBar.style.display = 'none';
					this.realElement.style.width = this.outerWrapper.style.width;
				}
				jcf.lib.toggleClass(this.outerWrapper, this.options.noHorizontalBarClass, this.hScrollBar.options.range === 0);
			}
			if(this.vScrollBar) {
				if(this.getScrollRange(true) > 0) {
					this.vScrollBar.scrollBar.style.display = 'block';
					this.resizeScrollContent();
					this.vScrollBar.setRange(this.getScrollRange(true));
				} else {
					this.vScrollBar.scrollBar.style.display = 'none';
					this.realElement.style.width = this.outerWrapper.style.width;
				}
				jcf.lib.toggleClass(this.outerWrapper, this.options.noVerticalBarClass, this.vScrollBar.options.range === 0);
			}
		}
		if(this.vScrollBar) {
			this.vScrollBar.setRange(this.realElement.scrollHeight - this.realElement.offsetHeight);
			this.vScrollBar.setSize(this.realElement.offsetHeight);
			this.vScrollBar.scrollTo(this.realElement.scrollTop);
		}
		if(this.hScrollBar) {
			this.hScrollBar.setRange(this.realElement.scrollWidth - this.realElement.offsetWidth);
			this.hScrollBar.setSize(this.realElement.offsetWidth);
			this.hScrollBar.scrollTo(this.realElement.scrollLeft);
		}
	},
	getScrollRange: function(isVertical) {
		if(isVertical) {
			return this.realElement.scrollHeight - this.realElement.offsetHeight;
		} else {
			return this.realElement.scrollWidth - this.realElement.offsetWidth;
		}
	},
	getCurrentRange: function(scrollInstance) {
		return this.getScrollRange(scrollInstance.isVertical);
	},
	onCreateModule: function(){
		if(jcf.modules.select) {
			this.extendSelect();
		}
		if(jcf.modules.selectmultiple) {
			this.extendSelectMultiple();
		}
		if(jcf.modules.textarea) {
			this.extendTextarea();
		}
	},
	onModuleAdded: function(module){
		if(module.prototype.name == 'select') {
			this.extendSelect();
		}
		if(module.prototype.name == 'selectmultiple') {
			this.extendSelectMultiple();
		}
		if(module.prototype.name == 'textarea') {
			this.extendTextarea();
		}
	},
	extendSelect: function() {
		// add scrollable if needed on control ready
		jcf.modules.select.prototype.onControlReady = function(obj){
			if(obj.selectList.scrollHeight > obj.selectList.offsetHeight) {
				obj.jcfScrollable = new jcf.modules.customscroll({
					alwaysPreventWheel: true,
					replaces:obj.selectList
				});
			}
		}
		// update scroll function
		var orig = jcf.modules.select.prototype.scrollToItem;
		jcf.modules.select.prototype.scrollToItem = function(){
			orig.apply(this);
			if(this.jcfScrollable) {
				this.jcfScrollable.refreshState();
			}
		}
	},
	extendTextarea: function() {
		// add scrollable if needed on control ready
		jcf.modules.textarea.prototype.onControlReady = function(obj){
			obj.jcfScrollable = new jcf.modules.customscroll({
				alwaysKeepScrollbars: true,
				alwaysPreventWheel: true,
				replaces: obj.realElement
			});
		}
		// update scroll function
		var orig = jcf.modules.textarea.prototype.refreshState;
		jcf.modules.textarea.prototype.refreshState = function(){
			orig.apply(this);
			if(this.jcfScrollable) {
				this.jcfScrollable.refreshState();
			}
		}
	},
	extendSelectMultiple: function(){
		// add scrollable if needed on control ready
		jcf.modules.selectmultiple.prototype.onControlReady = function(obj){
			//if(obj.optionsHolder.scrollHeight > obj.optionsHolder.offsetHeight) {
				obj.jcfScrollable = new jcf.modules.customscroll({
					alwaysPreventWheel: true,
					replaces:obj.optionsHolder
				});
			//}
		}
		// update scroll function
		var orig = jcf.modules.selectmultiple.prototype.scrollToItem;
		jcf.modules.selectmultiple.prototype.scrollToItem = function(){
			orig.apply(this);
			if(this.jcfScrollable) {
				this.jcfScrollable.refreshState();
			}
		}

		// update scroll size?
		var orig2 = jcf.modules.selectmultiple.prototype.rebuildOptions;
		jcf.modules.selectmultiple.prototype.rebuildOptions = function(){
			orig2.apply(this);
			if(this.jcfScrollable) {
				this.jcfScrollable.refreshState();
			}
		}

	}
});

// scrollbar plugin
jcf.addPlugin({
	name: 'scrollbar',
	defaultOptions: {
		size: 0,
		range: 0,
		moveStep: 6,
		moveDistance: 50,
		moveInterval: 10,
		trackHoldDelay: 900,
		holder: null,
		vertical: true,
		scrollTag: 'div',
		onScroll: function(){},
		onScrollEnd: function(){},
		onScrollStart: function(){},
		disabledClass: 'btn-disabled',
		VscrollBarClass:'vscrollbar',
		VscrollStructure: '<div class="vscroll-up"></div><div class="vscroll-line"><div class="vscroll-slider"><div class="scroll-bar-top"></div><div class="scroll-bar-bottom"></div></div></div></div><div class="vscroll-down"></div>',
		VscrollTrack: 'div.vscroll-line',
		VscrollBtnDecClass:'div.vscroll-up',
		VscrollBtnIncClass:'div.vscroll-down',
		VscrollSliderClass:'div.vscroll-slider',
		HscrollBarClass:'hscrollbar',
		HscrollStructure: '<div class="hscroll-left"></div><div class="hscroll-line"><div class="hscroll-slider"><div class="scroll-bar-left"></div><div class="scroll-bar-right"></div></div></div></div><div class="hscroll-right"></div>',
		HscrollTrack: 'div.hscroll-line',
		HscrollBtnDecClass:'div.hscroll-left',
		HscrollBtnIncClass:'div.hscroll-right',
		HscrollSliderClass:'div.hscroll-slider'
	},
	init: function(userOptions) {
		this.setOptions(userOptions);
		this.createScrollBar();
		this.attachEvents();
		this.setSize();
	},
	setOptions: function(extOptions) {
		// merge options
		this.options = jcf.lib.extend({}, this.defaultOptions, extOptions);
		this.isVertical = this.options.vertical;
		this.prefix = this.isVertical ? 'V' : 'H';
		this.eventPageOffsetProperty = this.isVertical ? 'pageY' : 'pageX';
		this.positionProperty = this.isVertical ? 'top' : 'left';
		this.sizeProperty = this.isVertical ? 'height' : 'width';
		this.dimenionsProperty = this.isVertical ? 'offsetHeight' : 'offsetWidth';
		this.invertedDimenionsProperty = !this.isVertical ? 'offsetHeight' : 'offsetWidth';

		// set corresponding classes
		for(var p in this.options) {
			if(p.indexOf(this.prefix) == 0) {
				this.options[p.substr(1)] = this.options[p];
			}
		}
	},
	createScrollBar: function() {
		// create dimensions
		this.scrollBar = document.createElement(this.options.scrollTag);
		this.scrollBar.className = this.options.scrollBarClass;
		this.scrollBar.innerHTML = this.options.scrollStructure;

		// get elements
		this.track = jcf.lib.queryBySelector(this.options.scrollTrack,this.scrollBar)[0];
		this.btnDec = jcf.lib.queryBySelector(this.options.scrollBtnDecClass,this.scrollBar)[0];
		this.btnInc = jcf.lib.queryBySelector(this.options.scrollBtnIncClass,this.scrollBar)[0];
		this.slider = jcf.lib.queryBySelector(this.options.scrollSliderClass,this.scrollBar)[0];
		this.slider.style.position = 'absolute';
		this.track.style.position = 'relative';
	},
	attachEvents: function() {
		// append scrollbar to holder if provided
		if(this.options.holder) {
			this.options.holder.appendChild(this.scrollBar);
		}

		// attach listeners for slider and buttons
		jcf.lib.event.add(this.slider, jcf.eventPress, this.onSliderPressed, this);
		jcf.lib.event.add(this.btnDec, jcf.eventPress, this.onBtnDecPressed, this);
		jcf.lib.event.add(this.btnInc, jcf.eventPress, this.onBtnIncPressed, this);
		jcf.lib.event.add(this.track, jcf.eventPress, this.onTrackPressed, this);
	},
	setSize: function(value) {
		if(typeof value === 'number') {
			this.options.size = value;
		}
		this.scrollOffset = this.scrollValue = this.sliderOffset = 0;
		this.scrollBar.style[this.sizeProperty] = this.options.size + 'px';
		this.resizeControls();
		this.refreshSlider();
	},
	setRange: function(r) {
		this.options.range = Math.max(r,0);
		this.resizeControls();
	},
	doScrollWheelStep: function(direction) {
		// 1 - scroll up, -1 scroll down
		this.startScroll();
		if((direction < 0 && !this.isEndPosition()) || (direction > 0 && !this.isStartPosition())) {
			this.scrollTo(this.getScrollValue()-this.options.moveDistance * direction);
			this.moveScroll();
			this.endScroll();
			return false;
		}
	},
	resizeControls: function() {
		// calculate dimensions
		this.barSize = this.scrollBar[this.dimenionsProperty];
		this.btnDecSize = this.btnDec[this.dimenionsProperty];
		this.btnIncSize = this.btnInc[this.dimenionsProperty];
		this.trackSize = Math.max(0, this.barSize - this.btnDecSize - this.btnIncSize);

		// resize and reposition elements
		this.track.style[this.sizeProperty] = this.trackSize + 'px';
		this.trackSize = this.track[this.dimenionsProperty];
		this.sliderSize = this.getSliderSize();
		this.slider.style[this.sizeProperty] = this.sliderSize + 'px';
		this.sliderSize = this.slider[this.dimenionsProperty];
	},
	refreshSlider: function(complete) {
		// refresh dimensions
		if(complete) {
			this.resizeControls();
		}
		// redraw slider and classes
		this.sliderOffset = isNaN(this.sliderOffset) ? 0 : this.sliderOffset;
		this.slider.style[this.positionProperty] = this.sliderOffset + 'px';
	},
	startScroll: function() {
		// refresh range if possible
		if(this.options.spawnClass && typeof this.options.spawnClass.getCurrentRange === 'function') {
			this.setRange(this.options.spawnClass.getCurrentRange(this));
		}
		this.resizeControls();
		this.scrollBarOffset = jcf.lib.getOffset(this.track)[this.positionProperty];
		this.options.onScrollStart();
	},
	moveScroll: function() {
		this.options.onScroll(this.scrollValue);

		// add disabled classes
		jcf.lib.removeClass(this.btnDec, this.options.disabledClass);
		jcf.lib.removeClass(this.btnInc, this.options.disabledClass);
		if(this.scrollValue === 0) {
			jcf.lib.addClass(this.btnDec, this.options.disabledClass);
		}
		if(this.scrollValue === this.options.range) {
			jcf.lib.addClass(this.btnInc, this.options.disabledClass);
		}
	},
	endScroll: function() {
		this.options.onScrollEnd();
	},
	startButtonMoveScroll: function(direction) {
		this.startScroll();
		clearInterval(this.buttonScrollTimer);
		this.buttonScrollTimer = setInterval(jcf.lib.bind(function(){
			this.scrollValue += this.options.moveStep * direction
			if(this.scrollValue > this.options.range) {
				this.scrollValue = this.options.range;
				this.endButtonMoveScroll();
			} else if(this.scrollValue < 0) {
				this.scrollValue = 0;
				this.endButtonMoveScroll();
			}
			this.scrollTo(this.scrollValue);

		},this),this.options.moveInterval);
	},
	endButtonMoveScroll: function() {
		clearInterval(this.buttonScrollTimer);
		this.endScroll();
	},
	isStartPosition: function() {
		return this.scrollValue === 0;
	},
	isEndPosition: function() {
		return this.scrollValue === this.options.range;
	},
	getSliderSize: function() {
		return Math.round(this.getSliderSizePercent() * this.trackSize / 100);
	},
	getSliderSizePercent: function() {
		return this.options.range === 0 ? 0 : this.barSize * 100 / (this.barSize + this.options.range);
	},
	getSliderOffsetByScrollValue: function() {
		return (this.scrollValue * 100 / this.options.range) * (this.trackSize - this.sliderSize) / 100;
	},
	getSliderOffsetPercent: function() {
		return this.sliderOffset * 100 / (this.trackSize - this.sliderSize);
	},
	getScrollValueBySliderOffset: function() {
		return this.getSliderOffsetPercent() * this.options.range / 100;
	},
	getScrollBarSize: function() {
		return this.scrollBar[this.invertedDimenionsProperty];
	},
	getScrollValue: function() {
		return this.scrollValue || 0;
	},
	scrollOnePage: function(direction) {
		this.scrollTo(this.scrollValue + direction*this.barSize);
	},
	scrollTo: function(x) {
		this.scrollValue = x < 0 ? 0 : x > this.options.range ? this.options.range : x;
		this.sliderOffset = this.getSliderOffsetByScrollValue();
		this.refreshSlider();
		this.moveScroll();
	},
	onSliderPressed: function(e){
		jcf.lib.event.add(document.body, jcf.eventRelease, this.onSliderRelease, this);
		jcf.lib.event.add(document.body, jcf.eventMove, this.onSliderMove, this);
		jcf.lib.disableTextSelection(this.slider);

		// calculate offsets once
		this.sliderInnerOffset = (jcf.isTouchDevice ? e.changedTouches[0] : e)[this.eventPageOffsetProperty] - jcf.lib.getOffset(this.slider)[this.positionProperty];
		this.startScroll();
		return false;
	},
	onSliderRelease: function(){
		jcf.lib.event.remove(document.body, jcf.eventRelease, this.onSliderRelease);
		jcf.lib.event.remove(document.body, jcf.eventMove, this.onSliderMove);
	},
	onSliderMove: function(e) {
		this.sliderOffset = (jcf.isTouchDevice ? e.changedTouches[0] : e)[this.eventPageOffsetProperty] - this.scrollBarOffset - this.sliderInnerOffset;
		if(this.sliderOffset < 0) {
			this.sliderOffset = 0;
		} else if(this.sliderOffset + this.sliderSize > this.trackSize) {
			this.sliderOffset = this.trackSize - this.sliderSize;
		}
		if(this.previousOffset != this.sliderOffset) {
			this.previousOffset = this.sliderOffset;
			this.scrollTo(this.getScrollValueBySliderOffset());
		}
	},
	onBtnIncPressed: function() {
		jcf.lib.event.add(document.body, jcf.eventRelease, this.onBtnIncRelease, this);
		jcf.lib.disableTextSelection(this.btnInc);
		this.startButtonMoveScroll(1);
		return false;
	},
	onBtnIncRelease: function() {
		jcf.lib.event.remove(document.body, jcf.eventRelease, this.onBtnIncRelease);
		this.endButtonMoveScroll();
	},
	onBtnDecPressed: function() {
		jcf.lib.event.add(document.body, jcf.eventRelease, this.onBtnDecRelease, this);
		jcf.lib.disableTextSelection(this.btnDec);
		this.startButtonMoveScroll(-1);
		return false;
	},
	onBtnDecRelease: function() {
		jcf.lib.event.remove(document.body, jcf.eventRelease, this.onBtnDecRelease);
		this.endButtonMoveScroll();
	},
	onTrackPressed: function(e) {
		var position = e[this.eventPageOffsetProperty] - jcf.lib.getOffset(this.track)[this.positionProperty];
		var direction = position < this.sliderOffset ? -1 : position > this.sliderOffset + this.sliderSize ? 1 : 0;
		if(direction) {
			this.scrollOnePage(direction);
		}
	}
});


/*
 * FancyBox - jQuery Plugin
 * Simple and fancy lightbox alternative
 *
 * Examples and documentation at: http://fancybox.net
 *
 * Copyright (c) 2008 - 2010 Janis Skarnelis
 * That said, it is hardly a one-person project. Many people have submitted bugs, code, and offered their advice freely. Their support is greatly appreciated.
 *
 * Version: 1.3.4 (11/11/2010)
 * Requires: jQuery v1.3+
 *
 * Dual licensed under the MIT and GPL licenses:
 *   http://www.opensource.org/licenses/mit-license.php
 *   http://www.gnu.org/licenses/gpl.html
 */
;(function(B){var L,T,Q,M,d,m,J,A,O,z,C=0,H={},j=[],e=0,G={},y=[],f=null,o=new Image(),i=/\.(jpg|gif|png|bmp|jpeg)(.*)?$/i,k=/[^\.]\.(swf)\s*$/i,p,N=1,h=0,t="",b,c,P=false,s=B.extend(B("<div/>")[0],{prop:0}),S=B.browser.msie&&B.browser.version<7&&!window.XMLHttpRequest,r=function(){T.hide();o.onerror=o.onload=null;if(f){f.abort()}L.empty()},x=function(){if(false===H.onError(j,C,H)){T.hide();P=false;return}H.titleShow=false;H.width="auto";H.height="auto";L.html('<p id="fancybox-error">The requested content cannot be loaded.<br />Please try again later.</p>');n()},w=function(){var Z=j[C],W,Y,ab,aa,V,X;r();H=B.extend({},B.fn.fancybox.defaults,(typeof B(Z).data("fancybox")=="undefined"?H:B(Z).data("fancybox")));X=H.onStart(j,C,H);if(X===false){P=false;return}else{if(typeof X=="object"){H=B.extend(H,X)}}ab=H.title||(Z.nodeName?B(Z).attr("title"):Z.title)||"";if(Z.nodeName&&!H.orig){H.orig=B(Z).children("img:first").length?B(Z).children("img:first"):B(Z)}if(ab===""&&H.orig&&H.titleFromAlt){ab=H.orig.attr("alt")}W=H.href||(Z.nodeName?B(Z).attr("href"):Z.href)||null;if((/^(?:javascript)/i).test(W)||W=="#"){W=null}if(H.type){Y=H.type;if(!W){W=H.content}}else{if(H.content){Y="html"}else{if(W){if(W.match(i)){Y="image"}else{if(W.match(k)){Y="swf"}else{if(B(Z).hasClass("iframe")){Y="iframe"}else{if(W.indexOf("#")===0){Y="inline"}else{Y="ajax"}}}}}}}if(!Y){x();return}if(Y=="inline"){Z=W.substr(W.indexOf("#"));Y=B(Z).length>0?"inline":"ajax"}H.type=Y;H.href=W;H.title=ab;if(H.autoDimensions){if(H.type=="html"||H.type=="inline"||H.type=="ajax"){H.width="auto";H.height="auto"}else{H.autoDimensions=false}}if(H.modal){H.overlayShow=true;H.hideOnOverlayClick=false;H.hideOnContentClick=false;H.enableEscapeButton=false;H.showCloseButton=false}H.padding=parseInt(H.padding,10);H.margin=parseInt(H.margin,10);L.css("padding",(H.padding+H.margin));B(".fancybox-inline-tmp").unbind("fancybox-cancel").bind("fancybox-change",function(){B(this).replaceWith(m.children())});switch(Y){case"html":L.html(H.content);n();break;case"inline":if(B(Z).parent().is("#fancybox-content")===true){P=false;return}B('<div class="fancybox-inline-tmp" />').hide().insertBefore(B(Z)).bind("fancybox-cleanup",function(){B(this).replaceWith(m.children())}).bind("fancybox-cancel",function(){B(this).replaceWith(L.children())});B(Z).appendTo(L);n();break;case"image":P=false;B.fancybox.showActivity();o=new Image();o.onerror=function(){x()};o.onload=function(){P=true;o.onerror=o.onload=null;F()};o.src=W;break;case"swf":H.scrolling="no";aa='<object classid="clsid:D27CDB6E-AE6D-11cf-96B8-444553540000" width="'+H.width+'" height="'+H.height+'"><param name="movie" value="'+W+'"></param>';V="";B.each(H.swf,function(ac,ad){aa+='<param name="'+ac+'" value="'+ad+'"></param>';V+=" "+ac+'="'+ad+'"'});aa+='<embed src="'+W+'" type="application/x-shockwave-flash" width="'+H.width+'" height="'+H.height+'"'+V+"></embed></object>";L.html(aa);n();break;case"ajax":P=false;B.fancybox.showActivity();H.ajax.win=H.ajax.success;f=B.ajax(B.extend({},H.ajax,{url:W,data:H.ajax.data||{},dataType:"text",error:function(ac,ae,ad){if(ac.status>0){x()}},success:function(ad,af,ac){var ae=typeof ac=="object"?ac:f;if(ae.status==200||ae.status===0){if(typeof H.ajax.win=="function"){X=H.ajax.win(W,ad,af,ac);if(X===false){T.hide();return}else{if(typeof X=="string"||typeof X=="object"){ad=X}}}L.html(ad);n()}}}));break;case"iframe":E();break}},n=function(){var V=H.width,W=H.height;if(V.toString().indexOf("%")>-1){V=parseInt((B(window).width()-(H.margin*2))*parseFloat(V)/100,10)+"px"}else{V=V=="auto"?"auto":V+"px"}if(W.toString().indexOf("%")>-1){W=parseInt((B(window).height()-(H.margin*2))*parseFloat(W)/100,10)+"px"}else{W=W=="auto"?"auto":W+"px"}L.wrapInner('<div style="width:'+V+";height:"+W+";overflow: "+(H.scrolling=="auto"?"auto":(H.scrolling=="yes"?"scroll":"hidden"))+';position:relative;"></div>');H.width=L.width();H.height=L.height();E()},F=function(){H.width=o.width;H.height=o.height;B("<img />").attr({id:"fancybox-img",src:o.src,alt:H.title}).appendTo(L);E()},E=function(){var W,V;T.hide();if(M.is(":visible")&&false===G.onCleanup(y,e,G)){B.event.trigger("fancybox-cancel");P=false;return}P=true;B(m.add(Q)).unbind();B(window).unbind("resize.fb scroll.fb");B(document).unbind("keydown.fb");if(M.is(":visible")&&G.titlePosition!=="outside"){M.css("height",M.height())}y=j;e=C;G=H;if(G.overlayShow){Q.css({"background-color":G.overlayColor,opacity:G.overlayOpacity,cursor:G.hideOnOverlayClick?"pointer":"auto",height:B(document).height()});if(!Q.is(":visible")){if(S){B("select:not(#fancybox-tmp select)").filter(function(){return this.style.visibility!=="hidden"}).css({visibility:"hidden"}).one("fancybox-cleanup",function(){this.style.visibility="inherit"})}Q.show()}}else{Q.hide()}c=R();l();if(M.is(":visible")){B(J.add(O).add(z)).hide();W=M.position(),b={top:W.top,left:W.left,width:M.width(),height:M.height()};V=(b.width==c.width&&b.height==c.height);m.fadeTo(G.changeFade,0.3,function(){var X=function(){m.html(L.contents()).fadeTo(G.changeFade,1,v)};B.event.trigger("fancybox-change");m.empty().removeAttr("filter").css({"border-width":G.padding,width:c.width-G.padding*2,height:H.autoDimensions?"auto":c.height-h-G.padding*2});if(V){X()}else{s.prop=0;B(s).animate({prop:1},{duration:G.changeSpeed,easing:G.easingChange,step:U,complete:X})}});return}M.removeAttr("style");m.css("border-width",G.padding);if(G.transitionIn=="elastic"){b=I();m.html(L.contents());M.show();if(G.opacity){c.opacity=0}s.prop=0;B(s).animate({prop:1},{duration:G.speedIn,easing:G.easingIn,step:U,complete:v});return}if(G.titlePosition=="inside"&&h>0){A.show()}m.css({width:c.width-G.padding*2,height:H.autoDimensions?"auto":c.height-h-G.padding*2}).html(L.contents());M.css(c).fadeIn(G.transitionIn=="none"?0:G.speedIn,v)},D=function(V){if(V&&V.length){if(G.titlePosition=="float"){return'<table id="fancybox-title-float-wrap" cellpadding="0" cellspacing="0"><tr><td id="fancybox-title-float-left"></td><td id="fancybox-title-float-main">'+V+'</td><td id="fancybox-title-float-right"></td></tr></table>'}return'<div id="fancybox-title-'+G.titlePosition+'">'+V+"</div>"}return false},l=function(){t=G.title||"";h=0;A.empty().removeAttr("style").removeClass();if(G.titleShow===false){A.hide();return}t=B.isFunction(G.titleFormat)?G.titleFormat(t,y,e,G):D(t);if(!t||t===""){A.hide();return}A.addClass("fancybox-title-"+G.titlePosition).html(t).appendTo("body").show();switch(G.titlePosition){case"inside":A.css({width:c.width-(G.padding*2),marginLeft:G.padding,marginRight:G.padding});h=A.outerHeight(true);A.appendTo(d);c.height+=h;break;case"over":A.css({marginLeft:G.padding,width:c.width-(G.padding*2),bottom:G.padding}).appendTo(d);break;case"float":A.css("left",parseInt((A.width()-c.width-40)/2,10)*-1).appendTo(M);break;default:A.css({width:c.width-(G.padding*2),paddingLeft:G.padding,paddingRight:G.padding}).appendTo(M);break}A.hide()},g=function(){if(G.enableEscapeButton||G.enableKeyboardNav){B(document).bind("keydown.fb",function(V){if(V.keyCode==27&&G.enableEscapeButton){V.preventDefault();B.fancybox.close()}else{if((V.keyCode==37||V.keyCode==39)&&G.enableKeyboardNav&&V.target.tagName!=="INPUT"&&V.target.tagName!=="TEXTAREA"&&V.target.tagName!=="SELECT"){V.preventDefault();B.fancybox[V.keyCode==37?"prev":"next"]()}}})}if(!G.showNavArrows){O.hide();z.hide();return}if((G.cyclic&&y.length>1)||e!==0){O.show()}if((G.cyclic&&y.length>1)||e!=(y.length-1)){z.show()}},v=function(){if(!B.support.opacity){m.get(0).style.removeAttribute("filter");M.get(0).style.removeAttribute("filter")}if(H.autoDimensions){m.css("height","auto")}M.css("height","auto");if(t&&t.length){A.show()}if(G.showCloseButton){J.show()}g();if(G.hideOnContentClick){m.bind("click",B.fancybox.close)}if(G.hideOnOverlayClick){Q.bind("click",B.fancybox.close)}B(window).bind("resize.fb",B.fancybox.resize);if(G.centerOnScroll){B(window).bind("scroll.fb",B.fancybox.center)}if(G.type=="iframe"){B('<iframe id="fancybox-frame" name="fancybox-frame'+new Date().getTime()+'" frameborder="0" hspace="0" '+(B.browser.msie?'allowtransparency="true""':"")+' scrolling="'+H.scrolling+'" src="'+G.href+'"></iframe>').appendTo(m)}M.show();P=false;B.fancybox.center();G.onComplete(y,e,G);K()},K=function(){var V,W;if((y.length-1)>e){V=y[e+1].href;if(typeof V!=="undefined"&&V.match(i)){W=new Image();W.src=V}}if(e>0){V=y[e-1].href;if(typeof V!=="undefined"&&V.match(i)){W=new Image();W.src=V}}},U=function(W){var V={width:parseInt(b.width+(c.width-b.width)*W,10),height:parseInt(b.height+(c.height-b.height)*W,10),top:parseInt(b.top+(c.top-b.top)*W,10),left:parseInt(b.left+(c.left-b.left)*W,10)};if(typeof c.opacity!=="undefined"){V.opacity=W<0.5?0.5:W}M.css(V);m.css({width:V.width-G.padding*2,height:V.height-(h*W)-G.padding*2})},u=function(){return[B(window).width()-(G.margin*2),B(window).height()-(G.margin*2),B(document).scrollLeft()+G.margin,B(document).scrollTop()+G.margin]},R=function(){var V=u(),Z={},W=G.autoScale,X=G.padding*2,Y;if(G.width.toString().indexOf("%")>-1){Z.width=parseInt((V[0]*parseFloat(G.width))/100,10)}else{Z.width=G.width+X}if(G.height.toString().indexOf("%")>-1){Z.height=parseInt((V[1]*parseFloat(G.height))/100,10)}else{Z.height=G.height+X}if(W&&(Z.width>V[0]||Z.height>V[1])){if(H.type=="image"||H.type=="swf"){Y=(G.width)/(G.height);if((Z.width)>V[0]){Z.width=V[0];Z.height=parseInt(((Z.width-X)/Y)+X,10)}if((Z.height)>V[1]){Z.height=V[1];Z.width=parseInt(((Z.height-X)*Y)+X,10)}}else{Z.width=Math.min(Z.width,V[0]);Z.height=Math.min(Z.height,V[1])}}Z.top=parseInt(Math.max(V[3]-20,V[3]+((V[1]-Z.height-40)*0.5)),10);Z.left=parseInt(Math.max(V[2]-20,V[2]+((V[0]-Z.width-40)*0.5)),10);return Z},q=function(V){var W=V.offset();W.top+=parseInt(V.css("paddingTop"),10)||0;W.left+=parseInt(V.css("paddingLeft"),10)||0;W.top+=parseInt(V.css("border-top-width"),10)||0;W.left+=parseInt(V.css("border-left-width"),10)||0;W.width=V.width();W.height=V.height();return W},I=function(){var Y=H.orig?B(H.orig):false,X={},W,V;if(Y&&Y.length){W=q(Y);X={width:W.width+(G.padding*2),height:W.height+(G.padding*2),top:W.top-G.padding-20,left:W.left-G.padding-20}}else{V=u();X={width:G.padding*2,height:G.padding*2,top:parseInt(V[3]+V[1]*0.5,10),left:parseInt(V[2]+V[0]*0.5,10)}}return X},a=function(){if(!T.is(":visible")){clearInterval(p);return}B("div",T).css("top",(N*-40)+"px");N=(N+1)%12};B.fn.fancybox=function(V){if(!B(this).length){return this}B(this).data("fancybox",B.extend({},V,(B.metadata?B(this).metadata():{}))).unbind("click.fb").bind("click.fb",function(X){X.preventDefault();if(P){return}P=true;B(this).blur();j=[];C=0;var W=B(this).attr("rel")||"";if(!W||W==""||W==="nofollow"){j.push(this)}else{j=B('a[rel="'+W+'"], area[rel="'+W+'"]');C=j.index(this)}w();return});return this};B.fancybox=function(Y){var X;if(P){return}P=true;X=typeof arguments[1]!=="undefined"?arguments[1]:{};j=[];C=parseInt(X.index,10)||0;if(B.isArray(Y)){for(var W=0,V=Y.length;W<V;W++){if(typeof Y[W]=="object"){B(Y[W]).data("fancybox",B.extend({},X,Y[W]))}else{Y[W]=B({}).data("fancybox",B.extend({content:Y[W]},X))}}j=jQuery.merge(j,Y)}else{if(typeof Y=="object"){B(Y).data("fancybox",B.extend({},X,Y))}else{Y=B({}).data("fancybox",B.extend({content:Y},X))}j.push(Y)}if(C>j.length||C<0){C=0}w()};B.fancybox.showActivity=function(){clearInterval(p);T.show();p=setInterval(a,66)};B.fancybox.hideActivity=function(){T.hide()};B.fancybox.next=function(){return B.fancybox.pos(e+1)};B.fancybox.prev=function(){return B.fancybox.pos(e-1)};B.fancybox.pos=function(V){if(P){return}V=parseInt(V);j=y;if(V>-1&&V<y.length){C=V;w()}else{if(G.cyclic&&y.length>1){C=V>=y.length?0:y.length-1;w()}}return};B.fancybox.cancel=function(){if(P){return}P=true;B.event.trigger("fancybox-cancel");r();H.onCancel(j,C,H);P=false};B.fancybox.close=function(){if(P||M.is(":hidden")){return}P=true;if(G&&false===G.onCleanup(y,e,G)){P=false;return}r();B(J.add(O).add(z)).hide();B(m.add(Q)).unbind();B(window).unbind("resize.fb scroll.fb");B(document).unbind("keydown.fb");if(G.type==="iframe"){m.find("iframe").attr("src",S&&/^https/i.test(window.location.href||"")?"javascript:void(false)":"about:blank")}if(G.titlePosition!=="inside"){A.empty()}M.stop();function V(){Q.fadeOut("fast");A.empty().hide();M.hide();B.event.trigger("fancybox-cleanup");m.empty();G.onClosed(y,e,G);y=H=[];e=C=0;G=H={};P=false}if(G.transitionOut=="elastic"){b=I();var W=M.position();c={top:W.top,left:W.left,width:M.width(),height:M.height()};if(G.opacity){c.opacity=1}A.empty().hide();s.prop=1;B(s).animate({prop:0},{duration:G.speedOut,easing:G.easingOut,step:U,complete:V})}else{M.fadeOut(G.transitionOut=="none"?0:G.speedOut,V)}};B.fancybox.resize=function(){if(Q.is(":visible")){Q.css("height",B(document).height())}B.fancybox.center(true)};B.fancybox.center=function(){var V,W;if(P){return}W=arguments[0]===true?1:0;V=u();if(!W&&(M.width()>V[0]||M.height()>V[1])){return}M.stop().animate({top:parseInt(Math.max(V[3]-20,V[3]+((V[1]-m.height()-40)*0.5)-G.padding)),left:parseInt(Math.max(V[2]-20,V[2]+((V[0]-m.width()-40)*0.5)-G.padding))},typeof arguments[0]=="number"?arguments[0]:200)};B.fancybox.init=function(){if(B("#fancybox-wrap").length){return}B("body").append(L=B('<div id="fancybox-tmp"></div>'),T=B('<div id="fancybox-loading"><div></div></div>'),Q=B('<div id="fancybox-overlay"></div>'),M=B('<div id="fancybox-wrap"></div>'));d=B('<div id="fancybox-outer"></div>').append('<div class="fancybox-bg" id="fancybox-bg-n"></div><div class="fancybox-bg" id="fancybox-bg-ne"></div><div class="fancybox-bg" id="fancybox-bg-e"></div><div class="fancybox-bg" id="fancybox-bg-se"></div><div class="fancybox-bg" id="fancybox-bg-s"></div><div class="fancybox-bg" id="fancybox-bg-sw"></div><div class="fancybox-bg" id="fancybox-bg-w"></div><div class="fancybox-bg" id="fancybox-bg-nw"></div>').appendTo(M);d.append(m=B('<div id="fancybox-content"></div>'),J=B('<a id="fancybox-close"></a>'),A=B('<div id="fancybox-title"></div>'),O=B('<a href="javascript:;" id="fancybox-left"><span class="fancy-ico" id="fancybox-left-ico"></span></a>'),z=B('<a href="javascript:;" id="fancybox-right"><span class="fancy-ico" id="fancybox-right-ico"></span></a>'));J.click(B.fancybox.close);T.click(B.fancybox.cancel);O.click(function(V){V.preventDefault();B.fancybox.prev()});z.click(function(V){V.preventDefault();B.fancybox.next()});if(B.fn.mousewheel){M.bind("mousewheel.fb",function(V,W){if(P){V.preventDefault()}else{if(B(V.target).get(0).clientHeight==0||B(V.target).get(0).scrollHeight===B(V.target).get(0).clientHeight){V.preventDefault();B.fancybox[W>0?"prev":"next"]()}}})}if(!B.support.opacity){M.addClass("fancybox-ie")}if(S){T.addClass("fancybox-ie6");M.addClass("fancybox-ie6");B('<iframe id="fancybox-hide-sel-frame" src="'+(/^https/i.test(window.location.href||"")?"javascript:void(false)":"about:blank")+'" scrolling="no" border="0" frameborder="0" tabindex="-1"></iframe>').prependTo(d)}};B.fn.fancybox.defaults={padding:10,margin:40,opacity:false,modal:false,cyclic:false,scrolling:"auto",width:560,height:340,autoScale:true,autoDimensions:true,centerOnScroll:false,ajax:{},swf:{wmode:"transparent"},hideOnOverlayClick:true,hideOnContentClick:false,overlayShow:true,overlayOpacity:0.7,overlayColor:"#777",titleShow:true,titlePosition:"float",titleFormat:null,titleFromAlt:false,transitionIn:"fade",transitionOut:"fade",speedIn:300,speedOut:300,changeSpeed:300,changeFade:"fast",easingIn:"swing",easingOut:"swing",showCloseButton:true,showNavArrows:true,enableEscapeButton:true,enableKeyboardNav:true,onStart:function(){},onCancel:function(){},onComplete:function(){},onCleanup:function(){},onClosed:function(){},onError:function(){}};B(document).ready(function(){B.fancybox.init()})})(jQuery);
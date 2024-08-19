// $Id: effects.js 15736 2009-02-06 15:29:25Z nikolai $
/**
 *
 * Copyright (c) 2004-2009 by Zapatec, Inc.
 * http://www.zapatec.com
 * 1700 MLK Way, Berkeley, California,
 * 94709, U.S.A.
 * All rights reserved.
 */

if (typeof Zapatec == 'undefined') {
  /// define the global Zapatec namespace
  Zapatec = {};
}

/**
 * Zapatec.Effect hierarchy contains functions for working with visual effects.
 * These are called to progressively style the DOM elements as menus show
 * and hide. They do not have to set item visibility, but may want to set DOM
 * properties like clipping, opacity and position to create custom effects.
 *
 * @param ref [HTMLElement] -- a target DOM element.
 * @param counter [number] -- an animation progress value, from 0 (start) to 100 (end).
 */

Zapatec.Effect = {};

/*
* Constant stores value for removing clip effect
*/
Zapatec.Effect.NO_CLIP = ((window.opera || navigator.userAgent.indexOf('KHTML') > -1) ?
	'' : 'rect(auto, auto, auto, auto)');

/**
 * Internal. Sometimes it is useful to execute some action for elements and all 
 * their childs.
 *
 * @param ref [HTMLElement] -- a target DOM element.
 * @param funcToDo [function] -- function that would be applied to ref.
 */

Zapatec.Effect.applyFunc = function(ref, funcToDo) {
	funcToDo(ref);

	for(var i = 0; i < ref.childNodes.length; i++) {
		Zapatec.Effect.applyFunc(ref.childNodes[i], funcToDo);
	}
};

Zapatec.Effect.fade = function(ref, counter) {
	if(ref.zpOriginalOpacity == null && ref.__zp_opacitySaved == null){
		ref.zpOpacitySaved = true;
		ref.zpOriginalOpacity = document.all ? 
			ref.style.filter : ref.style.opacity != null ? 
				ref.style.opacity : ref.style.MozOpacity
		;
	}

	var md = null;

	var currentOpacity = 
		(!isNaN(parseFloat(ref.zpOriginalOpacity || 1)) ?
			parseFloat(ref.zpOriginalOpacity || 1) : (
				(md = ref.zpOriginalOpacity.match(/alpha\(opacity=(\d+)\)/i)) ?
					parseInt(md[1]) / 100 : 1
			)
		) * counter / 100;

	if (ref.filters) {
		if (!ref.style.filter.match(/alpha/i)) {
			ref.style.filter += ' alpha(opacity=' + (currentOpacity * 100) + ')';
		} else if (ref.filters.length && ref.filters.alpha) {
			ref.style.filter = ref.style.filter.replace(/alpha\(opacity=\d+\)/ig, 'alpha(opacity=' + (Math.floor(currentOpacity * 100)) + ')');
		}
	} else {      
		if(counter > 0 && counter < 100){
			ref.style.opacity = ref.style.MozOpacity = currentOpacity;
		}
	}

	if(counter <= 0){
		ref.style.display = 'none';
		ref.style.filter = ref.style.opacity = ref.style.MozOpacity = ref.zpOriginalOpacity;
		ref.zpOriginalOpacity = null;
		ref.zpOpacitySaved = null;
	}

	if(counter >= 100 && ref.zpOpacitySaved != null) {
		ref.style.filter = ref.zpOriginalOpacity;

		// FF blinks if opacity is set to 1 for the element that already has it.
//		if(ref.zpOriginalOpacity != "" && parseFloat(ref.zpOriginalOpacity) != 1) {
			ref.style.opacity = ref.style.MozOpacity = ref.zpOriginalOpacity;
//		}
			
		ref.zpOriginalOpacity = null;
		ref.zpOpacitySaved = null;
	}
};

Zapatec.Effect.slideTop = function(ref, counter) {
	return Zapatec.Effect.slide(ref, counter, 'top');
};

Zapatec.Effect.slideRight = function(ref, counter) {
	return Zapatec.Effect.slide(ref, counter, 'right');
};

Zapatec.Effect.slideBottom = function(ref, counter) {
	return Zapatec.Effect.slide(ref, counter, 'bottom');
};

Zapatec.Effect.slideLeft = function(ref, counter) {
	return Zapatec.Effect.slide(ref, counter, 'left');
};

Zapatec.Effect.slide = function(ref, counter, direction) {
	if(typeof(direction) != 'string'){
		return false;
	}

	direction = direction.toLowerCase();

	var direct = "";

	switch(direction){
		case 'top':
			// fall through
		case 'bottom':
			direct = "marginTop";
			break;
		case 'right':
			// fall through
		case 'left':
			direct = "marginLeft";
			break;
		default:
			return false;
	}

	var cP = Math.pow(Math.sin(Math.PI*counter/200),0.75);
	if(isNaN(cP)){
		cP = 0;
	}

	if (typeof ref.__zp_origmargin == 'undefined') {
		ref.__zp_origmargin = ref.style[direct];
	}

	if(counter == 100){
		ref.style.clip = Zapatec.Effect.NO_CLIP;
		ref.style[direct] = ref.__zp_origmargin;
	} else {
		switch(direction){
			case 'top':
				ref.style.clip = 'rect(' +
					(ref.offsetHeight*(1 - cP)) + 'px, ' +
					ref.offsetWidth + 'px, ' +
					ref.offsetHeight + 'px, ' +
					'0px' +
				')';

				ref.style.marginTop = '-' + (ref.offsetHeight * (1 - cP)) + 'px';
				break;
			case 'right':
				ref.style.clip = 'rect(' +
					'0px, ' +
					(ref.offsetWidth * cP) + 'px, ' +
					ref.offsetHeight + 'px, ' +
					'0px' +
				')';

				ref.style.marginLeft = (ref.offsetWidth * (1 - cP)) + 'px';
				break;
			case 'bottom':
				ref.style.clip = 'rect(' +
					'0px, ' +
					ref.offsetWidth + 'px, ' +
					ref.offsetHeight*cP + 'px, ' +
					'0px' +
				')';
				ref.style.marginTop = (ref.offsetHeight * (1 - cP)) + 'px';
				break;
			case 'left':
				ref.style.clip = 'rect(' +
					'0px, ' +
					ref.offsetWidth + 'px, ' +
					ref.offsetHeight + 'px, ' +
					ref.offsetWidth*(1 - cP) + 'px' +
				')';

				ref.style.marginLeft = "-" + (ref.offsetWidth * (1 - cP)) + 'px';
				break;
		}
	}

	if(counter <= 0){
		ref.style.display = 'none';
		ref.style.clip = Zapatec.Effect.NO_CLIP;
		ref.style[direct] = ref.__zp_origmargin;
	}
};

Zapatec.Effect.glideTop = function(ref, counter) {
	return Zapatec.Effect.glide(ref, counter, 'top');
};

Zapatec.Effect.glideRight = function(ref, counter) {
	return Zapatec.Effect.glide(ref, counter, 'right');
};

Zapatec.Effect.glideBottom = function(ref, counter) {
	return Zapatec.Effect.glide(ref, counter, 'bottom');
};

Zapatec.Effect.glideLeft = function(ref, counter) {
	return Zapatec.Effect.glide(ref, counter, 'left');
};

Zapatec.Effect.glide = function(ref, counter, direction) {
	if(typeof(direction) != 'string'){
		return false;
	}

	direction = direction.toLowerCase();

	var cP = Math.pow(Math.sin(Math.PI*counter/200),0.75);

	if(counter == 100){
		ref.style.clip = Zapatec.Effect.NO_CLIP;
	} else {
		switch(direction){
			case 'top':
				ref.style.clip = 'rect(' +
					(ref.offsetHeight*(1 - cP)) + 'px, ' +
					ref.offsetWidth + 'px, ' +
					ref.offsetHeight + 'px, ' +
					'0px' +
				')';
				break;
			case 'right':
				ref.style.clip = 'rect(' +
					'0px, ' +
					(ref.offsetWidth * cP) + 'px, ' +
					ref.offsetHeight + 'px, ' +
					'0px' +
				')';
				break;
			case 'bottom':
				ref.style.clip = 'rect(' +
					'0px, ' +
					ref.offsetWidth + 'px, ' +
					ref.offsetHeight*cP + 'px, ' +
					'0px' +
				')';
				break;
			case 'left':
				ref.style.clip = 'rect(' +
					'0px, ' +
					ref.offsetWidth + 'px, ' +
					ref.offsetHeight + 'px, ' +
					ref.offsetWidth*(1 - cP) + 'px' +
				')';
				break;
		}
	}

	if(counter <= 0){
		ref.style.display = 'none';
		ref.style.clip = Zapatec.Effect.NO_CLIP;
	}
};

Zapatec.Effect.wipe = function(ref, counter) {
	ref.style.clip = (counter==100) ? Zapatec.Effect.NO_CLIP :
		'rect(0, ' + (ref.offsetWidth*(counter/100)) + 'px, ' +
		(ref.offsetHeight*(counter/100)) + 'px, 0)';

	if(counter <= 0){
		ref.style.display = 'none';
		ref.style.clip = Zapatec.Effect.NO_CLIP;
	}
};

Zapatec.Effect.unfurl = function(ref, counter) {
	if (counter <= 50) {
		ref.style.clip = 'rect(0, ' + (ref.offsetWidth*(counter/50)) +
			'px, 10px, 0)';
	} else if (counter < 100) {
		ref.style.clip =  'rect(0, ' + ref.offsetWidth + 'px, ' +
			(ref.offsetHeight*((counter-50)/50)) + 'px, 0)';
	} else {
		ref.style.clip = Zapatec.Effect.NO_CLIP;
	}

	if(counter <= 0){
		ref.style.display = 'none';
		ref.style.clip = Zapatec.Effect.NO_CLIP;
	}
};

Zapatec.Effect.shrink = function(ref, counter) {
	var paddingWidth = Math.floor(ref.offsetWidth * counter / 200);
	var paddingHeight = Math.floor(ref.offsetHeight * counter / 200);

	ref.style.clip = (counter >= 100) ? 
		Zapatec.Effect.NO_CLIP : "rect(" + (ref.offsetHeight / 2 - paddingHeight) + "px, " + (ref.offsetWidth/2 + paddingWidth) + "px, "
			+ (ref.offsetHeight / 2 + paddingHeight) + "px, " + (ref.offsetWidth/2 - paddingWidth) + "px)";

	if(counter <= 0){
		ref.style.display = 'none';
		ref.style.clip = Zapatec.Effect.NO_CLIP;
	}
};

Zapatec.Effect.grow = function(ref, counter) {
	Zapatec.Effect.shrink(ref, 100 - counter);
};

Zapatec.Effect.highlight = function(ref, counter) {
	if(ref.origbackground == null) {
		Zapatec.Effect.applyFunc(ref, function(){ 
			var el = arguments[0];

			if(el.nodeType == 1) {
				el.origbackground = el.style.backgroundColor;
			}
		});
	}

	Zapatec.Effect.applyFunc(ref, function(){ 
		var el = arguments[0];

		if(el.nodeType == 1) {
			el.style.backgroundColor = "#FFFF" + (255 - Math.floor(counter*1.5)).toString(16);
		}
	});

	if(counter <= 0 || counter >= 100) {
		Zapatec.Effect.applyFunc(ref, function(){ 
			var el = arguments[0];

			if(el.nodeType == 1) {
				el.style.backgroundColor = el.origbackground;
				el.origbackground = null;
			}
		});
	}
};

Zapatec.Effect.roundCorners = function(ref, outerColor, innerColor){
	if(!document.getElementById || !document.createElement){
	    return;
	}

	var ua = navigator.userAgent.toLowerCase();

	if(ua.indexOf("msie 5") != -1 && ua.indexOf("opera") == -1){
	    return;
	}

	var top = document.createElement("div");
	top.className = "rtop";
	top.style.backgroundColor = outerColor;
		
	for(var i = 1; i <= 4; i++){
		var child = document.createElement("span");
		child.className = "r" + i;
		child.style.backgroundColor = innerColor;
		top.appendChild(child);
	}

	ref.firstChild == null ? 
		ref.appendChild(top) : ref.insertBefore(top, ref.firstChild);

	var bottom = document.createElement("div");
	bottom.className = 'rbottom';
	bottom.style.backgroundColor = outerColor;

	for(var i = 4; i >= 1; i--){
		var child = document.createElement("span");
		child.className = 'r' + i;
		child.style.backgroundColor = innerColor;
		bottom.appendChild(child);
	}

	ref.appendChild(bottom);
	ref.__zp_roundCorners = true;
	ref.__zp_outerColor = outerColor;

	// if element has shadow - 
	if(ref.__zp_dropshadow != null){
		document.body.removeChild(ref.__zp_dropshadow);
		ref.__zp_dropshadow = null;
		Zapatec.Effect.dropShadow(ref, ref.__zp_deep);
	}
};

Zapatec.Effect.dropShadow = function(ref, deep) {
	// if an element already has a shadow or the element is not visible - do nothing
	if(ref.__zp_dropshadow != null || ref.style.display == 'none'){
		return false;
	}

	// parse deep parameter.
	if(deep == null || isNaN(parseInt(deep))) {
		deep = 5;
	}
	Zapatec.Effects.defOnBeginFunc(ref);
	ref.__zp_deep = deep;
	var shadow = document.createElement("div");
	
	shadow.style.position = "absolute";
	shadow.style.backgroundColor = "#666666";
	shadow.style.MozOpacity = 0.50;
	shadow.style.filter = "Alpha(Opacity=50)";

	var pos = Zapatec.Utils.getElementOffset(ref);
	
	shadow.style.left = (pos.x + deep) + "px";
	shadow.style.top = (pos.y + deep) + "px";
	shadow.style.width = ref.offsetWidth + "px";
	shadow.style.height = ref.offsetHeight + "px";
	shadow.style.visibility = ref.style.visibility;
	shadow.style.display = ref.style.display;

	ref.__zp_dropshadow = shadow;
		
	document.body.insertBefore(shadow, document.body.firstChild);

	if(ref.__zp_roundCorners){
		Zapatec.Effects.apply(shadow, 'roundCorners', {outerColor: ref.__zp_outerColor, innerColor: "#666666"});
	}

	return true;
};

Zapatec.Effects = {};

/**
 * This method is used to show HTML element with some visual effects.
 *
 * @param ref [HTMLElement] -- a DOM element that contains menu items.
 * @param animSpeed [number] -- animation speed. From 1(lowest speed) to 100(highest speed)
 * @param effects [String or array] -- effects to be applied to the element. The value should be a 
 * string (when only one effect is to be applied) or an array of strings
 * @param onFinish[function] -- function to call on effect finish
 * @param stretch	-- stretch can only receive values of 0, 1, 2 that stand for
 * ['barn', 'strut', 'relative']
 * @param disable_show -- disables repeating show, when this method is already 
 * called and the element is shown
 */

Zapatec.Effects.show = function(ref, animSpeed, effects, onFinish, stretch, disable_show) {	
	var ref_element = !ref.tagName ? document.getElementById(ref) : ref;
	var display_ref = Zapatec.Utils.getStyleProperty(ref_element, 'display');
	if(disable_show){
		if(display_ref == 'none'){
			Zapatec.Effects.init(ref, true, animSpeed, effects, onFinish, stretch);
		}	
	}else{
		Zapatec.Effects.init(ref, true, animSpeed, effects, onFinish, stretch);
	}	
};

/**
 * This method is used to hide an HTML element with some visual effects.
 *
 * @param ref [HTMLElement] -- a DOM element that contains menu items.
 * @param animSpeed [number] -- animation speed. From 1(lowest speed) to 100(highest speed)
 * @param effects [string or array] -- effects to be applied to the element. The value should be a 
 * string (when only one effect is to be applied) or an array of strings
 * @param onFinish[function] -- function to call on effect finish
 * @param stretch[number] -- stretch can only receive values of 0, 1, 2 that stand for
 * ['barn', 'strut', 'relative']
 * @param disable_hide -- disables repeating hide, when this method is already 
 * called and the element is hidden
 */

Zapatec.Effects.hide = function(ref, animSpeed, effects, onFinish, stretch, disable_hide) {
	var ref_element = !ref.tagName ? document.getElementById(ref) : ref;
	var display_ref = Zapatec.Utils.getStyleProperty(ref_element, 'display');
	if(disable_hide){
		if (display_ref != 'none'){
			Zapatec.Effects.init(ref, false, animSpeed, effects, onFinish, stretch);
		}
	}else{
		Zapatec.Effects.init(ref, false, animSpeed, effects, onFinish, stretch);
	}
};

/**
 * This method is used to show/hide an HTML element with some visual effects.
 *
 * @param ref [HTMLElement] -- a DOM element that contains menu items.
 * @param show [boolean] -- if true - show the element, false - hide the element.
 * @param animSpeed [number] -- animation speed. From 1(lowest speed) to 100(highest speed)
 * @param effects [string or array] -- effects to be applied to the element. The value should be a 
 * string (when only one effect is to be applied) or an array of strings
 * @param onFinish[function] -- function to call on effect finish
 * @param stretch[number] -- stretch can only receive values of 0, 1, 2 that stand for
 * ['barn', 'strut', 'relative']
 */

Zapatec.Effects.init = function(ref, show, animSpeed, effects, onFinish, stretch){
	if(typeof ref == "string"){
		ref = document.getElementById(ref);		
	}

	if(ref == null){
		return null;
	}

	if(stretch == undefined){
		ref.__zp_enableStretch = false;
		stretch = 0;
	}else{
		ref.__zp_enableStretch = true;
	}

	ref.stretch = stretch;
	Zapatec.Effects.defOnBeginFunc(ref, effects);
	ref.animations = [];

	if(effects == null || effects.length == 0){
		ref.style.display = show ? "" : "none";

		if(onFinish != null){
			onFinish();
		}

		return null;
	}

	// if effects is given as a string - replace it with an array with one value
	if(typeof effects == "string")
		effects = [effects];
		
	for(var i = 0; i < effects.length; i++){
		var effect = null;
	    
		// analyzing given effects names
		switch(effects[i]){
			case 'fade':
				effect = Zapatec.Effect.fade;
				break;
			case 'slide':
				effect = Zapatec.Effect.slideTop;
				break;
			case 'slideTop':
				effect = Zapatec.Effect.slideTop;
				break;
			case 'slideRight':
				effect = Zapatec.Effect.slideRight;
				break;
			case 'slideBottom':
				effect = Zapatec.Effect.slideBottom;
				break;
			case 'slideLeft':
				effect = Zapatec.Effect.slideLeft;
				break;
			case 'glide':
				effect = Zapatec.Effect.glideTop;
				break;
			case 'glideTop':
				effect = Zapatec.Effect.glideTop;
				break;
			case 'glideRight':
				effect = Zapatec.Effect.glideRight;
				break;
			case 'glideBottom':
				effect = Zapatec.Effect.glideBottom;
				break;
			case 'glideLeft':
				effect = Zapatec.Effect.glideLeft;
				break;
			case 'wipe':
				effect = Zapatec.Effect.wipe;
				break; 
			case 'unfurl':
				effect = Zapatec.Effect.unfurl;
				break;
			case 'grow':
				effect = Zapatec.Effect.grow;
				break;
			case 'shrink':
				effect = Zapatec.Effect.shrink;
				break;
			case 'highlight':
				effect = Zapatec.Effect.highlight;
				break;
		}

		if(effect != null){
			ref.animations.push(effect);
		}
	}

	if(ref.animations.length != 0 && ref.running == null) {
		ref.running = true;
		Zapatec.Effects.run(ref, animSpeed, show, null, onFinish);
	}
};

/**
 * Internal. Is called from Zapatec.Effects.init. Runs periodically
 * updating element properties.
 *
 * @param ref [HTMLElement] -- a DOM element that contains menu items.
 * @param animSpeed [number] -- animation speed. From 1(lowest speed) to 100(highest speed)
 * @param show [boolean] -- if true - show the element, false - hide the element.
 * @param currVal [number] -- current progress - from 0 to 100.
 * @param onFinish[function] -- function to call on effect finish
 */

Zapatec.Effects.run = function(ref, animSpeed, show, currVal, onFinish) {
	if(animSpeed == null)
		animSpeed = 10;

	if(currVal < 0){
		currVal = 0;
	}

	if(currVal > 100){
		currVal = 100;
	}

	if(currVal == null) {
		if(show){
			currVal = 0

			if(ref.style.display == "none"){
				ref.style.display = '';

				if(ref.__zp_dropshadow != null) {
					ref.__zp_dropshadow.style.display = '';
				}
			}
		}
		else {
			currVal = 100;
		}
	}
	
	currVal += (show ? 1 : -1) * animSpeed;	
	Zapatec.Effects.stretchTempDiv(ref, currVal);
	// run attached effects
	for (var i = 0; i < ref.animations.length; i++) {
		ref.animations[i](ref, currVal);

		if(ref.__zp_dropshadow != null) {
			ref.animations[i](ref.__zp_dropshadow, currVal);
		}
	}

	if (currVal <= 0 || currVal >= 100) {
		ref.running = null;
		Zapatec.Effects.defOnFinishFunc(ref);
		if(onFinish != null){					
			onFinish();
		}
		
		return;
	}
	else {
		setTimeout(function() {
			Zapatec.Effects.run(ref, animSpeed, show, currVal, onFinish);
		}, 50);
	}
};

Zapatec.Effects.apply = function(ref, effect, params){
	if(ref == null || effect == null) {
		return;
	}

	if(typeof ref == "string") {
		ref = document.getElementById(ref);
	}

	if(ref == null) {
		return;
	}

	switch(effect) {
		case 'roundCorners':
			return Zapatec.Effect.roundCorners(ref, params['outerColor'], params['innerColor']);
		case 'dropShadow':
			return Zapatec.Effect.dropShadow(ref, params['deep']);
	}
};

/**
 * Internal. Is called from Zapatec.Effects.init. Updates element properties.
 * Creates a temporary element to stretch over the page. Sets the display 
 * property of the main element to 'absolute'.
 * 
 * @param effects [string or array] -- effects to be applied to the element.
 * @param ref [HTMLElement] -- a DOM element that contains menu items.
 */
Zapatec.Effects.defOnBeginFunc = function(ref, effects){
	if((Zapatec.Utils.getStyleProperty(ref, 'position') != 'absolute' || ref.__zp_noAbsolutePos) && ref.__zp_enableStretch){
		ref.__zp_noAbsolutePos = true;
		var stretch = ref.stretch;	
		var allOffsetPosition = Zapatec.Utils.getElementOffset(ref);
		allOffsetPosition.marginBottom = Zapatec.Utils.getStyleProperty(ref, 'marginBottom');
		allOffsetPosition.marginTop = Zapatec.Utils.getStyleProperty(ref, 'marginTop');
		allOffsetPosition.marginRight = Zapatec.Utils.getStyleProperty(ref, 'marginRight');
		allOffsetPosition.marginLeft = Zapatec.Utils.getStyleProperty(ref, 'marginLeft');

		allOffsetPosition.paddingLeft = Zapatec.Utils.getStyleProperty(ref, 'paddingLeft');
		allOffsetPosition.paddingTop = Zapatec.Utils.getStyleProperty(ref, 'paddingTop');
		allOffsetPosition.paddingRight = Zapatec.Utils.getStyleProperty(ref, 'paddingRight');
		allOffsetPosition.paddingBottom = Zapatec.Utils.getStyleProperty(ref, 'paddingBottom');

		allOffsetPosition.borderRightWidth = Zapatec.Utils.getStyleProperty(ref, 'borderRightWidth');
		allOffsetPosition.borderLeftWidth = Zapatec.Utils.getStyleProperty(ref, 'borderLeftWidth');
		allOffsetPosition.borderTopWidth = Zapatec.Utils.getStyleProperty(ref, 'borderTopWidth');
		allOffsetPosition.borderBottomWidth = Zapatec.Utils.getStyleProperty(ref, 'borderBottomWidth');

		allOffsetPosition.borderRightStyle = Zapatec.Utils.getStyleProperty(ref, 'borderRightStyle');
		allOffsetPosition.borderLeftStyle = Zapatec.Utils.getStyleProperty(ref, 'borderLeftStyle');
		allOffsetPosition.borderBottomStyle = Zapatec.Utils.getStyleProperty(ref, 'borderBottomStyle');
		allOffsetPosition.borderTopStyle = Zapatec.Utils.getStyleProperty(ref, 'borderTopStyle');

		allOffsetPosition.borderTopColor = Zapatec.Utils.getStyleProperty(ref, 'borderTopColor');
		allOffsetPosition.borderBottomColor = Zapatec.Utils.getStyleProperty(ref, 'borderBottomColor');
		allOffsetPosition.borderLeftColor = Zapatec.Utils.getStyleProperty(ref, 'borderLeftColor');
		allOffsetPosition.borderRightColor = Zapatec.Utils.getStyleProperty(ref, 'borderRightColor');

		ref.__zp_allOffsetPosition = allOffsetPosition;
		ref.__zp_stretchEffects = effects;
		ref.style.display = '';

		if(ref.__zp_dropshadow){
			ref.__zp_dropshadow.style.display = "";
		}
		
		if(ref.__zp_stretchElem && Zapatec.Utils.getStyleProperty(ref.__zp_stretchElem, 'height') == '0px'){		
			var new_elem = ref.__zp_stretchElem;
			Zapatec.Effects.setTempElemStyle(new_elem, allOffsetPosition, ref);
		}
		if((ref && Zapatec.Utils.getStyleProperty(ref, 'position') != 'absolute')){			
			if(!ref.__zp_stretchElem){			
				// new element to simulate the absolute position
		  	var new_elem = document.createElement(ref.tagName);
				Zapatec.Effects.setTempElemStyle(new_elem, allOffsetPosition, ref);
			}

			ref.style.position = "absolute";
			ref.style.margin = 0;
			ref.style.padding = 0;
			ref.style.left = ref.style.left || allOffsetPosition.left	+ "px";
			ref.style.top = ref.style.top || allOffsetPosition.top	+ "px";
			if(isFinite(parseInt(allOffsetPosition.borderLeftWidth)) &&
				isFinite(parseInt(allOffsetPosition.borderRightWidth)) &&
				isFinite(parseInt(allOffsetPosition.borderTopWidth)) &&
				isFinite(parseInt(allOffsetPosition.borderBottomWidth))
			){
				ref.style.width = ref.style.width || (allOffsetPosition.width - 
				parseInt(allOffsetPosition.borderRightWidth) - parseInt(allOffsetPosition.borderLeftWidth)) + "px";
				ref.style.height = ref.style.height || (allOffsetPosition.height - 
				parseInt(allOffsetPosition.borderTopWidth) - parseInt(allOffsetPosition.borderBottomWidth)) + "px";		
			}else{
			  ref.style.width = ref.style.width || allOffsetPosition.width + "px";
				ref.style.height = ref.style.height || allOffsetPosition.height + "px";		
			}
		}
	}
};

/**
 * Internal. Is called on effect finish. Updates element properties.
 * Removes a temporary element and sets the display property to 'static'
 *
 * @param effects [string or array] -- effects to be applied to the element.
 */
Zapatec.Effects.defOnFinishFunc = function(ref){
  	if(
  		ref && 
  		ref.__zp_stretchElem && 
  		Zapatec.Utils.getStyleProperty(ref, 'display') == 'none' && 
  		ref.__zp_allOffsetPosition && 
  		!ref.__zp_dropshadow &&
  		ref.__zp_noAbsolutePos &&
  		ref.__zp_enableStretch
  	){
  			var allOffsetPosition = ref.__zp_allOffsetPosition;    
			Zapatec.Effects.setMainElemStyle(allOffsetPosition, ref);
			if(ref.stretch != null && (ref.stretch == 0 || ref.stretch == 2)){
				Zapatec.Effects.remTempDiv(ref);
			}
  	}else if(
  		ref && 
  		ref.__zp_stretchElem && 
  		Zapatec.Utils.getStyleProperty(ref, 'display') != 'none' && 
  		ref.__zp_allOffsetPosition && 
  		!ref.__zp_dropshadow  &&
  		ref.__zp_noAbsolutePos &&
  		ref.__zp_enableStretch
  		){
  			var allOffsetPosition = ref.__zp_allOffsetPosition;
			Zapatec.Effects.setMainElemStyle(allOffsetPosition, ref);						
			Zapatec.Effects.remTempDiv(ref);                                    
  	}
};

/**
 * Internal. Removes a temporary element.
 * Removes a temporary element and sets the position property to 'static'
 *
 * @param effects [string or array] -- effects to be applied to the element.
 */
Zapatec.Effects.remTempDiv = function(ref){
	//alert(1);
	//ref.__zp_stretchElem.style.height = "0px";
	//alert(2);
	ref.__zp_stretchElem.display = "none";
	//alert(3);
	if(Zapatec.is_ie || Zapatec.is_opera){
		if(ref && ref.__zp_stretchElem){
			ref.__zp_stretchElem.parentNode.removeChild(ref.__zp_stretchElem);
			ref.__zp_stretchElem = null;
		}
	}else{
		setTimeout(
			function(){
				if(ref && ref.__zp_stretchElem){
					//alert(4);
					ref.__zp_stretchElem.parentNode.removeChild(ref.__zp_stretchElem);
					//alert(5);
					ref.__zp_stretchElem = null;
				}
			},
			0
		);
	}//*/	
};

/**
 * Internal. Is called from Zapatec.Effects.run. Runs periodically
 * updating element properties.
 *
 * @param ref [HTMLElement] -- a DOM element that contains menu items.
 * @param currVal [number] -- current progress - from 0 to 100.
 */
Zapatec.Effects.stretchTempDiv = function(ref, currVal){
	if(ref.stretch == 2 && ref.__zp_noAbsolutePos && ref.__zp_enableStretch){
		var effects = ref.__zp_stretchEffects;		
		var tmpDiv = ref.__zp_stretchElem;
		var allOffsetPosition = ref.__zp_allOffsetPosition;
		var tmpHeight = parseInt(Zapatec.Utils.getElementOffset(ref).height);
		if(tmpHeight != 0 && 
			(effects == 'slide' || 
			effects == 'wipe' || 
			effects == 'unfurl' || 
			effects == 'slideTop' || 
			effects == 'glideBottom')
			){
				var cP = Math.pow(Math.sin(Math.PI * currVal/200),0.75);
				if(isFinite(parseInt(allOffsetPosition.borderTopWidth)) 
					&& isFinite(parseInt(allOffsetPosition.borderBottomWidth))
				){
					var elemHeight = (Math.floor(tmpHeight * cP) - parseInt(allOffsetPosition.borderTopWidth) 
					- parseInt(allOffsetPosition.borderBottomWidth));
				}else{
				  var elemHeight = Math.floor(tmpHeight * cP);
				}
				if(elemHeight >= 0)
				{
					tmpDiv.style.height = elemHeight + "px";				
				}else{
					tmpDiv.style.height = "0px";								
				}				
		}
	}
};

/**
 * Internal. Is called from Zapatec.Effects.defOnBeginFunc. 
 * Sets style properties for the temporary element 
 *
 * @param ref [HTMLElement] -- a DOM element that contains menu items.
 * @param allOffsetPosition [Object] -- an instance of the object with the style property
 * @new_elem -- a temporary element
 */
Zapatec.Effects.setTempElemStyle = function(new_elem, allOffsetPosition, ref){
	//new_elem.style.position = "static";
	new_elem.style.visibility = "hidden";
	if(Zapatec.Utils.getStyleProperty(ref, 'display') == "inline"){
		new_elem.style.display = "block";
	}

	new_elem.style.marginBottom = allOffsetPosition.marginBottom;
	new_elem.style.marginTop = allOffsetPosition.marginTop;
	new_elem.style.marginmarginRight = allOffsetPosition.marginmarginRight;
	new_elem.style.marginLeft = allOffsetPosition.marginLeft;

	new_elem.style.borderRightWidth = allOffsetPosition.borderRightWidth;
	new_elem.style.borderLeftWidth = allOffsetPosition.borderLeftWidth;
	new_elem.style.borderTopWidth = allOffsetPosition.borderTopWidth;
	new_elem.style.borderBottomWidth = allOffsetPosition.borderBottomWidth;
	
	new_elem.style.borderRightStyle = allOffsetPosition.borderRightStyle;
	new_elem.style.borderTopStyle = allOffsetPosition.borderTopStyle;
	new_elem.style.borderBottomStyle = allOffsetPosition.borderBottomStyle;
	new_elem.style.borderLeftStyle = allOffsetPosition.borderLeftStyle;

	new_elem.style.borderTopColor = allOffsetPosition.borderTopColor;
	new_elem.style.borderRightColor = allOffsetPosition.borderRightColor;
	new_elem.style.borderBottomColor = allOffsetPosition.borderBottomColor;
	new_elem.style.borderLeftColor = allOffsetPosition.borderLeftColor;

	if(!Zapatec.is_ie){	
		new_elem.style.width = ref.style.width || (allOffsetPosition.width - 
		parseInt(allOffsetPosition.borderRightWidth) - parseInt(allOffsetPosition.borderLeftWidth)) + "px";
		new_elem.style.height = ref.style.height || (allOffsetPosition.height - 
		parseInt(allOffsetPosition.borderTopWidth) - parseInt(allOffsetPosition.borderBottomWidth)) + "px";		
	}else{
		if(isFinite(parseInt(allOffsetPosition.borderLeftWidth)) &&
			isFinite(parseInt(allOffsetPosition.borderRightWidth)) &&
			isFinite(parseInt(allOffsetPosition.borderTopWidth)) &&
			isFinite(parseInt(allOffsetPosition.borderBottomWidth))
		){
			new_elem.style.width = ref.style.width || (allOffsetPosition.width - 
			parseInt(allOffsetPosition.borderRightWidth) - parseInt(allOffsetPosition.borderLeftWidth)) + "px";
			new_elem.style.height = ref.style.height || (allOffsetPosition.height - 
			parseInt(allOffsetPosition.borderTopWidth) - parseInt(allOffsetPosition.borderBottomWidth)) + "px";		
		}else{
			new_elem.style.width = ref.style.width || parseInt(allOffsetPosition.width) + "px"; 
			new_elem.style.height = ref.style.height || parseInt(allOffsetPosition.height) + "px";		
		}
	}
	ref.parentNode.insertBefore(new_elem, ref);
	ref.__zp_stretchElem = new_elem;
};

/**
 * Internal. Is called from Zapatec.Effects.defOnFinishFunc. 
 * Sets style properties for the temporary element 
 *
 * @param ref [HTMLElement] -- a DOM element that contains menu items.
 * @param allOffsetPosition [object] -- an instance of the object with the style property
 */
Zapatec.Effects.setMainElemStyle = function(allOffsetPosition, ref){
	ref.style.position 	= "";
	if(Zapatec.Utils.getStyleProperty(ref, 'display') == "inline"){
		ref.style.display = "block";
	}

  	ref.style.marginBottom = allOffsetPosition.marginBottom;
	ref.style.marginRight = allOffsetPosition.marginRight;
	ref.style.marginTop = allOffsetPosition.marginTop;
	ref.style.marginLeft = allOffsetPosition.marginLeft;

	ref.style.paddingBottom = allOffsetPosition.paddingBottom;
	ref.style.paddingRight = allOffsetPosition.paddingRight;
	ref.style.paddingTop = allOffsetPosition.paddingTop;
	ref.style.paddingLeft = allOffsetPosition.paddingLeft;
};

Zapatec.Utils.addEvent(window, 'load', Zapatec.Utils.checkActivation);

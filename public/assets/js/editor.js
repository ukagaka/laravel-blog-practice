/**
 * @file: mod.js
 * @author fis
 * ver: 1.0.11
 * update: 2015/05/14
 * https://github.com/fex-team/mod
 */
var require;

/* eslint-disable no-unused-vars */
var define;

(function (global) {

    // 避免重复加载而导致已定义模块丢失
    if (require) {
        return;
    }

    var head = document.getElementsByTagName('head')[0];
    var loadingMap = {};
    var factoryMap = {};
    var modulesMap = {};
    var scriptsMap = {};
    var resMap = {};
    var pkgMap = {};

    var createScript = function (url, onerror) {
        if (url in scriptsMap) {
            return;
        }

        scriptsMap[url] = true;

        var script = document.createElement('script');
        if (onerror) {
            var tid = setTimeout(onerror, require.timeout);

            script.onerror = function () {
                clearTimeout(tid);
                onerror();
            };

            var onload = function () {
                clearTimeout(tid);
            };

            if ('onload' in script) {
                script.onload = onload;
            }
            else {
                script.onreadystatechange = function () {
                    if (this.readyState === 'loaded' || this.readyState === 'complete') {
                        onload();
                    }
                };
            }
        }
        script.type = 'text/javascript';
        script.src = url;
        head.appendChild(script);
        return script;
    };

    var loadScript = function (id, callback, onerror) {
        var queue = loadingMap[id] || (loadingMap[id] = []);
        queue.push(callback);

        //
        // resource map query
        //
        var res = resMap[id] || resMap[id + '.js'] || {};
        var pkg = res.pkg;
        var url;

        if (pkg) {
            url = pkgMap[pkg].url;
        }
        else {
            url = res.url || id;
        }

        createScript(url, onerror && function () {
            onerror(id);
        });
    };

    define = function (id, factory) {
        id = id.replace(/\.js$/i, '');
        factoryMap[id] = factory;

        var queue = loadingMap[id];
        if (queue) {
            for (var i = 0, n = queue.length; i < n; i++) {
                queue[i]();
            }
            delete loadingMap[id];
        }
    };

    require = function (id) {

        // compatible with require([dep, dep2...]) syntax.
        if (id && id.splice) {
            return require.async.apply(this, arguments);
        }

        id = require.alias(id);

        var mod = modulesMap[id];
        if (mod) {
            return mod.exports;
        }

        //
        // init module
        //
        var factory = factoryMap[id];
        if (!factory) {
            throw '[ModJS] Cannot find module `' + id + '`';
        }

        mod = modulesMap[id] = {
            exports: {}
        };

        //
        // factory: function OR value
        //
        var ret = (typeof factory === 'function') ? factory.apply(mod, [require, mod.exports, mod]) : factory;

        if (ret) {
            mod.exports = ret;
        }

        if (mod.exports && !mod.exports['default']) {
            mod.exports['default'] = mod.exports;
        }

        return mod.exports;
    };

    require.async = function (names, onload, onerror) {
        if (typeof names === 'string') {
            names = [names];
        }

        var needMap = {};
        var needNum = 0;

        function findNeed(depArr) {
            var child;

            for (var i = 0, n = depArr.length; i < n; i++) {
                //
                // skip loading or loaded
                //
                var dep = require.alias(depArr[i]);

                if (dep in factoryMap) {
                    // check whether loaded resource's deps is loaded or not
                    child = resMap[dep] || resMap[dep + '.js'];
                    if (child && 'deps' in child) {
                        findNeed(child.deps);
                    }
                    continue;
                }

                if (dep in needMap) {
                    continue;
                }

                needMap[dep] = true;
                needNum++;
                loadScript(dep, updateNeed, onerror);

                child = resMap[dep] || resMap[dep + '.js'];
                if (child && 'deps' in child) {
                    findNeed(child.deps);
                }
            }
        }

        function updateNeed() {
            if (0 === needNum--) {
                var args = [];
                for (var i = 0, n = names.length; i < n; i++) {
                    args[i] = require(names[i]);
                }

                onload && onload.apply(global, args);
            }
        }

        findNeed(names);
        updateNeed();
    };

    require.resourceMap = function (obj) {
        var k;
        var col;

        // merge `res` & `pkg` fields
        col = obj.res;
        for (k in col) {
            if (col.hasOwnProperty(k)) {
                resMap[k] = col[k];
            }
        }

        col = obj.pkg;
        for (k in col) {
            if (col.hasOwnProperty(k)) {
                pkgMap[k] = col[k];
            }
        }
    };

    require.loadJs = function (url) {
        createScript(url);
    };

    require.loadCss = function (cfg) {
        if (cfg.content) {
            var sty = document.createElement('style');
            sty.type = 'text/css';

            if (sty.styleSheet) { // IE
                sty.styleSheet.cssText = cfg.content;
            }
            else {
                sty.innerHTML = cfg.content;
            }
            head.appendChild(sty);
        }
        else if (cfg.url) {
            var link = document.createElement('link');
            link.href = cfg.url;
            link.rel = 'stylesheet';
            link.type = 'text/css';
            head.appendChild(link);
        }
    };


    require.alias = function (id) {
        return id.replace(/\.js$/i, '');
    };

    require.timeout = 5000;

})(this);
;
// 为数组添加forEach方法
// Production steps of ECMA-262, Edition 5, 15.4.4.18
// Reference: http://es5.github.io/#x15.4.4.18
if (!Array.prototype.forEach) {
    Array.prototype.forEach = function(callback, thisArg) {
        var T, k;
        if (this == null) {
            throw new TypeError(' this is null or not defined');
        }
        // 1. Let O be the result of calling ToObject passing the |this| value as the argument.
        var O = Object(this);
        // 2. Let lenValue be the result of calling the Get internal method of O with the argument "length".
        // 3. Let len be ToUint32(lenValue).
        var len = O.length >>> 0;
        // 4. If IsCallable(callback) is false, throw a TypeError exception.
        // See: http://es5.github.com/#x9.11
        if (typeof callback !== "function") {
            throw new TypeError(callback + ' is not a function');
        }
        // 5. If thisArg was supplied, let T be thisArg; else let T be undefined.
        if (arguments.length > 1) {
            T = thisArg;
        }
        // 6. Let k be 0
        k = 0;
        // 7. Repeat, while k < len
        while (k < len) {
            var kValue;
            // a. Let Pk be ToString(k).
            //   This is implicit for LHS operands of the in operator
            // b. Let kPresent be the result of calling the HasProperty internal method of O with argument Pk.
            //   This step can be combined with c
            // c. If kPresent is true, then
            if (k in O) {
                // i. Let kValue be the result of calling the Get internal method of O with argument Pk.
                kValue = O[k];
                // ii. Call the Call internal method of callback with T as the this value and
                // argument list containing kValue, k, and O.
                callback.call(T, kValue, k, O);
            }
            // d. Increase k by 1.
            k++;
        }
        // 8. return undefined
    };
}
// Production steps of ECMA-262, Edition 5, 15.4.4.14
// Reference: http://es5.github.io/#x15.4.4.14
if (!Array.prototype.indexOf) {
    Array.prototype.indexOf = function(searchElement, fromIndex) {
        var k;
        // 1. Let O be the result of calling ToObject passing
        //    the this value as the argument.
        if (this == null) {
            throw new TypeError('"this" is null or not defined');
        }
        var O = Object(this);
        // 2. Let lenValue be the result of calling the Get
        //    internal method of O with the argument "length".
        // 3. Let len be ToUint32(lenValue).
        var len = O.length >>> 0;
        // 4. If len is 0, return -1.
        if (len === 0) {
            return -1;
        }
        // 5. If argument fromIndex was passed let n be
        //    ToInteger(fromIndex); else let n be 0.
        var n = +fromIndex || 0;
        if (Math.abs(n) === Infinity) {
            n = 0;
        }
        // 6. If n >= len, return -1.
        if (n >= len) {
            return -1;
        }
        // 7. If n >= 0, then Let k be n.
        // 8. Else, n<0, Let k be len - abs(n).
        //    If k is less than 0, then let k be 0.
        k = Math.max(n >= 0 ? n : len - Math.abs(n), 0);
        // 9. Repeat, while k < len
        while (k < len) {
            // a. Let Pk be ToString(k).
            //   This is implicit for LHS operands of the in operator
            // b. Let kPresent be the result of calling the
            //    HasProperty internal method of O with argument Pk.
            //   This step can be combined with c
            // c. If kPresent is true, then
            //    i.  Let elementK be the result of calling the Get
            //        internal method of O with the argument ToString(k).
            //   ii.  Let same be the result of applying the
            //        Strict Equality Comparison Algorithm to
            //        searchElement and elementK.
            //  iii.  If same is true, return k.
            if (k in O && O[k] === searchElement) {
                return k;
            }
            k++;
        }
        return -1;
    };
}
if (!Array.prototype.filter) {
    Array.prototype.filter = function(fun /*, thisArg*/ ) {
        'use strict';

        if (this === void 0 || this === null) {
            throw new TypeError();
        }

        var t = Object(this);
        var len = t.length >>> 0;
        if (typeof fun !== 'function') {
            throw new TypeError();
        }

        var res = [];
        var thisArg = arguments.length >= 2 ? arguments[1] : void 0;
        for (var i = 0; i < len; i++) {
            if (i in t) {
                var val = t[i];

                // NOTE: Technically this should Object.defineProperty at
                //       the next index, as push can be affected by
                //       properties on Object.prototype and Array.prototype.
                //       But that method's new, and collisions should be
                //       rare, so use the more-compatible alternative.
                if (fun.call(thisArg, val, i, t)) {
                    res.push(val);
                }
            }
        }

        return res;
    };
}
if (!Array.prototype.every) {
    Array.prototype.every = function(fun /*, thisArg */ ) {
        'use strict';

        if (this === void 0 || this === null)
            throw new TypeError();

        var t = Object(this);
        var len = t.length >>> 0;
        if (typeof fun !== 'function')
            throw new TypeError();

        var thisArg = arguments.length >= 2 ? arguments[1] : void 0;
        for (var i = 0; i < len; i++) {
            if (i in t && !fun.call(thisArg, t[i], i, t))
                return false;
        }

        return true;
    };
}
if (!Array.prototype.some) {
    Array.prototype.some = function(fun /*, thisArg */ ) {
        'use strict';

        if (this === void 0 || this === null)
            throw new TypeError();

        var t = Object(this);
        var len = t.length >>> 0;
        if (typeof fun !== 'function')
            throw new TypeError();

        var thisArg = arguments.length >= 2 ? arguments[1] : void 0;
        for (var i = 0; i < len; i++) {
            if (i in t && fun.call(thisArg, t[i], i, t))
                return true;
        }

        return false;
    };
}
// Production steps of ECMA-262, Edition 5, 15.4.4.19
// Reference: http://es5.github.io/#x15.4.4.19
if (!Array.prototype.map) {

    Array.prototype.map = function(callback, thisArg) {

        var T, A, k;

        if (this == null) {
            throw new TypeError(' this is null or not defined');
        }

        // 1. Let O be the result of calling ToObject passing the |this| 
        //    value as the argument.
        var O = Object(this);

        // 2. Let lenValue be the result of calling the Get internal 
        //    method of O with the argument "length".
        // 3. Let len be ToUint32(lenValue).
        var len = O.length >>> 0;

        // 4. If IsCallable(callback) is false, throw a TypeError exception.
        // See: http://es5.github.com/#x9.11
        if (typeof callback !== 'function') {
            throw new TypeError(callback + ' is not a function');
        }

        // 5. If thisArg was supplied, let T be thisArg; else let T be undefined.
        if (arguments.length > 1) {
            T = thisArg;
        }

        // 6. Let A be a new array created as if by the expression new Array(len) 
        //    where Array is the standard built-in constructor with that name and 
        //    len is the value of len.
        A = new Array(len);

        // 7. Let k be 0
        k = 0;

        // 8. Repeat, while k < len
        while (k < len) {

            var kValue, mappedValue;

            // a. Let Pk be ToString(k).
            //   This is implicit for LHS operands of the in operator
            // b. Let kPresent be the result of calling the HasProperty internal 
            //    method of O with argument Pk.
            //   This step can be combined with c
            // c. If kPresent is true, then
            if (k in O) {

                // i. Let kValue be the result of calling the Get internal 
                //    method of O with argument Pk.
                kValue = O[k];

                // ii. Let mappedValue be the result of calling the Call internal 
                //     method of callback with T as the this value and argument 
                //     list containing kValue, k, and O.
                mappedValue = callback.call(T, kValue, k, O);

                // iii. Call the DefineOwnProperty internal method of A with arguments
                // Pk, Property Descriptor
                // { Value: mappedValue,
                //   Writable: true,
                //   Enumerable: true,
                //   Configurable: true },
                // and false.

                // In browsers that support Object.defineProperty, use the following:
                // Object.defineProperty(A, k, {
                //   value: mappedValue,
                //   writable: true,
                //   enumerable: true,
                //   configurable: true
                // });

                // For best browser support, use the following:
                A[k] = mappedValue;
            }
            // d. Increase k by 1.
            k++;
        }

        // 9. return A
        return A;
    };
}
if ('function' !== typeof Array.prototype.reduce) {
    Array.prototype.reduce = function(callback, opt_initialValue) {
        'use strict';
        if (null === this || 'undefined' === typeof this) {
            // At the moment all modern browsers, that support strict mode, have
            // native implementation of Array.prototype.reduce. For instance, IE8
            // does not support strict mode, so this check is actually useless.
            throw new TypeError(
                'Array.prototype.reduce called on null or undefined');
        }
        if ('function' !== typeof callback) {
            throw new TypeError(callback + ' is not a function');
        }
        var index, value,
            length = this.length >>> 0,
            isValueSet = false;
        if (1 < arguments.length) {
            value = opt_initialValue;
            isValueSet = true;
        }
        for (index = 0; length > index; ++index) {
            if (this.hasOwnProperty(index)) {
                if (isValueSet) {
                    value = callback(value, this[index], index, this);
                } else {
                    value = this[index];
                    isValueSet = true;
                }
            }
        }
        if (!isValueSet) {
            throw new TypeError('Reduce of empty array with no initial value');
        }
        return value;
    };
}
// 去头尾空格
if (!String.prototype.trim) {
    String.prototype.trim = function() {
        return this.replace(/^[\s\uFEFF\xA0]+|[\s\uFEFF\xA0]+$/g, '');
    };
}
if (!window.JSON) {
    window.JSON = {
        parse: function(sJSON) {
            return eval('(' + sJSON + ')');
        },
        stringify: (function() {
            var toString = Object.prototype.toString;
            var isArray = Array.isArray || function(a) {
                return toString.call(a) === '[object Array]';
            };
            var escMap = {
                '"': '\\"',
                '\\': '\\\\',
                '\b': '\\b',
                '\f': '\\f',
                '\n': '\\n',
                '\r': '\\r',
                '\t': '\\t'
            };
            var escFunc = function(m) {
                return escMap[m] || '\\u' + (m.charCodeAt(0) + 0x10000).toString(16).substr(1);
            };
            var escRE = /[\\"\u0000-\u001F\u2028\u2029]/g;
            return function stringify(value) {
                if (value == null) {
                    return 'null';
                } else if (typeof value === 'number') {
                    return isFinite(value) ? value.toString() : 'null';
                } else if (typeof value === 'boolean') {
                    return value.toString();
                } else if (typeof value === 'object') {
                    if (typeof value.toJSON === 'function') {
                        return stringify(value.toJSON());
                    } else if (isArray(value)) {
                        var res = '[';
                        for (var i = 0; i < value.length; i++)
                            res += (i ? ', ' : '') + stringify(value[i]);
                        return res + ']';
                    } else if (toString.call(value) === '[object Object]') {
                        var tmp = [];
                        for (var k in value) {
                            if (value.hasOwnProperty(k))
                                tmp.push(stringify(k) + ': ' + stringify(value[k]));
                        }
                        return '{' + tmp.join(', ') + '}';
                    }
                }
                return '"' + value.toString().replace(escRE, escFunc) + '"';
            };
        })()
    };
}
if (!Object.keys) {
    Object.keys = function(o) {
        if (o !== Object(o))
            throw new TypeError('Object.keys called on a non-object');
        var k = [],
            p;
        for (p in o)
            if (Object.prototype.hasOwnProperty.call(o, p)) k.push(p);
        return k;
    }
}
/*
if (!document.querySelectorAll) {
    document.querySelectorAll = function (selectors) {
        var style = document.createElement('style'), elements = [], element;
        document.documentElement.firstChild.appendChild(style);
        document._qsa = [];

        style.styleSheet.cssText = selectors + '{x-qsa:expression(document._qsa && document._qsa.push(this))}';
        window.scrollBy(0, 0);
        style.parentNode.removeChild(style);

        while (document._qsa.length) {
            element = document._qsa.shift();
            element.style.removeAttribute('x-qsa');
            elements.push(element);
        }
        document._qsa = null;
        return elements;
    };
}

if (!document.querySelector) {
    document.querySelector = function (selectors) {
        var elements = document.querySelectorAll(selectors);
        return (elements.length) ? elements[0] : null;
    };
}
*/

if (!Function.prototype.bind) {
  Function.prototype.bind = function (oThis) {
    if (typeof this !== "function") {
      // closest thing possible to the ECMAScript 5
      // internal IsCallable function
      throw new TypeError("Function.prototype.bind - what is trying to be bound is not callable");
    }

    var aArgs = Array.prototype.slice.call(arguments, 1), 
        fToBind = this, 
        fNOP = function () {},
        fBound = function () {
          return fToBind.apply(this instanceof fNOP
                                 ? this
                                 : oThis || this,
                               aArgs.concat(Array.prototype.slice.call(arguments)));
        };

    fNOP.prototype = this.prototype;
    fBound.prototype = new fNOP();

    return fBound;
  };
}
define('modules/FacePopup/FacePopup', function(require, exports, module) {

  /**
   * create: 2016-9-13 20:18:55
   * author: xuxufei
   * e-mail: xuxufei@2144.cn
   * description: 表情弹出层
   */
  
  var error = function(){
  	if (console && typeof console.error === 'function') {
  		console.error.apply(console, arguments);
  	}
  };
  
  var instance,
  	g_context;
  
  var FacePopup = function(){
  	if (instance) {
  		return instance;
  	}
  	instance = this;
  
  	this.element = null;
  	this.panels = [{
  		name : '默认',
  		items : ['微笑', '大笑', '鼓掌', '不说了', '为什么', '哭', '不屑', '怒', '围观群众', '求神包邮', '胜利', '亏大了', '小钱钱', '牛', '俏皮', '傲', '好困惑', '想一下', '加油', '摊手', '汗', '兴奋', '失望', '困顿', '好逊', '爱心', '心碎', '赞', '不赞', '满仓', '空仓', '加仓', '减仓', '看多', '看空', '大便', '割韭菜', '诱多', '诱空', '涨了', '跌了', '赚钱了', '出政策了', '买入', '卖出']
  	}];
  	this.items = [];
  	this.current = 0;
  
  	this.init();
  };
  
  FacePopup.prototype = {
  	init : function(){
  		var self = this;
  
  		Event.on('OPEN_FACEPOPUP', function(x, y, flipOffset){
  			self.show().move(x, y, flipOffset);
  			g_context = this;
  		});	
  	},
  	create : function(){
  		var element = this.element = $('<div></div>').addClass('face_popup').appendTo(document.body),
  			panels = this.panels,
  			self = this;
  		this.hide();
  		panels.forEach(function(item, index){
  			item.parent = element;
  			var panel = new FacePanel(item);
  			this.items.push(panel);
  			if (index !== this.current) {
  				panel.hide();
  			}
  		}, this);
  
  		// 当点击其他位置的时候，隐藏表情弹出层
  		$(document).on('click', function(){
  			self.hide();
  		});
  
  		return this;
  	},
  	/**
  	 * 将弹出层移动到x,y的位置
  	 * @param  {Number} x      		x轴
  	 * @param  {Number} y      		y轴
  	 * @param  {Object} flipOffset 	翻转后的偏移量，包含x、y可以单独设置，如果不设置，则为0。当设置了之后，弹出层会对window的尺寸进行检测，尽量让弹出层完整的显示在窗口中。
  	 */
  	move : function(x, y, flipOffset){
  		var element = this.element,
  			offset, left, top,
  			wnd, w, h, ww, wh, fx, fy;
  		if (element) {
  			offset = element.offset();
  			left = offset.left;
  			top = offset.top;
  			x = +x;
  			y = +y;
  			if (type(x) !== 'number' || isNaN(x)) {
  				x = left;
  			}
  			if (type(y) !== 'number' || isNaN(y)) {
  				y = top;
  			}
  			if (type(flipOffset) === 'object') {
  				wnd = $(window);
  				ww = wnd.width();
  				wh = wnd.height();
  				w = element.outerWidth(true);
  				h = element.outerHeight(true);
  				if (x + w > ww) {
  					fx = +flipOffset.x;
  					if (type(fx) !== 'number' || isNaN(fx)) {
  						fx = 0;
  					}
  					x -= w;
  				}
  				if (y + h > wh) {
  					fy = +flipOffset.y;
  					if (type(fy) !== 'number' || isNaN(fy)) {
  						fy = 0;
  					}
  					y -= h + fy;
  				}
  			}
  			element.css({
  				left : x,
  				top : y
  			});
  		}
  
  		return this;
  	},
  	show : function(){
  		var element = this.element;
  		if (!element) {
  			this.create();
  			element = this.element;
  		}
  		if (element) {
  			element.removeClass('hidden');
  		}
  
  		return this;
  	},
  	hide : function(){
  		var element = this.element;
  		if (element) {
  			element.addClass('hidden');
  		}
  
  		return this;
  	}
  };
  
  var FacePanel = function(options){
  	$.extend(true, this, {
  		name : '',
  		items : [],
  		parent : $('body')
  	}, options || {});
  
  	this.create();
  };
  FacePanel.prototype = {
  	create : function(){
  		var element = this.element = $('<div></div>').addClass('fp_panel').appendTo(this.parent);
  		this.items = this.items.map(function(text, index){
  			return new FaceItem({
  				id : index,
  				name : text,
  				parent : element
  			});
  		});
  		// 当点击自己的时候，不关闭弹出层
  		element.on('click', function(event){
  			if (event.target === element.get(0)){
  				event.stopPropagation();
  			}
  		});
  
  		return this;
  	},
  	show : function(){
  		var element = this.element;
  		if (element) {
  			element.removeClass('hidden');
  		}
  
  		return this;
  	},
  	hide : function(){
  		var element = this.element;
  		if (element) {
  			element.addClass('hidden');
  		}
  
  		return this;
  	}
  };
  
  var FaceItem = function(options){
  	$.extend(true, this, {
  		id : -1,
  		name : '',
  		parent : $('body'),
  		path : 'http://static.2258.com/guba/images/face/default/'
  	}, options || {});
  	this.element = null;
  
  	this.create();
  };
  FaceItem.prototype = {
  	create : function(){
  		if (this.id < 0) {
  			this.error('FaceItem:create id无效.');
  			return this;
  		}
  		var self = this,
  			element = this.element = $('<span></span>')
  				.attr('title', this.name)
  				.appendTo(this.parent);
  		this.updateBackgroundPosition();
  		// 监听点击消息
  		element.on('click', function(){
  			Event.triggerWith(g_context, 'INSERT_FACE', [self.getUrl()]);
  		});
  
  		return this;
  	},
  	updateBackgroundPosition : function(){
  		var element = this.element,
  			height = element.height(),
  			id = this.id;
  		if (element) {
  			element.css('background-position', '0 -' + id * height + 'px');
  		}
  
  		return this;
  	},
  	getUrl : function(){
  		return this.path + (this.id + 1) + '.png';
  	},
  	error : error
  };
  
  module.exports = FacePopup;

});
define('modules/InsertImagePopup/InsertImagePopup', function(require, exports, module) {

  /**
   * create: 2016-9-13 20:34:26
   * author: xuxufei
   * e-mail: xuxufei@2144.cn
   * description: 插入图片弹出层
   */
  
  var error = function(){
  	if (console && typeof console.error === 'function') {
  		console.error.apply(console, arguments);
  	}
  };
  
  var noop = function(){};
  
  /**
   * PLUpload对象的封装
   * @param {Mixin} 	trigger 触发文件选择对话框的DOM元素，当点击该元素后便后弹出文件选择对话框。该值可以是DOM元素对象本身，也可以是该DOM元素的id
   * @param {Object} 	events  plupload实例对象的各种事件
   */
  var Uploader = function(trigger, events){
  	var uploader = new plupload.Uploader({
  		browse_button : trigger,
  		url : '/api/loadimg',
  		filters : {
  			mime_types : [{
  				title : 'Image Files',
  				extensions : 'jpg,jpeg,png,gif'
  			}],
  			max_file_size : '5120kb'
  		},
  		flash_swf_url : '/guba/plugin/plupload-2.1.9/js/Moxie.swf',
  		silverlight_xap_url : '/guba/plugin/plupload-2.1.9/js/Moxie.xap'
  	});
  	uploader.init();
  	// 绑定事件
  	Object.keys(events).forEach(function(name){
  		uploader.bind(name, events[name]);
  	});
  	return uploader;
  };
  
  /**
   * 文件选择器
   * @param {Mixin} 	trigger 触发文件选择对话框的DOM元素，当点击该元素后便后弹出文件选择对话框。该值可以是DOM元素对象本身，也可以是该DOM元素的id
   */
  var UploadSelector = function(options){
  	$.extend(true, this, {
  		trigger : null,
  		events : {
  			onFilesSelect : noop
  		}
  	}, options || {});
  	this.selector = null;
  
  	this.create();
  };
  UploadSelector.prototype = {
  	create : function(){
  		var self = this,
  			events = this.events;
  		this.selector = new Uploader(this.trigger.get(0), {
  			FilesAdded : function(uploader, files){
  				events.onFilesSelect.call(self, files, uploader);
  				Event.triggerWith(self, 'ADD_UPLOAD_FILE', [files, uploader]);
  			}
  		});
  	}
  };
  
  /**
   * 文件传输器
   * @param {Object} 	events  实例对象的各种事件
   */
  var UploadTransporter = function(){
  	this.uploader = null;
  	this.selector = [];
  
  	this.create();
  };
  UploadTransporter.prototype = {
  	create : function(){
  		var self = this,
  			events = this.events,
  			uploader = this.uploader =
  			new Uploader(document.createElement('div'), {
  				BeforeUpload : function(uploader, file){
  					Event.trigger('BEFORE_UPLOAD', [file]);
  				},
  				UploadFile : function(uploader, file){
  					Event.trigger('UPLOAD_FILE', [file]);
  				},
  				UploadProgress : function(uploader, file){
  					Event.trigger('UPLOAD_PROGRESS', [file]);
  				},
  				FileUploaded : function(uploader, file, response){
  					Event.trigger('FILE_UPLOADED', [file, response]);
  				},
  				UploadComplete : function(uploader, files){
  					Event.trigger('UPLOAD_COMPLETE', [files]);
  					// 文件传输完成，把文件队列清下
  					self.selector.forEach(function(s){
  						s.splice(0, s.files.length);
  					});
  				}
  			});
  		// 监听全局事件
  		Event.on('ADD_UPLOAD_FILE', function(files, selector){
  			self.selector.push(selector);
  			files.forEach(function(file){
  				self.uploader.addFile(file);
  			});
  		});
  		Event.on('REMOVE_UPLOAD_FILE', function(item, file){
  			self.uploader.removeFile(file);
  		});
  	},
  	/**
  	 * 开始传输
  	 */
  	start : function(){
  		this.uploader.start();
  	},
  	/**
  	 * 停止传输
  	 */
  	stop : function(){
  		this.uploader.stop();
  	},
  	/**
  	 * 清空传输队列
  	 */
  	clear : function(){
  		var uploader = this.uploader;
  		uploader.splice(0, uploader.files.length);
  	}
  };
  
  var InsertImageList = function(options){
  	$.extend(true, this, {
  		parent : $('body'),
  		maxItems : 100
  	}, options || {});
  	this.element = null;
  	this.selector = null;
  	this.items = [];
  
  	this.create();
  };
  InsertImageList.prototype = {
  	create : function(){
  		var self = this,
  			parent = this.parent,
  			element,
  			selector,
  			eleAdd;
  		// 创建html结构
  		element = this.element = $([
  			'<ul class="ip_list">',
  			'	<li class="ip_add"><span>还可上传<i>' + (this.maxItems - this.items.length) + '</i>张</span></li>',
  			'</ul>'
  		].join('')).appendTo(parent);
  		// 创建文件选择器
  		eleAdd = element.find('.ip_add');
  		selector = this.selector = new UploadSelector({
  			trigger : eleAdd.find('span')
  		});
  
  		// 监听全局消息
  		Event.on('ADD_UPLOAD_FILE', function(files){
  			self.append(files);
  		});
  		Event.on('REMOVE_UPLOAD_FILE', function(item){
  			self.items = self.items.filter(function(it){
  				return it !== item;
  			});
  			eleAdd.find('i').text(self.maxItems - self.items.length);
  		});
  	},
  	append : function(files){
  		if (type(files) === 'array') {
  			files.forEach(function(file){
  				var self = this,
  					item = new InsertImageItem(),
  					length = this.getLength(),
  					eleAdd = this.element.find('.ip_add');
  				if (length < this.maxItems) {
  					item.create(file);
  					this.items.push(item);
  					if (length) {
  						item.after(this.items[length - 1].getElement());
  					} else {
  						item.before(eleAdd);
  					}
  					// 更新还可上传数量
  					eleAdd.find('i').text(this.maxItems - this.items.length);
  				}
  			}, this);
  		} else {
  			arguments.callee.call(this, [files]);
  		}
  	},
  	clear : function(){
  		this.items.forEach(function(item){
  			item.destroy();
  		});
  	},
  	getLength : function(){
  		return this.items.length;
  	}
  };
  
  var InsertImageItem = function(){
  	this.element = null;
  	this.file = null;
  	this.loading = null;
  };
  InsertImageItem.prototype = {
  	create : function(file){
  		if (!file) {
  			this.error('InsertImageItemPreview:create 创建失败.');
  			return;
  		}
  		this.file = file;
  		var self = this,
  			element = this.element,
  			events = this.events;
  		// 创建html结构
  		element = this.element = $([
  			'<li class="ip_preview">',
  			'	<span class="ip_line"></span><div class="ip_image">',
  			'		<span>' + file.name + '</span>',
  			'	</div>',
  			'	<span class="ip_remove"></span>',
  			'</li>'
  		].join(''));
  		// 预览图片
  		this.preview(file, function(src){
  			element.find('.ip_image')
  				.append('<img src="' + src + '" alt="' + file.name + '">')
  				.find('span')
  				.remove();
  		});
  		// 创建进度条
  		this.loading = new InsertImageLoading({
  			parent : element,
  			file : file
  		});
  		// 绑定事件
  		element.on('click', '.ip_remove', function(){
  			self.destroy();
  		});
  	},
  	destroy : function(){
  		this.element
  			.off()
  			.remove();
  		Event.trigger('REMOVE_UPLOAD_FILE', [this, this.file]);
  	},
  	before : function(eleRelative){
  		var element = this.element;
  		if (element) {
  			element.insertBefore(eleRelative);
  		}
  	},
  	after : function(eleRelative){
  		var element = this.element;
  		if (element) {
  			element.insertAfter(eleRelative);
  		}
  	},
  	getElement : function(){
  		return this.element;
  	},
  	preview : function(file, callback){
  		if(!file || !/image\//.test(file.type)) return; //确保文件是图片
  		var context = this || window;
  		if(file.type=='image/gif'){//gif使用FileReader进行预览,因为mOxie.Image只支持jpg和png
  			var fr = new mOxie.FileReader();
  			fr.onload = function(){
  				if (type(callback) === 'function') {
  					callback.call(context, fr.result);
  				}
  				fr.destroy();
  				fr = null;
  			}
  			fr.readAsDataURL(file.getSource());
  		}else{
  			var preloader = new mOxie.Image();
  			preloader.onload = function() {
  				var imgsrc = preloader.type=='image/jpeg' ? preloader.getAsDataURL('image/jpeg',80) : preloader.getAsDataURL(); //得到图片src,实质为一个base64编码的数据
  				if (type(callback) === 'function') {
  					callback.call(context, imgsrc); //callback传入的参数为预览图片的url
  				}
  				preloader.destroy();
  				preloader = null;
  			};
  			preloader.load(file.getSource());
  		}	
  	},
  	error : error
  };
  
  var InsertImageLoading = function(options){
  	$.extend(this, {
  		parent : $('body'),
  		file : null
  	}, options || {});
  	this.element = null;
  	this.handle = null;
  
  	this.init();
  };
  InsertImageLoading.prototype = {
  	init : function(){
  		var self = this,
  			element = this.element;
  		// 上传前触发创建html结构
  		Event.on('BEFORE_UPLOAD', function(file){
  			if (file === self.file) {
  				self.create();
  			}
  		});
  		// 上传进度条控制
  		Event.on('UPLOAD_PROGRESS', function(file){
  			if (file === self.file) {
  				self.update(file.percent);
  			}
  		});
  	},
  	create : function(){
  		var self = this,
  			element;
  		// 创建html结构
  		element = this.element = $([
  			'<div class="ip_loading">',
  			'	<div><i style="width:0%"></i></div>',
  			'</div>'
  		].join('')).appendTo(this.parent);
  		this.handle = element.find('i');
  	},
  	destroy : function(){},
  	update : function(percent){
  		var handle = this.handle;
  		if (handle) {
  			handle.width(percent + '%');
  		}
  	}
  };
  
  var InsertImagePopup = function(options){
  	$.extend(true, this, {
  		trigger : null,
  		parent : $('body')
  	}, options || {});
  	this.element = null;
  	this.list = null;
  	this.transporter = null;
  	this.selector = null;
  	this.res = [];
  
  	this.create();
  };
  InsertImagePopup.prototype = {
  	create : function(){
  		var self = this,
  			selector;
  		// 创建图片选择器
  		selector = this.selector = new UploadSelector({
  			trigger : this.trigger,
  			events : {
  				onFilesSelect : function(files){
  					// 创建html结构
  					self.createPopup();
  					self.show();
  					// 创建列表
  					self.createList();
  					// 创建图片传输器
  					self.createTransporter();
  				}
  			}
  		});
  		Event.on('FILE_UPLOADED', function(file, response){
  			self.res.push(response);
  		});
  		Event.on('UPLOAD_COMPLETE', function(files){
  			var res = self.res;
  			if (res.length) {
  				Event.trigger('INSERT_IMAGE', [res.map(function(r){
  					var url = '';
  					if (r && typeof r.response === 'string') {
  						try{
  							url = JSON.parse(r.response).data.url;
  						} catch(e){
  							url = '';
  						}
  					}
  					return url;
  				}), self]);
  				res = [];
  			}
  			self.clear();
  			self.hide();
  		});
  	},
  	createPopup : function(){
  		var self = this;
  		return this.element = $([
  			'<div class="image_popup hidden">',
  			'	<span class="ip_line"></span><div class="ip_cont">',
  			'		<div class="ip_hd">',
  			'			<h2>插入图片</h2>',
  			'			<span class="ip_close"></span>',
  			'		</div>',
  			'		<div class="ip_bd"></div>',
  			'		<div class="ip_fd">',
  			'			<div class="ip_warn">5M以上图片无法添加</div>',
  			'			<div class="ip_button">',
  			'				<span class="ip_insert">插入图片</span>',
  			'				<span class="ip_cancel">取消</span>',
  			'			</div>',
  			'		</div>',
  			'	</div>',
  			'</div>'
  		].join(''))
  			.appendTo(this.parent)
  			.on('click', '.ip_close, .ip_cancel', function(){
  				var list = self.list,
  					length = list.getLength();
  				if (!length || length && confirm('确定取消插入图片？')) {
  					self.clear();
  					self.hide();
  				}
  			})
  			.on('click', '.ip_insert', function(){
  				self.transporter.start();
  			});
  	},
  	createList : function(){
  		return this.list = new InsertImageList({
  			parent : this.element.find('.ip_bd')
  		});
  	},
  	createTransporter : function(){
  		return this.transporter = new UploadTransporter();
  	},
  	show : function(){
  		var element = this.element;
  		if (element) {
  			element.removeClass('hidden').addClass('in_anim');
  		}
  	},
  	hide : function(){
  		var element = this.element;
  		if (element) {
  			element.removeClass('in_anim').addClass('out_anim');
  			setTimeout(function() {
  				element.removeClass('out_anim').addClass('hidden');
  			}, 180);
  		}
  	},
  	clear : function(){
  		this.transporter.clear();
  		this.list.clear();
  		this.res = [];
  	}
  };
  
  module.exports = InsertImagePopup;

});


var type = function(param){
    var ret;
    if (param == null) {
        ret = String(param);
    } else {
        ret = Object.prototype.toString.call(param).slice(8, -1).toLowerCase();
    }
    return ret;
};

var FacePopup = require('modules/FacePopup/FacePopup');
var InsertImagePopup = require('modules/InsertImagePopup/InsertImagePopup');

var Event = (function(){
	var list = {},
		Event = {};
	// 在指定上下文中触发事件
	Event.triggerWith = function(context, event, args, mode){
		var item = list[event];
		if (type(item) !== 'object') {
			item = list[event] = {
				listeners : [],
				triggers : []
			};
		}
		// 先触发所有的事件
		item.listeners.forEach(function(handle){
			handle.apply(context || Event, args || []);
		});
		// 保存当前这次的触发操作用于memory的时候
		item.triggers.push({
			context : context,
			args : args,
			mode : mode
		});
		return context;
	};
	// 在Event上下文中触发事件
	Event.trigger = function(event, args, mode){
		return Event.triggerWith(null, event, args, mode);
	};
	// 监听事件
	Event.on = function(event, handle){
		if (type(handle) !== 'function') {
			return;
		}
		if (type(list[event]) !== 'object') {
			list[event] = {
				listeners : [],
				triggers : []
			};
		}
		var item = list[event];
		// 保存在事件列表中
		item.listeners.push(handle);
		// 触发所有的memory的trigger
		item.triggers.forEach(function(trigger){
			if (trigger.mode === 'memory') {
				handle.apply(trigger.context, trigger.args);
			}
		});
		return this;
	};
	// 取消绑定
	Event.off = function(event, handle){
		if (type(event) === 'undefined') {			// 清空所有事件的所有绑定
			Object.keys(list).forEach(function(item){
				item.listeners = [];
			});
		} else {
			var item = list[event];
			if (type(item) === 'object') {
				if (type(handle) === 'undefined') {			// 清空当前事件的所有绑定
					item.listeners = [];
				} else {					// 取消指定事件的绑定
					item.listeners = item.listeners.filter(function(fn){
						return fn !== handle;
					});
				}
			}
		}
		return this;
	};
	// 只绑定一次
	Event.once = function(event, handle){
		if (type(handle) !== 'function') {
			return;
		}
		Event.on(event, function(){
			handle.apply(this, arguments);
			Event.off(event, arguments.callee);
		});
		return this;
	},
	// 删除指定事件
	Event.remove = function(event){
		delete list[event];
		return this;
	};
	return Event;
})();

var error = function(){
	if (console && typeof console.error === 'function') {
		console.error.apply(console, arguments);
	}
};

var parallel = function(tasks, callback, context){
    context = context || window;
    var results = [],
        count = 0,
        done = function(err, index, result){
            if (err) {
                callback.call(context, err);
            } else {
                results.push([index, result]);
                if (++count >= tasks.length) {
                    callback.call(context, null, results.sort(function(a, b){
                        return a[0] - b[0];
                    }).map(function(item){
                        return item[1];
                    }));
                }
            }
        };
    tasks.forEach(function(task, index){
        try{
            task.call(this, function(err, result){
                done(err, index, result);;
            });
        } catch(e){
            done(e, index);
        }
    }, context);
};

var noop = function(){};

var Editor = function(options){
	$.extend(true, this, {
		element : null,
		events : {}
	}, options || {});
	this.editor = null;
	this.popupFace = null;
	this.popupInsert = null;

	this.init();
};
Editor.prototype = {
	init : function(){
		var self = this,
			element = this.element;
		// 并行创建组件
		this.parallel([
			// 创建富文本框
			function(callback){
				KindEditor.ready(function(k){
					var editor = self.editor = k.create(element.find('textarea').get(0), {
						width : '100%',
						height : '100px',
						minHeight : 100,
						items : ['link'],
						resizeType : 1,
						themeType : 'comment',
						cssData : 'body{font: 14px/1.75 微软雅黑}'
					});
					editor.toolbar.hide();

					element.find('.e_toolbar').append('<span class="e_link"><i class="ke-icon-link ke-toolbar-icon-url"></i>超链接</span>');

					callback();
				});
			},
			// 创建表情弹出层
			function(callback){
				this.popupFace = new FacePopup();
				callback();
			},
			// 创建图片上传弹出层
			function(callback){
				this.popupInsert = new InsertImagePopup({
					trigger : element.find('.e_image')
				});
				callback();
			}
		], function(error, result){
			if (error) {
				this.error(error);
				return;
			}
			this.create(result);
		});
	},
	create : function(){
		var self = this,
			element = this.element,
			editor = this.editor;
		// 事件监听
		element.on('click', '.e_face', function(event){
			var $this = $(this),
				width = $this.outerWidth(),
				height = $this.outerHeight(),
				offset = $this.offset();
			Event.trigger('OPEN_FACEPOPUP', [
				offset.left/* + width*/,
				offset.top + height,
				{
					y : height
				}
			]);

			event.stopPropagation();
		}).on('click', '.e_link', function(){
			$('span[data-name="link"]').trigger('click');
		});
		// 向编辑器中插入表情
		Event.on('INSERT_FACE', function(url){
			editor.insertHtml([
				'<img src="' + url + '" />'
			].join(''));
		});
		// 向编辑器中插入图片
		Event.on('INSERT_IMAGE', function(urls){
			editor.insertHtml(urls.reduce(function(prev, url){
				return [prev,
					'<img src="' + url + '" />'
				].join('');
			}, ''));
		});
		// 将编辑器显示到视口中心
		Event.on('SCROLL_NEW_TOPIC_EDITOR_TO_VIEWPORT_CENTER', function(){
			var top = element.offset().top,
				height = element.outerHeight(),
				wndHeight = $(window).height(),
				scrollTop = top - (wndHeight - height) / 2;
			$('html, body').animate({
				scrollTop : scrollTop
			});
			editor.focus();
		});
	},
	parallel : function(tasks, callback){
		return parallel(tasks, callback, this);
	},
	error : error
};

$('.editor').each(function(){
	new Editor({
		element : $(this)
	});
});
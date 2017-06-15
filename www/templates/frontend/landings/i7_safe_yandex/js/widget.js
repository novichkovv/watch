(function() {
  var $, CSS, CalcForm, Chat, ConnectionWrapper, Cookie, EH, GUI, JS, JSTE, Observable, Observer, Slider, VVCWidget, WidgetState, buildQueryString, escapeHtml, getCaretPosition, setCaretPosition, settings, timestamp, trim,
    __indexOf = [].indexOf || function(item) { for (var i = 0, l = this.length; i < l; i++) { if (i in this && this[i] === item) return i; } return -1; },
    _this = this,
    __hasProp = {}.hasOwnProperty,
    __extends = function(child, parent) { for (var key in parent) { if (__hasProp.call(parent, key)) child[key] = parent[key]; } function ctor() { this.constructor = child; } ctor.prototype = parent.prototype; child.prototype = new ctor(); child.__super__ = parent.prototype; return child; };


  // parseUri 1.2.2
  // (c) Steven Levithan <stevenlevithan.com>
  // MIT License
  function parseUri (str) {
      var	o   = parseUri.options,
          m   = o.parser[o.strictMode ? "strict" : "loose"].exec(str),
          uri = {},
          i   = 14;

      while (i--) uri[o.key[i]] = m[i] || "";

      uri[o.q.name] = {};
      uri[o.key[12]].replace(o.q.parser, function ($0, $1, $2) {
          if ($1) uri[o.q.name][$1] = $2;
      });

      return uri;
  };

  parseUri.options = {
      strictMode: false,
      key: ["source","protocol","authority","userInfo","user","password","host","port","relative","path","directory","file","query","anchor"],
      q:   {
          name:   "queryKey",
          parser: /(?:^|&)([^&=]*)=?([^&]*)/g
      },
      parser: {
          strict: /^(?:([^:\/?#]+):)?(?:\/\/((?:(([^:@]*)(?::([^:@]*))?)?@)?([^:\/?#]*)(?::(\d*))?))?((((?:[^?#\/]*\/)*)([^?#]*))(?:\?([^#]*))?(?:#(.*))?)/,
          loose:  /^(?:(?![^:@]+:[^:@\/]*@)([^:\/?#.]+):)?(?:\/\/)?((?:(([^:@]*)(?::([^:@]*))?)?@)?([^:\/?#]*)(?::(\d*))?)(((\/(?:[^?#](?![^?#\/]*\.[^?#\/.]+(?:[?#]|$)))*\/?)?([^?#\/]*))(?:\?([^#]*))?(?:#(.*))?)/
      }
  };
  // end of parseUri

  settings = (function() {
    function findServerName() {
        var scriptTags = document.getElementsByTagName('SCRIPT');
        for(var i = 0; i < scriptTags.length; i++) {
            var matches = /\/js\/widget(1251)?\.js(\?ver\=[0-9.]+)?$/.exec(scriptTags[i].src);
            if(null !== matches)
                break;
        }

        if(null === matches)
            return false;

        var uri =  parseUri(scriptTags[i].src);
        return {
            host: uri.host
            , protocol: uri.protocol
            , http_host: uri.protocol + '://' + uri.host + (('' == uri.port) ? '' : (':' + uri.port))
        };
    }

    function getSettings() {
      var scriptSrc = findServerName();
      if(false === scriptSrc)
        throw new Error('Script source not found');
      var IE = document.all && !window.opera;
      return {
        domain: scriptSrc.host,
        ioPort: 5000,
        brand: 'vk24',
        socketIOURI: scriptSrc.protocol + '://' + scriptSrc.host + "/socket.io/socket.io.js",
        connectURI: scriptSrc.protocol + '://' + scriptSrc.host,
        httpHost: scriptSrc.http_host,
        debug: false && !IE
      };
    };

    return getSettings();
  })();

  $ = function(id) {
    return document.getElementById(id);
  };

  timestamp = function() {
    return (new Date).getTime();
  };

  trim = function(input) {
    if (typeof input !== 'string') {
      return;
    }
    return input.replace(/^\s+/g, '').replace(/\s+$/g, '');
  };

  buildQueryString = function(data) {
    var k, v;
    return ((function() {
      var _results;
      _results = [];
      for (k in data) {
        v = data[k];
        _results.push(encodeURIComponent(k) + '=' + encodeURIComponent(v));
      }
      return _results;
    })()).join('&');
  };

  escapeHtml = (function() {
    var symbols;
    symbols = [
      {
        escape: /&/g,
        equivalent: "&amp;"
      }, {
        escape: /</g,
        equivalent: "&lt;"
      }, {
        escape: />/g,
        equivalent: "&gt;"
      }, {
        escape: /"/g,
        equivalent: "&quot;"
      }, {
        escape: /'/g,
        equivalent: "&#039;"
      }
    ];
    return function(input) {
      var symbol, _i, _len;
      if (typeof input !== 'string') {
        return;
      }
      for (_i = 0, _len = symbols.length; _i < _len; _i++) {
        symbol = symbols[_i];
        input = input.replace(symbol.escape, symbol.equivalent);
      }
      return input;
    };
  })();

  getCaretPosition = function(e) {
    var range;
    if (document.selection) {
      range = document.selection.createRange();
      range.moveStart("textedit", -1);
      return range.text.length;
    } else {
      return e.selectionStart;
    }
  };

  setCaretPosition = function(e, pos) {
    var range;
    if (e.setSelectionRange) {
      e.focus();
      e.setSelectionRange(pos, pos);
    } else if (e.createTextRange) {
      range = e.createTextRange();
      range.collapse(true);
      range.moveEnd("character", pos);
      range.moveStart("character", pos);
      range.select();
    }
  };

  CSS = (function() {
    var added, indexOf;

    function CSS() {}

    added = [];

    indexOf = function(value) {
      var e, i, _i, _len;
      for (i = _i = 0, _len = this.length; _i < _len; i = ++_i) {
        e = this[i];
        if (e === value) {
          return i;
        }
      }
      return -1;
    };

    CSS.add = function(uri) {
      var link;
      if (__indexOf.call(added, uri) >= 0) {
        return;
      }
      added.push(uri);
      link = document.createElement('link');
      link.type = 'text/css';
      link.rel = 'stylesheet';
      link.href = uri;
      document.getElementsByTagName('head')[0].appendChild(link);
    };

    CSS.remove = function(uri) {
      var index, link, links, _i, _len;
      links = document.getElementsByTagName('LINK');
      for (_i = 0, _len = links.length; _i < _len; _i++) {
        link = links[_i];
        if (link.src === uri) {
          link.parentNode.removeChild(link);
        }
      }
      index = indexOf.call(added, uri);
      if (index > -1) {
        added.splice(index, 1);
      }
    };

    CSS.addText = function(text) {
      var style;
      style = document.createElement('style');
      style.type = 'text/css';
      style.innerHTML = text;
      document.getElementsByTagName('head')[0].appendChild(style);
    };

    return CSS;

  })();

  JS = (function() {
    var added, indexOf;

    function JS() {}

    added = [];

    indexOf = function(value) {
      var e, i, _i, _len;
      for (i = _i = 0, _len = this.length; _i < _len; i = ++_i) {
        e = this[i];
        if (e === value) {
          return i;
        }
      }
      return -1;
    };

    JS.add = function(uri) {
      var script;
      if (__indexOf.call(added, uri) >= 0) {
        return;
      }
      added.push(uri);

      if(typeof require === "function" && typeof define === "function") {
          require.config({paths: {"socketio": uri}});
          requirejs(['socketio'], function (io) {
              window.io = io;
          });
      } else {
          script = document.createElement('SCRIPT');
          script.type = 'text/javascript';
          script.charset = 'utf-8';
          script.src = uri;
          document.getElementsByTagName('head')[0].appendChild(script);
      }
    };

    JS.remove = function(uri) {
      var index, script, scripts, _i, _len;
      scripts = document.getElementsByTagName('SCRIPT');
      for (_i = 0, _len = scripts.length; _i < _len; _i++) {
        script = scripts[_i];
        if (script && script.src === uri) {
          script.parentNode.removeChild(script);
        }
      }
      index = indexOf.call(added, uri);
      if (index > -1) {
        added.splice(index, 1);
      }
    };

    return JS;

  })();

  EH = (function() {

    function EH() {}

    $ = function(id) {
      return document.getElementById(id);
    };

    if (document.addEventListener) {
      (function() {
        EH.add = function(element, eventType, handler) {
          if (typeof element === 'string') {
            element = $(element);
          }
          element.addEventListener(eventType, handler, false);
        };
        EH.remove = function(element, eventType, handler) {
          if (typeof element === 'string') {
            element = $(element);
          }
          element.removeEventListener(eventType, handler, false);
        };
      })();
    } else if (document.attachEvent) {
      (function() {
        var allHandlers, counter, find, onUnloadHandlerRegistered, removeAllHandlers, uid;
        counter = 0;
        allHandlers = {};
        onUnloadHandlerRegistered = false;
        uid = function() {
          return "h" + counter++;
        };
        find = function(element, eventType, handler) {
          var h, handlerId, handlers, i, _i, _ref;
          handlers = element._handlers;
          if (!handlers) {
            return -1;
          }
          for (i = _i = _ref = handlers.length - 1; _ref <= 0 ? _i <= 0 : _i >= 0; i = _ref <= 0 ? ++_i : --_i) {
            handlerId = handlers[i];
            h = allHandlers[handlerId];
            if (h.eventType === eventType && h.handler === handler) {
              return i;
            }
          }
          return -1;
        };
        removeAllHandlers = function() {
          var h, id;
          for (id in allHandlers) {
            h = allHandlers[id];
            h.element.detachEvent("on" + h.eventType, h.wrappedHandler);
            delete allHandlers[id];
          }
        };
        EH.add = function(element, eventType, handler) {
          var h, id, wrappedHandler;
          if (typeof element === 'string') {
            element = $(element);
          }
          if (find(element, eventType, handler) !== -1) {
            return;
          }
          wrappedHandler = function(e) {
            var event;
            e = e || window.event;
            event = {
              type: e.type,
              target: e.srcElement,
              currentTarget: element,
              relatedTarget: e.fromElement ? e.fromElement : e.toElement,
              eventPhase: e.srcElement === element ? 2 : 3,
              clientX: e.clientX,
              clientY: e.clientY,
              screenX: e.screenX,
              screenY: e.screenY,
              altKey: e.altKey,
              ctrlKey: e.ctrlKey,
              shiftKey: e.shiftKey,
              charCode: e.keyCode,
              stopPropagation: function() {
                e.cancelBubble = true;
              },
              preventDefault: function() {
                e.returnValue = false;
              }
            };
            if (Function.prototype.call) {
              handler.call(element, event);
            } else {
              element._currentHandler = handler;
              element._currentHandler(event);
              element._currentHandler = void 0;
            }
          };
          element.attachEvent("on" + eventType, wrappedHandler);
          h = {
            element: element,
            eventType: eventType,
            handler: handler,
            wrappedHandler: wrappedHandler
          };
          id = uid();
          allHandlers[id] = h;
          if (!element._handlers) {
            element._handlers = [];
          }
          element._handlers.push(id);
          if (!onUnloadHandlerRegistered) {
            (function() {
              var d, w;
              onUnloadHandlerRegistered = true;
              d = element.document || element;
              w = d.parentWindow;
              w.attachEvent("onunload", removeAllHandlers);
            })();
          }
        };
        EH.remove = function(element, eventType, handler) {
          var h, handlerId, i;
          if (typeof element === 'string') {
            element = $(element);
          }
          i = find(element, eventType, handler);
          if (i === -1) {
            return;
          }
          handlerId = element._handlers[i];
          h = allHandlers[handlerId];
          element.detachEvent("on" + eventType, h.wrappedHandler);
          element._handlers.splice(i, 1);
          delete allHandlers[handlerId];
        };
      })();
    }

    return EH;

  })();

  GUI = (function() {
    var add, added, element, hidingLayer, remove;

    function GUI() {}

    added = false;

    element = (function() {
      return document.createElement('div');
    })();

    hidingLayer = (function() {
      var e;
      e = document.createElement('div');
      e.className = 'vvc-widget-hiding-layer';
      return e;
    })();

    add = function() {
      document.body.appendChild(hidingLayer);
      document.body.appendChild(element);
      added = true;
    };

    remove = function() {
      document.body.removeChild(element);
      document.body.removeChild(hidingLayer);
      added = false;
    };

    GUI.addCreditOfferWindow = function(removeFromBasket) {
      var removeItem;
      if (added) {
        return;
      }
      JSTE.to(element, VVC.layout.creditOffer, settings);
      removeItem = function() {
        switch (typeof removeFromBasket) {
          case 'function':
            remove();
            removeFromBasket();
            break;
          case 'string':
            window.location = removeFromBasket;
            break;
          default:
            remove();
        }
      };
      add();
      EH.add('vvc_close', 'click', remove);
      EH.add('vvc_cancel', 'click', remove);
      EH.add('vvc_remove', 'click', removeItem);
    };

    GUI.addCreditInfoWindow = function(basket, proceed, item) {
      var goToBasket, proceedBuy;
      if (added) {
        return;
      }
      (function(basket, proceed, item) {
        if (arguments.length > 1) {
          if (typeof proceed === 'object' && item === void 0) {
            item = proceed;
          }
          if (item && typeof item === 'object' && 'name' in item && 'amount' in item) {
            JSTE.to(element, VVC.layout.creditInfoWithItem, {
              domain: settings.domain,
              httpHost: settings.httpHost,
              item: item
            });
            return;
          }
        }
        JSTE.to(element, VVC.layout.creditInfo, settings);
      })(basket, proceed, item);
      goToBasket = function() {
        switch (typeof basket) {
          case 'function':
            remove();
            basket();
            break;
          case 'string':
            window.location = basket;
            break;
          default:
            remove();
        }
      };
      proceedBuy = function() {
        switch (typeof proceed) {
          case 'function':
            remove();
            proceed();
            break;
          case 'string':
            window.location = proceed;
            break;
          default:
            remove();
        }
      };
      add();
      EH.add('vvc_close', 'click', remove);
      EH.add('vvc_proceed', 'click', proceedBuy);
      EH.add('vvc_basket', 'click', goToBasket);
    };

    return GUI;

  })();

  WidgetState = (function() {

    function WidgetState() {}

    WidgetState.OPENED = 'opened';

    WidgetState.CLOSED = 'closed';

    return WidgetState;

  })();

  Observer = (function() {

    function Observer() {}

    Observer.prototype.handleEvent = function(what) {};

    return Observer;

  })();

  Observable = (function() {

    function Observable() {
      this.observers = [];
    }

    Observable.prototype.addObserver = function(observer) {
      if (__indexOf.call(this.observers, observer) < 0) {
        this.observers.push(observer);
      }
    };

    Observable.prototype.notifyObservers = function(what) {
      var observer, _i, _len, _ref;
      _ref = this.observers;
      for (_i = 0, _len = _ref.length; _i < _len; _i++) {
        observer = _ref[_i];
        observer.handleEvent(what);
      }
    };

    return Observable;

  })();

  Chat = (function(_super) {

    __extends(Chat, _super);

    function Chat(parent) {
      var _this = this;
      this.parent = parent;
      this.sendMessage = function(e) {
        return Chat.prototype.sendMessage.apply(_this, arguments);
      };
      Chat.__super__.constructor.apply(this, arguments);
      this.lastMessages = void 0;
    }

    Chat.prototype.show = function() {
      JSTE.to(this.parent, VVC.layout.chat, settings);
      if (this.lastMessages) {
        this.showMessages(this.lastMessages);
      }
      $('vvc_chat_input').focus();
    };

    Chat.prototype.handleEvent = function(what) {
      this.onMessage(what);
    };

    Chat.prototype.onMessage = function(m) {
      switch (m.act) {
        case 'chat':
          this.lastMessages = m;
          this.showMessages(m);
      }
    };

    Chat.prototype.sendMessage = function(e) {
      var input, message;
      if (e ? !e.ctrlKey || e.keyCode !== 13 : void 0) {
        return;
      }
      input = $('vvc_chat_input');
      message = trim(escapeHtml(input.value));
      if (message) {
        VVC.send({
          act: 'chat',
          text: message
        });
      }
      input.value = '';
    };

    Chat.prototype.showMessages = function(m) {
      var output, s, _i, _len, _ref;
      output = $('vvc_chat_output');
      if (!output) {
        return;
      }
      s = '';
      _ref = m.data;
      for (_i = 0, _len = _ref.length; _i < _len; _i++) {
        m = _ref[_i];
        if (m.sid) {
          s += "<div class=\"vvc-widget-answer\"><b>" + m.sid + ":</b> " + m.text + "</div>";
        } else {
          s += "<div class=\"vvc-widget-question\"><b>Вопрос:</b> " + m.text + "</div>";
        }
      }
      output.innerHTML = s;
      output.scrollTop = output.scrollHeight - output.offsetHeight + 10;
    };

    return Chat;

  })(Observer);

  ConnectionWrapper = (function(_super) {

    __extends(ConnectionWrapper, _super);

    function ConnectionWrapper() {
      var _this = this;
      this.messageHandler = function(m) {
        return ConnectionWrapper.prototype.messageHandler.apply(_this, arguments);
      };
      this.send = function(m) {
        return ConnectionWrapper.prototype.send.apply(_this, arguments);
      };
      this.waitLoadingHandler = function() {
        return ConnectionWrapper.prototype.waitLoadingHandler.apply(_this, arguments);
      };
      this.disconnectHandler = function() {
        return ConnectionWrapper.prototype.disconnectHandler.apply(_this, arguments);
      };
      this.connectHandler = function() {
        return ConnectionWrapper.prototype.connectHandler.apply(_this, arguments);
      };
      this.connect = function() {
        return ConnectionWrapper.prototype.connect.apply(_this, arguments);
      };
      this.loadSocketIO = function() {
        return ConnectionWrapper.prototype.loadSocketIO.apply(_this, arguments);
      };
      ConnectionWrapper.__super__.constructor.apply(this, arguments);
      this.loaded = false;
      this.connected = false;
      this.callBack = void 0;
      this.timeoutID = void 0;
      this.duration = 100;
      this.waitDuration = 5000;
    }

    ConnectionWrapper.prototype.init = function(callBack) {
      this.callBack = callBack;
      if (this.connected) {
        if (typeof this.callBack === "function") {
          this.callBack();
        }
        return;
      }
      if (!this.loaded) {
        this.loadSocketIO();
        setTimeout(this.connect, this.duration);
      }
      this.notifyObservers({
        act: 'connection'
      });
    };

    ConnectionWrapper.prototype.loadSocketIO = function() {
      JS.remove(settings.socketIOURI);
      JS.add(settings.socketIOURI);
      this.timeoutID = setTimeout(this.waitLoadingHandler, this.waitDuration);
    };

    ConnectionWrapper.prototype.connect = function() {
      if (!('io' in window)) {
        setTimeout(this.connect, this.duration);
        return;
      }
      this.loaded = true;
      this.socket = io.connect(settings.connectURI);
      
      this.socket.on('connect', this.connectHandler);
      this.socket.on('disconnect', this.disconnectHandler);
      clearTimeout(this.timeoutID);
    };

    ConnectionWrapper.prototype.connectHandler = function() {
      this.connected = true;
      this.notifyObservers({
        act: 'connect'
      });
      this.socket.on('message', this.messageHandler);
      if (typeof this.callBack === "function") {
        this.callBack();
      }
    };

    ConnectionWrapper.prototype.disconnectHandler = function() {
      this.connected = false;
      this.notifyObservers({
        act: 'connection'
      });
    };

    ConnectionWrapper.prototype.waitLoadingHandler = function() {
      this.notifyObservers({
        act: 'reload'
      });
      clearTimeout(this.timeoutID);
    };

    ConnectionWrapper.prototype.send = function(m) {
      var _ref;
      if (settings.debug) {
        console.log('send:', m);
      }
      if ((_ref = this.socket) != null) {
        _ref.json.send(m);
      }
    };

    ConnectionWrapper.prototype.messageHandler = function(m) {
      if (settings.debug) {
        console.log('receive:', m);
      }
      this.notifyObservers(m);
    };

    return ConnectionWrapper;

  })(Observable);

  VVCWidget = (function(_super) {
    var checkedPhones, clickHandler, cookieLifetime, createHidingLayer, createMainPane, createdOrders, currentPhone, evalJSON, parseData, parseJSON, state, toDigStr, toMaskedPhone, widgetStyle;

    __extends(VVCWidget, _super);

    widgetStyle = {
      version: '1.0.3'
    };

    cookieLifetime = 5 * 60 * 1000;

    state = void 0;

    currentPhone = void 0;

    checkedPhones = {};

    createdOrders = {};

    function VVCWidget() {
      var _this = this;
      this.initButton = function(e) {
        return VVCWidget.prototype.initButton.apply(_this, arguments);
      };
      this.initButtons = function() {
        return VVCWidget.prototype.initButtons.apply(_this, arguments);
      };
      this.initInfoElement = function(e) {
        return VVCWidget.prototype.initInfoElement.apply(_this, arguments);
      };
      this.initInfoElements = function() {
        return VVCWidget.prototype.initInfoElements.apply(_this, arguments);
      };
      this.changeSurname = function() {
        return VVCWidget.prototype.changeSurname.apply(_this, arguments);
      };
      this.changeName = function() {
        return VVCWidget.prototype.changeName.apply(_this, arguments);
      };
      this.selectRegion = function() {
        return VVCWidget.prototype.selectRegion.apply(_this, arguments);
      };
      this.isPhoneEntered = function() {
        return VVCWidget.prototype.isPhoneEntered.apply(_this, arguments);
      };
      this.remove = function() {
        return VVCWidget.prototype.remove.apply(_this, arguments);
      };
      this.add = function() {
        return VVCWidget.prototype.add.apply(_this, arguments);
      };
      this.onBuy = function(goods, delay) {
        if (delay == null) {
          delay = 0;
        }
        return VVCWidget.prototype.onBuy.apply(_this, arguments);
      };
      this.onCheckPromo = function() {
        return VVCWidget.prototype.onCheckPromo.apply(_this, arguments);
      };
      this.showPromoAction = function() {
        return VVCWidget.prototype.showPromoAction.apply(_this, arguments);
      };
      this.onStartFormLight = function(showedPromoAction) {
        return VVCWidget.prototype.onStartFormLight.apply(_this, arguments);
      };
      this.shopInfo = function() {
        return VVCWidget.prototype.shopInfo.apply(_this, arguments);
      };
      this.errRepeat = function() {
        return VVCWidget.prototype.errRepeat.apply(_this, arguments);
      };
      if (!window.VVC_SETTINGS) {
        window.VVC_SETTINGS = {};
      }
      CSS.add("" + settings.httpHost + "/widget/normalize.css");
      CSS.add("" + settings.httpHost + "/widget/light.css?" + (buildQueryString(widgetStyle)));
      this.gui = GUI;
      this.buttonParams = {};
      this.shop_comm = 0;
      this.aid = '';
      this.topMenuList = [1, 0, 0];
      this.styleList = ['black', 'blue', 'green', 'navy', 'orange', 'red', 'violet'];
      this.stylesCount = ('vk24' == settings.brand) ? 2 : 5;
      this.hidingLayer = createHidingLayer();
      this.mainPane = createMainPane();
      this.connectionWrapper = new ConnectionWrapper;
      this.connectionWrapper.addObserver(this);
      this.connectionWrapper.addObserver(this.chat = new Chat(this.mainPane));
      this.initButtons();
      this.initInfoElements();
    }

    VVCWidget.prototype.handleEvent = function(what) {
      this.onMessage(what);
    };

    VVCWidget.prototype.send = function(m) {
      this.connectionWrapper.send(m);
    };

    VVCWidget.prototype.onMessage = function(m) {
      var e, j, selected, _base, _base1;
      switch (m.act) {
        case 'connection':
          JSTE.to(this.mainPane, VVC.layout.waitWindow, settings);
          break;
        case 'reload':
          JSTE.to(this.mainPane, VVC.layout.errWindow, settings);
          setTimeout(this.errRepeat, 1000);
          break;
        case 'sid':
          //console.log(m.sid);
          this.sid = m.sid;
          break;
        case 'bank':
          this.saveCreatedOrder(m);
          this.finalPage(m);
          break;
        case 'pwd_error':
          alert('Пароль неверный');
          this.onCheckPhone('user');
          break;
        case 'auth_ok':
          this.aid = m.aid;
          this.createOrder();
          break;
        case 'check_phone':
          checkedPhones[currentPhone] = m.user;
          this.onCheckPhone(m.user, m.sms);
          break;
        case 'crush':
          JSTE.to(this.mainPane, VVC.layout.crush, settings);
          break;
        case 'start':
          this.regions = {};
          if (m.city) {
            selected = true;
            for (j in m.city) {
              this.regions[j] = [m.city[j], selected, j];
              selected = false;
            }
            this.regions[++j] = ['Другой', false, '0'];
          }
          if (m.title) {
            this.shop_title = m.title;
          }
          if (m.sale_id) {
            this.sale_id = m.sale_id;
          }
          this.shop_comm = m.comm / 100;
          if (isNaN(this.shop_comm)) {
            this.shop_comm = 0;
          }
          this.onStartFormLight();
          break;
        case 'auth':
          if (m.aid) {
            this.aid = m.aid;
            this.user = m.name;
          }
          this.onStartFormLight();
          break;
        case 'cancel_by_bank':
          if (typeof (_base = window.VVC_SETTINGS).response === "function") {
            _base.response({
              user_id: m.shop_uid,
              order_id: m.num,
              vvc_status: "cancel"
            });
          }
          break;
        case 'approved_by_shop':
          if (m.sid === this.sid) {
            this.send({
              aid: this.aid,
              act: 'bank'
            });
          }
          break;
        case 'approved_by_bank':
          if (typeof (_base1 = window.VVC_SETTINGS).response === "function") {
            _base1.response({
              user_id: m.shop_uid,
              order_id: m.num,
              vvv_order_id: m.vvc_id,
              vvc_status: 'success',
              vvc_bank: m.title
            });
          }
          break;
        case 'promo':
          this.promo_title = m.title;
          this.onStartFormLight();
          break;
        case 'promo_check':
          if (m.result > 0) {
            alert('Ваш промо-код успешно зарегистрирован. Желаем приятной покупки со скидкой!');
            this.onStartFormLight(true);
          } else {
            alert('К сожалению, такой промо-код не найден. Пожалуйста, проверьте правильность введенной информации');
            e = $('vvc_promo_code');
            if (e) {
              e.focus();
              e.select();
            }
          }
      }
    };

    VVCWidget.prototype.browserError = function() {
      JSTE.to(this.mainPane, VVC.layout.browserError, settings);
    };

    VVCWidget.prototype.errRepeat = function() {
      var e, s;
      e = $('VVC_RECONNECT_SECONDS');
      if (!e) {
        return;
      }
      s = parseInt(e.innerHTML);
      s--;
      if (!isNaN(s)) {
        switch (s) {
          case 0:
            this.connectionWrapper.init(this.shopInfo);
            return;
          case 1:
            e.innerHTML = '1 секунду';
            break;
          case 2:
          case 3:
          case 4:
            e.innerHTML = s + ' секунды';
            break;
          default:
            e.innerHTML = s + ' секунд';
        }
        setTimeout(this.errRepeat, 1000);
      }
    };

    VVCWidget.prototype.shopInfo = function() {
      var m;
      m = {
        act: 'shop',
        aid: this.aid,
        shop_id: VVC_SETTINGS.shop_id
      };
      if (VVC_SETTINGS.vvc_order_id && VVC_SETTINGS.hash) {
        m.vvc_order_id = VVC_SETTINGS.vvc_order_id;
        m.hash = VVC_SETTINGS.hash;
      }
      this.send(m);
    };

    VVCWidget.prototype.onStartFormLight = function(showedPromoAction) {
      if (this.sale_id && this.promo_title === void 0) {
        this.send({
          act: 'promo_info'
        });
        return;
      }
      if (state === WidgetState.CLOSED) {
        return;
      }
      if (this.sale_id && this.promo_title && showedPromoAction === void 0) {
        this.showPromoAction();
        return;
      }
      this.goodsList();
    };

    VVCWidget.prototype.showPromoAction = function() {
      var promoInfoURL;
      promoInfoURL = "" + settings/*.domain*/.httpHost + "/sales/" + this.sale_id;
      JSTE.to(this.mainPane, VVC.layout.promoAction, {
        domain: settings.domain,
        promoInfoURL: promoInfoURL,
        title: this.promo_title
      });
      $('vvc_promo_code').focus();
    };

    VVCWidget.prototype.onCheckPromo = function() {
      var code, e;
      e = $('vvc_promo_code');
      code = trim(e.value);
      if (code) {
        this.send({
          act: 'promo_check',
          code: code
        });
      } else {
        e.focus();
        e.value = '    ';
        e.select();
      }
    };

    VVCWidget.prototype.goodsList = function() {
      this.topMenuList = [1, 0, 0];
      JSTE.to(this.mainPane, VVC.layout.basePane, {
        commText: this.shop_comm !== 0 ? ' с учётом комиссии магазина ' + this.shop_comm + '% ' : '',
        comm: this.shop_comm,
        domain: settings.domain,
        httpHost: settings.httpHost,
        g: this.goods,
        ml: document.all && !window.opera && document.querySelector && !document.addEventListener ? 10 : 19
      });
      this.addMaskedInput();
    };

    VVCWidget.prototype.addMaskedInput = function() {
      /*
      if (!(document.all && !window.opera && document.querySelector && !document.addEventListener)) {
        MaskedInput({
          elm: $('vvc_phone'),
          allowed: '0123456789',
          format: '(___) - ___ - __ - __',
          separator: '/:-. ()'
        });
      }
      */
      $('vvc_phone').focus();
      //setCaretPosition($('vvc_phone'), 1);
      this.isPhoneEntered();
    };

    VVCWidget.prototype.showCalcForm = function() {
      var item, sum, _i, _len, _ref;
      this.topMenuList = [0, 1, 0];
      sum = 0;
      _ref = this.goods;
      for (_i = 0, _len = _ref.length; _i < _len; _i++) {
        item = _ref[_i];
        sum += item.amount * item.count;
      }
      sum = sum * (1 + this.shop_comm * 0.01);
      if (!this.calcForm) {
        this.calcForm = new CalcForm(this.mainPane, {
          sum: sum,
          months: 12
        });
      }
      this.calcForm.init();
      this.calcForm.setValues(sum);
    };

    VVCWidget.prototype.showChat = function() {
      this.topMenuList = [0, 0, 1];
      this.chat.show();
    };

    VVCWidget.prototype.menuAction = function(num) {
      if (this.topMenuList[num]) {
        return;
      }
      switch (num) {
        case 0:
          this.goodsList();
          break;
        case 1:
          this.showCalcForm();
          break;
        case 2:
          this.showChat();
      }
    };

    VVCWidget.prototype.onBuy = function(goods, delay) {
      var internalBuy,
        _this = this;
      if (delay == null) {
        delay = 0;
      }
      internalBuy = function() {
        _this.buy(goods);
      };
      setTimeout(internalBuy, delay * 100);
    };

    VVCWidget.prototype.buy = function(g) {
      this.add();
      window.VVC_SETTINGS.shop_id = parseInt(window.VVC_SETTINGS.shop_id);
      if (isNaN(window.VVC_SETTINGS.shop_id)) {
        JSTE.to(this.mainPane, VVC.layout.crushMsg, { httpHost: settings.httpHost, errorMsg: 'Отсутствует параметр &laquo;shop_id&raquo;.' });
        return;
      }

      switch(settings.brand) {
        case 'vk24':
          window.VVC_SETTINGS.user_id = 1;
          //if (window.VVC_SETTINGS.user_id === void 0) {
          //  window.VVC_SETTINGS.user_id = 0;
          //}
          if (window.VVC_SETTINGS.order_id === void 0) {
            //window.VVC_SETTINGS.order_id = 0;
            JSTE.to(this.mainPane, VVC.layout.crushMsg, {
              httpHost: settings.httpHost,
              errorMsg: 'Отсутствует параметр &laquo;order_id&raquo;.'
            });
            return;
          }
          break;
        case 'vvc':
          if (window.VVC_SETTINGS.user_id === void 0) {
            window.VVC_SETTINGS.user_id = 0;
          }
          if (window.VVC_SETTINGS.order_id === void 0) {
            window.VVC_SETTINGS.order_id = 0;
            return;
          }
          break;
      }


      if (window.VVC_SETTINGS.img === void 0) {
        if (!window.VVC_SETTINGS.css || window.VVC_SETTINGS.css === 'red') {
          window.VVC_SETTINGS.img = '_red';
        } else {
          window.VVC_SETTINGS.img = '';
        }
      }
      if (typeof g !== 'object' || g === null) {
        JSTE.to(this.mainPane, VVC.layout.noItems, settings);
        return;
      }
      this.goods = 'length' in g ? g : [g];
      if (this.goods.length === 0) {
        JSTE.to(this.mainPane, VVC.layout.noItems, settings);
      }
      if (document.all && !window.opera && !document.querySelector) {
        this.browserError();
        return;
      }
      this.connectionWrapper.init(this.shopInfo);
    };

    VVCWidget.prototype.add = function() {
      if (!document.body) {
        window.setTimeout(arguments.callee, 100);
        return;
      }
      if (this.added) {
        return;
      }
      document.body.appendChild(this.hidingLayer);
      document.body.appendChild(this.mainPane);
      this.added = true;
      state = WidgetState.OPENED;
      if (typeof VVC_SETTINGS.onStateChange === "function") {
        VVC_SETTINGS.onStateChange(state);
      }
    };

    VVCWidget.prototype.remove = function() {
      if (!this.added) {
        return;
      }
      this.logout();
      document.body.removeChild(this.mainPane);
      document.body.removeChild(this.hidingLayer);
      this.added = false;
      state = WidgetState.CLOSED;
      if (typeof VVC_SETTINGS.onStateChange === "function") {
        VVC_SETTINGS.onStateChange(state);
      }
    };

    VVCWidget.prototype.logout = function() {
      this.send({
        act: 'logout'
      });
      this.topMenuList = [1, 0, 0];
      this.aid = false;
    };

    VVCWidget.prototype.isPhoneEntered = function() {
      var e, num;
      e = $('vvc_phone');
      if (e) {
        if (typeof VVC_SETTINGS.phone === 'string' && VVC_SETTINGS.phone.length === 10) {
          e.disabled = true;
          e.value = toMaskedPhone(VVC_SETTINGS.phone);
          this.checkPhone(VVC_SETTINGS.phone);
          return;
        }
        num = toDigStr(e.value);
        if (num.length === 10) {
          e.disabled = true;
          this.checkPhone(num);
        } else {
          window.setTimeout(this.isPhoneEntered, 100);
        }
      }
    };

    VVCWidget.prototype.checkPhone = function(phone) {
      if (phone in checkedPhones) {
        this.onCheckPhone(checkedPhones[phone]);
        return;
      }
      currentPhone = phone;
      VVC.send({
        act: 'check_phone',
        phone: phone
      });
    };

    VVCWidget.prototype.onCheckPhone = function(type, sms) {
      switch (type) {
        case 'admin':
        case 'shop':
        case 'bank':
          this.onWrongPhone();
          break;
        case 'user':
          this.showPassPane(sms);
          break;
        default:
          this.showRegForm();
      }
    };

    VVCWidget.prototype.onWrongPhone = function() {
      var phoneInput;
      phoneInput = $('vvc_phone');
      JSTE.to('VVC_FORM_USER', VVC.layout.wrongPhone, {
        phone: phoneInput.value
      });
      phoneInput.disabled = false;
      phoneInput.value = '';//'(___) - ___ - __ - __';
      phoneInput.focus();
      setCaretPosition(phoneInput, 1);
      this.isPhoneEntered();
    };

    VVCWidget.prototype.showPassPane = function(sms) {
      var m, phoneInput;
      m = this.getMessage();
      if (m) {
        this.finalPage(m);
        return;
      }
      phoneInput = $('vvc_phone');
      if (phoneInput) {
        VVC_SETTINGS.phone = toDigStr(phoneInput.value);
      }
      if (sms) {
        JSTE.to('VVC_FORM_USER', VVC.layout.passPane, settings);
      } else {
        JSTE.to('VVC_FORM_USER', VVC.layout.passPaneWithButton, settings);
      }
      $('vvc_pwd').focus();
    };

    VVCWidget.prototype.saveCreatedOrder = function(m) {
      if ('JSON' in window && Cookie.enabled && VVC_SETTINGS.order_id !== 0 && VVC_SETTINGS.order_id !== 1) {
        m.timestamp = timestamp();
        Cookie.set("order_" + VVC_SETTINGS.order_id, JSON.stringify(m));
      }
      if (!(currentPhone in createdOrders)) {
        createdOrders[currentPhone] = [];
      }
      createdOrders[currentPhone].push({
        m: m,
        goods: this.goods
      });
    };

    VVCWidget.prototype.getMessage = (function() {
      var isEqualArrays, isEqualObjects;
      isEqualObjects = function(a, b) {
        var k;
        for (k in a) {
          if (a[k] !== b[k]) {
            return false;
          }
        }
        return true;
      };
      isEqualArrays = function(a, b) {
        var i, _i, _ref;
        if (a.length !== b.length) {
          return false;
        }
        for (i = _i = 0, _ref = a.length; 0 <= _ref ? _i < _ref : _i > _ref; i = 0 <= _ref ? ++_i : --_i) {
          if (!isEqualObjects(a[i], b[i])) {
            return false;
          }
        }
        return true;
      };
      return function() {
        var item, key, m, str, _i, _len, _ref;
        if ('JSON' in window && Cookie.enabled && VVC_SETTINGS.order_id !== 0) {
          key = "order_" + VVC_SETTINGS.order_id;
          str = Cookie.get(key);
          if (str !== void 0) {
            m = JSON.parse(str);
            if (timestamp() - m.timestamp > cookieLifetime) {
              Cookie.remove(key);
              return;
            }
            return m;
          }
        }
        if (createdOrders[currentPhone]) {
          _ref = createdOrders[currentPhone];
          for (_i = 0, _len = _ref.length; _i < _len; _i++) {
            item = _ref[_i];
            if (isEqualArrays(this.goods, item.goods)) {
              return item.m;
            }
          }
        }
      };
    })();

    VVCWidget.prototype.showRegForm = function() {
      var name, phoneInput, surname, _ref;
      phoneInput = $('vvc_phone');
      if (phoneInput != null) {
        VVC_SETTINGS.phone = toDigStr(phoneInput.value);
      }
      if (typeof VVC_SETTINGS.name === 'string') {
        _ref = VVC_SETTINGS.name.split(' '), surname = _ref[0], name = _ref[1];
        if (this.vvcName === void 0) {
          this.vvcName = name;
        }
        if (this.vvcSurname === void 0) {
          this.vvcSurname = surname;
        }
      }
      this.vvcName = this.vvcName ? this.vvcName : '';
      this.vvcSurname = this.vvcSurname ? this.vvcSurname : '';
      JSTE.to('VVC_FORM_USER', VVC.layout.regForm, {
        domain: settings.domain,
        httpHost: settings.httpHost,
        name: this.vvcName,
        surname: this.vvcSurname,
        regions: this.regions
      });
      EH.add('vvc_region', 'change', this.selectRegion);
      EH.add('vvc_name', 'keyup', this.changeName);
      EH.add('vvc_surname', 'keyup', this.changeSurname);
      $('vvc_name').focus();
    };

    VVCWidget.prototype.selectRegion = function() {
      var key, region, value, _ref;
      value = $('vvc_region').value;
      _ref = this.regions;
      for (key in _ref) {
        region = _ref[key];
        region[1] = (region[2] === value ? true : false);
      }
    };

    VVCWidget.prototype.changeName = function() {
      this.vvcName = $('vvc_name').value;
    };

    VVCWidget.prototype.changeSurname = function() {
      this.vvcSurname = $('vvc_surname').value;
    };

    VVCWidget.prototype.anotherPhone = function() {
      var phoneInput;
      if (VVC_SETTINGS.phone !== void 0) {
        VVC_SETTINGS.phone = void 0;
      }
      $('VVC_FORM_USER').innerHTML = '';
      phoneInput = $('vvc_phone');
      phoneInput.disabled = false;
      if (true || document.all && !window.opera && document.querySelector && !document.addEventListener) {
        phoneInput.value = '';
        phoneInput.focus();
      } else {
        phoneInput.value = '(___) - ___ - __ - __';
        phoneInput.focus();
        setCaretPosition(phoneInput, 1);
      }
      this.isPhoneEntered();
    };

    VVCWidget.prototype.onSMSPWD = function() {
      var e, num;
      e = $('vvc_phone');
      if (e) {
        $('VVC_FORM_USER').innerHTML = '';
        num = toDigStr(e.value);
        if (num.length === 10) {
          this.send({
            act: 'sms',
            phone: num
          });
        }
      }
    };

    VVCWidget.prototype.onAuthUser = function() {
      var passInput, phoneInput;
      phoneInput = $('vvc_phone');
      passInput = $('vvc_pwd');
      if (phoneInput && passInput) {
        this.send({
          act: 'auth',
          phone: toDigStr(phoneInput.value),
          pwd: passInput.value
        });
        JSTE.to('VVC_FORM_USER', VVC.layout.creatingOrder);
      }
    };

    VVCWidget.prototype.registerUser = function() {
      if(!($('vvc_region').value.length)) {
        alert('Укажите, пожалуйста, регион, в котором вы живёте');
        $('vvc_region').focus();
        return;
      }
      this.vvcName = trim($('vvc_name').value);
      if (!this.vvcName.length || /[^А-яЁё\-]/.test(this.vvcName)) {
        alert('Сообщите, пожалуйста, своё имя. В этом поле допустимы только русские буквы');
        $('vvc_name').focus();
        $('vvc_name').select();
        return;
      }
      this.vvcSurname = trim($('vvc_surname').value);
      if (!this.vvcSurname.length || /[^А-яЁё\-]/.test(this.vvcSurname)) {
        alert('Сообщите, пожалуйста, свою фамилию. В этом поле допустимы только русские буквы');
        $('vvc_surname').focus();
        $('vvc_surname').select();
        return;
      }
      if (!$('vvc_terms').checked) {
        alert('Необходимо согласиться с условиями договора.');
        return;
      }

      this.send({
        act: 'register',
        name: this.vvcName,
        surname: this.vvcSurname,
        region: $('vvc_region').value,
        phone: toDigStr($('vvc_phone').value)
      });
      $('VVC_FORM_USER').innerHTML = '';
    };

    VVCWidget.prototype.createOrder = function() {
      var g, item, k, total, v, _i, _j, _len, _len1, _ref, _ref1;
      total = 0;
      _ref = this.goods;
      for (_i = 0, _len = _ref.length; _i < _len; _i++) {
        item = _ref[_i];
        total += item.amount * item.count;
      }
      g = {};
      _ref1 = this.goods;
      for (k = _j = 0, _len1 = _ref1.length; _j < _len1; k = ++_j) {
        v = _ref1[k];
        g[k] = v;
      }
      this.send({
        act: 'order_create',
        aid: this.aid,
        shop: VVC_SETTINGS.shop_id,
        list: g,
        amount: total,
        shop_uid: VVC_SETTINGS.user_id,
        num: VVC_SETTINGS.order_id
      });
    };

    VVCWidget.prototype.finalPage = function(m) {

      if(m.url)
      {
          if (typeof VVC_SETTINGS.onStateChange === "function") {
              VVC_SETTINGS.onStateChange('order');
          }
          VVC.remove();
          if(VVC_SETTINGS.shop_id==8320) alert('GO TO '+m.url);
          window.location.href = m.url;
      }
      else
      {

	      var fl, queryString, vvcuri;
	      queryString = buildQueryString({
	        hash: m.hash,
	        id: m.id,
	        uid: m.uid
	      });
	      vvcuri = "" + settings/*.domain*/.httpHost + "/session/order/?" + queryString;
	      fl = VVC_SETTINGS.final_link;
	      if (fl && typeof fl === 'object' && typeof fl.uri === 'string') {
	        JSTE.to('VVC_FORM_USER', VVC.layout.finalPageWithLink, {
	          domain: settings.domain,
	          oid: m.id,
	          vvcuri: vvcuri,
	          shopuri: fl.uri
	        });
	      } else {
	        JSTE.to('VVC_FORM_USER', VVC.layout.finalPage, {
	          domain: settings.domain,
	          oid: m.id,
	          vvcuri: vvcuri
	        });
	      }

	      if (typeof VVC_SETTINGS.onStateChange === "function") {
	        VVC_SETTINGS.onStateChange('order');
	      }
      }
    };

    VVCWidget.prototype.$ = $;

    VVCWidget.prototype.formatMoney = function(s) {
      var am;
      am = parseInt(s * 100) / 100 - parseInt(s);
      if (am === 0) {
        am = parseInt(s) + '.00';
      } else {
        am = parseInt(am * 100) - parseInt(am * 10) * 10;
        am = am === 0 ? s + '0' : s;
      }
      return am;
    };

    toDigStr = function(str) {
      var symbol;
      return ((function() {
        var _i, _len, _ref, _results;
        _ref = str.split('');
        _results = [];
        for (_i = 0, _len = _ref.length; _i < _len; _i++) {
          symbol = _ref[_i];
          if (!isNaN(parseInt(symbol))) {
            _results.push(symbol);
          }
        }
        return _results;
      })()).join('');
    };

    toMaskedPhone = function(numbers) {
      var number, result, _i, _len, _ref;
      result = '(___) - ___ - __ - __';
      _ref = numbers.split('');
      for (_i = 0, _len = _ref.length; _i < _len; _i++) {
        number = _ref[_i];
        result = result.replace('_', number);
      }
      return result;
    };

    createMainPane = function() {
      var e;
      e = document.createElement('div');
      e.className = 'vvc-widget-main-pane';
      return e;
    };

    createHidingLayer = function() {
      var e;
      e = document.createElement('div');
      e.className = 'vvc-widget-hiding-layer';
      return e;
    };

    parseJSON = function(str) {
      var data;
      try {
        data = JSON.parse(str);
      } catch (error) {
        return;
      }
      return data;
    };

    evalJSON = function(str) {
      var data;
      data = void 0;
      try {
        eval('data = ' + str);
      } catch (error) {
        return;
      }
      return data;
    };

    parseData = (function() {
      if ('JSON' in window) {
        return function(str) {
          var data;
          data = parseJSON(str);
          if (!data) {
            data = evalJSON(str);
          }
          return data;
        };
      } else {
        return function(str) {
          return evalJSON(str);
        };
      }
    })();

    VVCWidget.prototype.getAnnuityPay = function(sum, months, percent) {
      if (months == null) {
        months = 24;
      }
      if (percent == null) {
        percent = 0.24 / 12;
      }
      return sum * percent / (1 - 1 / Math.pow(1 + percent, months));
    };

    VVCWidget.prototype.initInfoElements = function() {
      var e, elements, _i, _len;
      if (!document.body) {
        window.setTimeout(this.initInfoElements, 100);
        return;
      }
      elements = document.body.getElementsByTagName('*');
      elements = (function() {
        var _i, _len, _results;
        _results = [];
        for (_i = 0, _len = elements.length; _i < _len; _i++) {
          e = elements[_i];
          if (e.id && ~e.id.indexOf('VVC_INFO_ELEMENT') && e.style.display !== 'none') {
            _results.push(e);
          }
        }
        return _results;
      })();
      for (_i = 0, _len = elements.length; _i < _len; _i++) {
        e = elements[_i];
        this.initInfoElement(e);
      }
    };

    VVCWidget.prototype.initInfoElement = function(e) {
      var a, p, t;
      a = parseInt(e.getAttribute('amount'));
      if (isNaN(a)) {
        return;
      }
      t = e.innerHTML;
      p = e.getAttribute('vvcpattern') || '~?~';
      if (!t || !~t.indexOf(p)) {
        return;
      }
      e.innerHTML = t.replace(p, Math.ceil(this.getAnnuityPay(a)));
    };

    VVCWidget.prototype.initButtons = function() {
      var b, buttons, _i, _len;
      if (!document.body) {
        window.setTimeout(this.initButtons, 100);
        return;
      }
      window.VVC_SETTINGS.color = window.VVC_SETTINGS.css ? window.VVC_SETTINGS.css : 'red';
      if (window.VVC_SETTINGS.img === void 0) {
        if (!window.VVC_SETTINGS.css || window.VVC_SETTINGS.css === 'red') {
          window.VVC_SETTINGS.img = '_red';
        } else {
          window.VVC_SETTINGS.img = '';
        }
      }
      buttons = document.body.getElementsByTagName('div');
      buttons = (function() {
        var _i, _len, _results;
        _results = [];
        for (_i = 0, _len = buttons.length; _i < _len; _i++) {
          b = buttons[_i];
          if (b.id && (b.id.indexOf('VVC_BUTTON_') === 0) && (b.style.display === 'none')) {
            _results.push(b);
          }
        }
        return _results;
      })();
      for (_i = 0, _len = buttons.length; _i < _len; _i++) {
        b = buttons[_i];
        this.initButton(b);
      }
    };

    VVCWidget.prototype.initButton = function(e) {
      var a, arg, args, btnColor, btnRound, btnStyle, p, src, style, styleNumber, total_amount, _i, _j, _k, _len, _len1, _ref, _ref1;
      args = parseData(e.innerHTML);
      if (!args) {
        return;
      }
      args = 'length' in args ? args : [args];
      a = 0;
      total_amount = 0;
      for (_i = 0, _len = args.length; _i < _len; _i++) {
        arg = args[_i];
        if (!(arg.amount !== void 0)) {
          continue;
        }
        if (arg.count === void 0) {
          arg.count = 1;
        }

        //arg.amount = arg.amount.replace(' ','').replace(' ','').replace(' ','').replace(',','').replace(',','').replace(',','');

        p = parseInt(arg.amount * 100 * arg.count);
        if (isNaN(p)) {
          continue;
        }
        a += p;
        total_amount += arg.amount;
      }
      if (!window.VVC) {
        window.VVC = this;
      }
      VVC.buttonParams[e.id] = args;
      a = parseInt(a / 2400);
      if (a === 0) {
        return;
      }

      if('vvc' == settings.brand) {
        if (e.id.indexOf("_IMAGE") > 0) {
          src = e.getAttribute('src') || e.title;
          e.innerHTML = "<img src=\"" + src + "\" border=\"0\" style=\"cursor:pointer\" onclick=\"VVC.buy(VVC.buttonParams['" + e.id + "'])\"/>";
          e.title = "Купить в кредит от " + a + " рублей в месяц";
          e.style.display = "";
          return;
        }
      }

      btnColor = window.VVC_SETTINGS.color;
      btnStyle = 1;
      btnRound = e.id.indexOf("_ROUND") > 0 ? "r" : "";
      _ref = this.styleList;
      for (_j = 0, _len1 = _ref.length; _j < _len1; _j++) {
        style = _ref[_j];
        if (e.id.indexOf("_COLOR" + style.toUpperCase()) > 0) {
          btnColor = style;
          break;
        }
      }
      for (styleNumber = _k = 1, _ref1 = this.stylesCount; 1 <= _ref1 ? _k <= _ref1 : _k >= _ref1; styleNumber = 1 <= _ref1 ? ++_k : --_k) {
        if (e.id.indexOf("_STYLE" + styleNumber) > 0) {
          btnStyle = styleNumber;
          break;
        }
      }
      e.className = "vvc_site_button_" + btnStyle;
      e.style.background =
          "url(" +
          settings.httpHost +
          "/widget/" + btnColor + "/" + btnStyle + "" + btnRound +
          "." + (('vk24' == settings.brand) ? 'png' : 'gif') + ")";
      switch(settings.brand) {

          case 'vk24':
              switch(btnStyle) {
                  case 2:
                      e.style.textAlign = "center";
                      e.style.cursor = "pointer";
                      EH.add(e, 'click', clickHandler);
                      e.innerHTML = "<div style=\"padding-top:42px;width:99%;overflow:hidden;text-align:center;\">от " + a + " р/мес</div>";
                      break;
                  case 1:
                  default:
                      e.style.textAlign = "center";
                      e.style.cursor = "pointer";
                      EH.add(e, 'click', clickHandler);
                      e.innerHTML = "<div style=\"font-size:18px;margin-top:3px;height:22px;padding-top:3px;width:99%;overflow:hidden;text-align:center;\">от " + a + " р/мес</div>";
              }
              break;

          case 'vvc':
              switch (btnStyle) {
                  case 2:
                      if (e.id.indexOf("_COUNT") > 0) {
                          e.innerHTML = (e.id.indexOf("_NOCLICK") > 0 ? "<div style=\"height:38px;\">&nbsp;</div>" : "<div style=\"height:38px;overflow:hidden;cursor:pointer;\" onclick=\"var p=parseInt(VVC.$('" + e.id + "_count').value);if(isNaN(p)||p<1)p=1;VVC.$('" + e.id + "_count').value=p;VVC.buttonParams." + e.id + "[0].count=p;VVC.buy(VVC.buttonParams." + e.id + ")\">&nbsp;</div>") + "<div style=\"font-size:12px;height:22px;overflow:hidden;\">" + "<input type=\"text\" maxlength=\"3\" id=\"" + e.id + "_count\" class=\"vvc_site_input\" value=\"1\" onclick=\"this.select()\" onkeyup=\"" + "if(isNaN(parseInt(this.value))||parseInt(this.value)<0)this.value=1;VVC.$('" + e.id + "_price').innerHTML=parseInt(this.value*" + total_amount + "/24)\"/>" + " шт. от <span id=\"" + e.id + "_price\">" + a + "</span> р/мес</div>" + (e.id.indexOf("_NOCLICK") > 0 ? "" : "<div style=\"height:40px;cursor:pointer;\" onclick=\"var p=parseInt(VVC.$('" + e.id + "_count').value);if(isNaN(p)||p<1)p=1;VVC.$('" + e.id + "_count').value=p;VVC.buttonParams." + e.id + "[0].count=p;VVC.buy(VVC.buttonParams." + e.id + ")\"></div>");
                      } else {
                          e.style.textAlign = "center";
                          if (e.id.indexOf("_NOCLICK") < 0) {
                              e.style.cursor = "pointer";
                              EH.add(e, 'click', clickHandler);
                          }
                          e.innerHTML = "<div style=\"padding-top:35px;width:99%;overflow:hidden;text-align:center;\">от " + a + " р/мес</div>";
                      }
                      break;
                  case 3:
                      if (e.id.indexOf("_COUNT") > 0) {
                          e.innerHTML = (e.id.indexOf("_NOCLICK") > 0 ? "<div style=\"height:60px;\">&nbsp;</div>" : "<div style=\"height:60px;overflow:hidden;cursor:pointer;\" onclick=\"var p=parseInt(VVC.$('" + e.id + "_count').value);if(isNaN(p)||p<1)p=1;VVC.$('" + e.id + "_count').value=p;VVC.buttonParams." + e.id + "[0].count=p;VVC.buy(VVC.buttonParams." + e.id + ")\">&nbsp;</div>") + "<div style=\"font-size:16px;height:40px;overflow:hidden;\">" + "<input type=\"text\" maxlength=\"3\" id=\"" + e.id + "_count\" class=\"vvc_site_input\" value=\"1\" onclick=\"this.select()\" onkeyup=\"" + "if(isNaN(parseInt(this.value))||parseInt(this.value)<0)this.value=1;VVC.$('" + e.id + "_price').innerHTML=parseInt(this.value*" + total_amount + "/24)\"/>" + " шт. от <span id=\"" + e.id + "_price\">" + a + "</span> р/мес</div>";
                      } else {
                          e.style.textAlign = "center";
                          if (e.id.indexOf("_NOCLICK") < 0) {
                              e.style.cursor = "pointer";
                              EH.add(e, 'click', clickHandler);
                          }
                          e.innerHTML = "<div style=\"padding-top:50px;width:99%;overflow:hidden;text-align:center;\">от " + a + " р/мес</div>";
                      }
                      break;
                  case 4:
                  case 5:
                      if (e.id.indexOf("_COUNT") > 0) {
                          e.innerHTML = "<div style=\"margin-left:10px;padding-top:9px;overflow:hidden;text-align:center;width:195px;height:20px;font-size:16px;float:left;\">" + "<input type=\"text\" maxlength=\"3\" id=\"" + e.id + "_count\" class=\"vvc_site_input\" value=\"1\" onclick=\"this.select()\" onkeyup=\"" + "if(isNaN(parseInt(this.value))||parseInt(this.value)<0)this.value=1;VVC.$('" + e.id + "_price').innerHTML=parseInt(this.value*" + total_amount + "/24)\"/>" + " шт. от <span id=\"" + e.id + "_price\">" + a + "</span> р/мес</div>" + (e.id.indexOf("_NOCLICK") > 0 ? "" : "<div style=\"cursor:pointer;float:left;height:40px;width:150px;\" onclick=\"var p=parseInt(VVC.$('" + e.id + "_count').value);if(isNaN(p)||p<1)p=1;VVC.$('" + e.id + "_count').value=p;VVC.buttonParams." + e.id + "[0].count=p;VVC.buy(VVC.buttonParams." + e.id + ")\"></div>");
                      } else {
                          e.style.cursor = "pointer";
                          if (e.id.indexOf("_NOCLICK") < 0) {
                              e.style.cursor = "pointer";
                              EH.add(e, 'click', clickHandler);
                          }
                          e.innerHTML = "<div style=\"margin-left:10px;padding-top:8px;overflow:hidden;text-align:left;width:195px;height:20px;\">В кредит от " + a + " р/мес</div>";
                      }
                      break;
                  default:
                      if (e.id.indexOf("_COUNT") > 0) {
                          e.innerHTML = "<div style=\"height:5px;overflow:hidden;\">&nbsp;</div><div style=\"font-size:12px;height:22px;overflow:hidden;\">" + "<input type=\"text\" maxlength=\"3\" id=\"" + e.id + "_count\" class=\"vvc_site_input\" value=\"1\" onclick=\"this.select()\" onkeyup=\"" + "if(isNaN(parseInt(this.value))||parseInt(this.value)<0)this.value=1;VVC.$('" + e.id + "_price').innerHTML=parseInt(this.value*" + total_amount + "/24)\"/>" + " шт. от <span id=\"" + e.id + "_price\">" + a + "</span> р/мес</div>" + (e.id.indexOf("_NOCLICK") > 0 ? "" : "<div style=\"height:73px;cursor:pointer;\" onclick=\"var p=parseInt(VVC.$('" + e.id + "_count').value);if(isNaN(p)||p<1)p=1;VVC.$('" + e.id + "_count').value=p;VVC.buttonParams." + e.id + "[0].count=p;VVC.buy(VVC.buttonParams." + e.id + ")\"></div>");
                      } else {
                          e.style.textAlign = "center";
                          if (e.id.indexOf("_NOCLICK") < 0) {
                              e.style.cursor = "pointer";
                              EH.add(e, 'click', clickHandler);
                          }
                          e.innerHTML = "<div style=\"padding-top:3px;width:99%;overflow:hidden;text-align:center;\">от " + a + " р/мес</div>";
                      }
              }
              break;
      }
      e.style.display = "";
    };

    clickHandler = function() {
      VVC.buy(VVC.buttonParams[this.id]);
    };

    return VVCWidget;

  })(Observer);

  window.VVC = new VVCWidget;

  Slider = (function() {
    var getPosition, inputFilter;

    function Slider(_arg) {
      var value,
        _this = this;
      this.range = _arg.range, this.input = _arg.input, this.min = _arg.min, this.max = _arg.max, value = _arg.value, this.onChange = _arg.onChange;
      this.drag = function(e) {
        return Slider.prototype.drag.apply(_this, arguments);
      };
      this.focusHandler = function(e) {
        return Slider.prototype.focusHandler.apply(_this, arguments);
      };
      this.keyUpHandler = function(e) {
        return Slider.prototype.keyUpHandler.apply(_this, arguments);
      };
      this.mouseDownHanler = function(e) {
        return Slider.prototype.mouseDownHanler.apply(_this, arguments);
      };
      this.clickHandler = function(e) {
        return Slider.prototype.clickHandler.apply(_this, arguments);
      };
      this.filler = this.range.firstChild;
      this.slider = this.filler.firstChild;
      this.sliderWidth = this.slider.offsetWidth;
      this.rangeWidth = this.range.offsetWidth - this.sliderWidth;
      this.slider.style.position = 'relative';
      if (!value) {
        value = this.min;
      }
      this.setValue(value);
      this.enable();
    }

    Slider.prototype.enable = function() {
      this.range.style.cursor = 'pointer';
      this.slider.style.cursor = 'e-resize';
      EH.add(this.slider, 'mousedown', this.mouseDownHanler);
      EH.add(this.range, 'click', this.clickHandler);
      if (this.input) {
        EH.add(this.input, 'keyup', this.keyUpHandler);
        EH.add(this.input, 'click', this.focusHandler);
        this.input.onkeypress = inputFilter;
        this.input.disabled = false;
      }
    };

    Slider.prototype.disable = function() {
      this.range.style.cursor = 'default';
      this.slider.style.cursor = 'default';
      EH.remove(this.slider, 'mousedown', this.mouseDownHanler);
      EH.remove(this.range, 'click', this.clickHandler);
      if (this.input) {
        EH.remove(this.input, 'keyup', this.keyUpHandler);
        EH.remove(this.input, 'click', this.focusHandler);
        this.input.onkeypress = void 0;
        this.input.disabled = true;
      }
    };

    Slider.prototype.setValues = function(min, max, value) {
      this.min = min;
      this.max = max;
      this.setValue(value);
    };

    Slider.prototype.setValue = function(value, setInput) {
      if (setInput == null) {
        setInput = true;
      }
      if (value == null) {
        return;
      }
      if (value > this.max) {
        value = this.max;
      }
      if (value < this.min) {
        value = this.min;
      }
      this.value = value;
      this.setSlider();
      if (setInput || this.value === this.min || this.value === this.max) {
        this.setInput();
      }
      if (typeof this.onChange === "function") {
        this.onChange(value);
      }
    };

    Slider.prototype.getValue = function() {
      return this.value;
    };

    Slider.prototype.setSlider = function() {
      var pos;
      pos = (this.value - this.min) / (this.max - this.min);
      this.filler.style.width = Math.ceil(this.sliderWidth + this.rangeWidth * pos) + 'px';
      this.slider.style.left = Math.ceil(this.rangeWidth * pos) + 'px';
    };

    Slider.prototype.setInput = function() {
      if (this.input) {
        this.input.value = Math.ceil(this.value);
      }
    };

    Slider.prototype.clickHandler = function(e) {
      var pos;
      pos = (e.clientX - getPosition(this.range).x - 0.5 * this.sliderWidth) / this.rangeWidth;
      this.setValue(this.min + pos * (this.max - this.min));
    };

    Slider.prototype.mouseDownHanler = function(e) {
      if (this.input) {
        this.input.blur();
      }
      this.drag(e);
    };

    Slider.prototype.keyUpHandler = function(e) {
      var value;
      value = parseInt(this.input.value);
      if (isNaN(value)) {
        return;
      }
      this.setValue(value);
    };

    Slider.prototype.focusHandler = function(e) {
      this.input.select();
    };

    Slider.prototype.drag = function(e) {
      var moveHandler, upHandler,
        _this = this;
      moveHandler = function(e) {
        var pos;
        e.stopPropagation();
        pos = (e.clientX - getPosition(_this.range).x - 0.5 * _this.sliderWidth) / _this.rangeWidth;
        _this.setValue(_this.min + pos * (_this.max - _this.min));
      };
      upHandler = function(e) {
        e.stopPropagation();
        EH.remove(document, 'mousemove', moveHandler);
        EH.remove(document, 'mouseup', upHandler);
      };
      e.stopPropagation();
      e.preventDefault();
      EH.add(document, 'mousemove', moveHandler);
      EH.add(document, 'mouseup', upHandler);
    };

    getPosition = function(element) {
      var e, x, y;
      x = 0;
      y = 0;
      e = element;
      while (e) {
        x += e.offsetLeft;
        y += e.offsetTop;
        e = e.offsetParent;
      }
      e = element.parentNode;
      while (e && e !== document.body) {
        if (e.scrollLeft) {
          x -= e.scrollLeft;
        }
        if (e.scrollTop) {
          y -= e.scrollTop;
        }
        e = e.parentNode;
      }
      return {
        x: x,
        y: y
      };
    };

    inputFilter = (function(allowed) {
      return function(e) {
        var c, code;
        e || (e = window.event);
        code = e.charCode || e.keyCode;
        if (e.ctrlKey || e.altKey) {
          return true;
        }
        if (e.charCode === 0) {
          return true;
        }
        if (code < 32) {
          return true;
        }
        c = String.fromCharCode(code);
        return !!~allowed.indexOf(c);
      };
    })('0123456789');

    return Slider;

  })();

  CalcForm = (function() {
    var createMainPane, focus, formatNumber, getAnnuityPay;

    focus = {};

    function CalcForm(parent, config) {
      var _this = this;
      this.parent = parent;
      this.config = config != null ? config : {};
      this.onChangeMonths = function(months) {
        return CalcForm.prototype.onChangeMonths.apply(_this, arguments);
      };
      this.onChangeFirstPay = function(firstPay) {
        return CalcForm.prototype.onChangeFirstPay.apply(_this, arguments);
      };
      this.inited = false;
      this.container = createMainPane();
      JSTE.to(this.container, VVC.layout.calcForm, settings);
      this.currentPercent = 0.24 / 12;
      this.minFirstPay = 0;
      this.maxFirstPay = 3e5 / 6;
      this.minMonths = 1;
      this.maxMonths = 24;
      this.init();
    }

    CalcForm.prototype.init = function() {
      this.add();
      if (this.inited) {
        this.enable();
        return;
      }
      this.firstPayInput = $('firstPayInput');
      this.monthInput = $('monthInput');
      this.creditSum = $('creditSum');
      this.annuityPay = $('annuityPay');
      this.sum = this.config.sum;
      this.firstPaySlider = new Slider({
        range: $('firstPayRange'),
        input: this.firstPayInput,
        min: this.minFirstPay,
        max: (this.maxFirstPay = this.config.sum / 6)
      });
      this.monthsSlider = new Slider({
        range: $('monthRange'),
        input: this.monthInput,
        min: this.minMonths,
        max: this.maxMonths
      });
      this.firstPaySlider.onChange = this.onChangeFirstPay;
      this.monthsSlider.onChange = this.onChangeMonths;
      this.setValues(this.config.sum, this.config.months);
      this.enable();
      this.inited = true;
    };

    CalcForm.prototype.setValues = function(sum, months) {
      this.sum = sum;
      this.creditSum.innerHTML = formatNumber(this.sum.toFixed(0));
      this.firstPaySlider.setValues(0, (this.maxFirstPay = this.sum / 6), 0);
      this.monthsSlider.setValue(months);
    };

    CalcForm.prototype.onChangeFirstPay = function(firstPay) {
      if (!focus['firstPayInput']) {
        this.firstPayInput.value = formatNumber(firstPay.toFixed(0));
      }
      this.annuityPay.innerHTML = formatNumber(Math.ceil(getAnnuityPay(this.sum - firstPay, this.monthsSlider.value, this.currentPercent)));
    };

    CalcForm.prototype.onChangeMonths = function(months) {
      this.annuityPay.innerHTML = formatNumber(Math.ceil(getAnnuityPay(this.sum - this.firstPaySlider.value, months, this.currentPercent)));
    };

    CalcForm.prototype.add = function() {
      this.parent.innerHTML = '';
      this.parent.appendChild(this.container);
    };

    CalcForm.prototype.remove = function() {
      this.parent.removeChild(this.container);
    };

    CalcForm.prototype.enable = function() {
      this.addEventListeners();
      this.firstPaySlider.enable();
      this.monthsSlider.enable();
    };

    CalcForm.prototype.disable = function() {
      this.removeEventListeners();
      this.firstPaySlider.disable();
      this.monthsSlider.disable();
    };

    CalcForm.prototype.addEventListeners = function() {
      this.firstPayInput.onfocus = this.focusHandler;
      this.firstPayInput.onblur = this.blurHandler;
    };

    CalcForm.prototype.removeEventListeners = function() {
      this.firstPayInput.onfocus = void 0;
      this.firstPayInput.onblur = void 0;
    };

    CalcForm.prototype.focusHandler = function() {
      focus[this.id] = true;
      this.value = this.value.replace(/\s+/g, '');
    };

    CalcForm.prototype.blurHandler = function() {
      focus[this.id] = false;
      this.value = formatNumber(this.value);
    };

    getAnnuityPay = function(sum, months, percent) {
      return sum * percent / (1 - 1 / Math.pow(1 + percent, months));
    };

    createMainPane = function() {
      var e;
      e = document.createElement('div');
      e.className = 'vvc-widget-main-pane';
      return e;
    };

    formatNumber = function(n) {
      var ceil, count, fractional, i, length, parts, residue, result, str;
      str = n.toString();
      parts = str.split('.');
      ceil = parts[0];
      fractional = '';
      if (parts[1] != null) {
        fractional = ',' + parts[1];
      }
      length = ceil.length;
      if (length < 4) {
        return ceil + fractional.slice(0, 3);
      }
      count = Math.floor(length / 3);
      residue = length % 3;
      result = ceil.slice(0, residue);
      i = 0;
      while (i < count) {
        if (result.length) {
          result += ' ';
        }
        result += ceil.substr(residue + 3 * i, 3);
        i++;
      }
      return result + fractional.slice(0, 3);
    };

    return CalcForm;

  })();

  JSTE = (function() {

    function JSTE() {}

    JSTE.prepare = (function() {
      var cache, match;
      cache = {};
      match = [
        {
          re: /<%=\s*(.*?)\s*%>/g,
          overlap: "',$1,'"
        }, {
          re: /<%\s*(.*?)\s*%>/g,
          overlap: "');$1r.push('"
        }
      ];
      return function(template) {
        if (template in cache) {
          return cache[template];
        }
        return cache[template] = (function(template) {
          var m, _i, _len;
          for (_i = 0, _len = match.length; _i < _len; _i++) {
            m = match[_i];
            template = template.replace(m.re, m.overlap);
          }
          return new Function("data", "var r=[];with(data){r.push('" + template + "');}return r.join('');");
        })(template);
      };
    })();

    JSTE.render = (function() {
      var empty;
      empty = {};
      return function(template, data) {
        if (data == null) {
          data = empty;
        }
        return this.prepare(template)(data);
      };
    })();

    (function() {
      if ('document' in this) {
        JSTE.to = function(element, template, data) {
          if (typeof element === 'string') {
            element = document.getElementById(element);
          }
          element.innerHTML = this.render(template, data);
        };
      }
    })();

    return JSTE;

  })();

  VVC.layout = {};

  VVC.layout.browserError = '<div class="vk24-widget-logo"></div>\n<div class="vvc-window-close" onclick="VVC.remove()"></div>\n<div class="vvc-widget-phone">\n	Москва: (495) 540-42-42<br/>\n	Регионы: (800) 333-21-81\n</div>\n<div class="vk24-widget-title">Заявка на кредит</div>\n<div class="vk24-widget-container">\n	Система <b>"Всё в кредит"</b> поддерживает<br/><br/> Internet Explorer начиная с восьмой версии.\n	<br/><br/>\n	Пожалуйста, установите <a href="http://windows.microsoft.com/ru-RU/internet-explorer/products/ie/home/" target="_blank">обновление Internet Explorer</a>,\n	 или<br/><br/>используйте другой браузер, например:\n	<br/><br/>\n	<a href="http://www.google.com/intl/ru/chrome/browser/" target="_blank">Google Chrome</a> или \n	<a href="http://mozilla-russia.org/" target="_blank">FireFox</a>\n</div>\n<div class="vvc-error-page-footer"></div>'.replace(/[\n\t]/g, '');

  VVC.layout.noItems = '<div class="vk24-widget-logo"></div>\n<div class="vvc-window-close" onclick="VVC.remove()"></div>\n<div class="vvc-widget-phone">\n	Москва: (495) 540-42-42<br/>\n	Регионы: (800) 333-21-81\n</div>\n<div class="vk24-widget-title">Заявка на кредит</div>\n<div class="vk24-widget-container">\n	<span class="vvc-noitems-text">Не выбрано ни одного товара!</span>\n</div>\n<img class="vvc-widget-rs" src="<%= httpHost %>/widget/img/rs.png"/>\n<img class="vvc-widget-otp" src="<%= httpHost %>/widget/img/otp.png"/>\n<img class="vvc-widget-hc" src="<%= httpHost %>/widget/img/hc.png"/>'.replace(/[\n\t]/g, '');

  VVC.layout.promoAction = '<div class="vk24-widget-logo"></div>\n<div class="vvc-window-close" onclick="VVC.remove()"></div>\n<div class="vvc-widget-phone">\n	Москва: (495) 540-42-42<br/>\n	Регионы: (800) 333-21-81\n</div>\n<div class="vk24-widget-title">Заявка на кредит</div>\n<div class="vk24-widget-container">\n	<br/>\n	<span class="vvc-promo-action-header">Внимание, проводится акция!</span>\n	<br/><br/>\n	<span class="vvc-promo-action-info"><%= title %></span>\n	<br/><br/>\n	<a class="vvc-promo-link" href="<%= promoInfoURL %>" target="_blank">Подробно об условиях акции</a>\n	<br/>\n	<div class="vvc-promo-code-container">\n		Введите ваш промокод:<br/>\n		<input id="vvc_promo_code" class="vk24-widget-input vvc-promo-code"/>\n	</div>\n	<div class="vk24-blue-gradient vvc-button-200px" onclick="VVC.onStartFormLight(true);">\n		Пропустить\n	</div>\n	&nbsp;&nbsp;&nbsp;&nbsp;\n	<div class="vk24-blue-gradient vvc-button-200px" onclick="VVC.onCheckPromo();">\n		Отправить\n	</div>\n</div>\n<img class="vvc-widget-rs" src="<%= httpHost %>/widget/img/rs.png"/>\n<img class="vvc-widget-otp" src="<%= httpHost %>/widget/img/otp.png"/>\n<img class="vvc-widget-hc" src="<%= httpHost %>/widget/img/hc.png"/>'.replace(/[\n\t]/g, '');

  VVC.layout.waitWindow = '<div class="vk24-widget-logo"></div>\n<div class="vvc-window-close" onclick="VVC.remove()"></div>\n<div class="vvc-widget-phone">\n	Москва: (495) 540-42-42<br/>\n	Регионы: (800) 333-21-81\n</div>\n<div class="vk24-widget-title">Заявка на кредит</div>\n<div class="vk24-widget-container">\n	<br/>\n	<img class="vvc-widget-preloader" src="<%= httpHost %>/widget/img/preloader.gif"/>\n	<br/>\n	<div id="VVC_WAIT_BTN_PANE">\n		Идёт соединение с сервером\n	</div>\n</div>\n<img class="vvc-widget-rs" src="<%= httpHost %>/widget/img/rs.png"/>\n<img class="vvc-widget-otp" src="<%= httpHost %>/widget/img/otp.png"/>\n<img class="vvc-widget-hc" src="<%= httpHost %>/widget/img/hc.png"/>'.replace(/[\n\t]/g, '');

  VVC.layout.errWindow = '<div class="vk24-widget-logo"></div>\n<div class="vvc-window-close" onclick="VVC.remove()"></div>\n<div class="vvc-widget-phone">\n	Москва: (495) 540-42-42<br/>\n	Регионы: (800) 333-21-81\n</div>\n<div class="vk24-widget-title">Заявка на кредит</div>\n<div class="vk24-widget-container">\n	Сервер временно недоступен.<br/>Это ненадолго.\n	<br/>\n	<img class="vvc-widget-preloader" src="<%= httpHost %>/widget/img/preloader.gif"/>\n	<br/>\n	<div>Попытка повторного соединения состоится через <span id="VVC_RECONNECT_SECONDS">10 секунд</span>.</div>\n</div>\n<img class="vvc-widget-rs" src="<%= httpHost %>/widget/img/rs.png"/>\n<img class="vvc-widget-otp" src="<%= httpHost %>/widget/img/otp.png"/>\n<img class="vvc-widget-hc" src="<%= httpHost %>/widget/img/hc.png"/>'.replace(/[\n\t]/g, '');

  VVC.layout.basePane = '<div class="vk24-widget-logo"></div>\n<div class="vvc-window-close" onclick="VVC.remove()"></div>\n<div class="vvc-widget-phone">\n	Москва: (495) 540-42-42<br/>\n	Регионы: (800) 333-21-81\n</div>\n<div class="vk24-widget-title">Заявка на кредит</div>\n<div class="vk24-widget-container">\n	<ul class="navigation-bar">\n		<li class="navigation-bar-item"><div class="vk24-blue-tab" id="VVC_MENU_ITEM_0" onclick="VVC.menuAction(0);">Ваш заказ</div></li>\n		<% if (!(document.all && !window.opera)) { %>\n			<li class="navigation-bar-item"><div class="vvc-gray-gradient vvc-tab" style="display: none;" id="VVC_MENU_ITEM_1" onclick="VVC.menuAction(1);">Калькулятор</div></li>\n		<% } %>\n		<li class="navigation-bar-item"><div class="vvc-gray-gradient vvc-tab" style="display: none;" id="VVC_MENU_ITEM_2" onclick="VVC.menuAction(2);">Задать вопрос</div></li>\n	</ul>\n	<div id="VVC_MAIN_PANE">\n		<table class="vk24-goods-table">\n			<thead>\n				<tr>\n					<th width="10%" class="left-border-radius">№</th>\n					<th width="50%" class="vvc-left">Название</th>\n					<th width="20%">Количество</th>\n					<th width="20%" class="right-border-radius">Цена, руб.</th>\n				</tr>\n			</thead>\n			<tbody>\n				<tr>\n					<td colspan="4" class="list-cell">\n						<div class="vvc-goods-list">\n							<table width="100%">\n								<%\n								var len = g.length, num = 0, total = 0, amount = 0;\n								for (var i = 0; i < len; i++)\n								{\n									if (typeof(g[i].amount)==\'undefined\' || g[i].amount*100<1) continue;\n									if (typeof(g[i].title)==\'undefined\' || !g[i].title) g[i].title = \'Без названия\';\n									if (typeof(g[i].count)==\'undefined\') g[i].count = 1;\n									total += g[i].amount * g[i].count;\n									amount = VVC.formatMoney(g[i].amount);\n									num++;\n								%>\n								<tr class="list-item">\n									<td width="10%" class="left-border-radius"><%= num %></td>\n									<td width="50%" class="vvc-left"><%= g[i].title %></td>\n									<td width="20%"><%= g[i].count %></td>\n									<td width="20%" class="right-border-radius"><%= amount %></td>\n								</tr>\n								<% } %>\n							</table>\n						</div>\n					</td>\n				</tr>\n			</tbody>\n			<tfoot>\n				<tr class="vvc-footer">\n					<td width="80%" colspan="3" class="left-border-radius"><b>Итого<%= commText %>:</b></td>\n					<td width="20%" class="right-border-radius"><b><%= (total * (1 + comm * 0.01)).toFixed(2) %></b></td>\n				</tr>\n			</tfoot>\n		</table>\n	</div>\n	<div class="vvc-right-block">\n		Номер вашего мобильного телефона: \n		<b style="margin-left:20px;">+7</b> <input type="text" class="vk24-widget-input" name="phone" id="vvc_phone" maxlength="<%= ml %>"/>\n	</div>\n	<div id="VVC_FORM_USER"></div>\n</div>\n<img class="vvc-widget-rs" src="<%= httpHost %>/widget/img/rs.png"/>\n<img class="vvc-widget-otp" src="<%= httpHost %>/widget/img/otp.png"/>\n<img class="vvc-widget-hc" src="<%= httpHost %>/widget/img/hc.png"/>'.replace(/[\n\t]/g, '');

  VVC.layout.passPane = '<div class="vvc-right-block">\n	Ваш пароль в системе "Всё в кредит": \n	<input id="vvc_pwd" type="password" class="vk24-widget-input"/>\n</div>\n<br/>\n<table width="100%">\n	<tr>\n		<td class="vvc-left"><div class="vvc-gray-gradient vvc-button-210px" onclick="VVC.anotherPhone();">Ввести другой номер</div></td>\n		<td>Пароль отправлен по SMS, ожидайте</td>\n		<td class="vvc-right"><div class="vk24-blue-gradient vvc-button-210px" onclick="VVC.onAuthUser();">Оформить заявку</div></td>\n	</tr>\n</table>'.replace(/[\n\t]/g, '');

  VVC.layout.passPaneWithButton = '<div class="vvc-right-block">\n	Ваш пароль в системе "Всё в кредит": \n	<input id="vvc_pwd" type="password" class="vk24-widget-input"/>\n</div>\n<br/>\n<table width="100%">\n	<tr>\n		<td class="vvc-left"><div class="vvc-gray-gradient vvc-button-210px" onclick="VVC.anotherPhone();">Ввести другой номер</div></td>\n		<td><div id="VVC_ACTION_GET_SMS" class="vk24-blue-gradient vvc-button-210px" onclick="VVC.onSMSPWD();">Получить SMS с паролем</div></td>\n		<td class="vvc-right"><div id="VVC_ACTION_AUTH" class="vvc-gray-gradient vvc-button-210px" onclick="VVC.onAuthUser();">Оформить заявку</div></td>\n	</tr>\n</table>'.replace(/[\n\t]/g, '');

  VVC.layout.wrongPhone = '<div>\n	<br/>Телефон <b><%= phone %></b> используется в административных целях.\n	<br/>Для оформления покупок используйте другой номер.\n</div>'.replace(/[\n\t]/g, '');

  VVC.layout.regForm = (''
      + '<div class="vvc-right-block">\n'
      + '	<div class="vk24-select-border">'
      + '	<select id="vvc_region" type="text" class="vvc-reg-input">\n'
      + '		<option value="">Выберите регион</option>'
      + '		<% for (var i in regions) { %>\n'
      + '		<option value=<%= regions[i][2] %> ><%= regions[i][0] %></option>\n'
      + '		<% } %>\n'
      + '	</select></div>\n'
      + '</div>\n'
      + '<div class="vvc-right-block">\n'
      + '	Представьтесь, пожалуйста: <input placeholder="Имя" id="vvc_name" class="vk24-widget-input" value="<%= name %>"/><input placeholder="Фамилия" id="vvc_surname" class="vk24-widget-input" value="<%= surname %>"/>\n'
      + '	<br/><br/>'
      + '<input type="checkbox" id="vvc_terms" checked>\n'
      + '	<label class="vvc-widget-terms" for="vvc_terms"> Я соглашаюсь с <a target="_blank" href="<%= httpHost %>/personal-data-agreement">условиями</a> обработки персональных данных.</label>\n'
      + '</div>\n'
      + '<br/>\n'
      + '<table width="100%">\n'
      + '	<tr>\n'
      + '		<td class="vvc-left" width="33%"><div class="vvc-gray-gradient vvc-button-210px" onclick="VVC.anotherPhone();">Ввести другой номер</div></td>\n'
      + '		<td width="34%">&nbsp;</td>\n'
      + '		<td class="vvc-right" width="33%"><div class="vk24-blue-gradient vvc-button-210px" onclick="VVC.registerUser();">Оформить заявку</div></td>\n'
      + '	</tr>\n'
      + '</table>').replace(/[\n\t]/g, '');

  VVC.layout.creatingOrder = '<div class="vvc-creating-order">Идёт создание заказа. Пожалуйста подождите.</div>'.replace(/[\n\t]/g, '');

  VVC.layout.crush = (''
      + '<div class="vk24-widget-logo"></div>\n'
      + '<div class="vvc-window-close" onclick="VVC.remove()"></div>\n'
      + '<div class="vvc-widget-phone">\n'
      + '	Москва: (495) 540-42-42<br/>\n'
      + '	Регионы: (800) 333-21-81\n</div>\n'
      + '<div class="vk24-widget-title">Заявка на кредит</div>\n'
      + '<div class="vk24-widget-container">\n'
      + '	<div id="VVC_MAIN_PANE">\n'
      + '		<br/>\n'
      + '		<div>Сожалеем, произошла ошибка идентификации магазина.</div>\n'
      + '		<div class="service-unavailable">Сервис недоступен до устранения интернет-магазином технической проблемы.</div>\n'
      + '	</div>\n'
      + '	<br/>\n'
      + '</div>\n'
      + '<img class="vvc-widget-rs" src="<%= httpHost %>/widget/img/rs.png"/>\n'
      + '<img class="vvc-widget-otp" src="<%= httpHost %>/widget/img/otp.png"/>\n'
      + '<img class="vvc-widget-hc" src="<%= httpHost %>/widget/img/hc.png"/>').replace(/[\n\t]/g, '');

  VVC.layout.crushMsg = (''
      +     '<div class="vk24-widget-logo"></div>\n'
      +     '<div class="vvc-window-close" onclick="VVC.remove()">'
      +     '</div>\n'
      +         '<div class="vvc-widget-phone">\n	'
      +              'Москва: (495) 540-42-42<br/>\n	Регионы: (800) 333-21-81\n'
      +     '</div>\n'
      +     '<div class="vk24-widget-title">Заявка на кредит</div>\n'
      +     '<div class="vk24-widget-container">\n	'
      +         '<div id="VVC_MAIN_PANE">\n		'
      +             '<br/>\n		'
      +             '<div>Сожалеем, произошла ошибка идентификации магазина.</div>\n		'
      +             '<div class="service-unavailable">Сервис недоступен по причине следующей ошибки:</div>\n	'
      +             '<div class="service-unavailable"><%= errorMsg %></div>\n	'
      +         '</div>\n	'
      +         '<br/>\n'
      +     '</div>\n'
      +     '<img class="vvc-widget-rs" src="<%= httpHost %>/widget/img/rs.png"/>\n'
      +     '<img class="vvc-widget-otp" src="<%= httpHost %>/widget/img/otp.png"/>\n'
      +     '<img class="vvc-widget-hc" src="<%= httpHost %>/widget/img/hc.png"/>').replace(/[\n\t]/g, '');

  VVC.layout.finalPage =
      ('<br/>Заказ № <b><%= oid %></b> успешно сформирован. В ближайшее время с Вами свяжется наш специалист.<br/><br/>\n'
       + '<div style="text-align: center;"><a target="_top" onclick="VVC.remove()" class="vk24-blue-gradient vvc-button-210px">\n	'
       + 'Завершить\n</a></div>').replace(/[\n\t]/g, '');

  VVC.layout.finalPageWithLink =
      ('<br/>Заказ № <b><%= oid %></b> успешно сформирован. В ближайшее время с Вами свяжется наш специалист.<br/><br/>\n'
      + '<table width="100%">\n	'
      +     '<tr>\n		'
      +         '<td>\n					'
      +         '</td>\n		'
      +         '<td style="text-align: center;">\n			'
      +             '<a target="_top" href="<%= shopuri %>" class="vk24-blue-gradient vvc-button-210px">Вернуться в магазин</a>\n		'
      +         '</td>\n	'
      +     '</tr>\n'
      + '</table>').replace(/[\n\t]/g, '');

  VVC.layout.calcForm = '<div class="vk24-widget-logo"></div>\n<div class="vvc-window-close" onclick="VVC.remove()"></div>\n<div class="vvc-widget-phone">\n	Москва: (495) 540-42-42<br/>\n	Регионы: (800) 333-21-81\n</div>\n<div class="vk24-widget-title">Заявка на кредит</div>\n<div class="vk24-widget-container">\n	<ul class="navigation-bar">\n		<li class="navigation-bar-item"><div class="vvc-gray-gradient vvc-tab" id="VVC_MENU_ITEM_0" onclick="VVC.menuAction(0);">Ваш заказ</div></li>\n		<li class="navigation-bar-item"><div class="vk24-blue-gradient vvc-tab" style="display: none;" id="VVC_MENU_ITEM_1" onclick="VVC.menuAction(1);">Калькулятор</div></li>\n		<li class="navigation-bar-item"><div class="vvc-gray-gradient vvc-tab" style="display: none;" id="VVC_MENU_ITEM_2" onclick="VVC.menuAction(2);">Задать вопрос</div></li>\n	</ul>\n	<table class="vvc-widget-table vvc-calc-slider-table">\n		<tr class="vvc-calc-slider-name"><td colspan="2">Первоначальный взнос, руб.</td></tr>\n		<tr>\n			<td>\n				<div id="firstPayRange" class="vvc-calc-slide-bg">\n					<div class="vvc-calc-slide-filler vvc-calc-filler-gradient">\n						<div class="vvc-calc-slider vvc-calc-slider-gradient"></div>\n					</div>\n				</div>\n			</td>\n			<td><input id="firstPayInput" class="vvc-calc-slider-input"/></td>\n		</tr>\n		<tr class="vvc-calc-slider-name"><td colspan="2">Срок кредита, мес.</td></tr>\n		<tr>\n			<td>\n				<div id="monthRange" class="vvc-calc-slide-bg">\n					<div class="vvc-calc-slide-filler vvc-calc-filler-gradient">\n						<div class="vvc-calc-slider vvc-calc-slider-gradient"></div>\n					</div>\n				</div>\n			</td>\n			<td><input id="monthInput" class="vvc-calc-slider-input"/></td>\n		</tr>\n		<tr class="empty-row"><td colspan="2">&nbsp;</td></tr>\n		<tr>\n			<td colspan="2">\n				<div class="vvc-left vvc-float-left vvc-widget-calc-field">Сумма кредита, р. <span id="creditSum" class="vvc-float-right vvc-widget-digits"></span></div>\n				<div class="vvc-left vvc-float-right vvc-widget-calc-field">Ежемесячный платёж, р. <span id="annuityPay" class="vvc-float-right vvc-widget-digits"></span></div>\n			</td>\n		</tr>\n		<tr>\n			<td colspan="2">\n				<div class="vvc-widget-annuity-pay-info">Расчет ежемесячного платежа является приблизительным.</div>\n			</td>\n		</tr>\n	</table>\n</div>\n<img class="vvc-widget-rs" src="<%= httpHost %>/widget/img/rs.png"/>\n<img class="vvc-widget-otp" src="<%= httpHost %>/widget/img/otp.png"/>\n<img class="vvc-widget-hc" src="<%= httpHost %>/widget/img/hc.png"/>'.replace(/[\n\t]/g, '');

  VVC.layout.chat = '<div class="vk24-widget-logo"></div>\n<div class="vvc-window-close" onclick="VVC.remove()"></div>\n<div class="vvc-widget-phone">\n	Москва: (495) 540-42-42<br/>\n	Регионы: (800) 333-21-81\n</div>\n<div class="vk24-widget-title">Заявка на кредит</div>\n<div class="vk24-widget-container">\n	<ul class="navigation-bar">\n		<li class="navigation-bar-item"><div class="vvc-gray-gradient vvc-tab" id="VVC_MENU_ITEM_0" onclick="VVC.menuAction(0);">Ваш заказ</div></li>\n		<% if (!(document.all && !window.opera)) {%>\n			<li class="navigation-bar-item"><div class="vvc-gray-gradient vvc-tab" style="display: none;" id="VVC_MENU_ITEM_1" onclick="VVC.menuAction(1);">Калькулятор</div></li>\n		<% } %>\n		<li class="navigation-bar-item"><div class="vk24-blue-gradient vvc-tab" style="display: none;" id="VVC_MENU_ITEM_2" onclick="VVC.menuAction(2);">Задать вопрос</div></li>\n	</ul>\n	<div id="VVC_MAIN_PANE">\n		<table class="vvc-widget-table">\n			<tr>\n				<td class="vvc-chat-table-cell">\n					<div id="vvc_chat_output" class="vvc-chat-output"></div>\n					<input id="vvc_chat_input" placeholder="Введите ваш вопрос" class="vvc-chat-input vvc-float-left" onkeyup="VVC.chat.sendMessage(event);">\n					<div class="vk24-blue-gradient vvc-send-button vvc-button" onclick="VVC.chat.sendMessage();">Отправить</div>\n				</td>\n			</tr>\n		</table>\n	</div>\n	<br/>\n</div>\n<img class="vvc-widget-rs" src="<%= httpHost %>/widget/img/rs.png"/>\n<img class="vvc-widget-otp" src="<%= httpHost %>/widget/img/otp.png"/>\n<img class="vvc-widget-hc" src="<%= httpHost %>/widget/img/hc.png"/>'.replace(/[\n\t]/g, '');

  VVC.layout.creditOffer = '<div class="vvc-window vvc-credit-offer">\n	<div class="vk24-widget-logo"></div>\n	<div class="vvc-window-close" id="vvc_close"></div>\n	<div class="vvc-credit-offer-window-content">\n		<span class="vvc-credit-offer-text">\n			Вы можете <b>купить</b> этот товар в <b>кредит</b>!\n		</span>\n		<br/><br/>\n		Удалить товар из заказа?\n	</div>\n	<div id="vvc_remove" class="vk24-blue-gradient vvc-button">Ок</div>\n	&nbsp;&nbsp;&nbsp;&nbsp;\n	<div id="vvc_cancel" class="vk24-blue-gradient vvc-button">Отмена</div>\n</div>'.replace(/[\n\t]/g, '');

  VVC.layout.creditInfo = '<div class="vvc-window vvc-credit-info">\n	<div class="vk24-widget-logo"></div>\n	<div class="vvc-window-close" id="vvc_close"></div>\n	<div class="vvc-window-title">Покупайте в кредит,<br/>не выходя из дома</div>\n	<div class="vvc-credit-info-window-content">\n		<div class="vvc-added-info">Товар добавлен в корзину</div>\n		<ul class="vvc-list">\n			<li>Услуга кредитования доступна для граждан РФ старше 18 лет.</li>\n			<li>Кредитный договор подписываете у себя дома или на работе.</li>\n			<li>Сумма кредита от 2000 до 300&nbsp;000 рублей.</li>\n			<li>Выгодные условия по кредиту - переплата от 10%.</li>\n			<li>Банки принимают решение о выдаче кредита за 5 минут.</li>\n			<li>Оформление кредита бесплатно.</li>\n		</ul>\n		<div class="vvc-center">\n			<div id="vvc_basket" class="vk24-blue-gradient vvc-button-200px">Перейти в корзину</div>\n			&nbsp;&nbsp;&nbsp;&nbsp;\n			<div id="vvc_proceed" class="vk24-blue-gradient vvc-button-200px">Продолжить покупки</div>\n		</div>\n	</div>\n	<img class="vvc-window-rs" src="<%= httpHost %>/widget/img/rs.png"/>\n	<img class="vvc-window-otp" src="<%= httpHost %>/widget/img/otp.png"/>\n	<img class="vvc-window-hc" src="<%= httpHost %>/widget/img/hc.png"/>\n</div>'.replace(/[\n\t]/g, '');

  VVC.layout.creditInfoWithItem = '<div class="vvc-window vvc-credit-info-with-item">\n	<div class="vk24-widget-logo"></div>\n	<div class="vvc-window-close" id="vvc_close"></div>\n	<div class="vvc-window-title">Покупайте в кредит,<br/>не выходя из дома</div>\n	<div class="vvc-credit-info-window-content">\n		<div class="vvc-item-info">\n			<div class="vvc-item-name">Товар <b><%= item.name %></b></div>\n			<div>добавлен в корзину</div>\n			<div class="vvc-float-left vvc-item-sum-and-annuity-pay">\n				Стоимость <b><%= item.amount %> руб</b>\n			</div>\n			<div class="vvc-float-right vvc-item-sum-and-annuity-pay">\n				В кредит <b class="vvc-pay-border">от <%= Math.ceil(VVC.getAnnuityPay(item.amount)) %> руб/мес</b>\n			</div>\n		</div>\n		<ul class="vvc-list">\n			<li>Услуга кредитования доступна для граждан РФ старше 18 лет.</li>\n			<li>Кредитный договор подписываете у себя дома или на работе.</li>\n			<li>Сумма кредита от 2000 до 300&nbsp;000 рублей.</li>\n			<li>Выгодные условия по кредиту - переплата от 10%.</li>\n			<li>Банки принимают решение о выдаче кредита за 5 минут.</li>\n			<li>Оформление кредита бесплатно.</li>\n		</ul>\n		<div class="vvc-center">\n			<div id="vvc_basket" class="vk24-blue-gradient vvc-button-200px">Перейти в корзину</div>\n			&nbsp;&nbsp;&nbsp;&nbsp;\n			<div id="vvc_proceed" class="vk24-blue-gradient vvc-button-200px">Продолжить покупки</div>\n		</div>\n	</div>\n	<img class="vvc-window-rs" src="<%= httpHost %>/widget/img/rs.png"/>\n	<img class="vvc-window-otp" src="<%= httpHost %>/widget/img/otp.png"/>\n	<img class="vvc-window-hc" src="<%= httpHost %>/widget/img/hc.png"/>\n</div>'.replace(/[\n\t]/g, '');

  Cookie = (function() {

    function Cookie() {}

    Cookie.get = function(name) {
      var end, start, value;
      if (document.cookie.length > 0) {
        start = document.cookie.indexOf(name + '=');
        if (start > -1) {
          start = start + name.length + 1;
          end = document.cookie.indexOf(';', start);
          if (end === -1) {
            end = document.cookie.length;
          }
          value = decodeURIComponent(document.cookie.substring(start, end));
          return value;
        }
      }
    };

    Cookie.set = function(name, value, days, path, domain, secure) {
      var cookie;
      if (days == null) {
        days = 30;
      }
      if (path == null) {
        path = '/';
      }
      if (domain == null) {
        domain = location.hostname;
      }
      if (secure == null) {
        secure = false;
      }
      cookie = encodeURIComponent(name) + '=' + encodeURIComponent(value);
      cookie += '; max-age=' + (days * 24 * 60 * 60);
      cookie += '; path=' + path;
      cookie += '; domain=' + domain;
      if (secure) {
        cookie += '; secure';
      }
      document.cookie = cookie;
    };

    Cookie.remove = function(name, path, domain, secure) {
      this.set(name, '', 0, path, domain, secure);
    };

    Cookie.enabled = (function() {
      var enabled;
      if (navigator.cookieEnabled !== void 0) {
        enabled = navigator.cookieEnabled;
        return enabled;
      }
      document.cookie = 'testcookie=test; max-age=10000';
      enabled = !!~document.cookie.indexOf('testcookie=test');
      if (enabled) {
        document.cookie = 'testcookie=test; max-age=0';
      }
      return enabled;
    })();

    return Cookie;

  })();

  (function(a){"use strict",a.MaskedInput=function(b){if(!b||!b.elm||!b.format)return null;if(this instanceof a.MaskedInput){var c=this,d=b.elm,e=b.format,f=b.allowed||"0123456789",g=b.separator||"/:-",h=b.typeon||"_YMDhms",i=b.onbadkey||function(){},j=b.badkeywait||0,k=!1,l=e,m=function(a,b,c,d){return!window.addEventListener||!!document.all&&!window.opera?window.attachEvent?function(a,b,c){a.attachEvent("on"+b,c)}:function(a,b,c){a["on"+b]=c}:function(a,b,c,d){a.addEventListener(b,c,d===undefined?!1:d)}}(),n=function(){return!d.tagName||d.tagName.toUpperCase()!=="INPUT"&&d.tagName.toUpperCase()!=="TEXTAREA"?null:(d.value=e,m(d,"keydown",function(a){q(a)}),m(d,"keypress",function(a){r(a)}),m(d,"focus",function(){l=d.value}),m(d,"blur",function(){d.value!==l&&d.onchange&&d.onchange()}),c)},o=function(a){a=a||window.event;var b="",c=a.which,d=a.type;c==null&&(c=a.keyCode);if(c===null)return"";switch(c){case 8:b="bksp";break;case 46:b=d=="keydown"?"del":".";break;case 16:b="shift";break;case 0:case 9:case 13:b="etc";break;case 37:case 38:case 39:case 40:b=!a.shiftKey&&a.charCode!=39&&a.charCode!==undefined?"etc":String.fromCharCode(c);break;default:b=String.fromCharCode(c)}return b},p=function(a,b){a.preventDefault&&a.preventDefault(),a.returnValue=b||!1},q=function(a){a=a||event;if(k)return p(a),!1;var b=o(a);return!a.metaKey&&!a.ctrlKey||b!="X"&&b!="V"?a.metaKey||a.ctrlKey?!0:(d.value==""&&(d.value=e,u(d,0)),b=="bksp"||b=="del"?(s(b),p(a),!1):b=="etc"||b=="shift"?!0:(p(a,!0),!0)):(p(a),!1)},r=function(a){a=a||event;if(k)return p(a),!1;var b=o(a);return b=="etc"||a.metaKey||a.ctrlKey||a.altKey?!0:b!="bksp"&&b!="del"&&b!="shift"?v(b)?s(b)?(p(a,!0),!0):(p(a),!1):(p(a),!1):!1},s=function(a){var b=t(d),c=d.value,i="";switch(!0){case f.indexOf(a)!=-1:if(++b>e.length)return!1;while(g.indexOf(c.charAt(b-1))!=-1&&b<=e.length)b++;i=c.substr(0,b-1)+a+c.substr(b),f.indexOf(c.charAt(b))==-1&&h.indexOf(c.charAt(b))==-1&&b++;break;case a=="bksp":if(--b<0)return!1;while(f.indexOf(c.charAt(b))==-1&&h.indexOf(c.charAt(b))==-1&&b>1)b--;i=c.substr(0,b)+e.substr(b,1)+c.substr(b+1);break;case a=="del":if(b>=c.length)return!1;while(g.indexOf(c.charAt(b))!=-1&&c.charAt(b)!="")b++;i=c.substr(0,b)+e.substr(b,1)+c.substr(b+1),b++;break;case a=="etc":return!0;default:return!1}return d.value="",d.value=i,u(d,b),!1},t=function(a){try{if(a.selectionStart>=0)return a.selectionStart;if(document.selection){var b=a.value,c=document.selection.createRange();c.text="|%|";var d=a.value.indexOf("|%|");return c.moveStart("character",-3),c.text="",a.value=b,d}return-1}catch(e){return-1}},u=function(a,b){try{if(a.selectionStart)a.focus(),a.setSelectionRange(b,b);else if(a.createTextRange){var c=a.createTextRange();c.move("character",b),c.select()}}catch(d){return!1}return!0},v=function(a){if(f.indexOf(a)==-1&&a!="bksp"&&a!="del"&&a!="etc"){var b=t(d);return k=!0,i(),setTimeout(function(){k=!1,u(d,b)},j),!1}return!0};return c.resetField=function(){d.value=e},c.setAllowed=function(a){f=a,resetField()},c.setFormat=function(a){e=a,resetField()},c.setSeparator=function(a){g=a,resetField()},c.setTypeon=function(a){h=a,resetField()},n()}return new a.MaskedInput(b)}})(window);

}).call(this);

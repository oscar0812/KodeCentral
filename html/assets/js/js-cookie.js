/*!
 * JavaScript Cookie v2.2.0
 * https://github.com/js-cookie/js-cookie
 *
 * Copyright 2006, 2015 Klaus Hartl & Fagner Brack
 * Released under the MIT license
 */
;
(function(factory) {
  var registeredInModuleLoader = false;
  if (typeof define === 'function' && define.amd) {
    define(factory);
    registeredInModuleLoader = true;
  }
  if (typeof exports === 'object') {
    module.exports = factory();
    registeredInModuleLoader = true;
  }
  if (!registeredInModuleLoader) {
    var OldCookies = window.Cookies;
    var api = window.Cookies = factory();
    api.noConflict = function() {
      window.Cookies = OldCookies;
      return api;
    };
  }
}(function() {
  function extend() {
    var i = 0;
    var result = {};
    for (; i < arguments.length; i++) {
      var attributes = arguments[i];
      for (var key in attributes) {
        result[key] = attributes[key];
      }
    }
    return result;
  }

  function init(converter) {
    function api(key, value, attributes) {
      var result;
      if (typeof document === 'undefined') {
        return;
      }

      // Write

      if (arguments.length > 1) {
        attributes = extend({
          path: '/'
        }, api.defaults, attributes);

        if (typeof attributes.expires === 'number') {
          var expires = new Date();
          expires.setMilliseconds(expires.getMilliseconds() + attributes.expires * 864e+5);
          attributes.expires = expires;
        }

        // We're using "expires" because "max-age" is not supported by IE
        attributes.expires = attributes.expires ? attributes.expires.toUTCString() : '';

        try {
          result = JSON.stringify(value);
          if (/^[\{\[]/.test(result)) {
            value = result;
          }
        } catch (e) {}

        if (!converter.write) {
          value = encodeURIComponent(String(value))
            .replace(/%(23|24|26|2B|3A|3C|3E|3D|2F|3F|40|5B|5D|5E|60|7B|7D|7C)/g, decodeURIComponent);
        } else {
          value = converter.write(value, key);
        }

        key = encodeURIComponent(String(key));
        key = key.replace(/%(23|24|26|2B|5E|60|7C)/g, decodeURIComponent);
        key = key.replace(/[\(\)]/g, escape);

        var stringifiedAttributes = '';

        for (var attributeName in attributes) {
          if (!attributes[attributeName]) {
            continue;
          }
          stringifiedAttributes += '; ' + attributeName;
          if (attributes[attributeName] === true) {
            continue;
          }
          stringifiedAttributes += '=' + attributes[attributeName];
        }
        return (document.cookie = key + '=' + value + stringifiedAttributes);
      }

      // Read

      if (!key) {
        result = {};
      }

      // To prevent the for loop in the first place assign an empty array
      // in case there are no cookies at all. Also prevents odd result when
      // calling "get()"
      var cookies = document.cookie ? document.cookie.split('; ') : [];
      var rdecode = /(%[0-9A-Z]{2})+/g;
      var i = 0;

      for (; i < cookies.length; i++) {
        var parts = cookies[i].split('=');
        var cookie = parts.slice(1).join('=');

        if (!this.json && cookie.charAt(0) === '"') {
          cookie = cookie.slice(1, -1);
        }

        try {
          var name = parts[0].replace(rdecode, decodeURIComponent);
          cookie = converter.read ?
            converter.read(cookie, name) : converter(cookie, name) ||
            cookie.replace(rdecode, decodeURIComponent);

          if (this.json) {
            try {
              cookie = JSON.parse(cookie);
            } catch (e) {}
          }

          if (key === name) {
            result = cookie;
            break;
          }

          if (!key) {
            result[name] = cookie;
          }
        } catch (e) {}
      }

      return result;
    }

    api.set = api;
    api.get = function(key) {
      return api.call(api, key);
    };
    api.getJSON = function() {
      return api.apply({
        json: true
      }, [].slice.call(arguments));
    };
    api.defaults = {};

    api.remove = function(key, attributes) {
      api(key, '', extend(attributes, {
        expires: -1
      }));
    };

    api.withConverter = init;

    return api;
  }

  return init(function() {});
}));

$(function(){
  // load all the posts this person has seen
  cookie = Cookies.get('history');
  cookie = typeof cookie == 'undefined' ? '[]' : cookie;
  arr = $.parseJSON(cookie);

  link = $('body').attr('data-hyperlink');
  title = $('body').attr('data-title');

  archives = $('#archives');
  template = archives.find('.invisible').eq(0);

  in_list = false;
  arr.forEach(function(e) {
    if (e.link == link) {
      // already in list, just update the date
      e.date = new Date();
      in_list = true;
    } else {
      // now that were here, just append to the list
      copy = template.clone().removeClass('invisible').attr('href', e.link);
      copy.find('span').text(e.title);
      template.before(copy);
    }
  });

  // remove template
  archives.find('a[href="#"]').remove();

  // try to store this page on the page visited history
  if (!in_list) {
    arr.push({
      link: link,
      title: title,
      date: new Date()
    });
  }

  // sort by date, with newest date on top
  arr.sort(function(x, y) {
    var a = new Date(x.date),
      b = new Date(y.date);
    return b - a;
  });

  if (arr.length > 10) {
    arr.length = 10;
  }

  Cookies.set('history', JSON.stringify(arr), {
    expires: 30
  });

});

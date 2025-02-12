/*!
 * bsStepper v1.3.0 (https://github.com/Johann-S/bs-stepper)
 * Copyright 2018 Johann-S <johann.servoire@gmail.com>
 * Licensed under MIT (https://github.com/Johann-S/bs-stepper/blob/master/LICENSE)
 */
!(function (t, e) {
  "object" == typeof exports && "undefined" != typeof module ? (module.exports = e()) : "function" == typeof define && define.amd ? define(e) : (t.Stepper = e());
})(this, function () {
  "use strict";
  function i() {
    return (i =
      Object.assign ||
      function (t) {
        for (var e = 1; e < arguments.length; e++) {
          var n = arguments[e];
          for (var s in n) Object.prototype.hasOwnProperty.call(n, s) && (t[s] = n[s]);
        }
        return t;
      }).apply(this, arguments);
  }
  var n = window.Element.prototype.matches,
    r = function (t, e) {
      return t.closest(e);
    },
    o = function (t, e) {
      return new window.Event(t, e);
    };
  window.Element.prototype.matches || (n = window.Element.prototype.msMatchesSelector || window.Element.prototype.webkitMatchesSelector),
    window.Element.prototype.closest ||
      (r = function (t, e) {
        if (!document.documentElement.contains(t)) return null;
        do {
          if (n.call(t, e)) return t;
          t = t.parentElement || t.parentNode;
        } while (null !== t && 1 === t.nodeType);
        return null;
      }),
    (window.Event && "function" == typeof window.Event) ||
      (o = function (t, e) {
        e = e || {};
        var n = document.createEvent("Event");
        return n.initEvent(t, Boolean(e.bubbles), Boolean(e.cancelable)), n;
      });
  var c = ".step",
    a = ".step-trigger, a",
    l = ".bs-stepper",
    u = "active",
    d = "linear",
    p = "dstepper-block",
    h = "dstepper-none",
    f = "fade",
    _ = "transitionend",
    v = "bsStepper",
    m = function (t, e) {
      if (!t.classList.contains(u)) {
        var n = r(t, l),
          s = e.filter(function (t) {
            return t.classList.contains(u);
          });
        s.length && s[0].classList.remove(u),
          e.forEach(function (t) {
            var e = t.querySelector(a);
            e.setAttribute("aria-selected", "false"), n.classList.contains(d) && e.setAttribute("disabled", "disabled");
          }),
          t.classList.add(u);
        var i = t.querySelector(a);
        i.setAttribute("aria-selected", "true"), n.classList.contains(d) && i.removeAttribute("disabled");
      }
    },
    L = function (e, t) {
      if (!e.classList.contains(u)) {
        var n = t.filter(function (t) {
          return t.classList.contains(u);
        });
        if ((n.length && (n[0].classList.remove(u), n[0].classList.remove(p)), e.classList.contains(f))) {
          e.classList.remove(h);
          var s = E(e);
          e.addEventListener(_, function t() {
            e.classList.add(p), e.removeEventListener(_, t);
          }),
            n.length && n[0].classList.add(h),
            e.classList.add(u),
            w(e, s);
        } else e.classList.add(u);
      }
    },
    E = function (t) {
      if (!t) return 0;
      var e = window.getComputedStyle(t).transitionDuration;
      return parseFloat(e) ? ((e = e.split(",")[0]), 1e3 * parseFloat(e)) : 0;
    },
    w = function (t, e) {
      var n = !1,
        s = e + 5;
      function i() {
        (n = !0), t.removeEventListener(_, i);
      }
      t.addEventListener(_, i),
        window.setTimeout(function () {
          n || t.dispatchEvent(o(_)), t.removeEventListener(_, i);
        }, s);
    };
  function s(t) {
    t.preventDefault();
  }
  function y(t) {
    t.preventDefault();
    var e = r(t.target, c),
      n = r(e, l)[v],
      s = n._steps.indexOf(e);
    (n._currentIndex = s), m(e, n._steps), L(n._stepsContents[s], n._stepsContents);
  }
  var b = { linear: !0, animation: !1 };
  return (function () {
    function t(t, e) {
      var n,
        s = this;
      void 0 === e && (e = {}),
        (this._element = t),
        (this._currentIndex = 0),
        (this._stepsContents = []),
        (this._steps = [].slice.call(this._element.querySelectorAll(c)).filter(function (t) {
          return t.hasAttribute("data-target");
        })),
        this._steps.forEach(function (t) {
          s._stepsContents.push(s._element.querySelector(t.getAttribute("data-target")));
        }),
        (this.options = i({}, b, e)),
        this.options.linear && this._element.classList.add(d),
        (n = this._stepsContents),
        this.options.animation &&
          n.forEach(function (t) {
            t.classList.add(f), t.classList.add(h);
          }),
        this._steps.length && (m(this._steps[this._currentIndex], this._steps), L(this._stepsContents[this._currentIndex], this._stepsContents)),
        this._setLinkListeners(),
        Object.defineProperty(this._element, v, { value: this, writable: !0 });
    }
    var e = t.prototype;
    return (
      (e._setLinkListeners = function () {
        var n = this;
        this._steps.forEach(function (t) {
          var e = t.querySelector(a);
          n.options.linear ? e.addEventListener("click", s) : e.addEventListener("click", y);
        });
      }),
      (e.next = function () {
        (this._currentIndex = this._currentIndex + 1 <= this._steps.length - 1 ? this._currentIndex + 1 : this._steps.length - 1), m(this._steps[this._currentIndex], this._steps), L(this._stepsContents[this._currentIndex], this._stepsContents);
      }),
      (e.previous = function () {
        (this._currentIndex = 0 <= this._currentIndex - 1 ? this._currentIndex - 1 : 0), m(this._steps[this._currentIndex], this._steps), L(this._stepsContents[this._currentIndex], this._stepsContents);
      }),
      (e.reset = function () {
        (this._currentIndex = 0), m(this._steps[this._currentIndex], this._steps), L(this._stepsContents[this._currentIndex], this._stepsContents);
      }),
      (e.destroy = function () {
        var n = this;
        this._steps.forEach(function (t) {
          var e = t.querySelector(a);
          n.options.linear ? e.removeEventListener("click", s) : e.removeEventListener("click", y);
        }),
          (this._element[v] = void 0),
          (this._element = void 0),
          (this._currentIndex = void 0),
          (this._steps = void 0),
          (this._stepsContents = void 0);
      }),
      t
    );
  })();
});
//# sourceMappingURL=bs-stepper.min.js.map

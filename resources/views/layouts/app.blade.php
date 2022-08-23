<!doctype html>
<html lang="en-US">
  <meta http-equiv="content-type" content="text/html;charset=UTF-8" />
  <head>
    <script>
      class RocketLazyLoadScripts {
        constructor(e) {
          this.triggerEvents = e, this.eventOptions = {
            passive: !0
          }, this.userEventListener = this.triggerListener.bind(this), this.delayedScripts = {
            normal: [],
            async: [],
            defer: []
          }, this.allJQueries = []
        }
        _addUserInteractionListener(e) {
          this.triggerEvents.forEach((t => window.addEventListener(t, e.userEventListener, e.eventOptions)))
        }
        _removeUserInteractionListener(e) {
          this.triggerEvents.forEach((t => window.removeEventListener(t, e.userEventListener, e.eventOptions)))
        }
        triggerListener() {
          this._removeUserInteractionListener(this), "loading" === document.readyState ? document.addEventListener("DOMContentLoaded", this._loadEverythingNow.bind(this)) : this._loadEverythingNow()
        }
        async _loadEverythingNow() {
          this._delayEventListeners(), this._delayJQueryReady(this), this._handleDocumentWrite(), this._registerAllDelayedScripts(), this._preloadAllScripts(), await this._loadScriptsFromList(this.delayedScripts.normal), await this._loadScriptsFromList(this.delayedScripts.defer), await this._loadScriptsFromList(this.delayedScripts.async), await this._triggerDOMContentLoaded(), await this._triggerWindowLoad(), window.dispatchEvent(new Event("rocket-allScriptsLoaded"))
        }
        _registerAllDelayedScripts() {
          document.querySelectorAll("script[type=rocketlazyloadscript]").forEach((e => {
            e.hasAttribute("src") ? e.hasAttribute("async") && !1 !== e.async ? this.delayedScripts.async.push(e) : e.hasAttribute("defer") && !1 !== e.defer || "module" === e.getAttribute("data-rocket-type") ? this.delayedScripts.defer.push(e) : this.delayedScripts.normal.push(e) : this.delayedScripts.normal.push(e)
          }))
        }
        async _transformScript(e) {
          return await this._requestAnimFrame(), new Promise((t => {
            const n = document.createElement("script");
            let r;
            [...e.attributes].forEach((e => {
              let t = e.nodeName;
              "type" !== t && ("data-rocket-type" === t && (t = "type", r = e.nodeValue), n.setAttribute(t, e.nodeValue))
            })), e.hasAttribute("src") ? (n.addEventListener("load", t), n.addEventListener("error", t)) : (n.text = e.text, t()), e.parentNode.replaceChild(n, e)
          }))
        }
        async _loadScriptsFromList(e) {
          const t = e.shift();
          return t ? (await this._transformScript(t), this._loadScriptsFromList(e)) : Promise.resolve()
        }
        _preloadAllScripts() {
          var e = document.createDocumentFragment();
          [...this.delayedScripts.normal, ...this.delayedScripts.defer, ...this.delayedScripts.async].forEach((t => {
            const n = t.getAttribute("src");
            if (n) {
              const t = document.createElement("link");
              t.href = n, t.rel = "preload", t.as = "script", e.appendChild(t)
            }
          })), document.head.appendChild(e)
        }
        _delayEventListeners() {
          let e = {};

          function t(t, n) {
            ! function(t) {
              function n(n) {
                return e[t].eventsToRewrite.indexOf(n) >= 0 ? "rocket-" + n : n
              }
              e[t] || (e[t] = {
                originalFunctions: {
                  add: t.addEventListener,
                  remove: t.removeEventListener
                },
                eventsToRewrite: []
              }, t.addEventListener = function() {
                arguments[0] = n(arguments[0]), e[t].originalFunctions.add.apply(t, arguments)
              }, t.removeEventListener = function() {
                arguments[0] = n(arguments[0]), e[t].originalFunctions.remove.apply(t, arguments)
              })
            }(t), e[t].eventsToRewrite.push(n)
          }

          function n(e, t) {
            let n = e[t];
            Object.defineProperty(e, t, {
              get: () => n || function() {},
              set(r) {
                e["rocket" + t] = n = r
              }
            })
          }
          t(document, "DOMContentLoaded"), t(window, "DOMContentLoaded"), t(window, "load"), t(window, "pageshow"), t(document, "readystatechange"), n(document, "onreadystatechange"), n(window, "onload"), n(window, "onpageshow")
        }
        _delayJQueryReady(e) {
          let t = window.jQuery;
          Object.defineProperty(window, "jQuery", {
            get: () => t,
            set(n) {
              if (n && n.fn && !e.allJQueries.includes(n)) {
                n.fn.ready = n.fn.init.prototype.ready = function(t) {
                  e.domReadyFired ? t.bind(document)(n) : document.addEventListener("rocket-DOMContentLoaded", (() => t.bind(document)(n)))
                };
                const t = n.fn.on;
                n.fn.on = n.fn.init.prototype.on = function() {
                  if (this[0] === window) {
                    function e(e) {
                      return e.split(" ").map((e => "load" === e || 0 === e.indexOf("load.") ? "rocket-jquery-load" : e)).join(" ")
                    }
                    "string" == typeof arguments[0] || arguments[0] instanceof String ? arguments[0] = e(arguments[0]) : "object" == typeof arguments[0] && Object.keys(arguments[0]).forEach((t => {
                      delete Object.assign(arguments[0], {
                        [e(t)]: arguments[0][t]
                      })[t]
                    }))
                  }
                  return t.apply(this, arguments), this
                }, e.allJQueries.push(n)
              }
              t = n
            }
          })
        }
        async _triggerDOMContentLoaded() {
          this.domReadyFired = !0, await this._requestAnimFrame(), document.dispatchEvent(new Event("rocket-DOMContentLoaded")), await this._requestAnimFrame(), window.dispatchEvent(new Event("rocket-DOMContentLoaded")), await this._requestAnimFrame(), document.dispatchEvent(new Event("rocket-readystatechange")), await this._requestAnimFrame(), document.rocketonreadystatechange && document.rocketonreadystatechange()
        }
        async _triggerWindowLoad() {
          await this._requestAnimFrame(), window.dispatchEvent(new Event("rocket-load")), await this._requestAnimFrame(), window.rocketonload && window.rocketonload(), await this._requestAnimFrame(), this.allJQueries.forEach((e => e(window).trigger("rocket-jquery-load"))), window.dispatchEvent(new Event("rocket-pageshow")), await this._requestAnimFrame(), window.rocketonpageshow && window.rocketonpageshow()
        }
        _handleDocumentWrite() {
          const e = new Map;
          document.write = document.writeln = function(t) {
            const n = document.currentScript,
              r = document.createRange(),
              i = n.parentElement;
            let o = e.get(n);
            void 0 === o && (o = n.nextSibling, e.set(n, o));
            const a = document.createDocumentFragment();
            r.setStart(a, 0), a.appendChild(r.createContextualFragment(t)), i.insertBefore(a, o)
          }
        }
        async _requestAnimFrame() {
          return new Promise((e => requestAnimationFrame(e)))
        }
        static run() {
          const e = new RocketLazyLoadScripts(["keydown", "mousemove", "touchmove", "touchstart", "touchend", "wheel"]);
          e._addUserInteractionListener(e)
        }
      }
      RocketLazyLoadScripts.run();
    </script>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="profile" href="http://gmpg.org/xfn/11">
    <title>Ecare Products</title>
    <style id="rocket-critical-css">
      .bhf-hidden {
        display: none
      }

      .ehf-header #masthead {
        z-index: 99;
        position: relative
      }

      .screen-reader-text {
        position: absolute;
        top: -10000em;
        width: 1px;
        height: 1px;
        margin: -1px;
        padding: 0;
        overflow: hidden;
        clip: rect(0, 0, 0, 0);
        border: 0
      }

      .elementor {
        -webkit-hyphens: manual;
        -ms-hyphens: manual;
        hyphens: manual
      }

      .elementor *,
      .elementor :after,
      .elementor :before {
        -webkit-box-sizing: border-box;
        box-sizing: border-box
      }

      .elementor a {
        -webkit-box-shadow: none;
        box-shadow: none;
        text-decoration: none
      }

      .elementor img {
        height: auto;
        max-width: 100%;
        border: none;
        -webkit-border-radius: 0;
        border-radius: 0;
        -webkit-box-shadow: none;
        box-shadow: none
      }

      .elementor-widget-wrap .elementor-element.elementor-widget__width-auto,
      .elementor-widget-wrap .elementor-element.elementor-widget__width-initial {
        max-width: 100%
      }

      @media (max-width:1024px) {
        .elementor-widget-wrap .elementor-element.elementor-widget-tablet__width-initial {
          max-width: 100%
        }
      }

      @media (max-width:767px) {
        .elementor-widget-wrap .elementor-element.elementor-widget-mobile__width-auto {
          max-width: 100%
        }
      }

      :root {
        --page-title-display: block
      }

      .elementor-section {
        position: relative
      }

      .elementor-section .elementor-container {
        display: -webkit-box;
        display: -ms-flexbox;
        display: flex;
        margin-right: auto;
        margin-left: auto;
        position: relative
      }

      @media (max-width:1024px) {
        .elementor-section .elementor-container {
          -ms-flex-wrap: wrap;
          flex-wrap: wrap
        }
      }

      .elementor-section.elementor-section-boxed>.elementor-container {
        max-width: 1140px
      }

      .elementor-section.elementor-section-stretched {
        position: relative;
        width: 100%
      }

      .elementor-section.elementor-section-items-middle>.elementor-container {
        -webkit-box-align: center;
        -ms-flex-align: center;
        align-items: center
      }

      .elementor-widget-wrap {
        position: relative;
        width: 100%;
        -ms-flex-wrap: wrap;
        flex-wrap: wrap;
        -ms-flex-line-pack: start;
        align-content: flex-start
      }

      .elementor:not(.elementor-bc-flex-widget) .elementor-widget-wrap {
        display: -webkit-box;
        display: -ms-flexbox;
        display: flex
      }

      .elementor-widget-wrap>.elementor-element {
        width: 100%
      }

      .elementor-widget {
        position: relative
      }

      .elementor-widget:not(:last-child) {
        margin-bottom: 20px
      }

      .elementor-widget:not(:last-child).elementor-widget__width-auto {
        margin-bottom: 0
      }

      .elementor-column {
        min-height: 1px
      }

      .elementor-column {
        position: relative;
        display: -webkit-box;
        display: -ms-flexbox;
        display: flex
      }

      @media (min-width:768px) {
        .elementor-column.elementor-col-25 {
          width: 25%
        }

        .elementor-column.elementor-col-50 {
          width: 50%
        }

        .elementor-column.elementor-col-100 {
          width: 100%
        }
      }

      @media (max-width:767px) {
        .elementor-column {
          width: 100%
        }
      }

      .elementor-view-stacked .elementor-icon {
        padding: .5em;
        background-color: #818a91;
        color: #fff;
        fill: #fff
      }

      .elementor-icon {
        display: inline-block;
        line-height: 1;
        color: #818a91;
        font-size: 50px;
        text-align: center
      }

      .elementor-icon i {
        width: 1em;
        height: 1em;
        position: relative;
        display: block
      }

      .elementor-icon i:before {
        position: absolute;
        left: 50%;
        -webkit-transform: translateX(-50%);
        -ms-transform: translateX(-50%);
        transform: translateX(-50%)
      }

      .elementor-shape-circle .elementor-icon {
        -webkit-border-radius: 50%;
        border-radius: 50%
      }

      .elementor .elementor-element ul.elementor-icon-list-items {
        padding: 0
      }

      @media (max-width:767px) {
        .elementor .elementor-hidden-phone {
          display: none
        }
      }

      @media (min-width:768px) and (max-width:1024px) {
        .elementor .elementor-hidden-tablet {
          display: none
        }
      }

      @media (min-width:1025px) and (max-width:99999px) {
        .elementor .elementor-hidden-desktop {
          display: none
        }
      }

      @media (min-width:768px) {
        .elementor-widget-icon-box.elementor-position-left .elementor-icon-box-wrapper {
          display: -webkit-box;
          display: -ms-flexbox;
          display: flex
        }

        .elementor-widget-icon-box.elementor-position-left .elementor-icon-box-icon {
          display: -webkit-inline-box;
          display: -ms-inline-flexbox;
          display: inline-flex;
          -webkit-box-flex: 0;
          -ms-flex: 0 0 auto;
          flex: 0 0 auto
        }

        .elementor-widget-icon-box.elementor-position-left .elementor-icon-box-wrapper {
          text-align: left;
          -webkit-box-orient: horizontal;
          -webkit-box-direction: normal;
          -ms-flex-direction: row;
          flex-direction: row
        }

        .elementor-widget-icon-box.elementor-vertical-align-top .elementor-icon-box-wrapper {
          -webkit-box-align: start;
          -ms-flex-align: start;
          align-items: flex-start
        }

        .elementor-widget-icon-box.elementor-vertical-align-middle .elementor-icon-box-wrapper {
          -webkit-box-align: center;
          -ms-flex-align: center;
          align-items: center
        }
      }

      @media (max-width:767px) {
        .elementor-widget-icon-box .elementor-icon-box-icon {
          margin-left: auto !important;
          margin-right: auto !important;
          margin-bottom: 15px
        }
      }

      .elementor-widget-icon-box .elementor-icon-box-wrapper {
        text-align: center
      }

      .elementor-widget-icon-box .elementor-icon-box-title a {
        color: inherit
      }

      .elementor-widget-icon-box .elementor-icon-box-content {
        -webkit-box-flex: 1;
        -ms-flex-positive: 1;
        flex-grow: 1
      }

      .elementor-widget .elementor-icon-list-items {
        list-style-type: none;
        margin: 0;
        padding: 0
      }

      .elementor-widget .elementor-icon-list-item {
        margin: 0;
        padding: 0;
        position: relative
      }

      .elementor-widget .elementor-icon-list-item:after {
        position: absolute;
        bottom: 0;
        width: 100%
      }

      .elementor-widget .elementor-icon-list-item,
      .elementor-widget .elementor-icon-list-item a {
        display: -webkit-box;
        display: -ms-flexbox;
        display: flex;
        -webkit-box-align: center;
        -ms-flex-align: center;
        align-items: center;
        font-size: inherit
      }

      .elementor-widget .elementor-icon-list-icon+.elementor-icon-list-text {
        -ms-flex-item-align: center;
        align-self: center;
        padding-left: 5px
      }

      .elementor-widget .elementor-icon-list-icon {
        display: -webkit-box;
        display: -ms-flexbox;
        display: flex
      }

      .elementor-widget .elementor-icon-list-icon i {
        width: 1.25em;
        font-size: var(--e-icon-list-icon-size)
      }

      .elementor-widget.elementor-widget-icon-list .elementor-icon-list-icon {
        text-align: var(--e-icon-list-icon-align)
      }

      .elementor-widget.elementor-list-item-link-full_width a {
        width: 100%
      }

      .elementor-widget:not(.elementor-align-right) .elementor-icon-list-item:after {
        left: 0
      }

      .elementor-widget:not(.elementor-align-left) .elementor-icon-list-item:after {
        right: 0
      }

      @media (max-width:1024px) {
        .elementor-widget:not(.elementor-tablet-align-right) .elementor-icon-list-item:after {
          left: 0
        }

        .elementor-widget:not(.elementor-tablet-align-left) .elementor-icon-list-item:after {
          right: 0
        }
      }

      @media (max-width:767px) {
        .elementor-widget:not(.elementor-mobile-align-right) .elementor-icon-list-item:after {
          left: 0
        }

        .elementor-widget:not(.elementor-mobile-align-left) .elementor-icon-list-item:after {
          right: 0
        }
      }

      .elementor-kit-11 {
        --e-global-color-primary: #5C9963;
        --e-global-color-primary_hover: #528959;
        --e-global-color-secondary: #FFA900;
        --e-global-color-secondary_hover: #ff8d00;
        --e-global-color-text: #656766;
        --e-global-color-accent: #2F3E30;
        --e-global-color-border: #E4E4E4;
        --e-global-color-light: #9f9f9f;
        --e-global-typography-heading_title-font-family: "Poppins";
        --e-global-typography-heading_title-font-size: 30px;
        --e-global-typography-heading_title-font-weight: 600;
        --e-global-typography-heading_title-line-height: 40px;
        --e-global-typography-heading_text-font-family: "Poppins";
        --e-global-typography-heading_text-font-size: 24px;
        --e-global-typography-heading_text-font-weight: 600;
        --e-global-typography-heading_text-line-height: 34px;
        --e-global-typography-heading_banner-font-family: "Poppins";
        --e-global-typography-heading_banner-font-size: 24px;
        --e-global-typography-heading_banner-font-weight: 600;
        --e-global-typography-heading_banner-line-height: 30px;
        --e-global-typography-heading_footer-font-family: "Poppins";
        --e-global-typography-heading_footer-font-size: 16px;
        --e-global-typography-heading_footer-font-weight: 700;
        --e-global-typography-heading_footer-text-transform: uppercase;
        --e-global-typography-heading_footer-line-height: 20px
      }

      .elementor-section.elementor-section-boxed>.elementor-container {
        max-width: 1290px
      }

      .elementor-widget:not(:last-child) {
        margin-bottom: 0px
      }

      @media (max-width:1024px) {
        .elementor-kit-11 {
          --e-global-typography-heading_title-font-size: 30px
        }

        .elementor-section.elementor-section-boxed>.elementor-container {
          max-width: 1024px
        }
      }

      @media (max-width:767px) {
        .elementor-kit-11 {
          --e-global-typography-heading_title-font-size: 24px;
          --e-global-typography-heading_title-line-height: 34px;
          --e-global-typography-heading_text-font-size: 20px;
          --e-global-typography-heading_text-line-height: 30px
        }

        .elementor-section.elementor-section-boxed>.elementor-container {
          max-width: 767px
        }
      }

      .elementor-widget-text-editor {
        color: var(--e-global-color-text)
      }

      .elementor-widget-icon-box.elementor-view-stacked .elementor-icon {
        background-color: var(--e-global-color-primary)
      }

      .elementor-widget-icon-box.elementor-view-default .elementor-icon {
        fill: var(--e-global-color-primary);
        color: var(--e-global-color-primary);
        border-color: var(--e-global-color-primary)
      }

      .elementor-widget-icon-box .elementor-icon-box-title {
        color: var(--e-global-color-primary)
      }

      .elementor-widget-icon-list .elementor-icon-list-icon i {
        color: var(--e-global-color-primary)
      }

      .elementor-widget-icon-list .elementor-icon-list-text {
        color: var(--e-global-color-secondary)
      }

      .elementor-widget-site-logo .hfe-site-logo-container .hfe-site-logo-img {
        border-color: var(--e-global-color-primary)
      }

      .elementor-312 .elementor-element.elementor-element-a89c10d>.elementor-container {
        min-height: 600px
      }

      .elementor-312 .elementor-element.elementor-element-a89c10d:not(.elementor-motion-effects-element-type-background) {
        background-color: #F2BF41
      }

      .elementor-312 .elementor-element.elementor-element-a89c10d {
        margin-top: 0px;
        margin-bottom: 50px
      }

      .elementor-312 .elementor-element.elementor-element-083eee1>.elementor-container {
        max-width: 1320px
      }

      .elementor-312 .elementor-element.elementor-element-083eee1 {
        margin-top: 0px;
        margin-bottom: 65px;
        padding: 0px 15px 0px 15px
      }

      .elementor-312 .elementor-element.elementor-element-15079ac:not(.elementor-motion-effects-element-type-background)>.elementor-widget-wrap {
        background-color: #E5EDBE;
        background-image: url("../../demothemedh.b-cdn.net/organey/wp-content/uploads/2021/08/h1-bg-1.jpg");
        background-position: top left;
        background-repeat: no-repeat;
        background-size: cover
      }

      .elementor-312 .elementor-element.elementor-element-15079ac>.elementor-element-populated {
        border-radius: 8px 8px 8px 8px
      }

      .elementor-312 .elementor-element.elementor-element-15079ac>.elementor-element-populated {
        margin: 0px 15px 0px 15px;
        --e-column-margin-right: 15px;
        --e-column-margin-left: 15px;
        padding: 30px 30px 30px 30px
      }

      .elementor-312 .elementor-element.elementor-element-7082419:not(.elementor-motion-effects-element-type-background)>.elementor-widget-wrap {
        background-color: #CFEBD2;
        background-image: url("../../demothemedh.b-cdn.net/organey/wp-content/uploads/2021/08/h1-bg-2.jpg");
        background-position: top left;
        background-repeat: no-repeat;
        background-size: cover
      }

      .elementor-312 .elementor-element.elementor-element-7082419>.elementor-element-populated {
        border-radius: 8px 8px 8px 8px
      }

      .elementor-312 .elementor-element.elementor-element-7082419>.elementor-element-populated {
        margin: 0px 15px 0px 15px;
        --e-column-margin-right: 15px;
        --e-column-margin-left: 15px;
        padding: 30px 30px 30px 30px
      }

      .elementor-312 .elementor-element.elementor-element-b1e4119:not(.elementor-motion-effects-element-type-background)>.elementor-widget-wrap {
        background-color: #D3E9F2;
        background-image: url("../../demothemedh.b-cdn.net/organey/wp-content/uploads/2021/08/h1-bg-3.jpg");
        background-position: top left;
        background-repeat: no-repeat;
        background-size: cover
      }

      .elementor-312 .elementor-element.elementor-element-b1e4119>.elementor-element-populated {
        border-radius: 8px 8px 8px 8px
      }

      .elementor-312 .elementor-element.elementor-element-b1e4119>.elementor-element-populated {
        margin: 0px 15px 0px 15px;
        --e-column-margin-right: 15px;
        --e-column-margin-left: 15px;
        padding: 30px 30px 30px 30px
      }

      .elementor-312 .elementor-element.elementor-element-8a4e6f4:not(.elementor-motion-effects-element-type-background)>.elementor-widget-wrap {
        background-color: #F9D0A8;
        background-image: url("../../demothemedh.b-cdn.net/organey/wp-content/uploads/2021/08/h1-bg-4.jpg");
        background-position: top left;
        background-repeat: no-repeat;
        background-size: cover
      }

      .elementor-312 .elementor-element.elementor-element-8a4e6f4>.elementor-element-populated {
        border-radius: 8px 8px 8px 8px
      }

      .elementor-312 .elementor-element.elementor-element-8a4e6f4>.elementor-element-populated {
        margin: 0px 15px 0px 15px;
        --e-column-margin-right: 15px;
        --e-column-margin-left: 15px;
        padding: 30px 30px 30px 30px
      }

      @media (min-width:1024px) {}

      .elementor-312 .elementor-element.elementor-element-5d83ce0 ul.products li.product {
        padding-left: calc(30px / 2);
        padding-right: calc(30px / 2);
        padding-top: calc(30px / 2);
        padding-bottom: calc(30px / 2);
        margin-bottom: 30px
      }

      .elementor-312 .elementor-element.elementor-element-5d83ce0 ul.products {
        margin-left: calc(30px / -2);
        margin-right: calc(30px / -2)
      }

      :root {
        --page-title-display: none
      }

      @media (max-width:1024px) {
        .elementor-312 .elementor-element.elementor-element-a89c10d {
          margin-top: 0px;
          margin-bottom: 30px
        }

        .elementor-312 .elementor-element.elementor-element-15079ac:not(.elementor-motion-effects-element-type-background)>.elementor-widget-wrap {
          background-position: bottom right;
          background-size: contain
        }

        .elementor-312 .elementor-element.elementor-element-15079ac>.elementor-element-populated {
          margin: 0px 15px 30px 15px;
          --e-column-margin-right: 15px;
          --e-column-margin-left: 15px
        }

        .elementor-312 .elementor-element.elementor-element-7082419:not(.elementor-motion-effects-element-type-background)>.elementor-widget-wrap {
          background-position: bottom right;
          background-size: contain
        }

        .elementor-312 .elementor-element.elementor-element-7082419>.elementor-element-populated {
          margin: 0px 15px 30px 15px;
          --e-column-margin-right: 15px;
          --e-column-margin-left: 15px
        }

        .elementor-312 .elementor-element.elementor-element-b1e4119:not(.elementor-motion-effects-element-type-background)>.elementor-widget-wrap {
          background-position: bottom right;
          background-size: contain
        }

        .elementor-312 .elementor-element.elementor-element-8a4e6f4:not(.elementor-motion-effects-element-type-background)>.elementor-widget-wrap {
          background-position: bottom right;
          background-size: contain
        }
      }

      @media (max-width:767px) {
        .elementor-312 .elementor-element.elementor-element-a89c10d>.elementor-container {
          min-height: 0px
        }

        .elementor-312 .elementor-element.elementor-element-a89c10d {
          margin-top: 0px;
          margin-bottom: 15px
        }

        .elementor-312 .elementor-element.elementor-element-15079ac>.elementor-element-populated {
          margin: 0px 0px 15px 0px;
          --e-column-margin-right: 0px;
          --e-column-margin-left: 0px
        }

        .elementor-312 .elementor-element.elementor-element-7082419>.elementor-element-populated {
          margin: 0px 0px 15px 0px;
          --e-column-margin-right: 0px;
          --e-column-margin-left: 0px
        }

        .elementor-312 .elementor-element.elementor-element-b1e4119>.elementor-element-populated {
          margin: 0px 0px 15px 0px;
          --e-column-margin-right: 0px;
          --e-column-margin-left: 0px
        }

        .elementor-312 .elementor-element.elementor-element-8a4e6f4>.elementor-element-populated {
          margin: 0px 0px 0px 0px;
          --e-column-margin-right: 0px;
          --e-column-margin-left: 0px
        }
      }

      @media (max-width:1024px) and (min-width:768px) {
        .elementor-312 .elementor-element.elementor-element-15079ac {
          width: 50%
        }

        .elementor-312 .elementor-element.elementor-element-7082419 {
          width: 50%
        }

        .elementor-312 .elementor-element.elementor-element-b1e4119 {
          width: 50%
        }

        .elementor-312 .elementor-element.elementor-element-8a4e6f4 {
          width: 50%
        }
      }

      .elementor-2671 .elementor-element.elementor-element-af6726c>.elementor-container {
        min-height: 52px
      }

      .elementor-2671 .elementor-element.elementor-element-af6726c:not(.elementor-motion-effects-element-type-background) {
        background-color: #F2F7F3
      }

      .elementor-2671 .elementor-element.elementor-element-af6726c {
        padding: 0px 30px 0px 30px
      }

      .elementor-2671 .elementor-element.elementor-element-b98f57f.elementor-column.elementor-element[data-element_type="column"]>.elementor-widget-wrap.elementor-element-populated {
        align-content: center;
        align-items: center
      }

      .elementor-2671 .elementor-element.elementor-element-68f4b3a {
        font-size: 14px;
        width: auto;
        max-width: auto
      }

      .elementor-2671 .elementor-element.elementor-element-68f4b3a>.elementor-widget-container {
        margin: 0px 25px 0px 0px
      }

      .elementor-2671 .elementor-element.elementor-element-a65e258 {
        width: auto;
        max-width: auto
      }

      .elementor-2671 .elementor-element.elementor-element-9846d73 {
        --e-icon-list-icon-size: 16px;
        width: auto;
        max-width: auto
      }

      .elementor-2671 .elementor-element.elementor-element-9846d73 .elementor-icon-list-text {
        color: var(--e-global-color-text);
        padding-left: 0px
      }

      .elementor-2671 .elementor-element.elementor-element-9846d73 .elementor-icon-list-item>a {
        font-size: 14px
      }

      .elementor-2671 .elementor-element.elementor-element-9846d73>.elementor-widget-container {
        margin: 0px 25px 0px 0px
      }

      .elementor-2671 .elementor-element.elementor-element-5121a88.elementor-column.elementor-element[data-element_type="column"]>.elementor-widget-wrap.elementor-element-populated {
        align-content: center;
        align-items: center
      }

      .elementor-2671 .elementor-element.elementor-element-5121a88.elementor-column>.elementor-widget-wrap {
        justify-content: flex-end
      }

      .elementor-2671 .elementor-element.elementor-element-e00c387 .elementor-icon-list-icon i {
        color: #5C9963
      }

      .elementor-2671 .elementor-element.elementor-element-e00c387 {
        --e-icon-list-icon-size: 16px;
        width: auto;
        max-width: auto
      }

      .elementor-2671 .elementor-element.elementor-element-e00c387 .elementor-icon-list-icon {
        padding: 7px 6px 7px 6px;
        border-radius: 50% 50% 50% 50%;
        background-color: #D9E8DB
      }

      .elementor-2671 .elementor-element.elementor-element-e00c387 .elementor-icon-list-text {
        color: var(--e-global-color-text);
        padding-left: 8px
      }

      .elementor-2671 .elementor-element.elementor-element-e00c387 .elementor-icon-list-item>a {
        font-size: 14px
      }

      .elementor-2671 .elementor-element.elementor-element-e00c387>.elementor-widget-container {
        margin: 0px 25px 0px 0px
      }

      .elementor-2671 .elementor-element.elementor-element-6873689 .site-header-account {
        text-align: left
      }

      .elementor-2671 .elementor-element.elementor-element-6873689 {
        width: auto;
        max-width: auto
      }

      .elementor-2671 .elementor-element.elementor-element-29edce1>.elementor-container {
        min-height: 120px
      }

      .elementor-2671 .elementor-element.elementor-element-29edce1 {
        padding: 0px 30px 0px 30px
      }

      .elementor-2671 .elementor-element.elementor-element-8d3cf4b.elementor-column.elementor-element[data-element_type="column"]>.elementor-widget-wrap.elementor-element-populated {
        align-content: center;
        align-items: center
      }

      .elementor-2671 .elementor-element.elementor-element-0970d68 {
        width: auto;
        max-width: auto
      }

      .elementor-2671 .elementor-element.elementor-element-bd2d5fd .hfe-site-logo-container {
        text-align: center
      }

      .elementor-2671 .elementor-element.elementor-element-bd2d5fd .hfe-site-logo-container .hfe-site-logo-img {
        border-style: none
      }

      .elementor-2671 .elementor-element.elementor-element-bd2d5fd {
        width: auto;
        max-width: auto
      }

      .elementor-2671 .elementor-element.elementor-element-e0920c1 .site-header-cart {
        text-align: left
      }

      .elementor-2671 .elementor-element.elementor-element-e0920c1 {
        width: auto;
        max-width: auto
      }

      .elementor-2671 .elementor-element.elementor-element-8541004 .site-header-cart {
        text-align: left
      }

      .elementor-2671 .elementor-element.elementor-element-8541004 {
        width: auto;
        max-width: auto
      }

      .elementor-2671 .elementor-element.elementor-element-c52ed2c.elementor-column>.elementor-widget-wrap {
        justify-content: center
      }

      .elementor-2671 .elementor-element.elementor-element-7cb6566.elementor-column.elementor-element[data-element_type="column"]>.elementor-widget-wrap.elementor-element-populated {
        align-content: center;
        align-items: center
      }

      .elementor-2671 .elementor-element.elementor-element-7cb6566.elementor-column>.elementor-widget-wrap {
        justify-content: flex-end
      }

      .elementor-2671 .elementor-element.elementor-element-6084eec .site-header-wishlist {
        text-align: left
      }

      .elementor-2671 .elementor-element.elementor-element-6084eec>.elementor-widget-container {
        margin: 0px 20px 0px 0px
      }

      .elementor-2671 .elementor-element.elementor-element-6084eec {
        width: auto;
        max-width: auto
      }

      .elementor-2671 .elementor-element.elementor-element-74d971b .site-header-cart {
        text-align: left
      }

      .elementor-2671 .elementor-element.elementor-element-74d971b {
        width: auto;
        max-width: auto
      }

      .elementor-2671 .elementor-element.elementor-element-0372de8:not(.elementor-motion-effects-element-type-background) {
        background-color: #3D6642
      }

      .elementor-2671 .elementor-element.elementor-element-0372de8 {
        padding: 6px 30px 6px 30px
      }

      .elementor-2671 .elementor-element.elementor-element-d0015e7>.elementor-element-populated {
        padding: 0px 15px 0px 0px
      }

      .elementor-2671 .elementor-element.elementor-element-300b8db .vertical-navigation {
        background-color: var(--e-global-color-primary);
        border-radius: 8px 8px 8px 8px
      }

      .elementor-2671 .elementor-element.elementor-element-300b8db .vertical-navigation ul.menu>li>a {
        font-size: 14px
      }

      .elementor-2671 .elementor-element.elementor-element-300b8db {
        width: 300px;
        max-width: 300px
      }

      .elementor-2671 .elementor-element.elementor-element-72cb7f4.elementor-column.elementor-element[data-element_type="column"]>.elementor-widget-wrap.elementor-element-populated {
        align-content: center;
        align-items: center
      }

      .elementor-2671 .elementor-element.elementor-element-72cb7f4.elementor-column>.elementor-widget-wrap {
        justify-content: space-between
      }

      .elementor-2671 .elementor-element.elementor-element-72cb7f4>.elementor-element-populated {
        padding: 0px 0px 0px 15px
      }

      .elementor-2671 .elementor-element.elementor-element-459dc54 .site-navigation {
        text-align: left
      }

      .elementor-2671 .elementor-element.elementor-element-459dc54 .site-navigation ul.menu>li.menu-item>a:not(:hover) {
        color: #FFFFFF
      }

      .elementor-2671 .elementor-element.elementor-element-459dc54 .site-navigation ul.menu>li .menu-title:before {
        background-color: #FFFFFF
      }

      .elementor-2671 .elementor-element.elementor-element-459dc54 .site-navigation ul.menu>li.menu-item.current-menu-item>a:not(:hover) {
        color: #FFFFFF
      }

      .elementor-2671 .elementor-element.elementor-element-459dc54 .site-navigation ul.menu>li.menu-item.current-menu-parent>a:not(:hover) {
        color: #FFFFFF
      }

      .elementor-2671 .elementor-element.elementor-element-459dc54 .site-navigation ul.menu>li.menu-item.current-menu-ancestor>a:not(:hover) {
        color: #FFFFFF
      }

      .elementor-2671 .elementor-element.elementor-element-459dc54 .site-navigation ul.menu>li.menu-item.current-menu-ancestor .menu-title:before {
        background-color: #FFFFFF
      }

      .elementor-2671 .elementor-element.elementor-element-459dc54 {
        width: auto;
        max-width: auto
      }

      .elementor-2671 .elementor-element.elementor-element-87e0895.elementor-view-stacked .elementor-icon {
        background-color: #D9E8DB;
        fill: var(--e-global-color-primary);
        color: var(--e-global-color-primary)
      }

      .elementor-2671 .elementor-element.elementor-element-87e0895.elementor-position-left .elementor-icon-box-icon {
        margin-right: 8px
      }

      .elementor-2671 .elementor-element.elementor-element-87e0895 .elementor-icon {
        font-size: 20px;
        padding: 5px
      }

      .elementor-2671 .elementor-element.elementor-element-87e0895 .elementor-icon i {
        transform: rotate(0deg)
      }

      .elementor-2671 .elementor-element.elementor-element-87e0895 .elementor-icon-box-title {
        margin-bottom: 0px;
        color: #FFA900
      }

      .elementor-2671 .elementor-element.elementor-element-87e0895 .elementor-icon-box-title,
      .elementor-2671 .elementor-element.elementor-element-87e0895 .elementor-icon-box-title a {
        font-size: 16px
      }

      .elementor-2671 .elementor-element.elementor-element-87e0895 {
        width: auto;
        max-width: auto
      }

      .elementor-2671 .elementor-element.elementor-element-e22e0a4>.elementor-container {
        min-height: 90px
      }

      .elementor-2671 .elementor-element.elementor-element-e22e0a4>.elementor-container>.elementor-column>.elementor-widget-wrap {
        align-content: center;
        align-items: center
      }

      .elementor-2671 .elementor-element.elementor-element-e22e0a4 {
        margin-top: 0px;
        margin-bottom: -80px;
        padding: 5px 30px 5px 30px
      }

      .elementor-2671 .elementor-element.elementor-element-96e12b1.elementor-column.elementor-element[data-element_type="column"]>.elementor-widget-wrap.elementor-element-populated {
        align-content: center;
        align-items: center
      }

      .elementor-2671 .elementor-element.elementor-element-96e12b1.elementor-column>.elementor-widget-wrap {
        justify-content: flex-start
      }

      .elementor-2671 .elementor-element.elementor-element-d2b7f0c .hfe-site-logo-container {
        text-align: left
      }

      .elementor-2671 .elementor-element.elementor-element-d2b7f0c .hfe-site-logo-container .hfe-site-logo-img {
        border-style: none
      }

      .elementor-2671 .elementor-element.elementor-element-d2b7f0c>.elementor-widget-container {
        margin: 7px 0px 0px 0px
      }

      .elementor-2671 .elementor-element.elementor-element-d2b7f0c {
        width: auto;
        max-width: auto
      }

      .elementor-2671 .elementor-element.elementor-element-a881416.elementor-column>.elementor-widget-wrap {
        justify-content: center
      }

      .elementor-2671 .elementor-element.elementor-element-643cce1 .site-navigation {
        text-align: left
      }

      .elementor-2671 .elementor-element.elementor-element-643cce1 {
        width: auto;
        max-width: auto
      }

      .elementor-2671 .elementor-element.elementor-element-641f1e9.elementor-column.elementor-element[data-element_type="column"]>.elementor-widget-wrap.elementor-element-populated {
        align-content: center;
        align-items: center
      }

      .elementor-2671 .elementor-element.elementor-element-641f1e9.elementor-column>.elementor-widget-wrap {
        justify-content: flex-end
      }

      .elementor-2671 .elementor-element.elementor-element-185d7c6 .site-header-wishlist {
        text-align: left
      }

      .elementor-2671 .elementor-element.elementor-element-185d7c6>.elementor-widget-container {
        margin: 0px 20px 0px 0px
      }

      .elementor-2671 .elementor-element.elementor-element-185d7c6 {
        width: auto;
        max-width: auto
      }

      .elementor-2671 .elementor-element.elementor-element-1a49b6c .site-header-cart {
        text-align: left
      }

      .elementor-2671 .elementor-element.elementor-element-1a49b6c {
        width: auto;
        max-width: auto
      }

      @media (min-width:768px) {
        .elementor-2671 .elementor-element.elementor-element-d0015e7 {
          width: 25%
        }

        .elementor-2671 .elementor-element.elementor-element-72cb7f4 {
          width: 75%
        }
      }

      @media (max-width:1024px) {
        .elementor-2671 .elementor-element.elementor-element-29edce1>.elementor-container {
          min-height: 80px
        }

        .elementor-2671 .elementor-element.elementor-element-8d3cf4b.elementor-column>.elementor-widget-wrap {
          justify-content: space-between
        }

        .elementor-2671 .elementor-element.elementor-element-0970d68 {
          width: 73px;
          max-width: 73px
        }

        .elementor-2671 .elementor-element.elementor-element-e22e0a4>.elementor-container {
          min-height: 80px
        }

        .elementor-2671 .elementor-element.elementor-element-96e12b1.elementor-column>.elementor-widget-wrap {
          justify-content: space-between
        }
      }

      @media (max-width:767px) {
        .elementor-2671 .elementor-element.elementor-element-af6726c>.elementor-container {
          min-height: 15px
        }

        .elementor-2671 .elementor-element.elementor-element-af6726c {
          padding: 5px 15px 5px 15px
        }

        .elementor-2671 .elementor-element.elementor-element-b98f57f {
          width: 50%
        }

        .elementor-2671 .elementor-element.elementor-element-b98f57f.elementor-column>.elementor-widget-wrap {
          justify-content: space-between
        }

        .elementor-2671 .elementor-element.elementor-element-9846d73>.elementor-widget-container {
          margin: 0px 0px 0px 0px
        }

        .elementor-2671 .elementor-element.elementor-element-5121a88 {
          width: 50%
        }

        .elementor-2671 .elementor-element.elementor-element-e00c387>.elementor-widget-container {
          margin: 0px 0px 0px 0px
        }

        .elementor-2671 .elementor-element.elementor-element-29edce1 {
          padding: 0px 15px 0px 15px
        }

        .elementor-2671 .elementor-element.elementor-element-0970d68 {
          width: auto;
          max-width: auto
        }

        .elementor-2671 .elementor-element.elementor-element-e0920c1 {
          width: auto;
          max-width: auto
        }

        .elementor-2671 .elementor-element.elementor-element-87e0895 .elementor-icon-box-icon {
          margin-bottom: 8px
        }

        .elementor-2671 .elementor-element.elementor-element-e22e0a4 {
          padding: 0px 15px 0px 15px
        }
      }

      @media (max-width:1024px) and (min-width:768px) {
        .elementor-2671 .elementor-element.elementor-element-8d3cf4b {
          width: 100%
        }

        .elementor-2671 .elementor-element.elementor-element-c52ed2c {
          width: 100%
        }

        .elementor-2671 .elementor-element.elementor-element-7cb6566 {
          width: 100%
        }

        .elementor-2671 .elementor-element.elementor-element-96e12b1 {
          width: 100%
        }

        .elementor-2671 .elementor-element.elementor-element-a881416 {
          width: 100%
        }

        .elementor-2671 .elementor-element.elementor-element-641f1e9 {
          width: 100%
        }
      }

      @media (max-width:767px) {
        .elementor-2671 .elementor-element.elementor-element-e00c387 .elementor-icon-list-icon {
          display: none
        }
      }

      .elementor-2671 .elementor-element.elementor-element-e22e0a4 {
        display: none
      }

      .elementor-4083 .elementor-element.elementor-element-79364e1>.elementor-container>.elementor-column>.elementor-widget-wrap {
        align-content: center;
        align-items: center
      }

      .elementor-4083 .elementor-element.elementor-element-79364e1:not(.elementor-motion-effects-element-type-background) {
        background-color: #FFFFFF
      }

      .elementor-4083 .elementor-element.elementor-element-79364e1 {
        border-style: solid;
        border-width: 1px 1px 1px 1px;
        border-color: var(--e-global-color-border);
        margin-top: 80px;
        margin-bottom: 0px
      }

      .elementor-4083 .elementor-element.elementor-element-8596078>.elementor-element-populated {
        border-style: solid;
        border-width: 0px 1px 0px 1px;
        border-color: var(--e-global-color-border)
      }

      .elementor-4083 .elementor-element.elementor-element-14702ff.elementor-view-default .elementor-icon {
        fill: var(--e-global-color-accent);
        color: var(--e-global-color-accent);
        border-color: var(--e-global-color-accent)
      }

      .elementor-4083 .elementor-element.elementor-element-14702ff.elementor-position-top .elementor-icon-box-icon {
        margin-bottom: 15px
      }

      .elementor-4083 .elementor-element.elementor-element-14702ff .elementor-icon i {
        transform: rotate(0deg)
      }

      .elementor-4083 .elementor-element.elementor-element-14702ff .elementor-icon-box-title {
        color: var(--e-global-color-accent)
      }

      .elementor-4083 .elementor-element.elementor-element-14702ff .elementor-icon-box-title,
      .elementor-4083 .elementor-element.elementor-element-14702ff .elementor-icon-box-title a {
        font-family: "Poppins", Sans-serif;
        font-weight: 600
      }

      .elementor-4083 .elementor-element.elementor-element-3d036ab>.elementor-element-populated {
        border-style: solid;
        border-width: 0px 1px 0px 0px;
        border-color: var(--e-global-color-border)
      }

      .elementor-4083 .elementor-element.elementor-element-c50db3d.elementor-view-default .elementor-icon {
        fill: var(--e-global-color-accent);
        color: var(--e-global-color-accent);
        border-color: var(--e-global-color-accent)
      }

      .elementor-4083 .elementor-element.elementor-element-c50db3d.elementor-position-top .elementor-icon-box-icon {
        margin-bottom: 15px
      }

      .elementor-4083 .elementor-element.elementor-element-c50db3d .elementor-icon i {
        transform: rotate(0deg)
      }

      .elementor-4083 .elementor-element.elementor-element-c50db3d .elementor-icon-box-title {
        color: var(--e-global-color-accent)
      }

      .elementor-4083 .elementor-element.elementor-element-c50db3d .elementor-icon-box-title,
      .elementor-4083 .elementor-element.elementor-element-c50db3d .elementor-icon-box-title a {
        font-family: "Poppins", Sans-serif;
        font-weight: 600
      }

      .elementor-4083 .elementor-element.elementor-element-e993fd0>.elementor-element-populated {
        border-style: solid;
        border-width: 0px 1px 0px 0px;
        border-color: var(--e-global-color-border)
      }

      .elementor-4083 .elementor-element.elementor-element-e993fd0>.elementor-element-populated {
        border-radius: 0px 0px 0px 0px
      }

      .elementor-4083 .elementor-element.elementor-element-e04d267 .footer-handheld a {
        text-align: center
      }

      .elementor-4083 .elementor-element.elementor-element-c5a6223.elementor-view-default .elementor-icon {
        fill: var(--e-global-color-accent);
        color: var(--e-global-color-accent);
        border-color: var(--e-global-color-accent)
      }

      .elementor-4083 .elementor-element.elementor-element-c5a6223.elementor-position-top .elementor-icon-box-icon {
        margin-bottom: 15px
      }

      .elementor-4083 .elementor-element.elementor-element-c5a6223 .elementor-icon i {
        transform: rotate(0deg)
      }

      .elementor-4083 .elementor-element.elementor-element-c5a6223 .elementor-icon-box-title {
        color: var(--e-global-color-accent)
      }

      .elementor-4083 .elementor-element.elementor-element-c5a6223 .elementor-icon-box-title,
      .elementor-4083 .elementor-element.elementor-element-c5a6223 .elementor-icon-box-title a {
        font-family: "Poppins", Sans-serif;
        font-weight: 600
      }

      @media (max-width:1024px) {
        .elementor-4083 .elementor-element.elementor-element-79364e1 {
          border-width: 1px 0px 1px 0px
        }

        .elementor-4083 .elementor-element.elementor-element-8596078>.elementor-element-populated {
          border-width: 0px 1px 0px 0px;
          padding: 12px 5px 10px 5px
        }

        .elementor-4083 .elementor-element.elementor-element-14702ff.elementor-position-top .elementor-icon-box-icon {
          margin-bottom: 0px
        }

        .elementor-4083 .elementor-element.elementor-element-14702ff .elementor-icon {
          font-size: 20px
        }

        .elementor-4083 .elementor-element.elementor-element-14702ff .elementor-icon-box-title {
          margin-bottom: 0px
        }

        .elementor-4083 .elementor-element.elementor-element-14702ff .elementor-icon-box-title,
        .elementor-4083 .elementor-element.elementor-element-14702ff .elementor-icon-box-title a {
          font-size: 12px;
          line-height: 1.7em
        }

        .elementor-4083 .elementor-element.elementor-element-3d036ab>.elementor-element-populated {
          border-width: 0px 1px 0px 0px;
          padding: 12px 5px 10px 5px
        }

        .elementor-4083 .elementor-element.elementor-element-c50db3d.elementor-position-top .elementor-icon-box-icon {
          margin-bottom: 0px
        }

        .elementor-4083 .elementor-element.elementor-element-c50db3d .elementor-icon {
          font-size: 20px
        }

        .elementor-4083 .elementor-element.elementor-element-c50db3d .elementor-icon-box-title {
          margin-bottom: 0px
        }

        .elementor-4083 .elementor-element.elementor-element-c50db3d .elementor-icon-box-title,
        .elementor-4083 .elementor-element.elementor-element-c50db3d .elementor-icon-box-title a {
          font-size: 12px;
          line-height: 1.7em
        }

        .elementor-4083 .elementor-element.elementor-element-e993fd0>.elementor-element-populated {
          border-width: 0px 1px 0px 0px;
          padding: 2px 0px 0px 0px
        }

        .elementor-4083 .elementor-element.elementor-element-e04d267 .footer-handheld a .title {
          font-size: 12px
        }

        .elementor-4083 .elementor-element.elementor-element-e04d267>.elementor-widget-container {
          margin: -9px 0px 0px 0px
        }

        .elementor-4083 .elementor-element.elementor-element-af0387d>.elementor-element-populated {
          padding: 12px 5px 10px 5px
        }

        .elementor-4083 .elementor-element.elementor-element-c5a6223.elementor-position-top .elementor-icon-box-icon {
          margin-bottom: 0px
        }

        .elementor-4083 .elementor-element.elementor-element-c5a6223 .elementor-icon {
          font-size: 20px
        }

        .elementor-4083 .elementor-element.elementor-element-c5a6223 .elementor-icon-box-title {
          margin-bottom: 0px
        }

        .elementor-4083 .elementor-element.elementor-element-c5a6223 .elementor-icon-box-title,
        .elementor-4083 .elementor-element.elementor-element-c5a6223 .elementor-icon-box-title a {
          font-size: 12px;
          line-height: 1.7em
        }
      }

      @media (max-width:767px) {
        .elementor-4083 .elementor-element.elementor-element-8596078 {
          width: 25%
        }

        .elementor-4083 .elementor-element.elementor-element-14702ff .elementor-icon-box-icon {
          margin-bottom: 0px
        }

        .elementor-4083 .elementor-element.elementor-element-14702ff .elementor-icon-box-title,
        .elementor-4083 .elementor-element.elementor-element-14702ff .elementor-icon-box-title a {
          font-size: 11px
        }

        .elementor-4083 .elementor-element.elementor-element-3d036ab {
          width: 25%
        }

        .elementor-4083 .elementor-element.elementor-element-c50db3d .elementor-icon-box-icon {
          margin-bottom: 0px
        }

        .elementor-4083 .elementor-element.elementor-element-c50db3d .elementor-icon-box-title,
        .elementor-4083 .elementor-element.elementor-element-c50db3d .elementor-icon-box-title a {
          font-size: 11px
        }

        .elementor-4083 .elementor-element.elementor-element-e993fd0 {
          width: 25%
        }

        .elementor-4083 .elementor-element.elementor-element-e04d267 .footer-handheld a .title {
          font-size: 11px
        }

        .elementor-4083 .elementor-element.elementor-element-af0387d {
          width: 25%
        }

        .elementor-4083 .elementor-element.elementor-element-c5a6223 .elementor-icon-box-icon {
          margin-bottom: 0px
        }

        .elementor-4083 .elementor-element.elementor-element-c5a6223 .elementor-icon-box-title,
        .elementor-4083 .elementor-element.elementor-element-c5a6223 .elementor-icon-box-title a {
          font-size: 11px
        }
      }

      .elementor-4083 .elementor-element.elementor-element-79364e1 {
        position: fixed;
        width: 100%;
        bottom: 0;
        z-index: 997
      }

      [class*=hint--] {
        position: relative;
        display: inline-block
      }

      [class*=hint--]:after,
      [class*=hint--]:before {
        position: absolute;
        -webkit-transform: translate3d(0, 0, 0);
        -moz-transform: translate3d(0, 0, 0);
        transform: translate3d(0, 0, 0);
        visibility: hidden;
        opacity: 0;
        z-index: 1000000
      }

      [class*=hint--]:before {
        content: '';
        position: absolute;
        background: 0 0;
        border: 6px solid transparent;
        z-index: 1000001
      }

      [class*=hint--]:after {
        background: #383838;
        color: #fff;
        padding: 8px 10px;
        font-size: 12px;
        font-family: "Helvetica Neue", Helvetica, Arial, sans-serif;
        line-height: 12px;
        white-space: nowrap;
        text-shadow: 0 -1px 0 #000;
        box-shadow: 4px 4px 8px rgba(0, 0, 0, .3)
      }

      [class*=hint--][aria-label]:after {
        content: attr(aria-label)
      }

      .hint--top:before {
        border-top-color: #383838
      }

      .hint--top:after,
      .hint--top:before {
        bottom: 100%;
        left: 50%
      }

      .hint--top:before {
        margin-bottom: -11px;
        left: calc(50% - 6px)
      }

      .hint--top:after {
        -webkit-transform: translateX(-50%);
        -moz-transform: translateX(-50%);
        transform: translateX(-50%)
      }

      .hint--left:before {
        border-left-color: #383838;
        margin-right: -11px;
        margin-bottom: -6px
      }

      .hint--left:after {
        margin-bottom: -14px
      }

      .hint--left:after,
      .hint--left:before {
        right: 100%;
        bottom: 50%
      }

      @keyframes woosc-spinner {
        to {
          transform: rotate(360deg)
        }
      }

      @-webkit-keyframes woosc-spinner {
        to {
          -webkit-transform: rotate(360deg)
        }
      }

      .woosc-popup {
        position: fixed;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background-color: rgba(0, 0, 0, 0.9);
        z-index: 99999999;
        opacity: 0;
        visibility: hidden
      }

      .woosc-popup .woosc-popup-inner {
        display: block;
        width: 100%;
        height: 100%;
        position: relative
      }

      .woosc-popup .woosc-popup-inner .woosc-popup-content {
        position: absolute;
        padding: 15px;
        top: 60%;
        left: 50%;
        width: 360px;
        height: 400px;
        max-width: 90%;
        max-height: 90%;
        background-color: #fff;
        border-radius: 2px;
        -moz-border-radius: 2px;
        -webkit-border-radius: 2px;
        transform: translate3d(-50%, -50%, 0)
      }

      .woosc-popup .woosc-popup-inner .woosc-popup-content .woosc-popup-content-inner {
        display: flex;
        flex-direction: column;
        width: 100%;
        height: 100%
      }

      .woosc-popup .woosc-popup-inner .woosc-popup-content .woosc-popup-content-inner .woosc-popup-close {
        width: 32px;
        height: 32px;
        line-height: 32px;
        position: absolute;
        top: -32px;
        right: -32px;
        color: #fff;
        text-align: center;
        background-image: url(https://demothemedh.b-cdn.net/organey/wp-content/plugins/woo-smart-compare/assets/images/close.svg);
        background-repeat: no-repeat;
        background-position: center
      }

      .woosc-popup .woosc-popup-inner .woosc-popup-content .woosc-popup-content-inner .woosc-search-input input {
        display: block;
        width: 100%;
        border: none;
        height: 40px;
        line-height: 40px;
        padding: 0 10px;
        box-shadow: none;
        color: #222;
        background-color: #f2f2f2;
        border-radius: 2px;
        -moz-border-radius: 2px;
        -webkit-border-radius: 2px;
        -webkit-appearance: none
      }

      .woosc-popup .woosc-popup-inner .woosc-popup-content .woosc-popup-content-inner .woosc-search-result {
        flex-grow: 1;
        margin-top: 15px;
        overflow-y: auto;
        position: relative
      }

      .woosc-popup .woosc-popup-inner .woosc-popup-content .woosc-popup-content-inner .woosc-search-result:before {
        content: '';
        width: 100%;
        height: 100%;
        display: block;
        position: absolute;
        top: 0;
        left: 0;
        z-index: 7;
        background-color: rgba(255, 255, 255, 0.7);
        opacity: 0;
        visibility: hidden
      }

      .woosc-popup .woosc-popup-inner .woosc-popup-content .woosc-popup-content-inner .woosc-search-result:after {
        width: 32px;
        height: 32px;
        display: block;
        margin-top: -16px;
        margin-left: -16px;
        content: '';
        background-image: url(https://demothemedh.b-cdn.net/organey/wp-content/plugins/woo-smart-compare/assets/images/curve.svg);
        background-repeat: no-repeat;
        background-position: center;
        position: absolute;
        top: 50%;
        left: 50%;
        z-index: 8;
        -webkit-animation: woosc-spinner 1s linear infinite;
        -moz-animation: woosc-spinner 1s linear infinite;
        -ms-animation: woosc-spinner 1s linear infinite;
        -o-animation: woosc-spinner 1s linear infinite;
        animation: woosc-spinner 1s linear infinite;
        opacity: 0;
        visibility: hidden
      }

      .woosc-area {
        position: fixed;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        z-index: 99999979;
        box-sizing: border-box
      }

      .woosc-area .woosc-inner {
        display: block;
        width: 100%;
        height: 100%;
        position: relative
      }

      .woosc-area .woosc-inner .woosc-table {
        padding: 15px 15px 78px 15px;
        margin: 0;
        width: 100%;
        height: 100%;
        box-sizing: border-box;
        background-color: #292a30;
        text-rendering: optimizeLegibility;
        -webkit-font-smoothing: antialiased;
        font-size: 14px;
        position: fixed;
        top: 0;
        left: 0;
        opacity: 0;
        visibility: hidden;
        z-index: 99999997
      }

      .woosc-area .woosc-inner .woosc-table * {
        box-sizing: border-box
      }

      .woosc-area .woosc-inner .woosc-table .woosc-table-inner {
        background-color: #ffffff;
        border-radius: 2px;
        -moz-border-radius: 2px;
        -webkit-border-radius: 2px;
        width: 100%;
        height: 100%;
        max-height: 100%;
        overflow: hidden;
        position: relative
      }

      .woosc-area .woosc-inner .woosc-table .woosc-table-inner:before {
        content: '';
        width: 100%;
        height: 100%;
        display: block;
        position: absolute;
        top: 0;
        left: 0;
        background-color: rgba(255, 255, 255, 0.7);
        opacity: 0;
        visibility: hidden;
        z-index: 7
      }

      .woosc-area .woosc-inner .woosc-table .woosc-table-inner:after {
        width: 32px;
        height: 32px;
        display: block;
        margin-top: -16px;
        margin-left: -16px;
        content: '';
        background-image: url(https://demothemedh.b-cdn.net/organey/wp-content/plugins/woo-smart-compare/assets/images/curve.svg);
        background-repeat: no-repeat;
        background-position: center;
        position: absolute;
        top: 50%;
        left: 50%;
        opacity: 0;
        visibility: hidden;
        z-index: 8;
        -webkit-animation: woosc-spinner 1s linear infinite;
        -moz-animation: woosc-spinner 1s linear infinite;
        -ms-animation: woosc-spinner 1s linear infinite;
        -o-animation: woosc-spinner 1s linear infinite;
        animation: woosc-spinner 1s linear infinite
      }

      .woosc-area .woosc-inner .woosc-table .woosc-table-inner .woosc-table-close {
        z-index: 6;
        position: absolute;
        top: 0;
        right: 0
      }

      .woosc-area .woosc-inner .woosc-table .woosc-table-inner .woosc-table-close .woosc-table-close-icon {
        display: block;
        position: relative;
        width: 100%;
        height: 100%;
        min-width: 52px;
        min-height: 52px;
        background-color: #eeeeee;
        background-image: url(https://demothemedh.b-cdn.net/organey/wp-content/plugins/woo-smart-compare/assets/images/remove-dark.svg);
        background-repeat: no-repeat;
        background-position: center
      }

      .woosc-area .woosc-inner .woosc-table .woosc-table-inner .woosc-table-items {
        z-index: 5;
        height: 100%;
        position: relative
      }

      .woosc-area .woosc-inner .woosc-bar {
        width: 100%;
        height: 78px;
        position: fixed;
        left: 0;
        bottom: -80px;
        padding: 15px;
        box-sizing: border-box;
        background-color: #292a30;
        color: #cfd2d4;
        display: -webkit-flex;
        display: flex;
        align-items: center;
        -webkit-justify-content: flex-end;
        -ms-flex-pack: end;
        justify-content: flex-end;
        flex-wrap: nowrap;
        z-index: 99999998;
        opacity: 0;
        visibility: hidden
      }

      .woosc-area .woosc-inner .woosc-bar .woosc-bar-btn {
        height: 48px;
        line-height: 48px;
        padding: 0 20px 0 68px;
        position: relative;
        border-radius: 2px;
        -moz-border-radius: 2px;
        -webkit-border-radius: 2px;
        background-color: #00a0d2;
        font-size: 14px;
        font-weight: 700;
        color: #ffffff;
        text-transform: uppercase;
        order: 1;
        margin-left: 15px
      }

      .woosc-area .woosc-inner .woosc-bar .woosc-bar-btn .woosc-bar-btn-icon-wrapper {
        width: 48px;
        height: 48px;
        line-height: 48px;
        background-color: rgba(0, 0, 0, 0.1);
        text-align: center;
        display: inline-block;
        position: absolute;
        top: 0;
        left: 0;
        overflow: hidden
      }

      .woosc-area .woosc-inner .woosc-bar .woosc-bar-btn .woosc-bar-btn-icon-wrapper .woosc-bar-btn-icon-inner {
        width: 16px;
        height: 12px;
        margin-top: 18px;
        margin-left: 16px;
        position: relative
      }

      .woosc-area .woosc-inner .woosc-bar .woosc-bar-btn .woosc-bar-btn-icon-wrapper .woosc-bar-btn-icon-inner span {
        display: block;
        position: absolute;
        height: 2px;
        width: 100%;
        background: #ffffff;
        border-radius: 2px;
        opacity: 1;
        left: 0;
        -webkit-transform: rotate(0deg);
        -moz-transform: rotate(0deg);
        -ms-transform: rotate(0deg);
        transform: rotate(0deg)
      }

      .woosc-area .woosc-inner .woosc-bar .woosc-bar-btn .woosc-bar-btn-icon-wrapper .woosc-bar-btn-icon-inner span:nth-child(1) {
        top: 0px
      }

      .woosc-area .woosc-inner .woosc-bar .woosc-bar-btn .woosc-bar-btn-icon-wrapper .woosc-bar-btn-icon-inner span:nth-child(2) {
        top: 5px
      }

      .woosc-area .woosc-inner .woosc-bar .woosc-bar-btn .woosc-bar-btn-icon-wrapper .woosc-bar-btn-icon-inner span:nth-child(3) {
        top: 10px
      }

      .woosc-area .woosc-inner .woosc-bar .woosc-bar-search {
        width: 48px;
        height: 48px;
        display: inline-block;
        position: relative;
        margin: 0 10px 0 0;
        background-color: rgba(255, 255, 255, 0.1);
        background-image: url(https://demothemedh.b-cdn.net/organey/wp-content/plugins/woo-smart-compare/assets/images/add.svg);
        background-size: 20px 20px;
        background-repeat: no-repeat;
        background-position: center;
        border-radius: 2px;
        -moz-border-radius: 2px;
        -webkit-border-radius: 2px
      }

      .woosc-settings-fields {
        margin: 10px 0 0 0;
        padding: 0;
        list-style: none;
        position: relative;
        overflow-y: auto
      }

      .woosc-settings-fields li span {
        margin-left: 5px;
        -webkit-touch-callout: none
      }

      .woosc-bar-settings,
      .woosc-bar-search {
        width: 48px;
        flex: 0 0 48px
      }

      .woosc-area .woosc-inner .woosc-bar .woosc-bar-settings {
        width: 48px;
        height: 48px;
        display: inline-block;
        position: relative;
        margin: 0 10px 0 0;
        background-color: rgba(255, 255, 255, 0.1);
        background-image: url(https://demothemedh.b-cdn.net/organey/wp-content/plugins/woo-smart-compare/assets/images/checkbox.svg);
        background-size: 16px 16px;
        background-repeat: no-repeat;
        background-position: center;
        border-radius: 2px;
        -moz-border-radius: 2px;
        -webkit-border-radius: 2px
      }

      .woosc-area .woosc-inner .woosc-bar .woosc-bar-items {
        height: 48px;
        flex-grow: 1;
        white-space: nowrap;
        width: auto;
        text-align: right;
        order: 0
      }

      .woosc-area .woosc-inner .woosc-bar .woosc-bar-notice {
        position: fixed;
        bottom: 88px;
        width: auto;
        left: 50%;
        padding: 0 10px;
        background-color: rgba(0, 0, 0, .7);
        color: #ffffff;
        border-radius: 2px;
        transform: translate(-50%, 10px);
        opacity: 0;
        visibility: hidden
      }

      @media screen and (max-width:767px) {
        .woosc-bar .woosc-bar-btn {
          font-size: 0 !important;
          padding: 0 !important;
          width: 48px !important;
          flex: 0 0 48px !important;
          overflow: hidden
        }
      }

      button::-moz-focus-inner {
        padding: 0;
        border: 0
      }

      @font-face {
        font-display: swap;
        font-family: feather;
        src: url(https://demothemedh.b-cdn.net/organey/wp-content/plugins/woo-smart-quick-view/assets/libs/feather/fonts/feather.eot);
        src: url(https://demothemedh.b-cdn.net/organey/wp-content/plugins/woo-smart-quick-view/assets/libs/feather/fonts/feather.eot#iefix) format('embedded-opentype'), url(https://demothemedh.b-cdn.net/organey/wp-content/plugins/woo-smart-quick-view/assets/libs/feather/fonts/feather.ttf) format('truetype'), url(https://demothemedh.b-cdn.net/organey/wp-content/plugins/woo-smart-quick-view/assets/libs/feather/fonts/feather.woff) format('woff'), url(https://demothemedh.b-cdn.net/organey/wp-content/plugins/woo-smart-quick-view/assets/libs/feather/fonts/feather.svg#feather) format('svg');
        font-weight: 400;
        font-style: normal
      }

      @font-face {
        font-display: swap;
        font-family: 'feather';
        src: url(https://demothemedh.b-cdn.net/organey/wp-content/plugins/woo-smart-wishlist/assets/libs/feather/fonts/feather.eot);
        src: url(https://demothemedh.b-cdn.net/organey/wp-content/plugins/woo-smart-wishlist/assets/libs/feather/fonts/feather.eot#iefix) format('embedded-opentype'), url(https://demothemedh.b-cdn.net/organey/wp-content/plugins/woo-smart-wishlist/assets/libs/feather/fonts/feather.ttf) format('truetype'), url(https://demothemedh.b-cdn.net/organey/wp-content/plugins/woo-smart-wishlist/assets/libs/feather/fonts/feather.woff) format('woff'), url(https://demothemedh.b-cdn.net/organey/wp-content/plugins/woo-smart-wishlist/assets/libs/feather/fonts/feather.svg#feather) format('svg');
        font-weight: normal;
        font-style: normal
      }

      .woosw-area {
        position: fixed;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        z-index: 99999989;
        background: rgba(0, 0, 0, .7);
        opacity: 0;
        font-size: 14px;
        visibility: hidden;
        box-sizing: border-box
      }

      .woosw-area * {
        box-sizing: border-box
      }

      .woosw-area .woosw-inner {
        display: block;
        width: 100%;
        height: 100%;
        position: relative
      }

      .woosw-area .woosw-inner .woosw-content {
        width: 90%;
        max-width: 480px;
        height: auto;
        max-height: 90%;
        position: absolute;
        top: 40%;
        left: 50%;
        transform: translate3d(-50%, -50%, 0);
        -webkit-transform: translate3d(-50%, -50%, 0);
        padding: 0;
        display: flex;
        flex-direction: column
      }

      .woosw-area .woosw-inner .woosw-content>div {
        align-self: stretch
      }

      .woosw-area .woosw-inner .woosw-content .woosw-content-top {
        flex: 0 0 auto;
        height: 48px;
        line-height: 48px;
        padding: 0 60px 0 20px;
        margin: 0;
        position: relative;
        color: #fff;
        font-weight: 700;
        background-color: #222
      }

      .woosw-area .woosw-inner .woosw-content .woosw-content-top .woosw-count:before {
        content: '('
      }

      .woosw-area .woosw-inner .woosw-content .woosw-content-top .woosw-count:after {
        content: ')'
      }

      .woosw-area .woosw-inner .woosw-content .woosw-content-top .woosw-close {
        display: inline-block;
        height: 48px;
        line-height: 48px;
        position: absolute;
        top: 0;
        right: 0;
        text-transform: none;
        color: #999;
        font-weight: 400
      }

      .woosw-area .woosw-inner .woosw-content .woosw-content-top .woosw-close:after {
        display: inline-block;
        float: right;
        width: 48px;
        height: 48px;
        line-height: 48px;
        text-align: center;
        content: '\e9ea';
        font-size: 20px;
        font-family: feather;
        speak: none;
        font-style: normal;
        font-weight: 400;
        font-variant: normal;
        text-transform: none;
        -webkit-font-smoothing: antialiased;
        -moz-osx-font-smoothing: grayscale
      }

      .woosw-area .woosw-inner .woosw-content .woosw-content-mid {
        display: block;
        position: relative;
        min-height: 80px;
        flex: 1 1 auto;
        padding: 0;
        margin: 0;
        background-color: #fff;
        overflow-x: hidden;
        overflow-y: auto
      }

      .woosw-area .woosw-inner .woosw-content .woosw-content-bot {
        flex: 0 0 auto;
        height: 48px;
        line-height: 48px;
        padding: 0 20px;
        position: relative;
        color: #fff;
        font-size: 14px;
        text-transform: uppercase;
        background-color: #222;
        overflow: hidden
      }

      .woosw-area .woosw-inner .woosw-content .woosw-content-bot .woosw-content-bot-inner {
        display: flex;
        flex-wrap: wrap;
        flex-direction: row;
        justify-content: space-between;
        align-items: center;
        width: 100%
      }

      .woosw-area .woosw-inner .woosw-content .woosw-content-bot .woosw-content-bot-inner a,
      .woosw-area .woosw-inner .woosw-content .woosw-content-bot .woosw-content-bot-inner span {
        color: #fff;
        text-decoration: underline;
        outline: none
      }

      .woosw-area .woosw-inner .woosw-content .woosw-content-bot .woosw-notice {
        display: block;
        text-align: center;
        width: 100%;
        height: 48px;
        line-height: 48px;
        padding: 0 20px;
        color: #fff;
        font-size: 14px;
        font-weight: 400;
        background-color: #5fbd74;
        position: absolute;
        top: 48px;
        left: 0
      }

      @font-face {
        font-family: "organey-icon";
        src: url(https://demothemedh.b-cdn.net/organey/wp-content/themes/organey/assets/fonts/organey-icon.eot);
        src: url(https://demothemedh.b-cdn.net/organey/wp-content/themes/organey/assets/fonts/organey-icon.eot?#iefix) format("eot"), url(https://demothemedh.b-cdn.net/organey/wp-content/themes/organey/assets/fonts/organey-icon.woff2) format("woff2"), url(https://demothemedh.b-cdn.net/organey/wp-content/themes/organey/assets/fonts/organey-icon.woff) format("woff"), url(https://demothemedh.b-cdn.net/organey/wp-content/themes/organey/assets/fonts/organey-icon.ttf) format("truetype"), url(https://demothemedh.b-cdn.net/organey/wp-content/themes/organey/assets/fonts/organey-icon.svg#organey-icon) format("svg");
        font-display: swap
      }

      [class*=organey-icon-] {
        font-family: "organey-icon";
        -webkit-font-smoothing: antialiased;
        -moz-osx-font-smoothing: grayscale;
        display: inline-block;
        font-style: normal;
        font-variant: normal;
        font-weight: normal
      }

      html {
        font-family: sans-serif;
        -ms-text-size-adjust: 100%;
        -webkit-text-size-adjust: 100%
      }

      body {
        margin: 0
      }

      header,
      nav,
      section {
        display: block
      }

      a {
        background-color: transparent
      }

      strong {
        font-weight: bold
      }

      img {
        border: 0
      }

      button,
      input {
        color: inherit;
        font: inherit;
        margin: 0
      }

      button {
        overflow: visible
      }

      button {
        text-transform: none
      }

      button {
        -webkit-appearance: button
      }

      button::-moz-focus-inner,
      input::-moz-focus-inner {
        border: 0;
        padding: 0
      }

      input {
        line-height: normal
      }

      input[type=checkbox] {
        box-sizing: border-box;
        padding: 0
      }

      input[type=search] {
        -webkit-appearance: textfield;
        box-sizing: content-box
      }

      input[type=search]::-webkit-search-cancel-button,
      input[type=search]::-webkit-search-decoration {
        -webkit-appearance: none
      }

      :root {
        --primary: #5C9963;
        --primary_hover: #528959;
        --secondary: #FFA900;
        --secondary_hover: #ff8d00;
        --text: #656766;
        --accent: #2F3E30;
        --light: #9f9f9f;
        --dark: #000;
        --border: #E4E4E4;
        --background: #ffffff;
        --background_light: #F5F5F5;
        --container: 1320px
      }

      body {
        -ms-word-wrap: break-word;
        word-wrap: break-word
      }

      body,
      button,
      input {
        font-size: 14px;
        color: var(--text);
        font-family: "Poppins";
        line-height: 1.7;
        text-rendering: optimizeLegibility
      }

      h2,
      h3 {
        font-family: "Poppins";
        clear: both;
        margin: 0 0 0.5407911001em;
        color: var(--accent);
        font-weight: 600
      }

      h2 {
        font-size: 2em;
        line-height: 1.214
      }

      h3 {
        font-size: 26px
      }

      p {
        margin: 0 0 1em
      }

      ul {
        margin: 0 0 1em 3em;
        padding: 0
      }

      ul {
        list-style: disc
      }

      strong {
        font-weight: 700
      }

      i {
        font-style: italic
      }

      ins {
        text-decoration: none;
        font-weight: 700;
        background: transparent
      }

      img {
        height: auto;
        max-width: 100%;
        display: block
      }

      a {
        color: var(--primary);
        text-decoration: none
      }

      :focus {
        outline: none
      }

      * {
        box-sizing: border-box
      }

      .row {
        display: flex;
        flex-wrap: wrap;
        margin-left: -15px;
        margin-right: -15px
      }

      [class^=column-] {
        padding-left: 15px;
        padding-right: 15px
      }

      ul.menu li.current-menu-item>a,
      ul.menu li.current-menu-ancestor>a,
      ul.menu li.current-menu-parent>a {
        color: var(--primary)
      }

      .site-navigation {
        position: relative
      }

      .site-navigation .menu {
        clear: both
      }

      .site-navigation ul {
        list-style: none
      }

      .site-navigation ul.menu {
        margin-left: 0;
        margin-bottom: 0
      }

      .site-navigation ul.menu ul {
        display: block;
        margin-left: 1.41575em
      }

      .site-navigation ul li {
        display: inline-block;
        position: relative;
        text-align: left
      }

      .site-navigation ul li.menu-item.current-menu-parent>a,
      .site-navigation ul li.menu-item.current-menu-item>a,
      .site-navigation ul li.menu-item.current-menu-ancestor>a {
        color: var(--primary)
      }

      .site-navigation ul li.menu-item.current-menu-parent .menu-title:before,
      .site-navigation ul li.menu-item.current-menu-item .menu-title:before,
      .site-navigation ul li.menu-item.current-menu-ancestor .menu-title:before {
        width: 100%
      }

      .site-navigation ul li a {
        color: var(--accent);
        padding: 0.6180469716em;
        display: block
      }

      @media (max-width:1023px) {
        .site-navigation .primary-navigation ul {
          max-height: 0;
          overflow: hidden;
          margin: 0
        }
      }

      @media (min-width:1024px) {
        .site-navigation ul li {
          display: inline-block;
          position: relative;
          text-align: left
        }

        .site-navigation ul li .menu-title {
          position: relative
        }

        .site-navigation ul li .menu-title:before {
          content: "";
          position: absolute;
          width: 0;
          height: 1px;
          bottom: -2px;
          left: 0;
          background-color: var(--primary)
        }

        .site-navigation ul ul.sub-menu {
          float: left;
          position: absolute;
          top: 100%;
          z-index: 99999;
          left: 1.1em;
          opacity: 0;
          visibility: hidden;
          border-radius: 0 0 8px 8px;
          background: #fff;
          box-shadow: 0 0 50px 0 rgba(0, 0, 0, 0.07);
          padding: 15px 0
        }

        .site-navigation ul ul.sub-menu li {
          display: block;
          min-width: 260px
        }

        .site-navigation ul ul.sub-menu .menu-title:before {
          display: none
        }

        .site-navigation ul.menu {
          max-height: none;
          overflow: visible;
          margin-left: -1.1em
        }

        .site-navigation ul.menu>li>a {
          padding: 0.907em 1em;
          font-size: 14px;
          font-weight: 500
        }

        .site-navigation ul.menu>li.menu-item-has-children>a:after {
          font-family: "organey-icon";
          -webkit-font-smoothing: antialiased;
          -moz-osx-font-smoothing: grayscale;
          display: inline-block;
          font-style: normal;
          font-variant: normal;
          font-weight: normal;
          content: "\e061";
          margin-left: 0.7em;
          font-size: 9px;
          font-weight: 700
        }

        .site-navigation ul.menu ul.sub-menu {
          margin: 0
        }

        .site-navigation ul.menu ul.sub-menu li.menu-item a {
          padding: 8px 40px 8px 25px;
          font-weight: 400;
          font-size: 14px;
          line-height: 1.5;
          position: relative;
          color: var(--text)
        }

        .site-navigation ul.menu ul.sub-menu li.menu-item a:before {
          content: "";
          width: 9px;
          height: 1px;
          background-color: var(--primary);
          position: absolute;
          top: 18px;
          transform: translateY(-50%);
          -webkit-transform: translateY(-50%);
          -moz-transform: translateY(-50%);
          -ms-transform: translateY(-50%);
          -o-transform: translateY(-50%);
          left: 25px;
          opacity: 0
        }

        .site-navigation ul.menu ul.sub-menu li.menu-item:last-child {
          border-bottom: 0;
          margin-bottom: 0
        }
      }

      .post-thumbnail {
        position: relative;
        margin-bottom: 15px
      }

      .post-thumbnail .meta-categories {
        position: absolute;
        left: 0;
        bottom: 0;
        padding: 10px 16px
      }

      .meta-categories a {
        font-size: 10px;
        text-transform: uppercase;
        display: inline-block;
        padding: 4px 12px;
        border-radius: 20px;
        font-weight: 500;
        letter-spacing: 0.5px;
        background: var(--primary);
        color: #fff;
        margin-right: 5px;
        margin-bottom: 10px
      }

      .entry-title {
        font-size: 24px;
        line-height: 1.3;
        font-weight: 600
      }

      .entry-title a {
        color: var(--accent)
      }

      .post-meta {
        font-size: 14px;
        margin-bottom: 10px;
        color: var(--light)
      }

      .post-meta a {
        color: var(--light)
      }

      .post-meta>span i {
        color: var(--primary);
        margin-right: 8px
      }

      .post-meta>span:not(:last-child):after {
        content: "\7c";
        margin-left: 10px;
        margin-right: 10px
      }

      .updated:not(.published) {
        display: none
      }

      .skeleton-body .skeleton-item {
        position: relative;
        overflow: hidden;
        width: 100%
      }

      .skeleton-body .skeleton-item:before {
        content: "";
        display: block;
        width: 100%;
        background-repeat: no-repeat;
        background-image: linear-gradient(var(--background_light) 100%, transparent 0), linear-gradient(var(--background_light) 100%, transparent 0), linear-gradient(var(--background_light) 100%, transparent 0), linear-gradient(var(--background_light) 100%, transparent 0), linear-gradient(var(--background_light) 100%, transparent 0), linear-gradient(var(--background_light) 100%, transparent 0), linear-gradient(var(--background_light) 100%, transparent 0), linear-gradient(var(--background_light) 100%, transparent 0), linear-gradient(var(--background_light) 100%, transparent 0), linear-gradient(var(--background_light) 100%, transparent 0), linear-gradient(var(--background_light) 100%, transparent 0), linear-gradient(var(--background_light) 100%, transparent 0), linear-gradient(var(--background_light) 100%, transparent 0), linear-gradient(var(--background_light) 100%, transparent 0), linear-gradient(var(--background_light) 100%, transparent 0), linear-gradient(var(--background_light) 100%, transparent 0), linear-gradient(var(--background_light) 100%, transparent 0), linear-gradient(var(--background_light) 100%, transparent 0), linear-gradient(var(--background_light) 100%, transparent 0)
      }

      .skeleton-body .skeleton-item:after {
        content: "";
        position: absolute;
        top: -50%;
        left: -50%;
        right: -50%;
        bottom: -50%;
        background-image: linear-gradient(90deg, rgba(255, 255, 255, 0) 20%, rgba(255, 255, 255, 0.8) 50%, rgba(255, 255, 255, 0) 80%);
        animation: skeletonloading 1.5s infinite
      }

      .skeleton-body .skeleton-blog-thumbnail:before {
        padding-bottom: 69.2307692308%;
        background-size: 100% 100%;
        background-position: left 0
      }

      @keyframes skeletonloading {
        from {
          transform: skewX(-45deg) translateX(-80%)
        }

        to {
          transform: skewX(-45deg) translateX(80%)
        }
      }

      .screen-reader-text {
        border: 0;
        clip: rect(1px, 1px, 1px, 1px);
        -webkit-clip-path: inset(50%);
        clip-path: inset(50%);
        height: 1px;
        margin: -1px;
        overflow: hidden;
        padding: 0;
        position: absolute;
        width: 1px;
        word-wrap: normal !important
      }

      form {
        margin-bottom: 1.618em
      }

      button,
      input {
        font-size: 100%;
        margin: 0;
        vertical-align: baseline;
        *vertical-align: middle
      }

      button,
      .button {
        border: none;
        border-radius: 24px;
        background-color: var(--primary);
        border-color: var(--primary);
        color: #fff;
        padding: calc(1.07em - 2px) 3.2em;
        text-decoration: none;
        text-shadow: none;
        display: inline-block;
        -webkit-appearance: none;
        font-weight: 500;
        line-height: 1.4
      }

      button::after,
      .button::after {
        display: none
      }

      input[type=checkbox] {
        padding: 0
      }

      input[type=search]::-webkit-search-decoration {
        -webkit-appearance: none
      }

      input[type=search] {
        box-sizing: border-box
      }

      button::-moz-focus-inner,
      input::-moz-focus-inner {
        border: 0;
        padding: 0
      }

      input[type=text],
      input[type=password],
      input[type=search] {
        padding: calc(0.734em - 2px) 1em;
        background-color: var(--background);
        color: var(--text);
        border-width: 1px;
        border-style: solid;
        border-color: var(--border);
        -webkit-appearance: none;
        box-sizing: border-box;
        font-weight: normal;
        border-radius: 6px;
        outline: 0
      }

      label {
        font-weight: 400
      }

      .widget_product_search form,
      .site-search form {
        position: relative;
        margin-bottom: 0
      }

      .widget_product_search form::before,
      .site-search form::before {
        font-size: 18px;
        color: var(--accent);
        font-family: "organey-icon";
        -webkit-font-smoothing: antialiased;
        -moz-osx-font-smoothing: grayscale;
        display: inline-block;
        font-style: normal;
        font-variant: normal;
        font-weight: normal;
        content: "\e01d";
        position: absolute;
        top: 50%;
        right: 20px;
        line-height: 1;
        transform: translate(0, -50%)
      }

      .widget_product_search form input[type=search],
      .site-search form input[type=search] {
        border: 1px solid;
        background-color: #f5f5f5;
        border-color: var(--border);
        width: 100%;
        line-height: 1;
        padding: 1em 1.5em;
        padding-right: 60px;
        flex: 1
      }

      .widget_product_search form button[type=submit],
      .site-search form button[type=submit] {
        font-size: 0;
        line-height: 0;
        width: 60px;
        height: 100%;
        position: absolute;
        right: 0;
        top: 0;
        z-index: 3;
        background: transparent
      }

      .site-search form {
        margin-bottom: 0
      }

      .organey-carousel {
        display: none
      }

      @media (max-width:767px) {
        .organey-carousel {
          overflow: hidden
        }
      }

      .woocommerce-carousel .products {
        display: none
      }

      .woocommerce-carousel .products .product {
        margin-bottom: 0
      }

      button::-moz-focus-inner {
        padding: 0;
        border: 0
      }

      .side-wrap {
        position: fixed;
        top: 0;
        bottom: 0;
        overflow: hidden;
        overflow-y: auto;
        width: 300px;
        background-color: var(--background);
        display: flex;
        flex-direction: column;
        right: 0;
        z-index: 9999999;
        transform: translate3d(300px, 0, 0)
      }

      @media (min-width:1024px) {
        .side-wrap {
          width: 440px;
          transform: translate3d(440px, 0, 0)
        }
      }

      .side-wrap .side-heading {
        flex: 0 0 auto;
        flex-direction: row;
        justify-content: flex-end;
        line-height: 1
      }

      .side-wrap .side-title {
        flex: 1 1 auto;
        font-size: 18px;
        text-transform: uppercase;
        color: var(--accent);
        font-weight: 600;
        padding: 20px 15px;
        display: block;
        border-bottom: 2px solid;
        border-color: var(--border)
      }

      .close-side {
        color: var(--accent);
        text-decoration: none;
        text-transform: uppercase;
        letter-spacing: 0.3px;
        font-weight: 600;
        font-size: 13px;
        width: 20px;
        height: 20px;
        position: absolute;
        right: 20px;
        top: 20px
      }

      .close-side:before,
      .close-side:after {
        content: "\20";
        position: absolute;
        top: 50%;
        display: inline-block;
        margin-top: -1px;
        width: 20px;
        height: 2px;
        background-color: var(--accent);
        right: 0;
        transform: rotate(-45deg)
      }

      .close-side:before {
        transform: rotate(45deg)
      }

      .side-overlay {
        position: fixed;
        width: 100vw;
        height: 100vh;
        top: 0;
        bottom: 0;
        left: 0;
        z-index: 997;
        opacity: 0;
        background-color: rgba(0, 0, 0, 0.7);
        visibility: hidden
      }

      .site-wishlist-side .wishlist-side-wrap-content {
        margin-bottom: 0;
        position: relative;
        flex: 1 1 auto;
        display: flex;
        flex-direction: column
      }

      .site-wishlist-side .organey-wishlist-content-scroll {
        position: relative;
        flex: 1 1 auto;
        overflow-y: auto;
        padding-right: 15px;
        margin-right: -15px
      }

      .site-wishlist-side .organey-wishlist-content-scroll .organey-wishlist-content {
        position: absolute;
        top: 0;
        right: 15px;
        bottom: 0;
        left: 0
      }

      .site-wishlist-side .organey-wishlist-bottom {
        padding: 20px 15px;
        margin: 0;
        border-top: 2px solid;
        border-top-color: var(--border)
      }

      .site-wishlist-side .organey-wishlist-bottom a.button {
        display: block;
        text-align: center
      }

      #woosw-area {
        display: none !important;
        position: absolute;
        top: 0;
        right: 0;
        opacity: 1;
        font-size: 0;
        color: var(--light)
      }

      .site-account-side form.organey-login-form-ajax {
        margin-bottom: 5px;
        padding: 15px
      }

      .site-account-side form.organey-login-form-ajax label {
        display: block;
        margin-bottom: 15px
      }

      .site-account-side form.organey-login-form-ajax input {
        width: 100%
      }

      .site-account-side form.organey-login-form-ajax .label {
        color: var(--accent);
        display: block;
        margin-bottom: 5px
      }

      .site-account-side form.organey-login-form-ajax button[type=submit] {
        display: block;
        width: 100%;
        margin-top: 23px
      }

      .site-account-side .login-form-bottom {
        border-top: 2px solid;
        border-color: var(--border);
        margin-top: 20px;
        padding: 20px 0;
        text-align: center
      }

      .site-account-side a.lostpass-link {
        color: var(--light);
        font-size: 14px;
        font-style: italic;
        text-decoration: underline dashed;
        text-align: center;
        display: block
      }

      .site-account-side a.register-link {
        font-weight: 600
      }

      .organey-icon-almonds:before {
        content: "\e001"
      }

      .organey-icon-carrot:before {
        content: "\e002"
      }

      .organey-icon-cart:before {
        content: "\e003"
      }

      .organey-icon-cherry:before {
        content: "\e004"
      }

      .organey-icon-fish:before {
        content: "\e00e"
      }

      .organey-icon-lettuce:before {
        content: "\e011"
      }

      .organey-icon-live-support:before {
        content: "\e012"
      }

      .organey-icon-open-can:before {
        content: "\e016"
      }

      .organey-icon-organic:before {
        content: "\e017"
      }

      .organey-icon-search:before {
        content: "\e01d"
      }

      .organey-icon-sprout:before {
        content: "\e020"
      }

      .organey-icon-tofu:before {
        content: "\e022"
      }

      .organey-icon-user:before {
        content: "\e023"
      }

      .organey-icon-bars:before {
        content: "\e05e"
      }

      .organey-icon-calendar:before {
        content: "\e05f"
      }

      .organey-icon-comment:before {
        content: "\e067"
      }

      .organey-icon-envelope:before {
        content: "\e06a"
      }

      .organey-icon-heart:before {
        content: "\e076"
      }

      .organey-icon-home:before {
        content: "\e077"
      }

      .organey-icon-times:before {
        content: "\e097"
      }

      @font-face {
        font-family: "organey-icon";
        src: url(https://demothemedh.b-cdn.net/organey/wp-content/themes/organey/assets/fonts/organey-icon.eot);
        src: url(https://demothemedh.b-cdn.net/organey/wp-content/themes/organey/assets/fonts/organey-icon.eot?#iefix) format("eot"), url(https://demothemedh.b-cdn.net/organey/wp-content/themes/organey/assets/fonts/organey-icon.woff2) format("woff2"), url(https://demothemedh.b-cdn.net/organey/wp-content/themes/organey/assets/fonts/organey-icon.woff) format("woff"), url(https://demothemedh.b-cdn.net/organey/wp-content/themes/organey/assets/fonts/organey-icon.ttf) format("truetype"), url(https://demothemedh.b-cdn.net/organey/wp-content/themes/organey/assets/fonts/organey-icon.svg#organey-icon) format("svg");
        font-display: swap
      }

      [class*=organey-icon-] {
        font-family: "organey-icon";
        -webkit-font-smoothing: antialiased;
        -moz-osx-font-smoothing: grayscale;
        display: inline-block;
        font-style: normal;
        font-variant: normal;
        font-weight: normal
      }

      .elementor-widget-organey-post-grid .column-item {
        margin-bottom: 30px
      }

      .elementor-widget-organey-instagram.elementor-instagram-style-2 .row .column-item:nth-child(6n+1) {
        grid-area: 5/1/span 4/span 2
      }

      .elementor-widget-organey-instagram.elementor-instagram-style-2 .row .column-item:nth-child(6n+2) {
        grid-area: 2/3/span 6/span 3
      }

      .elementor-widget-organey-instagram.elementor-instagram-style-2 .row .column-item:nth-child(6n+3) {
        grid-area: 8/4/span 4/span 2
      }

      .elementor-widget-organey-instagram.elementor-instagram-style-2 .row .column-item:nth-child(6n+4) {
        grid-area: 1/6/span 4/span 2
      }

      .elementor-widget-organey-instagram.elementor-instagram-style-2 .row .column-item:nth-child(6n+5) {
        grid-area: 5/6/span 6/span 3
      }

      .elementor-widget-organey-instagram.elementor-instagram-style-2 .row .column-item:nth-child(6n+6) {
        grid-area: 4/9/span 4/span 2
      }

      .elementor-search-form-wrapper .site-search {
        display: block
      }

      .elementor-search-form-wrapper .widget_product_search form::before {
        font-family: "organey-icon";
        -webkit-font-smoothing: antialiased;
        -moz-osx-font-smoothing: grayscale;
        display: inline-block;
        font-style: normal;
        font-variant: normal;
        font-weight: normal;
        content: "\e01d";
        position: absolute;
        top: 50%;
        right: 20px;
        line-height: 1;
        transform: translate(0, -50%);
        color: var(--text)
      }

      .elementor-search-form-wrapper .widget_product_search form input[type=search] {
        font-size: 15px;
        padding-left: 1.5em;
        padding-right: 4em;
        border-radius: 50px;
        background-color: transparent
      }

      .elementor-search-form-wrapper .widget_product_search form button[type=submit] {
        padding: 0;
        font-size: 0
      }

      .search-organey-layout-style-2 .elementor-search-form-wrapper .widget_product_search form::before {
        content: none
      }

      .search-organey-layout-style-2 .elementor-search-form-wrapper .widget_product_search form button[type=submit] {
        font-size: 14px;
        right: 4px;
        top: 4px;
        bottom: 4px;
        height: unset;
        padding: 0 24px;
        width: unset;
        font-weight: 400;
        background-color: var(--primary)
      }

      .site-search-popup {
        position: fixed;
        width: 100vw;
        height: 100vh;
        top: 0;
        left: 0;
        z-index: 99999;
        background-color: rgba(0, 0, 0, 0.7);
        opacity: 0;
        visibility: hidden
      }

      .site-search-popup .site-search-popup-wrap {
        display: flex;
        align-items: center;
        justify-content: center;
        position: relative;
        padding: 40px;
        background-color: #fff;
        transform: translateY(-100%)
      }

      @media (min-width:1024px) {
        .site-search-popup .site-search-popup-wrap {
          padding: 80px
        }
      }

      .site-search-popup .site-search-popup-wrap .site-search-popup-close {
        position: absolute;
        right: 10px;
        top: 10px;
        font-size: 20px;
        line-height: 1;
        width: 26px;
        height: 26px
      }

      @media (min-width:1024px) {
        .site-search-popup .site-search-popup-wrap .site-search-popup-close {
          top: 20px;
          right: 30px
        }
      }

      .site-search-popup .site-search-popup-wrap .site-search-popup-close:before,
      .site-search-popup .site-search-popup-wrap .site-search-popup-close:after {
        content: "\20";
        position: absolute;
        top: 50%;
        display: inline-block;
        margin-top: -1px;
        width: 26px;
        height: 2px;
        background-color: var(--accent);
        right: 0;
        transform: rotate(-45deg)
      }

      .site-search-popup .site-search-popup-wrap .site-search-popup-close:before {
        transform: rotate(45deg)
      }

      .site-search-popup .site-search-popup-wrap .site-search {
        display: block;
        max-width: 600px;
        width: 100%
      }

      @media (max-width:767px) {
        .site-search-popup .site-search-popup-wrap .site-search {
          max-width: 300px
        }
      }

      .site-search-popup .site-search-popup-wrap .site-search .widget {
        margin-bottom: 0;
        border: none
      }

      .site-search-popup .site-search-popup-wrap .site-search .ajax-search-result {
        max-height: 50vh
      }

      .site-search {
        font-size: 14px;
        color: var(--text);
        clear: both;
        display: none
      }

      .site-search .widget_product_search input[type=search] {
        padding: 1em 1.618em;
        line-height: 1;
        background-color: #fff;
        border-radius: 2em;
        border: 1px solid;
        border-color: var(--border)
      }

      .site-header-account {
        position: relative
      }

      .site-header-account>a {
        display: flex;
        align-items: center;
        white-space: nowrap;
        line-height: 1;
        color: var(--accent)
      }

      .site-header-account>a i {
        font-size: 16px;
        line-height: 1;
        vertical-align: middle;
        color: var(--primary)
      }

      .site-header-account>a .account-user {
        width: 32px;
        height: 32px;
        text-align: center;
        line-height: 30px;
        border-radius: 50%;
        margin-right: 10px;
        background-color: #D9E8DB
      }

      .site-header-account>a .account-content {
        font-size: 14px
      }

      .mobile-navigation,
      .mobile-navigation-categories {
        clear: both
      }

      .mobile-navigation ul,
      .mobile-navigation-categories ul {
        margin: 0;
        list-style: none
      }

      .mobile-navigation ul>li.menu-item,
      .mobile-navigation-categories ul>li.menu-item {
        position: relative
      }

      .mobile-navigation ul>li.menu-item>a,
      .mobile-navigation-categories ul>li.menu-item>a {
        display: flex;
        padding: 10px 0;
        font-size: 14px;
        font-weight: 500;
        border-bottom: 1px solid;
        border-bottom-color: var(--border);
        color: var(--accent)
      }

      .mobile-navigation-categories ul>li.menu-item>a i {
        font-size: 16px;
        margin-right: 15px
      }

      .mobile-navigation ul>li.menu-item:last-child>a,
      .mobile-navigation-categories ul>li.menu-item:last-child>a {
        border-bottom: none
      }

      .mobile-navigation ul ul.sub-menu,
      .mobile-navigation-categories ul ul.sub-menu {
        display: none;
        margin-top: 10px
      }

      .mobile-navigation ul ul.sub-menu>li.menu-item>a {
        font-size: 14px;
        padding: 2px 0 2px 13px;
        border-bottom: none;
        font-weight: 400;
        color: var(--text)
      }

      .mobile-navigation ul ul.sub-menu>li.menu-item:first-child>a {
        padding-top: 6px
      }

      .mobile-navigation ul ul.sub-menu>li.menu-item.current-menu-item>a {
        color: var(--primary)
      }

      .mobile-navigation ul.menu li.current-menu-item>a,
      .mobile-navigation ul.menu li.current-menu-ancestor>a,
      .mobile-navigation ul.menu li.current-menu-parent>a {
        color: var(--primary)
      }

      .elementor-canvas-menu-wrapper .menu-mobile-nav-button {
        line-height: 0;
        display: inline-block
      }

      .organey-mobile-nav {
        display: flex;
        flex-direction: column;
        justify-content: space-between;
        position: fixed;
        width: 330px;
        top: 0;
        bottom: 0;
        left: 0;
        z-index: 9999;
        overflow: hidden;
        overflow-y: auto;
        background-color: #fff;
        -webkit-transform: translate3d(-330px, 0, 0);
        transform: translate3d(-330px, 0, 0)
      }

      .organey-mobile-nav .organey-language-switcher-mobile {
        line-height: 0;
        padding: 0 30px
      }

      .organey-mobile-nav .organey-language-switcher-mobile .menu {
        list-style: none;
        margin: 0;
        padding: 10px 0;
        border-top: 1px solid;
        border-top-color: var(--border)
      }

      .organey-mobile-nav .organey-language-switcher-mobile .item {
        display: inline-block;
        margin-bottom: 5px;
        margin-top: 5px
      }

      .organey-mobile-nav .organey-language-switcher-mobile .item .language-switcher-head {
        padding-right: 5px
      }

      .organey-mobile-nav .organey-language-switcher-mobile .item a {
        display: block;
        padding: 0 5px
      }

      .organey-mobile-nav .organey-language-switcher-mobile .item:last-child {
        margin-right: 0
      }

      .organey-mobile-nav .organey-language-switcher-mobile .item img {
        width: 24px;
        height: 16px;
        object-fit: cover
      }

      .organey-mobile-nav .mobile-nav-tabs {
        clear: both;
        padding: 0 30px;
        background-color: #f7f7f7
      }

      .organey-mobile-nav .mobile-nav-tabs ul {
        display: flex;
        align-items: center;
        flex-direction: row;
        list-style: none;
        margin: 0
      }

      .organey-mobile-nav .mobile-nav-tabs ul li {
        position: relative;
        text-align: left;
        font-size: 14px;
        font-weight: 500;
        line-height: 20px;
        padding-top: 20px;
        padding-bottom: 20px;
        color: var(--light)
      }

      .organey-mobile-nav .mobile-nav-tabs ul li:before {
        content: "";
        display: inline-block;
        position: absolute;
        height: 2px;
        width: 100%;
        bottom: 0;
        opacity: 0;
        visibility: hidden;
        transform: scale(0.6);
        background-color: var(--primary)
      }

      .organey-mobile-nav .mobile-nav-tabs ul li.active {
        color: var(--accent)
      }

      .organey-mobile-nav .mobile-nav-tabs ul li.active:before {
        opacity: 1;
        visibility: visible;
        transform: scale(1)
      }

      .organey-mobile-nav .mobile-nav-tabs ul .mobile-pages-title {
        margin-right: 15px
      }

      .organey-mobile-nav .mobile-nav-tabs ul .mobile-categories-title {
        margin-left: 15px
      }

      .organey-mobile-nav .mobile-menu-tab {
        display: none;
        padding: 0 30px;
        -webkit-animation: wd-fadeIn 1s ease;
        animation: wd-fadeIn 1s ease
      }

      .organey-mobile-nav .mobile-menu-tab.active {
        display: block
      }

      @keyframes wd-fadeIn {
        0% {
          opacity: 0
        }

        100% {
          opacity: 1
        }
      }

      .mobile-nav-close {
        float: right;
        clear: both;
        position: absolute;
        line-height: 1;
        top: 20px;
        right: 22px;
        border: 1px solid;
        border-color: var(--accent);
        border-radius: 50%;
        padding: 0;
        width: 20px;
        height: 20px;
        text-align: center;
        color: var(--accent)
      }

      .mobile-nav-close i {
        line-height: 19px;
        vertical-align: middle
      }

      .organey-overlay {
        position: fixed;
        width: 100vw;
        height: 100vh;
        top: 0;
        bottom: 0;
        left: 0;
        z-index: 997;
        opacity: 0;
        background-color: rgba(0, 0, 0, 0.7);
        visibility: hidden
      }

      .menu-mobile-nav-button {
        display: block;
        font-size: 15px;
        color: var(--accent)
      }

      .menu-mobile-nav-button i {
        font-size: 22px;
        line-height: 1;
        vertical-align: middle
      }

      html {
        overflow-x: hidden
      }

      .hfe-site-logo-container img {
        display: inline-block
      }

      .site-header-wishlist {
        position: relative
      }

      .site-header-wishlist .header-wishlist i {
        font-size: 23px;
        line-height: 1;
        vertical-align: middle;
        color: var(--accent)
      }

      .site-header-wishlist .header-wishlist .count {
        min-width: 16px;
        height: 16px;
        line-height: 16px;
        font-size: 10px;
        font-weight: 600;
        text-align: center;
        border-radius: 50%;
        display: inline-block;
        position: absolute;
        bottom: -6px;
        left: 10px;
        color: #ffffff;
        background-color: var(--primary)
      }

      .site-header-cart-side .widget_shopping_cart {
        margin-bottom: 0;
        position: relative;
        flex: 1 1 auto;
        display: flex
      }

      .site-header-cart-side .widget_shopping_cart .widget_shopping_cart_content {
        display: flex;
        flex-direction: column;
        flex: 1 1 auto
      }

      .hide-price-cart-yes .site-header-cart .cart-contents .amount {
        display: none
      }

      .footer-handheld a {
        display: block;
        color: var(--accent);
        text-align: center;
        padding: 10px 5px
      }

      .footer-handheld .title {
        font-weight: 600;
        font-size: 12px;
        display: block
      }

      .footer-handheld i {
        font-size: 20px;
        display: block;
        margin-bottom: -2px
      }

      .vertical-navigation {
        position: relative;
        background-color: var(--primary);
        height: 100%;
        border-radius: 8px 8px 0 0
      }

      .vertical-navigation .vertical-navigation-header {
        font-size: 14px;
        padding: 16px 25px;
        font-weight: 600;
        color: #fff;
        display: flex;
        align-items: center;
        height: 100%
      }

      .vertical-navigation .vertical-navigation-header i {
        font-size: 18px;
        vertical-align: middle;
        line-height: 1;
        margin-right: 15px
      }

      .vertical-navigation .vertical-navigation-header .vertical-navigation-title {
        display: -webkit-box;
        -webkit-line-clamp: 1;
        -webkit-box-orient: vertical;
        overflow: hidden;
        line-height: 1
      }

      .vertical-navigation .vertical-menu {
        position: absolute;
        top: 100%;
        left: 0;
        width: 100%;
        opacity: 0;
        visibility: hidden
      }

      .vertical-navigation .vertical-menu .menu {
        position: relative;
        list-style: none;
        margin: 0;
        border: 1px solid;
        border-color: var(--border);
        border-top: none;
        border-radius: 0 0 8px 8px;
        padding: 10px 0
      }

      .vertical-navigation .vertical-menu .menu>li>a {
        position: relative;
        font-weight: 400;
        padding: 8px 25px;
        display: flex;
        -webkit-box-align: center;
        align-items: center
      }

      .vertical-navigation .vertical-menu .menu>li.has-mega-menu>a:after,
      .vertical-navigation .vertical-menu .menu>li.menu-item-has-children>a:after {
        font-family: "organey-icon";
        -webkit-font-smoothing: antialiased;
        -moz-osx-font-smoothing: grayscale;
        display: inline-block;
        font-style: normal;
        font-variant: normal;
        font-weight: normal;
        content: "\e05a";
        float: right;
        line-height: 24px;
        color: var(--accent);
        float: right;
        margin-left: auto
      }

      .vertical-navigation ul.menu {
        list-style: none;
        margin: 0;
        background-color: #FFFFFF
      }

      .vertical-navigation ul.menu .sub-menu {
        position: absolute;
        padding: 13px 0;
        left: 100%;
        top: 0;
        visibility: hidden;
        opacity: 0;
        list-style: none;
        margin: 0;
        background: #fff;
        width: 260px;
        border-radius: 0 8px 8px 0;
        box-shadow: 0 0 50px 0 rgba(0, 0, 0, 0.07)
      }

      .vertical-navigation ul.menu .sub-menu>li {
        padding: 8px 20px 8px 25px
      }

      .vertical-navigation ul.menu>li {
        position: relative
      }

      .vertical-navigation ul.menu>li:before {
        content: "";
        display: block;
        position: absolute;
        width: calc(100% - 50px);
        height: 1px;
        right: 0;
        left: 0;
        margin: 0 auto;
        bottom: 0;
        border-bottom: 1px solid var(--border)
      }

      .vertical-navigation ul.menu>li:last-child:before {
        display: none
      }

      .vertical-navigation ul.menu>li>a {
        color: var(--accent);
        font-size: 14px;
        padding: 0.5em 20px;
        display: block
      }

      .vertical-navigation ul.menu>li>a .menu-icon {
        font-size: 24px;
        margin-right: 15px;
        color: #838685
      }

      .sticky-header {
        --header-height: 80px;
        --opacity: 1;
        --shrink-me: 0.8;
        --sticky-background-color: #fff
      }

      :root {
        --scroll-bar: 8px
      }

      .elementor-widget-icon-list .elementor-icon-list-item a {
        align-items: center
      }

      .elementor-widget-icon-list .elementor-icon-list-icon {
        line-height: 1
      }

      .elementor-widget-icon-list .elementor-icon-list-icon i {
        text-align: center
      }

      @font-face {
        font-family: "star";
        src: url(https://demothemedh.b-cdn.net/organey/wp-content/plugins/woocommerce/assets/fonts/star.eot);
        src: url(https://demothemedh.b-cdn.net/organey/wp-content/plugins/woocommerce/assets/fonts/star.eot?#iefix) format("embedded-opentype"), url(https://demothemedh.b-cdn.net/organey/wp-content/plugins/woocommerce/assets/fonts/star.woff) format("woff"), url(https://demothemedh.b-cdn.net/organey/wp-content/plugins/woocommerce/assets/fonts/star.ttf) format("truetype"), url(https://demothemedh.b-cdn.net/organey/wp-content/plugins/woocommerce/assets/fonts/star.svg#star) format("svg");
        font-weight: normal;
        font-style: normal;
        font-display: swap
      }

      @font-face {
        font-family: "organey-icon";
        src: url(https://demothemedh.b-cdn.net/organey/wp-content/themes/organey/assets/fonts/organey-icon.eot);
        src: url(https://demothemedh.b-cdn.net/organey/wp-content/themes/organey/assets/fonts/organey-icon.eot?#iefix) format("eot"), url(https://demothemedh.b-cdn.net/organey/wp-content/themes/organey/assets/fonts/organey-icon.woff2) format("woff2"), url(https://demothemedh.b-cdn.net/organey/wp-content/themes/organey/assets/fonts/organey-icon.woff) format("woff"), url(https://demothemedh.b-cdn.net/organey/wp-content/themes/organey/assets/fonts/organey-icon.ttf) format("truetype"), url(https://demothemedh.b-cdn.net/organey/wp-content/themes/organey/assets/fonts/organey-icon.svg#organey-icon) format("svg");
        font-display: swap
      }

      [class*=organey-icon-] {
        font-family: "organey-icon";
        -webkit-font-smoothing: antialiased;
        -moz-osx-font-smoothing: grayscale;
        display: inline-block;
        font-style: normal;
        font-variant: normal;
        font-weight: normal
      }

      .price {
        font-size: 16px
      }

      .price ins {
        color: var(--primary);
        font-weight: 600
      }

      .price del {
        color: var(--light);
        font-size: 0.875em;
        font-weight: 400
      }

      .price del+ins {
        margin-left: 0.327em
      }

      .required {
        border-bottom: 0 !important;
        color: #e2401c
      }

      .star-rating {
        overflow: hidden;
        position: relative;
        height: 1.618em;
        line-height: 1.618;
        font-size: 12px;
        width: 6.3em;
        font-family: "star";
        font-weight: 400
      }

      .star-rating::before {
        content: "S S S S S";
        opacity: 0.25;
        float: left;
        top: 0;
        left: 0;
        position: absolute
      }

      .star-rating span {
        overflow: hidden;
        float: left;
        top: 0;
        left: 0;
        position: absolute;
        padding-top: 1.5em
      }

      .star-rating span::before {
        content: "S S S S S";
        top: 0;
        position: absolute;
        left: 0;
        color: #F5B400
      }

      ul.products {
        margin-left: -15px;
        margin-right: -15px;
        margin-bottom: 0;
        margin-top: 0;
        clear: both;
        display: flex;
        flex-wrap: wrap
      }

      ul.products li.product {
        padding: 20px 15px;
        list-style: none;
        position: relative;
        width: 100%
      }

      @media (max-width:767px) {
        ul.products li.product {
          margin-bottom: 1.41575em
        }
      }

      @media (min-width:450px) and (max-width:768px) {
        ul.products li.product {
          width: 50%
        }
      }

      ul.products li.product .price {
        font-size: 18px;
        display: block;
        font-weight: 600;
        color: var(--primary);
        line-height: 1.65
      }

      ul.products li.product .price del {
        color: var(--light);
        font-size: 0.875em;
        font-weight: 400
      }

      ul.products li.product h2,
      ul.products li.product .woocommerce-loop-product__title {
        font-weight: 400;
        font-size: 14px;
        line-height: 1.5;
        margin-top: 15px;
        margin-bottom: 7px
      }

      ul.products li.product h2 a,
      ul.products li.product .woocommerce-loop-product__title a {
        color: var(--accent)
      }

      ul.products li.product h2+.star-rating,
      ul.products li.product .woocommerce-loop-product__title+.star-rating {
        margin-bottom: 8px
      }

      ul.products li.product .star-rating {
        font-size: 14px;
        margin-left: auto;
        margin-right: auto
      }

      ul.products li.product img {
        display: block;
        margin: 0 auto;
        width: 100%
      }

      ul.products li.product a[class*=product_type_] {
        text-align: center;
        font-weight: 400;
        display: flex;
        align-items: center;
        justify-content: center;
        padding: 0.6em;
        background-color: transparent;
        color: var(--text);
        border: 1px solid;
        border-color: var(--border);
        font-size: 12px;
        text-transform: uppercase
      }

      ul.products li.product a[class*=product_type_]:before {
        font-family: "organey-icon";
        -webkit-font-smoothing: antialiased;
        -moz-osx-font-smoothing: grayscale;
        display: inline-block;
        font-style: normal;
        font-variant: normal;
        font-weight: normal;
        content: "\e003";
        margin-right: 10px;
        font-size: 16px;
        line-height: inherit;
        color: var(--primary)
      }

      .site-header-cart .cart-contents {
        color: var(--accent)
      }

      .site-header-cart .cart-contents i {
        font-size: 23px;
        line-height: 1;
        vertical-align: middle
      }

      .site-header-cart .cart-contents .count {
        min-width: 16px;
        height: 16px;
        line-height: 16px;
        font-size: 10px;
        font-weight: 600;
        text-align: center;
        border-radius: 50%;
        display: inline-block;
        position: absolute;
        bottom: -6px;
        left: 10px;
        color: #ffffff;
        background-color: var(--primary)
      }

      .site-header-cart .cart-contents .amount {
        font-weight: 600;
        font-size: 15px;
        margin-left: 9px;
        color: var(--accent)
      }

      @media (min-width:768px) {
        .site-header-cart {
          position: relative
        }

        .site-header-cart .cart-contents {
          display: flex;
          align-items: center;
          position: relative;
          text-indent: 0
        }

        .site-search {
          display: block
        }

        .site-search form {
          margin: 0
        }

        ul.products li.product {
          clear: none;
          width: 100%
        }

        ul.products.columns-1 li.product {
          flex: 0 0 100%;
          max-width: 100%
        }
      }

      @media (min-width:1024px) {
        .woocommerce.columns-1 ul.products li.product {
          width: 100%;
          flex: 0 0 100%;
          max-width: 100%
        }
      }

      .elementor-widget-organey-products ul.products .product-block-list .woocommerce-loop-product__title {
        margin-top: 0
      }

      .elementor-widget-organey-products ul.products .product-block-list .star-rating {
        margin-left: 0;
        margin-right: 0
      }

      .product-block-list.product-block-list-1 {
        padding: 30px;
        font-size: 15px;
        line-height: 24px;
        border-radius: 8px;
        border: 3px solid;
        border-color: var(--primary);
        background-color: var(--background)
      }

      .elementor-widget-organey-products ul.products .product-block-list.product-block-list-1 .woocommerce-loop-product__title {
        margin-top: 10px;
        font-size: 26px;
        line-height: 38px;
        font-weight: 600;
        margin-bottom: 15px;
        color: var(--accent)
      }

      @media (max-width:768px) {
        .elementor-widget-organey-products ul.products .product-block-list.product-block-list-1 .woocommerce-loop-product__title {
          font-size: 18px;
          line-height: 24px
        }
      }

      .elementor-widget-organey-products ul.products .product-block-list.product-block-list-1 .woocommerce-loop-product__title+.star-rating {
        margin-top: -10px
      }

      .elementor-widget-organey-products ul.products .product-block-list.product-block-list-1 .price {
        font-size: 20px;
        margin-bottom: 20px
      }

      .elementor-widget-organey-products ul.products .product-block-list.product-block-list-1 .price del {
        font-size: 16px
      }

      .elementor-widget-organey-products ul.products .product-block-list.product-block-list-1 .price ins {
        font-size: 20px
      }

      .elementor-widget-organey-products ul.products .product-block-list.product-block-list-1 .short-description {
        margin-bottom: 20px;
        padding-bottom: 20px;
        border-bottom: 1px solid;
        border-color: var(--border)
      }

      .elementor-widget-organey-products ul.products .product-block-list.product-block-list-1 .short-description ul {
        margin-left: 20px
      }

      .elementor-widget-organey-products ul.products .product-block-list.product-block-list-1 .add_to_cart_button {
        height: 50px;
        border-radius: 30px;
        border: 0;
        font-weight: 500;
        color: #fff;
        background-color: var(--primary)
      }

      .elementor-widget-organey-products ul.products .product-block-list.product-block-list-1 .add_to_cart_button:before {
        color: #fff
      }

      .product-block-list.product-block-list-1 .product-caption {
        display: flex;
        flex-wrap: wrap
      }

      .product-block-list.product-block-list-1 .product-caption>div {
        width: 100%
      }

      @media (min-width:768px) {
        .product-block-list.product-block-list-1 .product-caption>div {
          width: 50%
        }
      }

      .product-block-list.product-block-list-1 .product-caption .caption-left a {
        display: block;
        margin-right: 30px
      }

      .product-block-list.product-block-list-1 .product-caption .caption-left img {
        border: 1px solid var(--border);
        border-radius: 8px
      }

      .product-block-list.product-block-list-1 .star-rating {
        margin-bottom: 15px
      }

      .product-block-list.product-block-list-1 .product-caption-footer {
        display: flex;
        flex-wrap: wrap;
        align-items: center
      }

      .product-block-list.product-block-list-1 .product-caption-footer .add-to-cart {
        width: 100%
      }

      @media (min-width:768px) {
        .product-block-list.product-block-list-1 .product-caption-footer .add-to-cart {
          width: 40%
        }
      }

      .product-block-list.product-block-list-1 .product-caption-footer .time-sale {
        padding: 15px;
        width: 100%
      }

      @media (min-width:768px) {
        .product-block-list.product-block-list-1 .product-caption-footer .time-sale {
          width: 60%
        }
      }

      .time-sale {
        font-size: 16px;
        font-weight: 600;
        display: flex;
        flex-wrap: wrap;
        align-items: center
      }

      .time-sale .deal-text {
        color: var(--accent);
        font-weight: 400;
        margin-right: 10px
      }

      .time-sale .organey-countdown {
        display: flex;
        flex-wrap: wrap;
        justify-content: center;
        flex-direction: row;
        color: var(--primary)
      }

      .time-sale .countdown-item {
        position: relative
      }

      .time-sale .countdown-item+.countdown-item {
        margin-left: 3px
      }

      .time-sale .countdown-item:first-child:before {
        content: none
      }

      .time-sale .countdown-item:before {
        content: "\3a"
      }

      .time-sale .countdown-item .countdown-label {
        margin-left: -3px
      }

      .widget_product_search {
        position: relative
      }

      .ajax-search-result {
        position: absolute;
        top: 100%;
        left: 0;
        width: 100%;
        background-color: white;
        box-shadow: 0 5px 30px 0 rgba(0, 0, 0, 0.1);
        padding: 0 30px;
        z-index: 999;
        max-height: 500px;
        overflow-y: scroll
      }

      #wptime-plugin-preloader {
        background-size: 300px 100px !important
      }

      .rs-p-wp-fix {
        display: none !important;
        margin: 0 !important;
        height: 0 !important
      }

      rs-module-wrap {
        visibility: hidden
      }

      rs-module-wrap,
      rs-module-wrap * {
        box-sizing: border-box
      }

      rs-module-wrap {
        position: relative;
        z-index: 1;
        width: 100%;
        display: block
      }

      rs-module {
        position: relative;
        overflow: hidden;
        display: block
      }

      rs-module img {
        max-width: none !important;
        margin: 0;
        padding: 0;
        border: none
      }

      rs-slides,
      rs-slide,
      rs-slide:before {
        position: absolute;
        text-indent: 0;
        top: 0;
        left: 0
      }

      rs-slide,
      rs-slide:before {
        display: block;
        visibility: hidden
      }

      rs-module rs-layer {
        opacity: 0;
        position: relative;
        visibility: hidden;
        white-space: nowrap;
        display: block;
        -webkit-font-smoothing: antialiased !important;
        -moz-osx-font-smoothing: grayscale;
        z-index: 1;
        font-display: swap
      }

      rs-layer:not(.rs-wtbindex) {
        outline: none !important
      }

      rs-zone {
        position: absolute;
        width: 100%;
        left: 0;
        box-sizing: border-box;
        min-height: 50px;
        font-size: 0
      }

      rs-column {
        display: block;
        visibility: hidden
      }

      .rev_row_zone_top {
        top: 0
      }

      rs-row {
        display: table;
        position: relative;
        width: 100% !important;
        table-layout: fixed;
        box-sizing: border-box;
        vertical-align: top;
        height: auto;
        font-size: 0
      }

      rs-column {
        box-sizing: border-box;
        display: block;
        position: relative;
        width: 100% !important;
        height: auto !important;
        white-space: normal !important
      }

      .rev-btn,
      .rev-btn:visited {
        outline: none !important;
        box-shadow: none;
        text-decoration: none !important;
        box-sizing: border-box
      }
    </style>
    <link rel="preload" as="style" href="https://fonts.googleapis.com/css?family=Poppins%3A400%2C500%2C600%2C700%2C800%2C900%7CPoppins%3A100%2C100italic%2C200%2C200italic%2C300%2C300italic%2C400%2C400italic%2C500%2C500italic%2C600%2C600italic%2C700%2C700italic%2C800%2C800italic%2C900%2C900italic%7CRoboto%3A400%7CPoppins%3A400%2C900%2C500&amp;subset=latin%2Clatin-ext&amp;display=swap" />
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Poppins%3A400%2C500%2C600%2C700%2C800%2C900%7CPoppins%3A100%2C100italic%2C200%2C200italic%2C300%2C300italic%2C400%2C400italic%2C500%2C500italic%2C600%2C600italic%2C700%2C700italic%2C800%2C800italic%2C900%2C900italic%7CRoboto%3A400%7CPoppins%3A400%2C900%2C500&amp;subset=latin%2Clatin-ext&amp;display=swap" media="print" onload="this.media='all'" />
    <noscript>
      <link rel="preload" href="https://fonts.googleapis.com/css?family=Poppins%3A400%2C500%2C600%2C700%2C800%2C900%7CPoppins%3A100%2C100italic%2C200%2C200italic%2C300%2C300italic%2C400%2C400italic%2C500%2C500italic%2C600%2C600italic%2C700%2C700italic%2C800%2C800italic%2C900%2C900italic%7CRoboto%3A400%7CPoppins%3A400%2C900%2C500&amp;subset=latin%2Clatin-ext&amp;display=swap" data-rocket-async="style" as="style" onload="this.onload=null;this.rel='stylesheet'" />
    </noscript>
    <meta name='robots' content='max-image-preview:large' />
    <link rel='dns-prefetch' href='http://fonts.googleapis.com/' />
    <link rel='dns-prefetch' href='http://demothemedh.b-cdn.net/' />
    <link href='https://fonts.gstatic.com/' crossorigin rel='preconnect' />
    <link href='http://demothemedh.b-cdn.net/' rel='preconnect' />
    <link rel="alternate" type="application/rss+xml" title="Organey &raquo; Feed" href="feed/index.html" />
    <link rel="alternate" type="application/rss+xml" title="Organey &raquo; Comments Feed" href="comments/feed/index.html" />
    <style>
      img.wp-smiley,
      img.emoji {
        display: inline !important;
        border: none !important;
        box-shadow: none !important;
        height: 1em !important;
        width: 1em !important;
        margin: 0 0.07em !important;
        vertical-align: -0.1em !important;
        background: none !important;
        padding: 0 !important;
      }
    </style>
    <style id='global-styles-inline-css'>
      body {
        --wp--preset--color--black: #000000;
        --wp--preset--color--cyan-bluish-gray: #abb8c3;
        --wp--preset--color--white: #ffffff;
        --wp--preset--color--pale-pink: #f78da7;
        --wp--preset--color--vivid-red: #cf2e2e;
        --wp--preset--color--luminous-vivid-orange: #ff6900;
        --wp--preset--color--luminous-vivid-amber: #fcb900;
        --wp--preset--color--light-green-cyan: #7bdcb5;
        --wp--preset--color--vivid-green-cyan: #00d084;
        --wp--preset--color--pale-cyan-blue: #8ed1fc;
        --wp--preset--color--vivid-cyan-blue: #0693e3;
        --wp--preset--color--vivid-purple: #9b51e0;
        --wp--preset--gradient--vivid-cyan-blue-to-vivid-purple: linear-gradient(135deg, rgba(6, 147, 227, 1) 0%, rgb(155, 81, 224) 100%);
        --wp--preset--gradient--light-green-cyan-to-vivid-green-cyan: linear-gradient(135deg, rgb(122, 220, 180) 0%, rgb(0, 208, 130) 100%);
        --wp--preset--gradient--luminous-vivid-amber-to-luminous-vivid-orange: linear-gradient(135deg, rgba(252, 185, 0, 1) 0%, rgba(255, 105, 0, 1) 100%);
        --wp--preset--gradient--luminous-vivid-orange-to-vivid-red: linear-gradient(135deg, rgba(255, 105, 0, 1) 0%, rgb(207, 46, 46) 100%);
        --wp--preset--gradient--very-light-gray-to-cyan-bluish-gray: linear-gradient(135deg, rgb(238, 238, 238) 0%, rgb(169, 184, 195) 100%);
        --wp--preset--gradient--cool-to-warm-spectrum: linear-gradient(135deg, rgb(74, 234, 220) 0%, rgb(151, 120, 209) 20%, rgb(207, 42, 186) 40%, rgb(238, 44, 130) 60%, rgb(251, 105, 98) 80%, rgb(254, 248, 76) 100%);
        --wp--preset--gradient--blush-light-purple: linear-gradient(135deg, rgb(255, 206, 236) 0%, rgb(152, 150, 240) 100%);
        --wp--preset--gradient--blush-bordeaux: linear-gradient(135deg, rgb(254, 205, 165) 0%, rgb(254, 45, 45) 50%, rgb(107, 0, 62) 100%);
        --wp--preset--gradient--luminous-dusk: linear-gradient(135deg, rgb(255, 203, 112) 0%, rgb(199, 81, 192) 50%, rgb(65, 88, 208) 100%);
        --wp--preset--gradient--pale-ocean: linear-gradient(135deg, rgb(255, 245, 203) 0%, rgb(182, 227, 212) 50%, rgb(51, 167, 181) 100%);
        --wp--preset--gradient--electric-grass: linear-gradient(135deg, rgb(202, 248, 128) 0%, rgb(113, 206, 126) 100%);
        --wp--preset--gradient--midnight: linear-gradient(135deg, rgb(2, 3, 129) 0%, rgb(40, 116, 252) 100%);
        --wp--preset--duotone--dark-grayscale: url('#wp-duotone-dark-grayscale');
        --wp--preset--duotone--grayscale: url('#wp-duotone-grayscale');
        --wp--preset--duotone--purple-yellow: url('#wp-duotone-purple-yellow');
        --wp--preset--duotone--blue-red: url('#wp-duotone-blue-red');
        --wp--preset--duotone--midnight: url('#wp-duotone-midnight');
        --wp--preset--duotone--magenta-yellow: url('#wp-duotone-magenta-yellow');
        --wp--preset--duotone--purple-green: url('#wp-duotone-purple-green');
        --wp--preset--duotone--blue-orange: url('#wp-duotone-blue-orange');
        --wp--preset--font-size--small: 13px;
        --wp--preset--font-size--medium: 20px;
        --wp--preset--font-size--large: 36px;
        --wp--preset--font-size--x-large: 42px;
      }

      .has-black-color {
        color: var(--wp--preset--color--black) !important;
      }

      .has-cyan-bluish-gray-color {
        color: var(--wp--preset--color--cyan-bluish-gray) !important;
      }

      .has-white-color {
        color: var(--wp--preset--color--white) !important;
      }

      .has-pale-pink-color {
        color: var(--wp--preset--color--pale-pink) !important;
      }

      .has-vivid-red-color {
        color: var(--wp--preset--color--vivid-red) !important;
      }

      .has-luminous-vivid-orange-color {
        color: var(--wp--preset--color--luminous-vivid-orange) !important;
      }

      .has-luminous-vivid-amber-color {
        color: var(--wp--preset--color--luminous-vivid-amber) !important;
      }

      .has-light-green-cyan-color {
        color: var(--wp--preset--color--light-green-cyan) !important;
      }

      .has-vivid-green-cyan-color {
        color: var(--wp--preset--color--vivid-green-cyan) !important;
      }

      .has-pale-cyan-blue-color {
        color: var(--wp--preset--color--pale-cyan-blue) !important;
      }

      .has-vivid-cyan-blue-color {
        color: var(--wp--preset--color--vivid-cyan-blue) !important;
      }

      .has-vivid-purple-color {
        color: var(--wp--preset--color--vivid-purple) !important;
      }

      .has-black-background-color {
        background-color: var(--wp--preset--color--black) !important;
      }

      .has-cyan-bluish-gray-background-color {
        background-color: var(--wp--preset--color--cyan-bluish-gray) !important;
      }

      .has-white-background-color {
        background-color: var(--wp--preset--color--white) !important;
      }

      .has-pale-pink-background-color {
        background-color: var(--wp--preset--color--pale-pink) !important;
      }

      .has-vivid-red-background-color {
        background-color: var(--wp--preset--color--vivid-red) !important;
      }

      .has-luminous-vivid-orange-background-color {
        background-color: var(--wp--preset--color--luminous-vivid-orange) !important;
      }

      .has-luminous-vivid-amber-background-color {
        background-color: var(--wp--preset--color--luminous-vivid-amber) !important;
      }

      .has-light-green-cyan-background-color {
        background-color: var(--wp--preset--color--light-green-cyan) !important;
      }

      .has-vivid-green-cyan-background-color {
        background-color: var(--wp--preset--color--vivid-green-cyan) !important;
      }

      .has-pale-cyan-blue-background-color {
        background-color: var(--wp--preset--color--pale-cyan-blue) !important;
      }

      .has-vivid-cyan-blue-background-color {
        background-color: var(--wp--preset--color--vivid-cyan-blue) !important;
      }

      .has-vivid-purple-background-color {
        background-color: var(--wp--preset--color--vivid-purple) !important;
      }

      .has-black-border-color {
        border-color: var(--wp--preset--color--black) !important;
      }

      .has-cyan-bluish-gray-border-color {
        border-color: var(--wp--preset--color--cyan-bluish-gray) !important;
      }

      .has-white-border-color {
        border-color: var(--wp--preset--color--white) !important;
      }

      .has-pale-pink-border-color {
        border-color: var(--wp--preset--color--pale-pink) !important;
      }

      .has-vivid-red-border-color {
        border-color: var(--wp--preset--color--vivid-red) !important;
      }

      .has-luminous-vivid-orange-border-color {
        border-color: var(--wp--preset--color--luminous-vivid-orange) !important;
      }

      .has-luminous-vivid-amber-border-color {
        border-color: var(--wp--preset--color--luminous-vivid-amber) !important;
      }

      .has-light-green-cyan-border-color {
        border-color: var(--wp--preset--color--light-green-cyan) !important;
      }

      .has-vivid-green-cyan-border-color {
        border-color: var(--wp--preset--color--vivid-green-cyan) !important;
      }

      .has-pale-cyan-blue-border-color {
        border-color: var(--wp--preset--color--pale-cyan-blue) !important;
      }

      .has-vivid-cyan-blue-border-color {
        border-color: var(--wp--preset--color--vivid-cyan-blue) !important;
      }

      .has-vivid-purple-border-color {
        border-color: var(--wp--preset--color--vivid-purple) !important;
      }

      .has-vivid-cyan-blue-to-vivid-purple-gradient-background {
        background: var(--wp--preset--gradient--vivid-cyan-blue-to-vivid-purple) !important;
      }

      .has-light-green-cyan-to-vivid-green-cyan-gradient-background {
        background: var(--wp--preset--gradient--light-green-cyan-to-vivid-green-cyan) !important;
      }

      .has-luminous-vivid-amber-to-luminous-vivid-orange-gradient-background {
        background: var(--wp--preset--gradient--luminous-vivid-amber-to-luminous-vivid-orange) !important;
      }

      .has-luminous-vivid-orange-to-vivid-red-gradient-background {
        background: var(--wp--preset--gradient--luminous-vivid-orange-to-vivid-red) !important;
      }

      .has-very-light-gray-to-cyan-bluish-gray-gradient-background {
        background: var(--wp--preset--gradient--very-light-gray-to-cyan-bluish-gray) !important;
      }

      .has-cool-to-warm-spectrum-gradient-background {
        background: var(--wp--preset--gradient--cool-to-warm-spectrum) !important;
      }

      .has-blush-light-purple-gradient-background {
        background: var(--wp--preset--gradient--blush-light-purple) !important;
      }

      .has-blush-bordeaux-gradient-background {
        background: var(--wp--preset--gradient--blush-bordeaux) !important;
      }

      .has-luminous-dusk-gradient-background {
        background: var(--wp--preset--gradient--luminous-dusk) !important;
      }

      .has-pale-ocean-gradient-background {
        background: var(--wp--preset--gradient--pale-ocean) !important;
      }

      .has-electric-grass-gradient-background {
        background: var(--wp--preset--gradient--electric-grass) !important;
      }

      .has-midnight-gradient-background {
        background: var(--wp--preset--gradient--midnight) !important;
      }

      .has-small-font-size {
        font-size: var(--wp--preset--font-size--small) !important;
      }

      .has-medium-font-size {
        font-size: var(--wp--preset--font-size--medium) !important;
      }

      .has-large-font-size {
        font-size: var(--wp--preset--font-size--large) !important;
      }

      .has-x-large-font-size {
        font-size: var(--wp--preset--font-size--x-large) !important;
      }
    </style>
    <link data-minify="1" rel='preload' href="{{ asset('frontend/plugins/contact-form-7/includes/css/stylesfbc9.css?ver=1653443926') }}" data-rocket-async="style" as="style" onload="this.onload=null;this.rel='stylesheet'" media='all' />
    <style id='woocommerce-inline-inline-css'>
      .woocommerce form .form-row .required {
        visibility: visible;
      }
    </style>
    <link data-minify="1" rel='preload' href="{{ asset('frontend/plugins/header-footer-elementor/assets/css/header-footer-elementorfbc9.css?ver=1653443926') }}" data-rocket-async="style" as="style" onload="this.onload=null;this.rel='stylesheet'" media='all' />
    <link data-minify="1" rel='preload' href="{{ asset('frontend/plugins/elementor/assets/lib/eicons/css/elementor-icons.minfbc9.css?ver=1653443926') }}" data-rocket-async="style" as="style" onload="this.onload=null;this.rel='stylesheet'" media='all' />
    <link rel='preload' href="{{ asset('frontend/plugins/elementor/assets/css/frontend.min3ab2.css?ver=3.6.5') }}" data-rocket-async="style" as="style" onload="this.onload=null;this.rel='stylesheet'" media='all' />
    <link data-minify="1" rel='preload' href="{{ asset('frontend/uploads/elementor/css/post-11fbc9.css?ver=1653443926') }}" data-rocket-async="style" as="style" onload="this.onload=null;this.rel='stylesheet'" media='all' />
    <link data-minify="1" rel='preload' href="{{ asset('frontend/uploads/elementor/css/globalfbc9.css?ver=1653443926') }}" data-rocket-async="style" as="style" onload="this.onload=null;this.rel='stylesheet'" media='all' />
    <link data-minify="1" rel='preload' href="{{ asset('frontend/uploads/elementor/css/post-31249d6.css?ver=1653443927') }}" data-rocket-async="style" as="style" onload="this.onload=null;this.rel='stylesheet'" media='all' />
    <link data-minify="1" rel='preload' href="{{ asset('frontend/plugins/header-footer-elementor/inc/widgets-css/frontend49d6.css?ver=1653443927') }}" data-rocket-async="style" as="style" onload="this.onload=null;this.rel='stylesheet'" media='all' />
    <link data-minify="1" rel='preload' href="{{ asset('frontend/uploads/elementor/css/post-267149d6.css?ver=1653443927') }}" data-rocket-async="style" as="style" onload="this.onload=null;this.rel='stylesheet'" media='all' />
    <link data-minify="1" rel='preload' href="{{ asset('frontend/uploads/elementor/css/post-11249d6.css?ver=1653443927') }}" data-rocket-async="style" as="style" onload="this.onload=null;this.rel='stylesheet'" media='all' />
    <link data-minify="1" rel='preload' href="{{ asset('frontend/uploads/elementor/css/post-408349d6.css?ver=1653443927') }}" data-rocket-async="style" as="style" onload="this.onload=null;this.rel='stylesheet'" media='all' />
    <link rel='preload' href="{{ asset('frontend/plugins/woo-smart-compare/assets/libs/hint/hint.min7404.css?ver=5.9.3') }}" data-rocket-async="style" as="style" onload="this.onload=null;this.rel='stylesheet'" media='all' />
    <link rel='preload' href="{{ asset('frontend/plugins/woo-smart-compare/assets/libs/perfect-scrollbar/css/perfect-scrollbar.min7404.css?ver=5.9.3') }}" data-rocket-async="style" as="style" onload="this.onload=null;this.rel='stylesheet'" media='all' />
    <link data-minify="1" rel='preload' href="{{ asset('frontend/plugins/woo-smart-compare/assets/libs/perfect-scrollbar/css/custom-theme49d6.css?ver=1653443927') }}" data-rocket-async="style" as="style" onload="this.onload=null;this.rel='stylesheet'" media='all' />
    <link data-minify="1" rel='preload' href="{{ asset('frontend/plugins/woo-smart-compare/assets/css/frontend49d6.css?ver=1653443927') }}" data-rocket-async="style" as="style" onload="this.onload=null;this.rel='stylesheet'" media='all' />
    <link data-minify="1" rel='preload' href="{{ asset('frontend/plugins/woo-smart-quick-view/assets/libs/slick/slick49d6.css?ver=1653443927') }}" data-rocket-async="style" as="style" onload="this.onload=null;this.rel='stylesheet'" media='all' />
    <link data-minify="1" rel='preload' href="{{ asset('frontend/plugins/woo-smart-quick-view/assets/libs/magnific-popup/magnific-popup49d6.css?ver=1653443927') }}" data-rocket-async="style" as="style" onload="this.onload=null;this.rel='stylesheet'" media='all' />
    <link data-minify="1" rel='preload' href="{{ asset('frontend/plugins/woo-smart-quick-view/assets/libs/feather/feather49d6.css?ver=1653443927') }}" data-rocket-async="style" as="style" onload="this.onload=null;this.rel='stylesheet'" media='all' />
    <link data-minify="1" rel='preload' href="{{ asset('frontend/plugins/woo-smart-quick-view/assets/css/frontend49d6.css?ver=1653443927') }}" data-rocket-async="style" as="style" onload="this.onload=null;this.rel='stylesheet'" media='all' />
    <link data-minify="1" rel='preload' href="{{ asset('frontend/plugins/woo-smart-wishlist/assets/libs/feather/feather49d6.css?ver=1653443927') }}" data-rocket-async="style" as="style" onload="this.onload=null;this.rel='stylesheet'" media='all' />
    <link data-minify="1" rel='preload' href="{{ asset('frontend/plugins/woo-smart-wishlist/assets/css/frontend49d6.css?ver=1653443927') }}" data-rocket-async="style" as="style" onload="this.onload=null;this.rel='stylesheet'" media='all' />
    <style id='woosw-frontend-inline-css'>
      .woosw-popup .woosw-popup-inner .woosw-popup-content .woosw-popup-content-bot .woosw-notice {
        background-color: #5fbd74;
      }

      .woosw-popup .woosw-popup-inner .woosw-popup-content .woosw-popup-content-bot .woosw-popup-content-bot-inner .woosw-page a:hover,
      .woosw-popup .woosw-popup-inner .woosw-popup-content .woosw-popup-content-bot .woosw-popup-content-bot-inner .woosw-continue:hover {
        color: #5fbd74;
      }
    </style>
    <link data-minify="1" rel='preload' href="{{ asset('frontend/themes/organey/style49d6.css?ver=1653443927') }}" data-rocket-async="style" as="style" onload="this.onload=null;this.rel='stylesheet'" media='all' />
    <style id='organey-style-inline-css'>
      body {
        --primary: #5C9963;
        --primary_hover: #528959;
        --secondary: #FFA900;
        --secondary_hover: #ff8d00;
        --text: #656766;
        --accent: #2F3E30;
        --border: #E4E4E4;
        --light: #9f9f9f;
      }
    </style>
    <link rel='preload' href="{{ asset('frontend/plugins/woo-variation-swatches/assets/css/frontend.min573a.css?ver=1.1.19') }}" data-rocket-async="style" as="style" onload="this.onload=null;this.rel='stylesheet'" media='all' />
    <style id='woo-variation-swatches-inline-css'>
      .variable-item:not(.radio-variable-item) {
        width: 30px;
        height: 30px;
      }

      .wvs-style-squared .button-variable-item {
        min-width: 30px;
      }

      .button-variable-item span {
        font-size: 16px;
      }
    </style>
    <link rel='preload' href="{{ asset('frontend/css/post-7851171d.css') }}" data-rocket-async="style" as="style" onload="this.onload=null;this.rel='stylesheet'" media='all' />
    <link rel='preload' href="{{ asset('frontend/plugins/woo-variation-swatches/assets/css/wvs-theme-override.min573a.css?ver=1.1.19') }}" data-rocket-async="style" as="style" onload="this.onload=null;this.rel='stylesheet'" media='all' />
    <link rel='preload' href="{{ asset('frontend/plugins/woo-variation-swatches/assets/css/frontend-tooltip.min573a.css?ver=1.1.19') }}" data-rocket-async="style" as="style" onload="this.onload=null;this.rel='stylesheet'" media='all' />
    <link data-minify="1" rel='preload' href="{{ asset('frontend/themes/organey/elementor49d6.css?ver=1653443927') }}" data-rocket-async="style" as="style" onload="this.onload=null;this.rel='stylesheet'" media='all' />
    <link data-minify="1" rel='preload' href="{{ asset('frontend/themes/organey/woocommerce49d6.css?ver=1653443927') }}" data-rocket-async="style" as="style" onload="this.onload=null;this.rel='stylesheet'" media='all' />
    <link data-minify="1" rel='preload' href="{{ asset('frontend/themes/demo-child/style49d6.css?ver=1653443927') }}" data-rocket-async="style" as="style" onload="this.onload=null;this.rel='stylesheet'" media='all' />
    <link rel='preload' href="{{ asset('frontend/plugins/elementor/assets/lib/font-awesome/css/fontawesome.min52d5.css?ver=5.15.3') }}" data-rocket-async="style" as="style" onload="this.onload=null;this.rel='stylesheet'" media='all' />
    <link data-minify="1" rel='preload' href="{{ asset('frontend/plugins/elementor/assets/lib/font-awesome/css/solid.min49d6.css?ver=1653443927') }}" data-rocket-async="style" as="style" onload="this.onload=null;this.rel='stylesheet'" media='all' />
    <link data-minify="1" rel='preload' href="{{ asset('frontend/plugins/elementor/assets/lib/font-awesome/css/regular.min49d6.css?ver=1653443927') }}" data-rocket-async="style" as="style" onload="this.onload=null;this.rel='stylesheet'" media='all' />
    <script src="{{ asset('frontend/js/jquery/jquery.minaf6c.js?ver=3.6.0') }}" id='jquery-core-js' defer></script>
    <script src="{{ asset('frontend/js/jquery/jquery-migrate.mind617.js?ver=3.3.2') }}" id='jquery-migrate-js' defer></script>
    <link rel="https://api.w.org/" href="wp-json/index.html" />
    <link rel="alternate" type="application/json" href="{{ asset('frontend/json/wp/v2/pages/312.json') }}" />
    <link rel="EditURI" type="application/rsd+xml" title="RSD" href="xmlrpc0db0.php?rsd" />
    <link rel="wlwmanifest" type="application/wlwmanifest+xml" href="https://demothemedh.b-cdn.net/organey/wp-includes/wlwmanifest.xml" />
    <meta name="generator" content="WordPress 5.9.3" />
    <meta name="generator" content="WooCommerce 6.5.1" />
    <link rel="canonical" href="index.html" />
    <link rel='shortlink' href='index.html' />
    <link rel="alternate" type="application/json+oembed" href="{{ asset('frontend/json/oembed/1.0/embedc389.json?url=https%3A%2F%2Fdemo.leebrosus.com%2Forganey%2F') }}" />
    <link rel="alternate" type="text/xml+oembed" href="{{ asset('frontend/json/oembed/1.0/embedee66?url=https%3A%2F%2Fdemo.leebrosus.com%2Forganey%2F&amp;format=xml') }}" />
    <link rel="icon" href="{{ asset('images/favicon.png') }}" type="image/x-icon" />
    <link rel="dns-prefetch" href="http://fonts.googleapis.com/">
    <link rel="dns-prefetch" href="http://s.w.org/">
    <noscript>
      <style>
        .woocommerce-product-gallery {
          opacity: 1 !important;
        }
      </style>
    </noscript>

    <style id="wp-custom-css">
      .footer-handheld i {
        font-size: 20px;
        margin-bottom: -2px;
      }
    </style>
    <noscript>
      <style id="rocket-lazyload-nojs-css">
        .rll-youtube-player,
        [data-lazy-src] {
          display: none !important;
        }
      </style>
    </noscript>
    
    <link rel="stylesheet" type="text/css" href="{{ asset('frontend/css/custom.css') }}">

@stack('styles')

  </head>
  <body class="home page-template page-template-elementor_header_footer page page-id-312 wp-custom-logo wp-embed-responsive theme-organey woocommerce-no-js ehf-header ehf-footer ehf-template-organey ehf-stylesheet-demo-child woo-variation-swatches wvs-theme-demo-child wvs-theme-child-organey wvs-style-rounded wvs-attr-behavior-blur wvs-tooltip wvs-css wvs-show-label chrome woocommerce-active elementor-default elementor-template-full-width elementor-kit-11 elementor-page elementor-page-312">
    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 0 0" width="0" height="0" focusable="false" role="none" style="visibility: hidden; position: absolute; left: -9999px; overflow: hidden;">
      <defs>
        <filter id="wp-duotone-dark-grayscale">
          <feColorMatrix color-interpolation-filters="sRGB" type="matrix" values=" .299 .587 .114 0 0 .299 .587 .114 0 0 .299 .587 .114 0 0 .299 .587 .114 0 0 " />
          <feComponentTransfer color-interpolation-filters="sRGB">
            <feFuncR type="table" tableValues="0 0.49803921568627" />
            <feFuncG type="table" tableValues="0 0.49803921568627" />
            <feFuncB type="table" tableValues="0 0.49803921568627" />
            <feFuncA type="table" tableValues="1 1" />
          </feComponentTransfer>
          <feComposite in2="SourceGraphic" operator="in" />
        </filter>
      </defs>
    </svg>
    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 0 0" width="0" height="0" focusable="false" role="none" style="visibility: hidden; position: absolute; left: -9999px; overflow: hidden;">
      <defs>
        <filter id="wp-duotone-grayscale">
          <feColorMatrix color-interpolation-filters="sRGB" type="matrix" values=" .299 .587 .114 0 0 .299 .587 .114 0 0 .299 .587 .114 0 0 .299 .587 .114 0 0 " />
          <feComponentTransfer color-interpolation-filters="sRGB">
            <feFuncR type="table" tableValues="0 1" />
            <feFuncG type="table" tableValues="0 1" />
            <feFuncB type="table" tableValues="0 1" />
            <feFuncA type="table" tableValues="1 1" />
          </feComponentTransfer>
          <feComposite in2="SourceGraphic" operator="in" />
        </filter>
      </defs>
    </svg>
    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 0 0" width="0" height="0" focusable="false" role="none" style="visibility: hidden; position: absolute; left: -9999px; overflow: hidden;">
      <defs>
        <filter id="wp-duotone-purple-yellow">
          <feColorMatrix color-interpolation-filters="sRGB" type="matrix" values=" .299 .587 .114 0 0 .299 .587 .114 0 0 .299 .587 .114 0 0 .299 .587 .114 0 0 " />
          <feComponentTransfer color-interpolation-filters="sRGB">
            <feFuncR type="table" tableValues="0.54901960784314 0.98823529411765" />
            <feFuncG type="table" tableValues="0 1" />
            <feFuncB type="table" tableValues="0.71764705882353 0.25490196078431" />
            <feFuncA type="table" tableValues="1 1" />
          </feComponentTransfer>
          <feComposite in2="SourceGraphic" operator="in" />
        </filter>
      </defs>
    </svg>
    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 0 0" width="0" height="0" focusable="false" role="none" style="visibility: hidden; position: absolute; left: -9999px; overflow: hidden;">
      <defs>
        <filter id="wp-duotone-blue-red">
          <feColorMatrix color-interpolation-filters="sRGB" type="matrix" values=" .299 .587 .114 0 0 .299 .587 .114 0 0 .299 .587 .114 0 0 .299 .587 .114 0 0 " />
          <feComponentTransfer color-interpolation-filters="sRGB">
            <feFuncR type="table" tableValues="0 1" />
            <feFuncG type="table" tableValues="0 0.27843137254902" />
            <feFuncB type="table" tableValues="0.5921568627451 0.27843137254902" />
            <feFuncA type="table" tableValues="1 1" />
          </feComponentTransfer>
          <feComposite in2="SourceGraphic" operator="in" />
        </filter>
      </defs>
    </svg>
    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 0 0" width="0" height="0" focusable="false" role="none" style="visibility: hidden; position: absolute; left: -9999px; overflow: hidden;">
      <defs>
        <filter id="wp-duotone-midnight">
          <feColorMatrix color-interpolation-filters="sRGB" type="matrix" values=" .299 .587 .114 0 0 .299 .587 .114 0 0 .299 .587 .114 0 0 .299 .587 .114 0 0 " />
          <feComponentTransfer color-interpolation-filters="sRGB">
            <feFuncR type="table" tableValues="0 0" />
            <feFuncG type="table" tableValues="0 0.64705882352941" />
            <feFuncB type="table" tableValues="0 1" />
            <feFuncA type="table" tableValues="1 1" />
          </feComponentTransfer>
          <feComposite in2="SourceGraphic" operator="in" />
        </filter>
      </defs>
    </svg>
    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 0 0" width="0" height="0" focusable="false" role="none" style="visibility: hidden; position: absolute; left: -9999px; overflow: hidden;">
      <defs>
        <filter id="wp-duotone-magenta-yellow">
          <feColorMatrix color-interpolation-filters="sRGB" type="matrix" values=" .299 .587 .114 0 0 .299 .587 .114 0 0 .299 .587 .114 0 0 .299 .587 .114 0 0 " />
          <feComponentTransfer color-interpolation-filters="sRGB">
            <feFuncR type="table" tableValues="0.78039215686275 1" />
            <feFuncG type="table" tableValues="0 0.94901960784314" />
            <feFuncB type="table" tableValues="0.35294117647059 0.47058823529412" />
            <feFuncA type="table" tableValues="1 1" />
          </feComponentTransfer>
          <feComposite in2="SourceGraphic" operator="in" />
        </filter>
      </defs>
    </svg>
    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 0 0" width="0" height="0" focusable="false" role="none" style="visibility: hidden; position: absolute; left: -9999px; overflow: hidden;">
      <defs>
        <filter id="wp-duotone-purple-green">
          <feColorMatrix color-interpolation-filters="sRGB" type="matrix" values=" .299 .587 .114 0 0 .299 .587 .114 0 0 .299 .587 .114 0 0 .299 .587 .114 0 0 " />
          <feComponentTransfer color-interpolation-filters="sRGB">
            <feFuncR type="table" tableValues="0.65098039215686 0.40392156862745" />
            <feFuncG type="table" tableValues="0 1" />
            <feFuncB type="table" tableValues="0.44705882352941 0.4" />
            <feFuncA type="table" tableValues="1 1" />
          </feComponentTransfer>
          <feComposite in2="SourceGraphic" operator="in" />
        </filter>
      </defs>
    </svg>
    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 0 0" width="0" height="0" focusable="false" role="none" style="visibility: hidden; position: absolute; left: -9999px; overflow: hidden;">
      <defs>
        <filter id="wp-duotone-blue-orange">
          <feColorMatrix color-interpolation-filters="sRGB" type="matrix" values=" .299 .587 .114 0 0 .299 .587 .114 0 0 .299 .587 .114 0 0 .299 .587 .114 0 0 " />
          <feComponentTransfer color-interpolation-filters="sRGB">
            <feFuncR type="table" tableValues="0.098039215686275 1" />
            <feFuncG type="table" tableValues="0 0.66274509803922" />
            <feFuncB type="table" tableValues="0.84705882352941 0.41960784313725" />
            <feFuncA type="table" tableValues="1 1" />
          </feComponentTransfer>
          <feComposite in2="SourceGraphic" operator="in" />
        </filter>
      </defs>
    </svg>
    <div id="wptime-plugin-preloader"></div>
    

<x-header/>
    
<div data-elementor-type="wp-page" data-elementor-id="312" class="elementor elementor-312">
    
   @yield('content')

<div class='footer-width-fixer'>
  <div data-elementor-type="wp-post" data-elementor-id="4083" class="elementor elementor-4083">
    <section class="elementor-section elementor-top-section elementor-element elementor-element-79364e1 elementor-section-stretched elementor-hidden-desktop elementor-section-content-middle elementor-section-boxed elementor-section-height-default elementor-section-height-default" data-id="79364e1" data-element_type="section" data-settings="{&quot;stretch_section&quot;:&quot;section-stretched&quot;,&quot;background_background&quot;:&quot;classic&quot;}">
      <div class="elementor-container elementor-column-gap-no">
        <div class="elementor-column elementor-col-25 elementor-top-column elementor-element elementor-element-8596078" data-id="8596078" data-element_type="column">
          <div class="elementor-widget-wrap elementor-element-populated">
            <div class="elementor-element elementor-element-14702ff elementor-view-default elementor-mobile-position-top elementor-vertical-align-top elementor-widget elementor-widget-icon-box" data-id="14702ff" data-element_type="widget" data-widget_type="icon-box.default">
              <div class="elementor-widget-container">
                <div class="elementor-icon-box-wrapper">
                  <div class="elementor-icon-box-icon">
                    <a class="elementor-icon elementor-animation-" href="index.html">
                      <i aria-hidden="true" class="organey-icon- organey-icon-home"></i>
                    </a>
                  </div>
                  <div class="elementor-icon-box-content">
                    <h3 class="elementor-icon-box-title">
                      <a href="index.html"> Shop </a>
                    </h3>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
        <div class="elementor-column elementor-col-25 elementor-top-column elementor-element elementor-element-3d036ab" data-id="3d036ab" data-element_type="column" data-settings="{&quot;background_background&quot;:&quot;classic&quot;}">
          <div class="elementor-widget-wrap elementor-element-populated">
            <div class="elementor-element elementor-element-c50db3d elementor-view-default elementor-mobile-position-top elementor-vertical-align-top elementor-widget elementor-widget-icon-box" data-id="c50db3d" data-element_type="widget" data-widget_type="icon-box.default">
              <div class="elementor-widget-container">
                <div class="elementor-icon-box-wrapper">
                  <div class="elementor-icon-box-icon">
                    <a class="elementor-icon elementor-animation-" href="my-account/index.html">
                      <i aria-hidden="true" class="organey-icon- organey-icon-user"></i>
                    </a>
                  </div>
                  <div class="elementor-icon-box-content">
                    <h3 class="elementor-icon-box-title">
                      <a href="my-account/index.html"> My Account </a>
                    </h3>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
        <div class="elementor-column elementor-col-25 elementor-top-column elementor-element elementor-element-e993fd0" data-id="e993fd0" data-element_type="column">
          <div class="elementor-widget-wrap elementor-element-populated">
            <div class="elementor-element elementor-element-e04d267 elementor-widget elementor-widget-organey-handheld-footer" data-id="e04d267" data-element_type="widget" data-widget_type="organey-handheld-footer.default">
              <div class="elementor-widget-container">
                <div class="footer-handheld">
                  <a class="button-search-popup" href="#">
                    <i class="organey-icon-search"></i>
                    <span class="title">Search</span>
                  </a>
                </div>
              </div>
            </div>
          </div>
        </div>
        <div class="elementor-column elementor-col-25 elementor-top-column elementor-element elementor-element-af0387d" data-id="af0387d" data-element_type="column">
          <div class="elementor-widget-wrap elementor-element-populated">
            <div class="elementor-element elementor-element-c5a6223 elementor-view-default elementor-mobile-position-top elementor-vertical-align-top elementor-widget elementor-widget-icon-box" data-id="c5a6223" data-element_type="widget" data-widget_type="icon-box.default">
              <div class="elementor-widget-container">
                <div class="elementor-icon-box-wrapper">
                  <div class="elementor-icon-box-icon">
                    <a class="elementor-icon elementor-animation-" href="wishlist/index.html">
                      <i aria-hidden="true" class="organey-icon- organey-icon-heart"></i>
                    </a>
                  </div>
                  <div class="elementor-icon-box-content">
                    <h3 class="elementor-icon-box-title">
                      <a href="wishlist/index.html"> Wishlist </a>
                    </h3>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </section>
  </div>
</div>

<footer itemtype="https://schema.org/WPFooter" itemscope="itemscope" id="colophon" role="contentinfo">
  <div class='footer-width-fixer'>
    <div data-elementor-type="wp-post" data-elementor-id="112" class="elementor elementor-112">
      <section class="elementor-section elementor-top-section elementor-element elementor-element-28faedf elementor-section-stretched elementor-section-boxed elementor-section-height-default elementor-section-height-default" data-id="28faedf" data-element_type="section" data-settings="{&quot;stretch_section&quot;:&quot;section-stretched&quot;,&quot;background_background&quot;:&quot;classic&quot;}">
        <div class="elementor-container elementor-column-gap-no">
          <div class="elementor-column elementor-col-100 elementor-top-column elementor-element elementor-element-ff1f479" data-id="ff1f479" data-element_type="column">
            <div class="elementor-widget-wrap elementor-element-populated">
              <section class="elementor-section elementor-inner-section elementor-element elementor-element-bc54eed elementor-section-full_width elementor-section-height-default elementor-section-height-default" data-id="bc54eed" data-element_type="section" data-settings="{&quot;background_background&quot;:&quot;classic&quot;}">
                <div class="elementor-container elementor-column-gap-no">
                  <div class="elementor-column elementor-col-50 elementor-inner-column elementor-element elementor-element-b2c9afe" data-id="b2c9afe" data-element_type="column">
                    <div class="elementor-widget-wrap elementor-element-populated">
                      <div class="elementor-element elementor-element-955524b elementor-widget__width-auto elementor-hidden-phone elementor-view-stacked elementor-shape-circle elementor-widget elementor-widget-icon" data-id="955524b" data-element_type="widget" data-widget_type="icon.default">
                        <div class="elementor-widget-container">
                          <div class="elementor-icon-wrapper">
                            <div class="elementor-icon">
                              <i aria-hidden="true" class="organey-icon- organey-icon-envelope"></i>
                            </div>
                          </div>
                        </div>
                      </div>
                      <div class="elementor-element elementor-element-e0e41a2 elementor-widget__width-auto elementor-widget-mobile__width-auto elementor-widget elementor-widget-heading" data-id="e0e41a2" data-element_type="widget" data-widget_type="heading.default">
                        <div class="elementor-widget-container">
                          <h2 class="elementor-heading-title elementor-size-default">SIGN UP FOR NEWSLETTERS</h2>
                        </div>
                      </div>
                    </div>
                  </div>
                  <div class="elementor-column elementor-col-50 elementor-inner-column elementor-element elementor-element-3e74ae6" data-id="3e74ae6" data-element_type="column">
                    <div class="elementor-widget-wrap elementor-element-populated">
                      <div class="elementor-element elementor-element-4571f42 elementor-widget-tablet__width-initial elementor-widget elementor-widget-organey-mailchmip" data-id="4571f42" data-element_type="widget" data-widget_type="organey-mailchmip.default">
                        <div class="elementor-widget-container">
                          <div class="form-style">
                            <form id="mc4wp-form-1" class="mc4wp-form mc4wp-form-107" method="post" data-id="107" data-name="Organey Mail Chimp">
                              <div class="mc4wp-form-fields">
                                <input type="email" name="EMAIL" placeholder="Email address" required />
                                <input type="submit" value="Subscribe" />
                              </div>
                              <label style="display: none !important;">Leave this field empty if you're human: <input type="text" name="_mc4wp_honeypot" value="" tabindex="-1" autocomplete="off" />
                              </label>
                              <input type="hidden" name="_mc4wp_timestamp" value="1657801639" />
                              <input type="hidden" name="_mc4wp_form_id" value="107" />
                              <input type="hidden" name="_mc4wp_form_element_id" value="mc4wp-form-1" />
                              <div class="mc4wp-response"></div>
                            </form>
                          </div>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
              </section>
              <section class="elementor-section elementor-inner-section elementor-element elementor-element-0d4300b elementor-section-full_width elementor-section-height-default elementor-section-height-default" data-id="0d4300b" data-element_type="section">
                <div class="elementor-container elementor-column-gap-no">
                  <div class="elementor-column elementor-col-25 elementor-inner-column elementor-element elementor-element-67d8865" data-id="67d8865" data-element_type="column">
                    <div class="elementor-widget-wrap elementor-element-populated">
                      <div class="elementor-element elementor-element-67708fc elementor-widget elementor-widget-heading" data-id="67708fc" data-element_type="widget" data-widget_type="heading.default">
                        <div class="elementor-widget-container">
                          <h2 class="elementor-heading-title elementor-size-default">STORE LOCATION</h2>
                        </div>
                      </div>
                      <div class="elementor-element elementor-element-cd0e059 elementor-widget elementor-widget-text-editor" data-id="cd0e059" data-element_type="widget" data-widget_type="text-editor.default">
                        <div class="elementor-widget-container">We reserve the right to modify the existent privacy policy at any time; hence it is important that you review
                        </div>
                      </div>
                      <div class="elementor-element elementor-element-e482e49 elementor-icon-list--layout-traditional elementor-list-item-link-full_width elementor-widget elementor-widget-icon-list" data-id="e482e49" data-element_type="widget" data-widget_type="icon-list.default">
                        <div class="elementor-widget-container">
                          <ul class="elementor-icon-list-items">
                            <li class="elementor-icon-list-item">
                              <a href="#">
                                <span class="elementor-icon-list-icon">
                                  <i aria-hidden="true" class="far fa-envelope"></i>
                                </span>
                                <span class="elementor-icon-list-text">
                                  <span class="__cf_email__" data-cfemail="f99a96978d989a8db99c81989489959cd79a9694">[email&#160;protected]</span>
                                </span>
                              </a>
                            </li>
                            <li class="elementor-icon-list-item">
                              <a href="#">
                                <span class="elementor-icon-list-icon">
                                  <i aria-hidden="true" class="fas fa-phone-alt"></i>
                                </span>
                                <span class="elementor-icon-list-text">011-42207478</span>
                              </a>
                            </li>
                          </ul>
                        </div>
                      </div>
                    </div>
                  </div>
                  <div class="elementor-column elementor-col-25 elementor-inner-column elementor-element elementor-element-e6d95ba" data-id="e6d95ba" data-element_type="column">
                    <div class="elementor-widget-wrap elementor-element-populated">
                      <div class="elementor-element elementor-element-98f826a elementor-widget elementor-widget-heading" data-id="98f826a" data-element_type="widget" data-widget_type="heading.default">
                        <div class="elementor-widget-container">
                          <h2 class="elementor-heading-title elementor-size-default">INFORMATION</h2>
                        </div>
                      </div>
                      <div class="elementor-element elementor-element-ad5527a elementor-icon-list--layout-traditional elementor-list-item-link-full_width elementor-widget elementor-widget-icon-list" data-id="ad5527a" data-element_type="widget" data-widget_type="icon-list.default">
                        <div class="elementor-widget-container">
                          <ul class="elementor-icon-list-items">
                            <li class="elementor-icon-list-item">
                              <a href="#">
                                <span class="elementor-icon-list-text">About us</span>
                              </a>
                            </li>
                            <li class="elementor-icon-list-item">
                              <a href="{{ route('privacy') }}">
                                <span class="elementor-icon-list-text">Privacy Policy</span>
                              </a>
                            </li>
                            <li class="elementor-icon-list-item">
                              <a href="{{ route('terms_conditions') }}">
                                <span class="elementor-icon-list-text">Terms and Conditions</span>
                              </a>
                            </li>
                            <li class="elementor-icon-list-item">
                              <a href="#">
                                <span class="elementor-icon-list-text">Contact</span>
                              </a>
                            </li>
                            <li class="elementor-icon-list-item">
                              <a href="#">
                                <span class="elementor-icon-list-text">Service</span>
                              </a>
                            </li>
                          </ul>
                        </div>
                      </div>
                    </div>
                  </div>
                  <div class="elementor-column elementor-col-25 elementor-inner-column elementor-element elementor-element-ac57788" data-id="ac57788" data-element_type="column">
                    <div class="elementor-widget-wrap elementor-element-populated">
                      <div class="elementor-element elementor-element-a41e3d4 elementor-widget elementor-widget-heading" data-id="a41e3d4" data-element_type="widget" data-widget_type="heading.default">
                        <div class="elementor-widget-container">
                          <h2 class="elementor-heading-title elementor-size-default">MY ACCOUNT</h2>
                        </div>
                      </div>
                      <div class="elementor-element elementor-element-37f85a7 elementor-icon-list--layout-traditional elementor-list-item-link-full_width elementor-widget elementor-widget-icon-list" data-id="37f85a7" data-element_type="widget" data-widget_type="icon-list.default">
                        <div class="elementor-widget-container">
                          <ul class="elementor-icon-list-items">
                            <li class="elementor-icon-list-item">
                              <a href="#">
                                <span class="elementor-icon-list-text">My Account</span>
                              </a>
                            </li>
                            <li class="elementor-icon-list-item">
                              <a href="#">
                                <span class="elementor-icon-list-text">Contact</span>
                              </a>
                            </li>
                            <li class="elementor-icon-list-item">
                              <a href="#">
                                <span class="elementor-icon-list-text">Shopping cart</span>
                              </a>
                            </li>
                            <li class="elementor-icon-list-item">
                              <a href="#">
                                <span class="elementor-icon-list-text">Shop</span>
                              </a>
                            </li>
                          </ul>
                        </div>
                      </div>
                    </div>
                  </div>
                  <div class="elementor-column elementor-col-25 elementor-inner-column elementor-element elementor-element-345b0a8" data-id="345b0a8" data-element_type="column">
                    <div class="elementor-widget-wrap elementor-element-populated">
                      <div class="elementor-element elementor-element-63726a2 elementor-widget elementor-widget-heading" data-id="63726a2" data-element_type="widget" data-widget_type="heading.default">
                        <div class="elementor-widget-container">
                          <h2 class="elementor-heading-title elementor-size-default">CATEGORIES</h2>
                        </div>
                      </div>
                      <div class="elementor-element elementor-element-01cdbea elementor-icon-list--layout-traditional elementor-list-item-link-full_width elementor-widget elementor-widget-icon-list" data-id="01cdbea" data-element_type="widget" data-widget_type="icon-list.default">
                        <div class="elementor-widget-container">
                          <ul class="elementor-icon-list-items">
                            <li class="elementor-icon-list-item">
                              <a href="#">
                                <span class="elementor-icon-list-text">Table & Banches</span>
                              </a>
                            </li>
                            <li class="elementor-icon-list-item">
                              <a href="#">
                                <span class="elementor-icon-list-text"> Dairy Products</span>
                              </a>
                            </li>
                            <li class="elementor-icon-list-item">
                              <a href="#">
                                <span class="elementor-icon-list-text">Package Foods</span>
                              </a>
                            </li>
                            <li class="elementor-icon-list-item">
                              <a href="#">
                                <span class="elementor-icon-list-text"> Beverage</span>
                              </a>
                            </li>
                            <li class="elementor-icon-list-item">
                              <a href="#">
                                <span class="elementor-icon-list-text"> Health & Wellness</span>
                              </a>
                            </li>
                          </ul>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
              </section>
            </div>
          </div>
        </div>
      </section>
      <section class="elementor-section elementor-top-section elementor-element elementor-element-b171ff4 elementor-section-stretched elementor-section-boxed elementor-section-height-default elementor-section-height-default" data-id="b171ff4" data-element_type="section" data-settings="{&quot;stretch_section&quot;:&quot;section-stretched&quot;,&quot;background_background&quot;:&quot;classic&quot;}">
        <div class="elementor-container elementor-column-gap-no">
          <div class="elementor-column elementor-col-50 elementor-top-column elementor-element elementor-element-12c389c" data-id="12c389c" data-element_type="column">
            <div class="elementor-widget-wrap elementor-element-populated">
              <div class="elementor-element elementor-element-3d904b3 elementor-widget elementor-widget-text-editor" data-id="3d904b3" data-element_type="widget" data-widget_type="text-editor.default">
                <div class="elementor-widget-container"> Copyright © 2021 <a href=""> Ecare Shop</a>. All Rights Reserved. </div>
              </div>
            </div>
          </div>
          <div class="elementor-column elementor-col-50 elementor-top-column elementor-element elementor-element-412728d" data-id="412728d" data-element_type="column">
            <div class="elementor-widget-wrap elementor-element-populated">
              <div class="elementor-element elementor-element-be7e038 elementor-widget elementor-widget-image" data-id="be7e038" data-element_type="widget" data-widget_type="image.default">
                <div class="elementor-widget-container">
                  <img width="240" height="25" src="data:image/svg+xml,%3Csvg%20
                                    xmlns='http://www.w3.org/2000/svg'%20viewBox='0%200%20240%2025'%3E%3C/svg%3E" class="attachment-full size-full" alt="Revslider Organey" data-lazy-src="https://demothemedh.b-cdn.net/organey/wp-content/uploads/2021/07/footer_01-2.png.webp" />
                  <noscript>
                    <img width="240" height="25" src="https://demothemedh.b-cdn.net/organey/wp-content/uploads/2021/07/footer_01-2.png.webp" class="attachment-full size-full" alt="Revslider Organey" />
                  </noscript>
                </div>
              </div>
            </div>
          </div>
        </div>
      </section>
    </div>
  </div>
</footer>
<div class="site-wishlist-side side-wrap">
  <a href="#" class="close-wishlist-side close-side"></a>
  <div class="wishlist-side-heading side-heading">
    <span class="wishlist-side-title side-title">Wishlist</span>
  </div>
  <div class="wishlist-side-wrap-content">
    <div class="organey-wishlist-content-scroll">
      <div class="organey-wishlist-content"></div>
    </div>
    <div class="organey-wishlist-bottom">
      <a class="button" href="wishlist/index.html">Wishlist page</a>
    </div>
  </div>
</div>
<div class="wishlist-side-overlay side-overlay"></div>
<div class="site-search-popup">
  <div class="site-search-popup-wrap">
    <a href="#" class="site-search-popup-close"></a>
    <div class="site-search ajax-search">
      <div class="widget woocommerce widget_product_search">
        <div class="ajax-search-result d-none"></div>
        <form role="search" method="get" class="woocommerce-product-search" action="https://demo.leebrosus.com/organey/">
          <label class="screen-reader-text" for="woocommerce-product-search-field-2">Search for:</label>
          <input type="search" id="woocommerce-product-search-field-2" class="search-field" placeholder="Search products&hellip;" autocomplete="off" value="" name="s" />
          <button type="submit" value="Search">Search</button>
          <input type="hidden" name="post_type" value="product" />
        </form>
      </div>
    </div>
  </div>
</div>
<div class="woosc-popup woosc-search">
  <div class="woosc-popup-inner">
    <div class="woosc-popup-content">
      <div class="woosc-popup-content-inner">
        <div class="woosc-popup-close"></div>
        <div class="woosc-search-input">
          <input type="search" id="woosc_search_input" placeholder="Type any keyword to search..." />
        </div>
        <div class="woosc-search-result"></div>
      </div>
    </div>
  </div>
</div>
<div class="woosc-popup woosc-settings">
  <div class="woosc-popup-inner">
    <div class="woosc-popup-content">
      <div class="woosc-popup-content-inner">
        <div class="woosc-popup-close"></div>
        <ul class="woosc-settings-tools">
          <li>
            <label>
              <input type="checkbox" class="woosc-settings-tool" id="woosc_hide_similarities" /> Hide similarities </label>
          </li>
          <li>
            <label>
              <input type="checkbox" class="woosc-settings-tool" id="woosc_highlight_differences" /> Highlight differences </label>
          </li>
        </ul> Select the fields to be shown. Others will be hidden. Drag and drop to rearrange the order. <ul class="woosc-settings-fields">
          <li class="woosc-settings-field-li">
            <input type="checkbox" class="woosc-settings-field" value="image" checked />
            <span class="label">Image</span>
          </li>
          <li class="woosc-settings-field-li">
            <input type="checkbox" class="woosc-settings-field" value="sku" checked />
            <span class="label">SKU</span>
          </li>
          <li class="woosc-settings-field-li">
            <input type="checkbox" class="woosc-settings-field" value="rating" checked />
            <span class="label">Rating</span>
          </li>
          <li class="woosc-settings-field-li">
            <input type="checkbox" class="woosc-settings-field" value="price" checked />
            <span class="label">Price</span>
          </li>
          <li class="woosc-settings-field-li">
            <input type="checkbox" class="woosc-settings-field" value="stock" checked />
            <span class="label">Stock</span>
          </li>
          <li class="woosc-settings-field-li">
            <input type="checkbox" class="woosc-settings-field" value="availability" checked />
            <span class="label">Availability</span>
          </li>
          <li class="woosc-settings-field-li">
            <input type="checkbox" class="woosc-settings-field" value="add_to_cart" checked />
            <span class="label">Add to cart</span>
          </li>
          <li class="woosc-settings-field-li">
            <input type="checkbox" class="woosc-settings-field" value="description" checked />
            <span class="label">Description</span>
          </li>
          <li class="woosc-settings-field-li">
            <input type="checkbox" class="woosc-settings-field" value="weight" checked />
            <span class="label">Weight</span>
          </li>
          <li class="woosc-settings-field-li">
            <input type="checkbox" class="woosc-settings-field" value="dimensions" checked />
            <span class="label">Dimensions</span>
          </li>
          <li class="woosc-settings-field-li">
            <input type="checkbox" class="woosc-settings-field" value="additional" checked />
            <span class="label">Additional information</span>
          </li>
          <li class="woosc-settings-field-li">
            <input type="checkbox" class="woosc-settings-field" value="attributes" checked />
            <span class="label">Attributes</span>
          </li>
          <li class="woosc-settings-field-li">
            <input type="checkbox" class="woosc-settings-field" value="custom_attributes" checked />
            <span class="label">Custom attributes</span>
          </li>
          <li class="woosc-settings-field-li">
            <input type="checkbox" class="woosc-settings-field" value="custom_fields" checked />
            <span class="label">Custom fields</span>
          </li>
        </ul>
      </div>
    </div>
  </div>
</div>
<div class="woosc-popup woosc-share">
  <div class="woosc-popup-inner">
    <div class="woosc-popup-content">
      <div class="woosc-popup-content-inner">
        <div class="woosc-popup-close"></div>
        <div class="woosc-share-content"></div>
      </div>
    </div>
  </div>
</div>
<div id="woosc-area" class="woosc-area woosc-bar-bottom woosc-bar-right woosc-bar-click-outside-yes woosc-hide-checkout" data-bg-color="#292a30" data-btn-color="#00a0d2">
  <div class="woosc-inner">
    <div class="woosc-table">
      <div class="woosc-table-inner">
        <a href="javascript:void(0);" id="woosc-table-close" class="woosc-table-close hint--left" aria-label="Close">
          <span class="woosc-table-close-icon"></span>
        </a>
        <div class="woosc-table-items"></div>
      </div>
    </div>
    <div class="woosc-bar ">
      <div class="woosc-bar-notice"> Click outside to hide the compare bar </div>
      <a href="javascript:void(0);" class="woosc-bar-share hint--top" aria-label="Share"></a>
      <a href="javascript:void(0);" class="woosc-bar-search hint--top" aria-label="Add product"></a>
      <div class="woosc-bar-items"></div>
      <div class="woosc-bar-btn woosc-bar-btn-text">
        <div class="woosc-bar-btn-icon-wrapper">
          <div class="woosc-bar-btn-icon-inner">
            <span></span>
            <span></span>
            <span></span>
          </div>
        </div> Compare
      </div>
    </div>
  </div>
</div>
<div id="woosw_wishlist" class="woosw-popup"></div>




                          <script data-cfasync="false" src="{{ asset('frontend/js/email-decode.min.js') }}"></script>
                          <script type="text/html" id="tmpl-ajax-live-search-template">
      <div class="product-item-search">
        <a class="product-link" href="" title="">
          <img src="" alt="">
          <div class="product-content"><h3 class="product-title">Title Data</h3>Price data</div>
        </a>
      </div>
    
    </script>

<div class="site-account-side side-wrap">
  <a href="#" class="close-account-side close-side"></a>

  @if(auth::check())
    <div class="account-side-heading side-heading">
      <span class="account-side-title side-title">{{ auth::user()->name }}</span>
    </div>
    <div class="dropdown-menu dropdown-menu-end" aria-labelledby="navbarDropdown">
        <a class="dropdown-item" href="{{ route('logout') }}"
           onclick="event.preventDefault();
                         document.getElementById('logout-form').submit();">
            {{ __('Logout') }}
        </a>

        <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
            @csrf
        </form>
    </div>
  @else

  <div class="account-side-heading side-heading"><span class="account-side-title side-title">Sign in</span></div>
  <form class="organey-login-form-ajax" action="{{ route('login') }}" method="post">
    @csrf
      <label>
          <span class="label">Username or email <span class="required">*</span></span><input name="email" type="text" required />
      </label>
      <label>
          <span class="label">Password <span class="required">*</span></span><input name="password" type="password" required />
      </label>
      <button type="submit" data-button-action class="button">Login</button><input type="hidden" name="action" value="organey_login" /><input type="hidden" id="security-login" name="security-login" value="22057b5d89" />
      <input type="hidden" name="_wp_http_referer" value="/organey/" />
  </form>
  <a href="" class="lostpass-link" title="Lost your password?">Lost your password?</a>
  <div class="login-form-hook"></div>
  <div class="login-form-bottom"><span class="create-account-text">No account yet?</span><a class="register-link" href="{{ route('register') }}" title="Register">Create an Account</a></div>

  @endif

</div>


<div class="wishlist-side-overlay side-overlay"></div>
<div class="organey-mobile-nav">
    <div class="menu-scroll-mobile">
        <a href="#" class="mobile-nav-close"><i class="organey-icon-times"></i></a>
        <div class="mobile-nav-tabs">
            <ul>
                <li class="mobile-tab-title mobile-pages-title active" data-menu="pages"><span>main menu</span></li>
                <li class="mobile-tab-title mobile-categories-title" data-menu="categories"><span>All Departments</span></li>
            </ul>
        </div>
        <nav class="mobile-menu-tab mobile-navigation mobile-pages-menu active" aria-label="Mobile Navigation">
            <div class="handheld-navigation">
                <ul id="menu-main-menu" class="menu">
                    <li
                        class="menu-item menu-item-type-post_type menu-item-object-page menu-item-home current-menu-item page_item page-item-312 current_page_item current-menu-ancestor current-menu-parent current_page_parent current_page_ancestor menu-item-has-children menu-item-2022"
                    >
                        <a href="index.html" aria-current="page">Home</a>
                        <ul class="sub-menu">
                            <li class="menu-item menu-item-type-post_type menu-item-object-page menu-item-home current-menu-item page_item page-item-312 current_page_item menu-item-2035">
                                <a href="index.html" aria-current="page">Home Page Layout 1</a>
                            </li>
                            <li class="menu-item menu-item-type-post_type menu-item-object-page menu-item-2030"><a href="home-2/index.html">Home Page Layout 2</a></li>
                            <li class="menu-item menu-item-type-post_type menu-item-object-page menu-item-2481"><a href="home-3/index.html">Home Page Layout 3</a></li>
                            <li class="menu-item menu-item-type-post_type menu-item-object-page menu-item-2032"><a href="home-4/index.html">Home Page Layout 4</a></li>
                            <li class="menu-item menu-item-type-post_type menu-item-object-page menu-item-2033"><a href="home-5/index.html">Home Page Layout 5</a></li>
                            <li class="menu-item menu-item-type-post_type menu-item-object-page menu-item-2034"><a href="home-6/index.html">Home Page Layout 6</a></li>
                            <li class="menu-item menu-item-type-post_type menu-item-object-page menu-item-2296"><a href="home-7/index.html">Home Page Layout 7</a></li>
                            <li class="menu-item menu-item-type-post_type menu-item-object-page menu-item-2467"><a href="home-8/index.html">Home Page Layout 8</a></li>
                            <li class="menu-item menu-item-type-post_type menu-item-object-page menu-item-2480"><a href="home-9/index.html">Home Page Layout 9</a></li>
                            <li class="menu-item menu-item-type-post_type menu-item-object-page menu-item-2479"><a href="home-10/index.html">Home Page Layout 10</a></li>
                        </ul>
                    </li>
                    <li class="menu-item menu-item-type-post_type menu-item-object-page menu-item-has-children menu-item-2023">
                        <a href="shop/index.html">Shop</a>
                        <ul class="sub-menu">
                            <li class="menu-item menu-item-type-custom menu-item-object-custom menu-item-6966"><a href="shop/index2e45.html?woocommerce_archive_layout=canvas&amp;woocommerce_catalog_columns=5">Shop Full Width</a></li>
                            <li class="menu-item menu-item-type-custom menu-item-object-custom menu-item-6958"><a href="shop/indexe210.html?woocommerce_archive_sidebar=right">Shop Right Sidebar</a></li>
                            <li class="menu-item menu-item-type-custom menu-item-object-custom menu-item-6962"><a href="shop/index.html">Shop Left Sidebar</a></li>
                            <li class="menu-item menu-item-type-custom menu-item-object-custom menu-item-7011"><a href="shop/index2e45.html?woocommerce_archive_layout=canvas&amp;woocommerce_catalog_columns=5">Shop Filter Canvas</a></li>
                        </ul>
                    </li>
                    <li class="menu-item menu-item-type-custom menu-item-object-custom menu-item-has-children menu-item-2028">
                        <a href="#">Pages</a>
                        <ul class="sub-menu">
                            <li class="menu-item menu-item-type-post_type menu-item-object-page menu-item-7267"><a href="about-us/index.html">About us</a></li>
                            <li class="menu-item menu-item-type-post_type menu-item-object-page menu-item-7268"><a href="faqs/index.html">FAQ’s</a></li>
                            <li class="menu-item menu-item-type-custom menu-item-object-custom menu-item-7269"><a href="404-page/index.html">404 Page</a></li>
                            <li class="menu-item menu-item-type-post_type menu-item-object-page menu-item-6440"><a href="icons/index.html">Icons</a></li>
                        </ul>
                    </li>
                    <li class="menu-item menu-item-type-post_type menu-item-object-page menu-item-has-children menu-item-2027">
                        <a href="blog/index.html">Blog</a>
                        <ul class="sub-menu">
                            <li class="menu-item menu-item-type-custom menu-item-object-custom menu-item-7056"><a href="blog/index.html">Blog Left Sidebar</a></li>
                            <li class="menu-item menu-item-type-custom menu-item-object-custom menu-item-7055"><a href="blog/index8f3a.html?blog_sidebar=right">Blog Right Sidebar</a></li>
                            <li class="menu-item menu-item-type-custom menu-item-object-custom menu-item-7094"><a href="blog/indexb995.html?blog_style=grid">Blog Grid</a></li>
                            <li class="menu-item menu-item-type-post_type menu-item-object-post menu-item-7090"><a href="sweet-orange-yellow-from-australia/index.html">Single Post</a></li>
                        </ul>
                    </li>
                    <li class="menu-item menu-item-type-post_type menu-item-object-page menu-item-2024"><a href="contact/index.html">Contact</a></li>
                </ul>
            </div>
        </nav>
        <nav class="mobile-menu-tab mobile-navigation-categories mobile-categories-menu" aria-label="Mobile Navigation">
            <div class="handheld-navigation">
                <ul id="menu-all-departments" class="menu">
                    <li class="menu-item menu-item-type-custom menu-item-object-custom menu-item-has-children menu-item-2758 has-mega-menu">
                        <a href="shop/index.html"><i class="menu-icon organey-icon-organic"></i><span class="menu-title">Organic Produce</span></a><span class="icon-down-megamenu"></span>
                        <ul class="sub-menu mega-menu custom-subwidth" style="width: 880px;">
                            <li class="mega-menu-item">
                                <div class="skeleton-body">
                                    <script type="text/template">
                                        
                                      "\t\t <div data-elementor-type="page" data-elementor-id="5951" class="elementor elementor-5951"> \t\t\t\t\t\t\t\t <section class="elementor-section elementor-top-section elementor-element elementor-element-cf483e9 elementor-section-boxed elementor-section-height-default elementor-section-height-default" data-id="cf483e9" data-element_type="section"> \t\t\t\t\t <div class="elementor-container elementor-column-gap-no"> \t\t\t\t <div class="elementor-column elementor-col-50 elementor-top-column elementor-element elementor-element-25e12ef" data-id="25e12ef" data-element_type="column"> \t\t <div class="elementor-widget-wrap elementor-element-populated"> \t\t\t\t\t\t\t <section class="elementor-section elementor-inner-section elementor-element elementor-element-492c155 elementor-section-boxed elementor-section-height-default elementor-section-height-default" data-id="492c155" data-element_type="section" data-settings="{&quot;background_background&quot;:&quot;classic&quot;}"> \t\t\t\t\t <div class="elementor-container elementor-column-gap-no"> \t\t\t\t <div class="elementor-column elementor-col-100 elementor-inner-column elementor-element elementor-element-dd5af90" data-id="dd5af90" data-element_type="column"> \t\t <div class="elementor-widget-wrap elementor-element-populated"> \t\t\t\t\t\t\t <div class="elementor-element elementor-element-c1a0421 elementor-widget elementor-widget-heading" data-id="c1a0421" data-element_type="widget" data-widget_type="heading.default"> \t\t\t <div class="elementor-widget-container"> \t\t <h5 class="elementor-heading-title elementor-size-default">Vegetable<\ /h5>\t\t<\ /div> \t\t\t<\ /div> \t\t\t <div class="elementor-element elementor-element-b17cb0b elementor-icon-list--layout-traditional elementor-list-item-link-full_width elementor-widget elementor-widget-icon-list" data-id="b17cb0b" data-element_type="widget" data-widget_type="icon-list.default"> \t\t\t <div class="elementor-widget-container"> \t\t\t\t <ul class="elementor-icon-list-items"> \t\t\t\t\t\t <li class="elementor-icon-list-item"> \t\t\t\t\t\t\t\t\t\t <a href="http:\/\/demo.leebrosus.com\/organey\/shop\/">  \t\t\t\t\t\t\t\t\t\t <span class="elementor-icon-list-text">Fresh fruits<\ /span> \t\t\t\t\t\t\t\t\t\t<\ /a> \t\t\t\t\t\t\t\t<\ /li> \t\t\t\t\t\t\t
                                    <li class="elementor-icon-list-item"> \t\t\t\t\t\t\t\t\t\t <a href="http:\/\/demo.leebrosus.com\/organey\/product-category\/fruits\/">  \t\t\t\t\t\t\t\t\t\t <span class="elementor-icon-list-text">Flower Bunches<\ /span> \t\t\t\t\t\t\t\t\t\t<\ /a> \t\t\t\t\t\t\t\t<\ /li> \t\t\t\t\t\t\t
                                    <li class="elementor-icon-list-item"> \t\t\t\t\t\t\t\t\t\t <a href="http:\/\/demo.leebrosus.com\/organey\/product-category\/vegetables\/">  \t\t\t\t\t\t\t\t\t\t <span class="elementor-icon-list-text">Fresh Vegetables<\ /span> \t\t\t\t\t\t\t\t\t\t<\ /a> \t\t\t\t\t\t\t\t<\ /li> \t\t\t\t\t\t\t
                                    <li class="elementor-icon-list-item"> \t\t\t\t\t\t\t\t\t\t <a href="http:\/\/demo.leebrosus.com\/organey\/shop\/">  \t\t\t\t\t\t\t\t\t\t <span class="elementor-icon-list-text">Herbs & Seasoning<\ /span> \t\t\t\t\t\t\t\t\t\t<\ /a> \t\t\t\t\t\t\t\t<\ /li> \t\t\t\t\t<\ /ul> \t\t\t<\ /div> \t\t\t<\ /div> \t\t\t\t<\ /div> \t<\ /div> \t\t\t\t\t\t<\ /div> \t<\ /section> \t\t\t <section class="elementor-section elementor-inner-section elementor-element elementor-element-3d3e513 elementor-section-boxed elementor-section-height-default elementor-section-height-default" data-id="3d3e513" data-element_type="section" data-settings="{&quot;background_background&quot;:&quot;classic&quot;}"> \t\t\t\t\t <div class="elementor-container elementor-column-gap-no"> \t\t\t\t <div class="elementor-column elementor-col-100 elementor-inner-column elementor-element elementor-element-c772c8c" data-id="c772c8c" data-element_type="column"> \t\t <div class="elementor-widget-wrap elementor-element-populated"> \t\t\t\t\t\t\t <div class="elementor-element elementor-element-9ff94cc elementor-widget elementor-widget-heading" data-id="9ff94cc" data-element_type="widget" data-widget_type="heading.default"> \t\t\t <div class="elementor-widget-container"> \t\t <h5 class="elementor-heading-title elementor-size-default">Juice & Drinks<\ /h5>\t\t<\ /div> \t\t\t<\ /div> \t\t\t <div class="elementor-element elementor-element-763a805 elementor-icon-list--layout-traditional elementor-list-item-link-full_width elementor-widget elementor-widget-icon-list" data-id="763a805" data-element_type="widget" data-widget_type="icon-list.default"> \t\t\t <div class="elementor-widget-container"> \t\t\t\t <ul class="elementor-icon-list-items"> \t\t\t\t\t\t <li class="elementor-icon-list-item"> \t\t\t\t\t\t\t\t\t\t <a href="http:\/\/demo.leebrosus.com\/organey\/product-category\/fruits\/">  \t\t\t\t\t\t\t\t\t\t <span class="elementor-icon-list-text">Flower Bunches<\ /span> \t\t\t\t\t\t\t\t\t\t<\ /a> \t\t\t\t\t\t\t\t<\ /li> \t\t\t\t\t\t\t
                                                                                        <li class="elementor-icon-list-item"> \t\t\t\t\t\t\t\t\t\t <a href="http:\/\/demo.leebrosus.com\/organey\/product-category\/vegetables\/">  \t\t\t\t\t\t\t\t\t\t <span class="elementor-icon-list-text">Fresh Vegetables<\ /span> \t\t\t\t\t\t\t\t\t\t<\ /a> \t\t\t\t\t\t\t\t<\ /li> \t\t\t\t\t\t\t
                                                                                        <li class="elementor-icon-list-item"> \t\t\t\t\t\t\t\t\t\t <a href="http:\/\/demo.leebrosus.com\/organey\/product-category\/meat\/">  \t\t\t\t\t\t\t\t\t\t <span class="elementor-icon-list-text">Cuts & Sprouts<\ /span> \t\t\t\t\t\t\t\t\t\t<\ /a> \t\t\t\t\t\t\t\t<\ /li> \t\t\t\t\t\t\t
                                                                                        <li class="elementor-icon-list-item"> \t\t\t\t\t\t\t\t\t\t <a href="http:\/\/demo.leebrosus.com\/organey\/shop\/">  \t\t\t\t\t\t\t\t\t\t <span class="elementor-icon-list-text">Fresh fruits<\ /span> \t\t\t\t\t\t\t\t\t\t<\ /a> \t\t\t\t\t\t\t\t<\ /li> \t\t\t\t\t<\ /ul> \t\t\t<\ /div> \t\t\t<\ /div> \t\t\t\t<\ /div> \t<\ /div> \t\t\t\t\t\t<\ /div> \t<\ /section> \t\t\t\t<\ /div> \t<\ /div> \t\t\t <div class="elementor-column elementor-col-50 elementor-top-column elementor-element elementor-element-08ce9a2" data-id="08ce9a2" data-element_type="column"> \t\t <div class="elementor-widget-wrap elementor-element-populated"> \t\t\t\t\t\t\t <section class="elementor-section elementor-inner-section elementor-element elementor-element-4e5553a elementor-section-boxed elementor-section-height-default elementor-section-height-default" data-id="4e5553a" data-element_type="section" data-settings="{&quot;background_background&quot;:&quot;classic&quot;}"> \t\t\t\t\t <div class="elementor-container elementor-column-gap-no"> \t\t\t\t <div class="elementor-column elementor-col-100 elementor-inner-column elementor-element elementor-element-0d1a3b4" data-id="0d1a3b4" data-element_type="column"> \t\t <div class="elementor-widget-wrap elementor-element-populated"> \t\t\t\t\t\t\t <div class="elementor-element elementor-element-2b6942d elementor-widget elementor-widget-heading" data-id="2b6942d" data-element_type="widget" data-widget_type="heading.default"> \t\t\t <div class="elementor-widget-container"> \t\t <h5 class="elementor-heading-title elementor-size-default">Organic Fruits<\ /h5>\t\t<\ /div> \t\t\t<\ /div> \t\t\t <div class="elementor-element elementor-element-455dcec elementor-icon-list--layout-traditional elementor-list-item-link-full_width elementor-widget elementor-widget-icon-list" data-id="455dcec" data-element_type="widget" data-widget_type="icon-list.default"> \t\t\t <div class="elementor-widget-container"> \t\t\t\t <ul class="elementor-icon-list-items"> \t\t\t\t\t\t <li class="elementor-icon-list-item"> \t\t\t\t\t\t\t\t\t\t <a href="http:\/\/demo.leebrosus.com\/organey\/product-category\/meat\/">  \t\t\t\t\t\t\t\t\t\t <span class="elementor-icon-list-text">Cuts & Sprouts<\ /span> \t\t\t\t\t\t\t\t\t\t<\ /a> \t\t\t\t\t\t\t\t<\ /li> \t\t\t\t\t\t\t
                                                                                                                                                    <li class="elementor-icon-list-item"> \t\t\t\t\t\t\t\t\t\t <a href="http:\/\/demo.leebrosus.com\/organey\/product-category\/vegetables\/">  \t\t\t\t\t\t\t\t\t\t <span class="elementor-icon-list-text">Fresh Vegetables<\ /span> \t\t\t\t\t\t\t\t\t\t<\ /a> \t\t\t\t\t\t\t\t<\ /li> \t\t\t\t\t\t\t
                                                                                                                                                    <li class="elementor-icon-list-item"> \t\t\t\t\t\t\t\t\t\t <a href="http:\/\/demo.leebrosus.com\/organey\/shop\/">  \t\t\t\t\t\t\t\t\t\t <span class="elementor-icon-list-text">Herbs & Seasoning<\ /span> \t\t\t\t\t\t\t\t\t\t<\ /a> \t\t\t\t\t\t\t\t<\ /li> \t\t\t\t\t\t\t
                                                                                                                                                    <li class="elementor-icon-list-item"> \t\t\t\t\t\t\t\t\t\t <a href="http:\/\/demo.leebrosus.com\/organey\/product-category\/fruits\/">  \t\t\t\t\t\t\t\t\t\t <span class="elementor-icon-list-text">Flower Bunches<\ /span> \t\t\t\t\t\t\t\t\t\t<\ /a> \t\t\t\t\t\t\t\t<\ /li> \t\t\t\t\t<\ /ul> \t\t\t<\ /div> \t\t\t<\ /div> \t\t\t\t<\ /div> \t<\ /div> \t\t\t\t\t\t<\ /div> \t<\ /section> \t\t\t <section class="elementor-section elementor-inner-section elementor-element elementor-element-6ec2eb0 elementor-section-boxed elementor-section-height-default elementor-section-height-default" data-id="6ec2eb0" data-element_type="section" data-settings="{&quot;background_background&quot;:&quot;classic&quot;}"> \t\t\t\t\t <div class="elementor-container elementor-column-gap-no"> \t\t\t\t <div class="elementor-column elementor-col-100 elementor-inner-column elementor-element elementor-element-aaa4beb" data-id="aaa4beb" data-element_type="column"> \t\t <div class="elementor-widget-wrap elementor-element-populated"> \t\t\t\t\t\t\t <div class="elementor-element elementor-element-ba733af elementor-widget elementor-widget-heading" data-id="ba733af" data-element_type="widget" data-widget_type="heading.default"> \t\t\t <div class="elementor-widget-container"> \t\t <h5 class="elementor-heading-title elementor-size-default">Organic Foods<\ /h5>\t\t<\ /div> \t\t\t<\ /div> \t\t\t <div class="elementor-element elementor-element-36293a4 elementor-icon-list--layout-traditional elementor-list-item-link-full_width elementor-widget elementor-widget-icon-list" data-id="36293a4" data-element_type="widget" data-widget_type="icon-list.default"> \t\t\t <div class="elementor-widget-container"> \t\t\t\t <ul class="elementor-icon-list-items"> \t\t\t\t\t\t <li class="elementor-icon-list-item"> \t\t\t\t\t\t\t\t\t\t <a href="http:\/\/demo.leebrosus.com\/organey\/shop\/">  \t\t\t\t\t\t\t\t\t\t <span class="elementor-icon-list-text">Herbs & Seasoning<\ /span> \t\t\t\t\t\t\t\t\t\t<\ /a> \t\t\t\t\t\t\t\t<\ /li> \t\t\t\t\t\t\t
                                                                                                                                                                                                        <li class="elementor-icon-list-item"> \t\t\t\t\t\t\t\t\t\t <a href="http:\/\/demo.leebrosus.com\/organey\/shop\/">  \t\t\t\t\t\t\t\t\t\t <span class="elementor-icon-list-text">Fresh fruits<\ /span> \t\t\t\t\t\t\t\t\t\t<\ /a> \t\t\t\t\t\t\t\t<\ /li> \t\t\t\t\t\t\t
                                                                                                                                                                                                        <li class="elementor-icon-list-item"> \t\t\t\t\t\t\t\t\t\t <a href="http:\/\/demo.leebrosus.com\/organey\/product-category\/fruits\/">  \t\t\t\t\t\t\t\t\t\t <span class="elementor-icon-list-text">Flower Bunches<\ /span> \t\t\t\t\t\t\t\t\t\t<\ /a> \t\t\t\t\t\t\t\t<\ /li> \t\t\t\t\t\t\t
                                                                                                                                                                                                        <li class="elementor-icon-list-item"> \t\t\t\t\t\t\t\t\t\t <a href="http:\/\/demo.leebrosus.com\/organey\/product-category\/meat\/">  \t\t\t\t\t\t\t\t\t\t <span class="elementor-icon-list-text">Cuts & Sprouts<\ /span> \t\t\t\t\t\t\t\t\t\t<\ /a> \t\t\t\t\t\t\t\t<\ /li> \t\t\t\t\t<\ /ul> \t\t\t<\ /div> \t\t\t<\ /div> \t\t\t\t<\ /div> \t<\ /div> \t\t\t\t\t\t<\ /div> \t<\ /section> \t\t\t\t<\ /div> \t<\ /div> \t\t\t\t\t\t<\ /div> \t<\ /section> \t\t\t\t\t\t<\ /div>  </script>
                                                                                                                                                                                                                                            <div class="skeleton-item skeleton-megamenu-item"></div>
                                                                                                                                                                                                    </div>
                                                                                                                                                    </li>
                                                                                                                                                  </ul>
                                                                                        </li>
                                                                                        <li class="menu-item menu-item-type-custom menu-item-object-custom menu-item-has-children menu-item-2759 has-mega-menu">
                                                                                          <a href="product-category/vegetables/index.html">
                                                                                            <i class="menu-icon organey-icon-carrot"></i>
                                                                                            <span class="menu-title">Fresh Vegetables</span>
                                                                                          </a>
                                                                                          <span class="icon-down-megamenu"></span>
                                                                                          <ul class="sub-menu mega-menu custom-subwidth" style="width: 880px;">
                                                                                            <li class="mega-menu-item">
                                                                                              <div class="skeleton-body">
                                                                                                <script type="text/template"> "\t\t
                                                                                                                                                                                              <div data-elementor-type="page" data-elementor-id="5952" class="elementor elementor-5952"> \t\t\t\t\t\t\t\t
                                                                                                                                                                                                <section class="elementor-section elementor-top-section elementor-element elementor-element-1b1b9a9 elementor-section-boxed elementor-section-height-default elementor-section-height-default" data-id="1b1b9a9" data-element_type="section"> \t\t\t\t\t
                                                                                                                                                                                                  <div class="elementor-container elementor-column-gap-no"> \t\t\t\t
                                                                                                                                                                                                    <div class="elementor-column elementor-col-50 elementor-top-column elementor-element elementor-element-fe165f4" data-id="fe165f4" data-element_type="column"> \t\t
                                                                                                                                                                                                      <div class="elementor-widget-wrap elementor-element-populated"> \t\t\t\t\t\t\t
                                                                                                                                                                                                        <section class="elementor-section elementor-inner-section elementor-element elementor-element-81ec78c elementor-section-boxed elementor-section-height-default elementor-section-height-default" data-id="81ec78c" data-element_type="section" data-settings="{&quot;background_background&quot;:&quot;classic&quot;}"> \t\t\t\t\tundefined<div class="elementor-container elementor-column-gap-no"> \t\t\t\tundefined<div class="elementor-column elementor-col-100 elementor-inner-column elementor-element elementor-element-9cf82dc" data-id="9cf82dc" data-element_type="column"> \t\tundefined<div class="elementor-widget-wrap elementor-element-populated"> \t\t\t\t\t\t\tundefined<div class="elementor-element elementor-element-57124c9 elementor-widget elementor-widget-heading" data-id="57124c9" data-element_type="widget" data-widget_type="heading.default"> \t\t\tundefined<div class="elementor-widget-container"> \t\tundefined<h5 class="elementor-heading-title elementor-size-default">Juice & Drinks</h5>\t\t</div> \t\t\t</div> \t\t\tundefined<div class="elementor-element elementor-element-9b7498c elementor-icon-list--layout-traditional elementor-list-item-link-full_width elementor-widget elementor-widget-icon-list" data-id="9b7498c" data-element_type="widget" data-widget_type="icon-list.default"> \t\t\tundefined<div class="elementor-widget-container"> \t\t\t\tundefined<ul class="elementor-icon-list-items"> \t\t\t\t\t\tundefined<li class="elementor-icon-list-item"> \t\t\t\t\t\t\t\t\t\tundefined<a href="http:\/\/demo.leebrosus.com\/organey\/shop\/">  \t\t\t\t\t\t\t\t\t\tundefined<span class="elementor-icon-list-text">Watermelon juice</span> \t\t\t\t\t\t\t\t\t\t</a> \t\t\t\t\t\t\t\t</li> \t\t\t\t\t\t\tundefined<li class="elementor-icon-list-item"> \t\t\t\t\t\t\t\t\t\tundefined<a href="http:\/\/demo.leebrosus.com\/organey\/shop\/">  \t\t\t\t\t\t\t\t\t\tundefined<span class="elementor-icon-list-text">Carrot juice</span> \t\t\t\t\t\t\t\t\t\t</a> \t\t\t\t\t\t\t\t</li> \t\t\t\t\t\t\tundefined<li class="elementor-icon-list-item"> \t\t\t\t\t\t\t\t\t\tundefined<a href="http:\/\/demo.leebrosus.com\/organey\/shop\/">  \t\t\t\t\t\t\t\t\t\tundefined<span class="elementor-icon-list-text">Fruit juice</span> \t\t\t\t\t\t\t\t\t\t</a> \t\t\t\t\t\t\t\t</li> \t\t\t\t\t\t\tundefined<li class="elementor-icon-list-item"> \t\t\t\t\t\t\t\t\t\tundefined<a href="http:\/\/demo.leebrosus.com\/organey\/shop\/">  \t\t\t\t\t\t\t\t\t\tundefined<span class="elementor-icon-list-text">Challah</span> \t\t\t\t\t\t\t\t\t\t</a> \t\t\t\t\t\t\t\t</li> \t\t\t\t\t</ul> \t\t\t</div> \t\t\t</div> \t\t\t\t</div> \t</div> \t\t\t\t\t\t</div> \t</section> \t\t\tundefined<section class="elementor-section elementor-inner-section elementor-element elementor-element-11be5a2 elementor-section-boxed elementor-section-height-default elementor-section-height-default" data-id="11be5a2" data-element_type="section" data-settings="{&quot;background_background&quot;:&quot;classic&quot;}"> \t\t\t\t\tundefined<div class="elementor-container elementor-column-gap-no"> \t\t\t\tundefined<div class="elementor-column elementor-col-100 elementor-inner-column elementor-element elementor-element-5b268a3" data-id="5b268a3" data-element_type="column"> \t\tundefined<div class="elementor-widget-wrap elementor-element-populated"> \t\t\t\t\t\t\tundefined<div class="elementor-element elementor-element-e291515 elementor-widget elementor-widget-heading" data-id="e291515" data-element_type="widget" data-widget_type="heading.default"> \t\t\tundefined<div class="elementor-widget-container"> \t\tundefined<h5 class="elementor-heading-title elementor-size-default">Vegetable </h5>\t\t</div> \t\t\t</div> \t\t\tundefined<div class="elementor-element elementor-element-5420dbd elementor-icon-list--layout-traditional elementor-list-item-link-full_width elementor-widget elementor-widget-icon-list" data-id="5420dbd" data-element_type="widget" data-widget_type="icon-list.default"> \t\t\tundefined<div class="elementor-widget-container"> \t\t\t\tundefined<ul class="elementor-icon-list-items"> \t\t\t\t\t\tundefined<li class="elementor-icon-list-item"> \t\t\t\t\t\t\t\t\t\tundefined<a href="http:\/\/demo.leebrosus.com\/organey\/product-category\/fruits\/">  \t\t\t\t\t\t\t\t\t\tundefined<span class="elementor-icon-list-text">Flower Bunches</span> \t\t\t\t\t\t\t\t\t\t</a> \t\t\t\t\t\t\t\t</li> \t\t\t\t\t\t\tundefined<li class="elementor-icon-list-item"> \t\t\t\t\t\t\t\t\t\tundefined<a href="http:\/\/demo.leebrosus.com\/organey\/product-category\/vegetables\/">  \t\t\t\t\t\t\t\t\t\tundefined<span class="elementor-icon-list-text">Fresh Vegetables</span> \t\t\t\t\t\t\t\t\t\t</a> \t\t\t\t\t\t\t\t</li> \t\t\t\t\t\t\tundefined<li class="elementor-icon-list-item"> \t\t\t\t\t\t\t\t\t\tundefined<a href="http:\/\/demo.leebrosus.com\/organey\/product-category\/meat\/">  \t\t\t\t\t\t\t\t\t\tundefined<span class="elementor-icon-list-text">Cuts & Sprouts</span> \t\t\t\t\t\t\t\t\t\t</a> \t\t\t\t\t\t\t\t</li> \t\t\t\t\t\t\tundefined<li class="elementor-icon-list-item"> \t\t\t\t\t\t\t\t\t\tundefined<a href="http:\/\/demo.leebrosus.com\/organey\/shop\/">  \t\t\t\t\t\t\t\t\t\tundefined<span class="elementor-icon-list-text">Fresh fruits</span> \t\t\t\t\t\t\t\t\t\t</a> \t\t\t\t\t\t\t\t</li> \t\t\t\t\t</ul> \t\t\t</div> \t\t\t</div> \t\t\t\t</div> \t</div> \t\t\t\t\t\t</div> \t</section> \t\t\t\t</div> \t</div> \t\t\tundefined<div class="elementor-column elementor-col-50 elementor-top-column elementor-element elementor-element-16d2834" data-id="16d2834" data-element_type="column"> \t\tundefined<div class="elementor-widget-wrap elementor-element-populated"> \t\t\t\t\t\t\tundefined<section class="elementor-section elementor-inner-section elementor-element elementor-element-06355e8 elementor-section-boxed elementor-section-height-default elementor-section-height-default" data-id="06355e8" data-element_type="section" data-settings="{&quot;background_background&quot;:&quot;classic&quot;}"> \t\t\t\t\tundefined<div class="elementor-container elementor-column-gap-no"> \t\t\t\tundefined<div class="elementor-column elementor-col-100 elementor-inner-column elementor-element elementor-element-b47e654" data-id="b47e654" data-element_type="column"> \t\tundefined<div class="elementor-widget-wrap elementor-element-populated"> \t\t\t\t\t\t\tundefined<div class="elementor-element elementor-element-4ed2cbf elementor-widget elementor-widget-heading" data-id="4ed2cbf" data-element_type="widget" data-widget_type="heading.default"> \t\t\tundefined<div class="elementor-widget-container"> \t\tundefined<h5 class="elementor-heading-title elementor-size-default">Organic Oil</h5>\t\t</div> \t\t\t</div> \t\t\tundefined<div class="elementor-element elementor-element-e5e06e3 elementor-icon-list--layout-traditional elementor-list-item-link-full_width elementor-widget elementor-widget-icon-list" data-id="e5e06e3" data-element_type="widget" data-widget_type="icon-list.default"> \t\t\tundefined<div class="elementor-widget-container"> \t\t\t\tundefined<ul class="elementor-icon-list-items"> \t\t\t\t\t\tundefined<li class="elementor-icon-list-item"> \t\t\t\t\t\t\t\t\t\tundefined<a href="http:\/\/demo.leebrosus.com\/organey\/product-category\/meat\/">  \t\t\t\t\t\t\t\t\t\tundefined<span class="elementor-icon-list-text">Olive oil</span> \t\t\t\t\t\t\t\t\t\t</a> \t\t\t\t\t\t\t\t</li> \t\t\t\t\t\t\tundefined<li class="elementor-icon-list-item"> \t\t\t\t\t\t\t\t\t\tundefined<a href="http:\/\/demo.leebrosus.com\/organey\/product-category\/vegetables\/">  \t\t\t\t\t\t\t\t\t\tundefined<span class="elementor-icon-list-text">Sunflower oil</span> \t\t\t\t\t\t\t\t\t\t</a> \t\t\t\t\t\t\t\t</li> \t\t\t\t\t\t\tundefined<li class="elementor-icon-list-item"> \t\t\t\t\t\t\t\t\t\tundefined<a href="http:\/\/demo.leebrosus.com\/organey\/shop\/">  \t\t\t\t\t\t\t\t\t\tundefined<span class="elementor-icon-list-text">Soybean oil</span> \t\t\t\t\t\t\t\t\t\t</a> \t\t\t\t\t\t\t\t</li> \t\t\t\t\t\t\tundefined<li class="elementor-icon-list-item"> \t\t\t\t\t\t\t\t\t\tundefined<a href="http:\/\/demo.leebrosus.com\/organey\/product-category\/fruits\/">  \t\t\t\t\t\t\t\t\t\tundefined<span class="elementor-icon-list-text">Rapeseed oil</span> \t\t\t\t\t\t\t\t\t\t</a> \t\t\t\t\t\t\t\t</li> \t\t\t\t\t</ul> \t\t\t</div> \t\t\t</div> \t\t\t\t</div> \t</div> \t\t\t\t\t\t</div> \t</section> \t\t\tundefined<section class="elementor-section elementor-inner-section elementor-element elementor-element-f37c30b elementor-section-boxed elementor-section-height-default elementor-section-height-default" data-id="f37c30b" data-element_type="section" data-settings="{&quot;background_background&quot;:&quot;classic&quot;}"> \t\t\t\t\tundefined<div class="elementor-container elementor-column-gap-no"> \t\t\t\tundefined<div class="elementor-column elementor-col-100 elementor-inner-column elementor-element elementor-element-f3f5d1c" data-id="f3f5d1c" data-element_type="column"> \t\tundefined<div class="elementor-widget-wrap elementor-element-populated"> \t\t\t\t\t\t\tundefined<div class="elementor-element elementor-element-a5e01f4 elementor-widget elementor-widget-heading" data-id="a5e01f4" data-element_type="widget" data-widget_type="heading.default"> \t\t\tundefined<div class="elementor-widget-container"> \t\tundefined<h5 class="elementor-heading-title elementor-size-default">Organic Foods</h5>\t\t</div> \t\t\t</div> \t\t\tundefined<div class="elementor-element elementor-element-3d60f4d elementor-icon-list--layout-traditional elementor-list-item-link-full_width elementor-widget elementor-widget-icon-list" data-id="3d60f4d" data-element_type="widget" data-widget_type="icon-list.default"> \t\t\tundefined<div class="elementor-widget-container"> \t\t\t\tundefined<ul class="elementor-icon-list-items"> \t\t\t\t\t\tundefined<li class="elementor-icon-list-item"> \t\t\t\t\t\t\t\t\t\tundefined<a href="http:\/\/demo.leebrosus.com\/organey\/shop\/">  \t\t\t\t\t\t\t\t\t\tundefined<span class="elementor-icon-list-text">Oat</span> \t\t\t\t\t\t\t\t\t\t</a> \t\t\t\t\t\t\t\t</li> \t\t\t\t\t\t\tundefined<li class="elementor-icon-list-item"> \t\t\t\t\t\t\t\t\t\tundefined<a href="http:\/\/demo.leebrosus.com\/organey\/shop\/">  \t\t\t\t\t\t\t\t\t\tundefined<span class="elementor-icon-list-text">Rice</span> \t\t\t\t\t\t\t\t\t\t</a> \t\t\t\t\t\t\t\t</li> \t\t\t\t\t\t\tundefined<li class="elementor-icon-list-item"> \t\t\t\t\t\t\t\t\t\tundefined<a href="http:\/\/demo.leebrosus.com\/organey\/product-category\/fruits\/">  \t\t\t\t\t\t\t\t\t\tundefined<span class="elementor-icon-list-text">Spaghetti</span> \t\t\t\t\t\t\t\t\t\t</a> \t\t\t\t\t\t\t\t</li> \t\t\t\t\t\t\tundefined<li class="elementor-icon-list-item"> \t\t\t\t\t\t\t\t\t\tundefined<a href="http:\/\/demo.leebrosus.com\/organey\/product-category\/meat\/">  \t\t\t\t\t\t\t\t\t\tundefined<span class="elementor-icon-list-text">Quinoa</span> \t\t\t\t\t\t\t\t\t\t</a> \t\t\t\t\t\t\t\t</li> \t\t\t\t\t</ul> \t\t\t</div> \t\t\t</div> \t\t\t\t</div> \t</div> \t\t\t\t\t\t</div> \t</section> \t\t\t\t</div> \t</div> \t\t\t\t\t\t</div> \t</section> \t\t\t\t\t\t</div> 

                                    </script>
                                    <div class="skeleton-item skeleton-megamenu-item"></div>
                                </div>
                            </li>
                        </ul>
                    </li>
                    <li class="menu-item menu-item-type-custom menu-item-object-custom menu-item-2766">
                        <a href="product-category/fruits/index.html"><i class="menu-icon organey-icon-cherry"></i><span class="menu-title">Fresh Fruits</span></a>
                    </li>
                    <li class="menu-item menu-item-type-custom menu-item-object-custom menu-item-2767">
                        <a href="product-category/vegetables/index.html"><i class="menu-icon organey-icon-lettuce"></i><span class="menu-title">Fresh Packaged Salads</span></a>
                    </li>
                    <li class="menu-item menu-item-type-custom menu-item-object-custom menu-item-2769">
                        <a href="shop/index.html"><i class="menu-icon organey-icon-sprout"></i><span class="menu-title">Fresh Herbs</span></a>
                    </li>
                    <li class="menu-item menu-item-type-custom menu-item-object-custom menu-item-2770">
                        <a href="shop/index.html"><i class="menu-icon organey-icon-tofu"></i><span class="menu-title">Plant Based Protein &#038; Tofu</span></a>
                    </li>
                    <li class="menu-item menu-item-type-custom menu-item-object-custom menu-item-2771">
                        <a href="product-category/vegetables/index.html"><i class="menu-icon organey-icon-open-can"></i><span class="menu-title">Canned &#038; Jarred Vegetables</span></a>
                    </li>
                    <li class="menu-item menu-item-type-custom menu-item-object-custom menu-item-2772">
                        <a href="product-category/fruits/index.html"><i class="menu-icon organey-icon-almonds"></i><span class="menu-title">Dried Fruits</span></a>
                    </li>
                    <li class="menu-item menu-item-type-custom menu-item-object-custom menu-item-2776">
                        <a href="product-category/vegetables/index.html"><i class="menu-icon organey-icon-fish"></i><span class="menu-title">Dried Vegetables</span></a>
                    </li>
                </ul>
            </div>
        </nav>
    </div>
    <div class="organey-language-switcher-mobile">
        <ul class="menu">
            <li class="item">
                <div class="language-switcher-head">
                    <img
                        width="18"
                        height="12"
                        src="data:image/svg+xml,%3Csvg%20xmlns='http://www.w3.org/2000/svg'%20viewBox='0%200%2018%2012'%3E%3C/svg%3E"
                        alt="WPML"
                        data-lazy-src="https://demothemedh.b-cdn.net/organey/wp-content/themes/organey/assets/images/language-switcher/en.png"
                    />
                    <noscript><img width="18" height="12" src="../../demothemedh.b-cdn.net/organey/wp-content/themes/organey/assets/images/language-switcher/en.png" alt="WPML" /></noscript>
                </div>
            </li>
            <li class="item">
                <div class="language-switcher-img">
                    <a href="#">
                        <img
                            width="18"
                            height="12"
                            src="data:image/svg+xml,%3Csvg%20xmlns='http://www.w3.org/2000/svg'%20viewBox='0%200%2018%2012'%3E%3C/svg%3E"
                            alt="WPML"
                            data-lazy-src="https://demothemedh.b-cdn.net/organey/wp-content/themes/organey/assets/images/language-switcher/de.png"
                        />
                        <noscript><img width="18" height="12" src="../../demothemedh.b-cdn.net/organey/wp-content/themes/organey/assets/images/language-switcher/de.png" alt="WPML" /></noscript>
                    </a>
                </div>
            </li>
            <li class="item">
                <div class="language-switcher-img">
                    <a href="#">
                        <img
                            width="18"
                            height="12"
                            src="data:image/svg+xml,%3Csvg%20xmlns='http://www.w3.org/2000/svg'%20viewBox='0%200%2018%2012'%3E%3C/svg%3E"
                            alt="WPML"
                            data-lazy-src="https://demothemedh.b-cdn.net/organey/wp-content/themes/organey/assets/images/language-switcher/it.png"
                        />
                        <noscript><img width="18" height="12" src="../../demothemedh.b-cdn.net/organey/wp-content/themes/organey/assets/images/language-switcher/it.png" alt="WPML" /></noscript>
                    </a>
                </div>
            </li>
            <li class="item">
                <div class="language-switcher-img">
                    <a href="#">
                        <img
                            width="18"
                            height="12"
                            src="data:image/svg+xml,%3Csvg%20xmlns='http://www.w3.org/2000/svg'%20viewBox='0%200%2018%2012'%3E%3C/svg%3E"
                            alt="WPML"
                            data-lazy-src="https://demothemedh.b-cdn.net/organey/wp-content/themes/organey/assets/images/language-switcher/hi.png"
                        />
                        <noscript><img width="18" height="12" src="../../demothemedh.b-cdn.net/organey/wp-content/themes/organey/assets/images/language-switcher/hi.png" alt="WPML" /></noscript>
                    </a>
                </div>
            </li>
        </ul>
    </div>
</div>

<div class="organey-overlay"></div>

@include('inc.cart_sidebar')


    <link rel="preload" as="font" id="rs-icon-set-revicon-woff" href="https://demothemedh.b-cdn.net/organey/wp-content/plugins/revslider/public/assets/fonts/revicons/revicons.woff?5510888" type="font/woff" crossorigin="anonymous" media="all" /> 
    <link data-minify="1" rel='preload' href="{{ asset('frontend/uploads/elementor/css/post-595149d6.css?ver=1653443927') }}" data-rocket-async="style" as="style" onload="this.onload=null;this.rel='stylesheet'" media='all' /> 
    <link data-minify="1" rel='preload' href="{{ asset('frontend/uploads/elementor/css/post-595249d6.css?ver=1653443927') }}" data-rocket-async="style" as="style" onload="this.onload=null;this.rel='stylesheet'" media='all' /> 
    <link rel='preload' href="{{ asset('frontend/plugins/elementor/assets/lib/animations/animations.min3ab2.css?ver=3.6.5') }}" data-rocket-async="style" as="style" onload="this.onload=null;this.rel='stylesheet'" media='all' /> 
    <link data-minify="1" rel='preload' href="{{ asset('frontend/plugins/revslider/public/assets/css/rs649d6.css?ver=1653443927') }}" data-rocket-async="style" as="style" onload="this.onload=null;this.rel='stylesheet'" media='all' /><style id='rs-plugin-settings-inline-css'>
      #rev_slider_1_1_wrapper .hesperiden.tparrows {
        cursor: pointer;
        background: rgba(255, 255, 255, 0.7);
        width: 40px;
        height: 40px;
        position: absolute;
        display: block;
        z-index: 1000;
        border-radius: 50%
      }

      #rev_slider_1_1_wrapper .hesperiden.tparrows.rs-touchhover {
        background: #ffffff
      }

      #rev_slider_1_1_wrapper .hesperiden.tparrows:before {
        font-family: 'revicons';
        font-size: 28px;
        color: #000000;
        display: block;
        line-height: 40px;
        text-align: center
      }

      #rev_slider_1_1_wrapper .hesperiden.tparrows.tp-leftarrow:before {
        content: '\e820';
        margin-left: -3px
      }

      #rev_slider_1_1_wrapper .hesperiden.tparrows.tp-rightarrow:before {
        content: '\e81d';
        margin-right: -3px
      }

      #rev_slider_1_1_wrapper .uranus .tp-bullet {
        border-radius: 50%;
        box-shadow: 0 0 0 2px rgba(255, 255, 255, 0);
        -webkit-transition: box-shadow 0.3s ease;
        transition: box-shadow 0.3s ease;
        background: transparent;
        width: 14px;
        height: 14px
      }

      #rev_slider_1_1_wrapper .uranus .tp-bullet.selected,
      #rev_slider_1_1_wrapper .uranus .tp-bullet.rs-touchhover {
        box-shadow: 0 0 0 2px #0c0c0c;
        border: none;
        border-radius: 50%;
        background: transparent
      }

      #rev_slider_1_1_wrapper .uranus .tp-bullet-inner {
        -webkit-transition: background-color 0.3s ease, -webkit-transform 0.3s ease;
        transition: background-color 0.3s ease, transform 0.3s ease;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        outline: none;
        border-radius: 50%;
        background-color: rgba(255, 255, 255, 0);
        background-color: rgba(0, 0, 0, 0.3);
        text-indent: -999em;
        cursor: pointer;
        position: absolute
      }

      #rev_slider_1_1_wrapper .uranus .tp-bullet.selected .tp-bullet-inner,
      #rev_slider_1_1_wrapper .uranus .tp-bullet.rs-touchhover .tp-bullet-inner {
        transform: scale(0.4);
        -webkit-transform: scale(0.4);
        background-color: #0c0c0c
      }
    </style>
    

    <script type="text/javascript" id='rocket-browser-checker-js-after'> 
      "use strict";
var _createClass = (function () {
    function defineProperties(target, props) {
        for (var i = 0; i < props.length; i++) {
            var descriptor = props[i];
            (descriptor.enumerable = descriptor.enumerable || !1), (descriptor.configurable = !0), "value" in descriptor && (descriptor.writable = !0), Object.defineProperty(target, descriptor.key, descriptor);
        }
    }
    return function (Constructor, protoProps, staticProps) {
        return protoProps && defineProperties(Constructor.prototype, protoProps), staticProps && defineProperties(Constructor, staticProps), Constructor;
    };
})();
function _classCallCheck(instance, Constructor) {
    if (!(instance instanceof Constructor)) throw new TypeError("Cannot call a class as a function");
}
var RocketBrowserCompatibilityChecker = (function () {
    function RocketBrowserCompatibilityChecker(options) {
        _classCallCheck(this, RocketBrowserCompatibilityChecker), (this.passiveSupported = !1), this._checkPassiveOption(this), (this.options = !!this.passiveSupported && options);
    }
    return (
        _createClass(RocketBrowserCompatibilityChecker, [
            {
                key: "_checkPassiveOption",
                value: function (self) {
                    try {
                        var options = {
                            get passive() {
                                return !(self.passiveSupported = !0);
                            },
                        };
                        window.addEventListener("test", null, options), window.removeEventListener("test", null, options);
                    } catch (err) {
                        self.passiveSupported = !1;
                    }
                },
            },
            {
                key: "initRequestIdleCallback",
                value: function () {
                    !1 in window &&
                        (window.requestIdleCallback = function (cb) {
                            var start = Date.now();
                            return setTimeout(function () {
                                cb({
                                    didTimeout: !1,
                                    timeRemaining: function () {
                                        return Math.max(0, 50 - (Date.now() - start));
                                    },
                                });
                            }, 1);
                        }),
                        !1 in window &&
                            (window.cancelIdleCallback = function (id) {
                                return clearTimeout(id);
                            });
                },
            },
            {
                key: "isDataSaverModeOn",
                value: function () {
                    return "connection" in navigator && !0 === navigator.connection.saveData;
                },
            },
            {
                key: "supportsLinkPrefetch",
                value: function () {
                    var elem = document.createElement("link");
                    return elem.relList && elem.relList.supports && elem.relList.supports("prefetch") && window.IntersectionObserver && "isIntersecting" in IntersectionObserverEntry.prototype;
                },
            },
            {
                key: "isSlowConnection",
                value: function () {
                    return "connection" in navigator && "effectiveType" in navigator.connection && ("2g" === navigator.connection.effectiveType || "slow-2g" === navigator.connection.effectiveType);
                },
            },
        ]),
        RocketBrowserCompatibilityChecker
    );
})();

</script>
<script id='rocket-preload-links-js-extra'>
      var RocketPreloadLinksConfig = {
        "excludeUris": "\/organey(\/(.+\/)?feed\/?.+\/?|\/(?:.+\/)?embed\/|\/checkout\/|\/cart\/|\/my-account\/|\/wc-api\/v(.*)|\/(index\\.php\/)?wp\\-json(\/.*|$))|\/wp-admin\/|\/logout\/|\/wp-login.php",
        "usesTrailingSlash": "1",
        "imageExt": "jpg|jpeg|gif|png|tiff|bmp|webp|avif",
        "fileExt": "jpg|jpeg|gif|png|tiff|bmp|webp|avif|php|pdf|html|htm",
        "siteUrl": "https:\/\/demo.leebrosus.com\/organey",
        "onHoverDelay": "100",
        "rateThrottle": "3"
      };
    </script>
    <script type="text/javascript" id='rocket-preload-links-js-after'> 
      (function() {
"use strict";var r="function"==typeof Symbol&&"symbol"==typeof Symbol.iterator?function(e){return typeof e}:function(e){return e&&"function"==typeof Symbol&&e.constructor===Symbol&&e!==Symbol.prototype?"symbol":typeof e},e=function(){function i(e,t){for(var n=0;n<t.length;n++){var i=t[n];i.enumerable=i.enumerable||!1,i.configurable=!0,"value"in i&&(i.writable=!0),Object.defineProperty(e,i.key,i)}}return function(e,t,n){return t&&i(e.prototype,t),n&&i(e,n),e}}();function i(e,t){if(!(e instanceof t))throw new TypeError("Cannot call a class as a function")}var t=function(){function n(e,t){i(this,n),this.browser=e,this.config=t,this.options=this.browser.options,this.prefetched=new Set,this.eventTime=null,this.threshold=1111,this.numOnHover=0}return e(n,[{key:"init",value:function(){!this.browser.supportsLinkPrefetch()||this.browser.isDataSaverModeOn()||this.browser.isSlowConnection()||(this.regex={excludeUris:RegExp(this.config.excludeUris,"i"),images:RegExp(".("+this.config.imageExt+")$","i"),fileExt:RegExp(".("+this.config.fileExt+")$","i")},this._initListeners(this))}},{key:"_initListeners",value:function(e){-1<this.config.onHoverDelay&&document.addEventListener("mouseover",e.listener.bind(e),e.listenerOptions),document.addEventListener("mousedown",e.listener.bind(e),e.listenerOptions),document.addEventListener("touchstart",e.listener.bind(e),e.listenerOptions)}},{key:"listener",value:function(e){var t=e.target.closest("a"),n=this._prepareUrl(t);if(null!==n)switch(e.type){case"mousedown":case"touchstart":this._addPrefetchLink(n);break;case"mouseover":this._earlyPrefetch(t,n,"mouseout")}}},{key:"_earlyPrefetch",value:function(t,e,n){var i=this,r=setTimeout(function(){if(r=null,0===i.numOnHover)setTimeout(function(){return i.numOnHover=0},1e3);else if(i.numOnHover>i.config.rateThrottle)return;i.numOnHover++,i._addPrefetchLink(e)},this.config.onHoverDelay);t.addEventListener(n,function e(){t.removeEventListener(n,e,{passive:!0}),null!==r&&(clearTimeout(r),r=null)},{passive:!0})}},{key:"_addPrefetchLink",value:function(i){return this.prefetched.add(i.href),new Promise(function(e,t){var n=document.createElement("link");n.rel="prefetch",n.href=i.href,n.onload=e,n.onerror=t,document.head.appendChild(n)}).catch(function(){})}},{key:"_prepareUrl",value:function(e){if(null===e||"object"!==(void 0===e?"":r(e))||!1 in e||-1===["http:","https:"].indexOf(e.protocol))return null;var t=e.href.substring(0,this.config.siteUrl.length),n=this._getPathname(e.href,t),i={original:e.href,protocol:e.protocol,origin:t,pathname:n,href:t+n};return this._isLinkOk(i)?i:null}},{key:"_getPathname",value:function(e,t){var n=t?e.substring(this.config.siteUrl.length):e;return n.startsWith("https://demo.leebrosus.com/")||(n="/"+n),this._shouldAddTrailingSlash(n)?n+"/":n}},{key:"_shouldAddTrailingSlash",value:function(e){return this.config.usesTrailingSlash&&!e.endsWith("https://demo.leebrosus.com/")&&!this.regex.fileExt.test(e)}},{key:"_isLinkOk",value:function(e){return null!==e&&"object"===(void 0===e?"":r(e))&&(!this.prefetched.has(e.href)&&e.origin===this.config.siteUrl&&-1===e.href.indexOf("?")&&-1===e.href.indexOf("#")&&!this.regex.excludeUris.test(e.href)&&!this.regex.images.test(e.href))}}],[{key:"run",value:function(){""!=typeof RocketPreloadLinksConfig&&new n(new RocketBrowserCompatibilityChecker({capture:!0,passive:!0}),RocketPreloadLinksConfig).init()}}]),n}();t.run();
}());
</script><script id='woosc-frontend-js-extra'>
      var woosc_vars = {
        "ajax_url": "https:\/\/demo.leebrosus.com\/organey\/wp-admin\/admin-ajax.php",
        "user_id": "0cdb64fab32a05bd393b20c8c351de9f",
        "page_url": "#",
        "open_button": "",
        "open_button_action": "open_popup",
        "menu_action": "open_popup",
        "open_table": "yes",
        "open_bar": "no",
        "bar_bubble": "no",
        "click_again": "no",
        "hide_empty": "no",
        "click_outside": "yes",
        "freeze_column": "yes",
        "freeze_row": "yes",
        "scrollbar": "yes",
        "limit": "100",
        "button_text_change": "yes",
        "remove_all": "Do you want to remove all products from the compare?",
        "limit_notice": "You can add a maximum of {limit} products to the compare table.",
        "copied_text": "Share link %s was copied to clipboard!",
        "button_text": "Compare",
        "button_text_added": "Compare"
      };
    </script><script id='wc-add-to-cart-variation-js-extra'>
      var wc_add_to_cart_variation_params = {
        "wc_ajax_url": "\/organey\/?wc-ajax=%%endpoint%%",
        "i18n_no_matching_variations_text": "Sorry, no products matched your selection. Please choose a different combination.",
        "i18n_make_a_selection_text": "Please select some product options before adding this product to your cart.",
        "i18n_unavailable_text": "Sorry, this product is unavailable. Please choose a different combination."
      };
    </script><script id='woosq-frontend-js-extra'>
      var woosq_vars = {
        "ajax_url": "https:\/\/demo.leebrosus.com\/organey\/wp-admin\/admin-ajax.php",
        "effect": "mfp-3d-unfold",
        "scrollbar": "yes",
        "hashchange": "no",
        "cart_redirect": "no",
        "cart_url": "https:\/\/demo.leebrosus.com\/organey\/cart\/",
        "close": "Close (Esc)",
        "next": "Next (Right arrow key)",
        "prev": "Previous (Left arrow key)",
        "is_rtl": ""
      };
    </script><script id='woosw-frontend-js-extra'>
      var woosw_vars = {
        "ajax_url": "https:\/\/demo.leebrosus.com\/organey\/wp-admin\/admin-ajax.php",
        "menu_action": "open_page",
        "perfect_scrollbar": "yes",
        "wishlist_url": "https:\/\/demo.leebrosus.com\/organey\/wishlist\/",
        "button_action": "list",
        "button_action_added": "popup",
        "empty_confirm": "This action cannot be undone. Are you sure?",
        "delete_confirm": "This action cannot be undone. Are you sure?",
        "copied_text": "Copied the wishlist link:",
        "menu_text": "Wishlist",
        "button_text": "Add to wishlist",
        "button_text_added": "Browse wishlist"
      };
    </script><script id='woo-variation-swatches-js-extra'>
      var woo_variation_swatches_options = {
        "is_product_page": "",
        "show_variation_label": "1",
        "variation_label_separator": ":",
        "wvs_nonce": "e4347dc3e8"
      };
    </script><script type="text/javascript" id='elementor-frontend-js-before'> var elementorFrontendConfig = {"environmentMode":{"edit":false,"wpPreview":false,"isScriptDebug":false},"i18n":{"shareOnFacebook":"Share on Facebook","shareOnTwitter":"Share on Twitter","pinIt":"Pin it","download":"Download","downloadImage":"Download image","fullscreen":"Fullscreen","zoom":"Zoom","share":"Share","playVideo":"Play Video","previous":"Previous","next":"Next","close":"Close"},"is_rtl":false,"breakpoints":{"xs":0,"sm":480,"md":768,"lg":1025,"xl":1440,"xxl":1600},"responsive":{"breakpoints":{"mobile":{"label":"Mobile","value":767,"default_value":767,"direction":"max","is_enabled":true},"mobile_extra":{"label":"Mobile Extra","value":880,"default_value":880,"direction":"max","is_enabled":false},"tablet":{"label":"Tablet","value":1024,"default_value":1024,"direction":"max","is_enabled":true},"tablet_extra":{"label":"Tablet Extra","value":1200,"default_value":1200,"direction":"max","is_enabled":false},"laptop":{"label":"Laptop","value":1366,"default_value":1366,"direction":"max","is_enabled":false},"widescreen":{"label":"Widescreen","value":2400,"default_value":2400,"direction":"min","is_enabled":false}}},"version":"3.6.5","is_static":false,"experimentalFeatures":{"e_dom_optimization":true,"a11y_improvements":true,"e_import_export":true,"e_hidden_wordpress_widgets":true,"landing-pages":true,"elements-color-picker":true,"favorite-widgets":true,"admin-top-bar":true},"urls":{"assets":"https:\/\/demo.leebrosus.com\/organey\/wp-content\/plugins\/elementor\/assets\/"},"settings":{"page":[],"editorPreferences":[]},"kit":{"viewport_mobile":767,"viewport_tablet":1024,"active_breakpoints":["viewport_mobile","viewport_tablet"],"global_image_lightbox":"yes","lightbox_enable_counter":"yes","lightbox_enable_fullscreen":"yes","lightbox_enable_zoom":"yes","lightbox_enable_share":"yes","lightbox_title_src":"title","lightbox_description_src":"description"},"post":{"id":312,"title":"Organey%20%E2%80%93%20Just%20another%20WordPress%20site","excerpt":"","featuredImage":false}};
</script><script>
      window.lazyLoadOptions = {
        elements_selector: "img[data-lazy-src],.rocket-lazyload",
        data_src: "lazy-src",
        data_srcset: "lazy-srcset",
        data_sizes: "lazy-sizes",
        class_loading: "lazyloading",
        class_loaded: "lazyloaded",
        threshold: 300,
        callback_loaded: function(element) {
          if (element.tagName === "IFRAME" && element.dataset.rocketLazyload == "fitvidscompatible") {
            if (element.classList.contains("lazyloaded")) {
              if (typeof window.jQuery != "") {
                if (jQuery.fn.fitVids) {
                  jQuery(element).parent().fitVids()
                }
              }
            }
          }
        }
      };
      window.addEventListener('LazyLoad::Initialized', function(e) {
        var lazyLoadInstance = e.detail.instance;
        if (window.MutationObserver) {
          var observer = new MutationObserver(function(mutations) {
            var image_count = 0;
            var iframe_count = 0;
            var rocketlazy_count = 0;
            mutations.forEach(function(mutation) {
              for (i = 0; i < mutation.addedNodes.length; i++) {
                if (typeof mutation.addedNodes[i].getElementsByTagName !== 'function') {
                  continue
                }
                if (typeof mutation.addedNodes[i].getElementsByClassName !== 'function') {
                  continue
                }
                images = mutation.addedNodes[i].getElementsByTagName('img');
                is_image = mutation.addedNodes[i].tagName == "IMG";
                iframes = mutation.addedNodes[i].getElementsByTagName('iframe');
                is_iframe = mutation.addedNodes[i].tagName == "IFRAME";
                rocket_lazy = mutation.addedNodes[i].getElementsByClassName('rocket-lazyload');
                image_count += images.length;
                iframe_count += iframes.length;
                rocketlazy_count += rocket_lazy.length;
                if (is_image) {
                  image_count += 1
                }
                if (is_iframe) {
                  iframe_count += 1
                }
              }
            });
            if (image_count > 0 || iframe_count > 0 || rocketlazy_count > 0) {
              lazyLoadInstance.update()
            }
          });
          var b = document.getElementsByTagName("body")[0];
          var config = {
            childList: !0,
            subtree: !0
          };
          observer.observe(b, config)
        }
      }, !1) 
      
    </script><script data-no-minify="1" async src="{{ asset('frontend/js/lazyload.min.js') }}"></script>
    <script type="rocketlazyloadscript" src="{{ asset('frontend/js/5ba83d6c0b33b3917692efb98df2dd62.js') }}" data-minify="1" defer></script>


@stack('scripts')

<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
<script type="text/javascript" src="{{ asset('frontend/js/common.js') }}"></script>

  </body>
</html>
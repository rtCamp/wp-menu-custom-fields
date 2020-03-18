/******/ (function(modules) { // webpackBootstrap
/******/ 	// The module cache
/******/ 	var installedModules = {};
/******/
/******/ 	// The require function
/******/ 	function __webpack_require__(moduleId) {
/******/
/******/ 		// Check if module is in cache
/******/ 		if(installedModules[moduleId]) {
/******/ 			return installedModules[moduleId].exports;
/******/ 		}
/******/ 		// Create a new module (and put it into the cache)
/******/ 		var module = installedModules[moduleId] = {
/******/ 			i: moduleId,
/******/ 			l: false,
/******/ 			exports: {}
/******/ 		};
/******/
/******/ 		// Execute the module function
/******/ 		modules[moduleId].call(module.exports, module, module.exports, __webpack_require__);
/******/
/******/ 		// Flag the module as loaded
/******/ 		module.l = true;
/******/
/******/ 		// Return the exports of the module
/******/ 		return module.exports;
/******/ 	}
/******/
/******/
/******/ 	// expose the modules object (__webpack_modules__)
/******/ 	__webpack_require__.m = modules;
/******/
/******/ 	// expose the module cache
/******/ 	__webpack_require__.c = installedModules;
/******/
/******/ 	// define getter function for harmony exports
/******/ 	__webpack_require__.d = function(exports, name, getter) {
/******/ 		if(!__webpack_require__.o(exports, name)) {
/******/ 			Object.defineProperty(exports, name, { enumerable: true, get: getter });
/******/ 		}
/******/ 	};
/******/
/******/ 	// define __esModule on exports
/******/ 	__webpack_require__.r = function(exports) {
/******/ 		if(typeof Symbol !== 'undefined' && Symbol.toStringTag) {
/******/ 			Object.defineProperty(exports, Symbol.toStringTag, { value: 'Module' });
/******/ 		}
/******/ 		Object.defineProperty(exports, '__esModule', { value: true });
/******/ 	};
/******/
/******/ 	// create a fake namespace object
/******/ 	// mode & 1: value is a module id, require it
/******/ 	// mode & 2: merge all properties of value into the ns
/******/ 	// mode & 4: return value when already ns object
/******/ 	// mode & 8|1: behave like require
/******/ 	__webpack_require__.t = function(value, mode) {
/******/ 		if(mode & 1) value = __webpack_require__(value);
/******/ 		if(mode & 8) return value;
/******/ 		if((mode & 4) && typeof value === 'object' && value && value.__esModule) return value;
/******/ 		var ns = Object.create(null);
/******/ 		__webpack_require__.r(ns);
/******/ 		Object.defineProperty(ns, 'default', { enumerable: true, value: value });
/******/ 		if(mode & 2 && typeof value != 'string') for(var key in value) __webpack_require__.d(ns, key, function(key) { return value[key]; }.bind(null, key));
/******/ 		return ns;
/******/ 	};
/******/
/******/ 	// getDefaultExport function for compatibility with non-harmony modules
/******/ 	__webpack_require__.n = function(module) {
/******/ 		var getter = module && module.__esModule ?
/******/ 			function getDefault() { return module['default']; } :
/******/ 			function getModuleExports() { return module; };
/******/ 		__webpack_require__.d(getter, 'a', getter);
/******/ 		return getter;
/******/ 	};
/******/
/******/ 	// Object.prototype.hasOwnProperty.call
/******/ 	__webpack_require__.o = function(object, property) { return Object.prototype.hasOwnProperty.call(object, property); };
/******/
/******/ 	// __webpack_public_path__
/******/ 	__webpack_require__.p = "";
/******/
/******/
/******/ 	// Load entry module and return exports
/******/ 	return __webpack_require__(__webpack_require__.s = "./src/js/main.js");
/******/ })
/************************************************************************/
/******/ ({

/***/ "./src/js/main.js":
/*!************************!*\
  !*** ./src/js/main.js ***!
  \************************/
/*! no exports provided */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony import */ var _scss_main_scss__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! ../scss/main.scss */ "./src/scss/main.scss");
/* harmony import */ var _scss_main_scss__WEBPACK_IMPORTED_MODULE_0___default = /*#__PURE__*/__webpack_require__.n(_scss_main_scss__WEBPACK_IMPORTED_MODULE_0__);
function _classCallCheck(instance, Constructor) { if (!(instance instanceof Constructor)) { throw new TypeError("Cannot call a class as a function"); } }

function _defineProperties(target, props) { for (var i = 0; i < props.length; i++) { var descriptor = props[i]; descriptor.enumerable = descriptor.enumerable || false; descriptor.configurable = true; if ("value" in descriptor) descriptor.writable = true; Object.defineProperty(target, descriptor.key, descriptor); } }

function _createClass(Constructor, protoProps, staticProps) { if (protoProps) _defineProperties(Constructor.prototype, protoProps); if (staticProps) _defineProperties(Constructor, staticProps); return Constructor; }

/**
 * Main scripts, loaded on all pages.
 *
 * @package wp-menu-custom-fields
 */

/**
 * Internal dependencies
 */

window.$ = window.$ || jQuery;
/**
 * Single nav menu Item.
 *
 * @type {Object}
 */

var NavMenuItem =
/*#__PURE__*/
function () {
  /**
   * Initialize.
   *
   * @param {Element} menuLi Menu item li with class 'menu-item
   * @param {int|string} menuId  Menu id.
   *
   * @return {void}
   */
  function NavMenuItem(menuLi, menuId) {
    _classCallCheck(this, NavMenuItem);

    this.menuLi = menuLi;
    this.menuId = menuId;
    this.mediaModal = {};

    if (!menuLi.length) {
      return;
    }

    this.openMediaModal = this.openMediaModal.bind(this);
    this.destroy = this.destroy.bind(this);
    this.handleMediaModalOpen = this.handleMediaModalOpen.bind(this);
    this.handleMediaModalClose = this.handleMediaModalClose.bind(this);
    this.initTinyMce = this.initTinyMce.bind(this);
    this.mediaUploaderButton = this.menuLi.find('#custom-field-select-image-' + this.menuId);
    this.deleteButton = this.menuLi.find('#delete-' + this.menuId);
    this.mediaUploaderButton.on('click', this.openMediaModal);
    this.deleteButton.on('click', this.destroy);
    this.initTinyMce();
  }
  /**
   * Remove all event listeners, destroy tinyMCE.
   *
   * @return {void}
   */


  _createClass(NavMenuItem, [{
    key: "destroy",
    value: function destroy() {
      this.mediaUploaderButton.off('click', this.openMediaModal);
      this.mediaModal = null;

      if ('undefined' !== typeof tinymce) {
        var selector = '#menu-item-custom-html-' + this.menuId;
        tinymce.remove(selector);
      }
    }
  }, {
    key: "initTinyMce",
    value: function initTinyMce() {
      if ('undefined' !== typeof tinymce) {
        var selector = '#menu-item-custom-html-' + this.menuId;
        tinymce.init({
          selector: selector,
          setup: function setup(editor) {
            editor.on('change', function () {
              tinymce.triggerSave();
            });
          }
        });
      }
    }
    /**
     * Open media library modal.
     *
     * @return {void}
     */

  }, {
    key: "openMediaModal",
    value: function openMediaModal() {
      var config = {
        title: wpMenuCustomFields.selectMediaText,
        multiple: false,
        library: {
          type: ['image']
        }
      };
      this.mediaModal = wp.media(config);
      this.mediaModal.on('open', this.handleMediaModalOpen);
      this.mediaModal.on('close', this.handleMediaModalClose);
      this.mediaModal.open();
    }
    /**
     * Handle media modal open.
     *
     * @return {void}
     */

  }, {
    key: "handleMediaModalOpen",
    value: function handleMediaModalOpen() {
      var mediaId = jQuery('#menu-item-media-id-' + this.menuId).val();

      if (!mediaId) {
        return;
      }

      var attachment = wp.media.attachment(mediaId);

      if (attachment) {
        attachment.fetch();
        this.mediaModal.state().get('selection').add(attachment ? [attachment] : []);
      }
    }
    /**
     * Handle media modal close.
     *
     * @return {void}
     */

  }, {
    key: "handleMediaModalClose",
    value: function handleMediaModalClose() {
      var selection = this.mediaModal.state().get('selection');
      var mediaId = false;
      var mediaUrl = false;
      var mediaType = false;

      if (!selection.length) {
        jQuery('#menu-item-media-id-' + this.menuId).val('');
        jQuery('#menu-item-media-type-' + this.menuId).val('');
        jQuery('#menu-item-selected-media-display-paragraph-' + this.menuId).html('').css('display', 'none');
        return;
      }

      selection.each(function (attachment) {
        mediaId = attachment.id;

        if (attachment.attributes) {
          mediaUrl = attachment.attributes.url;
          mediaType = attachment.attributes.type;
        }
      });

      if (!mediaId || !mediaUrl) {
        return;
      }

      if ('image' === mediaType) {
        jQuery('#menu-item-media-id-' + this.menuId).val(mediaId);
        jQuery('#menu-item-media-type-' + this.menuId).val(mediaType);
        jQuery('#menu-item-selected-media-display-paragraph-' + this.menuId).html('<img height="100" src="' + mediaUrl + '">').css('display', 'block');
      }
    }
  }]);

  return NavMenuItem;
}();
/**
 * Nav Menus.
 *
 * @type {Object}
 */


var NavMenu = {
  /**
   * Initialized nav menu ids.
   *
   * @type {object}
   */
  initializedNavMenuIds: {},

  /**
   * Initialize.
   *
   * @return {void}
   */
  init: function init() {
    var _this = this;

    this.menuContainer = jQuery('#menu-to-edit');
    this.menuContainer.on('click', '.item-edit', function (e) {
      var menuId = _this.getMenuId(jQuery(e.target));

      if ('undefined' === typeof _this.initializedNavMenuIds[menuId]) {
        var menuLi = jQuery("#menu-item-".concat(menuId));
        new NavMenuItem(menuLi, menuId);
        _this.initializedNavMenuIds[menuId] = true;
      }
    });
  },

  /**
   * Get menu id.
   *
   * @param {Element} element Element.
   *
   * @return {string}
   */
  getMenuId: function getMenuId(element) {
    if (!element || !element.prop('id').length) {
      return '';
    }

    return element.prop('id').replace(/[^\d.]/g, '');
  }
};
NavMenu.init();

/***/ }),

/***/ "./src/scss/main.scss":
/*!****************************!*\
  !*** ./src/scss/main.scss ***!
  \****************************/
/*! no static exports found */
/***/ (function(module, exports, __webpack_require__) {

// extracted by mini-css-extract-plugin

/***/ })

/******/ });
//# sourceMappingURL=main.js.map
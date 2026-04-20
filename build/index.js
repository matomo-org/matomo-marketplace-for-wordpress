/******/ (() => { // webpackBootstrap
/******/ 	"use strict";
/******/ 	var __webpack_modules__ = ({

/***/ "./src/install-plugins.scss"
/*!**********************************!*\
  !*** ./src/install-plugins.scss ***!
  \**********************************/
(__unused_webpack_module, __webpack_exports__, __webpack_require__) {

__webpack_require__.r(__webpack_exports__);
// extracted by mini-css-extract-plugin


/***/ },

/***/ "./src/plugin-card.scss"
/*!******************************!*\
  !*** ./src/plugin-card.scss ***!
  \******************************/
(__unused_webpack_module, __webpack_exports__, __webpack_require__) {

__webpack_require__.r(__webpack_exports__);
// extracted by mini-css-extract-plugin


/***/ },

/***/ "react"
/*!************************!*\
  !*** external "React" ***!
  \************************/
(module) {

module.exports = window["React"];

/***/ },

/***/ "react/jsx-runtime"
/*!**********************************!*\
  !*** external "ReactJSXRuntime" ***!
  \**********************************/
(module) {

module.exports = window["ReactJSXRuntime"];

/***/ },

/***/ "@wordpress/api-fetch"
/*!**********************************!*\
  !*** external ["wp","apiFetch"] ***!
  \**********************************/
(module) {

module.exports = window["wp"]["apiFetch"];

/***/ },

/***/ "@wordpress/components"
/*!************************************!*\
  !*** external ["wp","components"] ***!
  \************************************/
(module) {

module.exports = window["wp"]["components"];

/***/ },

/***/ "@wordpress/dom-ready"
/*!**********************************!*\
  !*** external ["wp","domReady"] ***!
  \**********************************/
(module) {

module.exports = window["wp"]["domReady"];

/***/ },

/***/ "@wordpress/element"
/*!*********************************!*\
  !*** external ["wp","element"] ***!
  \*********************************/
(module) {

module.exports = window["wp"]["element"];

/***/ },

/***/ "@wordpress/i18n"
/*!******************************!*\
  !*** external ["wp","i18n"] ***!
  \******************************/
(module) {

module.exports = window["wp"]["i18n"];

/***/ },

/***/ "@wordpress/url"
/*!*****************************!*\
  !*** external ["wp","url"] ***!
  \*****************************/
(module) {

module.exports = window["wp"]["url"];

/***/ },

/***/ "./src/api.js"
/*!********************!*\
  !*** ./src/api.js ***!
  \********************/
(__unused_webpack___webpack_module__, __webpack_exports__, __webpack_require__) {

__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   searchPlugins: () => (/* binding */ searchPlugins)
/* harmony export */ });
/* harmony import */ var _wordpress_api_fetch__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! @wordpress/api-fetch */ "@wordpress/api-fetch");
/* harmony import */ var _wordpress_url__WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! @wordpress/url */ "@wordpress/url");
/**
 * Matomo - free/libre analytics platform
 *
 * @license http://www.gnu.org/licenses/gpl-3.0.html GPL v3 or later
 */



function searchPlugins({
  type,
  search
}) {
  const path = (0,_wordpress_url__WEBPACK_IMPORTED_MODULE_1__.addQueryArgs)('/matomo-marketplace-for-wordpress/v1/plugins', {
    type,
    search
  });
  console.log({
    path
  });
  try {
    return _wordpress_api_fetch__WEBPACK_IMPORTED_MODULE_0__({
      path
    });
  } catch (e) {
    console.log(e.stack || e.message || e);
    throw e;
  }
}

/***/ },

/***/ "./src/debounce.js"
/*!*************************!*\
  !*** ./src/debounce.js ***!
  \*************************/
(__unused_webpack___webpack_module__, __webpack_exports__, __webpack_require__) {

__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "default": () => (/* binding */ debounce)
/* harmony export */ });
const DEFAULT_DEBOUNCE_DELAY = 300;
function debounce(fn, delayInMs = DEFAULT_DEBOUNCE_DELAY) {
  let timeout = null;
  const debounced = function wrapper(...args) {
    if (timeout) {
      clearTimeout(timeout);
    }
    timeout = setTimeout(() => {
      fn.call(this, ...args);
    }, delayInMs);
  };
  debounced.cancel = () => clearTimeout(timeout);
  return debounced;
}

/***/ },

/***/ "./src/plugin-card.js"
/*!****************************!*\
  !*** ./src/plugin-card.js ***!
  \****************************/
(__unused_webpack___webpack_module__, __webpack_exports__, __webpack_require__) {

__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "default": () => (__WEBPACK_DEFAULT_EXPORT__)
/* harmony export */ });
/* harmony import */ var react__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! react */ "react");
/* harmony import */ var _wordpress_element__WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! @wordpress/element */ "@wordpress/element");
/* harmony import */ var _wordpress_components__WEBPACK_IMPORTED_MODULE_2__ = __webpack_require__(/*! @wordpress/components */ "@wordpress/components");
/* harmony import */ var _wordpress_i18n__WEBPACK_IMPORTED_MODULE_3__ = __webpack_require__(/*! @wordpress/i18n */ "@wordpress/i18n");
/* harmony import */ var _plugin_card_scss__WEBPACK_IMPORTED_MODULE_4__ = __webpack_require__(/*! ./plugin-card.scss */ "./src/plugin-card.scss");
/* harmony import */ var react_jsx_runtime__WEBPACK_IMPORTED_MODULE_5__ = __webpack_require__(/*! react/jsx-runtime */ "react/jsx-runtime");
/**
 * Matomo - free/libre analytics platform
 *
 * @license http://www.gnu.org/licenses/gpl-3.0.html GPL v3 or later
 */

// eslint-disable-next-line import/no-extraneous-dependencies






const DownloadButton = ({
  plugin
}) => {
  const [isDownloading, setIsDownloading] = (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_1__.useState)(false);
  let buttonText = plugin.is_downloadable ? (0,_wordpress_i18n__WEBPACK_IMPORTED_MODULE_3__.__)('Download', 'matomo') : (0,_wordpress_i18n__WEBPACK_IMPORTED_MODULE_3__.__)('Start free trial', 'matomo');
  let buttonUrl;
  if (plugin.is_downloadable) {
    buttonUrl = plugin.installUrl;
  } else {
    buttonUrl = plugin.add_to_cart_url || plugin.external_url;
  }
  if (plugin.isInstalled) {
    buttonUrl = '';
    buttonText = (0,_wordpress_i18n__WEBPACK_IMPORTED_MODULE_3__.__)('Installed', 'matomo');
  }
  return /*#__PURE__*/(0,react_jsx_runtime__WEBPACK_IMPORTED_MODULE_5__.jsx)("a", {
    href: buttonUrl,
    target: plugin.is_downloadable ? '' : '_blank',
    rel: plugin.is_downloadable ? '' : 'noreferrer noopener',
    onClick: () => plugin.is_downloadable && setIsDownloading(true),
    children: /*#__PURE__*/(0,react_jsx_runtime__WEBPACK_IMPORTED_MODULE_5__.jsxs)("button", {
      className: "button-primary purchaseable",
      title: buttonText,
      disabled: plugin.isInstalled || isDownloading ? 'disabled' : '',
      children: [buttonText, isDownloading && /*#__PURE__*/(0,react_jsx_runtime__WEBPACK_IMPORTED_MODULE_5__.jsx)(_wordpress_components__WEBPACK_IMPORTED_MODULE_2__.Spinner, {})]
    })
  });
};
const PluginCard = ({
  plugin
}) => {
  const {
    pluginUrl
  } = window.matomoMarketplaceForWordpressData;
  return /*#__PURE__*/(0,react_jsx_runtime__WEBPACK_IMPORTED_MODULE_5__.jsx)(_wordpress_components__WEBPACK_IMPORTED_MODULE_2__.Card, {
    className: "matomo-plugin-card",
    "data-plugin-slug": plugin.slug,
    "data-developer": plugin.owner,
    children: /*#__PURE__*/(0,react_jsx_runtime__WEBPACK_IMPORTED_MODULE_5__.jsx)(react__WEBPACK_IMPORTED_MODULE_0__.Fragment, {
      children: /*#__PURE__*/(0,react_jsx_runtime__WEBPACK_IMPORTED_MODULE_5__.jsxs)(_wordpress_components__WEBPACK_IMPORTED_MODULE_2__.Flex, {
        direction: "column",
        children: [/*#__PURE__*/(0,react_jsx_runtime__WEBPACK_IMPORTED_MODULE_5__.jsx)(_wordpress_components__WEBPACK_IMPORTED_MODULE_2__.CardMedia, {
          children: /*#__PURE__*/(0,react_jsx_runtime__WEBPACK_IMPORTED_MODULE_5__.jsx)("img", {
            src: plugin.cover_image_url,
            alt: "",
            className: "cover-image"
          })
        }), /*#__PURE__*/(0,react_jsx_runtime__WEBPACK_IMPORTED_MODULE_5__.jsx)(_wordpress_components__WEBPACK_IMPORTED_MODULE_2__.CardBody, {
          style: {
            flex: 1
          },
          children: /*#__PURE__*/(0,react_jsx_runtime__WEBPACK_IMPORTED_MODULE_5__.jsxs)(_wordpress_components__WEBPACK_IMPORTED_MODULE_2__.Flex, {
            direction: "column",
            children: [/*#__PURE__*/(0,react_jsx_runtime__WEBPACK_IMPORTED_MODULE_5__.jsxs)("div", {
              className: "card-content-top",
              style: {
                flex: 1
              },
              children: [/*#__PURE__*/(0,react_jsx_runtime__WEBPACK_IMPORTED_MODULE_5__.jsx)("div", {
                className: "price",
                children: plugin.pretty_price ? `${(0,_wordpress_i18n__WEBPACK_IMPORTED_MODULE_3__.__)('From', 'matomo')} ${plugin.pretty_price} / ${plugin.price_period}` : (0,_wordpress_i18n__WEBPACK_IMPORTED_MODULE_3__.__)('Free', 'matomo')
              }), /*#__PURE__*/(0,react_jsx_runtime__WEBPACK_IMPORTED_MODULE_5__.jsxs)("a", {
                className: "card-title-link",
                href: `${plugin.external_url}?wp=1&source=wordpress`,
                target: "_blank",
                rel: "noreferrer noopener",
                tabIndex: "0",
                children: [/*#__PURE__*/(0,react_jsx_runtime__WEBPACK_IMPORTED_MODULE_5__.jsx)("div", {
                  className: "card-focus"
                }), /*#__PURE__*/(0,react_jsx_runtime__WEBPACK_IMPORTED_MODULE_5__.jsxs)("h2", {
                  className: "card-title",
                  children: [plugin.name, /*#__PURE__*/(0,react_jsx_runtime__WEBPACK_IMPORTED_MODULE_5__.jsx)("span", {
                    className: "card-title-chevron",
                    children: "\xA0\u203A"
                  })]
                })]
              }), /*#__PURE__*/(0,react_jsx_runtime__WEBPACK_IMPORTED_MODULE_5__.jsx)("p", {
                className: "card-description",
                children: plugin.description
              })]
            }), /*#__PURE__*/(0,react_jsx_runtime__WEBPACK_IMPORTED_MODULE_5__.jsxs)("div", {
              className: "card-content-bottom",
              children: [/*#__PURE__*/(0,react_jsx_runtime__WEBPACK_IMPORTED_MODULE_5__.jsxs)("div", {
                className: "owner",
                children: [(0,_wordpress_i18n__WEBPACK_IMPORTED_MODULE_3__.__)('Created by', 'matomo'), ' ', /*#__PURE__*/(0,react_jsx_runtime__WEBPACK_IMPORTED_MODULE_5__.jsxs)("span", {
                  children: [" ", plugin.owner]
                })]
              }), /*#__PURE__*/(0,react_jsx_runtime__WEBPACK_IMPORTED_MODULE_5__.jsxs)(_wordpress_components__WEBPACK_IMPORTED_MODULE_2__.Flex, {
                justify: "space-between",
                children: [/*#__PURE__*/(0,react_jsx_runtime__WEBPACK_IMPORTED_MODULE_5__.jsx)("div", {
                  className: "cta-container",
                  children: /*#__PURE__*/(0,react_jsx_runtime__WEBPACK_IMPORTED_MODULE_5__.jsx)(DownloadButton, {
                    plugin: plugin
                  })
                }), /*#__PURE__*/(0,react_jsx_runtime__WEBPACK_IMPORTED_MODULE_5__.jsx)("img", {
                  className: "matomo-badge matomo-badge-bottom",
                  src: `${pluginUrl}/app/plugins/Marketplace/images/matomo-badge.png`,
                  "aria-label": "Matomo plugin",
                  alt: ""
                })]
              })]
            })]
          })
        })]
      })
    }, ".0")
  });
};
/* harmony default export */ const __WEBPACK_DEFAULT_EXPORT__ = (PluginCard);

/***/ },

/***/ "./src/plugin-filters.js"
/*!*******************************!*\
  !*** ./src/plugin-filters.js ***!
  \*******************************/
(__unused_webpack___webpack_module__, __webpack_exports__, __webpack_require__) {

__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "default": () => (__WEBPACK_DEFAULT_EXPORT__)
/* harmony export */ });
/* harmony import */ var _wordpress_components__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! @wordpress/components */ "@wordpress/components");
/* harmony import */ var _wordpress_i18n__WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! @wordpress/i18n */ "@wordpress/i18n");
/* harmony import */ var react_jsx_runtime__WEBPACK_IMPORTED_MODULE_2__ = __webpack_require__(/*! react/jsx-runtime */ "react/jsx-runtime");
/**
 * Matomo - free/libre analytics platform
 *
 * @license http://www.gnu.org/licenses/gpl-3.0.html GPL v3 or later
 */




const PluginFilters = ({
  onFilterChange,
  sort,
  search
}) => {
  return /*#__PURE__*/(0,react_jsx_runtime__WEBPACK_IMPORTED_MODULE_2__.jsxs)(_wordpress_components__WEBPACK_IMPORTED_MODULE_0__.Flex, {
    className: "matomo-plugin-filters",
    justify: "flex-start",
    children: [/*#__PURE__*/(0,react_jsx_runtime__WEBPACK_IMPORTED_MODULE_2__.jsxs)("select", {
      value: sort,
      onChange: e => {
        onFilterChange({
          sort: e.target.value,
          search
        });
      },
      children: [/*#__PURE__*/(0,react_jsx_runtime__WEBPACK_IMPORTED_MODULE_2__.jsx)("option", {
        value: "lastUpdated",
        children: (0,_wordpress_i18n__WEBPACK_IMPORTED_MODULE_1__.__)('Last Updated', 'matomo')
      }), /*#__PURE__*/(0,react_jsx_runtime__WEBPACK_IMPORTED_MODULE_2__.jsx)("option", {
        value: "numDownloads",
        children: (0,_wordpress_i18n__WEBPACK_IMPORTED_MODULE_1__.__)('Popular', 'matomo')
      }), /*#__PURE__*/(0,react_jsx_runtime__WEBPACK_IMPORTED_MODULE_2__.jsx)("option", {
        value: "createdDateTime",
        children: (0,_wordpress_i18n__WEBPACK_IMPORTED_MODULE_1__.__)('Newest', 'matomo')
      }), /*#__PURE__*/(0,react_jsx_runtime__WEBPACK_IMPORTED_MODULE_2__.jsx)("option", {
        value: "displayName",
        children: (0,_wordpress_i18n__WEBPACK_IMPORTED_MODULE_1__.__)('Alphabetically', 'matomo')
      })]
    }), /*#__PURE__*/(0,react_jsx_runtime__WEBPACK_IMPORTED_MODULE_2__.jsx)("input", {
      type: "text",
      value: search,
      placeholder: `${(0,_wordpress_i18n__WEBPACK_IMPORTED_MODULE_1__.__)('Search plugins', 'matomo')}...`,
      onChange: e => {
        onFilterChange({
          search: e.target.value,
          sort
        });
      }
    })]
  });
};
/* harmony default export */ const __WEBPACK_DEFAULT_EXPORT__ = (PluginFilters);

/***/ },

/***/ "./src/plugin-grid.js"
/*!****************************!*\
  !*** ./src/plugin-grid.js ***!
  \****************************/
(__unused_webpack___webpack_module__, __webpack_exports__, __webpack_require__) {

__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "default": () => (__WEBPACK_DEFAULT_EXPORT__)
/* harmony export */ });
/* harmony import */ var _wordpress_components__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! @wordpress/components */ "@wordpress/components");
/* harmony import */ var _wordpress_i18n__WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! @wordpress/i18n */ "@wordpress/i18n");
/* harmony import */ var _plugin_card_js__WEBPACK_IMPORTED_MODULE_2__ = __webpack_require__(/*! ./plugin-card.js */ "./src/plugin-card.js");
/* harmony import */ var react_jsx_runtime__WEBPACK_IMPORTED_MODULE_3__ = __webpack_require__(/*! react/jsx-runtime */ "react/jsx-runtime");
/**
 * Matomo - free/libre analytics platform
 *
 * @license http://www.gnu.org/licenses/gpl-3.0.html GPL v3 or later
 */

// eslint-disable-next-line @wordpress/no-unsafe-wp-apis




const PluginGrid = ({
  plugins
}) => {
  let children;
  if (plugins === null) {
    children = /*#__PURE__*/(0,react_jsx_runtime__WEBPACK_IMPORTED_MODULE_3__.jsx)(_wordpress_components__WEBPACK_IMPORTED_MODULE_0__.Animate, {
      type: "loading",
      children: ({
        className
      }) => /*#__PURE__*/(0,react_jsx_runtime__WEBPACK_IMPORTED_MODULE_3__.jsxs)("span", {
        className: className,
        children: [(0,_wordpress_i18n__WEBPACK_IMPORTED_MODULE_1__.__)('Loading', 'matomo'), "..."]
      })
    });
  } else if (plugins.length === 0) {
    children = /*#__PURE__*/(0,react_jsx_runtime__WEBPACK_IMPORTED_MODULE_3__.jsx)("span", {
      children: (0,_wordpress_i18n__WEBPACK_IMPORTED_MODULE_1__.__)('0 results found.', 'matomo')
    });
  } else {
    children = plugins.map(p => /*#__PURE__*/(0,react_jsx_runtime__WEBPACK_IMPORTED_MODULE_3__.jsx)(_plugin_card_js__WEBPACK_IMPORTED_MODULE_2__["default"], {
      plugin: p
    }, p.slug));
  }
  return /*#__PURE__*/(0,react_jsx_runtime__WEBPACK_IMPORTED_MODULE_3__.jsx)(_wordpress_components__WEBPACK_IMPORTED_MODULE_0__.__experimentalGrid, {
    alignment: "stretch",
    columns: 3,
    gap: 2,
    children: children
  });
};
/* harmony default export */ const __WEBPACK_DEFAULT_EXPORT__ = (PluginGrid);

/***/ }

/******/ 	});
/************************************************************************/
/******/ 	// The module cache
/******/ 	var __webpack_module_cache__ = {};
/******/ 	
/******/ 	// The require function
/******/ 	function __webpack_require__(moduleId) {
/******/ 		// Check if module is in cache
/******/ 		var cachedModule = __webpack_module_cache__[moduleId];
/******/ 		if (cachedModule !== undefined) {
/******/ 			return cachedModule.exports;
/******/ 		}
/******/ 		// Create a new module (and put it into the cache)
/******/ 		var module = __webpack_module_cache__[moduleId] = {
/******/ 			// no module.id needed
/******/ 			// no module.loaded needed
/******/ 			exports: {}
/******/ 		};
/******/ 	
/******/ 		// Execute the module function
/******/ 		if (!(moduleId in __webpack_modules__)) {
/******/ 			delete __webpack_module_cache__[moduleId];
/******/ 			var e = new Error("Cannot find module '" + moduleId + "'");
/******/ 			e.code = 'MODULE_NOT_FOUND';
/******/ 			throw e;
/******/ 		}
/******/ 		__webpack_modules__[moduleId](module, module.exports, __webpack_require__);
/******/ 	
/******/ 		// Return the exports of the module
/******/ 		return module.exports;
/******/ 	}
/******/ 	
/************************************************************************/
/******/ 	/* webpack/runtime/define property getters */
/******/ 	(() => {
/******/ 		// define getter functions for harmony exports
/******/ 		__webpack_require__.d = (exports, definition) => {
/******/ 			for(var key in definition) {
/******/ 				if(__webpack_require__.o(definition, key) && !__webpack_require__.o(exports, key)) {
/******/ 					Object.defineProperty(exports, key, { enumerable: true, get: definition[key] });
/******/ 				}
/******/ 			}
/******/ 		};
/******/ 	})();
/******/ 	
/******/ 	/* webpack/runtime/hasOwnProperty shorthand */
/******/ 	(() => {
/******/ 		__webpack_require__.o = (obj, prop) => (Object.prototype.hasOwnProperty.call(obj, prop))
/******/ 	})();
/******/ 	
/******/ 	/* webpack/runtime/make namespace object */
/******/ 	(() => {
/******/ 		// define __esModule on exports
/******/ 		__webpack_require__.r = (exports) => {
/******/ 			if(typeof Symbol !== 'undefined' && Symbol.toStringTag) {
/******/ 				Object.defineProperty(exports, Symbol.toStringTag, { value: 'Module' });
/******/ 			}
/******/ 			Object.defineProperty(exports, '__esModule', { value: true });
/******/ 		};
/******/ 	})();
/******/ 	
/************************************************************************/
var __webpack_exports__ = {};
// This entry needs to be wrapped in an IIFE because it needs to be isolated against other modules in the chunk.
(() => {
/*!**********************!*\
  !*** ./src/index.js ***!
  \**********************/
__webpack_require__.r(__webpack_exports__);
/* harmony import */ var _wordpress_dom_ready__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! @wordpress/dom-ready */ "@wordpress/dom-ready");
/* harmony import */ var _wordpress_element__WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! @wordpress/element */ "@wordpress/element");
/* harmony import */ var _wordpress_i18n__WEBPACK_IMPORTED_MODULE_2__ = __webpack_require__(/*! @wordpress/i18n */ "@wordpress/i18n");
/* harmony import */ var _plugin_grid_js__WEBPACK_IMPORTED_MODULE_3__ = __webpack_require__(/*! ./plugin-grid.js */ "./src/plugin-grid.js");
/* harmony import */ var _plugin_filters_js__WEBPACK_IMPORTED_MODULE_4__ = __webpack_require__(/*! ./plugin-filters.js */ "./src/plugin-filters.js");
/* harmony import */ var _api_js__WEBPACK_IMPORTED_MODULE_5__ = __webpack_require__(/*! ./api.js */ "./src/api.js");
/* harmony import */ var _install_plugins_scss__WEBPACK_IMPORTED_MODULE_6__ = __webpack_require__(/*! ./install-plugins.scss */ "./src/install-plugins.scss");
/* harmony import */ var _debounce_js__WEBPACK_IMPORTED_MODULE_7__ = __webpack_require__(/*! ./debounce.js */ "./src/debounce.js");
/* harmony import */ var react_jsx_runtime__WEBPACK_IMPORTED_MODULE_8__ = __webpack_require__(/*! react/jsx-runtime */ "react/jsx-runtime");
/**
 * Matomo - free/libre analytics platform
 *
 * @license http://www.gnu.org/licenses/gpl-3.0.html GPL v3 or later
 */










function isSortAscending(sort) {
  return sort === 'displayName';
}
let currentQuery;
const searchUsingFilter = async (setPlugins, {
  sort,
  search
}) => {
  currentQuery = {
    sort,
    search
  };
  setPlugins(null);
  const searchResult = await (0,_api_js__WEBPACK_IMPORTED_MODULE_5__.searchPlugins)({
    type: 'plugins',
    search
  });
  if (currentQuery.sort !== sort || currentQuery.search !== search) {
    return;
  }
  if (isSortAscending(sort)) {
    searchResult.sort(function (lhs, rhs) {
      if (lhs[sort] === rhs[sort]) {
        return 0;
      }
      return lhs[sort] < rhs[sort] ? -1 : 1;
    });
  } else {
    searchResult.sort(function (lhs, rhs) {
      if (lhs[sort] === rhs[sort]) {
        return 0;
      }
      return rhs[sort] < lhs[sort] ? -1 : 1;
    });
  }
  setPlugins(searchResult);
};
const MarketplacePage = () => {
  const [plugins, setPlugins] = (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_1__.useState)(null);
  const [sort, setSort] = (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_1__.useState)('lastUpdated');
  const [search, setSearch] = (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_1__.useState)('');
  const searchUsingFilterDebounced = (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_1__.useMemo)(() => (0,_debounce_js__WEBPACK_IMPORTED_MODULE_7__["default"])(searchUsingFilter.bind(null, setPlugins), 300));

  // initialize search to URL query param if there is a value there
  (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_1__.useEffect)(() => {
    const params = new URLSearchParams(document.location.search);
    const s = (params.get('search') || '').trim();
    if (s.length) {
      setSearch(s);
    }
  });
  (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_1__.useEffect)(() => {
    searchUsingFilterDebounced({
      sort,
      search
    });
    return () => {
      searchUsingFilterDebounced.cancel();
    };
  }, [sort, search]);
  return /*#__PURE__*/(0,react_jsx_runtime__WEBPACK_IMPORTED_MODULE_8__.jsxs)("div", {
    className: "matomo-marketplace-install-plugins",
    children: [/*#__PURE__*/(0,react_jsx_runtime__WEBPACK_IMPORTED_MODULE_8__.jsx)("h1", {
      children: (0,_wordpress_i18n__WEBPACK_IMPORTED_MODULE_2__.__)('Marketplace', 'matomo')
    }), /*#__PURE__*/(0,react_jsx_runtime__WEBPACK_IMPORTED_MODULE_8__.jsx)("p", {
      style: {
        margin: '2em 0'
      },
      children: (0,_wordpress_i18n__WEBPACK_IMPORTED_MODULE_2__.__)("Expand Matomo's functionality with plugins. Start free trials for" + ' premium plugins or directly install free plugins developed by the Matomo' + ' community.', 'matomo')
    }), /*#__PURE__*/(0,react_jsx_runtime__WEBPACK_IMPORTED_MODULE_8__.jsx)(_plugin_filters_js__WEBPACK_IMPORTED_MODULE_4__["default"], {
      sort: sort,
      search: search,
      onFilterChange: ({
        sort,
        search
      }) => {
        setSort(sort);
        setSearch(search);
      }
    }), /*#__PURE__*/(0,react_jsx_runtime__WEBPACK_IMPORTED_MODULE_8__.jsx)(_plugin_grid_js__WEBPACK_IMPORTED_MODULE_3__["default"], {
      plugins: plugins
    })]
  });
};
_wordpress_dom_ready__WEBPACK_IMPORTED_MODULE_0__(() => {
  const rootElement = document.getElementById('matomo-marketplace-for-wordpress');
  const root = (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_1__.createRoot)(rootElement);
  root.render(/*#__PURE__*/(0,react_jsx_runtime__WEBPACK_IMPORTED_MODULE_8__.jsx)(MarketplacePage, {}));
});
})();

/******/ })()
;
//# sourceMappingURL=index.js.map
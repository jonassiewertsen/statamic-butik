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
/******/ 			Object.defineProperty(exports, name, {
/******/ 				configurable: false,
/******/ 				enumerable: true,
/******/ 				get: getter
/******/ 			});
/******/ 		}
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
/******/ 	__webpack_require__.p = "/";
/******/
/******/ 	// Load entry module and return exports
/******/ 	return __webpack_require__(__webpack_require__.s = 2);
/******/ })
/************************************************************************/
/******/ ([
/* 0 */
/***/ (function(module, exports) {

/* globals __VUE_SSR_CONTEXT__ */

// IMPORTANT: Do NOT use ES2015 features in this file.
// This module is a runtime utility for cleaner component module output and will
// be included in the final webpack user bundle.

module.exports = function normalizeComponent (
  rawScriptExports,
  compiledTemplate,
  functionalTemplate,
  injectStyles,
  scopeId,
  moduleIdentifier /* server only */
) {
  var esModule
  var scriptExports = rawScriptExports = rawScriptExports || {}

  // ES6 modules interop
  var type = typeof rawScriptExports.default
  if (type === 'object' || type === 'function') {
    esModule = rawScriptExports
    scriptExports = rawScriptExports.default
  }

  // Vue.extend constructor export interop
  var options = typeof scriptExports === 'function'
    ? scriptExports.options
    : scriptExports

  // render functions
  if (compiledTemplate) {
    options.render = compiledTemplate.render
    options.staticRenderFns = compiledTemplate.staticRenderFns
    options._compiled = true
  }

  // functional template
  if (functionalTemplate) {
    options.functional = true
  }

  // scopedId
  if (scopeId) {
    options._scopeId = scopeId
  }

  var hook
  if (moduleIdentifier) { // server build
    hook = function (context) {
      // 2.3 injection
      context =
        context || // cached call
        (this.$vnode && this.$vnode.ssrContext) || // stateful
        (this.parent && this.parent.$vnode && this.parent.$vnode.ssrContext) // functional
      // 2.2 with runInNewContext: true
      if (!context && typeof __VUE_SSR_CONTEXT__ !== 'undefined') {
        context = __VUE_SSR_CONTEXT__
      }
      // inject component styles
      if (injectStyles) {
        injectStyles.call(this, context)
      }
      // register component module identifier for async chunk inferrence
      if (context && context._registeredComponents) {
        context._registeredComponents.add(moduleIdentifier)
      }
    }
    // used by ssr in case component is cached and beforeCreate
    // never gets called
    options._ssrRegister = hook
  } else if (injectStyles) {
    hook = injectStyles
  }

  if (hook) {
    var functional = options.functional
    var existing = functional
      ? options.render
      : options.beforeCreate

    if (!functional) {
      // inject component registration as beforeCreate hook
      options.beforeCreate = existing
        ? [].concat(existing, hook)
        : [hook]
    } else {
      // for template-only hot-reload because in that case the render fn doesn't
      // go through the normalizer
      options._injectStyles = hook
      // register for functioal component in vue file
      options.render = function renderWithStyleInjection (h, context) {
        hook.call(context)
        return existing(h, context)
      }
    }
  }

  return {
    esModule: esModule,
    exports: scriptExports,
    options: options
  }
}


/***/ }),
/* 1 */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
/* harmony default export */ __webpack_exports__["a"] = ({
    data: function data() {
        return {
            deletingRow: false
        };
    },


    computed: {
        deletingModalTitle: function deletingModalTitle() {
            return this.deletingModalTitleFromRowKey('title');
        }
    },

    methods: {
        confirmDeleteRow: function confirmDeleteRow(id, index) {
            this.deletingRow = { id: id, index: index };
        },
        deletingModalTitleFromRowKey: function deletingModalTitleFromRowKey(key) {
            return __('Delete') + ' ' + this.rows[this.deletingRow.index][key];
        },
        deleteRow: function deleteRow(resourceRoute, message) {
            var _this = this;

            var id = this.deletingRow.id;
            message = message || __('Deleted');

            this.$axios.delete(resourceRoute + '/' + id).then(function () {
                var i = _.indexOf(_this.rows, _.findWhere(_this.rows, { id: id }));
                _this.rows.splice(i, 1);
                _this.deletingRow = false;
                _this.$toast.success(message);

                if (_this.rows.length === 0) location.reload();
            }).catch(function (e) {
                _this.$toast.error(e.response ? e.response.data.message : __('Something went wrong'));
            });
        },
        cancelDeleteRow: function cancelDeleteRow() {
            this.deletingRow = false;
        }
    }
});

/***/ }),
/* 2 */
/***/ (function(module, exports, __webpack_require__) {

__webpack_require__(3);
module.exports = __webpack_require__(19);


/***/ }),
/* 3 */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
Object.defineProperty(__webpack_exports__, "__esModule", { value: true });
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_0__components_products_Listing__ = __webpack_require__(4);
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_0__components_products_Listing___default = __webpack_require__.n(__WEBPACK_IMPORTED_MODULE_0__components_products_Listing__);
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_1__components_shippings_Listing__ = __webpack_require__(7);
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_1__components_shippings_Listing___default = __webpack_require__.n(__WEBPACK_IMPORTED_MODULE_1__components_shippings_Listing__);
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_2__components_taxes_Listing__ = __webpack_require__(10);
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_2__components_taxes_Listing___default = __webpack_require__.n(__WEBPACK_IMPORTED_MODULE_2__components_taxes_Listing__);
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_3__components_orders_Listing__ = __webpack_require__(13);
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_3__components_orders_Listing___default = __webpack_require__.n(__WEBPACK_IMPORTED_MODULE_3__components_orders_Listing__);
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_4__components_fieldtypes_moneyFieldtype__ = __webpack_require__(16);
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_4__components_fieldtypes_moneyFieldtype___default = __webpack_require__.n(__WEBPACK_IMPORTED_MODULE_4__components_fieldtypes_moneyFieldtype__);







Statamic.booting(function () {
    // Listings
    Statamic.$components.register('butik-product-list', __WEBPACK_IMPORTED_MODULE_0__components_products_Listing___default.a);
    Statamic.$components.register('butik-shipping-list', __WEBPACK_IMPORTED_MODULE_1__components_shippings_Listing___default.a);
    Statamic.$components.register('butik-tax-list', __WEBPACK_IMPORTED_MODULE_2__components_taxes_Listing___default.a);
    Statamic.$components.register('butik-order-list', __WEBPACK_IMPORTED_MODULE_3__components_orders_Listing___default.a);

    // Fieldtypes
    Statamic.$components.register('money-fieldtype', __WEBPACK_IMPORTED_MODULE_4__components_fieldtypes_moneyFieldtype___default.a);
});

/***/ }),
/* 4 */
/***/ (function(module, exports, __webpack_require__) {

var disposed = false
var normalizeComponent = __webpack_require__(0)
/* script */
var __vue_script__ = __webpack_require__(5)
/* template */
var __vue_template__ = __webpack_require__(6)
/* template functional */
var __vue_template_functional__ = false
/* styles */
var __vue_styles__ = null
/* scopeId */
var __vue_scopeId__ = null
/* moduleIdentifier (server only) */
var __vue_module_identifier__ = null
var Component = normalizeComponent(
  __vue_script__,
  __vue_template__,
  __vue_template_functional__,
  __vue_styles__,
  __vue_scopeId__,
  __vue_module_identifier__
)
Component.options.__file = "resources/js/components/products/Listing.vue"

/* hot reload */
if (false) {(function () {
  var hotAPI = require("vue-hot-reload-api")
  hotAPI.install(require("vue"), false)
  if (!hotAPI.compatible) return
  module.hot.accept()
  if (!module.hot.data) {
    hotAPI.createRecord("data-v-24d71684", Component.options)
  } else {
    hotAPI.reload("data-v-24d71684", Component.options)
  }
  module.hot.dispose(function (data) {
    disposed = true
  })
})()}

module.exports = Component.exports


/***/ }),
/* 5 */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
Object.defineProperty(__webpack_exports__, "__esModule", { value: true });
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_0__DeletesListingRow_js__ = __webpack_require__(1);
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//



/* harmony default export */ __webpack_exports__["default"] = ({

    mixins: [__WEBPACK_IMPORTED_MODULE_0__DeletesListingRow_js__["a" /* default */]],

    props: ['initial-rows', 'columns'],

    data: function data() {
        return {
            rows: this.initialRows
        };
    }
});

/***/ }),
/* 6 */
/***/ (function(module, exports, __webpack_require__) {

var render = function() {
  var _vm = this
  var _h = _vm.$createElement
  var _c = _vm._self._c || _h
  return _c("data-list", {
    attrs: { columns: _vm.columns, rows: _vm.rows },
    scopedSlots: _vm._u([
      {
        key: "default",
        fn: function(ref) {
          var rows = ref.filteredRows
          return _c(
            "div",
            { staticClass: "card p-0" },
            [
              _c("data-list-table", {
                attrs: { rows: rows },
                scopedSlots: _vm._u(
                  [
                    {
                      key: "cell-title",
                      fn: function(ref) {
                        var collection = ref.row
                        return [
                          _c("a", { attrs: { href: collection.edit_url } }, [
                            _vm._v(_vm._s(collection.title))
                          ])
                        ]
                      }
                    },
                    {
                      key: "actions",
                      fn: function(ref) {
                        var collection = ref.row
                        var index = ref.index
                        return [
                          _c(
                            "dropdown-list",
                            [
                              _c("dropdown-item", {
                                attrs: {
                                  text: _vm.__("Edit"),
                                  redirect: collection.edit_url
                                }
                              }),
                              _vm._v(" "),
                              collection.deleteable
                                ? _c("dropdown-item", {
                                    staticClass: "warning",
                                    attrs: { text: _vm.__("Delete") },
                                    on: {
                                      click: function($event) {
                                        return _vm.confirmDeleteRow(
                                          collection.slug,
                                          index
                                        )
                                      }
                                    }
                                  })
                                : _vm._e()
                            ],
                            1
                          ),
                          _vm._v(" "),
                          _vm.deletingRow !== false
                            ? _c("confirmation-modal", {
                                attrs: {
                                  title: _vm.deletingModalTitle,
                                  bodyText: _vm.__(
                                    "Are you sure you want to delete this product?"
                                  ),
                                  buttonText: _vm.__("Delete"),
                                  danger: true
                                },
                                on: {
                                  confirm: function($event) {
                                    return _vm.deleteRow("/cp/butik/products")
                                  },
                                  cancel: _vm.cancelDeleteRow
                                }
                              })
                            : _vm._e()
                        ]
                      }
                    }
                  ],
                  null,
                  true
                )
              })
            ],
            1
          )
        }
      }
    ])
  })
}
var staticRenderFns = []
render._withStripped = true
module.exports = { render: render, staticRenderFns: staticRenderFns }
if (false) {
  module.hot.accept()
  if (module.hot.data) {
    require("vue-hot-reload-api")      .rerender("data-v-24d71684", module.exports)
  }
}

/***/ }),
/* 7 */
/***/ (function(module, exports, __webpack_require__) {

var disposed = false
var normalizeComponent = __webpack_require__(0)
/* script */
var __vue_script__ = __webpack_require__(8)
/* template */
var __vue_template__ = __webpack_require__(9)
/* template functional */
var __vue_template_functional__ = false
/* styles */
var __vue_styles__ = null
/* scopeId */
var __vue_scopeId__ = null
/* moduleIdentifier (server only) */
var __vue_module_identifier__ = null
var Component = normalizeComponent(
  __vue_script__,
  __vue_template__,
  __vue_template_functional__,
  __vue_styles__,
  __vue_scopeId__,
  __vue_module_identifier__
)
Component.options.__file = "resources/js/components/shippings/Listing.vue"

/* hot reload */
if (false) {(function () {
  var hotAPI = require("vue-hot-reload-api")
  hotAPI.install(require("vue"), false)
  if (!hotAPI.compatible) return
  module.hot.accept()
  if (!module.hot.data) {
    hotAPI.createRecord("data-v-169cd9c2", Component.options)
  } else {
    hotAPI.reload("data-v-169cd9c2", Component.options)
  }
  module.hot.dispose(function (data) {
    disposed = true
  })
})()}

module.exports = Component.exports


/***/ }),
/* 8 */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
Object.defineProperty(__webpack_exports__, "__esModule", { value: true });
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_0__DeletesListingRow_js__ = __webpack_require__(1);
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//



/* harmony default export */ __webpack_exports__["default"] = ({

    mixins: [__WEBPACK_IMPORTED_MODULE_0__DeletesListingRow_js__["a" /* default */]],

    props: ['initial-rows', 'columns'],

    data: function data() {
        return {
            rows: this.initialRows
        };
    }
});

/***/ }),
/* 9 */
/***/ (function(module, exports, __webpack_require__) {

var render = function() {
  var _vm = this
  var _h = _vm.$createElement
  var _c = _vm._self._c || _h
  return _c("data-list", {
    attrs: { columns: _vm.columns, rows: _vm.rows },
    scopedSlots: _vm._u([
      {
        key: "default",
        fn: function(ref) {
          var rows = ref.filteredRows
          return _c(
            "div",
            { staticClass: "card p-0" },
            [
              _c("data-list-table", {
                attrs: { rows: rows },
                scopedSlots: _vm._u(
                  [
                    {
                      key: "cell-title",
                      fn: function(ref) {
                        var collection = ref.row
                        return [
                          _c("a", { attrs: { href: collection.edit_url } }, [
                            _vm._v(_vm._s(collection.title))
                          ])
                        ]
                      }
                    },
                    {
                      key: "actions",
                      fn: function(ref) {
                        var collection = ref.row
                        var index = ref.index
                        return [
                          _c(
                            "dropdown-list",
                            [
                              _c("dropdown-item", {
                                attrs: {
                                  text: _vm.__("Edit"),
                                  redirect: collection.edit_url
                                }
                              }),
                              _vm._v(" "),
                              collection.deleteable
                                ? _c("dropdown-item", {
                                    staticClass: "warning",
                                    attrs: { text: _vm.__("Delete") },
                                    on: {
                                      click: function($event) {
                                        return _vm.confirmDeleteRow(
                                          collection.slug,
                                          index
                                        )
                                      }
                                    }
                                  })
                                : _vm._e()
                            ],
                            1
                          ),
                          _vm._v(" "),
                          _vm.deletingRow !== false
                            ? _c("confirmation-modal", {
                                attrs: {
                                  title: _vm.deletingModalTitle,
                                  bodyText: _vm.__(
                                    "Are you sure you want to delete this shipping? You will not be able to delete this shipping if used by any product."
                                  ),
                                  buttonText: _vm.__("Delete"),
                                  danger: true
                                },
                                on: {
                                  confirm: function($event) {
                                    return _vm.deleteRow(
                                      "/cp/butik/settings/shippings"
                                    )
                                  },
                                  cancel: _vm.cancelDeleteRow
                                }
                              })
                            : _vm._e()
                        ]
                      }
                    }
                  ],
                  null,
                  true
                )
              })
            ],
            1
          )
        }
      }
    ])
  })
}
var staticRenderFns = []
render._withStripped = true
module.exports = { render: render, staticRenderFns: staticRenderFns }
if (false) {
  module.hot.accept()
  if (module.hot.data) {
    require("vue-hot-reload-api")      .rerender("data-v-169cd9c2", module.exports)
  }
}

/***/ }),
/* 10 */
/***/ (function(module, exports, __webpack_require__) {

var disposed = false
var normalizeComponent = __webpack_require__(0)
/* script */
var __vue_script__ = __webpack_require__(11)
/* template */
var __vue_template__ = __webpack_require__(12)
/* template functional */
var __vue_template_functional__ = false
/* styles */
var __vue_styles__ = null
/* scopeId */
var __vue_scopeId__ = null
/* moduleIdentifier (server only) */
var __vue_module_identifier__ = null
var Component = normalizeComponent(
  __vue_script__,
  __vue_template__,
  __vue_template_functional__,
  __vue_styles__,
  __vue_scopeId__,
  __vue_module_identifier__
)
Component.options.__file = "resources/js/components/taxes/Listing.vue"

/* hot reload */
if (false) {(function () {
  var hotAPI = require("vue-hot-reload-api")
  hotAPI.install(require("vue"), false)
  if (!hotAPI.compatible) return
  module.hot.accept()
  if (!module.hot.data) {
    hotAPI.createRecord("data-v-5bb8a8b3", Component.options)
  } else {
    hotAPI.reload("data-v-5bb8a8b3", Component.options)
  }
  module.hot.dispose(function (data) {
    disposed = true
  })
})()}

module.exports = Component.exports


/***/ }),
/* 11 */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
Object.defineProperty(__webpack_exports__, "__esModule", { value: true });
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_0__DeletesListingRow_js__ = __webpack_require__(1);
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//



/* harmony default export */ __webpack_exports__["default"] = ({

    mixins: [__WEBPACK_IMPORTED_MODULE_0__DeletesListingRow_js__["a" /* default */]],

    props: ['initial-rows', 'columns'],

    data: function data() {
        return {
            rows: this.initialRows
        };
    }
});

/***/ }),
/* 12 */
/***/ (function(module, exports, __webpack_require__) {

var render = function() {
  var _vm = this
  var _h = _vm.$createElement
  var _c = _vm._self._c || _h
  return _c("data-list", {
    attrs: { columns: _vm.columns, rows: _vm.rows },
    scopedSlots: _vm._u([
      {
        key: "default",
        fn: function(ref) {
          var rows = ref.filteredRows
          return _c(
            "div",
            { staticClass: "card p-0" },
            [
              _c("data-list-table", {
                attrs: { rows: rows },
                scopedSlots: _vm._u(
                  [
                    {
                      key: "cell-title",
                      fn: function(ref) {
                        var collection = ref.row
                        return [
                          _c("a", { attrs: { href: collection.edit_url } }, [
                            _vm._v(_vm._s(collection.title))
                          ])
                        ]
                      }
                    },
                    {
                      key: "actions",
                      fn: function(ref) {
                        var collection = ref.row
                        var index = ref.index
                        return [
                          _c(
                            "dropdown-list",
                            [
                              _c("dropdown-item", {
                                attrs: {
                                  text: _vm.__("Edit"),
                                  redirect: collection.edit_url
                                }
                              }),
                              _vm._v(" "),
                              collection.deleteable
                                ? _c("dropdown-item", {
                                    staticClass: "warning",
                                    attrs: { text: _vm.__("Delete") },
                                    on: {
                                      click: function($event) {
                                        return _vm.confirmDeleteRow(
                                          collection.slug,
                                          index
                                        )
                                      }
                                    }
                                  })
                                : _vm._e()
                            ],
                            1
                          ),
                          _vm._v(" "),
                          _vm.deletingRow !== false
                            ? _c("confirmation-modal", {
                                attrs: {
                                  title: _vm.deletingModalTitle,
                                  bodyText: _vm.__(
                                    "Are you sure you want to delete this tax? You will not be able to delete this shipping if used by any product."
                                  ),
                                  buttonText: _vm.__("Delete"),
                                  danger: true
                                },
                                on: {
                                  confirm: function($event) {
                                    return _vm.deleteRow(
                                      "/cp/butik/settings/taxes"
                                    )
                                  },
                                  cancel: _vm.cancelDeleteRow
                                }
                              })
                            : _vm._e()
                        ]
                      }
                    }
                  ],
                  null,
                  true
                )
              })
            ],
            1
          )
        }
      }
    ])
  })
}
var staticRenderFns = []
render._withStripped = true
module.exports = { render: render, staticRenderFns: staticRenderFns }
if (false) {
  module.hot.accept()
  if (module.hot.data) {
    require("vue-hot-reload-api")      .rerender("data-v-5bb8a8b3", module.exports)
  }
}

/***/ }),
/* 13 */
/***/ (function(module, exports, __webpack_require__) {

var disposed = false
var normalizeComponent = __webpack_require__(0)
/* script */
var __vue_script__ = __webpack_require__(14)
/* template */
var __vue_template__ = __webpack_require__(15)
/* template functional */
var __vue_template_functional__ = false
/* styles */
var __vue_styles__ = null
/* scopeId */
var __vue_scopeId__ = null
/* moduleIdentifier (server only) */
var __vue_module_identifier__ = null
var Component = normalizeComponent(
  __vue_script__,
  __vue_template__,
  __vue_template_functional__,
  __vue_styles__,
  __vue_scopeId__,
  __vue_module_identifier__
)
Component.options.__file = "resources/js/components/orders/Listing.vue"

/* hot reload */
if (false) {(function () {
  var hotAPI = require("vue-hot-reload-api")
  hotAPI.install(require("vue"), false)
  if (!hotAPI.compatible) return
  module.hot.accept()
  if (!module.hot.data) {
    hotAPI.createRecord("data-v-1a4cbf45", Component.options)
  } else {
    hotAPI.reload("data-v-1a4cbf45", Component.options)
  }
  module.hot.dispose(function (data) {
    disposed = true
  })
})()}

module.exports = Component.exports


/***/ }),
/* 14 */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
Object.defineProperty(__webpack_exports__, "__esModule", { value: true });
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_0__DeletesListingRow_js__ = __webpack_require__(1);
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//



/* harmony default export */ __webpack_exports__["default"] = ({

    mixins: [__WEBPACK_IMPORTED_MODULE_0__DeletesListingRow_js__["a" /* default */]],

    props: ['initial-rows', 'columns'],

    data: function data() {
        return {
            rows: this.initialRows
        };
    }
});

/***/ }),
/* 15 */
/***/ (function(module, exports, __webpack_require__) {

var render = function() {
  var _vm = this
  var _h = _vm.$createElement
  var _c = _vm._self._c || _h
  return _c("data-list", {
    attrs: { columns: _vm.columns, rows: _vm.rows },
    scopedSlots: _vm._u([
      {
        key: "default",
        fn: function(ref) {
          var rows = ref.filteredRows
          return _c(
            "div",
            { staticClass: "card p-0" },
            [
              _c("data-list-table", {
                attrs: { rows: rows },
                scopedSlots: _vm._u(
                  [
                    {
                      key: "cell-title",
                      fn: function(ref) {
                        var collection = ref.row
                        return [
                          _c("a", { attrs: { href: collection.edit_url } }, [
                            _vm._v(_vm._s(collection.title))
                          ])
                        ]
                      }
                    },
                    {
                      key: "actions",
                      fn: function(ref) {
                        var collection = ref.row
                        var index = ref.index
                        return [
                          _c(
                            "dropdown-list",
                            [
                              _c("dropdown-item", {
                                attrs: {
                                  text: _vm.__("Edit"),
                                  redirect: collection.edit_url
                                }
                              }),
                              _vm._v(" "),
                              collection.deleteable
                                ? _c("dropdown-item", {
                                    staticClass: "warning",
                                    attrs: { text: _vm.__("Delete") },
                                    on: {
                                      click: function($event) {
                                        return _vm.confirmDeleteRow(
                                          collection.slug,
                                          index
                                        )
                                      }
                                    }
                                  })
                                : _vm._e()
                            ],
                            1
                          ),
                          _vm._v(" "),
                          _vm.deletingRow !== false
                            ? _c("confirmation-modal", {
                                attrs: {
                                  title: _vm.deletingModalTitle,
                                  bodyText: _vm.__(
                                    "Are you sure you want to delete this product?"
                                  ),
                                  buttonText: _vm.__("Delete"),
                                  danger: true
                                },
                                on: {
                                  confirm: function($event) {
                                    return _vm.deleteRow("/cp/butik/products")
                                  },
                                  cancel: _vm.cancelDeleteRow
                                }
                              })
                            : _vm._e()
                        ]
                      }
                    }
                  ],
                  null,
                  true
                )
              })
            ],
            1
          )
        }
      }
    ])
  })
}
var staticRenderFns = []
render._withStripped = true
module.exports = { render: render, staticRenderFns: staticRenderFns }
if (false) {
  module.hot.accept()
  if (module.hot.data) {
    require("vue-hot-reload-api")      .rerender("data-v-1a4cbf45", module.exports)
  }
}

/***/ }),
/* 16 */
/***/ (function(module, exports, __webpack_require__) {

var disposed = false
var normalizeComponent = __webpack_require__(0)
/* script */
var __vue_script__ = __webpack_require__(17)
/* template */
var __vue_template__ = __webpack_require__(18)
/* template functional */
var __vue_template_functional__ = false
/* styles */
var __vue_styles__ = null
/* scopeId */
var __vue_scopeId__ = null
/* moduleIdentifier (server only) */
var __vue_module_identifier__ = null
var Component = normalizeComponent(
  __vue_script__,
  __vue_template__,
  __vue_template_functional__,
  __vue_styles__,
  __vue_scopeId__,
  __vue_module_identifier__
)
Component.options.__file = "resources/js/components/fieldtypes/moneyFieldtype.vue"

/* hot reload */
if (false) {(function () {
  var hotAPI = require("vue-hot-reload-api")
  hotAPI.install(require("vue"), false)
  if (!hotAPI.compatible) return
  module.hot.accept()
  if (!module.hot.data) {
    hotAPI.createRecord("data-v-cc901e2e", Component.options)
  } else {
    hotAPI.reload("data-v-cc901e2e", Component.options)
  }
  module.hot.dispose(function (data) {
    disposed = true
  })
})()}

module.exports = Component.exports


/***/ }),
/* 17 */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
Object.defineProperty(__webpack_exports__, "__esModule", { value: true });
//
//
//
//
//
//

/* harmony default export */ __webpack_exports__["default"] = ({
    mixins: [Fieldtype],

    data: function data() {
        return {
            currencySymbol: this.meta.currencySymbol
        };
    }
});

/***/ }),
/* 18 */
/***/ (function(module, exports, __webpack_require__) {

var render = function() {
  var _vm = this
  var _h = _vm.$createElement
  var _c = _vm._self._c || _h
  return _c(
    "div",
    [
      _c("text-input", {
        attrs: {
          type: "number",
          prepend: _vm.currencySymbol,
          min: "0",
          placeholder: "0.00",
          value: _vm.value
        },
        on: { input: _vm.update }
      })
    ],
    1
  )
}
var staticRenderFns = []
render._withStripped = true
module.exports = { render: render, staticRenderFns: staticRenderFns }
if (false) {
  module.hot.accept()
  if (module.hot.data) {
    require("vue-hot-reload-api")      .rerender("data-v-cc901e2e", module.exports)
  }
}

/***/ }),
/* 19 */
/***/ (function(module, exports) {

// removed by extract-text-webpack-plugin

/***/ })
/******/ ]);
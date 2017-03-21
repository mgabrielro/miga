/**
 * Gets and/or creates a namespace object by its full qualified name.
 * Also runs a given callback method with the scope of the passed in namespace.
 *
 * @param namespaceName The full qualified namespace name (e.g. c24.main.pages.customer)
 * @param [callback] Callback to be called with given namespace scope
 * @param [namespaceToExtendFrom] A "base" ObjectLateral from which the new namespace should "inherit" properties and methods. This is NOT for real inheritance!!!
 * @returns object
 */
function namespace(namespaceName, callback, namespaceToExtendFrom) {

    var parts = namespaceName.split('.'),
        parent = window,
        currentPart = '',
        hasCallback = !!callback;

    for(var i = 0, length = parts.length; i < length; i++) {
        currentPart = parts[i];
        // Check for existing namespace
        // If this one does not exist, create new one with parent namespace
        parent[currentPart] = parent[currentPart] || {parentNS: parent};
        parent = parent[currentPart];
    }

    if(hasCallback) callback.apply(parent, null);

    if(!!namespaceToExtendFrom){
        parent = $.extend(parent, namespaceToExtendFrom);
    }

    return parent;
}


var Class = {
    create: function() {
        var methods = null,
            parent  = undefined,
            klass   = function() {
                this.$super = function(method, args) { return Class.$super(this.$parent, this, method, args); };
                this.initialize.apply(this, arguments);
            };

        if (typeof arguments[0] === 'function') {
            parent = arguments[0];
            methods = arguments[1];
        } else {
            methods = arguments[0];
        }

        if (typeof parent !== 'undefined') {
            Class.extend(klass.prototype, parent.prototype);
            klass.prototype.$parent = parent.prototype;
        }

        Class.mixin(klass, methods);
        Class.extend(klass.prototype, methods);
        klass.prototype.constructor = klass;

        if (!klass.prototype.initialize)
            klass.prototype.initialize = function(){};

        return klass;
    },

    mixin: function(klass, methods) {
        if (typeof methods.include !== 'undefined') {
            if (typeof methods.include === 'function') {
                Class.extend(klass.prototype, methods.include.prototype);
            } else {
                for (var i = 0; i < methods.include.length; i++) {
                    Class.extend(klass.prototype, methods.include[i].prototype);
                }
            }
        }
    },

    extend: function(destination, source) {
        for (var property in source)
            destination[property] = source[property];
        return destination;
    },
    $super: function(parentClass, instance, method, args) {
        return parentClass[method].apply(instance, args);
    }
};


/**
 * Added thousand seperator and Decimal seperator to a number
 */
function numberWithCommas(n) {

    if (typeof n != 'undefined') {
        var parts = n.toString().split(',');
        return parts[0].replace(/\B(?=(\d\d\d)+(?!\d))/g, '.') + (parts[1] ? ',' + parts[1] : '');
    } else {
        return n;
    }
}

/**
 * Format a number to the german rules
 */
Number.prototype.formatMoneyDe = function(no_of_decimals, tousand_sep, decimal_sep){
    var n = this,
        c = isNaN(no_of_decimals = Math.abs(no_of_decimals)) ? 2 : no_of_decimals,
        d = tousand_sep == undefined ? "." : tousand_sep,
        t = decimal_sep == undefined ? "," : decimal_sep,
        s = n < 0 ? "-" : "",
        i = parseInt(n = Math.abs(+n || 0).toFixed(c)) + "",
        j = (j = i.length) > 3 ? j % 3 : 0;
    return s + (j ? i.substr(0, j) + t : "") + i.substr(j).replace(/(\d{3})(?=\d)/g, "$1" + t) + (c ? d + Math.abs(n - i).toFixed(c).slice(2) : "");
};


/**
 * Clean a string and removes all non number character
 */
function cleanupNumber(n) {
    return n.replace(/[^0-9]/g, '');
}

/**
 * Returns the requested URL parameter value if exists OR
 * undefined if the parameter is not present in the query string
 *
 * @param {string} param URL Parameter name
 *
 * @returns {string|undefined}
 */
function get_url_param(param) {

    var query_string = {};
    var query = window.location.search.substring(1);
    var params_array = query.split('&');

    for (var i = 0; i < params_array.length; i++) {
        var pair = params_array[i].split('=');
        query_string[pair[0]] = pair[1];
    }

    return query_string[param];

}
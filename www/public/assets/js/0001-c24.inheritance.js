(function (ns) {
    'use strict';

    Function.prototype.inherit = function(source){
        ns.inherit(this, source);
    };

})(namespace("c24.inheritance", $.noop, {

    /**
     * Causes your desired class to inherit from a source class. This uses
     * prototypical inheritance so you can override methods without ruining
     * the parent class.
     *
     * This will alter the actual destination class though, it does not
     * create a new class.
     *
     * @param {Function} destination The target class for the inheritance.
     * @param {Function} source Class to inherit from.
     * @param {Boolean} addSuper Should we add the _super property to the prototype? Defaults to true.
     */
    inherit: function inherit(destination, source, addSuper) {
        var proto = destination.prototype = this.createObject(source.prototype);
        proto.constructor = destination;

        if (addSuper || typeof addSuper === 'undefined') {
            destination._super = source.prototype;
            proto._super = source.prototype;
        }
    },

    /**
     * Creates a new object with the source object nestled within its
     * prototype chain.
     *
     * @param {Object} source Method to insert into the new object's prototype.
     * @return {Object} An empty object with the source object in it's prototype chain.
     */
    createObject: Object.create || function createObject(source) {
        var Host = function () {};
        Host.prototype = source;
        return new Host();
    },

    /**
     * Mixes the specified object into your class. This can be used to add
     * certain capabilities and helper methods to a class that is already
     * inheriting from some other class. You can mix in as many object as
     * you want, but only inherit from one.
     *
     * These values are mixed into the actual prototype object of your
     * class, they are not added to the prototype chain like inherit.
     *
     * @param {Function} destination Class to mix the object into.
     * @param {Object} source Object to mix into the class.
     */
    mixin: function mixin(destination, source) {
        return this.merge(destination.prototype, source);
    },

    /**
     * Merges one object into another, change the object in place.
     *
     * @param {Object} destination The destination for the merge.
     * @param {Object} source The source of the properties to merge.
     */
    merge: function merge(destination, source) {
        var key;

        for (key in source) {
            if (this.hasOwn(source, key)) {
                destination[key] = source[key];
            }
        }
    },

    /**
     * Shortcut for `Object.prototype.hasOwnProperty`.
     *
     * Uses `Object.prototype.hasOwnPropety` rather than
     * `object.hasOwnProperty` as it could be overwritten.
     *
     * @param {Object} object The object to check
     * @param {String} key The key to check for.
     * @return {Boolean} Does object have key as an own propety?
     */
    hasOwn: function hasOwn(object, key) {
        return Object.prototype.hasOwnProperty.call(object, key);
    }
}));
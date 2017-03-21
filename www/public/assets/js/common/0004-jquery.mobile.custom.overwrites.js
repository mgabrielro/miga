/**
 * Created by Daniele.Cinquantini on 16.12.14.
 */


$.widget( "mobile.textinput", $.mobile.textinput, {

    _wrap: function() {

        if (!this.element.parent().hasClass('ui-input-text')){
            return this._super();
        }

    }

});


$.widget( "mobile.page", $.mobile.page, {

    _enhance: function() {
        // do nothing
        return this._super();
    }

});
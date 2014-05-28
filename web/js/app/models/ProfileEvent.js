App.module("UserModule", function(UserModule, FamileasyApp, Backbone, Marionette, $, _){

    ProfileEvent = Backbone.Model.extend({
        urlRoot: function(){
            return Routing.generate('events_get_user_events', { userId: this.userId });
        },

        initialize: function(model, options) {
            this.userId = options.userId;
        }
    });

    ProfileEvents = Backbone.Collection.extend({
        model: ProfileEvent,

        initialize: function(collection, options) {
            this.userId = options.userId;
        },

        url: function(){
            return Routing.generate('events_get_user_events', { userId: this.userId });
        }
    });
});

App.module("UserModule", function(UserModule, FamileasyApp, Backbone, Marionette, $, _){

    Photo = Backbone.Model.extend({
        urlRoot: function(){
            return Routing.generate('photos_get_user_photos', { userId: this.userId });
        },

        initialize: function(model, options) {
            this.userId = options.userId;
        }
    });

    Photos = Backbone.Collection.extend({
        model: Photo,

        initialize: function(collection, options) {
            this.userId = options.userId;
        },

        url: function(){
            return Routing.generate('photos_get_user_photos', { userId: this.userId });
        }
    });
});

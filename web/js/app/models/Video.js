App.module("UserModule", function(UserModule, FamileasyApp, Backbone, Marionette, $, _){

    Video = Backbone.Model.extend({
        urlRoot: function(){
            return Routing.generate('videos_get_user_videos', { userId: this.userId });
        },

        initialize: function(model, options) {
            this.userId = options.userId;
        }
    });

    Videos = Backbone.Collection.extend({
        model: Video,

        initialize: function(collection, options) {
            this.userId = options.userId;
        },

        url: function(){
            return Routing.generate('videos_get_user_videos', { userId: this.userId });
        }
    });
});

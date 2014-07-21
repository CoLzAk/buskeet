App.module("MessageModule", function(MessageModule, FamileasyApp, Backbone, Marionette, $, _){

    Thread = Backbone.Model.extend({
        urlRoot: function(){
            return Routing.generate('messages_get_user_threads', { userId: this.userId });
        },

        initialize: function(model, options) {
            this.userId = options.userId;
        }
    });

    Threads = Backbone.Collection.extend({
        model: Message,

        initialize: function(collection, options) {
            this.userId = options.userId;
        },

        url: function(){
            return Routing.generate('messages_get_user_threads', { userId: this.userId });
        }
    });
});

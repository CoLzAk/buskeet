App.module("MessageModule", function(MessageModule, FamileasyApp, Backbone, Marionette, $, _){

    Message = Backbone.Model.extend({
        urlRoot: function(){
            return Routing.generate('messages_get_thread_messages', { threadId: this.threadId });
        },

        initialize: function(model, options) {
            this.threadId = options.threadId;
        }
    });

    Messages = Backbone.Collection.extend({
        model: Message,

        initialize: function(collection, options) {
            this.threadId = options.threadId;
        },

        url: function(){
            return Routing.generate('messages_get_thread_messages', { threadId: this.threadId });
        }
    });
});

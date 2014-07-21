App.module("UserModule", function(UserModule, App, Backbone, Marionette, $, _){
    Message = Backbone.Model.extend({
        initialize: function(model, options) {
            this.recipientId = options.recipientId;
        },
        url: function() {
            return Routing.generate('messages_post_messages', { recipientId: this.recipientId });
        }
    });
});
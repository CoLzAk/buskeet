App.module("UserModule", function(UserModule, App, Backbone, Marionette, $, _){

    ProfileMessageView = Backbone.Marionette.ItemView.extend({
        template: '#clzk-profile-message-template',

        initialize: function() {
            // console.log('init profile-message-template');
        }
    });
});
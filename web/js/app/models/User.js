App.module("UserModule", function(UserModule, App, Backbone, Marionette, $, _){

    User = Backbone.DeepModel.extend({
        // idAttribute: 'username',
        url: function() {
            return 'http://colzakfr.dev/app_dev.php/api/users/' + this.username + '/';
        },

        initialize: function(model, options) {
            this.username = options.username;
        }
    });
});
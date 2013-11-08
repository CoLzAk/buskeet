App.module("UserModule", function(UserModule, App, Backbone, Marionette, $, _){

    Portfolio = Backbone.DeepModel.extend({
        url: function() {
            return 'http://colzakfr.dev/app_dev.php/api/users/' + this.username + '/';
        },

        initialize: function(model, options) {
            this.username = options.username;
        }
    });

    Portfolios = Backbone.Collection.extend({
        model: Portfolio,
        urlRoot: 'http://colzakfr.dev/app_dev.php/api/users/' + this.username + '/portfolios'
    });
});
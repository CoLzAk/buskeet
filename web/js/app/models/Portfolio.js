App.module("UserModule", function(UserModule, App, Backbone, Marionette, $, _){

    Portfolio = Backbone.DeepModel.extend({
        urlRoot: function() {
            return 'http://colzakfr.dev/app_dev.php/api/users/' + this.username + '/portfolios';
        },

        initialize: function(model, options) {
            this.username = options.username;
        }
    });

    Portfolios = Backbone.Collection.extend({
        model: Portfolio,
        url: 'http://colzakfr.dev/app_dev.php/api/users/' + this.username + '/portfolios'
    });
});
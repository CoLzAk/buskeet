App.module("UserModule", function(UserModule, App, Backbone, Marionette, $, _){

    Portfolio = Backbone.DeepModel.extend({
        urlRoot: function() {
            return 'http://colzakfr.dev/app_dev.php/api/users/' + this.userId + '/portfolio';
        },

        initialize: function(model, options) {
            // console.log('dd m> ', model);
            // console.log('dd o> ', options);
            this.userId = options.userId;
        }
    });

    // Portfolios = Backbone.Collection.extend({
    //     model: Portfolio,
    //     url: 'http://colzakfr.dev/app_dev.php/api/users/' + this.username + '/portfolios'
    // });
});
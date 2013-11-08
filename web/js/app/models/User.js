App.module("UserModule", function(UserModule, App, Backbone, Marionette, $, _){

    User = Backbone.DeepModel.extend({
        // idAttribute: 'username',
        // url: function() {
        //     return 'http://colzakfr.dev/app_dev.php/api/users/' + this.username + '/';
        // },
        urlRoot: 'http://colzakfr.dev/app_dev.php/api/users',

        // initialize: function(model, options) {
        //     this.username = options.username;
        // }
    });

    // Users = Backbone.Collection.extend({
    //     model: User,
    //     url: 'http://colzakfr.dev/app_dev.php/api/users'
    //     // url: 'http://www.famileasy.dev/app_dev.php/api/users'
    // });
});
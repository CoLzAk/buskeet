App.module("UserModule", function(UserModule, App, Backbone, Marionette, $, _){
    User = Backbone.DeepModel.extend({
        urlRoot: function(){
            return Routing.generate('users_get_users');
        }
    });

    Users = Backbone.Collection.extend({
        model: User,
        url: Routing.generate('users_get_users')
    });
});
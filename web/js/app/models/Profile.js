App.module("UserModule", function(UserModule, App, Backbone, Marionette, $, _){
    Profile = Backbone.DeepModel.extend({
        urlRoot: function(){
            return Routing.generate('users_get_user_profile', { userId: this.userId });
        },
        initialize: function(model, options) {
            var memento = new Backbone.Memento(this);
            _.extend(this, memento);
            this.userId = options.userId;
        }
    });

    Profiles = Backbone.Collection.extend({
        model: Profile,
        url: Routing.generate('users_get_profiles')
    });
});
App.module("UserModule", function(UserModule, App, Backbone, Marionette, $, _){

    Portfolio = Backbone.DeepModel.extend({
        urlRoot: function(){
            return Routing.generate('portfolios_get_user_portfolio', { userId: this.userId });
        },

        initialize: function(model, options) {
            var memento = new Backbone.Memento(this);
            _.extend(this, memento);
            this.userId = options.userId;
        }
    });
});
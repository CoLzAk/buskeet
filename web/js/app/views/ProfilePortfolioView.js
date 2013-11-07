App.module("UserModule", function(UserModule, App, Backbone, Marionette, $, _){

    ProfilePortfolioView = Backbone.Marionette.ItemView.extend({
        template: '#clzk-profile-portfolio-template',
        bindings: {
            '#profile-portfolio-targets-description': 'targetsDescription'
        },
        onRender: function() {
            this.stickit();
        },
        initialize: function() {
            console.log('init profile-portfolio-template');
        }
    });
});
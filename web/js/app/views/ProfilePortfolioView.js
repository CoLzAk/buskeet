App.module("UserModule", function(UserModule, App, Backbone, Marionette, $, _){

	ProfilePortfolioView = Backbone.Marionette.ItemView.extend({
		template: '#clzk-profile-portfolio-template',

		initialize: function() {
			console.log('init profile-portfolio-template');
		}
	});
});
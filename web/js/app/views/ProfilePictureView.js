App.module("UserModule", function(UserModule, App, Backbone, Marionette, $, _){

	ProfilePictureView = Backbone.Marionette.ItemView.extend({
		template: '#clzk-profile-picture-template',

		initialize: function() {
			console.log('init profile-photo-template');
		}
	});
});
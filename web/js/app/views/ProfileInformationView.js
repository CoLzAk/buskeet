App.module("UserModule", function(UserModule, App, Backbone, Marionette, $, _){

	ProfileInformationView = Backbone.Marionette.ItemView.extend({
		template: '#clzk-profile-information-template',
		bindings: {
			'#profile-firstname': 'firstname',
			'#profile-lastname': 'lastname'
		},
		events: {
			'click .edit-btn': 'editInformation'
		},
		editInformation: function(e) {
			e.preventDefault();
			Backbone.history.navigate(this.model.username + '/edit', { trigger: true });
		},
		serializeData: function() {
			return {
				profile: this.model.toJSON()
			};
		},
		onRender: function() {
			this.stickit();
		},
		initialize: function() {
			// console.log(this.model.toJSON());
			console.log('init profile-information-template');
		}
	});


});
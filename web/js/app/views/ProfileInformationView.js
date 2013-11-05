App.module("UserModule", function(UserModule, App, Backbone, Marionette, $, _){

	ProfileInformationView = Backbone.Marionette.ItemView.extend({
		template: '#clzk-profile-information-template',
		bindings: {
			'#profile-firstname': 'firstname',
			'#profile-lastname': 'lastname',
			'#profile-description': 'description'
		},
		events: {
			'click .edit-btn': 'editInformation'
		},
		editInformation: function(e) {
			e.preventDefault();
			Backbone.history.navigate(this.model.username + '/edit/informations', { trigger: true });
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
			console.log('init profile-information-template');
		}
	});

	ProfileInformationFormView = Backbone.Marionette.ItemView.extend({
		template: '#clzk-profile-information-form-template',
		bindings: {
			'#profile-birthdate': 'birthdate',
			'#profile-description': 'description'
		},
		events: {
			'click .close-modal-btn': 'closeModal'
		},
		closeModal: function(e) {
			e.preventDefault();
			console.log(this.model);
			Backbone.history.navigate(this.username, { trigger: true });
			$('#clzk-modal').modal('hide');
		},
		onRender: function() {
			this.stickit();
		}
	});
});
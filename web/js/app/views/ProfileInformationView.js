App.module("UserModule", function(UserModule, App, Backbone, Marionette, $, _){

    ProfileInformationView = Backbone.Marionette.ItemView.extend({
        template: '#clzk-profile-information-template',
        bindings: {
            '#profile-firstname': 'profile.firstname',
            '#profile-lastname': 'profile.lastname',
            '#profile-description': 'profile.description'
        },
        events: {
            'click .edit-btn': 'edit'
        },
        edit: function(e) {
            e.preventDefault();
            Backbone.history.navigate(this.model.username + '/edit/information', { trigger: true });
        },
        onRender: function() {
            this.stickit();
        },
        initialize: function() {
            console.log(this.model);
            console.log('init profile-information-template');
        }
    });

    ProfileInformationFormView = Backbone.Marionette.ItemView.extend({
        template: '#clzk-profile-information-form-template',
        bindings: {
            '#profile-birthdate': 'birthdate',
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
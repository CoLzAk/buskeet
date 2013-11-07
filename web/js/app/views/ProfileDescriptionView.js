App.module("UserModule", function(UserModule, App, Backbone, Marionette, $, _){

    ProfileDescriptionView = Backbone.Marionette.ItemView.extend({
        template: '#clzk-profile-description-template',
        bindings: {
            '#profile-description': 'profile.description'
        },
        events: {
            'click .edit-btn': 'edit'
        },
        edit: function(e) {
            e.preventDefault();
            Backbone.history.navigate(this.model.username + '/edit/aboutme', { trigger: true });
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
            console.log('init profile description');
        }
    });

    ProfileDescriptionFormView = Backbone.Marionette.ItemView.extend({
        template: '#clzk-profile-description-form-template',
        bindings: {
            '#profile-description': 'profile.description'
        },
        events: {
            'click .close-modal-btn': 'closeModal',
            'click .save-modal-btn': 'save'
        },
        save: function(e) {
            e.preventDefault();
            this.model.save({}, {
                success: function(model, response) {
                    $('#clzk-modal').modal('hide');
                    Backbone.history.navigate(model.get('username'), { trigger: true });
                }
            });
        },
        closeModal: function(e) {
            e.preventDefault();
            Backbone.history.navigate(this.model.username, { trigger: false });
            $('#clzk-modal').modal('hide');
        },
        onRender: function() {
            this.stickit();
        }
    });
});
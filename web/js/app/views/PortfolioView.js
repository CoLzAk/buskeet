App.module("UserModule", function(UserModule, App, Backbone, Marionette, $, _){

    PortfolioView = Backbone.Marionette.ItemView.extend({
        template: '#clzk-profile-portfolio-template',
        bindings: {
            '#profile-portfolio-targets-description': 'targets_description'
        },
        events: {
            'click .edit-btn': 'edit'
        },
        edit: function(e) {
            e.preventDefault();
            Backbone.history.navigate(this.username + '/edit/portfolio', { trigger: true });
        },
        onRender: function() {
            this.stickit();
        },
        initialize: function(model, options) {
            this.username = options.username;
        }
    });

    PortfolioFormView = Backbone.Marionette.ItemView.extend({
        template: '#clzk-profile-portfolio-form-template',
        bindings: {
            '#profile-portfolio-targets-description': 'targets_description'
        },
        events: {
            'click .close-modal-btn': 'closeModal',
            'click .save-modal-btn': 'save'
        },
        save: function(e) {
            var that = this;
            e.preventDefault();
            this.model.save({}, {
                success: function(model, response) {
                    $('#clzk-modal').modal('hide');
                    Backbone.history.navigate(that.username, { trigger: true });
                }
            });
        },
        closeModal: function(e) {
            e.preventDefault();
            Backbone.history.navigate(this.username, { trigger: false });
            $('#clzk-modal').modal('hide');
        },
        onRender: function() {
            this.stickit();
        },
        initialize: function(model, options) {
            this.username = options.username;
        }
    });
});
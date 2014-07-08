App.module("UserModule", function(UserModule, App, Backbone, Marionette, $, _){

    ProfileMenuView = Backbone.Marionette.ItemView.extend({
        template: '#clzk-profile-menu-template',
        events: {
            'click .edit-button': 'showEditView',
        },
        showEditView: function(e) {
            var form = $(e.currentTarget).data('form');
            e.preventDefault();
            $('#clzk-profile-menu-actions-region .list-group-item').removeClass('active');

            if (form == 'profile') {
                Backbone.history.navigate(UserModule.targetUserUsername, { trigger: true });
            } else {
                $(e.currentTarget).addClass('active');
                Backbone.history.navigate(UserModule.targetUserUsername + '/edit/' + form, { trigger: true });
            }
        },
        serializeData: function() {
            return {
                owner: (UserModule.userId === UserModule.visitorId ? true : false),
                // full_name: this.model.get('firstname').toUpperCase() + ' ' + this.model.get('lastname').toUpperCase()
            }
        }
    });
});
App.module("UserModule", function(UserModule, App, Backbone, Marionette, $, _){

    ProfileDescriptionView = Backbone.Marionette.ItemView.extend({
        template: '#clzk-profile-description-template',
        tagName: 'div',
        bindings: {
            '#clzk-profile-description': {
                observe: 'description',
                onGet: function(value) {
                    return value || 'Rien à déclarer !';
                }
            }
        },
        onRender: function() {
            this.stickit();
        },
        serializeData: function() {
            return {
                profile: this.model.toJSON()
            };
        }
    });
});
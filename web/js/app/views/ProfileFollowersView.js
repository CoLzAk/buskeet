App.module("UserModule", function(UserModule, App, Backbone, Marionette, $, _){

    ProfileFollowersView = Backbone.Marionette.ItemView.extend({
        template: '#clzk-profile-followers-template',
        tagName: 'div',
        onRender: function() {
            this.stickit();
        },
        serializeData: function() {
            return {
            	owner: (UserModule.userId === UserModule.visitorId ? true : false),
                followers: this.model.get('followers')
            };
        }
    });
});
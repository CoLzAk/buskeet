App.module('UserModule', function(UserModule, App, Backbone, Marionette, $, _){
	this.startWithParent = false;

	ProfileLayout = Backbone.Marionette.Layout.extend({
        template: '#clzk-profile-layout',
        regions: {
            profilePictureRegion: '#clzk-profile-picture-region',
            profileMessageRegion: '#clzk-profile-message-region',
            profileInformationRegion: '#clzk-profile-information-region',
            profilePortfolioRegion: '#clzk-profile-portfolio-region'
        }
    });

	UserModule.show = function(username) {
        UserModule.targetUser.fetch({
            success: function(result) {
                UserModule.profileLayout.profilePictureRegion.show(new ProfilePictureView());
                UserModule.profileLayout.profileMessageRegion.show(new ProfileMessageView());
                UserModule.profileLayout.profileInformationRegion.show(new ProfileInformationView({ model: result }));
                UserModule.profileLayout.profilePortfolioRegion.show(new ProfilePortfolioView());
            }
        });
	}

    UserModule.edit = function(username) {
        console.log(username);
    }

	UserModule.addInitializer(function(options){
        UserModule.targetUser = new User({}, { username: options.username });

        //Initialize layout
        UserModule.profileLayout = new ProfileLayout();
        App.profileRegion.show(UserModule.profileLayout);
    });

});
App.module('UserModule', function(UserModule, App, Backbone, Marionette, $, _){
    this.startWithParent = false;

    ProfileLayout = Backbone.Marionette.Layout.extend({
        template: '#clzk-profile-layout',
        regions: {
            profilePictureRegion: '#clzk-profile-picture-region',
            profileMessageRegion: '#clzk-profile-message-region',
            profileInformationRegion: '#clzk-profile-information-region',
            profileDescriptionRegion: '#clzk-profile-description-region',
            profilePortfolioRegion: '#clzk-profile-portfolio-region'
        }
    });

    ModalLayout = Backbone.Marionette.Layout.extend({
        template: "#clzk-modal-layout",
        regions: {
            modalContentRegion: "#clzk-modal-content-region"
        }
    });

    UserModule.show = function(username) {
        UserModule.targetUser.fetch({
            success: function(result) {
                UserModule.profileLayout.profilePictureRegion.show(new ProfilePictureView());
                UserModule.profileLayout.profileMessageRegion.show(new ProfileMessageView());
                UserModule.profileLayout.profileInformationRegion.show(new ProfileInformationView({ model: result }));
                UserModule.profileLayout.profileDescriptionRegion.show(new ProfileDescriptionView({ model: result }));
                UserModule.profileLayout.profilePortfolioRegion.show(new ProfilePortfolioView());
            }
        });
    };

    UserModule.edit = function(username, formName) {
        UserModule.modalLayout = new ModalLayout();
        App.modalRegion.show(UserModule.modalLayout);
        if (formName == 'information') {
            UserModule.modalLayout.modalContentRegion.show(new ProfileInformationFormView({ model: UserModule.targetUser }));
        }
        if (formName == 'aboutme') {
            UserModule.modalLayout.modalContentRegion.show(new ProfileDescriptionFormView({ model: UserModule.targetUser }));
        }
        $('#clzk-modal').modal('show');
        console.log(UserModule.targetUser);
    };

    UserModule.addInitializer(function(options){
        UserModule.targetUser = new User({}, { username: options.username });

        //Initialize layout
        UserModule.profileLayout = new ProfileLayout();
        App.profileRegion.show(UserModule.profileLayout);
    });

});
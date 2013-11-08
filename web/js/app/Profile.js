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
        console.log('az > ', UserModule.targetUserPortfolio);
        UserModule.profileLayout.profilePictureRegion.show(new ProfilePictureView());
        UserModule.profileLayout.profileMessageRegion.show(new ProfileMessageView());
        UserModule.profileLayout.profileInformationRegion.show(new ProfileInformationView({ model: UserModule.targetUser }));
        UserModule.profileLayout.profileDescriptionRegion.show(new ProfileDescriptionView({ model: UserModule.targetUser }));
        UserModule.profileLayout.profilePortfolioRegion.show(new PortfolioView({ model: UserModule.targetUserPortfolio }, { username: UserModule.targetUser.get('username') }));
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
        if (formName == 'portfolio') {
            UserModule.modalLayout.modalContentRegion.show(new PortfolioFormView({ model: UserModule.targetUserPortfolio }, { username: username }));
        }
        $('#clzk-modal').modal('show');
    };

    UserModule.addInitializer(function(options){
        UserModule.targetUser = new User(options.targetUser);
        UserModule.targetUserPortfolio = new Portfolio(options.targetUser.profile.portfolio, { userId: UserModule.targetUser.get('id') });

        //Initialize layout
        UserModule.profileLayout = new ProfileLayout();
        App.profileRegion.show(UserModule.profileLayout);
    });

});
App.module('UserModule', function(UserModule, App, Backbone, Marionette, $, _){
    this.startWithParent = false;

    ProfileLayout = Backbone.Marionette.Layout.extend({
        template: '#clzk-profile-layout',
        regions: {
            profilePhotosRegion: '#clzk-profile-photos-region',
            profileInformationsRegion: '#clzk-profile-informations-region',
            profilePortfolioRegion: '#clzk-profile-portfolio-region',
            profileEventsRegion: '#clzk-profile-events-region'
        }
    });

    ProfileMenuLayout = Backbone.Marionette.Layout.extend({
        template: '#clzk-profile-menu-layout',
        regions: {
            actionsRegion: '#clzk-profile-menu-actions-region'
        }
    });

    ProfileEditLayout = Backbone.Marionette.Layout.extend({
        template: '#clzk-profile-edit-layout',
        regions: {
            profileEditRegion: '#clzk-profile-edit-region'
        }
    });

    ModalLayout = Backbone.Marionette.Layout.extend({
        template: "#clzk-modal-layout",
        regions: {
            modalContentRegion: "#clzk-modal-content-region"
        },
        onDomRefresh: function() {
            $('#clzk-modal').on('hidden.bs.modal', function(e) {
                // $('#clzk-modal').modal('hide');
                Backbone.history.navigate(UserModule.targetUserUsername, { trigger: false });
            });
        }
    });

    UserModule.show = function(username) {
        App.formRegion.close();
        App.mainRegion.show(UserModule.profileLayout);
        if (typeof UserModule.targetUserProfile === 'undefined') {
            UserModule.targetUserUsername = username;

            var profile = new Profile({}, { userId: UserModule.userId });
            profile.fetch({
                success: function(model) {
                    UserModule.displayViews(model);
                }
            });
        } else {
            UserModule.displayViews(UserModule.targetUserProfile, UserModule.targetUserPhotos);
        }
    };

    UserModule.displayViews = function(data) {
        UserModule.targetUserProfile = data;
        UserModule.targetUserPhotos = new Photos(data.get('photos'), { userId: UserModule.userId });
        UserModule.targetUserProfilePortfolio = new Portfolio(data.get('portfolio'), { userId: UserModule.userId });
        UserModule.targetUserEvents = new ProfileEvents(data.get('events'), { userId: UserModule.userId });
        UserModule.targetUserProfile.store();
        UserModule.targetUserProfilePortfolio.store();
        // if (UserModule.firstRender) {
        //     UserModule.profileMenuLayout.actionsRegion.attachView(new ProfileMenuView({ model: profile, el: $('#clzk-profile-menu-static') }));
        //     UserModule.profileLayout.profilePhotosRegion.attachView(new ProfilePhotosView({ collection: photos, el: $('#clzk-profile-photos-static') }));
        //     UserModule.profileLayout.profileInformationsRegion.attachView(new ProfileInformationsView({ model: profile, el: $('#clzk-profile-informations-static') }));

        //     App.menuRegion.attachView(UserModule.profileMenuLayout);
        //     App.mainRegion.attachView(UserModule.profileLayout);

        //     $('#clzk-profile-menu-loading').addClass('hidden');
        //     $('#clzk-profile-menu-static').removeClass('hidden');
        // } else {
        UserModule.profileMenuLayout.actionsRegion.show(new ProfileMenuView({ model: UserModule.targetUserProfile }));
        UserModule.profileLayout.profilePhotosRegion.show(new ProfilePhotosView({ collection: UserModule.targetUserPhotos }));
        UserModule.profileLayout.profileInformationsRegion.show(new ProfileInformationsView({ model: UserModule.targetUserProfile }));
        UserModule.profileLayout.profilePortfolioRegion.show(new ProfilePortfolioView({ model: UserModule.targetUserProfile }));
        UserModule.profileLayout.profileEventsRegion.show(new ProfileEventsView({ collection: UserModule.targetUserEvents }));
            // App.menuRegion.show(UserModule.profileMenuLayout);
            // App.mainRegion.show(UserModule.profileLayout);
            // $('#clzk-profile-menu-loading').addClass('hidden');
            // $('#clzk-profile-menu-static').removeClass('hidden');
        // }
        NProgress.done();
    };

    UserModule.edit = function(username, formName) {
        App.mainRegion.close();
        App.formRegion.close();
        UserModule.profileEditLayout = new ProfileEditLayout();
        App.formRegion.show(UserModule.profileEditLayout);
        if (formName == 'informations') {
            UserModule.profileEditLayout.profileEditRegion.show(new ProfileInformationsFormView({ model: UserModule.targetUserProfile }));
        }
        if (formName == 'photos') {
            UserModule.profileEditLayout.profileEditRegion.show(new ProfilePhotosFormView({ collection: UserModule.targetUserPhotos }));
        }
        if (formName == 'portfolio') {
            UserModule.profileEditLayout.profileEditRegion.show(new ProfilePortfolioFormView({ model: UserModule.targetUserProfile }));
        }
        if (formName == 'events') {
            UserModule.profileEditLayout.profileEditRegion.show(new ProfileEventsFormView({ collection: UserModule.targetUserEvents }));
        }
    };

    UserModule.closeFormView = function() {
        App.formRegion.close();
        NProgress.done();
    };

    UserModule.gallery = function(username) {
        UserModule.modalLayout = new ModalLayout();
        App.modalRegion.show(UserModule.modalLayout);
        UserModule.modalLayout.modalContentRegion.show(new ProfilePhotosCarouselView({ collection: UserModule.targetUserPhotos }));

        $('#clzk-modal').modal('show');
    };

    UserModule.contact = function() {
        UserModule.modalLayout = new ModalLayout();
        App.modalRegion.show(UserModule.modalLayout);
        UserModule.modalLayout.modalContentRegion.show(new ContactView({ model: UserModule.targetUserProfile }));

        $('#clzk-modal').modal('show');
    };

    UserModule.addInitializer(function(options){
        UserModule.firstRender = true;
        UserModule.userId = options.userId;
        UserModule.visitorId = options.visitorId;
        UserModule.visitor = new Profile(options.visitor.profile, { userId: options.visitor.id });
        console.log(UserModule.visitor);
        UserModule.visitorUsername = options.visitor.username;
        //Initialize layout
        UserModule.profileLayout = new ProfileLayout();
        UserModule.profileMenuLayout = new ProfileMenuLayout();
        UserModule.profileEditLayout = new ProfileEditLayout();
        App.menuRegion.show(UserModule.profileMenuLayout);
    });

});
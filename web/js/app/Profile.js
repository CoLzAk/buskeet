App.module('UserModule', function(UserModule, App, Backbone, Marionette, $, _){
    this.startWithParent = false;

    ProfileLayout = Backbone.Marionette.Layout.extend({
        template: '#clzk-profile-layout',
        regions: {
            profileMapRegion: '#clzk-profile-map-region',
            profilePhotosRegion: '#clzk-profile-photos-region',
            profileInformationsRegion: '#clzk-profile-informations-region',
            profileDescriptionRegion: '#clzk-profile-description-region',

            profilePortfolioRegion: '#clzk-profile-portfolio-region',
            profileEventsRegion: '#clzk-profile-events-region',

            profileFollowersRegion: '#clzk-profile-followers-region'
        },
        onDomRefresh: function() {
            $('#edit-button').on('click', function() {
                Backbone.history.navigate(UserModule.targetUserUsername + '/edit/informations', { trigger: true });
            });
            $('#edit-button-sm').on('click', function() {
                Backbone.history.navigate(UserModule.targetUserUsername + '/edit/informations', { trigger: true });
            });
            $('#change-cover-photo-button').on('click', function() {
                Backbone.history.navigate(UserModule.targetUserUsername + '/edit/photos', { trigger: true });
            });
            $('#follow-button').on('click', function() {
                var that = this;
                // e.preventDefault();
                if (UserModule.visitorId === null || UserModule.visitorId == '') {
                    window.location.replace(Routing.generate('fos_user_security_login'));
                    return;
                }
                NProgress.start();
                $.ajax({
                    url: (typeof UserModule.isFollowing() === 'undefined' ? Routing.generate('users_follow_user', { profileId: UserModule.targetUserProfile.get('id') }) : Routing.generate('users_unfollow_user', { profileId: UserModule.targetUserProfile.get('id') })),
                    type: (typeof UserModule.isFollowing() === 'undefined' ? 'POST' : 'DELETE'),
                    dataType: 'json',
                    success: function(data) {
                        (UserModule.isFollowing() ? UserModule.visitor.get('following').splice(UserModule.visitor.get('following').indexOf(UserModule.isFollowing()), 1) : UserModule.visitor.get('following').push(data));
                        window.location.reload();
                        NProgress.done();
                    },
                    error: function(data) {
                        NProgress.done();
                    }
                });
            });
            $('#message-button').on('click', function() {
                if (UserModule.visitorId === null || UserModule.visitorId == '') {
                    window.location.replace(Routing.generate('fos_user_security_login'));
                    return;
                }
                Backbone.history.navigate(UserModule.targetUserUsername + '/contact', { trigger: true });
                });
        }
    });

    ProfileEditLayout = Backbone.Marionette.Layout.extend({
        template: '#clzk-profile-edit-layout',
        regions: {
            actionsRegion: '#clzk-profile-edit-actions-region',
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
        UserModule.profileLayout = new ProfileLayout();
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

        UserModule.profileLayout.profileMapRegion.show(new ProfileMapView({ model: UserModule.targetUserProfile }));
        UserModule.profileLayout.profilePhotosRegion.show(new ProfilePhotosView({ collection: UserModule.targetUserPhotos }));
        UserModule.profileLayout.profileInformationsRegion.show(new ProfileInformationsView({ model: UserModule.targetUserProfile }));
        UserModule.profileLayout.profileDescriptionRegion.show(new ProfileDescriptionView({ model: UserModule.targetUserProfile }));

        UserModule.profileLayout.profilePortfolioRegion.show(new ProfilePortfolioView({ model: UserModule.targetUserProfile }));
        UserModule.profileLayout.profileEventsRegion.show(new ProfileEventsView({ collection: UserModule.targetUserEvents }));

        UserModule.profileLayout.profileFollowersRegion.show(new ProfileFollowersView({ model: UserModule.targetUserProfile }));
        NProgress.done();
    };

    UserModule.edit = function(username, formName) {
        App.mainRegion.close();
        App.formRegion.close();
        UserModule.profileEditLayout = new ProfileEditLayout();
        App.formRegion.show(UserModule.profileEditLayout);

        UserModule.profileEditLayout.actionsRegion.show(new ProfileMenuView({ model: UserModule.targetUserProfile }));
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

    UserModule.isFollowing = function() {
        if (UserModule.visitorId === null || UserModule.visitorId == '') {
            return;
        } else {
            return _.findWhere(UserModule.visitor.get('following'), { username: UserModule.targetUserUsername });
        }
    }

    UserModule.addInitializer(function(options){
        UserModule.firstRender = true;
        UserModule.userId = options.userId;
        UserModule.visitorId = options.visitorId;

        if (options.visitor !== null) {
            UserModule.visitor = new Profile(options.visitor.profile, { userId: options.visitor.id });
            UserModule.visitorUsername = options.visitor.username;
        }
        //Initialize layout
        // UserModule.profileLayout = new ProfileLayout();
        // UserModule.profileMenuLayout = new ProfileMenuLayout();
        // UserModule.profileEditLayout = new ProfileEditLayout();
        // App.menuRegion.show(UserModule.profileMenuLayout);
    });

});
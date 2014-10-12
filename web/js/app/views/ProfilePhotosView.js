App.module("UserModule", function(UserModule, App, Backbone, Marionette, $, _){
    
    ProfilePhotosView = Backbone.Marionette.ItemView.extend({
        template: '#clzk-profile-photos-template',
        tagName: 'div',
        events: {
            'click #image-modal': 'initCarousel'
        },
        initCarousel: function(e) {
            e.preventDefault();
            Backbone.history.navigate(UserModule.targetUserUsername + "/gallery", { trigger: true });
        },
        serializeData: function() {
            // var photos = this.collection.toJSON(), profilePicture = _.findWhere(photos, {is_profile_picture: true});
            // if (typeof profilePicture === 'undefined') {
            //     profilePicture = (this.collection.length > 0 ? photos[0] : undefined);
            // }
            return {
                profile_gender: UserModule.targetUserProfile.get('gender'),
                profile_picture: UserModule.targetUserProfile.get('profile_photo')
            };
        },
        onDomRefresh: function() {
            // var coverPhoto = this.collection.findWhere({ default_cover_photo: true });
            if (typeof UserModule.targetUserProfile.get('cover_photo') !== 'undefined') {
                $('.clzk-profile-cover-container').css('background-image', 'url(' + UserModule.targetUserProfile.get('cover_photo').path + ')');
            }
        },
        initialize: function() {
            this.listenTo(this.collection, 'change', this.refresh);
        },
        refresh: function() {
            this.render();
        }
    });

    ProfilePhotosCarouselView = Backbone.Marionette.ItemView.extend({
        template: '#clzk-profile-photos-carousel-template',
        events: {
            'click .close-carousel-btn': 'closeCarousel'
        },
        closeCarousel: function(e) {
            e.preventDefault();
            $('#clzk-modal').modal('hide');
            Backbone.history.navigate(UserModule.targetUserUsername, { trigger: false });
        },
        serializeData: function() {
            var photos = this.collection.toJSON(), activePhoto = UserModule.targetUserProfile.get('profile_photo');
            if (typeof activePhoto === 'undefined') {
                activePhoto = photos[0];
            }
            return {
                active_photo: activePhoto,
                photos: this.collection.toJSON()
            };
        }
    });

    // Edit views
    ProfilePhotoFormView = Backbone.Marionette.ItemView.extend({
        template: '#clzk-profile-photo-form-template',
        tagName: 'div',
        className: 'col-sm-6 col-md-4 col-xs-12',

        events: {
            'click .profile-picture-button': 'setAsProfilePicture',
            'click .profile-cover-picture-button': 'setAsProfileCoverPicture',
            'click .delete-picture-button': 'deletePicture'
        },

        setAsProfilePicture: function(e) {
            NProgress.start();
            e.preventDefault();
            var that = this;
            // this.model.set('is_profile_picture', true);
            // this.model.save({}, {
            //     success: function(response, data) {
            //         $('.profile-picture-button').removeClass('disabled');
            //         UserModule.targetUserProfile.set('photos', data);
            //         $('.message-sign').removeClass().addClass('message-sign glyphicon glyphicon-ok-sign');
            //         $('.message-text').html('Les modifications ont été enregistrées !')
            //         $('.clzk-flash-messages-container').removeClass().addClass('clzk-flash-messages-container alert alert-success');
            //         $('.clzk-flash-messages-container').fadeIn( 400 ).delay( 3000 ).fadeOut( 400 );
            //         NProgress.done();
            //     },
            //     error: function(response) {
            //         $('.message-sign').removeClass().addClass('message-sign glyphicon glyphicon-remove-sign');
            //         $('.message-text').html('Une erreur est survenue. Veuillez réessayer ultérieurement ou contacter le support')
            //         $('.clzk-flash-messages-container').removeClass().addClass('clzk-flash-messages-container alert alert-danger');
            //         $('.clzk-flash-messages-container').fadeIn( 400 ).delay( 3000 ).fadeOut( 400 );
            //         NProgress.done();
            //     }
            // });

            UserModule.targetUserProfile.set('profile_photo', this.model.toJSON());
            UserModule.targetUserProfile.save({}, {
                success: function(response, data) {
                    $('.profile-picture-button').removeClass('disabled');
                    // UserModule.targetUserProfile.set('photos', data);
                    $('.message-sign').removeClass().addClass('message-sign glyphicon glyphicon-ok-sign');
                    $('.message-text').html('Les modifications ont été enregistrées !')
                    $('.clzk-flash-messages-container').removeClass().addClass('clzk-flash-messages-container alert alert-success');
                    $('.clzk-flash-messages-container').fadeIn( 400 ).delay( 3000 ).fadeOut( 400 );
                    NProgress.done();
                },
                error: function(response) {
                    $('.message-sign').removeClass().addClass('message-sign glyphicon glyphicon-remove-sign');
                    $('.message-text').html('Une erreur est survenue. Veuillez réessayer ultérieurement ou contacter le support')
                    $('.clzk-flash-messages-container').removeClass().addClass('clzk-flash-messages-container alert alert-danger');
                    $('.clzk-flash-messages-container').fadeIn( 400 ).delay( 3000 ).fadeOut( 400 );
                    NProgress.done();
                }
            });
        },
        setAsProfileCoverPicture: function(e) {
            NProgress.start();
            e.preventDefault();
            var that = this;
            this.model.set('cover_photo', true);
            // this.model.set('default_cover_photo', true);
            // this.model.save({}, {
            //     success: function(response, data) {
            //         $('.profile-cover-picture-button').removeClass('disabled');
            //         UserModule.targetUserProfile.set('photos', data);
            //         $('.message-sign').removeClass().addClass('message-sign glyphicon glyphicon-ok-sign');
            //         $('.message-text').html('Les modifications ont été enregistrées !')
            //         $('.clzk-flash-messages-container').removeClass().addClass('clzk-flash-messages-container alert alert-success');
            //         $('.clzk-flash-messages-container').fadeIn( 400 ).delay( 3000 ).fadeOut( 400 );
            //         NProgress.done();
            //     },
            //     error: function(response) {
            //         $('.message-sign').removeClass().addClass('message-sign glyphicon glyphicon-remove-sign');
            //         $('.message-text').html('Une erreur est survenue. Veuillez réessayer ultérieurement ou contacter le support')
            //         $('.clzk-flash-messages-container').removeClass().addClass('clzk-flash-messages-container alert alert-danger');
            //         $('.clzk-flash-messages-container').fadeIn( 400 ).delay( 3000 ).fadeOut( 400 );
            //         NProgress.done();
            //     }
            // });
            UserModule.targetUserProfile.set('cover_photo', this.model.toJSON());
            UserModule.targetUserProfile.save({}, {
                success: function(response, data) {
                    $('.profile-picture-button').removeClass('disabled');
                    // UserModule.targetUserProfile.set('photos', data);
                    $('.message-sign').removeClass().addClass('message-sign glyphicon glyphicon-ok-sign');
                    $('.message-text').html('Les modifications ont été enregistrées !')
                    $('.clzk-flash-messages-container').removeClass().addClass('clzk-flash-messages-container alert alert-success');
                    $('.clzk-flash-messages-container').fadeIn( 400 ).delay( 3000 ).fadeOut( 400 );
                    NProgress.done();
                },
                error: function(response) {
                    $('.message-sign').removeClass().addClass('message-sign glyphicon glyphicon-remove-sign');
                    $('.message-text').html('Une erreur est survenue. Veuillez réessayer ultérieurement ou contacter le support')
                    $('.clzk-flash-messages-container').removeClass().addClass('clzk-flash-messages-container alert alert-danger');
                    $('.clzk-flash-messages-container').fadeIn( 400 ).delay( 3000 ).fadeOut( 400 );
                    NProgress.done();
                }
            });
        },
        deletePicture: function(e) {
            NProgress.start();
            e.preventDefault();
            var profile = UserModule.targetUserProfile.toJSON();
            var photo = this.model;
            this.model.destroy({
                success: function(response, data) {
                    UserModule.targetUserProfile.set('photos', data);
                    $('.message-sign').removeClass().addClass('message-sign glyphicon glyphicon-ok-sign');
                    $('.message-text').html('Les modifications ont été enregistrées !')
                    $('.clzk-flash-messages-container').removeClass().addClass('clzk-flash-messages-container alert alert-success');
                    $('.clzk-flash-messages-container').fadeIn( 400 ).delay( 3000 ).fadeOut( 400 );
                    NProgress.done();
                },
                error: function(response) {
                    $('.message-sign').removeClass().addClass('message-sign glyphicon glyphicon-remove-sign');
                    $('.message-text').html('Une erreur est survenue. Veuillez réessayer ultérieurement ou contacter le support')
                    $('.clzk-flash-messages-container').removeClass().addClass('clzk-flash-messages-container alert alert-danger');
                    $('.clzk-flash-messages-container').fadeIn( 400 ).delay( 3000 ).fadeOut( 400 );
                    NProgress.done();
                }
            });
            this.render();
        },
        serializeData: function() {
            return {
                photo: this.model.toJSON(),
                profile_photo: UserModule.targetUserProfile.get('profile_photo'),
                cover_photo: UserModule.targetUserProfile.get('cover_photo')
            };
        },
        initialize: function(options) {
            this.collectionView = options.collectionView;
        }
    });


    ProfilePhotosFormView = Backbone.Marionette.CompositeView.extend({
        template: '#clzk-profile-photos-form-template',
        tagName: 'div',
        itemView: ProfilePhotoFormView,
        events: {
            'click .add-photos-button': 'addPhotos',
            'click .cancel-button': 'cancel'
        },
        cancel: function(e) {
            e.preventDefault();
            UserModule.closeFormView();
            Backbone.history.navigate(UserModule.targetUserUsername, { trigger: true });
        },
        addPhotos: function(e) {
            e.preventDefault();
            $('#fileUpload').click();
        },
        itemViewContainer: function() {
            return '#profile-photos-form-container';
        },
        previewImage: function(file) {
            $('#photos-previews').html('');
            var oFReader = new FileReader(), htmlPreviews = '';
            oFReader.readAsDataURL(file);
            oFReader.onload = function (oFREvent) {
                htmlPreviews += '<div class="col-md-2">';
                htmlPreviews += '<img src="' + oFREvent.target.result + '" class="img-responsive">';
                htmlPreviews += '</div>';
                $('#photos-previews').append(htmlPreviews);
            };
            $('.photos-previews-separator').removeClass('hidden');
            $('.upload-photos-button').removeClass('disabled');
        },
        onDomRefresh: function() {
            var photos = this.collection.toJSON(),
                that = this;

            $('#fileUpload').fileupload({
                dataType: 'json',
                autoUpload: true,
                url: that.collection.url(),
                add: function(e, data) {
                    // that.previewImage(data.files[0]);
                    // $('.upload-photos-button').on('click', function(e) {
                        $('#loading-photo-container').removeClass('hidden');
                        data.submit();
                    // });
                },
                done: function(e, data) {
                    var photo = new Photo({
                        id: data.result.id,
                        // is_profile_picture: data.result.is_profile_picture,
                        name: data.result.name,
                        path: data.result.path,
                        thumb_path: data.result.thumb_path
                    }, { userId: UserModule.userId });
                    that.collection.add(photo);
                    UserModule.targetUserProfile.get('photos').push(photo);
                    return that.render();
                }
            });
        },
        serializeData: function() {
            return {
                photos: this.collection.toJSON()
            };
        },
        itemViewOptions: function(model, index) {
            return {
                itemIndex: index,
                collectionView: this
            };
        },
        initialize: function() {
            this.listenTo(this.collection, 'change', this.refresh);
        },
        refresh: function() {
            this.render();
        }
    });
});
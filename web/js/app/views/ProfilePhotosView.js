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
            var photos = this.collection.toJSON(), profilePicture = _.findWhere(photos, {is_profile_picture: true});
            if (typeof profilePicture === 'undefined') {
                profilePicture = (this.collection.length > 0 ? photos[0] : undefined);
            }
            return {
                profile_picture: profilePicture
            };
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
            var photos = this.collection.toJSON(), activePhoto = _.findWhere(photos, {is_profile_picture: true});
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
        className: 'col-sm-4 col-md-3 col-xs-6',

        events: {
            'click .profile-picture-button': 'setAsProfilePicture',
            'click .delete-picture-button': 'deletePicture'
        },

        setAsProfilePicture: function(e) {
            NProgress.start();
            e.preventDefault();
            var that = this;
            this.model.set('is_profile_picture', true);
            this.model.save({}, {
                success: function(response, data) {
                    $('.profile-picture-button').removeClass('disabled');
                    UserModule.targetUserProfile.set('photos', data);
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
                    NProgress.done();
                }
            });
            this.render();
        },
        serializeData: function() {
            return {
                photo: this.model.toJSON()
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
                        data.submit();
                    // });
                },
                done: function(e, data) {
                    var photo = new Photo({
                        id: data.result.id,
                        is_profile_picture: data.result.is_profile_picture,
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
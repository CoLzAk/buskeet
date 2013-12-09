App.module("UserModule", function(UserModule, App, Backbone, Marionette, $, _){

    ProfilePictureView = Backbone.Marionette.ItemView.extend({
        template: '#clzk-profile-picture-template',
        tagName: 'div',
        events: {
            'click #gallery': 'initCarousel'
        },
        initCarousel: function(e) {
            e.preventDefault();
            Backbone.history.navigate(this.options.username + "/gallery", { trigger: true });
        },
        serializeData: function() {
            return {
                picture: this.options.model.toJSON(),
                itemIndex: this.options.itemIndex
            };
        },
        initialize: function() {
            // this.listenTo(this.model, 'change', this.refresh);
        },
        refresh: function() {
            this.render();
        }
    });

    ProfilePictureEmptyView = Backbone.Marionette.ItemView.extend({
        template: '#clzk-profile-picture-empty-template'
    });


    ProfilePicturesView = Backbone.Marionette.CompositeView.extend({
        template: '#clzk-profile-pictures-template',
        itemView: ProfilePictureView,
        tagName: 'div',
        emptyView: ProfilePictureEmptyView,
        events: {
            'click .edit-btn': 'showPhotosForm'
        },
        itemViewContainer: function() {
            return '#clzk-profile-pictures-container';
        },
        showPhotosForm: function(e) {
            e.preventDefault();
            Backbone.history.navigate(this.username + "/edit/photos", { trigger: true });
        },
        serializeData: function() {
            return {
                pictures: this.collection.toJSON()
            };
        },
        itemViewOptions: function(model, index) {
            return {
                itemIndex: index,
                collectionView: this,
                username: this.username
            };
        },
        initialize: function(collection, options) {
            this.username = options.username;
            // this.listenTo(this.collection, 'change', this.refresh);
        },
        refresh: function() {
            this.render();
        }
    });

    ProfilePicturesCarouselView = Backbone.Marionette.ItemView.extend({
        template: '#clzk-profile-pictures-carousel-template',
        events: {
            'click .close-carousel-btn': 'closeCarousel'
        },
        closeCarousel: function(e) {
            e.preventDefault();
            Backbone.history.navigate(this.collection.username, true);
        },
        serializeData: function() {
            return {
                pictures: this.collection.toJSON()
            };
        }
    });

    ProfilePictureFormView = Backbone.Marionette.ItemView.extend({
        template: '#clzk-profile-picture-form-template',
        tagName: 'div',

        events: {
            'click .profile-picture-button': 'setAsProfilePicture',
            'click .delete-picture-button': 'deletePicture'
        },
        

        setAsProfilePicture: function(e) {
            e.preventDefault();
            var that = this;
            this.model.set('profile_picture', true);
            this.model.save();
        },

        deletePicture: function(e) {
            e.preventDefault();
            this.model.destroy();
            this.render();
            this.options.collectionView.render();
        },
        serializeData: function() {
            return {
                picture: this.options.model.toJSON(),
                itemIndex: this.options.itemIndex
            };
        }
    });

    ProfilePictureFormEmptyView = Backbone.Marionette.ItemView.extend({
        template: '#clzk-profile-picture-form-empty-template'
    });

    ProfilePicturesFormView = Backbone.Marionette.CompositeView.extend({
        template: '#clzk-profile-pictures-form-template',
        tagName: 'div',
        itemView: ProfilePictureFormView,
        //emptyView: ProfilePictureFormEmptyView,

        events: {
            'click .save-modal-btn': 'closeModal',
            'click .close-modal-btn': 'closeModal'
        },
        closeModal: function(e) {
            e.preventDefault();
            Backbone.history.navigate(this.username, true);
            $('#cn-profile-modal').modal('hide');
        },
        itemViewContainer: function() {
            return '#clzk-profile-pictures-form-container';
        },
        onDomRefresh: function() {
            var pictures = this.collection,
                that = this;
            $('#fileUpload').fileupload({
                dataType: 'json',
                url: pictures.url(),
                done: this.done,
                autoUpload: false,
                dropZone: $('.drop-zone')
            });

            //files added
            $('#fileUpload').bind('fileuploadadd', function (e, data) {
                var goUpload = true;
                var uploadFile = data.files[0];
                if (!(/\.(jpg|jpeg|png)$/i).test(uploadFile.name)) {
                    console.log('You must select an image file only');
                    $('.flash-message').html('You must select an image file only');
                    goUpload = false;
                }
                if (uploadFile.size > 2000000) { // 2mb
                    console.log('Please upload a smaller image, max size is 2 MB');
                    $('.flash-message').html('Please upload a smaller image, max size is 2 MB');
                    goUpload = false;
                }
                if (goUpload === true) {
                    data.submit();
                }
            });

            //upload started
            $('#fileUpload').bind('fileuploadstart', function (e) { console.log('start'); });

            //upload done (success)
            $('#fileUpload').bind('fileuploaddone', function (e, data) {
                var picture = new File({
                    id: data.result.id,
                    name: data.result.name,
                    path: data.result.path,
                    profile_picture: data.result.profile_picture,
                    thumb_path: data.result.thumb_path,
                    file_type: data.result.file_type
                }, { userId: pictures.userId });
                pictures.push(picture.toJSON());
                return that.render();
            });

            $('#fileUpload').bind('progressall', function (e, data) {
                console.log('fail');
            });

            //upload fail
            $('#fileUpload').bind('fileuploadfail', function (e, data) {
                console.log('fail');
            });

            //uploading
            $('#fileUpload').bind('fileuploadalways', function (e, data) {
                console.log('always');
            });
            //EndFileUpload

            $(this.el).parent().trigger('create');
        },
        serializeData: function() {
            return {
                pictures: this.collection.toJSON()
            };
        },
        itemViewOptions: function(model, index) {
            return {
                itemIndex: index,
                collectionView: this
            };
        },
        initialize: function(collection, options) {
            this.username = options.username;
            console.log(collection);
        },
    });
});
App.module("UserModule", function(UserModule, App, Backbone, Marionette, $, _){

    ProfileVideoView = Backbone.Marionette.ItemView.extend({
        template: '#clzk-profile-video-template',
        tagName: 'div',
        // className: 'col-md-6',
        serializeData: function() {
            return {
                itemIndex: this.itemIndex
            };
        },
        onDomRefresh: function() {
            var playerWidth = ($('.video-container').width() > 600 ? 600 : $('.video-container').width()),
                playerHeight = Math.ceil(playerWidth / 1.78);


            $('#embedded-object-' + this.itemIndex).html(this.model.get('embedded_code'));
            $('#embedded-object-' + this.itemIndex + ' iframe').width(playerWidth).height(playerHeight);
        },
        initialize: function(options) {
            this.collectionView = options.collectionView;
            this.itemIndex = options.itemIndex;
        }
    });

    ProfileVideosView = Backbone.Marionette.CompositeView.extend({
        template: '#clzk-profile-videos-template',
        itemView: ProfileVideoView,
        itemViewContainer: function() {
            return '#profile-videos-container';
        },
        itemViewOptions: function(model, index) {
            return {
                itemIndex: index,
                collectionView: this
            };
        },
        serializeData: function() {
            return {
                videos: this.collection.toJSON()
            };
        }
    });

    ProfileVideoFormView = Backbone.Marionette.ItemView.extend({
        template: '#clzk-profile-video-form-template',
        tagName: 'div',
        events: {
            'click .delete-video': 'deleteVideo'
        },
        deleteVideo: function(e) {
            e.preventDefault();
            var that = this;
            NProgress.start();
            this.model.destroy({
                success: function(response, data) {
                    $('.message-sign').removeClass().addClass('message-sign glyphicon glyphicon-ok-sign');
                    $('.message-text').html('Les modifications ont été enregistrées !')
                    $('.clzk-flash-messages-container').removeClass().addClass('clzk-flash-messages-container alert alert-success');
                    $('.clzk-flash-messages-container').fadeIn( 400 ).delay( 3000 ).fadeOut( 400 );
                    UserModule.targetUserProfile.get('videos').splice(that.itemIndex, 1);
                    that.render();
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
        serializeData: function() {
            return {
                itemIndex: this.itemIndex
            };
        },
        onDomRefresh: function() {
            var playerWidth = ($('.video-container').width() > 600 ? 600 : $('.video-container').width()),
                playerHeight = Math.ceil(playerWidth / 1.78);


            $('#embedded-object-' + this.itemIndex).html(this.model.get('embedded_code'));
            $('#embedded-object-' + this.itemIndex + ' iframe').width(playerWidth).height(playerHeight);
        },
        initialize: function(options) {
            this.collectionView = options.collectionView;
            this.itemIndex = options.itemIndex;
        }
    });

    ProfileVideosFormView = Backbone.Marionette.CompositeView.extend({
        template: '#clzk-profile-videos-form-template',
        itemView: ProfileVideoFormView,
        tagName: 'div',
        events: {
            'click .add-video-button': 'addVideo'
        },
        addVideo: function() {
            var url = $('#clzk-profile-video-url').val(),
                video = new Video({ url: url }, { userId: UserModule.userId }),
                that = this;
                // videos = this.collection.toJSON();

            NProgress.start();
            video.save({}, {
                success: function(response, data) {
                    video = new Video(data, { userId: UserModule.userId });
                    that.collection.add(video);
                    UserModule.targetUserProfile.get('videos').push(video);
                    $('.message-sign').removeClass().addClass('message-sign glyphicon glyphicon-ok-sign');
                    $('.message-text').html('Les modifications ont été enregistrées !')
                    $('.clzk-flash-messages-container').removeClass().addClass('clzk-flash-messages-container alert alert-success');
                    $('.clzk-flash-messages-container').fadeIn( 400 ).delay( 3000 ).fadeOut( 400 );
                    that.render();
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
        itemViewContainer: function() {
            return '#profile-videos-form-container';
        },
        itemViewOptions: function(model, index) {
            return {
                itemIndex: index,
                collectionView: this
            };
        }
    });
});
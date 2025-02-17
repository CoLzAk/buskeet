App.module("FeedsModule", function(FeedsModule, App, Backbone, Marionette, $, _){

    FeedView = Backbone.Marionette.ItemView.extend({
        template: '#clzk-feed-template',
        tagName: 'div',
        events: {
            'click .image-modal': 'initCarousel'
        },
        initCarousel: function(e) {
            e.preventDefault();
            Backbone.history.navigate('/photo/'+this.model.get('id'), { trigger: true });
        },
        serializeData: function() {
            var context, movement = this.model.toJSON();
            if (typeof movement.movement_detail.photo !== 'undefined') {
                context = 'PHOTO';
            }
            if (typeof movement.movement_detail.video !== 'undefined') {
                context = 'VIDEO';
            }
            if (typeof movement.movement_detail.event !== 'undefined') {
                context = 'EVENT';
                var completeAddress = '';
                if (movement.movement_detail.event.street_number !== '') completeAddress += movement.movement_detail.event.street_number + ' ';
                if (movement.movement_detail.event.route !== '') completeAddress += movement.movement_detail.event.route + ', ';
                if (movement.movement_detail.event.sublocality !== '') completeAddress += movement.movement_detail.event.sublocality + ', ';
                if (movement.movement_detail.event.locality !== '') completeAddress += movement.movement_detail.event.locality + ', ';
                if (movement.movement_detail.event.country !== '') completeAddress += movement.movement_detail.event.country;
            }
            // console.log(completeAddress);
            if (typeof movement.movement_detail.profile !== 'undefined') {
                var followingProfilePhoto = movement.movement_detail.profile.profile_photo;
                context = 'PROFILE';
                
            }
            // var posterProfilePhoto = _.findWhere(movement.profile.photos, { is_profile_picture: true });
            var posterProfilePhoto = movement.profile.profile_photo;
            return {
                poster_profile_photo: posterProfilePhoto,
                following_profile_photo: followingProfilePhoto,
                completeAddress: completeAddress,
                context: context,
                feed: this.model.toJSON()
            }
        },
        onDomRefresh: function() {
            var context, movement = this.model.toJSON();
            if (typeof movement.movement_detail.video !== 'undefined') {
                var playerWidth = ($('.video-container').width() > 600 ? 600 : $('.video-container').width()),
                playerHeight = Math.ceil(playerWidth / 1.78);


                $('#embedded-object-' + movement.movement_detail.video.id).html(movement.movement_detail.video.embedded_code);
                $('#embedded-object-' + movement.movement_detail.video.id + ' iframe').width(playerWidth).height(playerHeight);
            }
        }
    });

    EmptyFeedView = Backbone.Marionette.ItemView.extend({
        template: '#clzk-empty-feed-template'
    });

    FeedsView = Backbone.Marionette.CompositeView.extend({
        template: '#clzk-feeds-template',
        itemView: FeedView,
        emptyView: EmptyFeedView,
        tagName: 'div',
        itemViewContainer: function() {
            return '#clzk-feed-container';
        },
        onDomRefresh: function() {
            var that = this;

            if (!FeedsModule.end) {
                $('.clzk-scrolling-content').smack({ threshold: 0.8 }).done(function() {
                    //Show ajax_loader.gif
                    $('.loader-indicator').removeClass('hidden');
                    FeedsModule.feedStream.set('current_page_number', parseInt(FeedsModule.feedStream.get('current_page_number'), 10) + 1);
                    // that.model.queryUrl.searchParams.page = that.model.get('current_page_number');
                    // for (var param in that.model.queryUrl.searchParams) {
                    //     if (i === 0) nextPageUrl += '?';
                    //     nextPageUrl += param + '=' + that.model.queryUrl.searchParams[param] + '&';
                    //     i++;
                    // }
                    // if (nextPageUrl.slice(-1) == '&') nextPageUrl = nextPageUrl.substring(0, nextPageUrl.length - 1);

                    $.ajax({
                        url: Routing.generate(FeedsModule.feedStream.get('route')),
                        dataType: 'json',
                        data: {
                            page: FeedsModule.feedStream.get('current_page_number')
                        },
                        success: function(data) {
                            if (data.items.length > 0) {
                                for (var it in data.items) {
                                    FeedsModule.feeds.push(data.items[it]);
                                }
                                //Hide ajax_loader.gif
                                $('.loader-indicator').addClass('hidden');
                            } else {
                                $('.loader-indicator').html('<p>Fin de liste</p>');
                                FeedsModule.end = true;
                            }
                            that.render();
                        },
                        error: function(data) {

                        }
                    });
                });
            }
        }
    });

    FeedsPhotoCarouselView = Backbone.Marionette.ItemView.extend({
        template: '#clzk-feeds-photo-carousel-template',
        serializeData: function() {
            return {
                photo: this.model.get('movement_detail').photo
            };
        }
    });

    FeedsProfilesView = Backbone.Marionette.ItemView.extend({
        template: '#clzk-feeds-profiles-template',
        serializeData: function() {
            return {
                user: FeedsModule.user.toJSON(),
                profiles: this.model.get('items')
            };
        }
    });

    FeedsEventsView = Backbone.Marionette.ItemView.extend({
        template: '#clzk-feeds-events-template',
        serializeData: function() {
            return {
                events: this.model.get('items')
            };
        }
    });
});
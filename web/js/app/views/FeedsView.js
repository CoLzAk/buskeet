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
                var followingProfilePhoto = _.findWhere(movement.movement_detail.profile.photos, { is_profile_picture: true });
                context = 'PROFILE';
                
            }
            var posterProfilePhoto = _.findWhere(movement.profile.photos, { is_profile_picture: true });
            return {
                poster_profile_photo: posterProfilePhoto,
                following_profile_photo: followingProfilePhoto,
                completeAddress: completeAddress,
                context: context,
                feed: this.model.toJSON()
            }
        }
    });

    FeedsView = Backbone.Marionette.CompositeView.extend({
        template: '#clzk-feeds-template',
        itemView: FeedView,
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
            }
        }
    });
});
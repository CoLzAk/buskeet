App.module('FeedsModule', function(FeedsModule, App, Backbone, Marionette, $, _, UserModule){
    this.startWithParent = false;

    FeedsLayout = Backbone.Marionette.Layout.extend({
        template: '#clzk-feeds-layout',
        regions: {
            feedsRegion: '#clzk-feeds-stream-region',
            feedsMenuRegion: '#clzk-feeds-menu-region',
            feedsSuggestedProfilesRegion: '#clzk-feeds-suggested-profiles-region',
            feedsSuggestedEventsRegion: '#clzk-feeds-suggested-events-region'
        }
    });

    ModalLayout = Backbone.Marionette.Layout.extend({
        template: "#clzk-modal-layout",
        regions: {
            modalContentRegion: "#clzk-modal-content-region"
        },
        onDomRefresh: function() {
            $('#clzk-modal').on('hidden.bs.modal', function(e) {
                Backbone.history.navigate('', { trigger: false });
            });
        }
    });

    FeedsModule.show = function() {
        NProgress.start();
        
        FeedsModule.end = false;
        FeedsModule.feedStream = new FeedStream();
        FeedsModule.feedStream.fetch({
        	success: function(results) {
                FeedsModule.feeds = new Feeds(results.get('items'));
                FeedsModule.feedsLayout.feedsMenuRegion.show(new FeedsMenuView({ model: FeedsModule.user }));
                FeedsModule.feedsLayout.feedsRegion.show(new FeedsView({ collection: FeedsModule.feeds }));

                if (typeof FeedsModule.user.get('coordinates') !== 'undefined') {
                    //fetch suggestions
                    var suggestedProfiles = new FeedsProfiles();
                    var suggestedEvents = new FeedsEvents();

                    suggestedProfiles.fetch({
                        success: function(profiles) {
                            FeedsModule.feedsLayout.feedsSuggestedProfilesRegion.show(new FeedsProfilesView({ model: profiles }));
                        }
                    });

                    suggestedEvents.fetch({
                        success: function(events) {
                            FeedsModule.feedsLayout.feedsSuggestedEventsRegion.show(new FeedsEventsView({ model: events }));
                        }
                    });
                }

                NProgress.done();
        	}
        });
    };

    FeedsModule.showPhoto = function(feedId) {
        var feed = FeedsModule.feeds.get(feedId);
        FeedsModule.modalLayout = new ModalLayout();
        App.modalRegion.show(FeedsModule.modalLayout);
        FeedsModule.modalLayout.modalContentRegion.show(new FeedsPhotoCarouselView({ model: feed }));

        $('#clzk-modal').modal('show');
    }

    FeedsModule.addInitializer(function(options){
        FeedsModule.user = new Profile(options.user.profile, { userId: options.user.id });

        //Initialize layout
        FeedsModule.feedsLayout = new FeedsLayout();
        App.mainRegion.show(FeedsModule.feedsLayout);
    });

});
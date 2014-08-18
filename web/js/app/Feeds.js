App.module('FeedsModule', function(FeedsModule, App, Backbone, Marionette, $, _){
    this.startWithParent = false;

    FeedsLayout = Backbone.Marionette.Layout.extend({
        template: '#clzk-feeds-layout',
        regions: {
            feedsRegion: '#clzk-feeds-stream-region'
        }
    });

    FeedsMenuLayout = Backbone.Marionette.Layout.extend({
        template: '#clzk-feeds-menu-layout',
        regions: {
            feedsMenuRegion: '#clzk-feeds-menu-region'
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
                // FeedsModule.feedsMenuLayout.feedsMenuRegion.show();
                FeedsModule.feedsLayout.feedsRegion.show(new FeedsView({ collection: FeedsModule.feeds }));
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
        FeedsModule.user = options.user;

        //Initialize layout
        FeedsModule.feedsLayout = new FeedsLayout();
        FeedsModule.feedsMenuLayout = new FeedsMenuLayout();
        App.menuRegion.show(FeedsModule.feedsMenuLayout);
        App.mainRegion.show(FeedsModule.feedsLayout);
    });

});
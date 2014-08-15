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

    FeedsModule.show = function() {
        NProgress.start();
        console.log('bonjour');
        
        var feeds = new Feeds();
        feeds.fetch({
        	success: function(results) {
                // FeedsModule.feedsMenuLayout.feedsMenuRegion.show(new ThreadsView({ collection: MessageModule.userThreads }));
                FeedsModule.feedsLayout.feedsRegion.show(new FeedsView({ collection: results }));
                NProgress.done();
        	}
        });
    // 	var threads = new Threads({}, { userId: MessageModule.userId });
    // 	threads.fetch({
    // 		success: function(collection) {
    // 			MessageModule.userThreads = collection;
    // 			var thread = collection.get(threadId);
				// MessageModule.messages = new Messages(thread.get('messages'), { threadId: threadId });
    // 			MessageModule.messageMenuLayout.messageMenuRegion.show(new ThreadsView({ collection: MessageModule.userThreads }));
    // 			MessageModule.messageLayout.messagesRegion.show(new MessagesView({ collection: MessageModule.messages }));
    // 		    NProgress.done();
    //         }
    // 	});
    };

    FeedsModule.addInitializer(function(options){
        FeedsModule.user = options.user;

        //Initialize layout
        FeedsModule.feedsLayout = new FeedsLayout();
        FeedsModule.feedsMenuLayout = new FeedsMenuLayout();
        App.menuRegion.show(FeedsModule.feedsMenuLayout);
        App.mainRegion.show(FeedsModule.feedsLayout);
    });

});
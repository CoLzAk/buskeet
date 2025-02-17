App.module('MessageModule', function(MessageModule, App, Backbone, Marionette, $, _){
    this.startWithParent = false;

    MessageLayout = Backbone.Marionette.Layout.extend({
        template: '#clzk-message-layout',
        regions: {
            messageMenuRegion: '#clzk-message-menu-region',
            messagesRegion: '#clzk-message-thread-region'
        }
    });

    ModalLayout = Backbone.Marionette.Layout.extend({
        template: "#clzk-modal-layout",
        regions: {
            modalContentRegion: "#clzk-modal-content-region"
        },
        onDomRefresh: function() {
            $('#clzk-modal').on('hidden.bs.modal', function(e) {
                Backbone.history.navigate(MessageModule.threadId, { trigger: false });
            });
        }
    });

    MessageModule.showThread = function(threadId) {
        NProgress.start();
    	var threads = new Threads({}, { userId: MessageModule.userId });
    	threads.fetch({
    		success: function(collection) {
    			MessageModule.userThreads = collection;
    			var thread = collection.get(threadId);
				MessageModule.messages = new Messages(thread.get('messages'), { threadId: threadId });
    			MessageModule.messageLayout.messageMenuRegion.show(new ThreadsView({ collection: MessageModule.userThreads }));
    			MessageModule.messageLayout.messagesRegion.show(new MessagesView({ collection: MessageModule.messages }));
    		    NProgress.done();
            }
    	});
    };

    MessageModule.addInitializer(function(options){
        MessageModule.userId = options.userId;
        MessageModule.user = options.user;
        MessageModule.threadId = options.threadId;

        //Initialize layout
        MessageModule.messageLayout = new MessageLayout();
        // MessageModule.messageMenuLayout = new MessageMenuLayout();
        // App.menuRegion.show(MessageModule.messageMenuLayout);
        App.mainRegion.show(MessageModule.messageLayout);
    });

});
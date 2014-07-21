App.module("MessageModule", function(MessageModule, App, Backbone, Marionette, $, _){

    ThreadView = Backbone.Marionette.ItemView.extend({
        template: '#clzk-thread-template',
        tagName: 'div',
        serializeData: function() {
        	return {
        		thread: this.model.toJSON(),
        		recipient: this.recipient
        	};
        },
        initialize: function() {
        	var participants = this.model.get('participants'), recipient;

        	for (var i in participants) {
        		if (participants.id !== MessageModule.user.profile.id) {
        			this.recipient = participants[i];
        		}
        	}
        }
    });

    ThreadEmptyView = Backbone.Marionette.ItemView.extend({
        template: '#clzk-thread-empty-template'
    });

    ThreadsView = Backbone.Marionette.CompositeView.extend({
        template: '#clzk-threads-template',
        itemView: ThreadView,
        emptyView: ThreadEmptyView,
        itemViewContainer: '#clzk-thread-container',
        initialize: function() {
        	// console.log(this.collection);
        }
    });
});
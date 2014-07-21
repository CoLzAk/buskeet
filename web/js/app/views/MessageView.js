App.module("MessageModule", function(MessageModule, App, Backbone, Marionette, $, _){

    MessageView = Backbone.Marionette.ItemView.extend({
        template: '#clzk-message-template',
        tagName: 'div',
        serializeData: function() {
        	return {
        		currentUser: MessageModule.user.profile,
        		recipient: this.recipient,
        		message: this.model.toJSON()
        	};
        },
        initialize: function(options) {
        	this.recipient = options.recipient;
        }
    });

    MessageEmptyView = Backbone.Marionette.ItemView.extend({
        template: '#clzk-message-empty-template'
    });

    MessagesView = Backbone.Marionette.CompositeView.extend({
        template: '#clzk-messages-template',
        itemView: MessageView,
        emptyView: MessageEmptyView,
        itemViewContainer: '#clzk-message-container',
        itemViewOptions: function(model, index) {
        	return {
                itemIndex: index,
                recipient: this.recipient
            };
        },
        serializeData: function() {
        	return {
        		recipient: this.recipient,
        		messages: this.collection.toJSON()
        	};
        },
        initialize: function() {
        	var messages = this.collection.toJSON();
        	this.recipient = messages[0].recipient;

        	if (messages[0].recipient.id === MessageModule.user.profile.id) {
        		this.recipient = messages[0].sender
        	}
        }
    });
});
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
        events: {
        	'click #send-message-button': 'sendMessage'
        },
        sendMessage: function(e) {
            e.preventDefault();
            NProgress.start();
            var messageContent = $('#message-content').val();
            var message = new Message({ message: messageContent, recipientId: this.recipient.id }, { threadId: this.collection.threadId });
            var that = this;

            message.save({}, {
                success: function(response, model) {
                    $('#message-content').val('');
                    $('.message-sign').removeClass().addClass('message-sign glyphicon glyphicon-ok-sign');
                    $('.message-text').html('Votre message a bien été envoyé !')
                    $('.clzk-flash-messages-container').removeClass().addClass('clzk-flash-messages-container alert alert-success');
                    $('.clzk-flash-messages-container').fadeIn( 400 ).delay( 3000 ).fadeOut( 400 );
                    that.collection.add(model);
                    $('#clzk-modal').modal('hide');
                    NProgress.done();
                },
                error: function(response) {
                    $('.message-sign').removeClass().addClass('message-sign glyphicon glyphicon-remove-sign');
                    $('.message-text').html('Une erreur est survenue. Veuillez réesayer ultérieurement ou contacter le support')
                    $('.clzk-flash-messages-container').removeClass().addClass('clzk-flash-messages-container alert alert-danger');
                    $('.clzk-flash-messages-container').fadeIn( 400 ).delay( 3000 ).fadeOut( 400 );
                    NProgress.done();
                }
            });
        },
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
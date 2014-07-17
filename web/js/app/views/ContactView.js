App.module("UserModule", function(UserModule, App, Backbone, Marionette, $, _){

    ContactView = Backbone.Marionette.ItemView.extend({
        template: '#clzk-contact-template',
        events: {
        	'click #send-message-button': 'sendMessage'
        },
        sendMessage: function(e) {
        	e.preventDefault();
        	var message = new Message({ message: $('#message-content').val() }, { recipientId: this.model.get('id') });
        	message.save({}, {
        		success: function(response, model) {
        			console.log(model);
        		},
        		error: function(response, model) {
        			console.log(response);
        		}
        	});
        },
        serializeData: function() {
            return {
                profile: this.model.toJSON()
            }
        }
    });
});
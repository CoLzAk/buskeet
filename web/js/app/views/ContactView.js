App.module("UserModule", function(UserModule, App, Backbone, Marionette, $, _){

    ContactView = Backbone.Marionette.ItemView.extend({
        template: '#clzk-contact-template',
        events: {
        	'click #send-message-button': 'sendMessage'
        },
        sendMessage: function(e) {
        	e.preventDefault();
            NProgress.start();
        	var message = new Message({ message: $('#message-content').val() }, { recipientId: this.model.get('id') });
        	message.save({}, {
        		success: function(response, model) {
                    $('#message-content').val('');
                    $('.message-sign').removeClass().addClass('message-sign glyphicon glyphicon-ok-sign');
                    $('.message-text').html('Votre message a bien été envoyé !')
                    $('.clzk-flash-messages-container').removeClass().addClass('clzk-flash-messages-container alert alert-success');
                    $('.clzk-flash-messages-container').fadeIn( 400 ).delay( 3000 ).fadeOut( 400 );
                    $('#clzk-modal').modal('hide');
                    NProgress.done();
        		},
        		error: function(response, model) {
        			$('.message-sign').removeClass().addClass('message-sign glyphicon glyphicon-remove-sign');
                    $('.message-text').html('Une erreur est survenue. Veuillez réesayer ultérieurement ou contacter le support')
                    $('.clzk-flash-messages-container').removeClass().addClass('clzk-flash-messages-container alert alert-danger');
                    $('.clzk-flash-messages-container').fadeIn( 400 ).delay( 3000 ).fadeOut( 400 );
                    NProgress.done();
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
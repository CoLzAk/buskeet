App.module("UserModule", function(UserModule, App, Backbone, Marionette, $, _){

    PortfolioView = Backbone.Marionette.ItemView.extend({
        template: '#clzk-profile-portfolio-template',
        bindings: {
            '#profile-portfolio-targets-description': 'targets_description'
        },
        events: {
            'click .edit-btn': 'edit'
        },
        edit: function(e) {
            e.preventDefault();
            Backbone.history.navigate(this.username + '/edit/portfolio', { trigger: true });
        },
        onRender: function() {
            this.stickit();
        },
        initialize: function(model, options) {
            this.username = options.username;
        }
    });

    PortfolioFormView = Backbone.Marionette.ItemView.extend({
        template: '#clzk-profile-portfolio-form-template',
        bindings: {
            '#profile-portfolio-targets-description': 'targets_description'
        },
        events: {
            'click .close-modal-btn': 'closeModal',
            'click .save-modal-btn': 'save',
            'keyup #profile-portfolio-targets': 'getInstrumentsList'
        },
        save: function(e) {
            var that = this;
            e.preventDefault();
            this.model.save({}, {
                success: function(model, response) {
                    $('#clzk-modal').modal('hide');
                    Backbone.history.navigate(that.username, { trigger: true });
                }
            });
        },
        closeModal: function(e) {
            e.preventDefault();
            Backbone.history.navigate(this.username, { trigger: false });
            $('#clzk-modal').modal('hide');
        },
        getInstrumentsList: function(e) {
            var instruments;
            e.preventDefault();
            if ($(e.currentTarget).val().length >= 3) {
                //Call ajax function to get the instruments list
                // instruments = new Instruments({}, {slug: $(e.currentTarget).val()});
                // instruments.fetch({
                //     success: function(results) {
                //         console.log(results);
                //     }
                // })
                $.ajax({
                    type: 'GET', // Le type de ma requete
                    url: 'http://colzakfr.dev/app_dev.php/api/portfolio/instruments/' + $(e.currentTarget).val(),
                    success: function(data, textStatus, jqXHR) {
                        // var result = $.parseJSON(data);
                        console.log(data);
                        for (var i=0, j=data.length; i<j; i++) {
                            $('#profile-portfolio-targets-results').append('<li class="list-group-item">Cras justo odio</li>');
                        }
                        $('#profile-portfolio-targets-results').show();
                        // La reponse du serveur est contenu dans data
                        // On peut faire ce qu'on veut avec ici
                        // console.log(data);
                    },
                    error: function(jqXHR, textStatus, errorThrown) {
                        // Une erreur s'est produite lors de la requete
                        console.log(data);
                    }
                });
                //Show results in a box
                //on results item click, add to list
                // console.log($(e.currentTarget).val());
            }
        },
        onRender: function() {
            this.stickit();
        },
        initialize: function(model, options) {
            this.username = options.username;
        }
    });
});
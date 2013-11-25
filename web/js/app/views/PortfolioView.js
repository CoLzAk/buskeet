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
            Backbone.history.navigate(this.username + '/edit/portfolio-' + e.currentTarget.getAttribute('data-edit'), { trigger: true });
        },
        onRender: function() {
            this.stickit();
        },
        initialize: function(model, options) {
            this.username = options.username;
        },
        serializeData: function() {
            return {
                portfolio: this.model.toJSON()
            };
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
            'keyup #profile-portfolio-targets': 'getInstrumentsList',
            'keyup #profile-portfolio-instruments': 'getInstrumentsList',
            'click .list-group-item': 'selectInstrument'
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
                if (e.keyCode >= 65 && e.keyCode <= 90) {
                    $.ajax({
                        type: 'GET', // Le type de ma requete
                        url: 'http://colzakfr.dev/app_dev.php/api/portfolio/instruments/' + $(e.currentTarget).val(),
                        success: function(data, textStatus, jqXHR) {
                            var html = '';
                            for (var i in data) {
                                html += '<li class="list-group-item" data-id="' + data[i].id + '" data-name="' + data[i].name + '" data-instrumenttypeid="' + data[i].instrumentType.id + '" data-instrumenttypecategory="' + data[i].instrumentType.category + '">'+ data[i].name +'</li>';
                            }
                            $('#profile-portfolio-targets-results').html(html);
                            $('#profile-portfolio-targets-results').show();
                        },
                        error: function(jqXHR, textStatus, errorThrown) {
                            console.log(data);
                        }
                    });
                }
            }
        },
        selectInstrument: function(e) {
            $('#profile-portfolio-targets-results').hide();
            $('#profile-portfolio-targets').val('');

            this.targets.push({
                id: e.currentTarget.getAttribute('data-id'),
                name: e.currentTarget.getAttribute('data-name'),
                instrument_type: {
                    id: e.currentTarget.getAttribute('data-instrumenttypeid'),
                    category: e.currentTarget.getAttribute('data-instrumenttypecategory')
                }
            });
            this.model.set('targets', this.targets);
            $('#profile-portfolio-targets-list').append('<li>'+ e.currentTarget.getAttribute('data-name') +'</li>');
        },
        onRender: function() {
            this.stickit();
        },
        initialize: function(model, options) {
            console.log(options);
            console.log('portfolio > ',this.model);
            console.log('portfolio-targets > ',this.model.get('targets'));
            console.log('portfolio-instruments > ',this.model.get('instruments'));
            this.username = options.username;
            this.edit = options.edit;
            this.targets = this.model.get('targets') || [];
            this.instruments = this.model.get('instruments') || [];
            // this.objectives = [];
        },
        serializeData: function() {
            return {
                edit: this.edit
            };
        }
    });
});
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
            'keyup #profile-portfolio-targets': 'getTargetsList',
            'keyup #profile-portfolio-instruments': 'getInstrumentsList',
            'click .list-group-item-instruments': 'selectInstrument',
            'click .list-group-item-targets': 'selectTarget',
            'click #add-objective-btn': 'addObjective'
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
            var instruments, that = this;
            e.preventDefault();
            if ($(e.currentTarget).val().length >= 3) {
                //Call ajax function to get the instruments list
                if (e.keyCode >= 65 && e.keyCode <= 90) {
                    $.ajax({
                        type: 'GET',
                        url: 'http://colzakfr.dev/app_dev.php/api/portfolio/instruments/' + $(e.currentTarget).val(),
                        success: function(data, textStatus, jqXHR) {
                            var html = '';
                            for (var i in data) {
                                html += '<li class="list-group-item list-group-item-instruments" data-id="' + data[i].id + '" data-name="' + data[i].name + '" data-adjective="' + data[i].adjective + '" data-instrumenttypeid="' + data[i].instrumentType.id + '" data-instrumenttypecategory="' + data[i].instrumentType.category + '">'+ data[i].name +'</li>';
                            }
                            $('#profile-portfolio-instruments-results').html(html);
                            $('#profile-portfolio-instruments-results').show();
                        },
                        error: function(jqXHR, textStatus, errorThrown) {
                            console.log(data);
                        }
                    });
                }
            }
        },
        getTargetsList: function(e) {
            var instruments, that = this;
            e.preventDefault();
            if ($(e.currentTarget).val().length >= 3) {
                //Call ajax function to get the targets list
                if (e.keyCode >= 65 && e.keyCode <= 90) {
                    $.ajax({
                        type: 'GET', // Le type de ma requete
                        url: 'http://colzakfr.dev/app_dev.php/api/portfolio/instruments/' + $(e.currentTarget).val(),
                        data: {
                            adjective: true
                        },
                        success: function(data, textStatus, jqXHR) {
                            var html = '';
                            for (var i in data) {
                                html += '<li class="list-group-item list-group-item-targets" data-id="' + data[i].id + '" data-name="' + data[i].name + '" data-adjective="' + data[i].adjective + '" data-instrumenttypeid="' + data[i].instrumentType.id + '" data-instrumenttypecategory="' + data[i].instrumentType.category + '">'+ data[i].adjective +'</li>';
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
            $('#profile-portfolio-instruments-results').hide();
            $('#profile-portfolio-instruments').val('');
            this.instruments.push({
                id: e.currentTarget.getAttribute('data-id'),
                name: e.currentTarget.getAttribute('data-name'),
                adjective: e.currentTarget.getAttribute('data-adjective'),
                instrument_type: {
                    id: e.currentTarget.getAttribute('data-instrumenttypeid'),
                    category: e.currentTarget.getAttribute('data-instrumenttypecategory')
                }
            });
            this.model.set('instruments', this.instruments);
            $('#profile-portfolio-instruments-list').append('<li>'+ e.currentTarget.getAttribute('data-name') +'</li>');
        },
        selectTarget: function(e) {
            $('#profile-portfolio-targets-results').hide();
            $('#profile-portfolio-targets').val('');
            this.targets.push({
                id: e.currentTarget.getAttribute('data-id'),
                name: e.currentTarget.getAttribute('data-name'),
                adjective: e.currentTarget.getAttribute('data-adjective'),
                instrument_type: {
                    id: e.currentTarget.getAttribute('data-instrumenttypeid'),
                    category: e.currentTarget.getAttribute('data-instrumenttypecategory')
                }
            });
            this.model.set('targets', this.targets);
            $('#profile-portfolio-targets-list').append('<li>'+ e.currentTarget.getAttribute('data-name') +'</li>');
        },
        addObjective: function(e) {
            e.preventDefault();
            var html = '', objective = {
                title: $('#profile-portfolio-objective-title').val(),
                content: $('#profile-portfolio-objective-description').val(),
                start_date: moment($('#profile-portfolio-objective-startDate').val(), "DD/MM/YYYY").format("YYYY-MM-DD\\THH:mm:ssZZ"),
                end_date: moment($('#profile-portfolio-objective-endDate').val(), "DD/MM/YYYY").format("YYYY-MM-DD\\THH:mm:ssZZ")
            };

            html += '<div class="col-md-4">';
            // write in the result div
            if (typeof objective.start_date !== 'undefined' &&
                objective.start_date.length > 0 &&
                typeof objective.end_date !== 'undefined' &&
                objective.end_date.length > 0) {
                    
                    html += '<span>Du '+ objective.start_date +' au '+ objective.end_date +'</span>';
            }
            html += '</div>';
            html += '<div class="col-md-8"><p>'+ objective.title +'</p><p>'+ objective.content +'</p></div>';

            //Verify informations

            //Push in the object
            $('#profile-portfolio-objectives-result').append(html);
            this.objectives.push(objective);
        },
        onDomRefresh: function() {
            $('.datepicker').datepicker({
                dateFormat: 'dd/mm/yy'
            });
        },
        onRender: function() {
            this.stickit();
        },
        initialize: function(model, options) {
            this.username = options.username;
            this.edit = options.edit;
            this.targets = this.model.get('targets') || [];
            this.instruments = this.model.get('instruments') || [];
            this.objectives = this.model.get('objectives') || [];
        },
        serializeData: function() {
            return {
                edit: this.edit
            };
        }
    });
});
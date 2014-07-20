App.module("UserModule", function(UserModule, App, Backbone, Marionette, $, _){

    ProfilePortfolioView = Backbone.Marionette.ItemView.extend({
        template: '#clzk-profile-portfolio-template',
        onRender: function() {
            this.stickit();
        },
        serializeData: function() {
            return {
                profile: this.model.toJSON()
            };
        }
    });

    ProfilePortfolioFormView = Backbone.Marionette.ItemView.extend({
        template: '#clzk-profile-portfolio-form-template',
        events: {
            'click .add-portfolio-item-button': 'addPortfolioItem',
            'click .delete-portfolio-item-button': 'deletePortfolioItem',
            // 'click .save-button': 'save',
            'click .cancel-button': 'cancel'
        },
        save: function() {
            var that = this;
            NProgress.start();
            this.model.save({}, {
                success: function(model, response) {
                    that.render();
                    $('.message-sign').removeClass().addClass('message-sign glyphicon glyphicon-ok-sign');
                    $('.message-text').html('Les modifications ont étés enregistrées !')
                    $('.clzk-flash-messages-container').removeClass().addClass('clzk-flash-messages-container alert alert-success');
                    $('.clzk-flash-messages-container').fadeIn( 400 ).delay( 3000 ).fadeOut( 400 );
                    NProgress.done();
                },
                error: function(response) {
                    that.render();
                    $('.message-sign').removeClass().addClass('message-sign glyphicon glyphicon-remove-sign');
                    $('.message-text').html('Une erreur est survenue. Veuillez réesayer ultérieurement ou contacter le support')
                    $('.clzk-flash-messages-container').removeClass().addClass('clzk-flash-messages-container alert alert-danger');
                    $('.clzk-flash-messages-container').fadeIn( 400 ).delay( 3000 ).fadeOut( 400 );
                    NProgress.done();
                }
            });
        },
        cancel: function(e) {
            e.preventDefault();
            UserModule.targetUserProfilePortfolio.restore();
            UserModule.closeFormView();
            Backbone.history.navigate(UserModule.targetUserUsername, { trigger: true });
        },
        addPortfolioItem: function(e) {
            e.preventDefault();
            var itemType = $(e.currentTarget).data('item'),
                items
                that = this;

            if (itemType == 'portfolio-instrument') {
                if ($('#clzk-portfolio-portfolio-instruments').val() == '') {
                    return;
                }
                items = this.model.get('portfolio').portfolio_instruments;

                var instrument = _.findWhere(UserModule.instrumentsList, { id: $('#clzk-portfolio-portfolio-instruments').val() });
                items.push({
                    level: $('#clzk-portfolio-portfolio-instruments-level').val(),
                    name: instrument.name,
                    category: instrument.category
                });
                this.model.set('portfolio_instruments', items);
            }

            if (itemType == 'music-style') {
                items = this.model.get('portfolio').music_styles;
                items.push({
                    name: $('#clzk-portfolio-music-style').val()
                });
                this.model.set('music_styles', items);
            }

            if (itemType == 'influence') {
                items = this.model.get('portfolio').influences;
                items.push({
                    name: $('#clzk-portfolio-influence').val()
                });
                this.model.set('influences', items);
            }

            this.save();
        },
        deletePortfolioItem: function(e) {
            e.preventDefault();

            var item = $(e.currentTarget).data('item'),
                itemIndex = $(e.currentTarget).data('index'),
                that = this;
            
            if (item == 'portfolio-instrument') {
                delete this.model.get('portfolio').portfolio_instruments[itemIndex];
            }

            if (item == 'music-style') {
                delete this.model.get('portfolio').music_styles[itemIndex];
            }

            if (item == 'influence') {
                delete this.model.get('portfolio').influence[itemIndex];
            }

            this.save();
        },
        onDomRefresh: function() {
            var that = this;

            if (typeof UserModule.instrumentsList !== 'undefined') {
                this.loadInstrumentList(UserModule.instrumentsList);
            } else {
                $.ajax({
                    type: 'GET',
                    url: Routing.generate('instruments_get_all_instruments'),
                    success: function(data) {
                        UserModule.instrumentsList = data;
                        that.loadInstrumentList(data);
                    }
                });
            }
        },
        loadInstrumentList: function(data) {
            $.each(data, function(i, el) {
                $('#clzk-portfolio-portfolio-instruments').append('<option value="'+ el.id +'">'+ el.name +'</option>');
            });

            $("#clzk-portfolio-portfolio-instruments").select2();
        },
        onRender: function() {
            this.stickit();
        },
        serializeData: function() {
            return {
                profile: this.model.toJSON()
            };
        }
    });
});
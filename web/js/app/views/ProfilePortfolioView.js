App.module("UserModule", function(UserModule, App, Backbone, Marionette, $, _){

    ProfilePortfolioView = Backbone.Marionette.ItemView.extend({
        template: '#clzk-profile-portfolio-template',
        onRender: function() {
            this.stickit();
        },
        serializeData: function() {
            return {
                portfolio: this.model.toJSON()
            };
        }
    });

    ProfilePortfolioFormView = Backbone.Marionette.ItemView.extend({
        template: '#clzk-profile-portfolio-form-template',
        events: {
            'click .add-portfolio-item-button': 'addPortfolioItem',
            'click .save-button': 'save',
            'click .cancel-button': 'cancel'
        },
        save: function(e) {
            NProgress.start();
            e.preventDefault();
            this.model.save({}, {
                success: function(model, response) {
                    UserModule.closeFormView();
                    Backbone.history.navigate(UserModule.targetUserUsername, { trigger: true });
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
                items;

            if (itemType == 'portfolio-instrument') {
                if ($('#clzk-portfolio-portfolio-instruments').val() == '') {
                    return;
                }
                items = this.model.get('portfolio_instruments');

                // console.log(this.instrumentsList);
                var instrument = _.findWhere(this.instrumentsList, { id: $('#clzk-portfolio-portfolio-instruments').val() });
                // console.log(instrument);
                items.push({
                    level: $('#clzk-portfolio-portfolio-instruments-level').val(),
                    name: instrument.name,
                    category: instrument.category
                });
                this.model.set('portfolio_instruments', items);
            }

            if (itemType == 'music-style') {
                items = this.model.get('music_styles');
                items.push({
                    name: $('#clzk-portfolio-music-style').val()
                });
                this.model.set('music_styles', items);
            }

            if (itemType == 'influence') {
                items = this.model.get('influences');
                items.push({
                    name: $('#clzk-portfolio-influence').val()
                });
                this.model.set('influences', items);
            }
            // console.log(this.model);
            this.render();
        },
        onDomRefresh: function() {
            console.log(this.model);
            var that = this;
            $.ajax({
                type: 'GET',
                url: Routing.generate('instruments_get_all_instruments'),
                success: function(data) {
                    that.instrumentsList = data;
                    $.each(data, function(i, el) {
                        $('#clzk-portfolio-portfolio-instruments').append('<option value="'+ el.id +'">'+ el.name +'</option>');
                    });

                    $("#clzk-portfolio-portfolio-instruments").select2();
                }
            });
            
        },
        onRender: function() {
            this.stickit();
        },
        serializeData: function() {
            return {
                portfolio_instruments: this.model.get('portfolio_instruments'),
                music_styles: this.model.get('music_styles'),
                influences: this.model.get('influences')
            };
        }
    });
});
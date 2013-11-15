App.module("UserModule", function(UserModule, App, Backbone, Marionette, $, _){

    Instrument = Backbone.DeepModel.extend({
        urlRoot: function() {
            return 'http://colzakfr.dev/app_dev.php/api/portfolio/instruments/' + this.slug;
        },

        initialize: function(model, options) {
            console.log(options);
            this.slug = options.slug;
        }
    });

    Instruments = Backbone.Collection.extend({
        model: Instrument,
        initialize: function(models, options) {
            console.log(options);
            this.slug = options.slug;
        },
        url: 'http://colzakfr.dev/app_dev.php/api/portfolio/instruments/'
    });
});
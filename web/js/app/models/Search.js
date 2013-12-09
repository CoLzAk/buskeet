App.module("SearchModule", function(SearchModule, App, Backbone, Marionette, $, _){

    Search = Backbone.DeepModel.extend({
        urlRoot: function() {
            return 'http://colzakfr.dev/app_dev.php/api/search/' + this.localization + '/' + this.category;
        },

        initialize: function(model, options) {
            this.localization = options.localization || 'FR';
            this.category = options.category || 'all';
        }
    });
});
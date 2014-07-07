App.module("SearchModule", function(SearchModule, App, Backbone, Marionette, $, _){
    Search = Backbone.DeepModel.extend({
        initialize: function(model, options) {
            this.queryUrl = options.queryUrl;
            var i = 0;
            this.baseUrl = Routing.generate('search_get_search', { localization: this.queryUrl.localization });
            for (var param in this.queryUrl.searchParams) {
                if (i === 0) this.baseUrl += '?';
                this.baseUrl += param + '=' + this.queryUrl.searchParams[param] + '&';
                i++;
            }
            if (this.baseUrl.slice(-1) == '&') this.baseUrl = this.baseUrl.substring(0, this.baseUrl.length - 1);
        },

        url: function(){
            return this.baseUrl;
        }
    });
});
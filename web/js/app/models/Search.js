App.module("SearchModule", function(SearchModule, App, Backbone, Marionette, $, _){
    Search = Backbone.DeepModel.extend({
        initialize: function(model, options) {
            this.queryUrl = options.queryUrl;
            var i = 0;
            this.baseUrl = Routing.generate('search_get_search', { localization: this.queryUrl.localization, direction: this.queryUrl.direction });
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

    SearchEvent = Backbone.Model.extend({
        urlRoot: function(){
            return Routing.generate('events_get_events');
        }
    });

    SearchEvents = Backbone.Collection.extend({
        model: SearchEvent,

        url: function(){
            return Routing.generate('events_get_events');
        }
    });

    Message = Backbone.Model.extend({
        initialize: function(model, options) {
            this.recipientId = options.recipientId;
        },
        url: function() {
            return Routing.generate('messages_post_messages', { recipientId: this.recipientId });
        }
    })
});
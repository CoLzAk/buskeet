App.module("SearchModule", function(SearchModule, App, Backbone, Marionette, $, _){
	PublicPlace = Backbone.Model.extend({
        urlRoot: function(){
            return Routing.generate('geo_get_public_places');
        }
    });

    PublicPlaces = Backbone.Collection.extend({
        model: PublicPlace,

        url: function(){
            return this.baseUrl;
        },
        initialize: function(collection, options) {
        	this.baseUrl = Routing.generate('geo_get_public_places');
        	this.baseUrl += '?lat=' + options.lat + '&lng=' + options.lng; // + '&radius=' + options.radius;
        }
    });
});
App.module("SearchModule", function(SearchModule, App, Backbone, Marionette, $, _){

    PublicPlaceView = Backbone.Marionette.ItemView.extend({
        template: '#clzk-public-place-template'
    });

    PublicPlacesView = Backbone.Marionette.CompositeView.extend({
        template: '#clzk-public-places-template',
        itemView: PublicPlaceView,
        itemViewContainer: function() {
            return '#public-places-container'
        }
    });
});
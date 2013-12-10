App.module("SearchModule", function(SearchModule, App, Backbone, Marionette, $, _){

    SearchMenuView = Backbone.Marionette.ItemView.extend({
        template: '#clzk-search-menu-template',
        onDomRefresh: function() {
            this.initMap();
        },
        initMap: function() {
            var mapWidth = $('#map').width();
            var mapUrl = 'http://maps.googleapis.com/maps/api/staticmap?center=Paris&zoom=13&size='+mapWidth+'x'+mapWidth+'&maptype=roadmap&markers=color:red|Paris&sensor=false';
            $('#map').html('<img src="'+ mapUrl +'">');
        },
        initialize: function() {
            console.log('init search menu view');
        }
    });

    SearchResultView = Backbone.Marionette.ItemView.extend({
        template: '#clzk-search-result-template',
        tagName: 'div',
        serializeData: function() {
            return {
                user: this.model.toJSON()
            };
        },
        initialize: function() {
            console.log(this.model.toJSON());
            console.log('init search results view');
        }
    });

    SearchResultsView = Backbone.Marionette.CompositeView.extend({
        template: '#clzk-search-results-template',
        itemView: SearchResultView,
        itemViewContainer: '#clzk-search-result-container'
    });
});
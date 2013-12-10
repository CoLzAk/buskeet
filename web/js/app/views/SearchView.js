App.module("SearchModule", function(SearchModule, App, Backbone, Marionette, $, _){

    SearchMenuView = Backbone.Marionette.ItemView.extend({
        template: '#clzk-search-menu-template',
        onDomRefresh: function() {
            this.initMap();
        },
        initMap: function() {
            var users = this.collection;
            var markers = '';
            var mapWidth = $('#map').width();
            var mapUrl = '';

            for (var i in users.models) {
                console.log(users.models[i]);
                if (typeof users.models[i].get('profile').lat !== 'undefined' || users.models[i].get('profile').lat !== null && typeof users.models[i].get('profile').lon !== 'undefined' || users.models[i].get('profile').lon !== null) {
                    markers += '&markers=color:red|' + users.models[i].get('profile').lat + ',' + users.models[i].get('profile').lon;
                }
            }
            mapUrl = 'http://maps.googleapis.com/maps/api/staticmap?center=Paris&zoom=13&size='+mapWidth+'x'+mapWidth+'&maptype=roadmap&sensor=false' + markers;
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
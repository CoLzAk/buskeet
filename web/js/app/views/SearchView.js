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
                if (typeof users.models[i].get('profile').lat !== 'undefined' || users.models[i].get('profile').lat !== null && typeof users.models[i].get('profile').lon !== 'undefined' || users.models[i].get('profile').lon !== null) {
                    markers += '&markers=color:red|' + users.models[i].get('profile').lat + ',' + users.models[i].get('profile').lon;
                }
            }
            mapUrl = 'http://maps.googleapis.com/maps/api/staticmap?center=Paris&zoom=5&size='+mapWidth+'x'+mapWidth+'&maptype=roadmap&sensor=false' + markers;
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
            var profile_picture = _.findWhere(this.model.get('profile').photos, { is_profile_picture: true });

            return {
                profile_picture_path: profile_picture.thumb_path,
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
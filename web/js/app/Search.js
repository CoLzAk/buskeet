App.module("SearchModule", function(SearchModule, App, Backbone, Marionette, $, _){
    this.startWithParent = false;   // prevent starting with parent

    SearchLayout = Backbone.Marionette.Layout.extend({
        template: "#clzk-search-layout",
        regions: {
            searchMenuRegion: '#clzk-search-menu-region',
            searchResultsRegion: '#clzk-search-results-region'
        }
    });

    ModalLayout = Backbone.Marionette.Layout.extend({
        template: "#clzk-modal-layout",
        regions: {
            modalContentRegion: "#clzk-modal-content-region"
        }
    });

    SearchModule.search = function(localization, filters) {
        console.log(SearchModule.queryUrl);
        if (typeof SearchModule.resultsCollection === 'undefined') {
            $.ajax({
                url: 'http://maps.googleapis.com/maps/api/geocode/json?address='+ localization.replace(/--/g, '+').replace(/-/g, '+') +'&sensor=true&language=fr&region=fr',
                success: function(data) {
                    SearchModule.queryUrl.searchParams['lat'] = data.results[0].geometry.location.lat;
                    SearchModule.queryUrl.searchParams['lng'] = data.results[0].geometry.location.lng;
                    SearchModule.queryUrl.searchParams['page'] = 1;

                    var results = new Search({}, { queryUrl: SearchModule.queryUrl });

                    results.fetch({
                        success: function(resultsCollection) {
                            SearchModule.resultsCollection = resultsCollection;
                            $('#clzk-search-input').val(data.results[0].formatted_address);
                            SearchModule.displayViews(resultsCollection, localization, filters);
                        }
                    });
                },
                error: function(data) {
                    alert('aucune ville trouvée à : ' + localization);
                }
            });
        } else {
            SearchModule.queryUrl.searchParams['page'] = 1;
            var results = new Search({}, { queryUrl: SearchModule.queryUrl });

            results.fetch({
                success: function(resultsCollection) {
                    SearchModule.displayViews(resultsCollection, localization, filters);
                }
            });
        }
    };

    SearchModule.displayViews = function(resultsCollection, localization, filters) {
        SearchModule.profiles = new Profiles(resultsCollection.get('items'));
        SearchModule.searchLayout.searchMenuRegion.show(new SearchMenuView({ model: resultsCollection }));
        SearchModule.searchLayout.searchResultsRegion.show(new SearchResultsView({ collection: SearchModule.profiles }));
    };

    SearchModule.addInitializer(function(options){
        SearchModule.queryUrl = options.queryUrl;
        SearchModule.searchLayout = new SearchLayout();
        App.mainRegion.show(SearchModule.searchLayout);
    });
});
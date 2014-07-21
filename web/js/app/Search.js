App.module("SearchModule", function(SearchModule, App, Backbone, Marionette, $, _){
    this.startWithParent = false;   // prevent starting with parent

    SearchLayout = Backbone.Marionette.Layout.extend({
        template: "#clzk-search-layout",
        regions: {
            searchMenuRegion: '#clzk-search-menu-region',
            searchResultsRegion: '#clzk-search-results-region',
            searchPreviewRegion: '#clzk-search-preview-region'
        },
        tagName: 'div',
        className: 'full-height'
    });

    ModalLayout = Backbone.Marionette.Layout.extend({
        template: "#clzk-modal-layout",
        regions: {
            modalContentRegion: "#clzk-modal-content-region"
        }
    });

    SearchModule.search = function(localization, filters) {
        NProgress.start();
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
                            SearchModule.displayViews(resultsCollection, localization, SearchModule.queryUrl.direction, filters);
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
                    SearchModule.displayViews(resultsCollection, localization, SearchModule.queryUrl.direction, filters);
                }
            });
        }
    };

    SearchModule.displayViews = function(resultsCollection, localization, direction, filters) {
        if ($('.clzk-preview-container').is(':visible')) {
            $('.clzk-preview-container').hide();
            $('.clzk-search-menu-region-container').animate({
                'margin-left': '0'
            }, 200);
        }
        SearchModule.searchLayout.searchMenuRegion.show(new SearchMenuView({ model: resultsCollection }));
        if (direction == 'profiles') {
            SearchModule.profiles = new Profiles(resultsCollection.get('items'));
            SearchModule.searchLayout.searchResultsRegion.show(new SearchResultsView({ collection: SearchModule.profiles }));
        }
        if (direction == 'events') {
            SearchModule.usersEvents = new SearchEvents(resultsCollection.get('items'));
            SearchModule.searchLayout.searchResultsRegion.show(new SearchEventsView({ collection: SearchModule.usersEvents }));
        }
        NProgress.done();
    };

    SearchModule.displayPreview = function(localization, direction, itemId) {
        $('.clzk-search-menu-region-container').animate({
            'margin-left': '-1000px'
        }, 500, function() {
            $('.event-container').addClass('disabled');
            $('.clzk-preview-container').fadeIn();
        });
        if (direction == 'events') {
            SearchModule.searchLayout.searchPreviewRegion.show(new SearchEventPreviewView({ model: SearchModule.usersEvents.get(itemId) }));
        }
        if (direction == 'profiles') {
            SearchModule.searchLayout.searchPreviewRegion.show(new SearchProfilePreviewView({ model: SearchModule.profiles.get(itemId) }));
        }
    }

    SearchModule.addInitializer(function(options){
        SearchModule.authUser = options.authUser;
        SearchModule.queryUrl = options.queryUrl;
        SearchModule.searchLayout = new SearchLayout();
        App.mainRegion.show(SearchModule.searchLayout);
    });
});
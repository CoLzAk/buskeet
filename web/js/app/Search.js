App.module("SearchModule", function(SearchModule, App, Backbone, Marionette, $, _){
    this.startWithParent = false;   // prevent starting with parent

    SearchLayout = Backbone.Marionette.Layout.extend({
        template: "#clzk-search-layout",
        regions: {
            searchMenuRegion: '#clzk-search-menu-region',
            searchResultsRegion: '#clzk-search-results-region',
            searchPaginationRegion: '#clzk-search-pagination-region',
            searchPreviewRegion: '#clzk-search-preview-region',
            searchInfoRegion: '#clzk-search-info-region'
        },
        tagName: 'div',
        className: 'full-height'
    });

    SearchMenuLayout = Backbone.Marionette.Layout.extend({
        template: '#clzk-search-menu-layout',
        regions: {
            actionsRegion: '#clzk-search-menu-actions-region'
        }
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
                    // SearchModule.queryUrl.searchParams['page'] = 1;

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
            // SearchModule.queryUrl.searchParams['page'] = 1;
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
            if (!SearchModule.isMobile) {
                $('.clzk-right-region').css('width', '75%');
            }
            $('#left-menu').animate({
                'margin-left': '0'
            }, 200);
            $('.clzk-search-info-container').removeClass('hidden');
        }
        SearchModule.searchMenuLayout.actionsRegion.show(new SearchMenuView({ model: resultsCollection }));
        SearchModule.searchLayout.searchPaginationRegion.show(new SearchPaginationView({ model: resultsCollection }));
        if (direction == 'profiles') {
            SearchModule.profiles = new Profiles(resultsCollection.get('items'));
            SearchModule.searchLayout.searchResultsRegion.show(new SearchResultsView({ collection: SearchModule.profiles }));
        }
        if (direction == 'events') {
            SearchModule.usersEvents = new SearchEvents(resultsCollection.get('items'));
            SearchModule.searchLayout.searchResultsRegion.show(new SearchEventsView({ collection: SearchModule.usersEvents }));
            
            // SearchModule.publicEvents = SearchModule.usersEvents;
            // // fetch public places
            // SearchModule.searchLayout.searchInfoRegion.show(new SearchPublicEventsView({ collection: SearchModule.publicEvents }));
        }
        // fetch and display public places
        var publicPlaces = new PublicPlaces({}, { lat: resultsCollection.get('params').lat, lng: resultsCollection.get('params').lng /*, radius: resultsCollection.get('params').radius*/ });

        publicPlaces.fetch({
            success: function(results) {
                // console.log(results);
                SearchModule.searchLayout.searchInfoRegion.show(new PublicPlacesView({ collection: results }));
            }
        });
        NProgress.done();
    };

    SearchModule.displayPreview = function(localization, direction, itemId) {
        $('#left-menu').animate({
            'margin-left': '-1000px'
        }, 500, function() {
            if (!SearchModule.isMobile) {
                $('.clzk-right-region').css('width', '100%');
            }
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

    SearchModule.displayPublicPlaces = function(localization) {
        console.log('jfkdlsj');
    }

    SearchModule.addInitializer(function(options){
        SearchModule.authUser = options.authUser;
        SearchModule.queryUrl = options.queryUrl;
        SearchModule.searchMenuLayout = new SearchMenuLayout();
        SearchModule.searchLayout = new SearchLayout();
        App.menuRegion.show(SearchModule.searchMenuLayout);
        App.mainRegion.show(SearchModule.searchLayout);
        SearchModule.isMobile = false;

        if ($('.xs-screen-menu-link').is(':visible') || $('.xs-screen-menu-link-right').is(':visible') || $('.xs-screen-menu-link-home').is(':visible')) {
            SearchModule.isMobile = true;
        }
    });
});
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

    SearchModule.search = function(localization, category) {
        SearchModule.search = new Search([], { localization: localization, category: category});
        SearchModule.search.fetch( {
            success: function(results) {
                SearchModule.users = new Users(results);
                SearchModule.searchLayout.searchMenuRegion.show(new SearchMenuView());
                SearchModule.searchLayout.searchResultsRegion.show(new SearchResultsView({ collection: SearchModule.users }));
                console.log(results);
            }
        });
    };

    SearchModule.addInitializer(function(options){
        SearchModule.searchLayout = new SearchLayout();
        App.mainRegion.show(SearchModule.searchLayout);
    });
});
App = new Backbone.Marionette.Application();

App.Router = Backbone.Marionette.AppRouter.extend({
    appRoutes: {
        ':username': 'show',
        ':username/edit/:formName': 'edit',
        ':username/gallery': 'gallery'
    }
});

App.SearchRouter = Backbone.Marionette.AppRouter.extend({
    appRoutes: {
        ':localization' : 'search',
        ':localization/:category' : 'search'
        // ':localization/:category?:slug' : "search"
    }
});

App.addRegions({
    mainRegion: '#clzk-main-region',
    modalRegion: '#clzk-modal-region'
});

App.on('start', function(options){

    console.log('start app');

    // Starting all the modules of the app
    _.each(this.submodules, function (mod) {
        mod.start(options);
    });

    if(options.module == "search") {
        App.searchRouter = new App.SearchRouter({
            controller: App.SearchModule
        });
    } else {
        App.router = new App.Router({
            controller: App.UserModule
        });
    }

    Backbone.history.start({ pushState: true, root: options.path });
});
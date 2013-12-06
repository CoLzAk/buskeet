App = new Backbone.Marionette.Application();

App.Router = Backbone.Marionette.AppRouter.extend({
    appRoutes: {
        ':username': 'show',
        ':username/edit/:formName': 'edit',
        ':username/gallery': 'gallery'
    }
});

App.addRegions({
    profileRegion: '#clzk-profile-region',
    modalRegion: '#clzk-modal-region'
});

App.on('start', function(options){

	console.log('start app');

    // Starting all the modules of the app
    _.each(this.submodules, function (mod) {
        mod.start(options);
    });

    App.router = new App.Router({
        controller: App.UserModule
    });
    
    Backbone.history.start({ pushState: true, root: options.path });
});
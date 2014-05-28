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
// Custom region transition
var MainRegion = Backbone.Marionette.Region.extend({
    el: '#clzk-main-region',
    show: function(view){
        this.ensureEl();
        view.render();

        this.close(function() {
            if (this.currentView && this.currentView !== view) { return; }
            this.currentView = view;

            this.open(view, function(){
                if (view.onShow){view.onShow();}
                view.trigger("show");

                if (this.onShow) { this.onShow(view); }
                this.trigger("view:show", view);
            });
        });
    },

    close: function(cb){
        var view = this.currentView;
        delete this.currentView;

        if (!view){
            if (cb){ cb.call(this); }
            return; 
        }

        var that = this;
        this.$el.addClass('hidden');
        view.$el.fadeOut(function(){
            if (view.close) { view.close(); }
            that.trigger("view:closed", view);
            if (cb){ cb.call(that); }
        });
    },

    open: function(view, callback){
        var that = this;
        // console.log(this.$el.addClass('hidden'));
        this.$el.html(view.$el.hide());

        this.$el.removeClass('hidden');
        view.$el.fadeIn(function(){
            callback.call(that);
        });
    }
});

// Custom region transition
var FormRegion = Backbone.Marionette.Region.extend({
    el: '#clzk-form-region',
    show: function(view){
        this.ensureEl();
        view.render();

        this.close(function() {
            if (this.currentView && this.currentView !== view) { return; }
            this.currentView = view;

            this.open(view, function(){
                if (view.onShow){view.onShow();}
                view.trigger("show");

                if (this.onShow) { this.onShow(view); }
                this.trigger("view:show", view);
            });
        });
    },

    close: function(cb){
        var view = this.currentView;
        delete this.currentView;

        if (!view){
            if (cb){ cb.call(this); }
            return; 
        }

        var that = this;
        this.$el.addClass('hidden');
        view.$el.fadeOut(function(){
            if (view.close) { view.close(); }
            that.trigger("view:closed", view);
            if (cb){ cb.call(that); }
        });
    },

    open: function(view, callback){
        var that = this;
        // console.log(this.$el.addClass('hidden'));
        this.$el.html(view.$el.hide());

        this.$el.removeClass('hidden');
        view.$el.fadeIn(function(){
            callback.call(that);
        });
    }
});

App.addRegions({
    menuRegion: '#clzk-menu-region',
    mainRegion: MainRegion,
    formRegion: FormRegion,
    modalRegion: '#clzk-modal-region'
});

App.on('start', function(options){

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
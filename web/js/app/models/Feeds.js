App.module("FeedsModule", function(FeedsModule, FamileasyApp, Backbone, Marionette, $, _){

    Feed = Backbone.Model.extend({
        urlRoot: function(){
            return Routing.generate('users_get_feeds');
        }
    });

    Feeds = Backbone.Collection.extend({
        model: Feed,
        url: function(){
            return Routing.generate('users_get_feeds');
        }
    });

    FeedStream = Backbone.Model.extend({
        urlRoot: function(){
            return Routing.generate('users_get_feeds');
        }
    });

    FeedsProfiles = Backbone.Model.extend({
        urlRoot: function() {
            return Routing.generate('users_get_feeds_profiles');
        }
    });

    FeedsEvents = Backbone.Model.extend({
        urlRoot: function() {
            return Routing.generate('users_get_feeds_events');
        }
    });
});

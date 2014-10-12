App.module("FeedsModule", function(FeedsModule, App, Backbone, Marionette, $, _){

    FeedsMenuView = Backbone.Marionette.ItemView.extend({
        template: '#clzk-feeds-menu-template',
        tagName: 'div',
        serializeData: function() {
        	return {
        		profile: this.model.toJSON()
        	};
        }
    });
});
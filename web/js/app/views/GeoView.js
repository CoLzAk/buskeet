App.module("SearchModule", function(SearchModule, App, Backbone, Marionette, $, _){

    PublicPlaceView = Backbone.Marionette.ItemView.extend({
        template: '#clzk-public-place-template',
        onDomRefresh: function() {
            var that = this;
            $('#search-info-panel-'+that.model.get('id')).on('mouseover', function(e) {
                $('#search-info-panel-body-'+that.model.get('id')).html(that.model.get('description') + '<div class="clearfix mb2"></div>');
            }).on('mouseout', function(e) {
                if (that.model.get('description').length > 50) {
                    $('#search-info-panel-body-'+that.model.get('id')).html(that.model.get('description').substring(0,50) + '...');
                }
            });
        },
        serializeData: function() {
            var completeAddress = '';
            if (typeof this.model.get('street_number') !== 'undefined' && this.model.get('street_number') !== '') completeAddress += this.model.get('street_number') + ' ';
            if (this.model.get('route') !== '') completeAddress += this.model.get('route') + ', ';
            if (typeof this.model.get('sublocality') !== 'undefined' && this.model.get('sublocality') !== '') completeAddress += this.model.get('sublocality') + ', ';
            if (this.model.get('locality') !== '') completeAddress += this.model.get('locality') + ', ';
            if (this.model.get('country') !== '') completeAddress += this.model.get('country');
            return {
                place: this.model.toJSON(),
                completeAddress: completeAddress
            };
        }
    });

    PublicPlacesView = Backbone.Marionette.CompositeView.extend({
        template: '#clzk-public-places-template',
        events: {
            'click #show-public-places': 'showPublicPlaces'
        },
        itemView: PublicPlaceView,
        itemViewContainer: function() {
            return '#public-places-container'
        },
        showPublicPlaces: function(e) {
            e.preventDefault();
            Backbone.history.navigate('places/'+SearchModule.resultsCollection.queryUrl.localization, { trigger: true });
        },
        serializeData: function() {
            return {
                places: this.collection.toJSON()
            };
        }
    });
});
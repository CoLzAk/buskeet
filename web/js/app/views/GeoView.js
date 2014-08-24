App.module("SearchModule", function(SearchModule, App, Backbone, Marionette, $, _){

    PublicPlaceView = Backbone.Marionette.ItemView.extend({
        template: '#clzk-public-place-template',
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
        itemView: PublicPlaceView,
        itemViewContainer: function() {
            return '#public-places-container'
        }
    });
});
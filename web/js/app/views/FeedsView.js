App.module("FeedsModule", function(FeedsModule, App, Backbone, Marionette, $, _){

    FeedView = Backbone.Marionette.ItemView.extend({
        template: '#clzk-feed-template',
        tagName: 'div',
        serializeData: function() {
            var context, followingProfilePhoto, movement = this.model.toJSON();
            if (typeof movement.movement_detail.photo !== 'undefined') {
                context = 'PHOTO';
            }
            if (typeof movement.movement_detail.event !== 'undefined') {
                context = 'EVENT';
                var completeAddress = '';
                if (movement.movement_detail.event.street_number !== '') completeAddress += movement.movement_detail.event.street_number + ' ';
                if (movement.movement_detail.event.route !== '') completeAddress += movement.movement_detail.event.route + ', ';
                if (movement.movement_detail.event.sublocality !== '') completeAddress += movement.movement_detail.event.sublocality + ', ';
                if (movement.movement_detail.event.locality !== '') completeAddress += movement.movement_detail.event.locality + ', ';
                if (movement.movement_detail.event.country !== '') completeAddress += movement.movement_detail.event.country;
            }
            // console.log(completeAddress);
            if (typeof movement.movement_detail.profile !== 'undefined') {
                context = 'PROFILE';
                // for (var i in )
            }
            var posterProfilePhoto = _.findWhere(movement.profile.photos, { is_profile_picture: true });
            return {
                poster_profile_photo: posterProfilePhoto,
                completeAddress: completeAddress,
                context: context,
                feed: this.model.toJSON()
            }
        }
    });

    FeedsView = Backbone.Marionette.CompositeView.extend({
        template: '#clzk-feeds-template',
        itemView: FeedView,
        tagName: 'div',
        itemViewContainer: function() {
            return '#clzk-feed-container';
        }
    });
});
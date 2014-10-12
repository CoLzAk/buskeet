App.module("UserModule", function(UserModule, App, Backbone, Marionette, $, _){

    ProfileMapView = Backbone.Marionette.ItemView.extend({
        template: '#clzk-profile-map-template',
        tagName: 'div',
        onRender: function() {
            this.stickit();
        },
        serializeData: function() {
            return {
                profile: this.model.toJSON()
            };
        },
        onDomRefresh: function() {
        	var lat = ((typeof this.model.get('coordinates') === 'undefined') ? 47.00 : this.model.get('coordinates').y),
        		lng = ((typeof this.model.get('coordinates') === 'undefined') ? 2.00 : this.model.get('coordinates').x),
        		zoom = ((typeof this.model.get('coordinates') === 'undefined') ? 5 : 15);
        		latlng = new google.maps.LatLng(lat, lng),
                mapOptions = {
                    zoom: zoom,
                    center: latlng,
                    mapTypeId: google.maps.MapTypeId.ROADMAP
                },
                map = new google.maps.Map(document.getElementById('cn-map-canvas'), mapOptions),
                marker = new google.maps.Marker({
                    position: latlng,
                    map: map,
                    title: 'Moi'
                });

            return map;
        }
    });
});
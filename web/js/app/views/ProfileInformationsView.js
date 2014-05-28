App.module("UserModule", function(UserModule, App, Backbone, Marionette, $, _){

    ProfileInformationsView = Backbone.Marionette.ItemView.extend({
        template: '#clzk-profile-informations-template',
        bindings: {
            '#clzk-profile-firstname': 'firstname',
            '#clzk-profile-lastname': 'lastname',
            '#clzk-profile-birthdate': {
                observe: 'birthdate',
                onGet: function(value) {
                    return moment(value).fromNow(true);
                }
            },
            '#clzk-profile-locality': 'locality',
            '#clzk-profile-description': 'description'
        },
        onRender: function() {
            this.stickit();
        },
        initialize: function() {
            // => ça c'est cool
            // var latlng = new google.maps.LatLng(this.model.get('profile').address_coordinates.x, this.model.get('profile').address_coordinates.y),
            //     mapOptions = {
            //         zoom: 15,
            //         center: latlng,
            //         mapTypeId: google.maps.MapTypeId.ROADMAP
            //     },
            //     map = new google.maps.Map(document.getElementById('cn-map-canvas'), mapOptions),
            //     marker = new google.maps.Marker({
            //         position: latlng,
            //         map: map,
            //         title: 'Moi'
            //     });

            // return map;
        }
    });

    ProfileInformationsFormView = Backbone.Marionette.ItemView.extend({
        template: '#clzk-profile-informations-form-template',
        bindings: {
            '#clzk-profile-birthdate': 'birthdate',
            '#clzk-profile-street-number': 'street_number',
            '#clzk-profile-route': 'route',
            '#clzk-profile-locality': 'locality',
            '#clzk-profile-sublocality': 'sublocality',
            '#clzk-profile-administrative-area-level-1': 'administrative_area_level_1',
            '#clzk-profile-administrative-area-level-2': 'administrative_area_level_2',
            '#clzk-profile-country': 'country',
            '#clzk-profile-postal-code': 'postal_code',
            '#clzk-profile-lat': 'lat',
            '#clzk-profile-lon': 'lon',
            '#clzk-profile-description': 'description'
        },
        events: {
            'click .save-button': 'save',
            'click .cancel-button': 'cancel'
        },
        save: function(e) {
            NProgress.start();
            e.preventDefault();
            this.model.save({}, {
                success: function(model, response) {
                    UserModule.closeFormView();
                    Backbone.history.navigate(UserModule.targetUserUsername, { trigger: true });
                }
            });
        },
        cancel: function(e) {
            e.preventDefault();
            UserModule.targetUserProfile.restore();
            UserModule.closeFormView();
            Backbone.history.navigate(UserModule.targetUserUsername, { trigger: true });
        },
        onRender: function() {
            this.stickit();
        },
        onDomRefresh: function() {
            var that = this;
            $('.datepicker').datepicker({
                dateFormat: 'dd/mm/yy'
            });
            that.initMap();
        },
        initMap: function() {
            var profile = this.model.toJSON(),
                mapWidth = $('#map-container').width(),
                mapUrl,
                input = document.getElementById('clzk-profile-address-input'),
                autocomplete = new google.maps.places.Autocomplete(input),
                place,
                center,
                that = this;

            //Show the map
            if (typeof profile.lat === 'undefined' || profile.lat === 0 && typeof profile.lon === 'undefined' || profile.lon === 0) {
                mapUrl = 'http://maps.googleapis.com/maps/api/staticmap?center=47.00,2.00&zoom=5&size='+mapWidth+'x250&maptype=roadmap&markers=color:red|47.00,2.00&sensor=false&scale=1';
            } else {
                mapUrl = 'http://maps.googleapis.com/maps/api/staticmap?center='+ profile.lat +','+ profile.lon +'&zoom=13&size='+mapWidth+'x250&maptype=roadmap&markers=color:red|'+ profile.lat +','+ profile.lon +'&sensor=false&scale=1';
            }

            $('#map').html('<img src="'+ mapUrl +'">');

            //Bind the input with autocomplete function
            google.maps.event.addListener(autocomplete, 'place_changed', function() {
                place = autocomplete.getPlace();
                if (!place.geometry) {
                    // Inform the user that the place was not found and return.
                    console.log('place not found');
                    return;
                } else {
                    if (place.address_components) {
                        address = [
                          (place.address_components[0] && place.address_components[0].short_name || ''),
                          (place.address_components[1] && place.address_components[1].short_name || ''),
                          (place.address_components[2] && place.address_components[2].short_name || '')
                        ].join(' ');

                        //fill hidden fields
                        for (var i=0, j=place.address_components.length; i<j; i++) {
                            if (place.address_components[i].types.indexOf("street_number") > -1) {
                                $('#clzk-profile-street-number').val(place.address_components[i].long_name);
                                that.model.set('street_number', place.address_components[i].long_name);
                            }
                            if (place.address_components[i].types.indexOf("route") > -1) {
                                $('#clzk-profile-route').val(place.address_components[i].long_name);
                                that.model.set('route', place.address_components[i].long_name);
                            }
                            if (place.address_components[i].types.indexOf("locality") > -1) {
                                $('#clzk-profile-locality').val(place.address_components[i].long_name);
                                that.model.set('locality', place.address_components[i].long_name);
                            }
                            if (place.address_components[i].types.indexOf("administrative_area_level_2") > -1) {
                                $('#clzk-profile-administrative-area-level-2').val(place.address_components[i].long_name);
                                that.model.set('administrative_area_level_2', place.address_components[i].long_name);
                            }
                            if (place.address_components[i].types.indexOf("administrative_area_level_1") > -1) {
                                $('#clzk-profile-administrative-area-level-1').val(place.address_components[i].long_name);
                                that.model.set('administrative_area_level_1', place.address_components[i].long_name);
                            }
                            if (place.address_components[i].types.indexOf("country") > -1) {
                                $('#clzk-profile-country').val(place.address_components[i].long_name);
                                that.model.set('country', place.address_components[i].long_name);
                            }
                            if (place.address_components[i].types.indexOf("postal_code") > -1) {
                                $('#clzk-profile-postal-code').val(place.address_components[i].long_name);
                                that.model.set('postal_code', place.address_components[i].long_name);
                            }
                            if (place.address_components[i].types.indexOf("sublocality") > -1) {
                                $('#clzk-profile-sublocality').val(place.address_components[i].long_name);
                                that.model.set('sublocality', place.address_components[i].long_name);
                            }
                        }
                        $('#clzk-profile-lon').val(place.geometry.location.lng());
                        that.model.set('lon', place.geometry.location.lng());
                        $('#clzk-profile-lat').val(place.geometry.location.lat());
                        that.model.set('lat', place.geometry.location.lat());

                        mapUrl = 'http://maps.googleapis.com/maps/api/staticmap?center='+ place.geometry.location.lat() +','+ place.geometry.location.lng() +'&zoom=13&size='+mapWidth+'x250&maptype=roadmap&markers=color:red|'+ place.geometry.location.lat() +','+ place.geometry.location.lng() +'&sensor=false';

                        $('#map').html('<img src="'+ mapUrl +'">');
                    }
                }
            });
        },
    });
});
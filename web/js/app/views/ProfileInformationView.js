App.module("UserModule", function(UserModule, App, Backbone, Marionette, $, _){

    ProfileInformationView = Backbone.Marionette.ItemView.extend({
        template: '#clzk-profile-information-template',
        bindings: {
            '#clzk-profile-firstname': 'profile.firstname',
            '#clzk-profile-lastname': 'profile.lastname',
            '#clzk-profile-birthdate': 'profile.birthdate',
            '#clzk-profile-locality': 'profile.locality'
        },
        events: {
            'click .edit-btn': 'edit'
        },
        edit: function(e) {
            e.preventDefault();
            Backbone.history.navigate(this.model.get('username') + '/edit/information', { trigger: true });
        },
        onRender: function() {
            this.stickit();
        },
        initialize: function() {
            console.log(this.model);
            console.log('init profile-information-template');


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

    ProfileInformationFormView = Backbone.Marionette.ItemView.extend({
        template: '#clzk-profile-information-form-template',
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
            '#clzk-profile-lon': 'lon'
        },
        events: {
            'click .close-modal-btn': 'closeModal',
            'click .save-modal-btn': 'save',
            'click #clzk-geocode' : 'geocode'
        },
        save: function(e) {
            e.preventDefault();
            this.model.save({}, {
                success: function(model, response) {
                    $('#clzk-modal').modal('hide');
                    Backbone.history.navigate(model.get('username'), { trigger: true });
                }
            });
        },
        closeModal: function(e) {
            e.preventDefault();
            Backbone.history.navigate(this.model.get('username'), { trigger: true });
            $('#clzk-modal').modal('hide');
        },
        onRender: function() {
            this.stickit();
        },
        onDomRefresh: function() {
            var that = this;
            $('.datepicker').datepicker({
                dateFormat: 'dd/mm/yy'
            });
            $('#clzk-modal').on('shown.bs.modal', function () {
                //google.maps.event.trigger(map, "resize");
                that.initMap();
            });
        },
        initMap: function() {
            var profile = this.model.get('profile');
            var mapWidth = $('.modal-body').width();
            var mapUrl;
            var input = document.getElementById('clzk-profile-address-input');
            var autocomplete = new google.maps.places.Autocomplete(input);
            var place;
            var center;

            //Show the map
            if (typeof profile.lat === 'undefined' || profile.lat === 0 && typeof profile.lon === 'undefined' || profile.lon === 0) {
                mapUrl = 'http://maps.googleapis.com/maps/api/staticmap?center=47.00,2.00&zoom=5&size='+mapWidth+'x180&maptype=roadmap&markers=color:red|47.00,2.00&sensor=false';
            } else {
                mapUrl = 'http://maps.googleapis.com/maps/api/staticmap?center='+ profile.lat +','+ profile.lon +'&zoom=13&size='+mapWidth+'x180&maptype=roadmap&markers=color:red|'+ profile.lat +','+ profile.lon +'&sensor=false';
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
                                profile.street_number = place.address_components[i].long_name;
                            }
                            if (place.address_components[i].types.indexOf("route") > -1) {
                                $('#clzk-profile-route').val(place.address_components[i].long_name);
                                profile.route = place.address_components[i].long_name;
                            }
                            if (place.address_components[i].types.indexOf("locality") > -1) {
                                $('#clzk-profile-locality').val(place.address_components[i].long_name);
                                profile.locality = place.address_components[i].long_name;
                            }
                            if (place.address_components[i].types.indexOf("administrative_area_level_2") > -1) {
                                $('#clzk-profile-administrative-area-level-2').val(place.address_components[i].long_name);
                                profile.administrative_area_level_2 = place.address_components[i].long_name;
                            }
                            if (place.address_components[i].types.indexOf("administrative_area_level_1") > -1) {
                                $('#clzk-profile-administrative-area-level-1').val(place.address_components[i].long_name);
                                profile.administrative_area_level_1 = place.address_components[i].long_name;
                            }
                            if (place.address_components[i].types.indexOf("country") > -1) {
                                $('#clzk-profile-country').val(place.address_components[i].long_name);
                                profile.country = place.address_components[i].long_name;
                            }
                            if (place.address_components[i].types.indexOf("postal_code") > -1) {
                                $('#clzk-profile-postal-code').val(place.address_components[i].long_name);
                                profile.postal_code = place.address_components[i].long_name;
                            }
                            if (place.address_components[i].types.indexOf("sublocality") > -1) {
                                $('#clzk-profile-sublocality').val(place.address_components[i].long_name);
                                profile.sublocality = place.address_components[i].long_name;
                            }
                        }
                        $('#clzk-profile-lon').val(place.geometry.location.lng());
                        profile.lon = place.geometry.location.lng();
                        $('#clzk-profile-lat').val(place.geometry.location.lat());
                        profile.lat = place.geometry.location.lat();

                        mapUrl = 'http://maps.googleapis.com/maps/api/staticmap?center='+ place.geometry.location.lat() +','+ place.geometry.location.lng() +'&zoom=13&size='+mapWidth+'x180&maptype=roadmap&markers=color:red|'+ place.geometry.location.lat() +','+ place.geometry.location.lng() +'&sensor=false';

                        $('#map').html('<img src="'+ mapUrl +'">');
                    }
                }
            });
        },
    });
});
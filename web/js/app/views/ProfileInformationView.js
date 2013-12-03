App.module("UserModule", function(UserModule, App, Backbone, Marionette, $, _){

    ProfileInformationView = Backbone.Marionette.ItemView.extend({
        template: '#clzk-profile-information-template',
        bindings: {
            '#profile-firstname': 'profile.firstname',
            '#profile-lastname': 'profile.lastname',
            '#profile-description': 'profile.description'
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
            '#profile-birthdate': 'birthdate',
        },
        events: {
            'click .close-modal-btn': 'closeModal',
            'click #clzk-geocode' : 'geocode'
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
            // this.initMap();
            var that = this;
            $('.datepicker').datepicker({
                dateFormat: 'dd/mm/yy'
            });
            // this.initMap();
            $('#clzk-modal').on('shown.bs.modal', function () {
                var map = that.initMap();
                google.maps.event.trigger(map, "resize");
            });
        },
        // initialize: function() {
        // },
        // initMap: function() {
        //     return new google.maps.Map(document.getElementById('map'), {
        //         zoom: 15,
        //         center: new google.maps.LatLng(51.505, -0.09),
        //         mapTypeId: google.maps.MapTypeId.ROADMAP
        //     });
        // },
        initMap: function() {
            console.log('go');
            var profile = this.model.get('profile');
            if (this.model.get('profile').lat === 0 && this.model.get('profile').lon === 0) {
                map = new google.maps.Map(document.getElementById('googleMap'), {
                    zoom: 5,
                    center: new google.maps.LatLng(47.00, 2.00),
                    mapTypeId: google.maps.MapTypeId.ROADMAP
                });
            } else {
                map = new google.maps.Map(document.getElementById('map'), {
                    zoom: 15,
                    center: new google.maps.LatLng(profile.lat, profile.lon),
                    mapTypeId: google.maps.MapTypeId.ROADMAP
                });
            }
            var input = document.getElementById('clzk-profile-address-input');
            var autocomplete = new google.maps.places.Autocomplete(input);
            var infowindow = new google.maps.InfoWindow();
            var marker = new google.maps.Marker({
              map: map,
              visible: true
            });

            autocomplete.bindTo('bounds', map);

            google.maps.event.addListener(autocomplete, 'place_changed', function() {
                infowindow.close();
                marker.setVisible(false);
                input.className = '';
                var place = autocomplete.getPlace();
                if (!place.geometry) {
                    // Inform the user that the place was not found and return.
                    input.className = 'notfound';
                    return;
                }

                // If the place has a geometry, then present it on a map.
                if (place.geometry.viewport) {
                    map.fitBounds(place.geometry.viewport);
                } else {
                    map.setCenter(place.geometry.location);
                    map.setZoom(17);
                }

                // icon that represents the user's position
                var image = {
                    url: place.icon,
                    size: new google.maps.Size(71, 71),
                    origin: new google.maps.Point(0, 0),
                    anchor: new google.maps.Point(17, 34),
                    scaledSize: new google.maps.Size(35, 35)
                };
                marker.setIcon(image);
                marker.setPosition(place.geometry.location);
                marker.setVisible(true);

                var address = '';
                if (place.address_components) {
                    address = [
                      (place.address_components[0] && place.address_components[0].short_name || ''),
                      (place.address_components[1] && place.address_components[1].short_name || ''),
                      (place.address_components[2] && place.address_components[2].short_name || '')
                    ].join(' ');

                    //fill hidden fields
                    for (var i=0, j=place.address_components.length; i<j; i++) {
                        if (place.address_components[i].types.indexOf("street_number") > -1) {
                            $('#profile-coordinates-addressNumber').val(place.address_components[i].long_name);
                            profile.address_number = place.address_components[i].long_name;
                        }
                        if (place.address_components[i].types.indexOf("route") > -1) {
                            $('#profile-coordinates-addressStreet').val(place.address_components[i].long_name);
                            profile.address_street = place.address_components[i].long_name;
                        }
                        if (place.address_components[i].types.indexOf("locality") > -1) {
                            $('#profile-coordinates-addressCity').val(place.address_components[i].long_name);
                            profile.address_city = place.address_components[i].long_name;
                        }
                        if (place.address_components[i].types.indexOf("administrative_area_level_2") > -1) {
                            $('#profile-coordinates-addressDepartment').val(place.address_components[i].long_name);
                            profile.address_department = place.address_components[i].long_name;
                        }
                        if (place.address_components[i].types.indexOf("administrative_area_level_1") > -1) {
                            $('#profile-coordinates-addressRegion').val(place.address_components[i].long_name);
                            profile.address_region = place.address_components[i].long_name;
                        }
                        if (place.address_components[i].types.indexOf("country") > -1) {
                            $('#profile-coordinates-addressCountry').val(place.address_components[i].long_name);
                            profile.address_country = place.address_components[i].long_name;
                        }
                        if (place.address_components[i].types.indexOf("postal_code") > -1) {
                            $('#profile-coordinates-addressZipcode').val(place.address_components[i].long_name);
                            profile.address_zipcode = place.address_components[i].long_name;
                        }
                        if (place.address_components[i].types.indexOf("sublocality") > -1) {
                            $('#profile-coordinates-addressSublocality').val(place.address_components[i].long_name);
                            profile.address_sublocality = place.address_components[i].long_name;
                        }
                    }
                    $('#profile-coordinates-addressCoordinates_longitude').val(place.geometry.location.lng());
                    profile.address_coordinates['y'] = place.geometry.location.lng();
                    $('#profile-coordinates-addressCoordinates_latitude').val(place.geometry.location.lat());
                    profile.address_coordinates.x = place.geometry.location.lat();
                }
                infowindow.setContent(place.name + ':<br>' + address);
                infowindow.open(map, marker);
            });

            return map;
        },

        // Fonction de callback en cas d’erreur
        errorCallback: function(error) {
            var info = "Erreur lors de la géolocalisation : ";
            switch(error.code) {
            case error.TIMEOUT:
                info += "Cela semble mettre trop de temps...";
            break;
            case error.PERMISSION_DENIED:
            info += "Vous n’avez pas autorisé la géolocalisation";
            break;
            case error.POSITION_UNAVAILABLE:
                info += "La position n’a pu être déterminée";
            break;
            case error.UNKNOWN_ERROR:
            info += "Erreur inconnue";
            break;
            }
            flashMessage('error', info);
        },

        successCallback: function(position) {
            map.setZoom = 17;
            map.panTo(new google.maps.LatLng(position.coords.latitude, position.coords.longitude));
            var marker = new google.maps.Marker({
                position: new google.maps.LatLng(position.coords.latitude, position.coords.longitude),
                map: map
            });
            this.codeLatLng(position.coords.latitude, position.coords.longitude);
        },

        codeLatLng: function(lat, lng) {
            var latlng = new google.maps.LatLng(lat, lng);
            var geocoder = new google.maps.Geocoder();
            geocoder.geocode({'latLng': latlng}, function(results, status) {
                if (status == google.maps.GeocoderStatus.OK) {
                    if (results[1]) {
                        //find country name
                        for (var i=0, j=results[0].address_components.length; i<j; i++) {
                            // for (var b=0, c=results[0].address_components[i].types.length; b<c; b++) {

                                //there are different types that might hold a city admin_area_lvl_1 usually does in come cases looking for sublocality type will be more appropriate
                                // if (results[0].address_components[i].types[b] == "locality") {
                                if (results[0].address_components[i].types.indexOf("locality") > -1) {
                                    //this is the object you are looking for
                                    city = results[0].address_components[i].long_name+", ";
                                    break;
                                }
                                // if (results[0].address_components[i].types[b] == "administrative_area_level_2") {
                                if (results[0].address_components[i].types.indexOf("administrative_area_level_2") > -1) {
                                    //this is the object you are looking for
                                    city += results[0].address_components[i].long_name+", ";
                                    break;
                                }
                                // if (results[0].address_components[i].types[b] == "country") {
                                if (results[0].address_components[i].types.indexOf("country") > -1) {
                                    //this is the object you are looking for
                                    city += results[0].address_components[i].long_name;
                                    break;
                                }
                            // }
                        }
                        $('#clzk-profile-address-input').val(city);
                    } else {
                        alert("No results found");
                    }
                } else {
                    alert("Geocoder failed due to: " + status);
                }
            });
        }
    });
});
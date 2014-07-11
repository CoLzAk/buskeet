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
        },
        serializeData: function() {
            return {
                profile: this.model.toJSON()
            };
        }
    });

    ProfileInformationsFormView = Backbone.Marionette.ItemView.extend({
        template: '#clzk-profile-informations-form-template',
        bindings: {
            '#clzk-profile-birthdate': 'birthdate',
            '#clzk-profile-street-number': 'street_number',
            '#clzk-profile-route': 'route',
            '#clzk-profile-city': 'locality',
            '#clzk-profile-sublocality': 'sublocality',
            '#clzk-profile-administrative-area-level-1': 'administrative_area_level_1',
            '#clzk-profile-administrative-area-level-2': 'administrative_area_level_2',
            '#clzk-profile-country': 'country',
            '#clzk-profile-postal-code': 'postal_code',
            '#clzk-profile-lat': 'coordinates.y',
            '#clzk-profile-lon': 'coordinates.x',
            '#clzk-profile-description': 'description'
        },
        events: {
            'click .cancel-button': 'cancel',
            'change .birthdate-selector': 'setBirthdate',
            'change #clzk-profile-description': 'save'
        },
        save: function() {
            NProgress.start();
            var that = this;
            this.model.save({}, {
                success: function(model, response) {
                    that.render();
                    NProgress.done();
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
            var birthdate = moment(this.model.get('birthdate'), "YYYY-MM-DD").format("DD/MM/YYYY").split('/');
            $('#birthdate-day-selector').val(birthdate[0]);
            $('#birthdate-month-selector').val(parseInt(birthdate[1]));
            $('#birthdate-year-selector').val(birthdate[2]);
            that.initMap();
        },
        serializeData: function() {
            return {
                profile: this.model.toJSON(),
                dayRange: this.getDays(),
                monthRange: this.getMonths(),
                yearRange: this.getYears()
            };
        },
        setBirthdate: function(e) {
            var birthdate,
                daySelected = $('#birthdate-day-selector').val(),
                monthSelected = $('#birthdate-month-selector').val(),
                yearSelected = $('#birthdate-year-selector').val();

            birthdate = daySelected + '/0' + monthSelected + '/' + yearSelected;
            this.model.set('birthdate', moment(birthdate, "DD/MM/YYYY").format("YYYY-MM-DD"));
            this.save();
        },
        getDays: function() {
            return ['01', '02', '03', '04', '05', '06', '07', '08', '09', '10', '11', '12', '13', '14', '15', '16', '17', '18', '19', '20', '21', '22', '23', '24', '25', '26', '27', '28', '29', '30', '31'];
        },
        getMonths: function() {
            return {'1':'jan','2':'feb','3':'mar','4':'apr','5':'may','6':'jun','7':'jul','8':'aug','9':'sep','10':'oct','11':'nov','12':'dec'};
        },
        getYears: function() {
            var years = [],
                date = new Date(),
                yearMin = date.getFullYear()-70,
                yearMax = date.getFullYear()-16;
            for (var i = yearMin; i <= yearMax; i++) {
                years.push(i);
            }
            return years;
        },
        initMap: function() {
            var profile = this.model.toJSON(),
                coordinates = this.model.get('coordinates'),
                mapWidth = $('#map-container').width(),
                mapUrl,
                input = document.getElementById('clzk-profile-address-input'),
                autocomplete = new google.maps.places.Autocomplete(input),
                place,
                center,
                that = this,
                completeAddress = '';

            // fill the address if user has defined it
            if ($('#clzk-profile-street-number').val() !== '') completeAddress += $('#clzk-profile-street-number').val() + ' ';
            if ($('#clzk-profile-route').val() !== '') completeAddress += $('#clzk-profile-route').val() + ', ';
            if ($('#clzk-profile-postal-code').val() !== '') completeAddress += $('#clzk-profile-postal-code').val() + ', ';
            if ($('#clzk-profile-sublocality').val() !== '') completeAddress += $('#clzk-profile-sublocality').val() + ', ';
            if ($('#clzk-profile-city').val() !== '') completeAddress += $('#clzk-profile-city').val() + ', ';
            if ($('#clzk-profile-country').val() !== '') completeAddress += $('#clzk-profile-country').val();

            if (completeAddress != '') {
                $('#clzk-profile-address-input').val(completeAddress);
            }

            //Show the map
            mapUrl = 'http://maps.googleapis.com/maps/api/staticmap?center='+ (typeof coordinates !== 'undefined' ? coordinates.y : 47.00) +','+ (typeof coordinates !== 'undefined' ? coordinates.x : 2.00) +'&zoom='+ (typeof coordinates !== 'undefined' ? 14 : 5) +'&size='+ mapWidth +'x250&maptype=roadmap&markers=color:red|'+ (typeof coordinates !== 'undefined' ? coordinates.y : 47.00) +','+ (typeof coordinates !== 'undefined' ? coordinates.x : 2.00) +'&sensor=false&scale=1';

            $('#map').html('<img src="'+ mapUrl +'">');

            //Bind the input with autocomplete function
            google.maps.event.addListener(autocomplete, 'place_changed', function() {
                NProgress.start();
                $('#clzk-profile-street-number').val('').trigger('change');
                $('#clzk-profile-route').val('').trigger('change');
                $('#clzk-profile-city').val('').trigger('change');
                $('#clzk-profile-sublocality').val('').trigger('change');
                $('#clzk-profile-postal-code').val('').trigger('change');
                $('#clzk-profile-administrative-area-level-1').val('').trigger('change');
                $('#clzk-profile-administrative-area-level-2').val('').trigger('change');
                $('#clzk-profile-country').val('').trigger('change');
                $('#clzk-profile-lat').val('').trigger('change');
                $('#clzk-profile-lon').val('').trigger('change');
                // $('#profile-coordinates-addressCoordinates_latitude').val('').trigger('change');
                // $('#profile-coordinates-addressAccuracy').val('').trigger('change');
                // infowindow.close();
                // marker.setVisible(false);

                place = autocomplete.getPlace();
                if (!place.geometry) {
                    // Inform the user that the place was not found and return.
                    console.log('place not found');
                    NProgress.done();
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
                                $('#clzk-profile-street-number').val(place.address_components[i].long_name).trigger('change');
                            }
                            if (place.address_components[i].types.indexOf("route") > -1) {
                                $('#clzk-profile-route').val(place.address_components[i].long_name).trigger('change');
                            }
                            if (place.address_components[i].types.indexOf("locality") > -1) {
                                $('#clzk-profile-city').val(place.address_components[i].long_name).trigger('change');
                            }
                            if (place.address_components[i].types.indexOf("administrative_area_level_2") > -1) {
                                $('#clzk-profile-administrative-area-level-2').val(place.address_components[i].long_name).trigger('change');
                            }
                            if (place.address_components[i].types.indexOf("administrative_area_level_1") > -1) {
                                $('#clzk-profile-administrative-area-level-1').val(place.address_components[i].long_name).trigger('change');
                            }
                            if (place.address_components[i].types.indexOf("country") > -1) {
                                $('#clzk-profile-country').val(place.address_components[i].long_name).trigger('change');
                            }
                            if (place.address_components[i].types.indexOf("postal_code") > -1) {
                                $('#clzk-profile-postal-code').val(place.address_components[i].long_name).trigger('change');
                            }
                            if (place.address_components[i].types.indexOf("sublocality") > -1) {
                                $('#clzk-profile-sublocality').val(place.address_components[i].long_name).trigger('change');
                            }
                        }
                        console.log(place.geometry.location.lat());
                        $('#clzk-profile-lon').val(place.geometry.location.lng()).trigger('change');
                        $('#clzk-profile-lat').val(place.geometry.location.lat()).trigger('change');

                        mapUrl = 'http://maps.googleapis.com/maps/api/staticmap?center='+ place.geometry.location.lat() +','+ place.geometry.location.lng() +'&zoom=14&size='+mapWidth+'x250&maptype=roadmap&markers=color:red|'+ place.geometry.location.lat() +','+ place.geometry.location.lng() +'&sensor=false';

                        $('#map').html('<img src="'+ mapUrl +'">');

                        // console.log(that.model);
                        that.model.save({}, {
                            success: function() {
                                NProgress.done();
                            }
                        });
                    }
                }
            });
        }
    });
});
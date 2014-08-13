App.module("UserModule", function(UserModule, App, Backbone, Marionette, $, _){
    
    ProfileEventView = Backbone.Marionette.ItemView.extend({
        template: '#clzk-profile-event-template',
        tagName: 'div',
        className: 'bg-dark',
        bindings: {
            '#clzk-profile-event-date-month': {
                observe: 'date',
                onGet: function(value) {
                    if(value.length > 0) {
                        return moment(value, "YYYY-MM-DD").format("MMMM");
                    } else {
                        return undefined;
                    }
                }
            },
            '#clzk-profile-event-date-day': {
                observe: 'date',
                onGet: function(value) {
                    if(value.length > 0) {
                        return moment(value, "YYYY-MM-DD").format("DD");
                    } else {
                        return undefined;
                    }
                }
            },
            '#clzk-profile-event-date-year': {
                observe: 'date',
                onGet: function(value) {
                    if(value.length > 0) {
                        return moment(value, "YYYY-MM-DD").format("YYYY");
                    } else {
                        return undefined;
                    }
                }
            },
            '#clzk-profile-event-time': 'time',
            '#clzk-profile-event-title': 'title',
            '#clzk-profile-event-content': 'content'
        },
        onRender: function() {
            this.stickit();
        },
        serializeData: function() {
            console.log(this.model);
            var completeAddress = '';
            if (this.model.get('street_number') !== '') completeAddress += this.model.get('street_number') + ' ';
            if (this.model.get('route') !== '') completeAddress += this.model.get('route') + ', ';
            // if (this.model.get('postal_code') !== '') completeAddress += this.model.get('postal_code') + ', ';
            if (this.model.get('sublocality') !== '') completeAddress += this.model.get('sublocality') + ', ';
            if (this.model.get('locality') !== '') completeAddress += this.model.get('locality') + ', ';
            if (this.model.get('country') !== '') completeAddress += this.model.get('country');
            return {
                userEvent: this.model.toJSON(),
                completeAddress: completeAddress
            };
        }
    });

    ProfileEventEmptyView = Backbone.Marionette.ItemView.extend({
        template: '#clzk-profile-event-empty-template'
    });

    ProfileEventsView = Backbone.Marionette.CompositeView.extend({
        template: '#clzk-profile-events-template',
        itemView: ProfileEventView,
        emptyView: ProfileEventEmptyView,
        tagName: 'div',
        itemViewContainer: function() {
            return '#clzk-profile-events-container';
        }
    });

    ProfileEventFormView = Backbone.Marionette.ItemView.extend({
        template: '#clzk-profile-event-form-template',
        tagName: 'div',
        className: 'col-md-8 bg-dark mb1',
        events : {
            'click .delete-event-button': 'deleteEvent'
        },
        bindings: {
            '#clzk-profile-event-date-month': {
                observe: 'date',
                onGet: function(value) {
                    if(value.length > 0) {
                        return moment(value, "YYYY-MM-DD").format("MMMM");
                    } else {
                        return undefined;
                    }
                }
            },
            '#clzk-profile-event-date-day': {
                observe: 'date',
                onGet: function(value) {
                    if(value.length > 0) {
                        return moment(value, "YYYY-MM-DD").format("DD");
                    } else {
                        return undefined;
                    }
                }
            },
            '#clzk-profile-event-date-year': {
                observe: 'date',
                onGet: function(value) {
                    if(value.length > 0) {
                        return moment(value, "YYYY-MM-DD").format("YYYY");
                    } else {
                        return undefined;
                    }
                }
            },
            '#clzk-profile-event-time': 'time',
            '#clzk-profile-event-title': 'title',
            '#clzk-profile-event-content': 'content'
        },
        deleteEvent: function(e) {
            e.preventDefault();
            NProgress.start();
            this.model.destroy({
                success: function(response, data) {
                    // UserModule.closeFormView();
                    // Backbone.history.navigate(UserModule.targetUserUsername, { trigger: true });
                    UserModule.targetUserProfile.set('events', data);
                    // that.render();
                    $('.message-sign').removeClass().addClass('message-sign glyphicon glyphicon-ok-sign');
                    $('.message-text').html('Les modifications ont été enregistrées !')
                    $('.clzk-flash-messages-container').removeClass().addClass('clzk-flash-messages-container alert alert-success');
                    $('.clzk-flash-messages-container').fadeIn( 400 ).delay( 3000 ).fadeOut( 400 );
                    NProgress.done();
                },
                error: function(response) {
                    // that.render();
                    $('.message-sign').removeClass().addClass('message-sign glyphicon glyphicon-remove-sign');
                    $('.message-text').html('Une erreur est survenue. Veuillez réessayer ultérieurement ou contacter le support')
                    $('.clzk-flash-messages-container').removeClass().addClass('clzk-flash-messages-container alert alert-danger');
                    $('.clzk-flash-messages-container').fadeIn( 400 ).delay( 3000 ).fadeOut( 400 );
                    NProgress.done();
                }
            });
        },
        onRender: function() {
            this.stickit();
        },
        serializeData: function() {
            var completeAddress = '';
            if (this.model.get('street_number') !== '') completeAddress += this.model.get('street_number') + ' ';
            if (this.model.get('route') !== '') completeAddress += this.model.get('route') + ', ';
            // if (this.model.get('postal_code') !== '') completeAddress += this.model.get('postal_code') + ', ';
            if (this.model.get('sublocality') !== '') completeAddress += this.model.get('sublocality') + ', ';
            if (this.model.get('locality') !== '') completeAddress += this.model.get('locality') + ', ';
            if (this.model.get('country') !== '') completeAddress += this.model.get('country');

            return {
                completeAddress: completeAddress
            };
        }
    });

    ProfileEventsFormView = Backbone.Marionette.CompositeView.extend({
        template: '#clzk-profile-events-form-template',
        tagName: 'div',
        itemView: ProfileEventFormView,
        events: {
            'click .show-add-event-form-button': 'showAddEventForm',
            'click .cancel-event-button': 'hideAddEventForm',
            'click .add-event-button': 'addEvent',
            'click .cancel-button': 'cancel'
        },
        itemViewContainer: function() {
            return '#clzk-profile-events-form-container';
        },
        save: function() {
            var i = 1, that = this;
            NProgress.start();

            this.collection.each(function(model) {
                if (i === that.collection.length) {
                    model.save({}, {
                        success: function(model, response) {
                            // UserModule.closeFormView();
                            // Backbone.history.navigate(UserModule.targetUserUsername, { trigger: true });
                            UserModule.targetUserProfile.set('events', that.collection.toJSON());
                            that.render();
                            $('.message-sign').removeClass().addClass('message-sign glyphicon glyphicon-ok-sign');
                            $('.message-text').html('Les modifications ont été enregistrées !')
                            $('.clzk-flash-messages-container').removeClass().addClass('clzk-flash-messages-container alert alert-success');
                            $('.clzk-flash-messages-container').fadeIn( 400 ).delay( 3000 ).fadeOut( 400 );
                            NProgress.done();
                        },
                        error: function(response) {
                            that.render();
                            $('.message-sign').removeClass().addClass('message-sign glyphicon glyphicon-remove-sign');
                            $('.message-text').html('Une erreur est survenue. Veuillez réessayer ultérieurement ou contacter le support')
                            $('.clzk-flash-messages-container').removeClass().addClass('clzk-flash-messages-container alert alert-danger');
                            $('.clzk-flash-messages-container').fadeIn( 400 ).delay( 3000 ).fadeOut( 400 );
                            NProgress.done();
                        }
                    });
                } else {
                    model.save();
                }
                i++;
            });
        },
        cancel: function(e) {
            e.preventDefault();
            UserModule.closeFormView();
            Backbone.history.navigate(UserModule.targetUserUsername, { trigger: true });
        },
        showAddEventForm: function(e) {
            e.preventDefault();
            $('#show-add-event-form').removeClass('hidden');

        },
        hideAddEventForm: function(e) {
            e.preventDefault();
            $('#show-add-event-form').addClass('hidden');
        },
        addEvent: function(e) {
            var profileEvent = new ProfileEvent({}, { userId: UserModule.userId }),
                eventTitle = $('#new-event-title-input').val(),
                eventStreetNumber = $('#clzk-new-event-street-number').val(),
                eventRoute = $('#clzk-new-event-route').val(),
                eventCity = $('#clzk-new-event-city').val(),
                eventSublocality = $('#clzk-new-event-sublocality').val(),
                eventPostalCode = $('#clzk-new-event-postal-code').val(),
                eventAdministrativeAreaLevel1 = $('#clzk-new-event-administrative-area-level-1').val(),
                eventAdministrativeAreaLevel2 = $('#clzk-new-event-administrative-area-level-2').val(),
                eventCountry = $('#clzk-new-event-country').val(),
                eventLat = $('#clzk-new-event-lat').val(),
                eventLon = $('#clzk-new-event-lon').val(),

                eventContent = $('#new-event-content-input').val(),
                eventDate = ($('#new-event-date-input').val().length > 0 ? moment($('#new-event-date-input').val(), "DD/MM/YYYY").format("YYYY-MM-DD") : undefined),
                eventTime = ($('#new-event-time-input').val().length > 0 ? $('#new-event-time-input').val() : undefined);
            e.preventDefault();


            
            profileEvent.set('title', eventTitle);
            profileEvent.set('content', eventContent);
            if (typeof eventDate !== 'undefined') {
                profileEvent.set('date', eventDate);
            }
            if (typeof eventTime !== 'undefined') {
                profileEvent.set('time', eventTime);
            }
            profileEvent.set('street_number', eventStreetNumber);
            profileEvent.set('route', eventRoute);
            profileEvent.set('locality', eventCity);
            profileEvent.set('sublocality', eventSublocality);
            profileEvent.set('postal_code', eventPostalCode);
            profileEvent.set('administrative_area_level_2', eventAdministrativeAreaLevel2);
            profileEvent.set('administrative_area_level_1', eventAdministrativeAreaLevel1);
            profileEvent.set('country', eventCountry);
            profileEvent.set('coordinates', { x: eventLon, y: eventLat });
            
            this.collection.add(profileEvent);

            this.save();
        },
        onDomRefresh: function() {
            $('.datepicker').datepicker({
                dateFormat: 'dd/mm/yy',
                closeText: 'Fermer',
                prevText: 'Précédent',
                nextText: 'Suivant',
                currentText: 'Aujourd\'hui',
                monthNames: ['Janvier', 'Février', 'Mars', 'Avril', 'Mai', 'Juin', 'Juillet', 'Août', 'Septembre', 'Octobre', 'Novembre', 'Décembre'],
                monthNamesShort: ['Janv.', 'Févr.', 'Mars', 'Avril', 'Mai', 'Juin', 'Juil.', 'Août', 'Sept.', 'Oct.', 'Nov.', 'Déc.'],
                dayNames: ['Dimanche', 'Lundi', 'Mardi', 'Mercredi', 'Jeudi', 'Vendredi', 'Samedi'],
                dayNamesShort: ['Dim.', 'Lun.', 'Mar.', 'Mer.', 'Jeu.', 'Ven.', 'Sam.'],
                dayNamesMin: ['D', 'L', 'M', 'M', 'J', 'V', 'S'],
                weekHeader: 'Sem.'
            });
            $('.timepicker').timepicker({
                'timeFormat': 'H:i'
            });
            this.initMap();
        },
        initMap: function() {
            var mapWidth = Math.round($('#event-map-container').width() * 3),
                mapUrl,
                input = document.getElementById('clzk-new-event-place-input'),
                autocomplete = new google.maps.places.Autocomplete(input),
                place,
                center;

            // var mapWidth = 500;

            mapUrl = 'http://maps.googleapis.com/maps/api/staticmap?center=47,2&zoom=5&size='+ mapWidth +'x150&maptype=roadmap&sensor=false&scale=1';

            $('#event-map').html('<img src="'+ mapUrl +'">');

            //Bind the input with autocomplete function
            google.maps.event.addListener(autocomplete, 'place_changed', function() {
                place = autocomplete.getPlace();
                if (!place.geometry) {
                    // Inform the user that the place was not found and return.
                    $('.message-sign').removeClass().addClass('message-sign glyphicon glyphicon-question-sign');
                    $('.message-text').html('Aucune adresse trouvée. Veuillez réessayer')
                    $('.clzk-flash-messages-container').removeClass().addClass('clzk-flash-messages-container alert alert-info');
                    $('.clzk-flash-messages-container').fadeIn( 400 ).delay( 3000 ).fadeOut( 400 );
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
                                $('#clzk-new-event-street-number').val(place.address_components[i].long_name);
                            }
                            if (place.address_components[i].types.indexOf("route") > -1) {
                                $('#clzk-new-event-route').val(place.address_components[i].long_name);
                            }
                            if (place.address_components[i].types.indexOf("locality") > -1) {
                                $('#clzk-new-event-city').val(place.address_components[i].long_name);
                            }
                            if (place.address_components[i].types.indexOf("administrative_area_level_2") > -1) {
                                $('#clzk-new-event-administrative-area-level-2').val(place.address_components[i].long_name);
                            }
                            if (place.address_components[i].types.indexOf("administrative_area_level_1") > -1) {
                                $('#clzk-new-event-administrative-area-level-1').val(place.address_components[i].long_name);
                            }
                            if (place.address_components[i].types.indexOf("country") > -1) {
                                $('#clzk-new-event-country').val(place.address_components[i].long_name);
                            }
                            if (place.address_components[i].types.indexOf("postal_code") > -1) {
                                $('#clzk-new-event-postal-code').val(place.address_components[i].long_name);
                            }
                            if (place.address_components[i].types.indexOf("sublocality") > -1) {
                                $('#clzk-new-event-sublocality').val(place.address_components[i].long_name);
                            }
                        }
                        $('#clzk-new-event-lon').val(place.geometry.location.lng());
                        $('#clzk-new-event-lat').val(place.geometry.location.lat());

                        mapUrl = 'http://maps.googleapis.com/maps/api/staticmap?center='+ place.geometry.location.lat() +','+ place.geometry.location.lng() +'&zoom=14&size='+mapWidth+'x150&maptype=roadmap&markers=color:red|'+ place.geometry.location.lat() +','+ place.geometry.location.lng() +'&sensor=false';

                        $('#event-map').html('<img src="'+ mapUrl +'">');
                    }
                }
            });
        }
    });
});
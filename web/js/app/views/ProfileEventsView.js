App.module("UserModule", function(UserModule, App, Backbone, Marionette, $, _){
    
    ProfileEventView = Backbone.Marionette.ItemView.extend({
        template: '#clzk-profile-event-template',
        tagName: 'div',
        className: 'bg-dark',
        bindings: {
            '#clzk-profile-event-start-date': {
                observe: 'start_date',
                onGet: function(value) {
                    if(value.length > 0) {
                        return moment(value, "YYYY-MM-DD\\THH:mm:ssZZ").format("DD/MM/YYYY");
                    } else {
                        return undefined;
                    }
                },
                onSet: function(value) {
                    return moment(value, "DD/MM/YYYY").format("YYYY-MM-DD\\THH:mm:ssZZ");
                }
            },
            '#clzk-profile-event-end-date': {
                observe: 'end_date',
                onGet: function(value) {
                    if(value.length > 0) {
                        return moment(value, "YYYY-MM-DD\\THH:mm:ssZZ").format("DD/MM/YYYY");
                    } else {
                        return undefined;
                    }
                },
                onSet: function(value) {
                    return moment(value, "DD/MM/YYYY").format("YYYY-MM-DD\\THH:mm:ssZZ");
                }
            },
            '#clzk-profile-event-title': 'title',
            '#clzk-profile-event-content': 'content'
        },
        onRender: function() {
            this.stickit();
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
        className: 'col-md-12 bg-dark mb1',
        bindings: {
            '#clzk-profile-event-title-input': 'title',
            '#clzk-profile-event-content-input': 'content',
            '#clzk-profile-event-start-date-input': {
                observe: 'start_date',
                onGet: function(value) {
                    if(value.length > 0) {
                        return moment(value, "YYYY-MM-DD\\THH:mm:ssZZ").format("DD/MM/YYYY");
                    } else {
                        return undefined;
                    }
                },
                onSet: function(value) {
                    return moment(value, "DD/MM/YYYY").format("YYYY-MM-DD\\THH:mm:ssZZ");
                }
            },
            '#clzk-profile-event-end-date-input': {
                observe: 'end_date',
                onGet: function(value) {
                    if(value.length > 0) {
                        return moment(value, "YYYY-MM-DD\\THH:mm:ssZZ").format("DD/MM/YYYY");
                    } else {
                        return undefined;
                    }
                },
                onSet: function(value) {
                    return moment(value, "DD/MM/YYYY").format("YYYY-MM-DD\\THH:mm:ssZZ");
                }
            }
        },
        onRender: function() {
            this.stickit();
        },
        onDomRefresh: function() {
            $('.datepicker').datepicker({
                dateFormat: 'dd/mm/yy'
            });
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
            'click .save-button': 'save',
            'click .cancel-button': 'cancel'
        },
        itemViewContainer: function() {
            return '#clzk-profile-events-form-container';
        },
        save: function(e) {
            var i = 1, that = this;
            NProgress.start();
            e.preventDefault();

            this.collection.each(function(model) {
                console.log('i > ', i);
                console.log(that.collection.length);
                if (i === that.collection.length) {
                    model.save({}, {
                        success: function(model, response) {
                            UserModule.closeFormView();
                            Backbone.history.navigate(UserModule.targetUserUsername, { trigger: true });
                            NProgress.done();
                        }
                    })
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
                eventContent = $('#new-event-content-input').val(),
                eventStartDate = ($('#new-event-start-date-input').val().length > 0 ? moment($('#new-event-start-date-input').val(), "DD/MM/YYYY").format("YYYY-MM-DD\\THH:mm:ssZZ") : '');
                eventEndDate = ($('#new-event-end-date-input').val().length > 0 ? moment($('#new-event-end-date-input').val(), "DD/MM/YYYY").format("YYYY-MM-DD\\THH:mm:ssZZ") : '');
            e.preventDefault();
            
            profileEvent.set('title', eventTitle);
            profileEvent.set('content', eventContent);
            profileEvent.set('start_date', eventStartDate);
            profileEvent.set('end_date', eventEndDate);

            this.collection.add(profileEvent);
            this.render();
        }
    });
});
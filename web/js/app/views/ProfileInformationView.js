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
            this.initMap();
            $('.datepicker').datepicker({
                dateFormat: 'dd/mm/yy'
            });
        },
        initialize: function() {
            var lat = this.model.get('profile').address.lat;
            // this.map = L.map('map')
        }
        initMap: function(lat, lon) {
            //set location to london
            if (typeof lat === 'undefined')
                lat = 51.505;

            if (typeof lon === 'undefined')
                lon = -0.09;
            var map = L.map('map').setView([lat, lon], 13);
            L.tileLayer('http://{s}.tile.cloudmade.com/0141904cfe59413f8a10df5a6e5352a5/997/256/{z}/{x}/{y}.png', {
                attribution: 'Map data &copy; <a href="http://openstreetmap.org">OpenStreetMap</a> contributors, <a href="http://creativecommons.org/licenses/by-sa/2.0/">CC-BY-SA</a>, Imagery © <a href="http://cloudmade.com">CloudMade</a>',
                maxZoom: 18
            }).addTo(map);
            //equivalent to googlemap resize on dialog
            L.Util.requestAnimFrame(map.invalidateSize,map,!1,map._container);
        },
        geocode: function(e) {
            var that = this;
            e.preventDefault();
            //Call ajax function to get the place geocoding
            $.ajax({
                type: 'GET',
                url: 'http://nominatim.openstreetmap.org/search?q=' + $('#clzk-profile-address-input').val() + '&format=json&countrycodes=fr&viewbox=bottom&limit=1&addressdetails=1',
                success: function(data) {
                    that.initMap(data[0].lat, data[1].lon);
                    // var html = '';
                    // for (var i in data) {
                    //     html += '<li class="list-group-item list-group-item-instruments" data-id="' + data[i].id + '" data-name="' + data[i].name + '" data-adjective="' + data[i].adjective + '" data-instrumenttypeid="' + data[i].instrumentType.id + '" data-instrumenttypecategory="' + data[i].instrumentType.category + '">'+ data[i].name +'</li>';
                    // }
                    // $('#profile-portfolio-instruments-results').html(html);
                    // $('#profile-portfolio-instruments-results').show();
                },
                error: function(jqXHR, textStatus, errorThrown) {
                    console.log(data);
                }
            });
        }
    });
});
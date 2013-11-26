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
            'click .close-modal-btn': 'closeModal'
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
        initMap: function() {
            //set location to london
            var map = L.map('map').setView([51.505, -0.09], 13);
            L.tileLayer('http://{s}.tile.cloudmade.com/0141904cfe59413f8a10df5a6e5352a5/997/256/{z}/{x}/{y}.png', {
                attribution: 'Map data &copy; <a href="http://openstreetmap.org">OpenStreetMap</a> contributors, <a href="http://creativecommons.org/licenses/by-sa/2.0/">CC-BY-SA</a>, Imagery © <a href="http://cloudmade.com">CloudMade</a>',
                maxZoom: 18
            }).addTo(map);
            //equivalent to googlemap resize on dialog
            L.Util.requestAnimFrame(map.invalidateSize,map,!1,map._container);
        }
    });
});
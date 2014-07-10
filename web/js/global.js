$(document).ready(function() {
    NProgress.configure({ 
        showSpinner: false,
        ease: 'ease',
        speed: 1000
    });

    $('#login-button').on('click', function(e) {
        $('#login-form').submit();
    });

    //Init googlePlaceAutocomplete on cn-search-form-localization input
    var input = document.getElementById('clzk-search-input'),
        autocomplete = new google.maps.places.Autocomplete(input),
        addressNumber = $('#clzk-search-addressNumber'),
        addressStreet = $('#clzk-search-addressStreet'),
        addressCity = $('#clzk-search-addressCity'),
        addressCountry = $('#clzk-search-addressCountry'),
        addressZipcode = $('#clzk-search-addressZipcode'),
        addressSublocality = $('#clzk-search-addressSublocality');

    // $(input).on('click', function(e) {
    //     $(input).val('');
    // });

    // if (navigator.geolocation) {
    //     $.get("http://ipinfo.io", function(response) {
    //         addressCity.val(response.city);
    //         addressCountry.val(response.country);
    //         $('#clzk-search-input').val(response.city);
    //     }, "jsonp").done(function() { 
    //         $('.clzk-geoloader').addClass('hidden');
    //     });
        
    // }

    $('.clzk-search-form-geolocation-btn').on('click', function(e) {
        e.preventDefault();
        $('.clzk-geoloader').removeClass('hidden');
        //Check if browser supports W3C Geolocation API
        if (navigator.geolocation) {
            $.get("http://ipinfo.io", function(response) {
                addressCity.val(response.city);
                addressCountry.val(response.country);
                $('#clzk-search-input').val(response.city);
            }, "jsonp").done(function() { 
                $('.clzk-geoloader').addClass('hidden');
            });
            
        } else {
            alert('Your browser does not support geolocation');
        }
    });

    google.maps.event.addListener(autocomplete, 'place_changed', function() {
        var place = autocomplete.getPlace();
            addressNumber.val('');
            addressStreet.val('');
            addressCity.val('');
            addressCountry.val('');
            addressZipcode.val('');
            addressSublocality.val('');

        // if (!place.geometry) {
        //     // Inform the user that the place was not found and return.
        //     input.className = 'notfound';
        //     return;
        // }

        var address = '';
        if (place.address_components) {
            address = [
              (place.address_components[0] && place.address_components[0].short_name || ''),
              (place.address_components[1] && place.address_components[1].short_name || ''),
              (place.address_components[2] && place.address_components[2].short_name || '')
            ].join(' ');

            for (var i=0, j=place.address_components.length; i<j; i++) {
                if (place.address_components[i].types.indexOf("street_number") > -1) {
                    addressNumber.val(place.address_components[i].long_name);
                }
                if (place.address_components[i].types.indexOf("route") > -1) {
                    addressStreet.val(place.address_components[i].long_name);
                }
                if (place.address_components[i].types.indexOf("locality") > -1) {
                    addressCity.val(place.address_components[i].long_name);
                }
                if (place.address_components[i].types.indexOf("sublocality") > -1) {
                    addressSublocality.val(place.address_components[i].long_name);
                }
                if (place.address_components[i].types.indexOf("country") > -1) {
                    addressCountry.val(place.address_components[i].long_name);
                }
                if (place.address_components[i].types.indexOf("postal_code") > -1) {
                    addressZipcode.val(place.address_components[i].long_name);
                }
            }
        }
    });

    $("#clzk-search-input").bind("keypress", function(event) {
        if(event.which == 13) {
            event.preventDefault();
            // alert('tesjklmfdjs');
            submitSearchForm();
        }
    });

    $('.clzk-search-form-submit-btn').on('click', function(e) {
        e.preventDefault();
        submitSearchForm();
    });

    function submitSearchForm() {
        var localization = ''

        if (addressNumber.val() !== '') localization += addressNumber.val() + '-';
        if (addressStreet.val() !== '') localization += addressStreet.val().replace(/ /g, '-') + '--';
        if (addressZipcode.val() !== '') localization += addressZipcode.val() + '-';
        if (addressSublocality.val() !== '') localization += addressSublocality.val().replace(/ /g, '-') + '-';
        if (addressCity.val() !== '') localization += addressCity.val().replace(/ /g, '-') + '--';
        if (addressCountry.val() !== '') localization += addressCountry.val();

        if (localization === '') {
            localization = $('#clzk-search-input').val().replace(/,/g, '-').replace(/ /g, '-');
        }

        window.location.href = Routing.generate('colzak_search_result', { localization: localization });
    }
});
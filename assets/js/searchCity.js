import places from "places.js";

(function() {
    
    // https://community.algolia.com/places/
    let placesAutocomplete = places({
        container: document.querySelector('#app_user_registration_city'),
        type: 'city',
        language: 'fr',
        countries: 'fr',
        templates: {
            value: function(suggestion) {
                return suggestion.name; 
            }
        },
        aroundLatLngViaIP: false
    });
    placesAutocomplete.on('change', function resultSelected(e) {
        document.querySelector('#app_user_registration_latitude').value = e.suggestion.latlng.lat || '';
        document.querySelector('#app_user_registration_longitude').value = e.suggestion.latlng.lng || '';
        document.querySelector('#app_user_registration_codePostal').value = e.suggestion.postcode || '';
    });
})();

  



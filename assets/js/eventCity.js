import places from "places.js";

(function() {

    // https://community.algolia.com/places/
    let placesAutocomplete = places({
        container: document.querySelector('#appbundle_event_city'),
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
        document.querySelector('#appbundle_event_latitude').value = e.suggestion.latlng.lat || '';
        document.querySelector('#appbundle_event_longitude').value = e.suggestion.latlng.lng || '';
        document.querySelector('#appbundle_event_CodePostal').value = e.suggestion.postcode || '';
    });
})();

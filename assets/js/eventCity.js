import places from "places.js";

(function() {

    // https://community.algolia.com/places/
    let placesAutocomplete = places({
        container: searchBar,
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
        latitude.value = e.suggestion.latlng.lat || '';
        longitude.value = e.suggestion.latlng.lng || '';
        codePostal.value = e.suggestion.postcode || '';
    });
})();

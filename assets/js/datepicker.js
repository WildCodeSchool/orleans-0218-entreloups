import flatpickr from 'flatpickr'
import {French} from 'flatpickr/dist/l10n/fr.js'

flatpickr('.flatpickr', {
    utc: false,
    locale: French,
    altInput: true,
    enableTime: true,
    altFormat: 'J F Y - H:i',
    time_24hr: true
});
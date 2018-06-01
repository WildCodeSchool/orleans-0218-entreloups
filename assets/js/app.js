import $ from "jquery"

import 'bootstrap/dist/js/bootstrap'

$('.confirm-alert').click(function () {
    return confirm ("Etes-vous sûr(e) de vouloir supprimer cet élément ?");
});
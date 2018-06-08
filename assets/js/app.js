import $ from "jquery"

import 'bootstrap/dist/js/bootstrap'

import './tagsinput'

$('.confirm-alert').click(function () {
    return confirm ("Etes-vous sûr(e) de vouloir supprimer cet élément ?");
});

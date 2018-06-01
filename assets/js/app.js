import $ from "jquery"

import 'bootstrap/dist/js/bootstrap'

let deleteButton = document.getElementsByClassName('confirm-alert');

$(deleteButton).click(function () {
    return confirm ("Etes-vous sûr(e) de vouloir supprimer cet élément ?");
});


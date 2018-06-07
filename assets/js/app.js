import $ from "jquery"

import 'bootstrap/dist/js/bootstrap'

import './tagsinput/bootstrap-tagsinput'

import './tagsinput/typeahead.bundle'

$('.confirm-alert').click(function () {
    return confirm ("Etes-vous sûr(e) de vouloir supprimer cet élément ?");
});

let tags = new Bloodhound({
    prefetch: 'tag/tags.json',
    datumTokenizer: Bloodhound.tokenizers.obj.whitespace('label'),
    queryTokenizer: Bloodhound.tokenizers.whitespace,
});

$('.tag-input').tagsinput({
    typeaheadjs: [{
        highlights: true
    },{
        name: 'tags',
        display: 'label',
        value: 'label',
        source: tags
    }]
});


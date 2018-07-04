$( document).ready(function() {
    $('#distance').text(rangeBar.value);
    $(rangeBar).on('input', function() {
        $('#distance').text(this.value);
    });
});

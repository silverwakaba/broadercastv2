$(function () {
    $('span.pagination').hide();

    $('[data-toggle="tooltip"]').tooltip();
    
    $('.select2bs4').select2({
        theme: 'bootstrap4',
    });

    $('.scrolling-pagination').jscroll({
        autoTrigger: true,
        padding: 0,
        contentSelector: 'div.scrolling-pagination',
        callback: function() {
            $('span.pagination').remove();
        }
    });
});
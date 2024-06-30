$(function () {
    $('[data-toggle="tooltip"]').tooltip();
    
    $('.select2bs4').select2({
        theme: 'bootstrap4',
    });

    $('.scrolling-pagination').jscroll({
        // debug: true,
        autoTrigger: true,
        padding: 0,
        nextSelector: 'a.scrolling-paging',
        contentSelector: 'div.scrolling-pagination',
    });
});
$(function () {
    Pusher.logToConsole = true;

    $('[data-toggle="tooltip"]').tooltip();
    
    $('.select2bs4').select2({
        theme: 'bootstrap4',
    });

    $('.scrolling-pagination').jscroll({
        autoTrigger: true,
        padding: 0,
        pagingSelector: 'div.scrolling-paging',
        contentSelector: 'div.scrolling-pagination',
    });
});
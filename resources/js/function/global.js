$(function () {
    $('.scrolling-pagination').jscroll({
        debug: true,
        autoTrigger: true,
        padding: 0,
        nextSelector: 'a.scrolling-paging',
        contentSelector: 'div.scrolling-pagination',
        loadingHtml: '<div class="flex items-center justify-center"><div class="vv-preloader-spikes-roll relative h-10 w-16 animate-spike-roll bg-spike-roll bg-no-repeat"></div></div>',
    });
});
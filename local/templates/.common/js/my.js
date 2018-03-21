$(document).ready( function() {
        $("html").niceScroll({cursorcolor:"#777", cursorwidth:"13px", cursorborderradius:"2px", cursorborder:"1px solid #eee", zindex:"9999"});
        /*$(".collapse").niceScroll({cursorcolor:"#777", cursorwidth:"12px", cursorborderradius:"2px", cursorborder:"1px solid #eee"});*/

        /**/
        $('.datepicker').datepicker({
            format: 'dd.mm.yyyy',
            language: 'ru'
            /* startView: '1' */
            /*startDate: '-3d'*/
        });
});
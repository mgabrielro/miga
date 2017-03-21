var c24_menu            = $('#c24-menu');
var menu_section        = $('#c24-menu .c24-menu-section');
var menu_back           = $('#c24-menu .c24-menu-back');
var menu_product_list   = $('#c24-menu .c24-menu-product-list');
var c24_menu_menu       = $('#c24-menu .c24-menu');
var menu_mk             = $('#c24-menu .c24-menu-mk');
var menu_mk_list        = $('#c24-menu .c24-menu-mk-list');

menu_section.dblclick(function(event) {
    event.preventDefault(); return false;
});

menu_section.click(function() {
    menu_product_list.hide();
    slideEle = '#c24-menu-product-list-' + $(this).data('slide');
    $(slideEle).show();
    c24_menu_menu.addClass('c24-slide');
    if (!c24_menu_menu.is(':animated')) {
        c24_menu_menu.animate({
            left: '-=17em'
        }, 300, function() {
            // Animation complete. Do nothin.
        });
    }
});

menu_back.click(function() {
    c24_menu_menu.removeClass('c24-slide');
    if (!c24_menu_menu.is(':animated')) {
        c24_menu_menu.animate({
            left: '+=17em'
        }, 300, function() {
            menu_product_list.hide();
        });
    }
});

menu_mk.click(function() {
    menu_mk_list.toggle();
    if (menu_mk_list.hasClass('c24-mk-open')) {
        c24_menu_menu.removeClass('c24-mk-open');
        menu_mk_list.removeClass('c24-mk-open');
        menu_mk.removeClass('c24-open');
    } else {
        c24_menu_menu.addClass('c24-mk-open');
        menu_mk_list.addClass('c24-mk-open');
        menu_mk.addClass('c24-open');
    }
});

c24_menu.on('panelclose', function( event, ui ) {
    $('.ui-panel-inner').css('overflow','hidden');
    c24_menu_menu.removeClass('c24-mk-open');
    menu_mk_list.removeClass('c24-mk-open');
    menu_mk.removeClass('c24-open');
    menu_mk_list.hide();
    if ( c24_menu_menu.hasClass('c24-slide')){
        c24_menu_menu.animate({
            left: '+=17em'
        }, 300, function() {
            menu_product_list.hide();
            c24_menu_menu.removeClass('c24-slide');
        });
    }
});

c24_menu.on('panelopen', function( event, ui ) {
    $('.ui-panel-inner').css('overflow','scroll');
});
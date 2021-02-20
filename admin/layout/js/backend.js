$( document ).ready(function() {


    // dashbored
    $('.toggle-info').click(function(){
        $(this).toggleClass("selected").parent().next('.panel-body').fadeToggle(500);
        if($(this).hasClass('selected')){
            $(this).html('<i class="fa fa-minus fa-lg"></i>');
        }else{
            $(this).html('<i class="fa fa-plus fa-lg"></i>');

        }
    });
    'use strict';

    // select box it pulign
    $('select').selectBoxIt();
    $("select").selectBoxIt({ autoWidth: false });
    // hidden placeholder in login form
    $('[placeholder]').focus(function(){
        $(this).attr("data-text" , $(this).attr("placeholder"));
        $(this).attr("placeholder" , "");

    }).blur(function(){
        $(this).attr("placeholder" , $(this).attr("data-text"));

    });
    
    $('input').each(function(){
        if($(this).attr('required') === 'required'){
            $(this).after("<span class = 'asterisk'>*</span>");
        }
    });

    $('.show-pass').hover(function(){
        $('.password').attr("type" , "text");
    },function(){
        $('.password').attr("type" , "password");
    });

    // confirmation button when delete

    $('.confirm').click(function(){
        return confirm("Are you sure ?");
    });

    $('.cat h3').click(function(){
        $(this).next('.full-view').fadeToggle(500);
    });

    $('.option span').click(function(){
        $(this).addClass('active').siblings('span').removeClass('active');
        if($(this).data('view') == 'Full'){
            $('.cat .full-view').fadeIn(200);
        }else{
            $('.cat .full-view').fadeOut(200);
        }
    });

    $('.child-link').hover(function(){
        $(this).find('.show-delete').fadeIn(400);
    },function(){
        $(this).find('show-delete').fadeOut(400);

    });
});

$( document ).ready(function() {


    
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

    

    // confirmation button when delete

    $('.confirm').click(function(){
        return confirm("Are you sure ?");
    });

    //-------------------------------------------
    $('.login-page h2 span').click(function(){
        $(this).addClass('selected').siblings('span').removeClass('selected');

        $('.login-page form').hide();
        $('.' +$(this).data('class')).fadeIn(500);
    })
// لما اكتب في الحقول يظهر في الجنب التاني عند الصورة
    $('.live').keyup(function(){
        $($(this).data('class')).text($(this).val());
        
        
    });
    /*$('.live-name').keyup(function(){
        $('.live-preview .caption h3').text($(this).val());
    });
    $('.live-desc').keyup(function(){
        $('.live-preview .caption p').text($(this).val());
    });
    $('.live-price').keyup(function(){
        $('.live-preview .price-tag').text('$' + $(this).val());
    });*/
});

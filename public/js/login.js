/**
 * Created by viller_m on 15/07/14.
 */


(function($){
    $base_url = $("#base_url").html();

    // Effect
    $spans = $('input, button, label');
    $('#formlogin').velocity('transition.bounceUpIn');

    $('#toregister').click(function(e){
        $('#formlogin').velocity('transition.bounceUpOut');
        $('#formregister').velocity('transition.bounceUpIn',{delay: 800});
        $spans.velocity('transition.bounceUpIn',{delay: 800});
    });

    $('#tologin').click(function(e){
        $('#formregister').velocity('transition.bounceUpOut');
        $('#formlogin').velocity('transition.bounceUpIn',{delay: 800});
        $spans.velocity('transition.bounceUpIn',{delay: 800});
    });

    $spans.velocity('transition.bounceUpIn');

    // Formulaire de login
    $('#formlogin').submit(function(e){
        e.preventDefault();
        doform('login');
        return false;
    });

    $('#formregister').submit(function(e){
        e.preventDefault();
        doform('register');
        return false;
    });

    function doform(type){
        $("#form"+type).find('.error').empty();
        //$("#form"+type).find('.error').html(makeAlert({"danger":"Le nom d'utilisateur ou le mot de passe ne correspond pas"}));

        var values = $('#'+type).serialize();

        $.ajax({
            type:'post',
            url: $base_url+'account/'+type,
            data: values,
            datatype: 'json'
        })
        .done(function(msg){
            msg = $.parseJSON(msg);
            if($.isEmptyObject(msg) == false){
                $.each(msg, function(key, value){
                    if (key == 'success' ){
                        if(type == 'login'){
                            $("#form"+type).find('.error').html(makeAlert(msg));
                            window.setTimeout(function() {
                                window.location.href = $base_url+'accueil';
                            }, 2000);
                        }
                    }
                    else {

                        $("#form"+type).find('.error').html(makeAlert(msg));
                    }
                })
            }
        });
    }

    function makeAlert(object){
        var alert = '';
        $.each(object, function(type, data){
            alert+= '<div class="alert alert-'+type+' alert-dismissable"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>'+data+'</div>';
        });
        return alert;
    }

})(jQuery);
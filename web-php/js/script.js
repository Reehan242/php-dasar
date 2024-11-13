$(function(){  // cek ready dom nya dlu
    
    // event ketika keyword search bar diketik
    $('#keyword').on('keyup',function(){

        // // ajak menggunakan $.get()
        $.get('ajax/live_search.php?keyword='+$('#keyword').val(),function(data){
            $('#container').html(data);            
        })
    });

    // event ketika regis username di ketik
    $('#reg_username').on('keyup',function(){
        // ajak menggunakan $.get()
        $.get('ajax/regis_validate.php?username='+$('#reg_username').val(),function(data){
            $('#errorMessageUsername').html(data);
        })
    });

    // // event ketika regis confirm password di ketik
    // $('#reg_password2').on('keyup',function(){

    //     // ajak menggunakan $.get()
    //     $.get('ajax/regis_validate.php?password='+$('#reg_password1').val()&'password2='+$('#reg_password2'),function(data){
    //         $('#errorMessagePassword').html(data);
    //     })
    // });

    // // event ketika regis password1 di ketik
    // $('#reg_password1').on('keyup',function(){

    //     // ajak menggunakan $.get()
    //     $.get('ajax/regis_validate.php?password='+$('#reg_password1').val()&'password2='+$('#reg_password2'),function(data){
    //         $('#errorMessagePassword').html(data);
    //     })
    // });


});




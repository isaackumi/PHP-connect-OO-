$(document).ready(function(){
		
		
    $("input[name='email']").on('input',()=>{
        console.log('12')
            $.ajax({
                url:'user',
                type: 'POST',

                data:{
                    email: $("input[name='email']").val()
                },
                success:(data)=>{
                    if (data.output==='true'){
                        $('#email_checker').html('');

                    }else{
                        $('#email_checker').html('Email address already exists');
                    }},
                error:(err)=>console.log(err),
                });
                
    });

    $("input[name='password']").on('input', ()=>{
        
        if ($("input[name='password']").val() !== $("input[name='confirm_password']").val()){
            $('#password_checker').html('Passwords do not match')
        }
        
        else{
            $('#password_checker').html('')
        }
    })


    $("input[name='confirm_password']").on('input', ()=>{
        if ($("input[name='password']").val() !== $("input[name='confirm_password']").val()){
            $('#password_checker').html('Passwords do not match')
        }

        else{
            $('#password_checker').html('')
        }
    })

    $( "#submit" ).click(function( event ) {
        
        var submit = false;
        
        $.ajax({
                url:'user',
                type: 'POST',

                data:{
                    email: $("input[name='email']").val()
                },
                async: false,
                success:(data)=>{
                    if (data.output==='true'){
                        $('#email_checker').html('')

                            if ($("input[name='password']").val() === $("input[name='confirm_password']").val()){
                                $('#password_checker').html('');
                                submit = true;
                            }
                            else{
                                $('#password_checker').html('Passwords do not match')			
                            }
                    }else{
                        $('#email_checker').html('Email address already exists')
                        if ($("input[name='password']").val() !== $("input[name='confirm_password']").val()){
                            $('#password_checker').html('Passwords do not match')
                            }

                        else{
                            $('#password_checker').html('')
                        }	
                    }},
                error:(err)=>console.log(err),
                });
                console.log(submit)
                return submit;
            });
});


  
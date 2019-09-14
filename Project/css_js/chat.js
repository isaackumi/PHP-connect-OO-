// Make connection
// var socket = io.connect('http://127.0.0.1:8000');


$(document).ready(() =>{
    // var socket = io.connect('http://127.0.0.1:8000');


    $('#send').click(()=>{
        socket.emit('chat', {
            message: $('#message').val(),
        });
        message: $('#message').val('')
    });

    socket.on('chat', function(data){
       
        $('#output').append(
            '<div class="d-flex justify-content-start mb-4"><div class="img_cont_msg"><img src="https://devilsworkshop.org/files/2013/01/enlarged-facebook-profile-picture.jpg" class="rounded-circle user_img_msg"></div><div class="msg_cotainer">'+ data.message+'<span class="msg_time">9:07 AM, Today</span></div></div>'
            );
window.scrollTo(0, document.body.scrollHeight);
        // socket.off()
    });

});
$(document).ready(function(){
    $('#action_menu_btn').click(function(){
        $('.action_menu').toggle();
    });
        });

// // Query DOM
// var message = document.getElementById('message'),
//       handle = document.getElementById('handle'),
//       btn = document.getElementById('send'),
//       output = document.getElementById('output'),
//       feedback = document.getElementById('feedback');

// // Emit events
// btn.addEventListener('click', function(){

//     socket.emit('chat', {
//         message: message.value,
//         handle: handle.value
//     });
//     // message.value = "";
// });

// message.addEventListener('keypress', function(){
//     socket.emit('typing', handle.value);
// })

// // Listen for events
// socket.on('chat', function(data){
//     feedback.innerHTML = '';
//     output.innerHTML += '<p><strong>' + data.handle + ':</p>';
//     output.innerHTML += '<li class="sent"><img src="/views/logo.png" alt="" /><p>'+data.message + '</p></li>';
//     // socket.off()
// });

// socket.on('typing', function(data){
//     feedback.innerHTML = '<p><em>' + data + ' is typing a message...</em></p>';
// });

setInterval(
ping, 1000);


$(document).on('click', '.message-submit', addMess)


function addMess(){
  let val = $('.message-input').val();
  $('.message-input').val('');
  $.post('/add', {mess:val});
}


function ping() {
  $.post('/ping', function (resp){

    $('.messages-content').html(resp);

  });
}
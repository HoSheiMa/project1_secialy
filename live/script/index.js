live = document.querySelector('#live_now');


// private live

navigator.getUserMedia = navigator.getUserMedia ||
  navigator.webkitGetUserMedia ||
  navigator.mozGetUserMedia;

if (navigator.getUserMedia) {
  navigator.getUserMedia({
      audio: true,
      video: true
    },
    function(stream) {

      var video = document.querySelector('#c');
      video.src = window.URL.createObjectURL(stream);
      video.onloadedmetadata = function(e) {
        video.play();
      };
    },
    function(err) {
      console.log("The following error occurred: " + err.name);
    }
  );

}



var peer = new Peer();

peer.on('open', function(id) {
  console.log(id)
})

live.onclick = () => {


  navigator.getUserMedia = navigator.getUserMedia ||
    navigator.webkitGetUserMedia ||
    navigator.mozGetUserMedia;

  if (navigator.getUserMedia) {

    window.socket = io('http://localhost:8080/');

    $.ajax({
      url: '../ajax.php',
      data: {
        req: 'need_info'
      },
      type: 'post',
      success: function(d) {
        d = JSON.parse(d);
        socket.emit('live', {
          id: peer.id,
          id_user: d[0]
        });
        $(live).remove()
          $('.title').html('live is opened at : localhost/live/?room=' + (peer.id).toString())
          peer.on('call', function(call) {
          navigator.getUserMedia({
              audio: true,
              video: true
            },
            function(stream) {

              call.answer(stream); // Answer the call with an A/V stream.

            },
            function(err) {
              console.log("The following error occurred: " + err.name);
            }
          );
        });
      }
    });


  }


}
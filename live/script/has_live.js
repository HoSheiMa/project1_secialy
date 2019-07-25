var peer = new Peer();
var id = (window.location.search).split('=')[1];

navigator.getUserMedia = navigator.getUserMedia ||
	navigator.webkitGetUserMedia ||
	navigator.mozGetUserMedia;

if (navigator.getUserMedia) {
	navigator.getUserMedia({
			audio: false,
			video:true,
		},



		function(stream) {
			var call = peer.call(id, stream);
			call.on('stream', function(remoteStream) {
				console.log(remoteStream);
			var video = document.querySelector('#c');
			video.srcObject = remoteStream;
			video.onloadedmetadata = function(e) {
				video.play();
			};
			});
		},



		function(err) {
			console.log("The following error occurred: " + err.name);
		}
	);
} else {
	console.log("getUserMedia not supported");
}
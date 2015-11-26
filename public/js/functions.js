var playlist = [
	'CGCMl-K09vg',
	'5-RszQzQCvg',
	'3Fhx2YgbskE'
];

var tag = document.createElement('script');
tag.src = "https://www.youtube.com/iframe_api";

var firstScriptTag = document.getElementsByTagName('script')[0];
firstScriptTag.parentNode.insertBefore(tag, firstScriptTag);

var videoNum = 0,
	player;

function onYouTubeIframeAPIReady() {
	player = new YT.Player('player', {
		height: '390',
		width: '640',
		events: {
			'onReady': onPlayerReady,
			'onStateChange': onPlayerStateChange
		}
	});
}

function onPlayerReady(event) {
	var videoId = playlist[videoNum];
	
	player.loadVideoById(videoId);
	player.playVideo();

	var playlistHTML = document.getElementById('playlist');

	if (playlist.length > 1) {		
		playlistHTML.innerHTML = '';
		
		for (var i = 0; i < playlist.length; i++) {	
			var currentClass = videoNum == i ? ' class="current"' : '';
			playlistHTML.innerHTML += '<li' + currentClass + '>' + playlist[i] + '</li>';
		};
	};
}

function onPlayerStateChange(event) {
	if (event.data == YT.PlayerState.PLAYING) {
	}

	if (event.data == YT.PlayerState.ENDED) {
		videoNum++;
		onPlayerReady();
	}
}

function stopVideo() {
	player.stopVideo();
}
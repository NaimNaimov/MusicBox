var playlist = [];

var tag = document.createElement('script');
tag.src = "https://www.youtube.com/iframe_api";

var firstScriptTag = document.getElementsByTagName('script')[0];
firstScriptTag.parentNode.insertBefore(tag, firstScriptTag);

var videoNum = 0,
	forcePlayer = false,
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

	fillPlaylist();
}

function onPlayerStateChange(event) {
	if (event.data == YT.PlayerState.PLAYING) {
	}

	if ( (event.data == YT.PlayerState.ENDED) && (playlist.length > videoNum + 1) ) {
		videoNum++;
		onPlayerReady();
	}
}

function fillPlaylist() {
	var playlistHTML = document.getElementById('playlist');

	if (playlist.length > 0) {		
		playlistHTML.innerHTML = '';
		
		for (var i = 0; i < playlist.length; i++) {	
			var currentClass = videoNum == i ? ' class="current"' : '';
			playlistHTML.innerHTML += '<li' + currentClass + '>' + playlist[i] + '</li>';
		};
	};
}

function stopVideo() {
	player.stopVideo();
}

;(function($, window, document, undefined) {

	var $win = $(window);
	var $doc = $(document);

	$doc.ready(function() {
		// Search
		$('#search').on('submit', function(event) {
			event.preventDefault();

			var $this = $(this);

			$.ajax({
				method: $this.attr('method'),
				url: $this.attr('action'),
				data: $this.serializeArray(),
				dataType: 'html',
				success: function(data, textStatus, request) {
					$('#searchResults').addClass('active').html(data);
				},
				error: function(request, textStatus, errorThrown) {
					console.log('error');
				}
			});
		});

		// Search Results
		$doc.find('#searchResults').on('click', 'a', function(event) {
			event.preventDefault();
			var $this = $(this);
			var videoId = $this[0].getAttribute('data-videoid');
			
			playlist.push(videoId);

			if (!forcePlayer && playlist.length == 1) {
				onPlayerReady();
				forcePlayer = true;
			};
			
			fillPlaylist();
		});
	});

})(jQuery, window, document);
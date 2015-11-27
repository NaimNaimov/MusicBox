var playlist = {
	items: []
};

var tag = document.createElement('script');
tag.src = "https://www.youtube.com/iframe_api";

var firstScriptTag = document.getElementsByTagName('script')[0];
firstScriptTag.parentNode.insertBefore(tag, firstScriptTag);

var videoNum = 0,
	forcePlayer = false,
	player;

function onYouTubeIframeAPIReady() {
	player = new YT.Player('player', {
		height: '360',
		width: '640',
		events: {
			'onReady': onPlayerReady,
			'onStateChange': onPlayerStateChange
		}
	});
}

function onPlayerReady(event) {
	if (playlist.items.length > 0) {
		var videoId = playlist.items[videoNum].videoId;
		
		player.loadVideoById({
			videoId: videoId,
			startSeconds: 0,
			suggestedQuality: 'hd720'
		});

		player.playVideo();
	};

	fillPlaylist();
}

function onPlayerStateChange(event) {
	if (event.data == YT.PlayerState.PLAYING) {
	}

	if (event.data == YT.PlayerState.ENDED) {
		if (playlist.items.length > videoNum + 1) {
			videoNum++;
		} else {
			videoNum = 0;
		};

		onPlayerReady();
	}
}

function fillPlaylist() {
	var playlistHTML = document.getElementById('playlist');

	if (playlist.items.length > 0) {		
		playlistHTML.parentNode.classList.add('active');
		playlistHTML.innerHTML = '';
		
		for (var i = 0; i < playlist.items.length; i++) {	
			var currentClass = videoNum == i ? ' class="current"' : '';
			playlistHTML.innerHTML += '<li' + currentClass + '><a href="#" data-videoId="' + playlist.items[i].videoId + '">' + playlist.items[i].videoName + '</a></li>';
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
			var videoName = $this[0].getAttribute('data-videoname');
			
			playlist.items.push({
				videoId: videoId,
				videoName: videoName
			});

			if (!forcePlayer && playlist.items.length == 1) {
				onPlayerReady();
				forcePlayer = true;
			};

			fillPlaylist();
		});

		// Change Video
		$doc.find('.playlist').on('click', 'a', function(event) {
			console.log('playlist!!');
			event.preventDefault();

			videoNum = $(this).parent('li').index();

			onPlayerReady();
		});
	});

})(jQuery, window, document);
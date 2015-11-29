var playlist = {
	items: []
};

var player;

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
	
	if (typeof player === 'undefined') {
		return false;
	};
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
			playlistHTML.innerHTML += '<li' + currentClass + '><a href="#" data-videoId="' + playlist.items[i].videoId + '">' + playlist.items[i].videoName + '</a> <span class="video-remove"><i class="fa fa-times"></i></span></li>';
		};
	} 
}

function stopVideo() {
	player.stopVideo();
}

function playVideo() {
	player.playVideo();
}

function playerDestroy() {
	player.playVideo();	
}

;(function($, window, document, undefined) {

	var $win = $(window);
	var $doc = $(document);
	$win.on('load', function() {
		$('.wrapper').addClass('loaded');
		player.addEventListener('onStateChange', function(event){
			if (event.data === -1) {
				updateCurrentSong();
			};
		});
		navPlayerControls();
	});

	$doc.ready(function() {
		queueAddedPlaylist();
		searchVideos();
		scrollTopController();
		removeVideoFromPlaylist();
		roomsToggle();

		// Search Results
		$doc.find('#searchResults').on('click', 'a', function(event) {
			event.preventDefault();
			var $this = $(this);
			var videoId = $this[0].getAttribute('data-videoid');
			var videoName = $this[0].getAttribute('data-videoname');
			
			_token = $('.container').data('token');
			slug = $('.container').data('slug');
			data = {
				'_token' : _token,
				'video_id': videoId,
				'video_name': videoName,
				'slug' : slug,
			};

			addSongToPlaylist(data);
		});

		// Change Video
		$('.playlist').on('click', 'a', function(event) {
			event.preventDefault();
			videoNum = $(this).parent('li').index();
			onPlayerReady();

			$('html, body').animate({
				scrollTop : 0
			}, 1000);
		});
	});

	function addSongToPlaylist(data) {
		$notice = $('.notice-playlist');
		$.ajax({
			type: 'POST',
			url: '/add_video',
			data:data,
			dataType: 'json'
		})
		.done(function(response){
			var text;
			$notice.removeClass('success error');

			if (response.success) {
				addVideoToPlaylist(data.video_id, data.video_name)
				text = 'Added to playlist.';
				noticeClass = 'success';

				// if ( !$('#playlist').hasClass('empty') ) {
				// 	$('#playlist').append('<li class="current"><a href="#" data-videoId="' + data.videoId +'">' + data.video_name+ '</a></li>')
				// };

			} else {
				text = 'Something went wrong, please try again later.';
				noticeClass = 'error';
			}
			$notice.text(text).addClass(noticeClass).fadeIn('fast');
		})
		.fail(function(jqXHR, error, status){
			alert('Something went wrong, please try again later.')
		})

		.always( function() {
			setTimeout(function(){ 
				$notice.fadeOut();
			}, 3000);
		})
	}

	function queueAddedPlaylist(){
		$playlistItems = $('.playlist li a');

		if (!$playlistItems.length) {
			return;
		};

		$playlistItems.each(function(){
			$this = $(this);
			var videoId = $this.data('videoid');
			var videoName = $this.text();
			
			playlist.items.push({
				videoId: videoId,
				videoName: videoName
			});
		})

		if (!forcePlayer && playlist.items.length == 1) {
			onPlayerReady();
			forcePlayer = true;
		};
	}


	function searchVideos() {
		$('#search').on('submit', function(event) {
			event.preventDefault();

			var $this = $(this);

			$.ajax({
				method: $this.attr('method'),
				url: $this.attr('action'),
				data: $this.serializeArray(),
				dataType: 'html',
				success: function(data, textStatus, request) {
					$results = $('#searchResults');
					$('#searchResults').addClass('active').find('.results-container').html(data);
					$('html, body').animate({
						scrollTop : $results.offset().top
					}, 1000);
				},
				error: function(request, textStatus, errorThrown) {
					
				}
			});
		});
	}


	function addVideoToPlaylist(videoID, videoName ) {
		playlist.items.push({
			videoId: videoID,
			videoName: videoName
		});

		if (!forcePlayer && playlist.items.length == 1) {
			onPlayerReady();
			forcePlayer = true;
		};

		fillPlaylist();
	}


	function scrollTopController() {
		var $scroll = $('.scroll-top');
		$('.scroll-top').on('click', function(e){
			$('html, body').animate({
				scrollTop : $('body').offset().top
			}, 1000);
			e.preventDefault();
		});

		$win.on('load scroll', function(){
			
			if ($win.scrollTop() === 0  ) {
				$scroll.fadeOut();
			} else {
				$scroll.fadeIn();
			}
		})
	}

	function updateCurrentSong() {
		var $playlist = $('.playlist');
		var $controls = $('.navbar-player-controls');
		var $holder = $('.current-song');

		if ( !$playlist.length) {
			$controls.hide();
		};
		if ( $playlist.find('li.current a').length ) {
			$holder.text( $playlist.find('li.current a').text() );
		};
	}

	function navPlayerControls() {


		var $playlist = $('.playlist');
		var $controls = $('.navbar-player-controls');

		if ( !$playlist.length) {
			$controls.hide();
		};

		$controls.find('.next').on('click', function(){
			$playlist.find('.current').next().find('a').trigger('click');
		})

		$controls.find('.prev').on('click', function(){
			$playlist.find('.current').prev().find('a').trigger('click');
		})

		$controls.find('.toggle-play').on('click', function(){

			if ( $(this).hasClass('stopped') ) {
				playVideo();
			} else {
				stopVideo();
			}

			$(this).toggleClass('stopped');
		})
	}

	function removeVideoFromPlaylist() {

		$doc.find('#playlist').on('click', '.video-remove', function(event) {
			event.preventDefault();
			var $this = $(this);
			var videoId = $this.prev().data('videoid');
			var videoName = $this.prev().text();
			
			_token = $('.container').data('token');
			slug = $('.container').data('slug');
			data = {
				'_token' : _token,
				'video_id': videoId,
				'video_name': videoName,
				'slug' : slug,
			};

			confirmation = confirm("Are you sure you want to delete " + videoName + " from the playlist?");
			if (!confirmation) {
				return false;
			};

			$.ajax({
				url : '/remove_video',
				type: 'POST',
				data : data,
				dataType : 'json'
			})
			.done(function (response){
				
				if (response.success) {
					$parent = $this.parents('li')

					if ($parent.hasClass('current')) {
						$parent.next().trigger('click')
					};
					$parent.remove();
					
					if (!$('#playlist li').length ) {
						playerDestroy();
						stopVideo();
					};
				};
			})
		});
	}

	function roomsToggle() {
		$('.room-cat').on('click', function(){
			$(this).toggleClass('open');
			$(this).next().slideToggle();
		})
	}


})(jQuery, window, document);
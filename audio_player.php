<div class="mhn-player">
	<div class="album-art"></div>
	<div class="play-list">
		<?php
		/** only change within '' in album and artist **/
		/** to change audio just add files with mp3 format in folder audio in root **/
		$fileList = glob('audio/*.mp3');/** reads the file contents in a folder **/
		$i =1;
		foreach($fileList as $audioMp3){
		    if(is_file($audioMp3)){
		    	$title = substr($audioMp3, 0, strrpos($audioMp3, "."));/** removes file extension **/
		        echo
		        "<a href='#' class='play'
					data-id='",$i++/** adds number id to array files for playlist count**/,"'
					data-album='The Shattered Divide'
					data-artist='Nocturnalis'
					data-title='",basename($title)/** gets only file name w/o folder name **/,"'
					data-albumart='images/album_art.jpg'
					data-url='audio/",basename($title)/**array path to file**/,".mp3'>
				</a>'"; 
			}   
		}
		?>
		<!-- commented out
		<a href="#" class="play"
			data-id="2"
			data-album="Album"
			data-artist="Nocturnalis"
			data-title="song title"
			data-albumart="audio/album_art.jpg"
			data-url="audio/test_2.mp3">
		
		</a>
		-->
	</div>
	<!-- design structure for the audio player do not tuch -->
	<div class="audio"></div>

	<div class="current-info">
		<div class="song-artist"></div>
		<div class="song-album"></div>
		<div class="song-title"></div>
	</div>

	<div class="controls">
		<a href="#" class="toggle-play-list"><i class="fa fa-list-ul"></i></a>
	<div class="duration clearfix">
		<span class="pull-left play-position"></span>
		<span class="pull-right"><span class="play-current-time">00:00</span> / <span class="play-total-time">00:00</span></span>
	</div>
	<div class="progress"><div class="bar"></div></div>
	<div class="action-button">
		<a href="#" class="prev"><i class="fa fa-step-backward"></i></a>
		<a href="#" class="play-pause"><i class="fa fa-pp"></i></a>
		<a href="#" class="stop"><i class="fa fa-stop"></i></a>
		<a href="#" class="next"><i class="fa fa-step-forward"></i></a>
		<input type="range" class="volume" min="0" max="1" step="0.1" value="0.5" data-css="0.5">
	</div>

	</div>
</div>
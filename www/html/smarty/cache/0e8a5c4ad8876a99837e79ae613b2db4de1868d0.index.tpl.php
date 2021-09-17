<?php
/* Smarty version 3.1.30-dev/47, created on 2016-02-24 08:36:19
  from "C:\htdocs\The Fall of the Wehrmacht\iwpserver\htdocs\templates\index.tpl" */

/* @var Smarty_Internal_Template $_smarty_tpl */
if ($_smarty_tpl->_decodeProperties($_smarty_tpl, array (
  'version' => '3.1.30-dev/47',
  'unifunc' => 'content_56cd5d73f24800_27308618',
  'has_nocache_code' => false,
  'file_dependency' => 
  array (
    '683ff292f4ade5e3c6fb11946229082ae9cc05ce' => 
    array (
      0 => 'C:\\htdocs\\The Fall of the Wehrmacht\\iwpserver\\htdocs\\templates\\index.tpl',
      1 => 1456296461,
      2 => 'file',
    ),
  ),
  'cache_lifetime' => 120,
),true)) {
function content_56cd5d73f24800_27308618 (Smarty_Internal_Template $_smarty_tpl) {
?>
<!DOCTYPE HTML>
<html lang="en">

<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<link rel="icon" href="/img/favicon2.png" type="image/png">

<!-- Latest compiled and minified CSS -->
<link rel="stylesheet" href="/css/bootstrap.min.css">
<link rel="stylesheet" href="/css/bootstrap-theme.min.css">
<link rel="stylesheet" href="/css/jumbotron-narrow.css">
<link rel="stylesheet" href="/css/style.css">

<script src="/js/jquery.min.js"></script>
<script src="/js/bootstrap.min.js"></script>
<script src="/js/soundManager2/soundmanager2-nodebug-jsmin.js"></script>
<script src="/js/scripts.js"></script>
<!--<script src="js/soundManager2/soundmanager2.js"></script>-->


<script type="text/javascript">


$(document).ready(function() {
			
	// if user is on a mobile
	if (isMobile()) {
		
		// auto show modal
		//$('#myModal').modal('show');
	
		// auto-start sounds and video upon modal close
		// this is required because mobile devices block autoplay features of sounds and videos
		$("#modalClose").click(function() {
			
			// load intro soundtrack
			soundManager.setup({
				url: '/',
				onready: function() {
					var introSound = soundManager.createSound({
						id: 'intro_sound',
						url: 'sound/intro.mp3'
					});
					//introSound.play();
				},
				ontimeout: function() {
				// Hrmm, SM2 could not start. Missing SWF? Flash blocked? Show an error, etc.?
				}
			});
				
			// auto play background video
			//$("#bgvid").trigger('play');
				
		});
	}
	else { // non-mobile user
		
		// auto play soundtrack
		soundManager.setup({
			url: '/',
			onready: function() {
				var introSound = soundManager.createSound({
					id: 'intro_sound',
					url: 'sound/intro.mp3'
				});
				// below line is commented out for testing purposes
				//introSound.play();
			},
			ontimeout: function() {
			// Hrmm, SM2 could not start. Missing SWF? Flash blocked? Show an error, etc.?
			}
		});
		
		// auto play background video
		//$("#bgvid").trigger('play');
	}
	
   
   
   // function to toggle sound on or off
	$("#mute_button").click(function() {
		var current_val = $('#mute_button').attr("title");
		
		if (current_val == 'Mute Sound') {
			soundManager.setVolume('intro_sound',0);
			$('#mute_button').attr("title", "Unmute Sound");
		}
		else if (current_val == 'Unmute Sound') {
			soundManager.setVolume('intro_sound',100);
			$('#mute_button').attr("title", "Mute Sound");	
		}
	});


	   
});	// end $(document).ready

</script>

<meta charset="UTF-8">
<title>The Fall of the Wehrmacht</title>
</head>

<body>
 
 <!-- autoplayed intro vid -->
<video loop poster="/img/intro/intro.jpg" id="bgvid">
    <source src="video/intro.mp4" type="video/mp4">
</video>

	<!-- Modal for mobile browsers -->
	<div class="modal fade" id="myModal" role="dialog" data-backdrop="static" data-keyboard="false">
		<div class="modal-dialog">
		  <!-- Modal content-->
		  <div class="modal-content">
			<div class="modal-body">
			  <strong><p>Welcome to The Fall of the Werhmacht!</p></strong>
			</div>
			<div class="modal-footer">
			  <button type="button" id="modalClose" class="btn btn-default" data-dismiss="modal">Proceed</button>
			</div>
		  </div>
		</div>
	</div>
	<!-- end modal -->
	
	<!-- Begin content container -->
    <div class="container">

		<nav>
          <ul class="nav nav-pills pull-right">
            <li role="presentation" id="mute_button" title="Mute Sound"><a href="#"><span class="glyphicon glyphicon-volume-off"></span></a></li>
          </ul>
        </nav>

		<img src="/img/logo.png" class="img-responsive" alt="The Fall of the Werhmacht logo" id="intro_logo" />
		
		<div id="content_div" class="jumbotron">
			<div class="embed-responsive embed-responsive-4by3" style="min-height: 250px;">
				<iframe class="embed-responsive-item" src="login.php" id="content_iframe"></iframe>
			</div>
      </div> <!-- /jumbotron -->

    </div> <!-- /container -->

  </body>
</html><?php }
}

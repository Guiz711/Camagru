<?php	
session_start();
// print_r($_SESSION);
if (!array_key_exists('user_id', $_SESSION))
    $_SESSION['user_id'] = "unknown";
?>

<html lang="fr">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<link rel="stylesheet" type="text/css" href="./View/style_css/style.css">
	<title>Camagru</title>
	<meta charset="UTF-8">
</head>
<body>

	<header>

	<?php
	require("./requirements.php");
    include("./View/header_user.html");
    include("./Controller/displayMedia.php");
    ?>
	</header>
    <div class="corpus">
    
    <div class="webcam">
    <video id='video'></video>
    <canvas id='canvas'></canvas>
    <img src='#' class='hidden' id='photo'> 
    
    <!-- <div><button id='startbutton'>Prendre une photo</button></div> -->
    <div class="filters">   <?php  display_filters();  ?>   </div>
    </div>
    <div class="photo_media">  <?php   display_photomontage(); ?>  </div>
    </div>
    
    
    
    <?php include("./View/footer.html"); ?>




    <script src='./Controller/thumbnails.js'></script>
    <script>
    console.log("Script1");
    (function(){
    let streaming = false;
    let video = document.querySelector('#video');
    let webcam = document.querySelector('.webcam');
    let canvas = document.querySelector('#canvas');
    let photo = document.querySelector('#photo');
    let startbutton = document.querySelector('#startbutton');
    let width = webcam.offsetWidth;
    let height = 0;
    navigator.getMedia = ( navigator.getUserMedia || navigator.webkitGetUserMedia || navigator.mozGetUserMedia || navigator.msGetUserMedia);
    
    navigator.getMedia(
        {video:true, audio:false},
        function(stream){
            if (navigator.mozGetUserMedia){
                video.mozSrcObject = stream;
            }
            else {
                let vendorURL = window.URL || window.webkitURL;
                video.src = vendorURL.createObjectURL(stream);
            }
            video.play();},
        function(err){
            console.log("Une erreur est survenue" + err);}
        );
    video.addEventListener('canplay', function(ev){
        if (!streaming){
            height = video.videoHeight / (video.videoWidth/width);
            video.setAttribute('width', width);
            video.setAttribute('height', height);
            canvas.setAttribute('width', width);
            canvas.setAttribute('height', height);
            streaming = true;    
        }}, false);
    window.addEventListener('resize', function(ev){
            width = webcam.offsetWidth;
            height = video.videoHeight / (video.videoWidth/width);
            video.setAttribute('width', width);
            video.setAttribute('height', height);
            canvas.setAttribute('width', width);
            canvas.setAttribute('height', height);
            photo.setAttribute('width', width);
            photo.setAttribute('height', height);
            streaming = true;    
    });
    startbutton.addEventListener('click', function(ev){
        takepicture();
        ev.preventDefault();
    }, false);
    
    function takepicture(){
        canvas.width = width;
        canvas.height = height;
        canvas.getContext('2d').drawImage(video, 0, 0, width, height);
        let data = canvas.toDataURL('image/png');
        photo.setAttribute('src', data);
        photo.classList.remove('hidden');
        // alert (photo.getAttribute('src'));
    }
    
    })();
    console.log("Script");
    </script>
</body>
</html>
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

function uploadpicture()
{
    let photo = document.querySelector('#photo');
    let xhr = new XMLHttpRequest();
    let data = photo.getAttribute('src');

    xhr.open('POST', './Controller/uploadImage.php');
    xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
    xhr.onload = () => {
        if (xhr.readyState === XMLHttpRequest.DONE && xhr.status === 200) {
            var ret = xhr.responseText;

            console.log(ret);
        }
    }
    xhr.send('image=' + data + '&description=');
}

savebutton.addEventListener('click', function(ev){
    uploadpicture();
    ev.preventDefault();
}, false);

})();
console.log("Script");
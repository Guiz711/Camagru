console.log("Script1");
(function(){
let streaming = false;
let video = document.querySelector('#video');
let webcam = document.querySelector('.webcam');
let canvas = document.querySelector('#canvas');
let photo = document.querySelector('#photo');
let startbutton = document.querySelector('#startbutton');
let savebutton = document.querySelector('#savebutton');
let description = document.querySelector('#Description');
let filters = document.querySelectorAll("div[id^='filter']");
let cancel_photomontage = document.querySelector('#cancel_photomontage');
startbutton.disabled = true;
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
        // canvas.setAttribute('width', width);
        // canvas.setAttribute('height', height);
        photo.setAttribute('width', width);
        photo.setAttribute('height', height);
        streaming = true;    
    }}, false);
window.addEventListener('resize', function(ev){
        width = webcam.offsetWidth;
        height = video.videoHeight / (video.videoWidth/width);
        video.setAttribute('width', width);
        video.setAttribute('height', height);
        // canvas.setAttribute('width', width);
        // canvas.setAttribute('height', height);
        photo.setAttribute('width', width);
        photo.setAttribute('height', height);
        streaming = true;    
});

startbutton.addEventListener('click', function(ev){
    takepicture();
    ev.preventDefault();
}, false);

function takepicture(){
    canvas.width = video.videoWidth;
    canvas.height = video.videoHeight;
    canvas.getContext('2d').drawImage(video, 0, 0, video.videoWidth, video.videoHeight);
    let data = canvas.toDataURL('image/png');
    photo.setAttribute('src', data);
    photo.setAttribute('width', width);
    photo.setAttribute('height', height);
    photo.classList.remove('hidden');
    description.classList.remove('hidden');
    savebutton.classList.remove('hidden');
    let filterexists = document.querySelector('.filters');
    filterexists.classList.add('hidden');
    cancel_photomontage.classList.remove('hidden');
    // alert (photo.getAttribute('src'));
}

function get_applied_filters_ids()
{
    let filter_data = document.querySelectorAll("div[id^='applied_filter']");
    let id_list = "";
    let i = 0;

    while (i < filter_data.length)
    {
        let div_id = filter_data[i].id;
        id_list += div_id.substr("applied_filter".length)
        if (i != filter_data.length - 1)
            id_list += ';';
        i++;
    }
    return (id_list);
}

function uploadpicture()
{
    let data_description = document.getElementById("Description").value;
    let photo = document.querySelector('#photo');
    let xhr = new XMLHttpRequest();
    let data = photo.getAttribute('src');
    let id_list = get_applied_filters_ids();

    xhr.open('POST', './Controller/uploadImage.php');
    xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
    xhr.onload = () => {
        if (xhr.readyState === XMLHttpRequest.DONE && xhr.status === 200) {
            var ret = xhr.responseText;
            console.log(ret);
        }
    }
    xhr.send('image=' + data + '&description=' + data_description + '&ids=' + id_list);
}

cancel_photomontage.addEventListener('click', function(){
    photo.classList.add('hidden');
    let filterexists = document.querySelector('.filters');
    filterexists.classList.remove('hidden');
})

savebutton.addEventListener('click', function(ev){
    uploadpicture();
    document.location.href="myprofile.php";
    ev.preventDefault();
}, false);

let i = 0;
while (i < filters.length)
{
    filters[i].addEventListener('click', function(){
        let filterexists = document.querySelector('#applied_' + this.id);
        console.log(filterexists);
        if (filterexists != null){
            console.log("hey you");
            filterexists.remove();
            let iffilter = document.querySelectorAll("div[id^='applied_']");
            console.log(iffilter);
            if (iffilter.length == 0)
                startbutton.disabled = true;
        }
        else {
            let filterscpy = this.cloneNode(true);
            let webcam_content = document.querySelector('#webcam_content');
            filterscpy.id = 'applied_' + this.id;
            webcam_content.appendChild(filterscpy);
            startbutton.disabled = false;
        }
    });
    i++;
}

})();
console.log("Script");
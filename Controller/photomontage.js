console.log("Script1");
(function(){
let streaming = false;
let video = document.querySelector('#video');
let webcam = document.querySelector('.webcam');
let webcam_content = document.querySelector('#webcam_content');
let canvas = document.querySelector('#canvas');
let photo = document.querySelector('#photo');
let startbutton = document.querySelector('#startbutton');
let savebutton = document.querySelector('#savebutton');
let description = document.querySelector('#Description');
let filters = document.querySelectorAll("div[id^='filter']");
let cancel_photomontage = document.querySelector('#cancel_photomontage');
let choose_img = document.querySelector('#choose_img');
startbutton.disabled = true;
let width = webcam.offsetWidth;
let height = 0;
let tmp = new Image;
let photo_view = new Image;
let img_canvas = document.createElement('canvas'); 
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
        let photo_view = document.querySelector('#photo_view');

        width = window.innerWidth * 0.80;
        height = video.videoHeight / (video.videoWidth/width);
        if (photo_view) {
            photo_view.setAttribute('height', height);
            photo_view.setAttribute('width', width);
        }
        video.setAttribute('width', width);
        video.setAttribute('height', height);
        // canvas.setAttribute('width', width);
        // canvas.setAttribute('height', height);
        photo.setAttribute('width', width);
        photo.setAttribute('height', height);
        streaming = true;
        let iffilter = document.querySelectorAll("div[id^='applied_']");
        let i = 0;
        while (i < iffilter.length)
        {
            iffilter[i].style.height = height;
            iffilter[i].children[0].style.height = height;
            iffilter[i].style.width = width;
            iffilter[i].children[0].style.width = width;   
            i++;
        }
      
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
    startbutton.classList.add('hidden');
    choose_img.classList.add('hidden');
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
			let ret = xhr.responseText;
			if (ret == "ERROR"){
				display_popup_result('popup_photomontage_not_uploaded');
				delete_popup('popup_photomontage_not_uploaded');
			}
			else { 
                let div_media = document.querySelector('.photomontages_last');
                let photo_view = document.querySelector('#photo_view');

                div_media.innerHTML = ret;
                if (photo_view)
                    photo_view.parentNode.removeChild(photo_view);
    			display_popup_result('popup_photomontage_uploaded');
    			delete_popup('popup_photomontage_uploaded');
         	}		
		}
    }
    xhr.send('image=' + data + '&description=' + data_description + '&ids=' + id_list);
}

cancel_photomontage.addEventListener('click', function(){
    photo.classList.add('hidden');
    startbutton.classList.remove('hidden');
    choose_img.classList.remove('hidden');
    choose_img.value = "";
    let photo_view = document.querySelector('#photo_view');
    if (photo_view)
        photo_view.parentNode.removeChild(photo_view);
    savebutton.classList.add('hidden');
    let filterexists = document.querySelector('.filters');
    filterexists.classList.remove('hidden');
    description.classList.add('hidden');
})

// Image uploadee par le user

function size_image (tmp, img_canvas, img_width, img_height) {
    let ratio = height / width;

    if (img_width > img_height){
        var new_width = img_height / ratio;
        var new_height = img_height;
        var pos_y = 0;
        var pos_x = (img_width - new_width) / 2.0;
    }
    else {
        var new_height = ratio * img_width;
        var new_width = img_width;
        var pos_y = (img_height - new_height) / 2.0;
        var pos_x = 0;
    }
    img_canvas.setAttribute('width', width);
    img_canvas.setAttribute('height', height);
    var ctx = img_canvas.getContext('2d');
    ctx.rect(0, 0, width, height);
    ctx.fill();
    img_canvas.getContext('2d').drawImage(tmp, pos_x, pos_y, new_width, new_height, 0, 0, width, height);
}

let reader = new FileReader();
choose_img.addEventListener('change', function(){
    let file = choose_img.files[0];
    reader.addEventListener('load', function(){
        photo.setAttribute('src', reader.result);
        tmp.onload = function() {
            size_image(tmp, img_canvas, tmp.width, tmp.height);
            description.classList.remove('hidden');
            photo_view.setAttribute('src', img_canvas.toDataURL('image/png'));
            photo_view.setAttribute('height', height);
            photo_view.setAttribute('width', width);
            photo_view.setAttribute('id', 'photo_view');
            webcam_content.appendChild(photo_view);
            startbutton.classList.add('hidden');
            choose_img.classList.add('hidden');
            savebutton.classList.remove('hidden');
            let iffilter = document.querySelectorAll("div[id^='applied_']");
            if (iffilter.length == 0)
                savebutton.disabled = true;
            else
                savebutton.disabled = false;
            cancel_photomontage.classList.remove('hidden');
        };
        tmp.setAttribute('src', reader.result);
    });
    reader.readAsDataURL(file);
});

// Image uploadee par le user - fin

function	display_popup_result(type)
{
	// alert (type);
	let popup_result = document.getElementById(type);
	// alert (popup_result);
	popup_result.style.display = 'block';
}		

function delete_popup(type)
{
// console.log(type);
	let popup = document.getElementById(type);
	// console.log('je veux savoir');
	// console.log(popup);
		window.onclick = function(event) 
		{
			// console.log('je veux savoir2');
		if (event.target == popup) {
			popup.style.display = 'none';
		}
	}
}

savebutton.addEventListener('click', function(ev){
	uploadpicture();
    photo.classList.add('hidden');
    choose_img.classList.remove('hidden'); 
    savebutton.classList.add('hidden');
    startbutton.classList.remove('hidden'); 
    startbutton.disabled = true;
    let filterexists = document.querySelector('.filters');
    filterexists.classList.remove('hidden');
    choose_img.value = "";
    let iffilter = document.querySelectorAll("div[id^='applied_']");
    let i = 0
    while (i < iffilter.length){
        iffilter[i].remove();
        i++;
	}
    ev.preventDefault();
}, false);

let i = 0;
while (i < filters.length)
{
    filters[i].addEventListener('click', function(){
        let filterexists = document.querySelector('#applied_' + this.id);
        let iffilter = document.querySelectorAll("div[id^='applied_']");
        // savebutton.disabled = true;
        if (filterexists != null){
            filterexists.remove();
            let iffilter = document.querySelectorAll("div[id^='applied_']");
            if (iffilter.length == 0) {
                startbutton.disabled = true;
                savebutton.disabled = true;
            }   
        }
        else {
            let filterscpy = this.cloneNode(true);
            let webcam_content = document.querySelector('#webcam_content');
            filterscpy.id = 'applied_' + this.id;
            let heightval = video.videoHeight / (video.videoWidth/width) + "px";
            filterscpy.style.height = heightval;
            filterscpy.children[0].style.height = heightval;
            filterscpy.style.width = width;
            filterscpy.children[0].style.width = width;
            webcam_content.appendChild(filterscpy);
            startbutton.disabled = false;
            savebutton.disabled = false;
        }
    });
    i++;
}
})();

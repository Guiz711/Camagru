function preparetoHandle(toSend, path, img_id, url)
{
    var xhr = new XMLHttpRequest();

    xhr.open('POST', url, true);
    xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
    xhr.addEventListener('readystatechange', function() {
        if (xhr.readyState === XMLHttpRequest.DONE && xhr.status === 200) {
            var ret = xhr.responseText;
            document.getElementById(path+img_id).innerHTML = ret;
        }
    });
    xhr.send(toSend);
}

function IsMoreToDisplay(id, action)
{
    var xhr = new XMLHttpRequest();
    var url = './Controller/displayMedia.php';
    var new_nb = Number(id) + Number(1);
    var toSend = 'action=IsMoreDisplay&nb='+id;

    xhr.open('POST', url, true);
    xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');

    xhr.addEventListener('readystatechange', function() {
        if (xhr.readyState === XMLHttpRequest.DONE && xhr.status === 200) {
            var ret = xhr.responseText;
            if (ret == 1) {
                document.getElementById(action+';'+id).id = action+';'+new_nb;
            }
            else {
                var elem = document.getElementById(action+'1');
                elem.innerHTML = "";
                elem.remove();
            }
        }
    });
    xhr.send(toSend);
}

function preparetoHandleAdd(toSend, action, path, nb, url)
{
    var xhr = new XMLHttpRequest();

    xhr.open('POST', url, true);
    xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
    xhr.addEventListener('readystatechange', function() {

        if (xhr.readyState === XMLHttpRequest.DONE && xhr.status === 200) {
            var ret = xhr.responseText;
            document.getElementById(path).innerHTML += ret;
            IsMoreToDisplay(nb, action);
        }
    });
    xhr.send(toSend);
}

function preparetoHandleDelete(toSend, path, img_id, url)
{
    var xhr = new XMLHttpRequest();

    xhr.open('POST', url, true);
    xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
    xhr.addEventListener('readystatechange', function() {

        if (xhr.readyState === XMLHttpRequest.DONE && xhr.status === 200) {
            var ret = xhr.responseText;
            document.getElementById(path).innerHTML = ret;
        }
    });
    xhr.send(toSend);
}

function handleLike(load_id) 
{
    var tab = load_id.split(';');
    var where = tab[0];
    var img_id = tab[2];
    var user_id = tab[3];
    var url = './Controller/handleAjax.php';
    // Prepare addLike
    var action = tab[1];
    var toSend = 'action='+action+'&img_id='+img_id+'&user_id='+user_id+'&where='+where;
    var path = where+';allAboutLike';

    console.log('HandleLike FROM :');
    console.log(where);

    // Handle Like Here (eg : Index)
    preparetoHandle(toSend, path, img_id, url);
    // Handle Like There (eg : Popup)
    if (where == "index")
        where = "popup";
    else
        where = "index";
    path = where+';allAboutLike';
    toSend = 'action=updateLike&img_id='+img_id+'&user_id='+user_id+'&where='+where;
    preparetoHandle(toSend, path, img_id, url);
}

function addComment(load_id) 
{
    var tab = load_id.split(';');
    var where = tab[0];
    var img_id = tab[2];
    var user_id = tab[3];
    var url = './Controller/handleAjax.php';
    var is_displayed = document.getElementById(where+';undisplayComment;'+img_id+';'+user_id);

    if (is_displayed)
        is_displayed = true;
    else
        is_displayed = false;
    // Prepare AddComment
    var action = tab[1];
    var textcomment = document.getElementById(where+';textComment;'+img_id+';'+user_id).value;
    if (textcomment === "")
        return;
    var path = where+';commentPart';
    var toSend = 'action='+action+'&img_id='+img_id+'&user_id='+user_id+'&text_comment='+textcomment+'&is_displayed='+is_displayed+'&where='+where;
    console.log('addComment to send =');
    console.log(toSend);

    console.log('Add Comment FROM :');
    console.log(where);
    preparetoHandle(toSend, path, img_id, url);
    // Handle Comment There (eg : Popup)
    if (where == "index")
       where = "popup";
    else
       where = "index";
    is_displayed = document.getElementById(where+';undisplayComment;'+img_id+';'+user_id);
    if (is_displayed)
        is_displayed = true;
    else
        is_displayed = false;
    toSend = 'action=updateComment&img_id='+img_id+'&user_id='+user_id+'&text_comment='+textcomment+'&is_displayed='+is_displayed+'&where='+where;
    path = where+';commentPart';
    preparetoHandle(toSend, path, img_id, url);
}


function displayComment(load_id) {
    var tab = load_id.split(';');
    var where = tab[0];
    var img_id = tab[2];
    var user_id = tab[3];
    var action = tab[1];
    var url = './Controller/handleAjax.php';
    var toSend = 'action='+action+'&img_id='+img_id+'&user_id='+user_id+'&where='+where;
    var path = where+';commentPart';
    preparetoHandle(toSend, path, img_id, url);
}

function deleteImg(load_id) {
    var tab = load_id.split(';');
    var where = tab[0];
    var img_id = tab[2];
    var user_id = tab[3];
    var action = tab[1];
    var display_id = tab[4];
    var url = './Controller/displayMedia.php';
    var path = 'content_index';

    if (document.getElementById('content_profile') !== null)
        path = 'content_profile';
    if (document.getElementById('photomontages_last') !== null)
        path = 'photomontages_last';
    var toSend = 'action='+action+'&img_id='+img_id+'&user_id='+user_id+'&display_id='+display_id+'&where='+path;
    preparetoHandleDelete(toSend, path, img_id, url);
}

function displayMore(load_id) {
    var tab = load_id.split(';');
    
    var where = tab[0];
    var action = tab[1];
    var nb = tab[2];
    var url = './Controller/displayMedia.php';
    var toSend = 'action='+action+'&nb='+nb;
    var path = 'content_index';

    if (where == 'profile')
        path = 'content_profile';
    
     console.log('DisplayMore to send =');
     console.log(toSend);
  
    preparetoHandleAdd(toSend, action, path, nb, url);
}

function displayImage(load_id) {
    var tab = load_id.split(';');
    var img_id = tab[2];
    document.getElementById('popup_media'+img_id).style.display = 'block';
}

function undisplayImage(load_id) {
    var tab = load_id.split(';');
    var img_id = tab[2];
    document.getElementById('popup_media'+img_id).style.display = 'none';

}

function undisplayPopup(type) {
    console.log(type);
	let popup = document.getElementById(type);
	window.onclick = function(event) {
		if (event.target == popup) {
			popup.style.display = 'none';
		}
	}
}

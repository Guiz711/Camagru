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
    // console.log("New_nb =");
    // console.log(new_nb);

    var toSend = 'action=IsMoreDisplay&nb='+id;
    xhr.open('POST', url, true);
    xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');

    xhr.addEventListener('readystatechange', function() {

        if (xhr.readyState === XMLHttpRequest.DONE && xhr.status === 200) {
            ret = xhr.responseText;
            // console.log("IsMoreToDisplay ret =");
            // console.log(ret);
            if (ret == 1) {
                // console.log("New_id =");
                // console.log(action+';'+new_nb);
                document.getElementById(action+';'+id).id = action+';'+new_nb;
            }
            else {
                // console.log("kill div");
                elem = document.getElementById(action+'1');
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

    var img_id = tab[1];
    var user_id = tab[2];

    var url = './Controller/handleAjax.php';

    // Prepare addLike
    var action = tab[0];
    var toSend = 'action='+action+'&img_id='+img_id+'&user_id='+user_id;
    var path = 'allAboutLike';

    preparetoHandle(toSend, path, img_id, url);
}


function addComment(load_id) 
{
    var tab = load_id.split(';');
    // console.log('add comment');
    // console.log(tab);

    var img_id = tab[1];
    var user_id = tab[2];

    var url = './Controller/handleAjax.php';

    var is_displayed = document.getElementById('undisplayComment;'+img_id+';'+user_id);
    if (is_displayed)
        is_displayed = true;
    else
        is_displayed = false;

    // Prepare AddComment
    var action = tab[0];
    var textcomment = document.getElementById('textComment;'+img_id+';'+user_id).value;
    if (textcomment === "")
        return;
    var path = 'commentPart';
    var toSend = 'action='+action+'&img_id='+img_id+'&user_id='+user_id+'&text_comment='+textcomment+'&is_displayed='+is_displayed;
    // console.log('addComment to send =');
    // console.log(toSend);

    preparetoHandle(toSend, path, img_id, url);
}


function displayComment(load_id) {
    var tab = load_id.split(';');

    var img_id = tab[1];
    var user_id = tab[2];
    var action = tab[0];

    var url = './Controller/handleAjax.php';

    var toSend = 'action='+action+'&img_id='+img_id+'&user_id='+user_id;
    var path = 'commentPart';

    preparetoHandle(toSend, path, img_id, url);
}

function deleteImg(load_id) {
    var tab = load_id.split(';');
    
    var img_id = tab[1];
    var user_id = tab[2];
    var action = tab[0];
    var display_id = tab[3];

    var url = './Controller/displayMedia.php';

    var path = 'content_index';
    if (document.getElementById('content_profile') !== null)
        path = 'content_profile';

    var toSend = 'action='+action+'&img_id='+img_id+'&user_id='+user_id+'&display_id='+display_id+'&where='+path;
    
    console.log('deleteImg to send =');
    console.log(toSend);

    preparetoHandleDelete(toSend, path, img_id, url);


}

function displayMore(load_id) {
    var tab = load_id.split(';');
    
    var action = tab[0];
    var nb = tab[1];

    var url = './Controller/displayMedia.php';

    var toSend = 'action='+action+'&nb='+nb;
    var path = 'content_index';
    
    // console.log('DisplayMore to send =');
    // console.log(toSend);

    preparetoHandleAdd(toSend, action, path, nb, url);
}

function showElem(load_id) {
    var tab = load_id.split(';');
    var id = tab[1];
	let bin = document.querySelector('#deleteImg' + id);
    // console.log('Show elem id = ');
    // console.log(id);

    document.getElementById('author'+id).style.display = 'block';
	if (bin)
    	bin.style.display = 'block';
}

function hideElem(load_id) {
    var tab = load_id.split(';');
	var id = tab[1];
	let bin = document.querySelector('#deleteImg' + id);
    // console.log('Show elem id = ');
    // console.log(id);


	document.getElementById('author'+id).style.display = 'none';
	if (bin)
    	bin.style.display = 'none';
}

function displayImage(load_id) {
    var tab = load_id.split(';');
    var img_id = tab[1];

        // console.log('DisplayImage to send =');
        // console.log(img_id);

        document.getElementById('media'+img_id).id = 'Bigmedia'+img_id;
        document.getElementById('Bigmedia'+img_id).className = 'Big_media';
        document.getElementById('description'+img_id).className = 'description';
        document.getElementById('picture;'+img_id).onclick = function (){undisplayImage(this.id)};
}

function undisplayImage(load_id) {
    var tab = load_id.split(';');
    var img_id = tab[1];
    
    // console.log('UndisplayImage to send =');
    // console.log(img_id);

    document.getElementById('Bigmedia'+img_id).id = 'media'+img_id;
    document.getElementById('media'+img_id).className = 'media';
    document.getElementById('description'+img_id).className = 'hidden';
    document.getElementById('picture;'+img_id).onclick = function (){displayImage(this.id)};

}
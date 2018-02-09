

function preparetoHandle(load_id, path)
{
    var xhr = new XMLHttpRequest();
    
    tab = load_id.split(';');
    var action = tab[0];
    var img_id = tab[1];
    var user_id = tab[2];
    var to_send = 'action='+action+'&img_id='+img_id+'&user_id='+user_id;
    var textcomment = 'test';
    if (action == 'addcomment') {
        textcomment = document.getElementById('textcomment;'+img_id+';'+user_id).value;
        to_send += '&text_comment='+textcomment;
    }
    var url = './Controller/handleAjax.php';

    xhr.open('POST', url, true);
    xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');

    xhr.addEventListener('readystatechange', function() {

        if (xhr.readyState === XMLHttpRequest.DONE && xhr.status === 200) {
            var ret = xhr.responseText;
            document.getElementById(path+img_id).innerHTML = ret;
        }
    });
    xhr.send(to_send);
}

function updateNb(load_id, pathNB) {

    var xhr = new XMLHttpRequest();
    
    tab = load_id.split(';');
    
    var img_id = tab[1];
    var to_send = 'action=updateNb&img_id='+img_id;
    if (pathNB == 'nblikes') {
        to_send += '&type=Like(s)';
    }
    else {
        to_send += '&type=Comment(s)';
    }

    var url = './Controller/handleAjax.php';
    xhr.open('POST', url, true);
    xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');

    xhr.addEventListener('readystatechange', function() {

        if (xhr.readyState === XMLHttpRequest.DONE && xhr.status === 200) {
            var ret = xhr.responseText;
            document.getElementById(pathNB+img_id).innerHTML = ret;
        }
    });
    xhr.send(to_send);
}

function refreshComment(load_id, path) {
    var xhr = new XMLHttpRequest();
    
    tab = load_id.split(';');
    var img_id = tab[1];
    var to_send = 'action=refreshComment&img_id='+img_id;
    var textcomment = 'test';
    var url = './Controller/handleAjax.php';

    xhr.open('POST', url, true);
    xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');

    xhr.addEventListener('readystatechange', function() {

        if (xhr.readyState === XMLHttpRequest.DONE && xhr.status === 200) {
            var ret = xhr.responseText;
            console.log("Ret = ");
            console.log(ret);
            console.log(path+img_id);
            document.getElementById(path+img_id).innerHTML = ret;
        }
    });
    xhr.send(to_send);
}

function refreshComment(load_id, path) {
    var xhr = new XMLHttpRequest();
    
    tab = load_id.split(';');
    var img_id = tab[1];
    var to_send = 'action=refreshComment&img_id='+img_id;
    var textcomment = 'test';
    var url = './Controller/handleAjax.php';

    xhr.open('POST', url, true);
    xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');

    xhr.addEventListener('readystatechange', function() {

        if (xhr.readyState === XMLHttpRequest.DONE && xhr.status === 200) {
            var ret = xhr.responseText;
            console.log("Ret = ");
            console.log(ret);
            console.log(path+img_id);
            document.getElementById(path+img_id).innerHTML = ret;
        }
    });
    xhr.send(to_send);
}

function preparetoDisplay(load_id, path) {
    var xhr = new XMLHttpRequest();
    
    tab = load_id.split(';');
    var img_id = tab[1];
    var to_send = 'action=displayComment&img_id='+img_id;
    var url = './Controller/handleAjax.php';

    xhr.open('POST', url, true);
    xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');

    xhr.addEventListener('readystatechange', function() {

        if (xhr.readyState === XMLHttpRequest.DONE && xhr.status === 200) {
            var ret = xhr.responseText;
            console.log("Ret = ");
            console.log(ret);
            console.log(path+img_id);
            document.getElementById(path+img_id).innerHTML = ret;
        }
    });
    xhr.send(to_send);
}

function preparetoUnDisplay(load_id, path) {
    var xhr = new XMLHttpRequest();
    
    tab = load_id.split(';');
    console.log(load_id);
    var img_id = tab[1];
    var to_send = 'action=undisplayComment&img_id='+img_id;
    var url = './Controller/handleAjax.php';

    xhr.open('POST', url, true);
    xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');

    xhr.addEventListener('readystatechange', function() {

        if (xhr.readyState === XMLHttpRequest.DONE && xhr.status === 200) {
            var ret = xhr.responseText;
            console.log("Ret = ");
            console.log(ret);
            console.log(path+img_id);
            document.getElementById(path+img_id).innerHTML = ret;
        }
    });
    xhr.send(to_send);
}


function loadHeart(load_id) {
    var path = 'addlike';
    var pathNB = 'nblikes';
    preparetoHandle(load_id, path);
    updateNb(load_id, pathNB);
}

function addComment(load_id) {
    var path = 'addcomment';
    var pathNB = 'nbcomments';
    var pathRefresh = 'lastcomment';
    preparetoHandle(load_id, path);
    updateNb(load_id, pathNB);
    refreshComment(load_id, pathRefresh);
}

function displayComment(load_id) {
    var path = 'show_comment';
    preparetoDisplay(load_id, path);
}

function undisplayComment(load_id) {
    var path = 'show_comment';
    preparetoUnDisplay(load_id, path);
}


console.log('DANS --> Display.js');
function preparetoHandle(toSend, path, img_id)
{
    var xhr = new XMLHttpRequest();
    
    var url = './Controller/handleAjax.php';

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

function handleLike(load_id) 
{
    tab = load_id.split(';');

    var img_id = tab[1];
    var user_id = tab[2];

    // Prepare addLike
    var action = tab[0];
    var toSend = 'action='+action+'&img_id='+img_id+'&user_id='+user_id;
    var path = 'allAboutLike';

    preparetoHandle(toSend, path, img_id);
}


function addComment(load_id) 
{
    tab = load_id.split(';');
    console.log('add comment');
    console.log(tab);

    var img_id = tab[1];
    var user_id = tab[2];

    var is_displayed = document.getElementById('undisplayComment;'+img_id+';'+user_id);
    if (is_displayed)
        is_displayed = true;
    else
        is_displayed = false;

    // Prepare AddComment
    var action = tab[0];
    var textcomment = document.getElementById('textComment;'+img_id+';'+user_id).value;
    var path = 'commentPart';
    var toSend = 'action='+action+'&img_id='+img_id+'&user_id='+user_id+'&text_comment='+textcomment+'&is_displayed='+is_displayed;
    console.log('addComment to send =');
    console.log(toSend);

    preparetoHandle(toSend, path, img_id);
    element.scrollIntoView('commentPart'+img_id);
}


function displayComment(load_id) {
    tab = load_id.split(';');

    var img_id = tab[1];
    var user_id = tab[2];
    var action = tab[0];
    var toSend = 'action='+action+'&img_id='+img_id+'&user_id='+user_id;
    var path = 'commentPart';

    preparetoHandle(toSend, path, img_id);
}
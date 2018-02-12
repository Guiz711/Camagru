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
    var path = 'handleLike';

    preparetoHandle(toSend, path, img_id);

   // Prepare UpdateNbLikes
   var action = 'updateNb';
   var type = 'Like(s)';
   var path = 'nbLikes';
   var toSend = 'action='+action+'&type='+type+'&img_id='+img_id+'&user_id='+user_id;

   preparetoHandle(toSend, path, img_id);
}


function addComment(load_id) 
{
    tab = load_id.split(';');
    console.log('add comment');
    console.log(tab);

    var img_id = tab[1];
    var user_id = tab[2];

    // Prepare AddComment
    var action = tab[0];
    var textcomment = document.getElementById('textComment;'+img_id+';'+user_id).value;
    var path = 'addComment';
    var toSend = 'action='+action+'&img_id='+img_id+'&user_id='+user_id+'&text_comment='+textcomment;
    console.log('addComment to send =');
    console.log(toSend);

    preparetoHandle(toSend, path, img_id);


    // Prepare UpdateNbComments
    var action = 'updateNb';
    var type = 'Comment(s)';
    var path = 'nbComments';
    var toSend = 'action='+action+'&type='+type+'&img_id='+img_id+'&user_id='+user_id;
    console.log('UpdateNbComments to send =');
    console.log(toSend);

    preparetoHandle(toSend, path, img_id);


    //Prepare RefreshComment
    var action = 'refreshComment';
    var path = 'lastComment';
    var toSend = 'action='+action+'&img_id='+img_id+'&user_id='+user_id;
    console.log('RefreshComment to send =');
    console.log(toSend);

    preparetoHandle(toSend, path, img_id);
}

function displayComment(load_id) {
    tab = load_id.split(';');

    var img_id = tab[1];
    var user_id = tab[2];
    var action = tab[0];
    var toSend = 'action='+action+'&img_id='+img_id+'&user_id='+user_id;
    var path = 'showComment';

    preparetoHandle(toSend, path, img_id);
}
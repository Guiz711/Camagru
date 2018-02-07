{/* <div class="media">
    <div class="img"></div>
    <div class="like"></div>
    <div class="comment"></div>
    <div class="add_like"></div>
    <div class="add_comment"></div>
</div> */}

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
    var url = './Controller/handle_like.php';

    xhr.open('POST', url, true);
    xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
    // On souhaite juste récupérer le contenu du fichier, la méthode GET suffit amplement :

    xhr.addEventListener('readystatechange', function() { // On gère ici une requête asynchrone

        if (xhr.readyState === XMLHttpRequest.DONE && xhr.status === 200) { // Si le fichier est chargé sans erreur
            var ret = xhr.responseText;
            // console.log("Ret = ");
            // console.log(ret);
            // console.log('addlike'+img_id);
            document.getElementById(path+img_id).innerHTML = ret;
        }
    });
    xhr.send(to_send); // La requête est prête, on envoie tout !
}
function loadHeart(load_id) {
    path = 'addlike';
    preparetoHandle(load_id, path);
}

function addComment(load_id) {
    path = 'addcomment';
    preparetoHandle(load_id, path);
}

console.log('DANS --> Display.js');
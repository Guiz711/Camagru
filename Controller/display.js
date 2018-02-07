{/* <div class="media">
    <div class="img"></div>
    <div class="like"></div>
    <div class="comment"></div>
    <div class="add_like"></div>
    <div class="add_comment"></div>
</div> */}

function loadMedia(load_id) {
    
    var xhr = new XMLHttpRequest();
    
    tab = load_id.split(';');
    console.log(tab);
    var action = tab[0];
    var img_id = tab[1];
    var user_id = tab[2];
    console.log(action);
    console.log(img_id);
    console.log(user_id);
    var url = './Controller/handle_like.php';
    var to_send = 'action='+action+'&img_id='+img_id+'&user_id='+user_id;
    

    xhr.open('POST', url, true);
    xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
    // On souhaite juste récupérer le contenu du fichier, la méthode GET suffit amplement :

    xhr.addEventListener('readystatechange', function() { // On gère ici une requête asynchrone

        if (xhr.readyState === XMLHttpRequest.DONE && xhr.status === 200) { // Si le fichier est chargé sans erreur
            var ret = xhr.responseText;
            console.log("Ret = ");
            console.log(ret);
            document.getElementById(load_id).innerHTML = ret;


        }
    });
    xhr.send(to_send); // La requête est prête, on envoie tout !

}

console.log('DANS --> Display.js');
{/* <div class="media">
    <div class="img"></div>
    <div class="like"></div>
    <div class="comment"></div>
    <div class="add_like"></div>
    <div class="add_comment"></div>
</div> */}

function loadMedia(img_path) {
    
    var xhr = new XMLHttpRequest();
    
    // On souhaite juste récupérer le contenu du fichier, la méthode GET suffit amplement :
    
    alert(img_path);

    xhr.addEventListener('readystatechange', function() { // On gère ici une requête asynchrone

        if (xhr.readyState === XMLHttpRequest.DONE && xhr.status === 200) { // Si le fichier est chargé sans erreur
            // alert(xhr.responseText);
            document.getElementById('content').innerHTML = '<img src=' + xhr.responseText + '/>'; // Et on affiche !
            alert('<img src=' + xhr.responseText + '/>');
        }

    });
    xhr.open('GET', img_path);
    xhr.send(null); // La requête est prête, on envoie tout !

}

console.log('DANS --> Display.js');
document.addEventListener('DOMContentLoaded', function() {
    // Ajout des gestionnaires d'événements pour tous les boutons 'Add to library' existants
    var addButtons = document.querySelectorAll('.addlist');
    addButtons.forEach(function(button) {
        button.addEventListener('click', addListe);
    });
});

function addListe(event) {
    // Trouver le conteneur du taxon (le parent de l'élément bouton cliqué)
    var taxonContainer = event.target.closest('.item');

    // Récupérer le nom et l'image du taxon
    var taxonName = taxonContainer.querySelector('h2').textContent;
    var taxonImageSrc = taxonContainer.querySelector('img').src;

    // Créer un nouvel élément de liste pour le taxon
    var newListItem = document.createElement('li');
    newListItem.classList.add('cartitem-li');
    document.getElementById('listeLibrary').style.alignItems = 'center';
    document.getElementById('listeLibrary').style.display = 'grid';

    // Créer un élément image et ajouter l'URL de l'image
    var imageElement = document.createElement('img');
    imageElement.src = taxonImageSrc;
    imageElement.style.width = '100px'; // Ajustez selon vos besoins
    imageElement.style.display = 'flex';


    // Créer un bouton pour supprimer l'élément de la liste
    var deleteButton = document.createElement('button');
    deleteButton.textContent = 'Supprimer';
    deleteButton.onclick = removeListItem; // Fonction de suppression
    deleteButton.classList.add('removeItem'); // Classe pour le style
    deleteButton.style.display = 'flex';
    deleteButton.style.borderRadius = '20px';

    // Ajouter l'image, le nom et le bouton supprimer au nouvel élément de liste
    newListItem.appendChild(imageElement);
    newListItem.appendChild(document.createTextNode(' ' + taxonName + ' '));
    newListItem.appendChild(deleteButton);

    // Ajouter le nouvel élément à la liste 'listCart'
    var listCart = document.getElementById('listeLibrary');
    listCart.appendChild(newListItem);
}

function removeListItem(event) {
    // Récupérer le parent <li> de l'élément bouton cliqué et le supprimer
    var listItem = event.target.closest('li');
    listItem.remove();
}
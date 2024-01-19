let taxaList = [];

const phpScript = './src/Model/API/TaxaAPI.php';
const phpFunction = 'SearchVernacularListJSON';
const taxaName = 'rouge-gorge'; // Replace with the actual value
const sizeQuery = 100; // Replace with the actual value
const apiUrl = `${phpScript}?function=${phpFunction}&name=${encodeURIComponent(taxaName)}&size=${sizeQuery}`;
fetch(apiUrl)
    .then(response => {
        if (!response.ok) {
            console.log(response);
            throw new Error(`HTTP error! Status: ${response.status}`);
        }

        return response.text();
    })
    .then(data => {
        console.log(data);
    })
    .catch(error => {
        console.error('Fetch error:', error);
    });

document.addEventListener('DOMContentLoaded', function() {
    // Ajout des gestionnaires d'événements pour tous les boutons 'Add to library' existants
    var addButtons = document.querySelectorAll('.addlist');
    addButtons.forEach(function(button) {
        button.addEventListener('click', addListe);
    });
});

function searchTaxa(event) {

}

function addListe(event) {
    // Trouver le conteneur du taxon (le parent de l'élément bouton cliqué)
    var taxonContainer = event.target.closest('.item');

    // Récupérer le nom et l'image du taxon
    var taxonName = taxonContainer.querySelector('h2').textContent;
    taxaList.push(taxonName);
    console.log(taxaList);
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

    var spanElement = document.createElement('span');
    spanElement.id = "taxa-id";
    spanElement.textContent = taxonName;

    // Ajouter l'image, le nom et le bouton supprimer au nouvel élément de liste
    newListItem.appendChild(imageElement);
    newListItem.appendChild(spanElement);
    newListItem.appendChild(deleteButton);

    // Ajouter le nouvel élément à la liste 'listCart'
    var listCart = document.getElementById('listeLibrary');
    listCart.appendChild(newListItem);
}

function removeListItem(event) {
    // Récupérer le parent <li> de l'élément bouton cliqué et le supprimer
    var listItem = event.target.closest('li');
    var textElement = listItem.querySelector('#taxa-id');
    var taxaName = textElement.textContent;

    const index = taxaList.indexOf(taxaName);
    if (index > -1) { // only splice array when item is found
        taxaList.splice(index, 1); // 2nd parameter means remove one item only
    }

    listItem.remove();
}
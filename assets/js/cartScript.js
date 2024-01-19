let taxaList = [];
var taxaName = 'rouge-gorge';

// Replace 'https://api.example.com' with the actual API endpoint
const apiUrl = `https://taxref.mnhn.fr/api/taxa/search?frenchVernacularNames=${taxaName}`;
// Make a GET request
fetch(apiUrl)
    .then(response => {
        if (!response.ok) {
            throw new Error(`HTTP error! Status: ${response.status}`);
        }
        return response.json();
    })
    .then(data => {
        var result = processApiData(data);
        console.log(result);
        return result;
    })
    .catch(error => {
        // Handle errors
        console.error('Fetch error:', error);
    });

function processApiData(data) {
    data = data['_embedded']['taxa'];
    var result = [];
    for ( var i = 0; i < data.length; i++) {
        if (data[i]['parentId'] == null) {
            continue;
        }
        var taxaArray = [];
        var taxaId = data[i]['id'];
        var taxaName = data[i]['frenchVernacularName']
        var taxaImg = data[i]['_links']['media'].href;
        taxaArray['id'] = taxaId;
        taxaArray['taxaName'] = taxaName;
        taxaArray['taxaImg'] = taxaImg;
        result.push(taxaArray);
    }
    return result;
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
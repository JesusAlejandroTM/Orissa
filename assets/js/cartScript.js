let taxaList = [];


function apiRequest() {
    var taxaName = document.getElementById('recherche').value;
    const apiUrl = `https://taxref.mnhn.fr/api/taxa/search?frenchVernacularNames=${taxaName}&size=100&page=1`;
    fetch(apiUrl)
        .then(response => {
            if (!response.ok) {
                throw new Error(`HTTP error! Status: ${response.status}`);
            }
            return response.json();
        })
        .then(data => {
            return processApiData(data);
        })
        .then(result => {
            console.log(result);
        })
        .catch(error => {
            // Handle errors
            console.error('Fetch error:', error);
        });
}

function processImage(apiUrl) {
    return fetch(apiUrl)
        .then(response => {
            if (!response.ok) {
                return 'DefaultImage.png';
            }
            return response.json();
        })
        .then(data => {
            if (data && data['_embedded'] && data['_embedded']['media']) {
                return data['_embedded']['media'][0]['_links']['file'].href;
            } else {
                return 'DefaultImage.png';
            }
        })
        .catch(error => {
            console.error('Fetch error:', error);
            return 'DefaultImage.png';
        });
}

async function processApiData(data) {
    data = data['_embedded']['taxa'];
    var result = [];

    var promises = data.map(async (taxon) => {
        if (taxon['parentId'] != null) {
            var taxaObject = {
                id: taxon['id'],
                taxaName: taxon['frenchVernacularName'],
                taxaImg: await processImage(taxon['_links']['media'].href)
            };
            result.push(taxaObject);
        }
    });

    return Promise.all(promises).then(() => result);
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
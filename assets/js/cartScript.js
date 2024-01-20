let taxaList = [];

document.addEventListener('DOMContentLoaded', function() {
    // This code will run after the DOM has fully loaded
    var addButtons = document.querySelectorAll('.addlist');

    addButtons.forEach(function(button) {
        button.addEventListener('click', addListe);
    });
});

function apiRequest() {
    var searchList = document.getElementById('search-list-result');

    if (searchList) {
        while (searchList.firstChild) {
            searchList.removeChild(searchList.firstChild);
        }
    }

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
            var searchList = document.getElementById('search-list-result');
            for (let i = 0; i < result.length; i++)
            {
                let taxaHTML = generateListItem(result[i]);
                searchList.innerHTML += taxaHTML;
            }
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
                return 'Orissa/../assets/img/taxaUnavailable.png';
            }
            return response.json();
        })
        .then(data => {
            if (data && data['_embedded'] && data['_embedded']['media']) {
                return data['_embedded']['media'][0]['_links']['file'].href;
            } else {
                return 'Orissa/../assets/img/taxaUnavailable.png';
            }
        })
        .catch(error => {
            console.error('Fetch error:', error);
            return 'Orissa/../assets/img/taxaUnavailable.png';
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

    var taxaId = taxonContainer.querySelector('#item-id').textContent;

    // S'assurer que le taxa n'est pas déjà dans la liste
    if (taxaList.includes(taxaId)) {
        alert("Ce taxon a déjà été sélectionné!");
        return; // Break
    }

    taxaList.push(taxaId);
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
    spanElement.id = "taxa-name";
    spanElement.textContent = taxonName;

    var spanId = document.createElement('span');
    spanId.id = "taxa-id";
    spanId.textContent = taxaId;
    spanId.className = "hidden";

    // Ajouter l'image, le nom et le bouton supprimer au nouvel élément de liste
    newListItem.appendChild(imageElement);
    newListItem.append(spanId);
    newListItem.appendChild(spanElement);
    newListItem.appendChild(deleteButton);

    // Ajouter le nouvel élément à la liste 'listCart'
    var listCart = document.getElementById('listeLibrary');
    listCart.appendChild(newListItem);
    console.log(taxaList);
}

function removeListItem(event) {
    // Récupérer le parent <li> de l'élément bouton cliqué et le supprimer
    var listItem = event.target.closest('li');
    var textElement = listItem.querySelector('#taxa-id');
    var taxaId = textElement.textContent;

    const index = taxaList.indexOf(taxaId);
    if (index > -1) { // only splice array when item is found
        taxaList.splice(index, 1); // 2nd parameter means remove one item only
    }

    listItem.remove();
}

function generateListItem(taxa) {
    return `
    <li>
      <div class="item">
        <span class="hidden" id="item-id">${taxa.id}</span>
        <img src="${taxa.taxaImg}" alt="img taxon">
        <h2 id="id-taxa">${taxa.taxaName}</h2>
        <button class="addlist" onclick="addListe(event)">Add to library</button>
      </div>
    </li>
  `;
}
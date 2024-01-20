// Récupérer l'image d'un taxon
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

// Nettoyer les données obtenus par l'API
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
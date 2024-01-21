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
async function processApiSearchData(data) {
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

// Nettoyer les données obtenus par l'API à partir de la base de données
async function processApiTaxaData(taxon, taxaCaption, taxaHref) {
    const [taxaName, taxaImg] = await Promise.all([
        taxon['frenchVernacularName'],
        processImage(taxon['_links']['media'].href)
    ]);

    taxaCaption.textContent = taxaName;
    taxaHref.src = taxaImg;
    console.log(taxaName);
}

async function processApiRegisteredTaxaData(taxon, taxaCaption, taxaImageSpace) {
    const [taxaName, taxaImg] = await Promise.all([
        taxon['frenchVernacularName'],
        processImage(taxon['_links']['media'].href)
    ]);

    taxaCaption.textContent = taxaName;
    taxaImageSpace.style.backgroundImage = `url('${taxaImg}')`;
}
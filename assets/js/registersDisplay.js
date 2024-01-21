setTimeout(function() {
    let resultsList = document.getElementById("list-grid");
    for (let i = 0; i < resultsList.children.length; i++)
    {
        let result = resultsList.children[i];
        let taxaLink = result.querySelector("a");
        let taxaId = taxaLink.id;

        let taxaImageSpace = result.querySelector("#imageSpace");
        let taxaCaption = result.querySelector("span");


        apiTaxaUnitRequest(taxaId, taxaCaption, taxaImageSpace);
    }
}, 100);

// Exécuter la requête de recherche de taxon à l'API
function apiTaxaUnitRequest(taxaId, taxaCaption, taxaHref) {
    const apiUrl = `https://taxref.mnhn.fr/api/taxa/${taxaId}`;

    const controller = new AbortController();
    const signal = controller.signal;

    const warningTimeout = setTimeout(() => {
        console.warn("Votre requête semble prendre du temps");
    }, 15000);

    const cancelTimeOut = setTimeout(() => {
            controller.abort();
            console.error("Votre requête a été annulée");
        }, 30000
    )

    fetch(apiUrl, { signal })
        .then(response => {
            clearTimeout(warningTimeout);
            clearTimeout(cancelTimeOut);
            if (!response.ok) {
                throw new Error(`HTTP error! Status: ${response.status}`);
            }
            return response.json();
        })
        .then(data => processApiRegisteredTaxaData(data, taxaCaption, taxaHref))
        .catch(error => {
            console.error('Fetch error:', error);
        });
}
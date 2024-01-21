setTimeout(function() {
    let resultsList = document.getElementById("liste");
    for (let i = 0; i < resultsList.children.length; i++)
    {
        let result = resultsList.children[i];
        let taxaLink = result.querySelector("a");
        let taxaId = taxaLink.id;
        let taxaImage = result.querySelector("img");
        let taxaCaption = result.querySelector("p");
        apiRequest(taxaId, taxaCaption, taxaImage);
    }
}, 100);

// Exécuter la requête de recherche de taxon à l'API
function apiRequest(taxaId, taxaCaption, taxaHref) {
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
        .then(data => processApiTaxaData(data, taxaCaption, taxaHref))
        .catch(error => {
            console.error('Fetch error:', error);
        });
}
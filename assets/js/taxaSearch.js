function searchApi() {
    var searchList = document.getElementById('liste');

    if (searchList) {
        while (searchList.firstChild) {
            searchList.removeChild(searchList.firstChild);
        }
    }

    var taxaName = document.getElementById('taxaName').value;
    const apiUrl = `https://taxref.mnhn.fr/api/taxa/search?frenchVernacularNames=${taxaName}&size=100&page=1`;
    const loader = document.querySelector(".loader--hidden");
    loader.classList = "loader";

    const controller = new AbortController();
    const signal = controller.signal;

    const warningTimeout = setTimeout(() => {
        console.warn("Votre requête semble prendre du temps");
    }, 15000);

    const cancelTimeOut = setTimeout(() => {
            controller.abort();
            loader.classList = "loader--hidden";
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
            loader.classList = "loader--hidden";
            return response.json();
        })
        .then(data => {
            const totalElements = data['page']['totalElements'];
            if (totalElements < 1) {
                throw new Error('No taxas found')
            } else {
                // Process the non-empty 'data'
                return processApiData(data);
            }
        })
        .then(result => {
            var searchList = document.getElementById('liste');
            for (let i = 0; i < result.length; i++)
            {
                let taxaHTML = generateTaxaItem(result[i]);
                searchList.innerHTML += taxaHTML;
            }
        })
        .catch(error => {
            // Handle errors
            console.error('Fetch error:', error);
        });
}

function generateTaxaItem(taxa) {
    return `<li>
                <div class="image">
                    <a href="/Orissa/Taxa/${taxa.id}" class="imageLink">
                        <img src="${taxa.taxaImg}" alt="image">
                    </a>
                </div>
                <div class="caption">
                    <p>${taxa.taxaName}</p>
                </div>
            </li>`;
}
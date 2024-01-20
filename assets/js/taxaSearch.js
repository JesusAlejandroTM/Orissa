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
    fetch(apiUrl)
        .then(response => {
            if (!response.ok) {
                throw new Error(`HTTP error! Status: ${response.status}`);
            }
            loader.classList = "loader--hidden";
            return response.json();
        })
        .then(data => {
            console.log(data);
            return processApiData(data);
        })
        .then(result => {
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
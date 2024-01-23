let currentPage = 1;

function searchApi() {
    var searchList = document.getElementById('liste');

    if (searchList) {
        while (searchList.firstChild) {
            searchList.removeChild(searchList.firstChild);
        }
    }

    let taxaName = document.getElementById('taxaName').value;
    let territory = document.getElementById('territory').value;
    let domain = document.getElementById('domain').value;
    let habitat = document.getElementById('habitat').value;
    let taxonomicRank = document.getElementById('taxonomicRank').value;

    if (!taxaName) {
        alert("Vous devez saisir un nom de taxon!");
        return;
    }

    const apiUrl = `https://taxref.mnhn.fr/api/taxa/search?frenchVernacularNames=${taxaName}&taxonomicRanks=${taxonomicRank}&territories=${territory}&domain=${domain}&habitats=${habitat}&page=${currentPage}&size=100`;
    const loader = document.querySelector(".loader--hidden");
    loader.classList = "loader";

    const controller = new AbortController();
    const signal = controller.signal;

    const warningTimeout = setTimeout(() => {
        alert("Votre requête semble prendre du temps");
    }, 15000);

    const cancelTimeOut = setTimeout(() => {
            controller.abort();
            loader.classList = "loader--hidden";
            alert("Votre requête a été annulée");
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
            const totalTaxas = data['page']['size'];
                if (totalTaxas < 1) {
                throw new Error('Pas de taxon trouvé')
            } else {
                // Process the non-empty 'data'
                return processApiSearchData(data);
            }
        })
        .then(result => {
            var searchList = document.getElementById('liste');
            for (let i = 0; i < result.length; i++)
            {
                let taxaHTML = generateTaxaItem(result[i]);
                searchList.innerHTML += taxaHTML;
            }
            addPaginationControls();
        })
        .catch(error => {
            // Handle errors
            alert(error);
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
function addPaginationControls() {
    var paginationContainer = document.getElementById('pagination-container');
    paginationContainer.innerHTML = '';

    var prevButton = document.createElement('button');
    prevButton.textContent = 'Previous Page';
    prevButton.onclick = function () {
        changePage('prev');
    };
    paginationContainer.appendChild(prevButton);

    var nextButton = document.createElement('button');
    nextButton.textContent = 'Next Page';
    nextButton.onclick = function () {
        changePage('next');
    };
    paginationContainer.appendChild(nextButton);
}

function changePage(direction) {
    if (direction === 'prev' && currentPage > 1) {
        currentPage--;
    } else if (direction === 'next') {
        currentPage++;
    }

    searchApi();
}
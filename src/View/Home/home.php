<main>
    <div id="fond" class="content">
        <h1>ORISSA : RECHERCHE TAXONOMIQUE DE <br> TAXONS</h1>
        <p>La recherche taxonomique de Orissa vous permet de rechercher les différents êtres vivants de la divérsité du monde
        vivant français<br> et étudier les différentes branches et catégories grâce à la source d'informations TaxRef</p>
    </div>

    <div class="mainContainer">
        <h2>Parcourir</h2>
        <br>
        <h3>Orissa vous donne le plaisir d'offrir une toute nouvelle éxperience de recherche. Vous pouvez 
            retrouver les animaux, les plantes, les bactéries et plus encore en naviguant dans les différentes catégories qu'on vous met à disposition.
            Nous vous conseillons de jeter un coup d'oeil à notre page et créer et consulter vos propres naturothèques,
            ou encore à notre page decouverte qui vous amenèra sur une page aléatoire de taxon.</h3>
        <br>

        <div class="rows">
        <div class="item">
            <div class="image-container" id="bibliotheques1"></div>
            <button id="button2"><a href="Search">Recherche</a></button>
        </div>

        <div class="item">
            <div class="image-container" id="bibliotheques2"></div>
            <button id="button2"><a href="Library/CreateLibrary">Naturothèques</a></button>
        </div>
        <div class="item">
            <div class="image-container" id="bibliotheques3"></div>
            <button id="button3"><a href="Home/Discovery">Decouverte</a></button>
        </div>
    </div>
    </div>
</main>
<script>
    document.querySelectorAll('.rows .item').forEach(container => {
        container.addEventListener('mouseover', function () {
            this.style.transform = 'scale(1.1)';
            this.style.transition = 'transform 0.5s ease'; // Ajout d'une transition pour un effet plus fluide
        });

        container.addEventListener('mouseout', function () {
            this.style.transform = 'scale(1.0)';
            this.style.transition = 'transform 0.5s ease'; // Ajout d'une transition pour un effet plus fluide
        });
    });
</script>
<script>
    // Animation de défilement fluide pour les liens de navigation
    document.querySelectorAll('a[href^="#"]').forEach(anchor => {
        anchor.addEventListener('click', function (e) {
            e.preventDefault();

            document.querySelector(this.getAttribute('href')).scrollIntoView({
                behavior: 'smooth'
            });
        });
    });
    // main
    window.onload = function() {
    var image = document.getElementById('#fond');
    image.onmouseover = function() {
        this.style.transform = 'scale(1.1)';
        this.style.opacity = '0.7';
    }
    image.onmouseout = function() {
        this.style.transform = 'scale(1.0)';
        this.style.opacity = '1.0';
    }
}
    // Effet de survol pour les images
    document.querySelectorAll('.image-container').forEach(container => {
    container.addEventListener('mouseover', function () {
        this.style.transform = 'scale(1)';
        this.style.transition = 'transform 0.5s ease'; // Ajout d'une transition pour un effet plus fluide
    });

    container.addEventListener('mouseout', function () {
        this.style.transform = 'scale(1.0)';
        this.style.transition = 'transform 0.5s ease'; // Ajout d'une transition pour un effet plus fluide
    });
    });

    window.onload = function() {
    var textP = document.querySelector("#fond p").innerText;
    var wordsP = textP.split(" ");
    var iP = 0;

    var texth1 = document.querySelector("#fond h1").innerText;
    var lettersh1 = texth1.split("");
    var ih1 = 0;

    function updateTextP() {
        if (iP < wordsP.length) {
            document.querySelector("#fond p").innerText = wordsP.slice(0, iP+1).join(" ");
            iP++;
        } else {
            clearInterval(intervalIdP);
        }
    }

    function updateTexth1() {
        if (ih1 < lettersh1.length) {
            document.querySelector("#fond h1").innerText = lettersh1.slice(0, ih1+1).join("");
            ih1++;
        } else {
            clearInterval(intervalIdh1);
        }
    }

    var intervalIdP = setInterval(updateTextP, 90);
    var intervalIdh1 = setInterval(updateTexth1, 70); // Augmenter l'intervalle pour ralentir l'affichage
}
</script>

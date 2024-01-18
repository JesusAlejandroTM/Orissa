<!DOCTYPE html>
<html lang="fr">

<head>
    <title>create-library</title>
    <link rel="stylesheet" href="library.css">
    <script src="library.js"></script>
    <meta charset="utf-8">
</head>

<body>
    <div class="page-creation">

        <div class="create-library-box">
            <h1>Create Library</h1>
            <form class="Library-Form" method="post">

                <div class="textbox">
                    <label for="title_id">Titre de naturothèque :</label>
                    <input type="text" name="title" placeholder="title" id="title_id">
                </div>

                <div class="wrapped ">
                    <label for="description_id">Description de votre naturothèque :</label>
                    <input type="text" name="description" placeholder="description" id="description_id">

                </div>
                <input type="submit" value="create">

                <script>
                    const textarea = document.querySelector('textarea');
                    textarea.addEventListener('keydown', e => {
                        textarea.style.height = `59px`;
                        let scHeight = e.target.scrollHeight;

                        textarea.style.height = `${scHeight}px`;

                    }
                    )
                </script>
            </form>

        </div>


        <div class="container-rech">
            <header>
                <div class="titre">LIST TAXON</div>


            </header>


            <div id="recherche_barre">
                <input type="text" name="recherche" placeholder="Rechercher" id="recherche">
                <input type="submit" name="recherche" value="Rechercher">
            </div>

            <div class="registered">
                <input type="checkbox" name="registered" id="registered">
                <label for="registered">Register</label>

            </div>

            <div class="list-taxon">
                <ul class="list-item-ul" id="">
                    <li>
                        <div class="item">
                            <img src="../../../../../../Users/jesus/Downloads/library/create-library/orissa-remove-copy.png" alt="img taxon">
                            <h2>nom taxon</h2>
                            <button class="addlist" onclick="addListe()">Add to library</button>
                        </div>
                    </li>
                </ul>
            </div>
        </div>
    </div>

    <div class="cartTab">
        <h1>Library list</h1>
        <div class="listcart">
            <ul id="listeLibrary">
            </ul>
        </div>
        <div class="btn">
            <button class="save">SAVE</button>
        </div>

    </div>
</body>

</html>
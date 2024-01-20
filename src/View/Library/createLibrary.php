<div class="loader--hidden"></div>
<div class="creationContainer">
    <div class="page-creation">
        <div class="create-library-box">
            <h1>Create Library</h1>
            <form id="formId" method="POST" class="Library-Form">

                <div class="textbox">
                    <input type="text" name="title" id="title_id" required>
                    <label for="title_id">Titre de naturothèque :</label>
                </div>

                <div class="textbox ">
                    <input type="text" name="description" id="description_id" required>
                    <label for="description_id">Description de votre naturothèque :</label>
                </div>

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
            <div class="titre"><h1>Recherche Taxons</h1></div>

            <div id="recherche_barre">
                <input type="text" name="recherche" placeholder="Rechercher" id="recherche">
                <input type="submit" name="recherche" value="Rechercher" onclick="apiRequest()">
            </div>

            <div class="registered">
                <input type="checkbox" name="registered" id="registered">
                <label for="registered">Register</label>

            </div>

            <div class="list-taxon">
                <ul class="list-item-ul" id="search-list-result">
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
            <input form="formId" type="submit" value="SAVE" id="saveButton" onclick="sendData()">
        </div>
    </div>
</div>
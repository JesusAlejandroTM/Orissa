<div>
    <form method="GET" action="Search/SearchTaxas">
        <h2>Search taxa</h2>
        <div>
            <label for="taxaName"></label>
            <input type="text" id="taxaName" name="taxaName" placeholder="Rouge-Gorge" required>
        </div>
        <div>
            <input type="submit" value="Search"/>
        </div>
    </form>
    <?php
        if (isset($taxaArrays)) {
            echo '<br><h1>Taxas found :</h1><ul>';
            foreach($taxaArrays as $taxa){
                //TODO Link Taxa HREF to a web page
                echo '<li>' . $taxa->getVernacularName() . '<a href=""></a></li>';
            }
            echo '</ul>';
        }
    ?>
</div>
<header>

    <a href="/Orissa" class="logo"><img src="orissa-logo.png" alt="logo" /></a>


    <ul>
        <li><a href="">MAIN</a></li>
        <li><a href="">LIBRARY</a></li>
        <li><a href="">ARTICLE</a></li>
        <li><a href="">TAXON</a></li>
        <li><a href="">ROLE</a></li>
        <li><a href="">DISCOVER</a></li>
        <li><a href="">ABOUT</a></li>
        <!-- <li><form class="searchbarr ">
        <input type="text" name="text" class="search" placeholder="Search">
        <input type="submit" name="submit" class="submit" value="Search">
      </form></li>  -->
        <li><a href="">Login</a></li>
    </ul>
    <div class="search">
            <span class="icon">
                <ion-icon name="search-outline" class="searchBtn"></ion-icon>
                <ion-icon name="close-outline" class="closeBtn"></ion-icon>
            </span>
    </div>
    <div class="searchBox">
        <input type="text" name="text" class="search" placeholder="Search">
    </div>
</header>
<script type="module" src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.esm.js"></script>
<script nomodule src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.js"></script>
<script>
    let searchBtn = document.querySelector(".searchBtn");
    let closeBtn = document.querySelector(".closeBtn");
    let searchBox = document.querySelector(".searchBox");

    searchBtn.onclick = function () {
        searchBox.classList.add("active");
        closeBtn.classList.add("active");
        searchBtn.classList.add("active");
    }

    closeBtn.onclick = function () {
        searchBox.classList.remove("active");
        closeBtn.classList.remove("active");
        searchBtn.classList.remove("active");
    }
</script>
<div class="container">
</div>
<div class="container2">
    <p>
    </p>
</div>

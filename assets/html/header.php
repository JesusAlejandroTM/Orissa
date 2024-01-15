<header>
    <a href="/Orissa" class="logo"><img src="Orissa/../assets/img/orissa-logo.png" alt="logo" /></a>
    <ul>
        <li><a href="">LIBRARY</a></li>
        <li><a href="">ARTICLE</a></li>
        <li><a href="Taxa">TAXON</a></li>
        <li><a href="">ROLE</a></li>
        <li><a href="">DISCOVER</a></li>
        <li><a href="">ABOUT</a></li>
    </ul>
    <div class="search">
        <a href="Search" class="searchIcon">
            <span>
                <ion-icon name="search-outline" class="searchBtn"></ion-icon>
            </span>
        </a>
        <?php
            use App\Code\Lib\UserSession;
            if (UserSession::isConnected()) {
                echo '
            <a href="Profile">
            <span>
                <ion-icon name="people-outline" class="searchBtn"></ion-icon>
            </span>
            </a>';
            }
            else {
                echo '
            <a href="Login">
            <span>
                <ion-icon name="log-in-outline" class="searchBtn"></ion-icon>
            </span>
            </a>';
            }
        ?>
    </div>
    <script type="module" src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.esm.js"></script>
    <script nomodule src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.js"></script>
</header>
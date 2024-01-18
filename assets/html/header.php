<header>
    <a href="/Orissa" class="logo"><img src="Orissa/../assets/img/orissa-logo.png" alt="logo" /></a>
    <ul>
        <li><a href="Library">LIBRARY</a></li>
        <li><a href="Search">TAXON</a></li>
        <li><a href="">DISCOVER</a></li>
        <li><a href="Home">ABOUT</a></li>
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
                $link = 'Profile';
                $icon = 'people-outline';
            }
            else {
                $link = 'Login';
                $icon = 'log-in-outline';
            }

            echo '
            <a href="' . $link . '">
            <span>
                <ion-icon name="' . $icon . '" class="searchBtn"></ion-icon>
            </span>
            </a>';
        ?>
    </div>
    <script type="module" src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.esm.js"></script>
    <script nomodule src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.js"></script>
</header>
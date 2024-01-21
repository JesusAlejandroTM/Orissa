<header>
    <div class="nav-container">

        <div class="navbar">
            <a href="/Orissa" class="logo"><img src="Orissa/../assets/img/orissa-logo.png" alt="logo" /></a>

            <!-- Move the mobile menu toggle inside the navbar -->
            <div class="menu-toggle" id="mobile-menu">
                <span class="bar"></span>
                <span class="bar"></span>
                <span class="bar"></span>
            </div>

            <ul class="nav-menu">
                <li><a href="Library" class="nav-links">LIBRARY</a></li>
                <li><a href="Search" class="nav-links">TAXON</a></li>
                <li><a href="" class="nav-links">DISCOVER</a></li>
                <li><a href="Home" class="nav-links">ABOUT</a></li>
            


              <li>
                  <div class="search">
                      <a href="Search" class="searchIcon">
                          <span>
                              <ion-icon name="search-outline" class="searchBtn"></ion-icon>
                          </span>
                      </a>
                  </div>
              </li>
               
                <?php

                use App\Code\Lib\UserSession;

                if (UserSession::isConnected()) {
                    $link = 'Profile';
                    $icon = 'people-outline';
                } else {
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
        </div>
   
    <script type="module" src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.esm.js"></script>
    <script nomodule src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.js"></script>

    <script>
        const menu =document.querySelector('#mobile-menu');
        const menuLinks = document.querySelector('.nav-menu');
      
        menu.addEventListener('click', function() {
            menu.classList.toggle('is-active');
            menuLinks.classList.toggle('active');
        });

    
    

    </script>
    </div>
    </div>
</header>

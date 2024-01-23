<div class="login-box">
    <h1>Connexion</h1>
    <form method="GET" action="Login/logging">
        <div class="textbox">
            <input type="text" id="username" name="username" required>
            <label>Nom d'utilisateur</label>
        </div>

        <div class="textbox">
            <input type="password" id="password" name="password" required>
            <span></span>
            <label>Mot de passe</label>
        </div>
        <input type="submit" value="Login">


        <div class="signup">
            <p>Vous n'avez pas de compte? <a href="Login/CreateAccount"><br>Créer un compte</a></p>
        </div>
    </form>
</div>
<div class="login-box">
    <h1>Créer un compte</h1>
    <form method="GET" action="Login/create">
        <div class="textbox">
            <input type="text" id="username" name="username" required>
            <label>Nom d'utilisateur</label>
        </div>
        <div class="textbox">
            <input type="password" id="password" name="password" required>
            <span></span>
            <label>Mot de passe</label>
        </div>
        <div class="textbox">
            <input type="text" name="birthdate" id="birthdate" onfocus="(this.type='date')" onblur="if(!this.value) this.type='text'" required>
            <span></span>
            <label for="dateInput">Date de naissance</label>
        </div>
        <div class="textbox">

            <input type="email" name="email" id="email" required>
            <span></span>
            <label>Adresse mail</label>
        </div>
        <input type="submit" value="Create Account">
        <div class="signup">
            <p>Vous possédez déjà un compte?<a href="Login"><br>Connexion</a></p>
        </div>
    </form>
</div>
<section>
    <div class="imgBox">
        <img src="Assets/img/medusa.jpeg" alt="image">
        <div class="contentBox">
            <div class="formBox">
                <form action="Login/logging" method="GET">
                    <h2>Login</h2>
                    <fieldset>
                        <p>
                            <label for="usernameId">Username : </label>
                            <input type="text" name="username" placeholder="username" id="usernameId">
                        </p>
                        <p>
                            <label for="passwordId">Password : </label>
                            <input type="password" name="password" placeholder="password" id="passwordId">
                        </p>
                        <p>
                            <label for="emailId">Mail : </label>
                            <input type="email" name="email" placeholder="mail" id="emailId">
                        </p>
                        <p><input type="submit" value="Envoyer"/></p>
                        <p><a class="forgetpwd" href="#">Forgot password?</a></p>
                        <p class="message">Not registered? <a href="#">Create account</a></p>
                    </fieldset>
                </form>
            </div>
        </div>
    </div>
</section>
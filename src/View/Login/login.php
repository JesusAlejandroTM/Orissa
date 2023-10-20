<section>
    <div class="imgBox">
        <img src="Assets/img/medusa.jpeg" alt="image">
    </div>
    <div class="contentBox">
        <div class="formBox">
            <form action="Login" method="GET">
                <input type="hidden" name="controller" value="login"/>
                <input type="hidden" name="action"  value="logging"/>
                <h2>Login</h2>
                <fieldset>
                    <input type="text" name="username" placeholder="Username">
                    <br>
                    <input type="password" name="password" placeholder="Password">
                    <br>
                    <input type="email" name="email" placeholder="Email">
                    <br>
                    <input type="submit" name="login" value="Login">
                    <br>
                    <p><a class="forgetpwd" href="#">Forgot password?</a></p>
                    <p class="message">Not registered? <a href="#">Create account</a></p>
                </fieldset>
            </form>
        </div>
    </div>
</section>





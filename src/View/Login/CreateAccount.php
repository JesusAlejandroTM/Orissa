<div class="diagonal-image"></div>
<div class="form-container">
    <h2 class="create-title">CREATE ACCOUNT</h2>
    <form method="GET" action="Login/create">
        <div class="form-group">
            <input type="email" id="email" name="email" placeholder="Mail" required>
        </div>
        <div class="form-group">
            <input type="text" id="username" name="username" placeholder="Username" required>
        </div>
        <div class="form-group">
            <input type="password" id="password" name="password" placeholder="Password" required>
        </div>
        <div class="form-group">
            <input type="date" id="birthdate" name="birthdate" placeholder="12-02-2005" required>
        </div>
        <div class="form-group super-user-group">
            <span class="super-user-text">Do you want to be a super user?</span>
            <span class="super-user-icon">?</span>
        </div>
        <div class="form-login">
            <a href="Login" class="login">I already have an account.</a>
        </div>
        <br>
        <div class="form-group">
            <input class="submit-btn" type="submit" value="Create Account"/>
        </div>
    </form>
</div>
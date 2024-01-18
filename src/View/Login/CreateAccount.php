<div class="login-box">
    <h1>Create Account</h1>
    <form method="GET" action="Login/create">
        <div class="textbox">
            <input type="text" id="username" name="username" required>
            <label>Username</label>
        </div>
        <div class="textbox">
            <input type="password" id="password" name="password" required>
            <span></span>
            <label>Password</label>
        </div>
        <div class="textbox">
            <input type="text" name="birthdate" id="birthdate" onfocus="(this.type='date')" onblur="if(!this.value) this.type='text'" required>
            <span></span>
            <label for="dateInput">Date of Birth</label>
        </div>
        <div class="textbox">

            <input type="email" name="email" id="email" required>
            <span></span>
            <label>Email</label>
        </div>
        <input type="submit" value="Create Account">
        <div class="sign">
            <p>You already have account<a href="#"> Login</a></p>
        </div>
    </form>
</div>
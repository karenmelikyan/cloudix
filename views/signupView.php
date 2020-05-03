<br/>
<div align="center">
    <a href="<?= Config::$conf['domain']; ?>"><h1>Cloudix</h1></a>
</div>

<div id="login-box">
    <div class="left">
        <h1>Sign Up</h1>
        <form action="index.php?r=user/signup" method="post">
            <input type="text" name="username" required placeholder="Username" />
            <input type="password" name="password" required placeholder="Password" />
            <input type="password" name="password2" required placeholder="Retype password" />
            <input type="submit" value="Sign me up" />
        </form>
    </div>

    <div class="right">
        <h1>Log In</h1>
        <form action="index.php?r=user/login" method="post">
            <input type="text" name="username" required placeholder="Username" />
            <input type="password" name="password" required placeholder="Password" />
            <input type="submit"  value="Log In" />
        </form>
    </div>
    <div class="or">OR</div>
</div>

<div align="center">
    <h3><?= $message ?></h3>
</div>







<br/>
<div align="center">
    <a href="<?= Config::$conf['domain']; ?>"><h1>Cloudix</h1></a>
</div>

<div id="login-box">
    <div class="left">
        <h1>SignUp/LogIn</h1>
        <th>____________________________________________________________</th>
        <form action="index.php?r=user/" method="post">
            <input type="submit" value="Signup/Login" />
        </form>
        <th>____________________________________________________________</th>
        <h1>Upload Files</h1>
        <form action="index.php?r=file/" method="post">
            <input type="submit" value="Upload" />
        </form>
    </div>

    <div class="right">
        <h1>Views Files</h1>
        <th>__________________</th>
        <form action="index.php?r=file/show" method="post">
            <input type="submit" value="View" />
        </form>
        <th>__________________</th>
    </div>
</div>

<div align="center">
    <?php if(isset($_SESSION['user'])):?>
        <?php if($_SESSION['user']): ?>
            <th>Welcome <?= $_SESSION['user']; ?></th>
            <a href="<?= Config::$conf['domain'] . '/index.php?r=user/logout'; ?>"> | Log Out</a>
        <?php endif; ?>
    <?php endif; ?>
</div>






<br/>
<div align="center">
    <a href="<?= Config::$conf['domain']; ?>"><h1>Cloudix</h1></a>
</div>

<div id="login-box">
    <div class="left">
        <h1>Upload File</h1>
        <th>____________________________________________________________</th>
            <form method="post" action="/index.php?r=file/upload" enctype="multipart/form-data">
                <input type="file" name="file" />
                <input type="submit" value="Upload" />
            </form>
        <th>____________________________________________________________</th>
        <form action="index.php?r=file/show" method="post">
            <input type="submit" value="View" />
        </form>
    </div>
</div>

<div align="center">
    <h3><?= $message ?></h3>
    <?php if(isset($_SESSION['user'])): ?>
        <?php if($_SESSION['user']): ?>
            <th>Welcome <?= $_SESSION['user']; ?></th>
            <a href="<?= Config::$conf['domain'] . '/index.php?r=user/logout'; ?>"> | Log Out</a>
        <?php endif; ?>
    <?php endif; ?>
</div>




<br/>
<div align="center">
    <a href="<?= Config::$conf['domain']; ?>"><h1>Cloudix</h1></a>
    <br/>
    <br/>
    <br/>
    <br/>
    <br/>
    <table>
        <thead>
            <tr>
                <th>Download</th>
            </tr>
        </thead>
        <tbody>
            <?php for($i = 0; $i < count($dbData); $i ++): ?>
                <tr>
                    <td><a class="button" href="/index.php?r=file/download&filePath=storage/<?= $dbData[$i][1] ?>"><?= $dbData[$i][1] ?></a></td>
                    <td><div class="fb-share-button" data-href="<?= Config::$conf['domain'] . '/storage/' . $dbData[$i][1]; ?>" data-layout="button_count" data-size="small"><a target="_blank" href="https://www.facebook.com/sharer/sharer.php?u=https%3A%2F%2Fdevelopers.facebook.com%2Fdocs%2Fplugins%2F&amp;src=sdkpreparse" class="fb-xfbml-parse-ignore">Share</a></div></td>
                </tr>
            <?php endfor; ?>
        </tbody>
    </table>
</div>
<!doctype html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Download covers</title>
    <script src="https://cdn.tailwindcss.com?plugins=typography"></script>
</head>

<body class="p-4 bg-green-200">
    <h1 class="text-2xl font-bold mb-2">Download covers</h1>
    <div class="max-w-3xl bg-white/75 border rounded-md shadow-xl p-4">
        <?php
        $download_url = "https://pverhaert.sinners.be/covers_vinylshop.zip";
        $download_to = "storage/covers.zip";

        $script = basename($_SERVER['PHP_SELF']);
        file_put_contents($download_to, fopen($download_url, 'r'));
        $path = pathinfo(realpath($download_to), PATHINFO_DIRNAME);
        $zip = new ZipArchive;
        $res = $zip->open($download_to);
        if ($res === TRUE) {
            $zip->extractTo($path);
            $zip->close();
            echo "<p>The file <b>$download_url</b><br>was successfully extracted to <b>$path</b></p>";
            unlink($download_to);
        } else {
            echo "<p>Couldn't open <b>$download_to</b></p>";
        }
        echo '<p class="mt-6"><a href="/" class="px-6 py-2 bg-green-600 text-white rounded">BACK HOME</a></p>';
        ?>
    </div>
</body>

</html>

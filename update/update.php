<?php
// update/update.php
include 'version.php';
include 'check_update.php';

function downloadAndExtract($url, $path) {
    $zipFile = "$path/update.zip";
    file_put_contents($zipFile, fopen($url, 'r'));

    $zip = new ZipArchive;
    if ($zip->open($zipFile) === TRUE) {
        $zip->extractTo($path);
        $zip->close();
        unlink($zipFile);
        return true;
    } else {
        return false;
    }
}

function updateVersionFile($newVersion) {
    file_put_contents('version.php', "<?php\n\$currentVersion = '$newVersion';\nfunction getCurrentVersion() { return \$GLOBALS['currentVersion']; }\n");
}

$repoOwner = 'vexato';
$repoName = 'vexato-panel';
$latestVersion = getLatestReleaseVersion();

$url = "https://github.com/$repoOwner/$repoName/releases/download/$latestVersion/update.zip";
$path = __DIR__; // Le répertoire actuel de votre panel

if (downloadAndExtract($url, $path)) {
    updateVersionFile($latestVersion);
    echo json_encode([
        'status' => 'update_successful',
        'new_version' => $latestVersion
    ]);
} else {
    echo json_encode([
        'status' => 'update_failed'
    ]);
}

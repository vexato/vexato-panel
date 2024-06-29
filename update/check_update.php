<?php
// update/check_update.php
include 'version.php';

function getLatestReleaseVersion() {
    $url = "https://api.github.com/repos/vexato/vexato-panel/releases/latest";
    $opts = [
        "http" => [
            "method" => "GET",
            "header" => [
                "User-Agent: PHP"
            ]
        ]
    ];
    $context = stream_context_create($opts);
    $response = file_get_contents($url, false, $context);
    $release = json_decode($response, true);
    return $release['tag_name'];
}

$currentVersion = getCurrentVersion();
$latestVersion = getLatestReleaseVersion();

if ($latestVersion !== $currentVersion) {
    echo json_encode([
        'status' => 'update_available',
        'latest_version' => $latestVersion
    ]);
} else {
    echo json_encode([
        'status' => 'up_to_date'
    ]);
}

<?php

// Fonction pour récupérer la dernière version depuis GitHub
function getLatestVersionFromGitHub($owner, $repo, $token) {
    $url = "https://api.github.com/repos/{$owner}/{$repo}/releases/latest";
    $opts = [
        'http' => [
            'method' => 'GET',
            'header' => "Authorization: token {$token}\r\n" .
                        "User-Agent: MyPanelApp\r\n"
        ]
    ];
    $context = stream_context_create($opts);
    $response = file_get_contents($url, false, $context);
    $data = json_decode($response, true);
    return isset($data['tag_name']) ? $data['tag_name'] : null;
}


// Variables pour GitHub
$github_owner = 'vexato';
$github_repo = 'vexato-panel';

// Récupérer la version actuelle de votre application (dans un fichier texte par exemple)
$current_version = file_get_contents('version.txt');

// Récupérer la dernière version depuis GitHub
$github_token = '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';
$latest_version = getLatestVersionFromGitHub($github_owner, $github_repo, $github_token);


// Comparaison des versions
if (version_compare($current_version, $latest_version, '<')) {
    // Télécharger et mettre à jour vers la dernière version
    $url = "https://github.com/{$github_owner}/{$github_repo}/archive/{$latest_version}.zip";
    $zipFile = 'update.zip';
    file_put_contents($zipFile, file_get_contents($url));

    // Extraire le contenu de l'archive
    $zip = new ZipArchive;
    if ($zip->open($zipFile) === TRUE) {
        $zip->extractTo('./'); // Extraire dans le répertoire courant (vous pouvez spécifier un autre répertoire)
        $zip->close();
        echo 'Mise à jour réussie vers la version '.$latest_version;
    } else {
        echo 'Échec de l\'extraction de l\'archive';
    }
    unlink($zipFile); // Supprimer le fichier zip après extraction
} else {
    echo 'Votre application est déjà à jour.';
}

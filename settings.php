<?php
require_once './utils/logs.php';
session_start();
$configFilePath = './conn.php';
if (!file_exists($configFilePath)) {
    header('Location: setdb');
    exit();
}
require_once './connexion_bdd.php';
require('./auth.php');
if (isset($_POST['logout'])) {
    session_unset();
    session_destroy();
    header('Location: account/connexion');
    exit();
}
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST["submit_roles_settings"])) {
        // Traitement des rôles
        for ($i = 1; $i <= 8; $i++) {
            $roleName = $_POST["role" . $i . "_name"];
            $backgroundUrl = $_POST["role" . $i . "_background"];

            if (!empty($roleName)) {
                $sql = "SELECT role_name, role_background FROM roles WHERE id = :id";
                $stmt = $pdo->prepare($sql);
                $stmt->bindParam(':id', $i);
                $stmt->execute();
                $previousData = $stmt->fetch(PDO::FETCH_ASSOC);

                if ($previousData['role_name'] != $roleName || $previousData['role_background'] != $backgroundUrl) {
                    $sql = "UPDATE roles SET role_name = :role_name, role_background = :role_background WHERE id = :id";
                    $stmt = $pdo->prepare($sql);
                    $stmt->bindParam(':id', $i);
                    $stmt->bindParam(':role_name', $roleName);
                    $stmt->bindParam(':role_background', $backgroundUrl);
                    $stmt->execute();

                    // Enregistrer l'action dans les logs
                    $action = "Modification du rôle $roleName avec l'image de fond $backgroundUrl";
                    logAction($_SESSION['user_email'], $action);
                }
            }
        }
    } elseif (isset($_POST["submit_maintenance"])) {
        // Traitement de la maintenance
        $maintenance = isset($_POST["maintenance"]) ? 1 : 0;
        $maintenance_message = $_POST["maintenance_message"];

        $sql = "SELECT maintenance, maintenance_message FROM options";
        $stmt = $pdo->query($sql);
        $previousData = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($previousData['maintenance'] != $maintenance || $previousData['maintenance_message'] != $maintenance_message) {
            $sql = "UPDATE options SET maintenance = :maintenance, maintenance_message = :maintenance_message";
            $stmt = $pdo->prepare($sql);
            $stmt->bindParam(':maintenance', $maintenance);
            $stmt->bindParam(':maintenance_message', $maintenance_message);
            $stmt->execute();

            // Enregistrer l'action dans les logs
            $action = "Modification du mode maintenance avec message : $maintenance_message";
            logAction($_SESSION['user_email'], $action);
        }

    } elseif (isset($_POST["submit_server_info"])) {
        // Traitement des informations du serveur
        $server_img = $_POST["server_img"];
        $server_name = $_POST["server_name"];
        $server_ip = $_POST["server_ip"];
        $server_port = $_POST["server_port"];

        $sql = "SELECT server_img, server_name, server_ip, server_port FROM options";
        $stmt = $pdo->query($sql);
        $previousData = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($previousData['server_img'] != $server_img || $previousData['server_name'] != $server_name || $previousData['server_ip'] != $server_ip || $previousData['server_port'] != $server_port) {
            $sql = "UPDATE options SET server_img = :server_img, server_name = :server_name, server_ip = :server_ip, server_port = :server_port";
            $stmt = $pdo->prepare($sql);
            $stmt->bindParam(':server_img', $server_img);
            $stmt->bindParam(':server_name', $server_name);
            $stmt->bindParam(':server_ip', $server_ip);
            $stmt->bindParam(':server_port', $server_port);
            $stmt->execute();

            // Enregistrer l'action dans les logs
            $action = "Modification des informations du serveur : $server_name, $server_ip:$server_port";
            logAction($_SESSION['user_email'], $action);
        }

    } elseif (isset($_POST["submit_loader_settings"])) {
        // Traitement des paramètres de chargement
        $game_folder_name = $_POST["minecraft_version"];
        $loader_type = $_POST["loader_type"];
        $loader_build_version = $_POST["loader_build_version"];
        $loader_activation = isset($_POST["loader_activation"]) ? 1 : 0;

        $sql = "SELECT minecraft_version, loader_type, loader_build_version, loader_activation FROM options";
        $stmt = $pdo->query($sql);
        $previousData = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($previousData['minecraft_version'] != $game_folder_name || $previousData['loader_type'] != $loader_type || $previousData['loader_build_version'] != $loader_build_version || $previousData['loader_activation'] != $loader_activation) {
            $sql = "UPDATE options SET minecraft_version = :minecraft_version, loader_type = :loader_type, loader_build_version = :loader_build_version, loader_activation = :loader_activation";
            $stmt = $pdo->prepare($sql);
            $stmt->bindParam(':minecraft_version', $game_folder_name);
            $stmt->bindParam(':loader_type', $loader_type);
            $stmt->bindParam(':loader_build_version', $loader_build_version);
            $stmt->bindParam(':loader_activation', $loader_activation);
            $stmt->execute();

            // Enregistrer l'action dans les logs
            $action = "Modification des paramètres de chargement : $loader_type, version $loader_build_version, activation $loader_activation";
            logAction($_SESSION['user_email'], $action);
        }

    } elseif (isset($_POST["submit_rpc_settings"])) {
        // Traitement des paramètres RPC
        $rpc_id = $_POST["rpc_id"];
        $rpc_details = $_POST["rpc_details"];
        $rpc_state = $_POST["rpc_state"];
        $rpc_large_text = $_POST["rpc_large_text"];
        $rpc_small_text = $_POST["rpc_small_text"];
        $rpc_activation = isset($_POST["rpc_activation"]) ? 1 : 0;
        $rpc_button1 = $_POST["rpc_button1"];
        $rpc_button1_url = $_POST["rpc_button1_url"];
        $rpc_button2 = $_POST["rpc_button2"];
        $rpc_button2_url = $_POST["rpc_button2_url"];

        $sql = "SELECT rpc_id, rpc_details, rpc_state, rpc_large_text, rpc_small_text, rpc_activation, rpc_button1, rpc_button1_url, rpc_button2, rpc_button2_url FROM options";
        $stmt = $pdo->query($sql);
        $previousData = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($previousData['rpc_id'] != $rpc_id || $previousData['rpc_details'] != $rpc_details || $previousData['rpc_state'] != $rpc_state || $previousData['rpc_large_text'] != $rpc_large_text || $previousData['rpc_small_text'] != $rpc_small_text || $previousData['rpc_activation'] != $rpc_activation || $previousData['rpc_button1'] != $rpc_button1 || $previousData['rpc_button1_url'] != $rpc_button1_url || $previousData['rpc_button2'] != $rpc_button2 || $previousData['rpc_button2_url'] != $rpc_button2_url) {
            $sql = "UPDATE options SET rpc_id = :rpc_id, rpc_details = :rpc_details, rpc_state = :rpc_state, rpc_large_text = :rpc_large_text, rpc_small_text = :rpc_small_text, rpc_activation = :rpc_activation, rpc_button1 = :rpc_button1, rpc_button1_url = :rpc_button1_url, rpc_button2 = :rpc_button2, rpc_button2_url = :rpc_button2_url";
            $stmt = $pdo->prepare($sql);
            $stmt->bindParam(':rpc_id', $rpc_id);
            $stmt->bindParam(':rpc_details', $rpc_details);
            $stmt->bindParam(':rpc_state', $rpc_state);
            $stmt->bindParam(':rpc_large_text', $rpc_large_text);
            $stmt->bindParam(':rpc_small_text', $rpc_small_text);
            $stmt->bindParam(':rpc_activation', $rpc_activation);
            $stmt->bindParam(':rpc_button1', $rpc_button1);
            $stmt->bindParam(':rpc_button1_url', $rpc_button1_url);
            $stmt->bindParam(':rpc_button2', $rpc_button2);
            $stmt->bindParam(':rpc_button2_url', $rpc_button2_url);
            $stmt->execute();

            // Enregistrer l'action dans les logs
            $action = "Modification des paramètres RPC : ID $rpc_id, détails $rpc_details, état $rpc_state, texte large $rpc_large_text, texte petit $rpc_small_text, activation $rpc_activation, bouton 1 $rpc_button1, URL bouton 1 $rpc_button1_url, bouton 2 $rpc_button2, URL bouton 2 $rpc_button2_url";
            logAction($_SESSION['user_email'], $action);
        }

    } elseif (isset($_POST["submit_changelog"])) {
        // Traitement du changelog
        $changelog_version = $_POST["changelog_version"];
        $changelog_message = str_replace("\n", '<br>', $_POST["changelog_message"]);

        $sql = "SELECT changelog_version, changelog_message FROM options";
        $stmt = $pdo->query($sql);
        $previousData = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($previousData['changelog_version'] != $changelog_version || $previousData['changelog_message'] != $changelog_message) {
            $sql = "UPDATE options SET changelog_version = :changelog_version, changelog_message = :changelog_message";
            $stmt = $pdo->prepare($sql);
            $stmt->bindParam(':changelog_version', $changelog_version);
            $stmt->bindParam(':changelog_message', $changelog_message);
            $stmt->execute();

            // Enregistrer l'action dans les logs
            $action = "Modification du changelog : version $changelog_version, message $changelog_message";
            logAction($_SESSION['user_email'], $action);
        }

    } elseif (isset($_POST["submit_splash_info"])) {
        // Traitement des informations du splash
        $splash = $_POST["splash"];
        $splash_author = $_POST["splash_author"];

        $sql = "SELECT splash, splash_author FROM options";
        $stmt = $pdo->query($sql);
        $previousData = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($previousData['splash'] != $splash || $previousData['splash_author'] != $splash_author) {
            $sql = "UPDATE options SET splash = :splash, splash_author = :splash_author";
            $stmt = $pdo->prepare($sql);
            $stmt->bindParam(':splash', $splash);
            $stmt->bindParam(':splash_author', $splash_author);
            $stmt->execute();

            // Enregistrer l'action dans les logs
            $action = "Modification des informations du splash : $splash, auteur $splash_author";
            logAction($_SESSION['user_email'], $action);
        }

    } elseif (isset($_POST["submit_ignored_folder_data"])) {
        // Traitement des dossiers ignorés
        $ignored_folder = $_POST["ignored_folder"];

        $folderArray = explode(',', $ignored_folder);
        $folderArray = array_map('trim', $folderArray);
        $ignored_folder = implode(',', $folderArray);

        $sqlDelete = "DELETE FROM ignored_folders";
        $pdo->exec($sqlDelete);

        $sqlInsert = "INSERT INTO ignored_folders (folder_name) VALUES (:folder_name)";
        $stmt = $pdo->prepare($sqlInsert);

        foreach ($folderArray as $folder) {
            $stmt->bindParam(':folder_name', $folder);
            $stmt->execute();
        }

        // Enregistrer l'action dans les logs
        $action = "Mise à jour des dossiers ignorés : $ignored_folder";
        logAction($_SESSION['user_email'], $action);

    } elseif (isset($_POST["submit_whitelist"])) {
        // Traitement de la whitelist
        $whitelist = isset($_POST["whitelist_activation"]) ? 1 : 0;

        $sql = "SELECT whitelist_activation FROM options";
        $stmt = $pdo->query($sql);
        $previousData = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($previousData['whitelist_activation'] != $whitelist) {
            $sql = "UPDATE options SET whitelist_activation = :whitelist_activation";
            $stmt = $pdo->prepare($sql);
            $stmt->bindParam(':whitelist_activation', $whitelist);
            $stmt->execute();

            // Enregistrer l'action dans les logs
            $action = "Modification de la whitelist : activation $whitelist";
            logAction($_SESSION['user_email'], $action);
        }

        $whitelistUsers = $_POST["whitelist_users"];
        $usernamesArray = explode(',', $whitelistUsers);
        $usernamesArray = array_map('trim', $usernamesArray);

        $sqlDelete = "DELETE FROM whitelist";
        $pdo->exec($sqlDelete);

        $sqlInsert = "INSERT INTO whitelist (users) VALUES (:users)";
        $stmt = $pdo->prepare($sqlInsert);

        foreach ($usernamesArray as $username) {
            $stmt->bindParam(':users', $username);
            $stmt->execute();
        }

        // Enregistrer l'action dans les logs
        $action = "Ajout d'utilisateurs à la whitelist : $whitelistUsers";
        logAction($_SESSION['user_email'], $action);

    } elseif (isset($_POST["submit_general_settings"])) {
        // Traitement des paramètres généraux
        $role = isset($_POST["role"]) ? 1 : 0;
        $money = isset($_POST["money"]) ? 1 : 0;
        $game_folder_name = $_POST["game_folder_name"];
        $azuriom = $_POST["azuriom"];
        $mods = isset($_POST["mods_enabled"]) ? 1 : 0;
        $file_verification = isset($_POST["file_verification"]) ? 1 : 0;
        $embedded_java = isset($_POST["embedded_java"]) ? 1 : 0;

        $sql = "SELECT role, money, game_folder_name, azuriom, mods_enabled, file_verification, embedded_java FROM options";
        $stmt = $pdo->query($sql);
        $previousData = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($previousData['role'] != $role || $previousData['money'] != $money || $previousData['game_folder_name'] != $game_folder_name || $previousData['azuriom'] != $azuriom || $previousData['mods_enabled'] != $mods || $previousData['file_verification'] != $file_verification || $previousData['embedded_java'] != $embedded_java) {
            $sql = "UPDATE options SET role = :role, money = :money, game_folder_name = :game_folder_name, azuriom = :azuriom, mods_enabled = :mods_enabled, file_verification = :file_verification, embedded_java = :embedded_java";
            $stmt = $pdo->prepare($sql);
            $stmt->bindParam(':role', $role);
            $stmt->bindParam(':money', $money);
            $stmt->bindParam(':game_folder_name', $game_folder_name);
            $stmt->bindParam(':azuriom', $azuriom);
            $stmt->bindParam(':mods_enabled', $mods);
            $stmt->bindParam(':file_verification', $file_verification);
            $stmt->bindParam(':embedded_java', $embedded_java);
            $stmt->execute();

            // Enregistrer l'action dans les logs
            $action = "Modification des paramètres généraux : rôle $role, argent $money, dossier de jeu $game_folder_name, Azuriom $azuriom, mods activés $mods, vérification des fichiers $file_verification, Java intégré $embedded_java";
            logAction($_SESSION['user_email'], $action);
        }
    }
}

$sql = "SELECT * FROM options";
$stmt = $pdo->query($sql);

if ($stmt->rowCount() > 0) {
    $row = $stmt->fetch(PDO::FETCH_ASSOC);
}
?>

<?php require_once './ui/header.php'; ?>
<style>
    .scroll-to-top {
        position: fixed;
        bottom: 2rem;
        right: 2rem;
        z-index: 10;
    }
</style>
<a href="#" class="scroll-to-top bg-gray-900 hover:bg-blue-600 text-white py-2 px-4 rounded-full shadow-lg transition duration-300 ease-in-out">
    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 inline-block align-middle" fill="none" viewBox="0 0 24 24" stroke="currentColor">
        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 10l7-7m0 0l7 7m-7-7v18"/>
    </svg>
</a>
<style>
    .scroll-to-down {
        position: fixed;
        bottom: 2rem;
        right: 6rem;
        z-index: 10;
    }
</style>
<a href="#footer" class="scroll-to-down bg-blue-900 hover:bg-blue-600 text-white py-2 px-4 rounded-full shadow-lg transition duration-300 ease-in-out">
<svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 inline-block align-middle" fill="none" viewBox="0 0 24 24" stroke="currentColor">
    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 14l-7 7m0 0l-7-7m7 7V3"/>
</svg>

</a>

<?php require_once './function/main.php'; ?>
<?php require_once './function/serveur.php'; ?>
<?php require_once './function/splash.php'; ?>
<?php require_once './function/loader.php'; ?>
<?php require_once './function/rpc.php'; ?>
<?php require_once './function/changelog.php'; ?>
<?php require_once './function/maintenance.php'; ?>
<?php require_once './function/whitelist.php'; ?>
<?php require_once './function/roles.php'; ?>
<?php require_once './function/ignore.php'; ?>
<?php require_once './function/logs.php'; ?>

<?php require_once './ui/footer.php'; ?>

<?php
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
$sql = "SELECT * FROM options";
$stmt = $pdo->query($sql);

if ($stmt->rowCount() > 0) {
    $row = $stmt->fetch(PDO::FETCH_ASSOC);
} else {
    $row = [];
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST["submit_roles_settings"])) {
        for ($i = 1; $i <= 8; $i++) {
            $roleName = $_POST["role" . $i . "_name"] ?? '';

            // Fetch current background before attempting to upload a new one
            $sql = "SELECT role_background FROM roles WHERE id = :id";
            $stmt = $pdo->prepare($sql);
            $stmt->bindParam(':id', $i);
            $stmt->execute();
            $currentBackground = $stmt->fetchColumn();

            // Handle role background image upload
            $backgroundUrl = uploadRoleImage($i, $currentBackground);

            if (!empty($roleName)) {
                $sql = "INSERT INTO roles (id, role_name, role_background) VALUES (:id, :role_name, :role_background)
                        ON DUPLICATE KEY UPDATE role_name = :role_name, role_background = :role_background";
                $stmt = $pdo->prepare($sql);
                $stmt->bindParam(':id', $i);
                $stmt->bindParam(':role_name', $roleName);
                $stmt->bindParam(':role_background', $backgroundUrl);
                $stmt->execute();
            }
        }    
    }elseif (isset($_POST["submit_maintenance"])) {
        $maintenance = isset($_POST["maintenance"]) ? 1 : 0;
        $sql = "UPDATE options SET maintenance = ?";
        $stmt = $pdo->prepare($sql);
        $stmt->execute([$maintenance]);
        $maintenance_message = $_POST["maintenance_message"];
        $sql = "UPDATE options SET maintenance_message = :maintenance_message";
        $stmt = $pdo->prepare($sql);
        $stmt->bindValue(':maintenance_message', $maintenance_message, PDO::PARAM_STR);
        $stmt->execute();
    } elseif (isset($_POST["submit_server_info"])) {
        $server_name = $_POST["server_name"];
        $server_ip = $_POST["server_ip"];
        $server_port = $_POST["server_port"];

        // Fetch current image before attempting to upload a new one
        $current_img = isset($row['server_img']) ? $row['server_img'] : null;
        $server_img = uploadServerImage($current_img);

        $sql = "UPDATE options SET server_name = ?, server_ip = ?, server_port = ?, server_img = ?";
        $stmt = $pdo->prepare($sql);
        $stmt->execute([$server_name, $server_ip, $server_port, $server_img]);
    }elseif (isset($_POST["submit_loader_settings"])) {
        
            $game_folder_name = $_POST["minecraft_version"];
            $sql = "UPDATE options SET minecraft_version = ?";
            $stmt = $pdo->prepare($sql);
            $stmt->execute([$game_folder_name]);
            $loader_type = $_POST["loader_type"];
            $loader_build_version = $_POST["loader_build_version"];
            $loader_forge_version = $_POST["loader_forge_version"];
            $loader_activation = isset($_POST["loader_activation"]) ? 1 : 0;
            
            $sql = "UPDATE options SET loader_type = ?, loader_build_version = ?, loader_forge_version = ?, loader_activation = ?";
            $stmt = $pdo->prepare($sql);
            $stmt->execute([$loader_type, $loader_build_version, $loader_forge_version, $loader_activation]);
        
    }elseif (isset($_POST["submit_rpc_settings"])) {
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
        
        $sql = "UPDATE options SET rpc_id = ?, rpc_details = ?, rpc_state = ?, rpc_large_text = ?, rpc_small_text = ?, rpc_activation = ?, rpc_button1 = ?, rpc_button1_url = ?, rpc_button2 = ?, rpc_button2_url = ?";
        $stmt = $pdo->prepare($sql);
        $stmt->execute([$rpc_id, $rpc_details, $rpc_state, $rpc_large_text, $rpc_small_text, $rpc_activation, $rpc_button1, $rpc_button1_url, $rpc_button2, $rpc_button2_url]);
    
    }elseif (isset($_POST["submit_changelog"])) {
        $changelog_version = $_POST["changelog_version"];
        $changelog_message = str_replace("\n", '<br>', $_POST["changelog_message"]);

        $sql = "UPDATE options SET changelog_version = ?, changelog_message = ?";
        $stmt = $pdo->prepare($sql);
        $stmt->execute([$changelog_version, $changelog_message]);
    } elseif (isset($_POST["submit_splash_info"])) {
        $splash = $_POST["splash"];
        $splash_author = $_POST["splash_author"];
        
        $sql = "UPDATE options SET splash = ?, splash_author = ?";
        $stmt = $pdo->prepare($sql);
        $stmt->execute([$splash, $splash_author]);
    
    }elseif (isset($_POST["submit_ignored_folder_data"])) {
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
    }elseif (isset($_POST["submit_whitelist"])) {
        $whitelist = isset($_POST["whitelist_activation"]) ? 1 : 0;
        $sql = "UPDATE options SET whitelist_activation = ?";
        $stmt = $pdo->prepare($sql);
        $stmt->execute([$whitelist]);

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
    }elseif (isset($_POST["submit_general_settings"])) {
        
            $role = isset($_POST["role"]) ? 1 : 0;
            $sql = "UPDATE options SET role = ?";
            $stmt = $pdo->prepare($sql);
            $stmt->execute([$role]);
      
            $money = isset($_POST["money"]) ? 1 : 0;
            $sql = "UPDATE options SET money = ?";
            $stmt = $pdo->prepare($sql);
            $stmt->execute([$money]);
          
            $game_folder_name = $_POST["game_folder_name"];
            $sql = "UPDATE options SET game_folder_name = ?";
            $stmt = $pdo->prepare($sql);
            $stmt->execute([$game_folder_name]);
           
            $azuriom = $_POST["azuriom"];
            $sql = "UPDATE options SET azuriom = ?";
            $stmt = $pdo->prepare($sql);
            $stmt->execute([$azuriom]);
          
            $mods = isset($_POST["mods_enabled"]) ? 1 : 0;
            $sql = "UPDATE options SET mods_enabled = ?";
            $stmt = $pdo->prepare($sql);
            $stmt->execute([$mods]);    
          
            $file_verification = isset($_POST["file_verification"]) ? 1 : 0;
            $sql = "UPDATE options SET file_verification = ?";
            $stmt = $pdo->prepare($sql);
            $stmt->execute([$file_verification]);
            
            $embedded_java = isset($_POST["embedded_java"]) ? 1 : 0;
            $sql = "UPDATE options SET embedded_java = ?";
            $stmt = $pdo->prepare($sql);
            $stmt->execute([$embedded_java]);
            
}
}
$sql = "SELECT * FROM options";
$stmt = $pdo->query($sql);

if ($stmt->rowCount() > 0) {
    $row = $stmt->fetch(PDO::FETCH_ASSOC);
}
function uploadServerImage($currentImage)
{
    if (empty($_FILES['server_img']['tmp_name']) || $_FILES['server_img']['error'] !== UPLOAD_ERR_OK) {
        return $currentImage;
    }

    $uploadDir = './uploads/';
    
    if (!is_dir($uploadDir)) {
        if (!mkdir($uploadDir, 0777, true)) {
            die("Erreur : Impossible de créer le dossier de téléchargement.");
        }
    }

    $uploadedFile = $_FILES['server_img']['tmp_name'];
    $fileName = $_FILES['server_img']['name'];
    $fileType = $_FILES['server_img']['type'];

    $allowedTypes = ['image/jpeg', 'image/png', 'image/gif'];
    if (!in_array($fileType, $allowedTypes)) {
        die("Erreur : Seuls les fichiers JPEG, PNG et GIF sont autorisés.");
    }

    $uniqueFileName = uniqid() . '_' . $fileName;

    if (move_uploaded_file($uploadedFile, $uploadDir . $uniqueFileName)) {
        return $uploadDir . $uniqueFileName;
    } else {
        die("Erreur lors du déplacement du fichier téléchargé.");
    }
}

function uploadRoleImage($roleIndex, $currentBackground) {
    if (isset($_FILES["role" . $roleIndex . "_background"]) && $_FILES["role" . $roleIndex . "_background"]["error"] == 0) {
        $targetDirectory = "uploads/";
        if (!file_exists($targetDirectory)) {
            mkdir($targetDirectory, 0777, true);
        }
        $targetFile = $targetDirectory . basename($_FILES["role" . $roleIndex . "_background"]["name"]);
        $imageFileType = strtolower(pathinfo($targetFile, PATHINFO_EXTENSION));

        if (getimagesize($_FILES["role" . $roleIndex . "_background"]["tmp_name"])) {
            if (move_uploaded_file($_FILES["role" . $roleIndex . "_background"]["tmp_name"], $targetFile)) {
                return $targetFile;
            }
        }
    }
    return $currentBackground;
}

?>
<?php
require_once './ui/header.php';
?>
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

<?php
require_once './function/main.php';
?>
<?php
require_once './function/serveur.php';
?>
<?php
require_once './function/splash.php';
?>


        <?php
require_once './function/loader.php';
?>

            
            <?php
require_once './function/rpc.php';
?>
            
            <?php
require_once './function/changelog.php';
?>
            <?php
require_once './function/maintenance.php';
?>
    </div>

    <?php
require_once './function/whitelist.php';
?>



    
    <?php
require_once './function/roles.php';
?>
<?php
require_once './function/ignore.php';
?>


<?php
require_once './ui/footer.php';
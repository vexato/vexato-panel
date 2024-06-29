<?php
session_start();
$configFilePath = '../conn.php';
if (!file_exists($configFilePath)) {
    header('Location: ../setdb');
    exit();
}
require_once '../connexion_bdd.php';
if (isset($_SESSION['user_token'])) {
    $stmt = $pdo->prepare("SELECT * FROM users WHERE token = :token");
    $stmt->bindParam(':token', $_SESSION['user_token']);
    $stmt->execute();
    $utilisateur = $stmt->fetch();

    if ($utilisateur) {
        header('Location: ../settings');
        exit();
    }
}
function generateToken($length = 40) {
    $characters = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789-_!?./$';
    $charactersLength = strlen($characters);
    $token = '';
    for ($i = 0; $i < $length; $i++) {
        $token .= $characters[rand(0, $charactersLength - 1)];
    }
    return $token;
}

$sql = "SELECT COUNT(*) as count FROM users";
$stmt = $pdo->prepare($sql);
$stmt->execute();

$row = $stmt->fetch(PDO::FETCH_ASSOC);
$comptesExistants = $row['count'] > 0;

if (!$comptesExistants) {
    header('Location: register.php');
    exit();
}

$errors = [];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = $_POST['email'];
    $password = $_POST['password'];

    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $errors[] = "Adresse email invalide.";
    }

    if (empty($password)) {
        $errors[] = "Veuillez saisir votre mot de passe.";
    }

    if (empty($errors)) {
        try {
            $sth = $pdo->prepare("SELECT id, password FROM users WHERE email = :email");
            $sth->execute(['email' => $email]);

            if ($sth->rowCount() === 0) {
                $errors[] = "Adresse email ou mot de passe incorrect.";
            } else {
                $user = $sth->fetch();

                if (!password_verify($password, $user['password'])) {
                    $errors[] = "Adresse email ou mot de passe incorrect.";
                } else {
                    $token = generateToken();

                    $_SESSION['user_email'] = $email;
                    $_SESSION['user_token'] = $token;

                    $stmt = $pdo->prepare("UPDATE users SET token = :token WHERE email = :email");
                    $stmt->bindParam(':token', $token);
                    $stmt->bindParam(':email', $email);
                    $stmt->execute();
                    header('Location: ../settings');
                    exit();
                }
            }
        } catch (PDOException $e) {
            echo "Erreur de connexion à la base de données: " . $e->getMessage();
            exit();
        }
    }
}
?>

<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Connexion</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">
</head>

<body class="bg-gray-100">
    <div class="container mx-auto mt-20">
        <div class="flex justify-center">
            <div class="w-full max-w-md">
                <div class="bg-white shadow-md rounded px-8 pt-6 pb-8 mb-4">
                    <h2 class="text-2xl mb-4 text-center	">Connexion au Panel</h2>
                    <?php if (!empty($errors)) : ?>
                    <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative mb-4">
                        <?php foreach ($errors as $error) : ?>
                        <span class="block sm:inline"><?php echo $error; ?></span>
                        <?php endforeach; ?>
                    </div>
                    <?php endif; ?>
                    <form method="post" action="">
                        <div class="mb-4">
                            <label for="email" class="block text-gray-700 text-sm font-bold mb-2">Adresse email</label>
                            <div class="relative">
                                <input type="email" name="email"
                                    class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"
                                    placeholder="MonEmail@exemple.com" required>
                                <i class="bi bi-envelope-fill absolute right-3 top-2.5 text-gray-400"></i>
                            </div>
                        </div>
                        <div class="mb-6">
                            <label for="password" class="block text-gray-700 text-sm font-bold mb-2">Mot de
                                passe</label>
                            <div class="relative">
                                <input id="password" type="password" name="password"
                                    class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 mb-3 leading-tight focus:outline-none focus:shadow-outline"
                                    required>
                                <i class="bi bi-lock-fill absolute right-10 top-2.5 text-gray-400"></i>
                                <i id="togglePassword"
                                    class="bi bi-eye-fill absolute right-3 top-2.5 cursor-pointer text-gray-400"></i>
                            </div>
                        </div>

                        <div class="flex items-center justify-center">
                            <button type="submit" name="submit"
                                class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline">
                                Se connecter
                            </button>
                        </div>

                    </form>
                </div>
            </div>
        </div>
    </div>

    <script src="https://www.google.com/recaptcha/enterprise.js?render=6LfQWIglAAAAAEzTj18fKpd0udB2MBkUojHnRr3p">
    </script>
    <script>
    const togglePassword = document.querySelector('#togglePassword');
    const password = document.querySelector('#password');

    togglePassword.addEventListener('click', function(e) {
        
        const type = password.getAttribute('type') === 'password' ? 'text' : 'password';
        password.setAttribute('type', type);
        
        this.classList.toggle('bi-eye-fill');
        this.classList.toggle('bi-eye-slash-fill');
    });
    </script>

    <script>
    grecaptcha.enterprise.ready(function() {
        grecaptcha.enterprise.execute('6LfQWIglAAAAAEzTj18fKpd0udB2MBkUojHnRr3p', {
            action: 'login'
        }).then(function(token) {});
    });
    </script>

</body>

</html>
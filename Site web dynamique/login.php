<?php
session_start();
include('php/dbadmin.php'); // Include the database connection file

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST['username'];
    $password = $_POST['password'];

    // Prepare the SQL query to verify credentials
    $query = "SELECT * FROM Administration WHERE login = ? AND mdp = ?";
    $stmt = $conn->prepare($query);
    if ($stmt === false) {
        die('Error preparing the query: ' . htmlspecialchars($conn->error));
    }
    $stmt->bind_param('ss', $username, $password);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $user = $result->fetch_assoc();
        $_SESSION['role'] = $user['role'];

        if ($user['role'] == 'admin') {
            header('Location: administration.php');
        } elseif ($user['role'] == 'gestionnaire') {
            header('Location: php/gestion.php'); 
        }
        exit();
    } else {
        $error = "identifiant ou mot de passe incorrect";
    }

    $stmt->close();
    $conn->close();
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Connexion</title>
    <link rel="stylesheet" href="styles/styleadmin.css">
</head>
<body>
    <header>
        <div class="logo">Saé 23</div> <!-- Site logo -->
        <nav class="top-menu">
            <a href="index.html">Accueil</a> <!-- Link to the homepage -->
        </nav>
    </header>
    <div class="container">
        <h1>Veuillez vous connecter avec vos identifiants</h1> <!-- Page heading -->
        <?php if (isset($error)): ?>
            <p style="color: red;"><?php echo $error; ?></p> <!-- Display error message if credentials are incorrect -->
        <?php endif; ?>
        <form method="POST" action="" class="login-form"> <!-- Login form -->
            <label for="username">Username:</label>
            <input type="text" id="username" name="username" required> <!-- Input for username -->
            <label for="password">Password:</label>
            <input type="password" id="password" name="password" required> <!-- Input for password -->
            <button type="submit">Login</button> <!-- Submit button -->
        </form>
    </div>
</body>
</html>

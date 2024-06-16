<?php
include('php/dbadmin.php'); 

$message = '';

// Add a building
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['ajouter_batiment'])) {
    $id_unique = $_POST['id_unique'];
    $nom_batiment = $_POST['nom_batiment'];
    $login = $_POST['login'];
    $mot_de_passe = $_POST['mot_de_passe'];
    $stmt = mysqli_prepare($conn, "INSERT INTO batiment (ID_unique, nom, login, `mot de passe`) VALUES (?, ?, ?, ?)");
    if ($stmt === false) {
        $message = "Erreur de préparation de la requête : " . mysqli_error($conn);
    } else {
        mysqli_stmt_bind_param($stmt, "ssss", $id_unique, $nom_batiment, $login, $mot_de_passe);
        if (mysqli_stmt_execute($stmt)) {
            $message = "Bâtiment ajouté avec succès.";
        } else {
            $message = "Erreur lors de l'ajout du bâtiment : " . mysqli_stmt_error($stmt);
        }
        mysqli_stmt_close($stmt);
    }
}

// Delete a building
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['supprimer_batiment'])) {
    $id_batiment = $_POST['id_batiment'];
    $check_salles = mysqli_prepare($conn, "SELECT COUNT(*) FROM Salle WHERE ID_unique = ?");
    if ($check_salles === false) {
        $message = "Erreur de préparation de la requête (vérification des salles) : " . mysqli_error($conn);
    } else {
        mysqli_stmt_bind_param($check_salles, "s", $id_batiment);
        mysqli_stmt_execute($check_salles);
        mysqli_stmt_bind_result($check_salles, $salle_count);
        mysqli_stmt_fetch($check_salles);
        mysqli_stmt_close($check_salles);

        if ($salle_count > 0) {
            $message = "Erreur : Le bâtiment contient des salles et ne peut pas être supprimé.";
        } else {
            $stmt = mysqli_prepare($conn, "DELETE FROM batiment WHERE ID_unique = ?");
            if ($stmt === false) {
                $message = "Erreur de préparation de la requête : " . mysqli_error($conn);
            } else {
                mysqli_stmt_bind_param($stmt, "s", $id_batiment);
                if (mysqli_stmt_execute($stmt)) {
                    $message = "Bâtiment supprimé avec succès.";
                } else {
                    $message = "Erreur lors de la suppression du bâtiment : " . mysqli_stmt_error($stmt);
                }
                mysqli_stmt_close($stmt);
            }
        }
    }
}

// Add a room
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['ajouter_salle'])) {
    $nom_salle = $_POST['nom_salle'];
    $type = $_POST['type'];
    $capacite = $_POST['capacite'];
    $id_batiment = $_POST['id_batiment_salle'];
    $stmt = mysqli_prepare($conn, "INSERT INTO Salle (nom_salle, type, capacite, ID_unique) VALUES (?, ?, ?, ?)");
    if ($stmt === false) {
        $message = "Erreur de préparation de la requête : " . mysqli_error($conn);
    } else {
        mysqli_stmt_bind_param($stmt, "ssis", $nom_salle, $type, $capacite, $id_batiment);
        if (mysqli_stmt_execute($stmt)) {
            $message = "Salle ajoutée avec succès.";
        } else {
            $message = "Erreur lors de l'ajout de la salle : " . mysqli_stmt_error($stmt);
        }
        mysqli_stmt_close($stmt);
    }
}

// Delete a room
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['supprimer_salle'])) {
    $id_salle = $_POST['id_salle'];
    $stmt = mysqli_prepare($conn, "DELETE FROM Salle WHERE nom_salle = ?");
    if ($stmt === false) {
        $message = "Erreur de préparation de la requête : " . mysqli_error($conn);
    } else {
        mysqli_stmt_bind_param($stmt, "s", $id_salle);
        if (mysqli_stmt_execute($stmt)) {
            $message = "Salle supprimée avec succès.";
        } else {
            $message = "Erreur lors de la suppression de la salle : " . mysqli_stmt_error($stmt);
        }
        mysqli_stmt_close($stmt);
    }
}

// Add a sensor
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['ajouter_capteur'])) {
    $nom_capteur = $_POST['nom_capteur'];
    $type_capteur = $_POST['type_capteur'];
    $unite = $_POST['unite'];
    $nom_salle_capteur = $_POST['nom_salle_capteur'];
    $stmt = mysqli_prepare($conn, "INSERT INTO Capteurs (nom_capteur, type, unite, nom_salle) VALUES (?, ?, ?, ?)");
    if ($stmt === false) {
        $message = "Erreur de préparation de la requête : " . mysqli_error($conn);
    } else {
        mysqli_stmt_bind_param($stmt, "ssss", $nom_capteur, $type_capteur, $unite, $nom_salle_capteur);
        if (mysqli_stmt_execute($stmt)) {
            $message = "Capteur ajouté avec succès.";
        } else {
            $message = "Erreur lors de l'ajout du capteur : " . mysqli_stmt_error($stmt);
        }
        mysqli_stmt_close($stmt);
    }
}

// Delete a sensor
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['supprimer_capteur'])) {
    $id_capteur = $_POST['id_capteur'];
    $stmt = mysqli_prepare($conn, "DELETE FROM Capteurs WHERE nom_capteur = ?");
    if ($stmt === false) {
        $message = "Erreur de préparation de la requête : " . mysqli_error($conn);
    } else {
        mysqli_stmt_bind_param($stmt, "s", $id_capteur);
        if (mysqli_stmt_execute($stmt)) {
            $message = "Capteur supprimé avec succès.";
        } else {
            $message = "Erreur lors de la suppression du capteur : " . mysqli_stmt_error($stmt);
        }
        mysqli_stmt_close($stmt);
    }
}

// Get data for drop-down lists
$batiments_result = mysqli_query($conn, "SELECT * FROM batiment");
$batiments = $batiments_result ? mysqli_fetch_all($batiments_result, MYSQLI_ASSOC) : [];

$salles_result = mysqli_query($conn, "SELECT * FROM Salle");
$salles = $salles_result ? mysqli_fetch_all($salles_result, MYSQLI_ASSOC) : [];

$capteurs_result = mysqli_query($conn, "SELECT * FROM Capteurs");
$capteurs = $capteurs_result ? mysqli_fetch_all($capteurs_result, MYSQLI_ASSOC) : [];
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Administration</title>
    <link rel="stylesheet" href="styles/styleadministration.css">
</head>
<body>
    <header>
        <div class="logo">Saé 23</div>
        <nav class="top-menu">
            <a href="index.html">Accueil</a>
        </nav>
    </header>
    <div class="container">
        <h1>Administration</h1>
        <?php if ($message): ?>
            <p class="message"><?php echo $message; ?></p>
        <?php endif; ?>
        <section>
            <h2>Gérer les bâtiments</h2>
            <form method="post" action="">
                <label for="id_unique">ID Unique :</label>
                <input type="text" id="id_unique" name="id_unique" required>
                <label for="nom_batiment">Ajouter un bâtiment :</label>
                <input type="text" id="nom_batiment" name="nom_batiment" required>
                <label for="login">Login :</label>
                <input type="text" id="login" name="login" required>
                <label for="mot_de_passe">Mot de passe :</label>
                <input type="password" id="mot_de_passe" name="mot_de_passe" required>
                <button type="submit" name="ajouter_batiment">Ajouter</button>
            </form>
            <form method="post" action="">
                <label for="id_batiment">Supprimer un bâtiment :</label>
                <select id="id_batiment" name="id_batiment" required>
                    <option value="">--Sélectionnez un bâtiment--</option>
                    <?php foreach ($batiments as $batiment): ?>
                        <option value="<?php echo $batiment['ID_unique']; ?>"><?php echo $batiment['nom']; ?></option>
                    <?php endforeach; ?>
                </select>
                <button type="submit" name="supprimer_batiment">Supprimer</button>
            </form>
        </section>

        <section>
            <h2>Gérer les salles</h2>
            <form method="post" action="">
                <label for="nom_salle">Ajouter une salle :</label>
                <input type="text" id="nom_salle" name="nom_salle" required>
                <label for="type">Type TD / TP:</label>
                <input type="text" id="type" name="type" required>
                <label for="capacite">Capacité élève:</label>
                <input type="number" id="capacite" name="capacite" required>
                <label for="id_batiment_salle">Bâtiment :</label>
                <select id="id_batiment_salle" name="id_batiment_salle" required>
                    <option value="">--Sélectionnez un bâtiment--</option>
                    <?php foreach ($batiments as $batiment): ?>
                        <option value="<?php echo $batiment['ID_unique']; ?>"><?php echo $batiment['nom']; ?></option>
                    <?php endforeach; ?>
                </select>
                <button type="submit" name="ajouter_salle">Ajouter</button>
            </form>
            <form method="post" action="">
                <label for="id_salle">Supprimer une salle :</label>
                <select id="id_salle" name="id_salle" required>
                    <option value="">--Sélectionnez une salle--</option>
                    <?php foreach ($salles as $salle): ?>
                        <option value="<?php echo $salle['nom_salle']; ?>"><?php echo $salle['nom_salle']; ?></option>
                    <?php endforeach; ?>
                </select>
                <button type="submit" name="supprimer_salle">Supprimer</button>
            </form>
        </section>

        <section>
            <h2>Gérer les capteurs</h2>
            <form method="post" action="">
                <label for="nom_capteur">Ajouter un capteur :</label>
                <input type="text" id="nom_capteur" name="nom_capteur" required>
                <label for="type_capteur">Type CO2 / Température:</label>
                <input type="text" id="type_capteur" name="type_capteur" required>
                <label for="unite">Unité ppm / °C :</label>
                <input type="text" id="unite" name="unite" required>
                <label for="nom_salle_capteur">Salle :</label>
                <select id="nom_salle_capteur" name="nom_salle_capteur" required>
                    <option value="">--Sélectionnez une salle--</option>
                    <?php foreach ($salles as $salle): ?>
                        <option value="<?php echo $salle['nom_salle']; ?>"><?php echo $salle['nom_salle']; ?></option>
                    <?php endforeach; ?>
                </select>
                <button type="submit" name="ajouter_capteur">Ajouter</button>
            </form>
            <form method="post" action="">
                <label for="id_capteur">Supprimer un capteur :</label>
                <select id="id_capteur" name="id_capteur" required>
                    <option value="">--Sélectionnez un capteur--</option>
                    <?php foreach ($capteurs as $capteur): ?>
                        <option value="<?php echo $capteur['nom_capteur']; ?>"><?php echo $capteur['nom_capteur']; ?></option>
                    <?php endforeach; ?>
                </select>
                <button type="submit" name="supprimer_capteur">Supprimer</button>
            </form>
        </section>
    </div>
</body>
</html>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Consultation des Capteurs</title>
    <link rel="stylesheet" href="../styles/styless.css">
    <script>
        var buildings = <?php
            include('dbadmin.php'); // Include database connection file
            $query = "SELECT nom_salle, ID_unique FROM Salle";
            $result = $conn->query($query);
            $rooms = [];
            if ($result->num_rows > 0) {
                while ($row = $result->fetch_assoc()) {
                    $rooms[$row['ID_unique']][] = ['nom_salle' => $row['nom_salle']];
                }
            }
            echo json_encode($rooms);
            $conn->close();
        ?>;
        
        function updateRooms(buildings) {
            var buildingSelect = document.getElementById('building-select');
            var roomSelect = document.getElementById('room-select');

            // Clear previous options
            roomSelect.innerHTML = '<option value="">--Sélectionnez une salle--</option>';

            var selectedBuilding = buildingSelect.value;
            var rooms = buildings[selectedBuilding] || [];

            rooms.forEach(function(room) {
                roomSelect.options.add(new Option(room.nom_salle, room.nom_salle));
            });
        }

        function setInitialRooms(buildings) {
            var selectedBuilding = '<?php echo isset($_POST['building']) ? $_POST['building'] : ''; ?>';
            var selectedRoom = '<?php echo isset($_POST['room']) ? $_POST['room'] : ''; ?>';
            if (selectedBuilding) {
                document.getElementById('building-select').value = selectedBuilding;
                updateRooms(buildings);
                if (selectedRoom) {
                    document.getElementById('room-select').value = selectedRoom;
                }
            }
        }
    </script>
</head>
<body onload="setInitialRooms(buildings)">
    <header>
        <div class="logo">Saé 23</div>
        <nav class="top-menu">
            <a href="../index.html">Accueil</a>
            <a href="../login.php">Connexion</a>
            <a href="../gestion_projet.html">Gestion de projet</a>
            <a href="../mention_legales.html">Mentions légales</a>
        </nav>
    </header>

    <div class="container">
        <h1>Consultation des Capteurs</h1>
        <form method="POST" action="">
            <label for="building-select">Choisissez un bâtiment:</label>
            <select id="building-select" name="building" onchange="updateRooms(buildings)">
                <option value="">--Sélectionnez un bâtiment--</option>
                <?php
                include('dbadmin.php'); // Include database connection file
                $query = "SELECT ID_unique, nom FROM batiment";
                $result = $conn->query($query);
                if ($result->num_rows > 0) {
                    while ($row = $result->fetch_assoc()) {
                        echo "<option value='" . htmlspecialchars($row['ID_unique']) . "'>" . htmlspecialchars($row['nom']) . "</option>";
                    }
                }
                $conn->close();
                ?>
            </select>
            
            <label for="room-select">Choisissez une salle:</label>
            <select id="room-select" name="room">
                <option value="">--Sélectionnez une salle--</option>
            </select>
            
            <button type="submit">Consulter</button>
        </form>
        <div id="sensor-data">
            <?php
            if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['building']) && isset($_POST['room']) && $_POST['building'] !== '' && $_POST['room'] !== '') {
                $selected_building = $_POST['building'];
                $selected_room = $_POST['room'];
                echo "<h2>Données des capteurs pour Bâtiment " . htmlspecialchars($selected_building) . " - Salle " . htmlspecialchars($selected_room) . "</h2>";

                include('dbadmin.php'); // Reopen the database connection
                // SQL query to retrieve the latest values of all sensors in the selected room
                $query = "
                    SELECT Capteurs.nom_capteur, Mesures.valeur, Mesures.date, Mesures.horaire
                    FROM Mesures
                    INNER JOIN Capteurs ON Mesures.nom_capteur = Capteurs.nom_capteur
                    INNER JOIN Salle ON Capteurs.nom_salle = Salle.nom_salle
                    INNER JOIN batiment ON Salle.ID_unique = batiment.ID_unique
                    WHERE batiment.ID_unique = ? AND Salle.nom_salle = ?
                    AND Mesures.date = (
                        SELECT MAX(date)
                        FROM Mesures M2
                        WHERE M2.nom_capteur = Mesures.nom_capteur
                    )
                    AND Mesures.horaire = (
                        SELECT MAX(horaire)
                        FROM Mesures M2
                        WHERE M2.nom_capteur = Mesures.nom_capteur
                        AND M2.date = Mesures.date
                    )
                    ORDER BY Capteurs.nom_capteur";
                
                // Prepare the query and check for errors
                if ($stmt = $conn->prepare($query)) {
                    $stmt->bind_param('ss', $selected_building, $selected_room);
                    $stmt->execute();
                    $result = $stmt->get_result();

                    if ($result->num_rows > 0) {
                        echo "<table>";
                        echo "<tr><th>Capteur</th><th>Valeur</th><th>Date</th><th>Horaire</th></tr>";
                        while ($row = $result->fetch_assoc()) {
                            echo "<tr>";
                            echo "<td>" . htmlspecialchars($row['nom_capteur']) . "</td>";
                            echo "<td>" . htmlspecialchars($row['valeur']) . "</td>";
                            echo "<td>" . htmlspecialchars($row['date']) . "</td>";
                            echo "<td>" . htmlspecialchars($row['horaire']) . "</td>";
                            echo "</tr>";
                        }
                        echo "</table>";
                    } else {
                        echo "<p>Aucune donnée trouvée pour les capteurs de cette salle.</p>";
                    }

                    $stmt->close();
                } else {
                    echo "<p>Erreur dans la préparation de la requête: " . htmlspecialchars($conn->error) . "</p>";
                }

                $conn->close();
            } else {
                echo "<p>Veuillez sélectionner un bâtiment et une salle.</p>";
            }
            ?>
        </div>
    </div>
</body>
</html>

<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

include('dbadmin.php');

// Initialization of variables
$building = '';
$room = '';
$sensor = '';
$start_date = '';
$end_date = '';
$sensor_data = [];
$stats = [];
$rooms = [];
$sensors = [];

// Form processing
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST['building'])) {
        $building = $_POST['building'];
        // SQL query to retrieve the rooms of the selected building
        $query = "SELECT nom_salle FROM Salle WHERE ID_unique = ?";
        $stmt = $conn->prepare($query);
        $stmt->bind_param('s', $building);
        $stmt->execute();
        $result = $stmt->get_result();
        while ($row = $result->fetch_assoc()) {
            $rooms[] = $row['nom_salle'];
        }
        $stmt->close();
    }

    if (isset($_POST['room'])) {
        $room = $_POST['room'];
        // SQL query to retrieve the sensors of the selected room
        $query = "SELECT nom_capteur FROM Capteurs WHERE nom_salle = ?";
        $stmt = $conn->prepare($query);
        $stmt->bind_param('s', $room);
        $stmt->execute();
        $result = $stmt->get_result();
        while ($row = $result->fetch_assoc()) {
            $sensors[] = $row['nom_capteur'];
        }
        $stmt->close();
    }

    if (isset($_POST['sensor'])) {
        $sensor = $_POST['sensor'];
    }

    if (isset($_POST['start_date']) && isset($_POST['end_date'])) {
        $start_date = $_POST['start_date'];
        $end_date = $_POST['end_date'];
    }

    // SQL query to retrieve the measurements of the selected sensor and the time range
    if ($sensor && $start_date && $end_date) {
        $query = "
            SELECT valeur, date, horaire
            FROM Mesures
            WHERE nom_capteur = ? AND date BETWEEN ? AND ?
            ORDER BY date DESC, horaire DESC";
        
        $stmt = $conn->prepare($query);
        $stmt->bind_param('sss', $sensor, $start_date, $end_date);
        $stmt->execute();
        $result = $stmt->get_result();
        
        $values = [];
        while ($row = $result->fetch_assoc()) {
            $sensor_data[] = $row;
            $values[] = $row['valeur'];
        }

        if (!empty($values)) {
            $stats['max'] = max($values);
            $stats['min'] = min($values);
            $stats['avg'] = array_sum($values) / count($values);
        }

        $stmt->close();
    }
}

// Fetch buildings for the dropdown
$buildings = [];
$query = "SELECT ID_unique, nom FROM batiment";
$result = $conn->query($query);
if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $buildings[] = $row;
    }
}
$conn->close();
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gestion des Capteurs</title>
    <link rel="stylesheet" href="../styles/styless.css">
</head>
<body>
    <header>
        <div class="logo">Saé 23</div>
        <nav class="top-menu">
            <a href="../index.html">Accueil</a>
        </nav>
    </header>

    <div class="container">
        <h1>Gestion des Capteurs</h1>
        <form method="POST" action="">
            <label for="building-select">Choisissez un bâtiment:</label>
            <select id="building-select" name="building" onchange="this.form.submit()" required>
                <option value="">--Sélectionnez un bâtiment--</option>
                <?php
                if (!empty($buildings)) {
                    foreach ($buildings as $building) {
                        echo "<option value='" . htmlspecialchars($building['ID_unique']) . "' " . ($building['ID_unique'] == $_POST['building'] ? 'selected' : '') . ">" . htmlspecialchars($building['nom']) . "</option>";
                    }
                } else {
                    echo "<option value=''>Aucun bâtiment disponible</option>";
                }
                ?>
            </select>

            <?php if (!empty($rooms)): ?>
                <label for="room-select">Choisissez une salle:</label>
                <select id="room-select" name="room" onchange="this.form.submit()" required>
                    <option value="">--Sélectionnez une salle--</option>
                    <?php foreach ($rooms as $r): ?>
                        <option value="<?php echo htmlspecialchars($r); ?>" <?php echo ($room == $r ? 'selected' : ''); ?>><?php echo htmlspecialchars($r); ?></option>
                    <?php endforeach; ?>
                </select>
            <?php endif; ?>

            <?php if (!empty($sensors)): ?>
                <label for="sensor-select">Choisissez un capteur:</label>
                <select id="sensor-select" name="sensor" onchange="this.form.submit()" required>
                    <option value="">--Sélectionnez un capteur--</option>
                    <?php foreach ($sensors as $s): ?>
                        <option value="<?php echo htmlspecialchars($s); ?>" <?php echo ($sensor == $s ? 'selected' : ''); ?>><?php echo htmlspecialchars($s); ?></option>
                    <?php endforeach; ?>
                </select>
            <?php endif; ?>

            <?php if ($sensor): ?>
                <label for="start_date">Date de début:</label>
                <input type="date" id="start_date" name="start_date" value="<?php echo htmlspecialchars($start_date); ?>" required>

                <label for="end_date">Date de fin:</label>
                <input type="date" id="end_date" name="end_date" value="<?php echo htmlspecialchars($end_date); ?>" required>
                
                <button type="submit">Consulter</button>
            <?php endif; ?>
        </form>

        <?php if (!empty($sensor_data)): ?>
            <h2>Données des capteurs pour <?php echo htmlspecialchars($sensor); ?></h2>
            <table>
                <thead>
                    <tr>
                        <th>Valeur</th>
                        <th>Date</th>
                        <th>Horaire</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($sensor_data as $data): ?>
                        <tr>
                            <td><?php echo htmlspecialchars($data['valeur']); ?></td>
                            <td><?php echo htmlspecialchars($data['date']); ?></td>
                            <td><?php echo htmlspecialchars($data['horaire']); ?></td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>

            <h2>Statistiques pour <?php echo htmlspecialchars($sensor); ?></h2>
            <table>
                <thead>
                    <tr>
                        <th>Max</th>
                        <th>Min</th>
                        <th>Moyenne</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td><?php echo htmlspecialchars($stats['max']); ?></td>
                        <td><?php echo htmlspecialchars($stats['min']); ?></td>
                        <td><?php echo htmlspecialchars(round($stats['avg'], 2)); ?></td>
                    </tr>
                </tbody>
            </table>
        <?php elseif ($_SERVER["REQUEST_METHOD"] == "POST"): ?>
            <p>Aucune donnée trouvée pour les critères sélectionnés.</p>
        <?php endif; ?>
    </div>
</body>
</html>

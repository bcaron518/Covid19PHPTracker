<?php
declare(strict_types=1);

// Enable error reporting for debugging (optional, remove in production)
error_reporting(E_ALL);
ini_set('display_errors', '1');

// Caching API data to reduce requests
$cacheFile = 'cache.json';
$cacheTime = 600; // Cache duration: 10 minutes

if (file_exists($cacheFile) && (time() - filemtime($cacheFile)) < $cacheTime) {
    $data = file_get_contents($cacheFile);
} else {
    $data = @file_get_contents('https://api.covidtracking.com/v1/us/daily.json');
    if ($data !== FALSE) {
        file_put_contents($cacheFile, $data);
    } else {
        $data = null;
    }
}

// Decode data
$coronalive = $data ? json_decode($data, true) : null;
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Covid19 Tracker</title>
    <link rel="stylesheet" href="styles.css">
    <style>
        /* Moved to an external file like `styles.css` - Keeping inline for now */
        .header {
            background-image: url('cool-background.png');
            width: 40%;
            font-family: 'Niconne', cursive;
            box-shadow: 0 4px 8px 0 rgba(0, 0, 0, 0.2), 0 6px 20px 0 rgba(0, 0, 0, 0.19);
            border-radius: 20px;
            background-size: auto;
        }
        .middle {
            margin-top: 60px;
            opacity: 1.0;
            border-radius: 20px;
            background-color: #f2f2f2;
            background-image: url('cool-background3.png');
            background-size: auto;
            padding: 20px;
        }
        th {
            padding-top: 12px;
            padding-bottom: 12px;
            text-align: left;
            background-color: #4CAF50;
            color: white;
        }
        td, th {
            border: 1px solid #ddd;
            padding: 8px;
        }
        tr:nth-child(even) {
            background-color: #f2f2f2;
        }
        tr:hover {
            background-color: #ddd;
        }
    </style>
</head>
<body>
    <center>
        <div class="header">
            <h1>Covid19 Tracker</h1>
        </div>

        <div class="middle">
            <h2>Covid19 US Updates</h2>
        </div>

        <div style="overflow-x:auto;">
            <table border="1px" aria-describedby="covid-data-table">
                <caption id="covid-data-table">Covid-19 Daily Updates</caption>
                <tr>
                    <th>Date</th>
                    <th>States</th>
                    <th>Positive Cases</th>
                    <th>Negative Cases</th>
                    <th>Hospitalized Currently</th>
                    <th>ICU Currently</th>
                    <th>Ventilator Currently</th>
                    <th>Total Deaths</th>
                </tr>
                <?php if ($coronalive): ?>
                    <?php foreach ($coronalive as $row): ?>
                        <tr>
                            <td>
                                <?php
                                $date = DateTime::createFromFormat('Ymd', strval($row['date'] ?? ''));
                                echo $date ? $date->format('M d, Y') : 'N/A';
                                ?>
                            </td>
                            <td><?= htmlspecialchars($row['states'] ?? 'N/A') ?></td>
                            <td><?= htmlspecialchars($row['positive'] ?? 'N/A') ?></td>
                            <td><?= htmlspecialchars($row['negative'] ?? 'N/A') ?></td>
                            <td><?= htmlspecialchars($row['hospitalizedCurrently'] ?? 'N/A') ?></td>
                            <td><?= htmlspecialchars($row['inIcuCurrently'] ?? 'N/A') ?></td>
                            <td><?= htmlspecialchars($row['onVentilatorCurrently'] ?? 'N/A') ?></td>
                            <td><?= htmlspecialchars($row['death'] ?? 'N/A') ?></td>
                        </tr>
                    <?php endforeach; ?>
                <?php else: ?>
                    <tr>
                        <td colspan="8">Error fetching data. Please try again later.</td>
                    </tr>
                <?php endif; ?>
            </table>
        </div>
    </center>
</body>
</html>

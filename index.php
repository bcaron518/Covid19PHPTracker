<!DOCTYPE html>
<html>
<head>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Covid19 Report</title>
    <style type="text/css">
        .header {
            background-image: url('cool-background.png');
            width: 40%;
            font-family: 'Niconne';
            box-shadow: 0 4px 8px 0 rgba(0, 0, 0, 0.2), 
                        0 6px 20px 0 rgba(0, 0, 0, 0.19);
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
            <table border="1px">
                <?php
                $data = file_get_contents('https://api.covidtracking.com/v1/us/daily.json');
                $coronalive = json_decode($data, true);
                ?>
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
                <?php
                foreach ($coronalive as $row) {
                ?>
                <tr>
                    <td><?php echo $row['date']; ?></td>
                    <td><?php echo $row['states']; ?></td>
                    <td><?php echo $row['positive']; ?></td>
                    <td><?php echo $row['negative']; ?></td>
                    <td><?php echo $row['hospitalizedCurrently']; ?></td>
                    <td><?php echo $row['inIcuCurrently']; ?></td>
                    <td><?php echo $row['onVentilatorCurrently']; ?></td>
                    <td><?php echo $row['death']; ?></td>
                </tr>
                <?php
                }
                ?>
            </table>
        </div>
    </center>
</body>
</html>

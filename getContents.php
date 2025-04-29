$data=file_get_contents('https://api.covidtracking.com/v1/us/daily.json');

$coronalive =json_decode($data,true);

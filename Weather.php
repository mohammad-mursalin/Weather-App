
<?php
header('Access-Control-Allow-Origin: *');
header('Content-Type: application/json');

$city = isset($_GET['city']) ? urlencode($_GET['city']) : '';
if (!$city) {
	echo json_encode(['error' => 'No city provided']);
	exit;
}

$weatherApiKey = 'ab6de896c6a8b8f7bc3072d23b4a6879';
$unsplashAccessKey = '1-mI4g_NXergmF7IJZp7AV9GMsXp7F608x6mN-WLC_8';

// Fetch weather data
$weatherUrl = "https://api.openweathermap.org/data/2.5/weather?q={$city}&units=metric&appid={$weatherApiKey}";
$weatherResponse = file_get_contents($weatherUrl);
$weatherData = json_decode($weatherResponse, true);


// Add weather description to Unsplash query if available
$weatherDescription = '';
if (isset($weatherData['weather'][0]['description'])) {
	$weatherDescription = $weatherData['weather'][0]['description'];
}
$unsplashQuery = trim($city . ' ' . $weatherDescription);
$unsplashUrl = "https://api.unsplash.com/search/photos?query=" . urlencode($unsplashQuery) . "&client_id={$unsplashAccessKey}&orientation=landscape&per_page=10&page=1";
$unsplashResponse = file_get_contents($unsplashUrl);
$imageData = json_decode($unsplashResponse, true);

echo json_encode([
	'weather' => $weatherData,
	'image_response' => $imageData
]);
exit;

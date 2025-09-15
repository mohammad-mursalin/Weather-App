<?php
header('Access-Control-Allow-Origin: *');
header('Content-Type: application/json');

$city = $_GET['city'] ?? '';
if (!$city) {
    echo json_encode(['error' => 'No city provided']);
    exit;
}

$weatherApiKey = 'ab6de896c6a8b8f7bc3072d23b4a6879';
$unsplashAccessKey = '1-mI4g_NXergmF7IJZp7AV9GMsXp7F608x6mN-WLC_8';

function fetchJson($url) {
    $response = @file_get_contents($url);
    return $response ? json_decode($response, true) : null;
}

// Weather API
$weatherUrl = "https://api.openweathermap.org/data/2.5/weather?q=" . urlencode($city) . "&units=metric&appid={$weatherApiKey}";
$weatherData = fetchJson($weatherUrl);

// Unsplash API (use description if available)
$description = $weatherData['weather'][0]['description'] ?? '';
$unsplashQuery = urlencode(trim("$city $description"));
$unsplashUrl = "https://api.unsplash.com/search/photos?query={$unsplashQuery}&client_id={$unsplashAccessKey}&orientation=landscape&per_page=10&page=1";
$imageData = fetchJson($unsplashUrl);

echo json_encode([
    'weather' => $weatherData,
    'image_response' => $imageData
]);

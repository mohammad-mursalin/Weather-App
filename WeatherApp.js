

    async function fetchWeather(city) {
        const response = await fetch(`http://localhost:8080/Weather.php?city=${encodeURIComponent(city)}`);
        if (!response.ok) {
            alert("Invalid city name !!!\nNo weather found...");
            throw new Error("No weather found.");
        }
        const result = await response.json();
        if (result.weather && result.weather.cod === 200) {
            displayWeather(result.weather, result.image_response);
        } else {
            alert("Invalid city name !!!\nNo weather found...");
        }
    }


function displayWeather(data, image_response) {
    const { name } = data;
    const { icon, description } = data.weather[0];
    const { temp, humidity } = data.main;
    const { speed } = data.wind;

    document.querySelector(".city").innerText = "Weather in " + name;
    document.querySelector(".icon").src = "https://openweathermap.org/img/wn/" + icon + ".png";
    document.querySelector(".description").innerText = description;
    document.querySelector(".temp").innerText = temp + "°C";
    document.querySelector(".humidity").innerText = "Humidity: " + humidity + "%";
    document.querySelector(".wind").innerText = "Wind speed: " + speed +" km/h";
    document.querySelector(".weather").classList.remove("loading");
    if (image_response && image_response.results && image_response.results.length > 0) {
        const randomIdx = Math.floor(Math.random() * image_response.results.length);
        const imgUrl = image_response.results[randomIdx].urls.full;
        // Preload image
        const img = new Image();
        img.onload = function() {
            document.body.style.backgroundImage = `url('${imgUrl}')`;
        };
        img.src = imgUrl;
    }
}

            function search() {
                fetchWeather(document.querySelector(".search-bar").value);
            }

            document.querySelector(".search-bar").addEventListener("keyup",function(event) {

                if (event.key == "Enter") {

                    search()
                }
            });

            document.querySelector("button").addEventListener("click",function() {

                search();
            });


fetchWeather("Bangladesh");
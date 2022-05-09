<!DOCTYPE html>
<html>

<head>
    <link rel="stylesheet" href="https://unpkg.com/@picocss/pico@latest/css/pico.min.css">
    <title>Cultureel Erfgoed</title>
    <!-- Leaflet  -->
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.8.0/dist/leaflet.css"
        integrity="sha512-hoalWLoI8r4UszCkZ5kL8vayOGVae1oxXe/2A4AO6J9+580uKHDO3JdHb7NzwwzK5xr/Fs0W40kiNHxM9vyTtQ=="
        crossorigin="" />
    <script src="https://unpkg.com/leaflet@1.8.0/dist/leaflet.js"
        integrity="sha512-BB3hKbKWOc9Ez/TAwyWxNXeoV9c1v6FIeYiBieIWkpLjauysF18NzgR1MBNBXf8/KABdlkX68nAhlwcDFLGPCQ=="
        crossorigin=""></script>

    <style>
        #map {
            height: 500px;
        }
    </style>
</head>

<body>
    <main class="container">
        <hgroup>
            <h1>Cultureel Erfgoed</h1>
            <p>Culturere erfgoeden van het <a href="https://mass.cultureelerfgoed.nl/">MaSS</a></p>
        </hgroup>
        <div id="map"></div>
    </main>
    <script>
        var map = L.map('map').setView([52.370, 4.895], 10);
        L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
            maxZoom: 16,
            attribution: '&copy; <a href="https://openstreetmap.org/copyright">OpenStreetMap contributors</a>'
        }).addTo(map);
        L.control.scale({ imperial: true, metric: true }).addTo(map);
        var popup = L.popup();

        function onMapClick(e) {
            popup
                .setLatLng(e.latlng)
                .setContent("Je hebt op de kaart geklikt op: " + e.latlng.toString())
                .openOn(map);
        }

        map.on('click', onMapClick);

        <?php
            $res = file_get_contents("https://mass.cultureelerfgoed.nl/api/v1/list/");
            echo "const API_DATA=".$res.";";
        ?>

        for (item of API_DATA) {
            L.marker({lat: item.lat, lon: item.lon, icon: L.icon({iconSize: [32, 32]})}).bindPopup(`<b>${item.name}<br>${item.location}<br>${item.type} - ${item.subtype ?? ""}</b>`).addTo(map);
            console.log(item);
        }
    </script>
</body>

</html>
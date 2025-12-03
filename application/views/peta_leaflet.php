<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Peta WebGIS</title>

    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.7.1/dist/leaflet.css" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/leaflet-groupedlayercontrol/0.6.1/leaflet.groupedlayercontrol.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/leaflet-minimap/3.6.1/Control.MiniMap.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/leaflet.locatecontrol@0.76.0/dist/L.Control.Locate.min.css" />
    <link rel="stylesheet" href="https://unpkg.com/leaflet-control-geocoder/dist/Control.Geocoder.css" />

    <style>
        /* Agar peta full layar di dalam iframe */
        html, body { margin: 0; padding: 0; height: 100%; width: 100%; }
        #map { width: 100%; height: 100%; }
    </style>
</head>

<body>

    <div id="map"></div>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://unpkg.com/leaflet@1.7.1/dist/leaflet.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/leaflet-groupedlayercontrol/0.6.1/leaflet.groupedlayercontrol.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/leaflet-minimap/3.6.1/Control.MiniMap.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/leaflet.locatecontrol@0.76.0/dist/L.Control.Locate.min.js"></script>
    <script src="https://unpkg.com/leaflet-control-geocoder/dist/Control.Geocoder.js"></script>

    <script>
    // --- MULAI KODINGAN PETA ---

    // 1. Variabel Penampung Layer
    var rth = new L.LayerGroup();
    var poligonCiputat = new L.LayerGroup();

    // 2. Inisialisasi Peta
    var map = L.map('map', {
        center: [-6.305, 106.73], // Koordinat Ciputat
        zoom: 13,
        zoomControl: true, // Zoom bar bawaan leaflet (karena plugin ZoomBar custom sering error)
        layers: []
    });

    // Tempelkan layer agar langsung muncul
    rth.addTo(map);
    poligonCiputat.addTo(map);

    /* --- BASEMAPS --- */
    var GoogleSatelliteHybrid = L.tileLayer('https://mt1.google.com/vt/lyrs=y&x={x}&y={y}&z={z}', {
        maxZoom: 22, attribution: 'Latihan Web GIS'
    }).addTo(map);

    var Esri_NatGeoWorldMap = L.tileLayer('https://server.arcgisonline.com/ArcGIS/rest/services/NatGeo_World_Map/MapServer/tile/{z}/{y}/{x}', {
        attribution: 'Tiles &copy; Esri', maxZoom: 16
    });

    var GoogleMaps = new L.TileLayer('https://mt1.google.com/vt/lyrs=m&x={x}&y={y}&z={z}', {
        opacity: 1.0, attribution: 'Latihan Web GIS'
    });

    var GoogleRoads = new L.TileLayer('https://mt1.google.com/vt/lyrs=h&x={x}&y={y}&z={z}', {
        opacity: 1.0, attribution: 'Latihan Web GIS'
    });

    var baseLayers = {
        'Google Satellite': GoogleSatelliteHybrid,
        'Esri World': Esri_NatGeoWorldMap,
        'Google Maps': GoogleMaps,
        'Google Roads': GoogleRoads
    };

    /* --- CONTROL LAYER --- */
    var groupedOverlays = {
        "Peta Dasar": {
            'Titik RTH Sarua': rth,
            'Area Poligon Ciputat': poligonCiputat
        }
    };

    L.control.groupedLayers(baseLayers, groupedOverlays).addTo(map);

    /* --- FITUR TAMBAHAN (Menggunakan Plugin CDN) --- */
    
    // MiniMap
    var osmUrl = 'https://server.arcgisonline.com/ArcGIS/rest/services/World_Imagery/MapServer/tile/{z}/{y}/{x}';
    var osm2 = new L.TileLayer(osmUrl, {minZoom: 0, maxZoom: 13});
    var miniMap = new L.Control.MiniMap(osm2, {
        toggleDisplay: true, position: "bottomright",
        aimingRectOptions: {color: "#ff1100", weight: 3},
        shadowRectOptions: {color: "#0000AA", weight: 1, opacity: 0, fillOpacity: 0}
    }).addTo(map);

    // Geocoder (Pencarian)
    L.Control.geocoder({position: "topleft", collapsed: true}).addTo(map);

    // Locate Control (GPS)
    L.control.locate({
        position: "topright", drawCircle: true, follow: true, setView: true, 
        keepCurrentZoomLevel: false, icon: "fa fa-location-arrow", metric: true
    }).addTo(map);

    // Skala
    L.control.scale({metric: true, position: "bottomleft"}).addTo(map);

    // Arah Mata Angin
    var north = L.control({position: "bottomleft"});
    north.onAdd = function(map) {
        var div = L.DomUtil.create("div", "info legend");
        // Pastikan gambar ini ada, atau ganti linknya
        div.innerHTML = '<img src="<?=base_url()?>assets/arah-mata-angin.png" style="width:100px;">';
        return div;
    };
    north.addTo(map);

    /* --- LOAD DATA 1: TITIK RTH --- */
    $.getJSON("<?=base_url()?>assets/rth.geojson", function(data) {
        var ratIcon = L.icon({
            // Pakai icon online biar aman dulu
            iconUrl: 'https://raw.githubusercontent.com/pointhi/leaflet-color-markers/master/img/marker-icon-2x-green.png',
            iconSize: [25, 41], iconAnchor: [12, 41], popupAnchor: [1, -34], shadowSize: [41, 41]
        });

        var geoJsonLayer = L.geoJson(data, {
            pointToLayer: function(feature, latlng) {
                var marker = L.marker(latlng, {icon: ratIcon});
                if (feature.properties['Nama Lokas']) {
                    marker.bindPopup("<b>" + feature.properties['Nama Lokas'] + "</b>");
                }
                return marker;
            }
        });
        geoJsonLayer.addTo(rth);
    });

    /* --- LOAD DATA 2: POLIGON CIPUTAT --- */
    $.getJSON("<?=base_url()?>assets/poligon_ciputat.geojson", function(data) {
        L.geoJson(data, {
            style: function(feature) {
                var fillColor, kode = feature.properties.kode; 
                // Logika Warna
                if (kode == 7) fillColor = "#800026";
                else if (kode == 6) fillColor = "#BD0026";
                else if (kode == 5) fillColor = "#E31A1C";
                else if (kode == 4) fillColor = "#FC4E2A";
                else if (kode == 3) fillColor = "#FD8D3C";
                else if (kode == 2) fillColor = "#FEB24C";
                else if (kode == 1) fillColor = "#FED976";
                else fillColor = "#3388ff"; // Biru Default

                return { color: "white", weight: 1, fillColor: fillColor, fillOpacity: 0.6 };
            },
            onEachFeature: function(feature, layer) {
                if(feature.properties.NAME_4) {
                    layer.bindPopup("Kelurahan: " + feature.properties.NAME_4);
                }
            }
        }).addTo(poligonCiputat);
        
        // Zoom Otomatis ke Ciputat
        var tempLayer = L.geoJson(data);
        map.fitBounds(tempLayer.getBounds());
    });

    </script>
</body>
</html>
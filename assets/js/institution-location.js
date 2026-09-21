(function () {
    function initLocationPicker(mapId) {
        var mapElement = document.getElementById(mapId);
        if (!mapElement || typeof L === 'undefined') return;

        var form = mapElement.closest('form');
        var latInput = form && form.querySelector('input[name="inst_lat"]');
        var lngInput = form && form.querySelector('input[name="inst_lng"]');
        var coordinates = form && form.querySelector('[data-location-coordinates]');
        var urlInput = form && form.querySelector('[data-location-url]');
        var defaultCenter = [13.6929, -89.2182];
        var lat = parseFloat(latInput && latInput.value);
        var lng = parseFloat(lngInput && lngInput.value);
        var hasLocation = Number.isFinite(lat) && Number.isFinite(lng);
        var map = L.map(mapElement, { center: hasLocation ? [lat, lng] : defaultCenter, zoom: hasLocation ? 16 : 9 });
        L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
            attribution: '&copy; OpenStreetMap contributors',
            maxZoom: 19
        }).addTo(map);
        var marker = hasLocation ? L.marker([lat, lng]).addTo(map) : null;

        function setLocation(position) {
            var nextLat = position.lat.toFixed(7);
            var nextLng = position.lng.toFixed(7);
            if (latInput) latInput.value = nextLat;
            if (lngInput) lngInput.value = nextLng;
            if (coordinates) coordinates.textContent = 'Ubicación seleccionada: ' + nextLat + ', ' + nextLng;
            if (marker) marker.setLatLng(position);
            else marker = L.marker(position).addTo(map);
            map.setView(position, Math.max(map.getZoom(), 16));
        }

        function coordinatesFromMapsUrl(value) {
            // Google Maps suele incluir /@lat,lng o !3dlat!4dlng en el enlace.
            var match = String(value || '').match(/@(-?\d+(?:\.\d+)?),(-?\d+(?:\.\d+)?)/);
            if (!match) match = String(value || '').match(/!3d(-?\d+(?:\.\d+)?)!4d(-?\d+(?:\.\d+)?)/);
            if (!match) return null;
            var parsedLat = parseFloat(match[1]);
            var parsedLng = parseFloat(match[2]);
            return Math.abs(parsedLat) <= 90 && Math.abs(parsedLng) <= 180
                ? { lat: parsedLat, lng: parsedLng } : null;
        }

        if (urlInput) {
            urlInput.addEventListener('input', function () {
                var position = coordinatesFromMapsUrl(urlInput.value);
                urlInput.setCustomValidity(position || !urlInput.value ? '' : 'Pega un enlace de Google Maps con coordenadas del punto exacto.');
                if (position) setLocation(position);
            });
        }

        map.on('click', function (event) { setLocation(event.latlng); });
        var button = form && form.querySelector('[data-location-action="geolocate"]');
        if (button) {
            button.addEventListener('click', function () {
                if (!navigator.geolocation) {
                    button.textContent = 'Mapa no disponible';
                    return;
                }
                button.disabled = true;
                button.textContent = 'Buscando...';
                navigator.geolocation.getCurrentPosition(function (position) {
                    setLocation({ lat: position.coords.latitude, lng: position.coords.longitude });
                    button.disabled = false;
                    button.textContent = 'Usar mi ubicación';
                }, function () {
                    button.disabled = false;
                    button.textContent = 'Intentar de nuevo';
                }, { enableHighAccuracy: true, timeout: 10000 });
            });
        }
        if (hasLocation && coordinates) coordinates.textContent = 'Ubicación seleccionada: ' + lat.toFixed(7) + ', ' + lng.toFixed(7);
        setTimeout(function () { map.invalidateSize(); }, 100);
        if (window.ResizeObserver) {
            new ResizeObserver(function () { map.invalidateSize(); }).observe(mapElement);
        }
    }

    document.addEventListener('DOMContentLoaded', function () {
        initLocationPicker('registerInstitutionMap');
        initLocationPicker('profileInstitutionMap');
    });
})();
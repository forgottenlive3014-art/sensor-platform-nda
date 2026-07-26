// NDA - Deteccion de ubicacion del usuario (municipio/departamento/pais)
// para las paginas de Clima en Tiempo Real y Fases de la Luna.
//
// La tabla `usuarios` no guarda municipio/departamento/pais (ver
// sql/nda_project.sql), asi que la ubicacion se resuelve enteramente en el
// navegador:
//   1) Geolocation API del navegador (requiere permiso del usuario).
//   2) Reverse-geocoding gratuito y sin API key (BigDataCloud) para
//      convertir lat/lng en nombres de municipio/departamento/pais.
//   3) Si el usuario no concede el permiso o falla: San Salvador como
//      ubicacion aproximada por defecto, marcada explicitamente como tal
//      (approx:true) para que la interfaz lo indique en vez de fingir
//      precision que no tiene.
//
// Se cachea en sessionStorage por 30 min para no re-pedir el permiso ni
// volver a golpear la API cada vez que el usuario cambia de pagina.
(function (global) {
    const CACHE_KEY = 'nda_location_cache_v1';
    const CACHE_TTL = 30 * 60 * 1000;
    const DEFAULT_LOCATION = {
        lat: 13.6929, lng: -89.2182,
        municipio: 'San Salvador', departamento: 'San Salvador', pais: 'El Salvador',
        approx: true
    };

    function readCache() {
        try {
            const raw = sessionStorage.getItem(CACHE_KEY);
            if (!raw) return null;
            const parsed = JSON.parse(raw);
            if (Date.now() - parsed.savedAt > CACHE_TTL) return null;
            return parsed.data;
        } catch (e) { return null; }
    }

    function writeCache(data) {
        try { sessionStorage.setItem(CACHE_KEY, JSON.stringify({ savedAt: Date.now(), data: data })); } catch (e) {}
    }

    function getBrowserCoords() {
        return new Promise((resolve, reject) => {
            if (!navigator.geolocation) { reject(new Error('Geolocalizacion no disponible')); return; }
            navigator.geolocation.getCurrentPosition(
                pos => resolve({ lat: pos.coords.latitude, lng: pos.coords.longitude }),
                err => reject(err),
                { enableHighAccuracy: false, timeout: 8000, maximumAge: 10 * 60 * 1000 }
            );
        });
    }

    async function reverseGeocode(lat, lng) {
        const url = `https://api.bigdatacloud.net/data/reverse-geocode-client?latitude=${lat}&longitude=${lng}&localityLanguage=es`;
        const resp = await fetch(url);
        if (!resp.ok) throw new Error('reverse geocode fallo');
        const d = await resp.json();
        return {
            lat: lat, lng: lng,
            municipio: d.locality || d.city || d.principalSubdivision || 'Tu ubicación',
            departamento: d.principalSubdivision || '',
            pais: d.countryName || 'El Salvador',
            approx: false
        };
    }

    // Devuelve siempre una ubicacion utilizable (nunca rechaza la promesa).
    async function getNdaLocation(forceRefresh) {
        if (!forceRefresh) {
            const cached = readCache();
            if (cached) return cached;
        }
        try {
            const coords = await getBrowserCoords();
            const geocoded = await reverseGeocode(coords.lat, coords.lng);
            writeCache(geocoded);
            return geocoded;
        } catch (e) {
            writeCache(DEFAULT_LOCATION);
            return DEFAULT_LOCATION;
        }
    }

    global.ndaGetLocation = getNdaLocation;
})(window);

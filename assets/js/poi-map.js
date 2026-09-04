// NDA - Puntos de interes ante emergencias (hospitales, albergues, policia,
// bomberos) en El Salvador. Usa una lista fija y ya determinada (no depende
// de una API externa en vivo, para que siempre cargue), calcula la distancia
// a la ubicacion del usuario y la ordena de mas cercano a mas lejano.
(function () {
    const CATS = {
        hospital: { label: 'Hospital', color: '--red', icon: 'fa-hospital' },
        albergue: { label: 'Albergue / Punto de Acopio', color: '--purple', icon: 'fa-tents' },
        policia: { label: 'Delegación PNC', color: '--blue', icon: 'fa-shield-halved' },
        bomberos: { label: 'Cuerpo de Bomberos', color: '--acc3', icon: 'fa-fire-flame-curved' }
    };

    // Ubicaciones de referencia recopiladas manualmente (ver aviso en la
    // pagina) - instalaciones publicas conocidas en las principales cabeceras
    // departamentales de El Salvador.
    const POIS = [
        // ---- HOSPITALES (red nacional MINSAL) ----
        { cat: 'hospital', name: 'Hospital Nacional Rosales', addr: 'San Salvador, San Salvador', phone: '2231-9200', lat: 13.6989, lon: -89.1934 },
        { cat: 'hospital', name: 'Hospital Nacional de Niños Benjamín Bloom', addr: 'San Salvador, San Salvador', phone: '2225-4114', lat: 13.6978, lon: -89.1968 },
        { cat: 'hospital', name: 'Hospital Nacional San Rafael', addr: 'Santa Tecla, La Libertad', phone: '2201-3900', lat: 13.6769, lon: -89.2822 },
        { cat: 'hospital', name: 'Hospital Nacional San Juan de Dios', addr: 'Santa Ana', phone: '2440-1700', lat: 13.9930, lon: -89.5588 },
        { cat: 'hospital', name: 'Hospital Nacional San Juan de Dios', addr: 'San Miguel', phone: '2661-8000', lat: 13.4783, lon: -88.1850 },
        { cat: 'hospital', name: 'Hospital Nacional de Sonsonate', addr: 'Sonsonate', phone: '2451-0330', lat: 13.7189, lon: -89.7244 },
        { cat: 'hospital', name: 'Hospital Nacional Santa Teresa', addr: 'Zacatecoluca, La Paz', phone: '2334-0044', lat: 13.5083, lon: -88.8681 },
        { cat: 'hospital', name: 'Hospital Nacional San Pedro', addr: 'Usulután', phone: '2662-0577', lat: 13.3486, lon: -88.4472 },
        { cat: 'hospital', name: 'Hospital Nacional de Chalatenango', addr: 'Chalatenango', phone: '2301-0000', lat: 14.0339, lon: -88.9319 },
        { cat: 'hospital', name: 'Hospital Nacional Dr. Héctor Antonio Hernández Flores', addr: 'La Unión', phone: '2604-4700', lat: 13.3369, lon: -87.8422 },

        // ---- POLICIA NACIONAL CIVIL ----
        { cat: 'policia', name: 'Delegación Centro PNC', addr: 'San Salvador, San Salvador', phone: '911', lat: 13.6994, lon: -89.1912 },
        { cat: 'policia', name: 'Subdelegación PNC Santa Tecla', addr: 'Santa Tecla, La Libertad', phone: '911', lat: 13.6769, lon: -89.2797 },
        { cat: 'policia', name: 'Delegación PNC Santa Ana', addr: 'Santa Ana', phone: '911', lat: 13.9942, lon: -89.5580 },
        { cat: 'policia', name: 'Delegación PNC San Miguel', addr: 'San Miguel', phone: '911', lat: 13.4820, lon: -88.1780 },
        { cat: 'policia', name: 'Delegación PNC Sonsonate', addr: 'Sonsonate', phone: '911', lat: 13.7194, lon: -89.7242 },
        { cat: 'policia', name: 'Delegación PNC La Libertad', addr: 'La Libertad, La Libertad', phone: '911', lat: 13.4886, lon: -89.3225 },
        { cat: 'policia', name: 'Delegación PNC Zacatecoluca', addr: 'Zacatecoluca, La Paz', phone: '911', lat: 13.5083, lon: -88.8686 },
        { cat: 'policia', name: 'Delegación PNC Usulután', addr: 'Usulután', phone: '911', lat: 13.3494, lon: -88.4494 },

        // ---- CUERPO DE BOMBEROS ----
        { cat: 'bomberos', name: 'Cuartel Central de Bomberos', addr: 'San Salvador, San Salvador', phone: '913', lat: 13.6989, lon: -89.1914 },
        { cat: 'bomberos', name: 'Compañía de Bomberos Santa Tecla', addr: 'Santa Tecla, La Libertad', phone: '913', lat: 13.6764, lon: -89.2803 },
        { cat: 'bomberos', name: 'Compañía de Bomberos Santa Ana', addr: 'Santa Ana', phone: '913', lat: 13.9950, lon: -89.5600 },
        { cat: 'bomberos', name: 'Compañía de Bomberos San Miguel', addr: 'San Miguel', phone: '913', lat: 13.4811, lon: -88.1794 },
        { cat: 'bomberos', name: 'Compañía de Bomberos Sonsonate', addr: 'Sonsonate', phone: '913', lat: 13.7183, lon: -89.7250 },
        { cat: 'bomberos', name: 'Compañía de Bomberos La Libertad', addr: 'La Libertad, La Libertad', phone: '913', lat: 13.4880, lon: -89.3230 },
        { cat: 'bomberos', name: 'Compañía de Bomberos Zacatecoluca', addr: 'Zacatecoluca, La Paz', phone: '913', lat: 13.5078, lon: -88.8678 },
        { cat: 'bomberos', name: 'Compañía de Bomberos Usulután', addr: 'Usulután', phone: '913', lat: 13.3489, lon: -88.4480 },

        // ---- ALBERGUES / PUNTOS DE ACOPIO (instalaciones publicas usadas
        // habitualmente por Protección Civil - ubicación de referencia) ----
        { cat: 'albergue', name: 'Gimnasio Nacional "Cheché" Guirola', addr: 'San Salvador, San Salvador', phone: '', lat: 13.6961, lon: -89.2144 },
        { cat: 'albergue', name: 'Polideportivo de Santa Tecla', addr: 'Santa Tecla, La Libertad', phone: '', lat: 13.6739, lon: -89.2794 },
        { cat: 'albergue', name: 'Complejo Deportivo Las Delicias', addr: 'Santa Ana', phone: '', lat: 13.9833, lon: -89.5578 },
        { cat: 'albergue', name: 'Complejo Deportivo San Miguel', addr: 'San Miguel', phone: '', lat: 13.4747, lon: -88.1739 },
        { cat: 'albergue', name: 'Casa de la Cultura de Sonsonate', addr: 'Sonsonate', phone: '', lat: 13.7192, lon: -89.7245 },
        { cat: 'albergue', name: 'Centro de Gobierno Municipal La Libertad', addr: 'La Libertad, La Libertad', phone: '', lat: 13.4880, lon: -89.3220 },
        { cat: 'albergue', name: 'Complejo Educativo (albergue) Zacatecoluca', addr: 'Zacatecoluca, La Paz', phone: '', lat: 13.5083, lon: -88.8681 },
        { cat: 'albergue', name: 'Casa de la Cultura de Usulután', addr: 'Usulután', phone: '', lat: 13.3486, lon: -88.4478 }
    ];

    function cssVar(name) {
        return getComputedStyle(document.documentElement).getPropertyValue(name).trim() || '#888';
    }

    function waitForLeaflet() {
        return new Promise((resolve) => {
            if (window.L) { resolve(); return; }
            const iv = setInterval(() => { if (window.L) { clearInterval(iv); resolve(); } }, 50);
        });
    }

    function haversineKm(lat1, lon1, lat2, lon2) {
        const R = 6371, toRad = (d) => d * Math.PI / 180;
        const dLat = toRad(lat2 - lat1), dLon = toRad(lon2 - lon1);
        const a = Math.sin(dLat / 2) ** 2 + Math.cos(toRad(lat1)) * Math.cos(toRad(lat2)) * Math.sin(dLon / 2) ** 2;
        return R * 2 * Math.atan2(Math.sqrt(a), Math.sqrt(1 - a));
    }

    function escapeHtml(s) {
        return (s || '').replace(/[&<>"]/g, (c) => ({ '&': '&amp;', '<': '&lt;', '>': '&gt;', '"': '&quot;' }[c]));
    }

    let map = null, markersLayer = null, activeCats = new Set(Object.keys(CATS));
    let allItems = [];
    const markerById = new Map();

    function markerIcon(cat) {
        return L.divIcon({
            className: '',
            html: `<div class="poi-marker cat-${cat}" style="background:${cssVar(CATS[cat].color)}"><i class="fa-solid ${CATS[cat].icon}"></i></div>`,
            iconSize: [30, 30], iconAnchor: [15, 29], popupAnchor: [0, -26]
        });
    }

    async function initMap(lat, lon) {
        const el = document.getElementById('poiMap');
        if (!el) return;
        await waitForLeaflet();
        // CARTO dejo de servir tiles gratis sin API key (por eso salia el
        // watermark "API KEY REQUIRED"); Esri no pide key. Ojo: Esri usa
        // orden {z}/{y}/{x} en la URL, al reves que CARTO/OSM ({z}/{x}/{y}).
        const isDark = document.documentElement.getAttribute('data-theme') !== 'light';
        const tileUrl = isDark
            ? 'https://server.arcgisonline.com/ArcGIS/rest/services/Canvas/World_Dark_Gray_Base/MapServer/tile/{z}/{y}/{x}'
            : 'https://server.arcgisonline.com/ArcGIS/rest/services/Canvas/World_Light_Gray_Base/MapServer/tile/{z}/{y}/{x}';

        map = L.map(el, { zoomControl: true, attributionControl: false }).setView([lat, lon], 10);
        L.tileLayer(tileUrl, { maxZoom: 16 }).addTo(map);
        L.control.attribution({ prefix: false }).addAttribution('© Esri').addTo(map);
        L.marker([lat, lon], {
            icon: L.divIcon({ className: '', html: '<div class="poi-marker user-loc"></div>', iconSize: [18, 18], iconAnchor: [9, 9] })
        }).addTo(map).bindPopup('Tu ubicación');

        markersLayer = L.layerGroup().addTo(map);
    }

    function renderMarkers(items) {
        if (!markersLayer) return;
        markersLayer.clearLayers();
        markerById.clear();
        items.filter((it) => activeCats.has(it.cat)).forEach((it) => {
            const m = L.marker([it.lat, it.lon], { icon: markerIcon(it.cat) });
            m.bindPopup(`<strong>${escapeHtml(it.name)}</strong><br>${CATS[it.cat].label}${it.addr ? '<br>' + escapeHtml(it.addr) : ''}`);
            m.addTo(markersLayer);
            markerById.set(it.id, m);
        });
    }

    function renderList(items) {
        const list = document.getElementById('poiList');
        if (!list) return;
        const filtered = items.filter((it) => activeCats.has(it.cat));
        if (!filtered.length) {
            list.innerHTML = '<div class="poi-empty">No hay puntos de esta categoría en la lista.</div>';
            return;
        }
        list.innerHTML = filtered.map((it) => `
            <div class="poi-item cat-${it.cat}" data-id="${it.id}" data-lat="${it.lat}" data-lon="${it.lon}">
                <div class="poi-item-icon"><i class="fa-solid ${CATS[it.cat].icon}"></i></div>
                <div class="poi-item-body">
                    <div class="poi-item-name">${escapeHtml(it.name)}</div>
                    <div class="poi-item-cat">${CATS[it.cat].label}</div>
                    ${it.addr ? `<div class="poi-item-addr">${escapeHtml(it.addr)}</div>` : ''}
                    <div class="poi-item-meta">
                        <span class="poi-item-dist">${it.dist < 1 ? Math.round(it.dist * 1000) + ' m' : it.dist.toFixed(1) + ' km'}</span>
                        ${it.phone ? `<span class="poi-item-phone">☎ ${escapeHtml(it.phone)}</span>` : ''}
                        <a class="poi-item-go" href="https://www.google.com/maps/dir/?api=1&destination=${it.lat},${it.lon}" target="_blank" rel="noopener">Cómo llegar →</a>
                    </div>
                </div>
            </div>`).join('');

        list.querySelectorAll('.poi-item').forEach((node) => {
            node.addEventListener('click', (e) => {
                if (e.target.closest('.poi-item-go')) return;
                const lat = parseFloat(node.dataset.lat), lon = parseFloat(node.dataset.lon);
                if (map) map.setView([lat, lon], 15);
                const marker = markerById.get(node.dataset.id);
                if (marker) marker.openPopup();
            });
        });
    }

    function wireFilters() {
        document.querySelectorAll('.poi-filter-btn').forEach((btn) => {
            btn.addEventListener('click', () => {
                const cat = btn.dataset.cat;
                if (activeCats.has(cat)) { activeCats.delete(cat); btn.classList.remove('active'); }
                else { activeCats.add(cat); btn.classList.add('active'); }
                renderMarkers(allItems);
                renderList(allItems);
            });
        });
    }

    function buildItems(userLat, userLon) {
        return POIS.map((p, idx) => ({
            id: 'poi' + idx,
            ...p,
            dist: haversineKm(userLat, userLon, p.lat, p.lon)
        })).sort((a, b) => a.dist - b.dist);
    }

    async function boot() {
        const listEl = document.getElementById('poiList');
        if (!document.getElementById('poiMap')) return;
        try {
            const loc = await (window.ndaGetLocation ? window.ndaGetLocation() : Promise.resolve({ lat: 13.6929, lng: -89.2182 }));
            await initMap(loc.lat, loc.lng);
            wireFilters();
            allItems = buildItems(loc.lat, loc.lng);
            renderMarkers(allItems);
            renderList(allItems);
        } catch (e) {
            console.error('NDA poi-map error', e);
            if (listEl) listEl.innerHTML = '<div class="poi-error">No se pudo cargar el listado de puntos de interés.</div>';
        }
    }

    if (document.readyState === 'loading') document.addEventListener('DOMContentLoaded', boot);
    else boot();
})();

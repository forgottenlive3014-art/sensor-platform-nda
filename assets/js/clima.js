// NDA - Clima en Tiempo Real
// Datos 100% reales y en vivo desde Open-Meteo (sin API key, sin datos de
// ejemplo). Ubicacion resuelta via nda-location.js (geolocalizacion del
// navegador + reverse geocoding). Mapa: Leaflet + radar de lluvia RainViewer
// (gratuito, sin API key).
(function () {
    if (!document.getElementById('climaRoot')) return;

    const WMO = {
        0: { label: 'Despejado', cat: 'clear' },
        1: { label: 'Mayormente despejado', cat: 'partly' },
        2: { label: 'Parcialmente nublado', cat: 'partly' },
        3: { label: 'Nublado', cat: 'cloudy' },
        45: { label: 'Niebla', cat: 'fog' },
        48: { label: 'Niebla con escarcha', cat: 'fog' },
        51: { label: 'Llovizna ligera', cat: 'drizzle' },
        53: { label: 'Llovizna moderada', cat: 'drizzle' },
        55: { label: 'Llovizna intensa', cat: 'drizzle' },
        56: { label: 'Llovizna helada', cat: 'drizzle' },
        57: { label: 'Llovizna helada intensa', cat: 'drizzle' },
        61: { label: 'Lluvia ligera', cat: 'rain' },
        63: { label: 'Lluvia moderada', cat: 'rain' },
        65: { label: 'Lluvia intensa', cat: 'rain-heavy' },
        66: { label: 'Lluvia helada', cat: 'rain' },
        67: { label: 'Lluvia helada intensa', cat: 'rain-heavy' },
        71: { label: 'Nieve ligera', cat: 'snow' },
        73: { label: 'Nieve moderada', cat: 'snow' },
        75: { label: 'Nieve intensa', cat: 'snow' },
        77: { label: 'Granizo fino', cat: 'snow' },
        80: { label: 'Chubascos ligeros', cat: 'rain' },
        81: { label: 'Chubascos moderados', cat: 'rain' },
        82: { label: 'Chubascos violentos', cat: 'rain-heavy' },
        85: { label: 'Chubascos de nieve', cat: 'snow' },
        86: { label: 'Chubascos de nieve intensos', cat: 'snow' },
        95: { label: 'Tormenta eléctrica', cat: 'thunder' },
        96: { label: 'Tormenta con granizo ligero', cat: 'thunder' },
        99: { label: 'Tormenta con granizo intenso', cat: 'thunder' }
    };
    function wmoInfo(code) { return WMO[code] || { label: 'Variable', cat: 'cloudy' }; }

    function wxIconSVG(cat, isDay, size) {
        size = size || 56;
        const day = isDay !== false;
        switch (cat) {
            case 'clear':
                return `<svg class="wi wi-clear" width="${size}" height="${size}" viewBox="0 0 100 100">${day ?
                    `<g class="wi-rays"><g stroke="currentColor" stroke-width="4" stroke-linecap="round">
                        <line x1="50" y1="6" x2="50" y2="18"/><line x1="50" y1="82" x2="50" y2="94"/>
                        <line x1="6" y1="50" x2="18" y2="50"/><line x1="82" y1="50" x2="94" y2="50"/>
                        <line x1="16" y1="16" x2="24" y2="24"/><line x1="76" y1="76" x2="84" y2="84"/>
                        <line x1="84" y1="16" x2="76" y2="24"/><line x1="24" y1="76" x2="16" y2="84"/>
                    </g></g><circle class="wi-sun-core" cx="50" cy="50" r="22" fill="currentColor"/>` :
                    `<path class="wi-moon" d="M62 20a32 32 0 1 0 20 45 26 26 0 0 1-20-45z" fill="currentColor"/>
                    <circle cx="30" cy="26" r="1.6" fill="currentColor" opacity=".6"/><circle cx="20" cy="42" r="1.2" fill="currentColor" opacity=".5"/>`
                }</svg>`;
            case 'partly':
                return `<svg class="wi wi-partly" width="${size}" height="${size}" viewBox="0 0 100 100">
                    <g class="wi-rays" transform="translate(-8,-6)"><g stroke="currentColor" stroke-width="3.5" stroke-linecap="round" opacity=".9">
                        <line x1="46" y1="10" x2="46" y2="18"/><line x1="14" y1="42" x2="22" y2="42"/>
                        <line x1="22" y1="18" x2="27" y2="23"/><line x1="70" y1="18" x2="65" y2="23"/>
                    </g></g><circle class="wi-sun-core" cx="46" cy="42" r="17" fill="currentColor" opacity=".95"/>
                    <g class="wi-cloud"><path d="M30 78c-9 0-16-7-16-15s7-15 15-15c2-10 11-17 21-17 11 0 20 8 22 18 8 1 14 8 14 16 0 9-7 16-16 16H30z" fill="currentColor"/></g>
                </svg>`;
            case 'cloudy':
                return `<svg class="wi wi-cloudy" width="${size}" height="${size}" viewBox="0 0 100 100">
                    <g class="wi-cloud wi-cloud-back" opacity=".55"><path d="M20 60c-8 0-14-6-14-13s6-13 13-13c2-9 10-15 19-15 10 0 18 7 19 16 7 1 13 7 13 14 0 8-6 14-14 14H20z" fill="currentColor"/></g>
                    <g class="wi-cloud" transform="translate(10,14)"><path d="M28 70c-9 0-16-7-16-15s7-15 15-15c2-10 11-17 21-17 11 0 20 8 22 18 8 1 14 8 14 16 0 9-7 16-16 16H28z" fill="currentColor"/></g>
                </svg>`;
            case 'fog':
                return `<svg class="wi wi-fog" width="${size}" height="${size}" viewBox="0 0 100 100">
                    <g class="wi-cloud" transform="translate(6,-4)"><path d="M26 52c-8 0-14-6-14-13s6-13 13-13c2-9 10-15 19-15 10 0 18 7 19 16 7 1 13 7 13 14 0 8-6 14-14 14H26z" fill="currentColor" opacity=".85"/></g>
                    <g stroke="currentColor" stroke-width="4" stroke-linecap="round">
                        <line class="wi-fog-line" x1="14" y1="70" x2="86" y2="70"/>
                        <line class="wi-fog-line" x1="20" y1="82" x2="80" y2="82" style="animation-delay:.4s"/>
                        <line class="wi-fog-line" x1="10" y1="94" x2="90" y2="94" style="animation-delay:.8s"/>
                    </g>
                </svg>`;
            case 'drizzle':
            case 'rain':
            case 'rain-heavy':
                const drops = cat === 'rain-heavy' ? 5 : cat === 'rain' ? 4 : 3;
                let dropSvg = '';
                for (let i = 0; i < drops; i++) {
                    const x = 22 + i * (56 / (drops - 1 || 1));
                    dropSvg += `<line class="wi-drop" x1="${x}" y1="62" x2="${x - 4}" y2="78" style="animation-delay:${(i * 0.15).toFixed(2)}s"/>`;
                }
                return `<svg class="wi wi-rain" width="${size}" height="${size}" viewBox="0 0 100 100">
                    <g class="wi-cloud" transform="translate(6,-10)"><path d="M26 52c-8 0-14-6-14-13s6-13 13-13c2-9 10-15 19-15 10 0 18 7 19 16 7 1 13 7 13 14 0 8-6 14-14 14H26z" fill="currentColor"/></g>
                    <g stroke="currentColor" stroke-width="3.5" stroke-linecap="round">${dropSvg}</g>
                </svg>`;
            case 'snow':
                let flakes = '';
                for (let i = 0; i < 4; i++) {
                    const x = 24 + i * 17;
                    flakes += `<circle class="wi-flake" cx="${x}" cy="64" r="2.6" fill="currentColor" style="animation-delay:${(i * 0.25).toFixed(2)}s"/>`;
                }
                return `<svg class="wi wi-snow" width="${size}" height="${size}" viewBox="0 0 100 100">
                    <g class="wi-cloud" transform="translate(6,-10)"><path d="M26 52c-8 0-14-6-14-13s6-13 13-13c2-9 10-15 19-15 10 0 18 7 19 16 7 1 13 7 13 14 0 8-6 14-14 14H26z" fill="currentColor"/></g>
                    ${flakes}
                </svg>`;
            case 'thunder':
                return `<svg class="wi wi-thunder" width="${size}" height="${size}" viewBox="0 0 100 100">
                    <g class="wi-cloud" transform="translate(6,-12)"><path d="M26 52c-8 0-14-6-14-13s6-13 13-13c2-9 10-15 19-15 10 0 18 7 19 16 7 1 13 7 13 14 0 8-6 14-14 14H26z" fill="currentColor"/></g>
                    <polygon class="wi-bolt" points="54,58 40,80 50,80 44,96 66,70 54,70" style="fill:var(--acc4)"/>
                </svg>`;
            default:
                return `<svg width="${size}" height="${size}" viewBox="0 0 100 100"><circle cx="50" cy="50" r="20" fill="currentColor"/></svg>`;
        }
    }

    // Imagen ilustrativa del clima actual (assets/media/img/clima/), junto al
    // clima actual. Hay 3 ilustraciones (soleado/nublado/lluvioso); el resto
    // de condiciones (niebla, nieve) cae en "nublado" como la mas cercana.
    const WX_IMAGE_PATH = 'assets/media/img/clima/';
    function weatherImageFor(cat, isDay) {
        if (isDay && (cat === 'clear' || cat === 'partly')) return 'soleado.png';
        if (['rain', 'rain-heavy', 'drizzle', 'thunder'].includes(cat)) return 'lluvioso.png';
        return 'nublado.png';
    }

    const DIRS = ['N', 'NE', 'E', 'SE', 'S', 'SO', 'O', 'NO'];
    const dirName = deg => DIRS[Math.round(deg / 45) % 8] || '—';

    function fmtHour(iso) {
        return new Date(iso).toLocaleTimeString('es-SV', { hour: 'numeric', hour12: true });
    }
    function fmtDayShort(iso, idx) {
        if (idx === 0) return 'Hoy';
        if (idx === 1) return 'Mañana';
        const d = new Date(iso + 'T12:00:00');
        const s = d.toLocaleDateString('es-ES', { weekday: 'short' });
        return s.charAt(0).toUpperCase() + s.slice(1).replace('.', '');
    }

    async function fetchWeather(lat, lng) {
        const params = [
            'current=temperature_2m,relative_humidity_2m,apparent_temperature,precipitation,weather_code,cloud_cover,pressure_msl,wind_speed_10m,wind_direction_10m,is_day',
            'hourly=temperature_2m,precipitation_probability,weather_code,visibility,uv_index,dew_point_2m',
            'daily=weather_code,temperature_2m_max,temperature_2m_min,precipitation_probability_max,precipitation_sum,uv_index_max,wind_speed_10m_max',
            'timezone=auto', 'forecast_days=8'
        ].join('&');
        const url = `https://api.open-meteo.com/v1/forecast?latitude=${lat}&longitude=${lng}&${params}`;
        const resp = await fetch(url);
        if (!resp.ok) throw new Error('Open-Meteo error');
        return resp.json();
    }

    function buildSkyLine(data) {
        const times = data.hourly.time;
        const nowIso = new Date().toISOString().slice(0, 13);
        let idx = times.findIndex(t => t.slice(0, 13) >= nowIso);
        if (idx < 0) idx = 0;
        const next12 = [];
        for (let i = idx; i < idx + 12 && i < times.length; i++) next12.push(i);

        const rainIdx = next12.find(i => ['rain', 'rain-heavy', 'drizzle', 'thunder'].includes(wmoInfo(data.hourly.weather_code[i]).cat));
        if (rainIdx != null) return `Lluvia esperada cerca de las ${fmtHour(data.hourly.time[rainIdx])}.`;

        const maxRainProb = Math.max(...next12.map(i => data.hourly.precipitation_probability[i]));
        if (maxRainProb >= 40) return `Probabilidad de lluvia de hasta ${maxRainProb}% en las próximas horas.`;

        const curCat = wmoInfo(data.current.weather_code).cat;
        if (curCat === 'clear') return 'Cielo despejado durante todo el día.';
        if (curCat === 'partly' || curCat === 'cloudy') return 'Parcialmente nublado, sin lluvia a la vista.';
        if (curCat === 'fog') return 'Niebla en la zona — visibilidad reducida.';
        return 'Condiciones estables en las próximas horas.';
    }

    function renderHero(loc, data) {
        const cur = data.current;
        const info = wmoInfo(cur.weather_code);
        document.getElementById('climaLoc').textContent = [loc.municipio, loc.departamento, loc.pais].filter(Boolean).join(', ');
        document.getElementById('climaLocNote').style.display = loc.approx ? 'inline-flex' : 'none';
        document.getElementById('climaDate').textContent = new Date().toLocaleDateString('es-SV', { weekday: 'long', day: 'numeric', month: 'long' });
        document.getElementById('climaUpdated').textContent = 'Actualizado ' + new Date().toLocaleTimeString('es-SV', { hour: '2-digit', minute: '2-digit' });
        document.getElementById('climaIconBig').innerHTML = wxIconSVG(info.cat, cur.is_day === 1, 110);
        document.getElementById('climaTemp').textContent = Math.round(cur.temperature_2m) + '°';
        document.getElementById('climaFeels').textContent = 'Sensación ' + Math.round(cur.apparent_temperature) + '°';
        document.getElementById('climaCondLabel').textContent = info.label;
        const hi = Math.round(data.daily.temperature_2m_max[0]);
        const lo = Math.round(data.daily.temperature_2m_min[0]);
        document.getElementById('climaHiLo').innerHTML = `<span class="hilo-up">↑ ${hi}°</span><span class="hilo-down">↓ ${lo}°</span>`;
        document.getElementById('climaSkyLine').textContent = buildSkyLine(data);

        document.getElementById('climaWxImage').src = WX_IMAGE_PATH + weatherImageFor(info.cat, cur.is_day === 1);
        document.getElementById('climaWxImage').alt = info.label;
    }

    function renderHourly(data) {
        const times = data.hourly.time;
        const nowIso = new Date().toISOString().slice(0, 13);
        let startIdx = times.findIndex(t => t.slice(0, 13) >= nowIso);
        if (startIdx < 0) startIdx = 0;
        const slice = [];
        for (let i = startIdx; i < startIdx + 24 && i < times.length; i++) slice.push(i);

        document.getElementById('climaHourly').innerHTML = slice.map(i => {
            const info = wmoInfo(data.hourly.weather_code[i]);
            return `<div class="clima-hour-card${i === startIdx ? ' now' : ''}">
                <div class="chc-time">${i === startIdx ? 'Ahora' : fmtHour(data.hourly.time[i])}</div>
                <div class="chc-icon">${wxIconSVG(info.cat, true, 42)}</div>
                <div class="chc-temp">${Math.round(data.hourly.temperature_2m[i])}°</div>
                <div class="chc-precip">${data.hourly.precipitation_probability[i] >= 10 ? data.hourly.precipitation_probability[i] + '%' : ''}</div>
            </div>`;
        }).join('');
    }

    function renderDaily(data) {
        const d = data.daily;
        document.getElementById('climaDaily').innerHTML = d.time.slice(0, 7).map((t, i) => {
            const info = wmoInfo(d.weather_code[i]);
            const max = Math.round(d.temperature_2m_max[i]);
            const min = Math.round(d.temperature_2m_min[i]);
            const precip = d.precipitation_probability_max[i];
            return `<div class="clima-day-card${i === 0 ? ' today' : ''}">
                <div class="cdc-day">${fmtDayShort(t, i)}</div>
                <div class="cdc-icon">${wxIconSVG(info.cat, true, 38)}</div>
                <div class="cdc-precip">${precip >= 10 ? precip + '%' : ''}</div>
                <div class="cdc-temps"><span class="cdc-max">${max}°</span><span class="cdc-min">${min}°</span></div>
            </div>`;
        }).join('');
    }

    function renderIndicators(data) {
        const cur = data.current;
        const times = data.hourly.time;
        const nowIso = new Date().toISOString().slice(0, 13);
        let idx = times.findIndex(t => t.slice(0, 13) >= nowIso);
        if (idx < 0) idx = 0;
        const uv = data.hourly.uv_index[idx];
        const vis = data.hourly.visibility[idx];
        const dewPoint = data.hourly.dew_point_2m[idx];

        const ICONS = {
            wind: '<path d="M9.6 4.6a2 2 0 1 1 1.4 3.4H2M12.6 19.4a2 2 0 1 0 1.4-3.4H2M17.6 8.6a2.5 2.5 0 1 1 1.8 4.4H2"/>',
            droplet: '<path d="M12 2.5s6 7 6 11a6 6 0 1 1-12 0c0-4 6-11 6-11z"/>',
            eye: '<path d="M1 12s4-7 11-7 11 7 11 7-4 7-11 7-11-7-11-7z"/><circle cx="12" cy="12" r="3"/>',
            gauge: '<path d="M12 15a3 3 0 1 0 0-6 3 3 0 0 0 0 6z"/><path d="M19.4 15a8 8 0 1 0-14.8 0"/><line x1="12" y1="12" x2="15" y2="9"/>',
            thermo: '<path d="M14 14.76V3.5a2 2 0 0 0-4 0v11.26a4 4 0 1 0 4 0z"/>',
            sun: '<circle cx="12" cy="12" r="4.5"/><line x1="12" y1="2" x2="12" y2="4.5"/><line x1="12" y1="19.5" x2="12" y2="22"/><line x1="4.2" y1="4.2" x2="6" y2="6"/><line x1="18" y1="18" x2="19.8" y2="19.8"/><line x1="2" y1="12" x2="4.5" y2="12"/><line x1="19.5" y1="12" x2="22" y2="12"/><line x1="4.2" y1="19.8" x2="6" y2="18"/><line x1="18" y1="6" x2="19.8" y2="4.2"/>'
        };

        const windArrow = `<svg width="10" height="10" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="3" stroke-linecap="round" stroke-linejoin="round" style="transform:rotate(${(cur.wind_direction_10m + 180) % 360}deg);vertical-align:-1px;margin-left:3px"><line x1="12" y1="19" x2="12" y2="5"/><polyline points="5 12 12 5 19 12"/></svg>`;

        const items = [
            {
                icon: 'wind', label: 'Viento',
                value: Math.round(cur.wind_speed_10m) + ' km/h' + windArrow,
                title: 'Viene del ' + dirName(cur.wind_direction_10m)
            },
            { icon: 'droplet', label: 'Humedad', value: cur.relative_humidity_2m + '%' },
            { icon: 'eye', label: 'Visibilidad', value: vis != null ? (vis / 1000).toFixed(1) + ' km' : '—' },
            { icon: 'gauge', label: 'Presión', value: Math.round(cur.pressure_msl) + ' hPa' },
            { icon: 'thermo', label: 'Punto de rocío', value: dewPoint != null ? Math.round(dewPoint) + '°' : '—' },
            { icon: 'sun', label: 'Índice UV', value: uv != null ? Math.round(uv) + (uv >= 8 ? ' Alto' : '') : '—' }
        ];

        document.getElementById('climaIndicators').innerHTML = items.map(it => `
            <div class="cir-item"${it.title ? ` title="${it.title}"` : ''}>
                <svg class="cir-icon" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">${ICONS[it.icon]}</svg>
                <div class="cir-txt"><span class="cir-lbl">${it.label}</span><span class="cir-val">${it.value}</span></div>
            </div>`).join('');
    }

    function renderAlerts(data) {
        const alerts = [];
        const d = data.daily;
        if (d.precipitation_probability_max[0] >= 75 || d.precipitation_probability_max[1] >= 75) {
            alerts.push({ level: 'red', title: 'Lluvias intensas', body: 'Alta probabilidad de precipitación fuerte en las próximas 48 horas.' });
        }
        if (d.precipitation_sum[0] >= 40) {
            alerts.push({ level: 'orange', title: 'Riesgo de inundación', body: `Se esperan ${Math.round(d.precipitation_sum[0])}mm de lluvia acumulada hoy — precaución en zonas bajas.` });
        }
        if (d.wind_speed_10m_max[0] >= 45) {
            alerts.push({ level: 'orange', title: 'Fuertes vientos', body: `Ráfagas de hasta ${Math.round(d.wind_speed_10m_max[0])} km/h previstas hoy.` });
        }
        if (d.uv_index_max[0] >= 10) {
            alerts.push({ level: 'red', title: 'Radiación UV extrema', body: 'Índice UV muy alto — evita exposición directa entre 10am y 3pm.' });
        }
        if (d.temperature_2m_max[0] >= 35) {
            alerts.push({ level: 'red', title: 'Calor extremo', body: `Temperatura máxima esperada de ${Math.round(d.temperature_2m_max[0])}°C.` });
        }

        const wrap = document.getElementById('climaAlerts');
        if (!alerts.length) { wrap.style.display = 'none'; wrap.innerHTML = ''; return; }
        wrap.style.display = 'grid';
        wrap.innerHTML = alerts.map(a => `
            <div class="clima-alert clima-alert-${a.level}">
                <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M10.3 3.9L1.8 18a2 2 0 0 0 1.7 3h17a2 2 0 0 0 1.7-3L13.7 3.9a2 2 0 0 0-3.4 0z"/><line x1="12" y1="9" x2="12" y2="13"/><line x1="12" y1="17" x2="12.01" y2="17"/></svg>
                <div><strong>${a.title}</strong><p>${a.body}</p></div>
            </div>`).join('');
    }

    function renderRecs(data) {
        const cur = data.current;
        const d = data.daily;
        const times = data.hourly.time;
        const nowIso = new Date().toISOString().slice(0, 13);
        let idx = times.findIndex(t => t.slice(0, 13) >= nowIso);
        if (idx < 0) idx = 0;
        const vis = data.hourly.visibility[idx];

        const recs = [];
        if (d.precipitation_probability_max[0] >= 50) recs.push({ icon: 'umbrella', accent: 'blue', text: 'Lleva paraguas o impermeable, buena probabilidad de lluvia hoy.' });
        if (d.uv_index_max[0] >= 7) recs.push({ icon: 'sun', accent: 'acc', text: 'Usa protector solar y evita la exposición prolongada al sol.' });
        if (d.wind_speed_10m_max[0] >= 30) recs.push({ icon: 'wind', accent: 'teal', text: 'Precaución con objetos sueltos por fuertes vientos.' });
        if (cur.apparent_temperature >= 30) recs.push({ icon: 'water', accent: 'red', text: 'Mantente hidratado, la sensación térmica es elevada.' });
        if (cur.relative_humidity_2m >= 85) recs.push({ icon: 'water', accent: 'teal', text: 'Ambiente muy húmedo — busca zonas ventiladas o con sombra.' });
        if (cur.apparent_temperature <= 18) recs.push({ icon: 'cold', accent: 'purple', text: 'Sensación fresca — considera llevar una chaqueta ligera.' });
        if (vis != null && vis < 4000) recs.push({ icon: 'eye', accent: 'purple', text: 'Visibilidad reducida — maneja con precaución y luces encendidas.' });
        if (!recs.length) recs.push({ icon: 'check', accent: 'green', text: 'Condiciones estables. Buen momento para actividades al aire libre.' });

        const ICONS = {
            umbrella: '<path d="M12 2a9 9 0 0 0-9 9h4a5 5 0 0 1 10 0h4a9 9 0 0 0-9-9z"/><line x1="12" y1="2" x2="12" y2="4"/><path d="M12 11v8a2 2 0 0 1-4 0"/>',
            sun: '<circle cx="12" cy="12" r="4.5"/><line x1="12" y1="2" x2="12" y2="4.5"/><line x1="12" y1="19.5" x2="12" y2="22"/><line x1="4.2" y1="4.2" x2="6" y2="6"/><line x1="18" y1="18" x2="19.8" y2="19.8"/>',
            wind: '<path d="M9.6 4.6a2 2 0 1 1 1.4 3.4H2M12.6 19.4a2 2 0 1 0 1.4-3.4H2M17.6 8.6a2.5 2.5 0 1 1 1.8 4.4H2"/>',
            water: '<path d="M12 2.5s6 7 6 11a6 6 0 1 1-12 0c0-4 6-11 6-11z"/>',
            cold: '<path d="M14 14.76V3.5a2 2 0 0 0-4 0v11.26a4 4 0 1 0 4 0z"/>',
            eye: '<path d="M1 12s4-7 11-7 11 7 11 7-4 7-11 7-11-7-11-7z"/><circle cx="12" cy="12" r="3"/>',
            check: '<path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"/><polyline points="22 4 12 14.01 9 11.01"/>'
        };
        document.getElementById('climaRecs').innerHTML = recs.map(r => `
            <div class="clima-rec-card clima-rec-${r.accent}">
                <div class="crc-icon"><svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">${ICONS[r.icon]}</svg></div>
                <span>${r.text}</span>
            </div>`).join('');
    }

    let climaMap = null;
    async function initMap(lat, lng) {
        const el = document.getElementById('climaMap');
        if (!el || !window.L) return;
        const isDark = document.documentElement.getAttribute('data-theme') !== 'light';
        const tileUrl = isDark
            ? 'https://{s}.basemaps.cartocdn.com/dark_all/{z}/{x}/{y}{r}.png'
            : 'https://{s}.basemaps.cartocdn.com/light_all/{z}/{x}/{y}{r}.png';

        climaMap = L.map(el, { zoomControl: true, attributionControl: false }).setView([lat, lng], 9);
        L.tileLayer(tileUrl, { subdomains: 'abcd', maxZoom: 18 }).addTo(climaMap);
        L.control.attribution({ prefix: false }).addAttribution('© CARTO · © RainViewer · © OpenStreetMap').addTo(climaMap);
        const marker = L.circleMarker([lat, lng], { radius: 7, color: '#3d6f8f', fillColor: '#3d6f8f', fillOpacity: .9, weight: 2 }).addTo(climaMap);

        let rainLayer = null, cloudLayer = null;
        try {
            const resp = await fetch('https://api.rainviewer.com/public/weather-maps.json');
            const meta = await resp.json();
            const lastRain = meta.radar && meta.radar.past && meta.radar.past.length ? meta.radar.past[meta.radar.past.length - 1] : null;
            const lastSat = meta.satellite && meta.satellite.infrared && meta.satellite.infrared.length ? meta.satellite.infrared[meta.satellite.infrared.length - 1] : null;
            if (lastRain) {
                rainLayer = L.tileLayer(`https://tilecache.rainviewer.com${lastRain.path}/256/{z}/{x}/{y}/2/1_1.png`, { opacity: 0.65, maxZoom: 12 });
                rainLayer.addTo(climaMap);
            }
            if (lastSat) {
                cloudLayer = L.tileLayer(`https://tilecache.rainviewer.com${lastSat.path}/256/{z}/{x}/{y}/0/0_0.png`, { opacity: 0.5, maxZoom: 12 });
            }
        } catch (e) { /* radar es un extra, el mapa base sigue funcionando sin el */ }

        const btnRain = document.getElementById('climaLayerRain');
        const btnCloud = document.getElementById('climaLayerCloud');
        if (btnRain) btnRain.addEventListener('click', () => {
            btnRain.classList.toggle('active');
            if (rainLayer) { climaMap.hasLayer(rainLayer) ? climaMap.removeLayer(rainLayer) : rainLayer.addTo(climaMap); }
        });
        if (btnCloud) btnCloud.addEventListener('click', () => {
            btnCloud.classList.toggle('active');
            if (cloudLayer) { climaMap.hasLayer(cloudLayer) ? climaMap.removeLayer(cloudLayer) : cloudLayer.addTo(climaMap); }
        });

        const expandBtn = document.getElementById('climaMapExpand');
        const mapCard = document.getElementById('climaMapCard');
        if (expandBtn) expandBtn.addEventListener('click', () => {
            mapCard.classList.toggle('clima-map-expanded');
            setTimeout(() => climaMap.invalidateSize(), 260);
        });
    }

    // Segundo mapa, independiente del radar RainViewer de arriba: capas de
    // OpenWeatherMap (precipitacion/nubes/temperatura/viento), una a la vez
    // como pestañas. La API key es publica (solo pide tiles de mapa, no
    // accede a la cuenta) y llega por data-owm-key desde clima.php.
    let climaMapOwm = null;
    function initOwmMap(lat, lng) {
        const el = document.getElementById('climaMapOwm');
        const root = document.getElementById('climaRoot');
        const key = root ? root.dataset.owmKey : '';
        if (!el || !window.L || !key) return;

        const isDark = document.documentElement.getAttribute('data-theme') !== 'light';
        const tileUrl = isDark
            ? 'https://{s}.basemaps.cartocdn.com/dark_all/{z}/{x}/{y}{r}.png'
            : 'https://{s}.basemaps.cartocdn.com/light_all/{z}/{x}/{y}{r}.png';

        climaMapOwm = L.map(el, { zoomControl: true, attributionControl: false }).setView([lat, lng], 7);
        L.tileLayer(tileUrl, { subdomains: 'abcd', maxZoom: 18 }).addTo(climaMapOwm);
        L.control.attribution({ prefix: false }).addAttribution('© CARTO · © OpenWeatherMap · © OpenStreetMap').addTo(climaMapOwm);
        L.circleMarker([lat, lng], { radius: 7, color: '#3d6f8f', fillColor: '#3d6f8f', fillOpacity: .9, weight: 2 }).addTo(climaMapOwm);

        let owmLayer = null;
        function setOwmLayer(layerId) {
            if (owmLayer) climaMapOwm.removeLayer(owmLayer);
            owmLayer = L.tileLayer(`https://tile.openweathermap.org/map/${layerId}/{z}/{x}/{y}.png?appid=${key}`, { opacity: 0.7, maxZoom: 18 });
            owmLayer.addTo(climaMapOwm);
        }
        setOwmLayer('precipitation_new');

        const btns = document.querySelectorAll('#climaMapOwmCard .clima-layer-btn');
        btns.forEach(btn => btn.addEventListener('click', () => {
            btns.forEach(b => b.classList.remove('active'));
            btn.classList.add('active');
            setOwmLayer(btn.dataset.owmLayer);
        }));

        const expandBtn = document.getElementById('climaMapOwmExpand');
        const mapCard = document.getElementById('climaMapOwmCard');
        if (expandBtn) expandBtn.addEventListener('click', () => {
            mapCard.classList.toggle('clima-map-expanded');
            setTimeout(() => climaMapOwm.invalidateSize(), 260);
        });
    }

    async function boot() {
        try {
            const loc = await window.ndaGetLocation();
            const data = await fetchWeather(loc.lat, loc.lng);
            renderHero(loc, data);
            renderHourly(data);
            renderDaily(data);
            renderIndicators(data);
            renderAlerts(data);
            renderRecs(data);
            initMap(loc.lat, loc.lng);
            initOwmMap(loc.lat, loc.lng);
        } catch (e) {
            const root = document.getElementById('climaRoot');
            if (root) root.querySelector('.clima-hero-main').innerHTML = '<div class="loading-s">⚠️ No se pudo cargar el clima. Intenta de nuevo más tarde.</div>';
            console.error('NDA clima error', e);
        }
    }

    if (document.readyState === 'loading') document.addEventListener('DOMContentLoaded', boot);
    else boot();
})();

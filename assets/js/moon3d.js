/* ================================================================
   NDA — Luna 3D en tiempo real (CesiumJS, sin token de Cesium ion)
   Muestra la Luna renderizada con su posicion e iluminacion solar
   reales para el momento actual (Cesium.Simon1994PlanetaryPositions),
   no una animacion prefijada.
   ================================================================ */
(function () {
    const el = document.getElementById('moon3dContainer');
    if (!el || typeof ensureCesiumLoaded !== 'function') return;

    async function init() {
        await ensureCesiumLoaded();

        const viewer = new Cesium.Viewer('moon3dContainer', {
            globe: false,
            imageryProvider: false,
            baseLayerPicker: false,
            geocoder: false,
            homeButton: false,
            sceneModePicker: false,
            navigationHelpButton: false,
            animation: false,
            timeline: false,
            fullscreenButton: false,
            infoBox: false,
            selectionIndicator: false,
            requestRenderMode: true,
            maximumRenderTimeChange: Infinity
        });

        viewer.scene.skyAtmosphere.show = false;
        if (viewer.scene.sun) viewer.scene.sun.show = false;
        if (!viewer.scene.moon) viewer.scene.moon = new Cesium.Moon();

        // Momento real (no se anima): posicion e iluminacion tal como son
        // "ahora mismo", calculadas con datos astronomicos reales.
        const now = Cesium.JulianDate.now();
        viewer.clock.currentTime = now;
        viewer.clock.shouldAnimate = false;

        const moonPosEci = Cesium.Simon1994PlanetaryPositions.computeMoonPositionInEarthInertialFrame(now);
        const temeToFixed = Cesium.Transforms.computeTemeToPseudoFixedMatrix(now);
        const moonPosFixed = Cesium.Matrix3.multiplyByVector(temeToFixed, moonPosEci, new Cesium.Cartesian3());
        const dirToMoon = Cesium.Cartesian3.normalize(moonPosFixed, new Cesium.Cartesian3());

        // Camara ubicada lejos de la Tierra, sobre la misma linea Tierra-Luna,
        // mirando hacia la Luna real — reproduce aproximadamente la fase tal
        // como se ve desde la Tierra en este momento.
        const camPos = Cesium.Cartesian3.multiplyByScalar(dirToMoon, 20000000, new Cesium.Cartesian3());
        viewer.camera.setView({
            destination: camPos,
            orientation: { direction: dirToMoon, up: Cesium.Cartesian3.UNIT_Z }
        });

        function resize() { viewer.resize(); viewer.scene.requestRender(); }
        window.addEventListener('resize', resize);
    }

    init();
})();

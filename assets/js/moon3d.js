// NDA - Luna 3D en tiempo real (CesiumJS), posicion e iluminacion reales para el momento actual
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

        const now = Cesium.JulianDate.now();
        viewer.clock.currentTime = now;
        viewer.clock.shouldAnimate = false;

        const moonPosEci = Cesium.Simon1994PlanetaryPositions.computeMoonPositionInEarthInertialFrame(now);
        const temeToFixed = Cesium.Transforms.computeTemeToPseudoFixedMatrix(now);
        const moonPosFixed = Cesium.Matrix3.multiplyByVector(temeToFixed, moonPosEci, new Cesium.Cartesian3());
        const dirToMoon = Cesium.Cartesian3.normalize(moonPosFixed, new Cesium.Cartesian3());

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

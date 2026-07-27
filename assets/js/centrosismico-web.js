const ctxViva = document.getElementById('graficaViva').getContext('2d');

const graficaViva = new Chart(ctxViva, {

    type: 'line',

    data: {

        labels: [],

        datasets: [
            {
                label: 'X',
                data: [],
                borderColor: '#ff3c3c',
                borderWidth: 2,
                pointRadius: 0,
                tension: 0.3,
                fill: false
            },
            {
                label: 'Y',
                data: [],
                borderColor: '#3cff3c',
                borderWidth: 2,
                pointRadius: 0,
                tension: 0.3,
                fill: false
            },
            {
                label: 'Z',
                data: [],
                borderColor: '#3caaff',
                borderWidth: 2,
                pointRadius: 0,
                tension: 0.3,
                fill: false
            }
        ]

    },

    options: {

        responsive: true,

        animation: false,

        scales: {

            y: {

                suggestedMin: -2,
                suggestedMax: 2

            }

        }

    }

});

async function cargarLecturas(){

    try{

        const respuesta = await fetch("../API/obtener_lecturas.php");

        const datos = await respuesta.json();

        graficaViva.data.labels = datos.map(d => d.ts.split(" ")[1] ?? d.ts);

        graficaViva.data.datasets[0].data = datos.map(d => d.ax);
        graficaViva.data.datasets[1].data = datos.map(d => d.ay);
        graficaViva.data.datasets[2].data = datos.map(d => d.az);

        graficaViva.update();

    }

    catch(error){

        console.log(error);

    }

}

cargarLecturas();

setInterval(cargarLecturas,200);

const ctx = document.getElementById('graficaSismos').getContext('2d');

const grafica = new Chart(ctx, {

    type: 'line',

    data: {

        labels: [],

        datasets: [{

            label: 'Magnitud',

            data: [],

            borderColor: '#00e5ff',

            backgroundColor: 'rgba(0,229,255,0.2)',

            borderWidth: 2,

            tension: 0.3,

            fill: true

        }]

    },

    options: {

        responsive: true,

        animation: false,

        scales: {

            y: {

                beginAtZero: true,

                suggestedMax: 8

            }

        }

    }

});

function colorNivel(nivel){

    switch(nivel){

        case "LEVE": return "#ffd400";
        case "MODERADO": return "#ff9500";
        case "FUERTE": return "#ff3b3b";
        case "TERREMOTO": return "#b03bff";
        case "MICRO SISMO": return "#00e676";
        default: return "#00e676";

    }

}

function badgeNivel(nivel){

    const color = colorNivel(nivel);

    return `<span style="color:${color}">&#9679;</span> ${nivel}`;

}

async function cargarDatos(){

    try{

        const respuesta = await fetch("../API/obtener_sismo.php");

        const datos = await respuesta.json();

        actualizarTabla(datos);

        actualizarGrafica(datos);

        actualizarEstado(datos);

    }

    catch(error){

        console.log(error);

    }

}

function actualizarEstado(datos){

    if(datos.length==0) return;

    const ultimo = datos[0];

    document.getElementById("magnitud").innerHTML =
        parseFloat(ultimo.magnitud).toFixed(2);

    document.getElementById("nivel").innerHTML =
        badgeNivel(ultimo.nivel);

}

function actualizarTabla(datos){

    let tabla = "";

    datos.slice(0,10).forEach(sismo=>{

        tabla += `

        <tr>

            <td>${sismo.fecha}</td>

            <td>${sismo.hora}</td>

            <td>${parseFloat(sismo.magnitud).toFixed(2)}</td>

            <td>${badgeNivel(sismo.nivel)}</td>

        </tr>

        `;

    });

    document.getElementById("tabla").innerHTML = tabla;

}

function actualizarGrafica(datos){

    grafica.data.labels = [];

    grafica.data.datasets[0].data = [];

    datos.reverse().forEach(sismo=>{

        grafica.data.labels.push(sismo.hora);

        grafica.data.datasets[0].data.push(sismo.magnitud);

    });

    grafica.update();

}

cargarDatos();

setInterval(cargarDatos,500);
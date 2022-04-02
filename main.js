const apiKey = "pk.eyJ1IjoicGthc2VtZXIiLCJhIjoiY2wxYzNwMnRrMDN2czNkbzBnd2NtM3B5ZSJ9.anQZtZnER9oJ2rodYqx-XQ";

const mymap = L.map('map').setView([2.7720190833020135, 32.30025580020922], 13);

L.tileLayer('https://api.mapbox.com/styles/v1/{id}/tiles/{z}/{x}/{y}?access_token={accessToken}', {
    maxZoom: 18,
    id: 'mapbox/streets-v11',
    tileSize: 512,
    zoomOffset: -1,
    accessToken: apiKey
}).addTo(mymap);


//Add circle
const circle = L.circle([2.7720190833020135, 32.30025580020922], {
    radius: 100,
    color: 'green'
}).addTo(mymap);


const url = 'https://yugimap.com/mobile/api/v1/infrastructure/read.php?page=1';

async function getInfrastructure() {
    const response = await fetch(url);
    const data = await response.json();

    const { total_results, infrastructure } = data;


    infrastructure.forEach(element => {
        const { id, aim, description, longitude, latitude, type } = element;
        //adding Marker
        const marker = L.marker([latitude, longitude]).addTo(mymap);

        //Add popup message
        let template = `
            <h1 style="text-align:center; text-transform: capitalize; color: #015418;">${type}</h1>
            <div style="text-align:center">
            <h2>${description}</h2>
            <p>${aim}</p>
            <p>This location may change based on the tracker device </p>
            </div>
            `
        marker.bindPopup(template);
    });


}

getInfrastructure();

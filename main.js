const apiKey = "pk.eyJ1IjoicGthc2VtZXIiLCJhIjoiY2wxYzNwMnRrMDN2czNkbzBnd2NtM3B5ZSJ9.anQZtZnER9oJ2rodYqx-XQ";

const mymap = L.map('map').setView([2.2398967680870316, 32.89527797106312], 13);

L.tileLayer('https://api.mapbox.com/styles/v1/{id}/tiles/{z}/{x}/{y}?access_token={accessToken}', {
    maxZoom: 18,
    id: 'mapbox/streets-v11',
    tileSize: 512,
    zoomOffset: -1,
    accessToken: apiKey
}).addTo(mymap);


//adding Marker
const marker = L.marker([2.239878798827563, 32.89395403994614]).addTo(mymap);

//Add popup message
let template = `
<h1>Yugi Map Demo</h1>

<div style="text-align:center">
<h2>This location may change based on the tracker device</h2>
</div>
`
marker.bindPopup(template);

//Add circle
const circle = L.circle([2.239878798827563, 32.89395403994614], {
    radius: 500,
    color: 'green'
}).addTo(mymap)

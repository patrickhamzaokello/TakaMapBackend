const apiKey = "pk.eyJ1IjoicGthc2VtZXIiLCJhIjoiY2wxYzNwMnRrMDN2czNkbzBnd2NtM3B5ZSJ9.anQZtZnER9oJ2rodYqx-XQ";

const mymap = L.map('map').setView([2.7720190833020135, 32.30025580020922], 14);

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
            
            <div class="infras_card" style="border-radius: 20px;background-color:#228765 ; padding: 2em; color: #fff; font-size: 15px;">
            <h1 style="color: #F6FFEE; font-size: 22px;">${type}</h1>
            <p style="margin: 0;color: #CDEDCB;">${description}</p>
            <p style="margin: 0;color:#36CC7C ;margin-top: 1em;"><span style="color: #CDEDCB;">Aim</span>${aim}</p>
            <p style="margin: 0;"><span style="color: #CDEDCB;">Contact</span> 0787250196</p>
            <p style="margin: 0;"><span style="color: #CDEDCB;">Install Date</span> 8th Jun 2022</p>
            <p style=" margin: 0; color: #D9D055; margin-top: 1em; font-size: 12px;">This location may change based on the tracker device</p>
          </div>
            `
        marker.bindPopup(template);
    });


}

getInfrastructure();

const body = document.querySelector("body"),
sidebar = body.querySelector("nav"),
searchBtn = body.querySelector(".search-box"),
modeSwitch = body.querySelector(".toggle-switch"),
modeText = body.querySelector(".mode-text");

searchBtn.addEventListener("click", () => {
sidebar.classList.remove("close");
});

modeSwitch.addEventListener("click", () => {
body.classList.toggle("dark");

if (body.classList.contains("dark")) {
  modeText.innerText = "Light mode";
} else {
  modeText.innerText = "Dark mode";
}
});

var example_array = {
ValueA: "Gulu",
ValueB: "Lira",
ValueC: "Apac",
};

var select = document.getElementById("example-select");
for (index in example_array) {
select.options[select.options.length] = new Option(
  example_array[index],
  index
);
}

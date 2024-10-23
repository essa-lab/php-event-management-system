const menuIcon = document.querySelector('#menu-icon');
const navbar = document.querySelector('.navbar');
const navbg = document.querySelector('.nav-bg');
const apiKey = localStorage.getItem('apiKey');
menuIcon.addEventListener('click', () => {
    menuIcon.classList.toggle('bx-x');
    navbar.classList.toggle('active');
    navbg.classList.toggle('active');
});

function notify(className, text){
    const notification = document.createElement('div');
    notification.className = 'notification';

    notification.classList.add(className);
    notification.innerText = text;

    document.body.appendChild(notification);

    setTimeout(() => {
        notification.remove();
    }, 5000);
}

async function fillLocationSelect(){
    const locationSelect = document.getElementById('location-select');
    const url = `/api/location-options`;
    
    // Fetch data from the server
    const response = await fetch(url);
    const data = await response.json(); 

    data.locations.forEach(item => {
        const option = document.createElement('option');
        option.value = item.id; // Set the option value
        option.textContent = item.location_name; // Set the option text
        
        locationSelect.appendChild(option); // Add the option to the select element
    });
}

async function fillParticipantSelect(){
    const locationSelect = document.getElementById('participant-select');
    const url = `/api/participant-options`;
    
    // Fetch data from the server
    const response = await fetch(url);
    const data = await response.json(); 

    data.participants.forEach(item => {
        const option = document.createElement('option');
        option.value = item.id; // Set the option value
        option.textContent = item.name; // Set the option text
        
        locationSelect.appendChild(option); // Add the option to the select element
    });
}

async function fillEventSelect(){
    const locationSelect = document.getElementById('event-select');
    const url = `/api/event-options`;
    
    // Fetch data from the server
    const response = await fetch(url);
    const data = await response.json(); 

    data.events.forEach(item => {
        const option = document.createElement('option');
        option.value = item.event_id; // Set the option value
        option.textContent = item.title; // Set the option text
        
        locationSelect.appendChild(option); // Add the option to the select element
    });
}


const baseUri = '/api' + window.location.pathname;

const tableBody = document.getElementById('table-body');


function fillUserTable(data){
    data.forEach(user => {
     const row = 
         `<tr>
             <td>${user.id}</td>
             <td>${user.name}</td>
             <td>${user.ip}</td>
             <td>${user.blocked_at}</td>
             <td><button class="action-btn" onclick="toggleBlock(${user.id})">${user.is_blocked==0?"Block":"UnBlock"}</button></td>
             <td>
                 <button onclick="window.location.href='/user/'+${user.id}" id="edit-button" class="action-btn edit-btn">Edit</button>
                 <button onclick="deleteRow(${user.id})" class="action-btn delete-btn">Delete</button>

             </td>
         </tr>`
     ;
     tableBody.insertAdjacentHTML('beforeend', row);
 });

}
async function toggleBlock(id){
    const response = await fetch(`/api/toggle-block/${id}`,{
        method:"PUT",
        headers: {
			'api_key': apiKey,
		},
    });
    const data = await response.json();

    if(data.statusCode ==200){
        notify('success','Done');

    }else{
        notify('error',data.message);

    }
    
    const parameters = getURLParams();
    renderTable(parameters.page,parameters.perPage,parameters.perPage)
}
function fillEventTable(data){
    data.forEach(event => {
     const row = 
         `<tr>
             <td>${event.event_id}</td>
             <td>${event.title}</td>
             <td>${event.location_name}</td>
             <td>${event.start_date}</td>
             <td>${event.end_date}</td>
             <td>
                 <button onclick="window.location.href='/event/'+${event.event_id}" id="edit-button" class="action-btn edit-btn">Edit</button>
                 <button onclick="deleteRow(${event.event_id})" class="action-btn delete-btn">Delete</button>

             </td>
         </tr>`
     ;
     tableBody.insertAdjacentHTML('beforeend', row);
 });

}

function fillLocationTable(data){
    data.forEach(location => {
     const row = 
         `<tr>
             <td>${location.id}</td>
             <td>${location.location_name}</td>
             <td>${location.address}</td>
             <td>${location.capacity}</td>
             <td>
                 <button onclick="window.location.href='/location/'+${location.id}" id="edit-button" class="action-btn edit-btn">Edit</button>
                 <button onclick="deleteRow(${location.id})" class="action-btn delete-btn">Delete</button>

             </td>
         </tr>`
     ;
     tableBody.insertAdjacentHTML('beforeend', row);
 });

}

function fillParticipantTable(data){
    data.forEach(participant => {
     const row = 
         `<tr>
             <td>${participant.id}</td>
             <td>${participant.name}</td>
            <td>${participant.phone_number}</td>

             <td>
                 <button onclick="window.location.href='/participant/'+${participant.id}" id="edit-button" class="action-btn edit-btn">Edit</button>
                 <button onclick="deleteRow(${participant.id})" class="action-btn delete-btn">Delete</button>

             </td>
         </tr>`
     ;
     tableBody.insertAdjacentHTML('beforeend', row);
 });

}

function fillEventParticipantTable(data){
    data.forEach(eventParticipant => {
        const occupancyRate = (eventParticipant.total_participants*100)/eventParticipant.capacity;
     const row = 
         `<tr>
             <td>${eventParticipant.title}</td>
            <td>${eventParticipant.location_name}</td>
            <td>${eventParticipant.address}</td>

            <td>${eventParticipant.total_participants} / ${eventParticipant.capacity}</td>

            <td>${occupancyRate} % ${occupancyRate > 85 ? '<svg xmlns="http://www.w3.org/2000/svg" height="24px" viewBox="0 0 24 24" width="24px" fill="orange"><path d="M0 0h24v24H0z" fill="none"/><path d="M1 21h22L12 2 1 21zm12-3h-2v-2h2v2zm0-4h-2v-4h2v4z"/></svg>':''}</td>
            <td><a href="/show-participant/${eventParticipant.event_id}">Show Event Participants</a></td>
         </tr>`
     ;
     tableBody.insertAdjacentHTML('beforeend', row);
 });

}

function fillParticipantForEvent(data){
    data.forEach(eventParticipant => {
     const row = 
         `<tr>
             <td>${eventParticipant.name}</td>
            <td>${eventParticipant.phone_number}</td>
         </tr>`
     ;
     tableBody.insertAdjacentHTML('beforeend', row);
 });

}
// Function to render tables based on data
function fillTable(data) {
    tableBody.innerHTML = ''; // Clear previous table data

    if (baseUri.includes('/event-participant')) {
        fillEventParticipantTable(data);

        fillLocationSelect()

    } else if (baseUri.includes('/location')) {
        fillLocationTable(data);
    }else if (baseUri.includes('/participant')) {
        fillParticipantTable(data);
    }
     else if (baseUri.includes('/blacklist')) {
        fillBlacklistTable(data);
    } else if (baseUri.includes('/event')) {
        fillEventTable(data);
        fillLocationSelect()
    }else if (baseUri.includes('/show-participant')) {
        fillParticipantForEvent(data);
    }else if (baseUri.includes('/user')) {
        fillUserTable(data);
    }
}
async function deleteRow(id){
    const response = await fetch(`${baseUri}/${id}`,{
        method:"DELETE",
        headers:{
            'api_key':apiKey
        }
    });
    const data = await response.json();

    if(data.statusCode ==200){
        notify('success','Record Deleted Successfully');

    }else{
        notify('error',data.message);

    }
    
    const parameters = getURLParams();
    renderTable(parameters.page,parameters.perPage,parameters.perPage)
}
// Function to handle rendering data and pagination
async function renderTable(currentPage, rowsPerPage, searchTerms = {}) {
    // Convert search terms into query string format
    const searchQuery = Object.entries(searchTerms)
        .map(([key, value]) => `${encodeURIComponent(key)}=${encodeURIComponent(value)}`)
        .join('&');

    // Build the full URL for the API request
    const url = `${baseUri}?page=${currentPage}&perPage=${rowsPerPage}${searchQuery ? '&' + searchQuery : ''}`;
    console.log(url);
    // Fetch data from the server
    const response = await fetch(url);
    const data = await response.json();

    // Update the table with the fetched data
    fillTable(data.item.data);

    // Handle pagination controls
    updatePaginationControls(data.item.total_pages, currentPage, rowsPerPage, searchTerms);
}

// Function to update the URL and trigger table re-render
function updateURLAndRender(currentPage, rowsPerPage, searchTerms) {
    // Build the new URL with parameters
    console.log(searchTerms)
    const filledParams = Object.fromEntries(
        Object.entries(searchTerms).filter(([key, value]) => value !== '')
    );

    const searchQuery = Object.entries(filledParams)
        .map(([key, value]) => `${encodeURIComponent(key)}=${encodeURIComponent(value)}`)
        .join('&');

    const newUrl = `${window.location.pathname}?page=${currentPage}&perPage=${rowsPerPage}${searchQuery ? '&' + searchQuery : ''}`;
    window.history.pushState(null, '', newUrl);

    // Re-render the table with the updated URL parameters
    renderTable(currentPage, rowsPerPage, searchTerms);
}

// Function to handle pagination controls
function updatePaginationControls(totalPages, currentPage, rowsPerPage, searchTerms) {
    const paginationControls = document.getElementById('pagination-controls');
    paginationControls.innerHTML = ''; // Clear previous pagination

    for (let i = 1; i <= totalPages; i++) {
        const button = document.createElement('button');
        button.textContent = i;
        button.dataset.page = i;
        button.classList.add('pagination-btn')

        // Add event listener for each pagination button
        button.addEventListener('click', () => {
            updateURLAndRender(i, rowsPerPage, searchTerms);
        });

        paginationControls.appendChild(button);
    }

    // Highlight the current page button
    const currentPageButtons = document.querySelectorAll('.pagination-btn');
    currentPageButtons.forEach(button => {
        button.classList.remove('active');
        if (parseInt(button.dataset.page) === currentPage) {
            button.classList.add('active');
        }
    });

    const rowsSelect = document.getElementById('rows-select');
    rowsSelect.addEventListener('change', () => {
        updateURLAndRender(currentPage, rowsSelect.value, searchTerms);
    });
}

// Function to get URL parameters and return only filled ones
function getURLParams() {
    const params = new URLSearchParams(window.location.search);
    return{
        page: parseInt(params.get('page')) || 1,
        perPage: parseInt(params.get('perPage')) || 5,
        event_title: params.get('event_title') || '',
        start_date: params.get('start_date') || '',
        end_date: params.get('end_date') || '',
        location_id: params.get('location_id') || ''

    }

}

// Function to perform search and update URL
function performEventSearch() {
    const eventTitle = document.getElementById('event_title').value;
    const startDate = document.getElementById('start_date').value;
    const endDate = document.getElementById('end_date').value;
    const locationId = document.getElementById('location-select').value;

    const searchTerms = {
        event_title: eventTitle,
        start_date: startDate,
        end_date: endDate,
        location_id:locationId
    };

    const { page, perPage } = getURLParams(); // Retrieve current pagination settings
    updateURLAndRender(1, perPage, searchTerms); // Start from page 1 for search
}

function performParticipantSearch() {
    const name = document.getElementById('name').value;
    const phoneNumber = document.getElementById('phone_number').value;
 

    const searchTerms = {
        name: name,
        phone_number: phoneNumber,

    };

    const { page, perPage } = getURLParams(); // Retrieve current pagination settings
    updateURLAndRender(1, perPage, searchTerms); // Start from page 1 for search
}

function performLocationSearch() {
    const location_name = document.getElementById('location_name').value;
    const address = document.getElementById('address').value;
    const capacity = document.getElementById('capacity').value;

    const searchTerms = {
        location_name: location_name,
        address: address,
        capacity:capacity
    };

    const { page, perPage } = getURLParams(); // Retrieve current pagination settings
    updateURLAndRender(1, perPage, searchTerms); // Start from page 1 for search
}

// Initial load of the table based on URL parameters
document.addEventListener('DOMContentLoaded', () => {
    const { page, perPage } = getURLParams(); // Retrieve current pagination settings
    renderTable(page, perPage);
});

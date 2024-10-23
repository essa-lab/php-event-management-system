<?php view("partials/head.php",['title'=>$title,'subTitle'=>$subTitle]) ?>

<div class="frm-container">

<div class="form-container">
        <form id="eventForm">
            <div class="input-group">
                <label for="event_title">Event Title</label>
                    <input type="text" id="event_title" name="event_title" placeholder="Enter Event Title" required>
            </div>
            <div class="input-group">
                <label for="location">Location</label>
                <select name="location_id" id="location-select">
                    <option value="" disabled>--Select location--</option>
                </select>                
            </div>
            <div class="input-group">
                <label for="start_date">Start Date</label>
                    <input type="date" id="start_date" name="start_date" required>
            </div>
            <div class="input-group">
                <label for="end_date">End Date</label>
                    <input type="date" id="end_date" name="end_date" required>
            </div>
            <div class="form-button">
                <button onclick="location.href='/event'" class="btn btn-back" type="button">Back</button>
                <button id="submitButton" class="btn" type="submit">Save</button>
            </div>

        </form>
    </div>

    </div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    // notify('success','Hello')
    fillLocationSelect()

    var isEdit = <?= $id > 0 ? 'true' : 'false'?>;
    
    const eventForm = document.getElementById('eventForm');
    const submitBtn = document.getElementById('submitButton');
      
    // If editing, fetch user data and populate the form
    if (isEdit) {
      fetch(`/api/event/<?= $id ?>`)
        .then(response => response.json())
        .then(data => {
          const event = data.item;
          document.getElementById('event_title').value = event.title;
          document.getElementById('location-select').value = event.location_id;
          document.getElementById('start_date').value = event.start_date;
          document.getElementById('end_date').value = event.end_date;
        });
    }
  

  
    //Handle form submission
    eventForm.addEventListener('submit', function(event) {
      event.preventDefault();

  
      const formData = new FormData(eventForm);
      const newEvent = {
        event_title: formData.get('event_title'),
        location_id: formData.get('location_id'),
        start_date: formData.get('start_date'),
        end_date: formData.get('end_date')
      };
  
      let apiUrl = isEdit ? `/api/event/<?= $id ?>` : '/api/event';
      let method = isEdit ? 'PUT' : 'POST';
      console.log(apiUrl)
      fetch(apiUrl, {
        method: method,
        headers: {
          'Content-Type': 'application/json',
          'api_key':apiKey
        },
        body: JSON.stringify(newEvent),
      })
      .then(response => response.json())
      .then(data => {
        if (data.statusCode === 200) {
          notify('success',data.message) 
          setTimeout(() => {
            window.location.href='/event'
          }, 1000); 
        } else {
          notify('error',data.message)       
        }
      })
      .catch(error => {
        notify('error',error)       
      });
    });
    
  });
</script>

<?php view("partials/footer.php") ?>

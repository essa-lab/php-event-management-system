<?php view("partials/head.php",['title'=>$title,'subTitle'=>$subTitle]) ?>

<div class="frm-container">

<div class="form-container">
        <form id="eventParticipationForm">
            <div class="input-group">
                <label for="event_title">Participant</label>
                <select name="participant_id" id="participant-select">
                    <option value="" disabled>--Select participant--</option>
                </select>            
             </div>

            <div class="input-group">
                <label for="event">Event</label>
                <select name="event_id" id="event-select">
                    <option value="" disabled>--Select event--</option>
                </select>                
            </div>


            <div class="form-button">
                <button onclick="location.href='/event-participant'" class="btn btn-back" type="button">Back</button>
                <button id="submitButton" class="btn" type="submit">Save</button>
            </div>

        </form>
    </div>

    </div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    // notify('success','Hello')
    fillEventSelect()
    fillParticipantSelect()
    
    const eventParticipationForm = document.getElementById('eventParticipationForm');
    const submitBtn = document.getElementById('submitButton');
      
  
    //Handle form submission
    eventParticipationForm.addEventListener('submit', function(event) {
      event.preventDefault();

  
      const formData = new FormData(eventParticipationForm);
      const newEventParticipant = {
        event_id: formData.get('event_id'),
        participant_id: formData.get('participant_id'),

      };
  
      let apiUrl =  '/api/event-participant';
      let method =  'POST';
  
      fetch(apiUrl, {
        method: method,
        headers: {
          'Content-Type': 'application/json',
          'api_key':apiKey
        },
        body: JSON.stringify(newEventParticipant),
      })
      .then(response => response.json())
      .then(data => {
        if (data.statusCode === 200) {
          notify('success',data.message) 
          setTimeout(() => {
            window.location.href='/event-participant'
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

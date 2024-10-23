<?php view("partials/head.php",['title'=>$title,'subTitle'=>$subTitle]) ?>

<div class="frm-container">

<div class="form-container">
        <form id="participantForm">
            <div class="input-group">
                <label for="name">Name</label>
                    <input type="text" id="name" name="name" placeholder="Enter  Name" required>
            </div>
            <div class="input-group">
                <label for="address">Phone Number</label>
                <input type="text" id="phone_number" name="phone_number" placeholder="Enter Phone Number" required>
               
            </div>
           
            
            <div class="form-button">
                <button onclick="location.href='/participant'" class="btn btn-back" type="button">Back</button>
                <button id="submitButton" class="btn" type="submit">Save</button>
            </div>

        </form>
    </div>

    </div>

<script>
document.addEventListener('DOMContentLoaded', function() {

    var isEdit = <?= $id > 0 ? 'true' : 'false'?>;
    
    const participantForm = document.getElementById('participantForm');
    const submitBtn = document.getElementById('submitButton');
      
    // If editing, fetch user data and populate the form
    if (isEdit) {
      fetch(`/api/participant/<?= $id ?>`)
        .then(response => response.json())
        .then(data => {
          const participant = data.item;
          document.getElementById('name').value = participant.name;
          document.getElementById('phone_number').value = participant.phone_number;
        });
    }
  

  
    //Handle form submission
    participantForm.addEventListener('submit', function(participant) {
      participant.preventDefault();

  
      const formData = new FormData(participantForm);
      const newParticipant = {
        name: formData.get('name'),
        phone_number: formData.get('phone_number'),
      };
  
      let apiUrl = isEdit ? `/api/participant/<?= $id ?>` : '/api/participant';
      let method = isEdit ? 'PUT' : 'POST';
  
      fetch(apiUrl, {
        method: method,
        headers: {
          'Content-Type': 'application/json',
          'api_key':apiKey
        },
        body: JSON.stringify(newParticipant),
      })
      .then(response => response.json())
      .then(data => {
        if (data.statusCode === 200) {
          notify('success',data.message) 
          setTimeout(() => {
            window.location.href='/participant'
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

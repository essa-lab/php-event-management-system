<?php view("partials/head.php",['title'=>$title,'subTitle'=>$subTitle]) ?>

<div class="frm-container">

<div class="form-container">
        <form id="locationForm">
            <div class="input-group">
                <label for="location_name">Location Name</label>
                    <input type="text" id="location_name" name="location_name" placeholder="Enter Location Name" required>
            </div>
            <div class="input-group">
                <label for="address">Address</label>
                <input type="text" id="address" name="address" placeholder="Enter Address" required>
               
            </div>
            <div class="input-group">
                <label for="capacity">Capacity</label>
                    <input type="number" id="capacity" name="capacity"  placeholder="Enter Capacity"  required>
            </div>
            
            <div class="form-button">
                <button onclick="location.href='/location'" class="btn btn-back" type="button">Back</button>
                <button id="submitButton" class="btn" type="submit">Save</button>
            </div>

        </form>
    </div>

    </div>

<script>
document.addEventListener('DOMContentLoaded', function() {

    var isEdit = <?= $id > 0 ? 'true' : 'false'?>;
    
    const locationForm = document.getElementById('locationForm');
    const submitBtn = document.getElementById('submitButton');
      
    // If editing, fetch user data and populate the form
    if (isEdit) {
      fetch(`/api/location/<?= $id ?>`)
        .then(response => response.json())
        .then(data => {
          const location = data.item;
          document.getElementById('location_name').value = location.location_name;
          document.getElementById('address').value = location.address;
          document.getElementById('capacity').value = location.capacity;
        });
    }
  

  
    //Handle form submission
    locationForm.addEventListener('submit', function(location) {
      location.preventDefault();

  
      const formData = new FormData(locationForm);
      const newLocation = {
        location_name: formData.get('location_name'),
        address: formData.get('address'),
        capacity: formData.get('capacity'),
      };
  
      let apiUrl = isEdit ? `/api/location/<?= $id ?>` : '/api/location';
      let method = isEdit ? 'PUT' : 'POST';
  
      fetch(apiUrl, {
        method: method,
        headers: {
          'Content-Type': 'application/json',
          'api_key',apiKey
        },
        body: JSON.stringify(newLocation),
      })
      .then(response => response.json())
      .then(data => {
        if (data.statusCode === 200) {
          notify('success',data.message) 
          setTimeout(() => {
            window.location.href='/location'
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

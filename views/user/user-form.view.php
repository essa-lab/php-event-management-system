<?php view("partials/head.php",['title'=>$title,'subTitle'=>$subTitle]) ?>

<div class="frm-container">

<div class="form-container">
        <form id="userForm">
            <div class="input-group">
                <label for="name">name</label>
                    <input type="text" id="name" name="name" placeholder="Enter Name" required>
            </div>
            <div class="input-group">
                <label for="ip">IP</label>
                <input type="text" id="ip" name="ip" placeholder="Enter IP" required>

            </div>
            <div class="input-group">
                <label for="api_key">API KEY</label>
                    <input type="text" id="api_key" name="api_key" required>
            </div>

            <div class="form-button">
                <button onclick="location.href='/user'" class="btn btn-back" type="button">Back</button>
                <button id="submitButton" class="btn" type="submit">Save</button>
            </div>

        </form>
    </div>

    </div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    // notify('success','Hello')

    var isEdit = <?= $id > 0 ? 'true' : 'false'?>;
    
    const userForm = document.getElementById('userForm');
    const submitBtn = document.getElementById('submitButton');
      
    // If editing, fetch user data and populate the form
    console.log('<?= $id ?>')
    if (isEdit) {
      
      fetch(`/api/user/<?= $id ?>`,{
        method:"GET",
        headers:{'api_key':apiKey}

      }
    )
        .then(response => response.json())
        .then(data => {
            if(data.statusCode != 200){
                notify("error",data.message)
            }
          const user = data.item;
          document.getElementById('name').value = user.name;
          document.getElementById('ip').value = user.ip;
          document.getElementById('api_key').value = user.api_key;
        });
    }
  

  
    //Handle form submission
    userForm.addEventListener('submit', function(user) {
      user.preventDefault();

  
      const formData = new FormData(userForm);
      const newUser = {
        name: formData.get('name'),
        ip: formData.get('ip'),
        api_key: formData.get('api_key'),
        is_blocked: 0
      };
  
      let apiUrl = isEdit ? `/api/user/<?= $id ?>` : '/api/user';
      let method = isEdit ? 'PUT' : 'POST';
  
      fetch(apiUrl, {
        method: method,
        headers: {
          'Content-Type': 'application/json',
          'api_key':apiKey
        },
        body: JSON.stringify(newUser),
      })
      .then(response => response.json())
      .then(data => {
        if (data.statusCode === 200) {
          notify('success',data.message) 
          setTimeout(() => {
            window.location.href='/user'
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

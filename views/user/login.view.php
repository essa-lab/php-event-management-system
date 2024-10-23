<?php view("partials/head.php",['title'=>'Login','subTitle'=>'You need to log in for specific action in the sytem']) ?>

<div class="frm-container">

<div class="form-container">
        <form id="loginForm">
            <div class="input-group">
                <label for="username">User Name</label>
                    <input type="text" id="username" name="username" placeholder="Enter username" required>
            </div>


            <div class="form-button">
                <button onclick="location.href='/'" class="btn btn-back" type="button">Back</button>
                <button id="submitButton" class="btn" type="submit">Login</button>
            </div>

        </form>
    </div>

    </div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    // notify('success','Hello')
    
    const loginForm = document.getElementById('loginForm');
    const submitBtn = document.getElementById('submitButton');
      
 
    //Handle form submission
    loginForm.addEventListener('submit', function(user) {
        user.preventDefault();

  
      const formData = new FormData(loginForm);
      const newLogin = {
        username: formData.get('username'),
      };
  
      let apiUrl ='/api/login/';
      let method ='POST';
  
      fetch(apiUrl, {
        method: method,
        headers: {
          'Content-Type': 'application/json',
        },
        body: JSON.stringify(newLogin),
      })
      .then(response => response.json())
      .then(data => {
        if (data.statusCode === 200) {
          notify('success',data.message) 
          localStorage.setItem('apiKey',data.apiKey)
          setTimeout(() => {
            window.location.href='/'
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

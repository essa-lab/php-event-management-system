<?php view("partials/head.php",['title'=>$title,'subTitle'=>$subTitle]) ?>


<div class="container">

<div class="card" click="alert(2)">
  <div class="inside">
    <div class="circle">1</div>
  </div>
  <div class="text" onclick="location.href='/event'">
    <p class="header">Events</p>
    <p class="content">Create / Read / Update / Delete Events</p>
  </div>
</div>

<div class="card">
  <div class="inside">
    <div class="circle">2</div>
  </div>
  <div class="text" onclick="location.href='/location'">
    <p class="header">Location</p>
    <p class="content">Create / Read / Update / Delete Locations</p>
  </div>
</div>

<div class="card">
  <div class="inside">
    <div class="circle">3</div>
  </div>
  <div class="text" onclick="location.href='/event-participants'">
    <p class="header">Participants</p>
    <p class="content">Create / Read / Update / Delete Participants</p>
  </div>
</div>
  
<div class="card">
  <div class="inside">
    <div class="circle">4</div>
  </div> 
  <div class="text" onclick="location.href='/black-list'">
    <p class="header">Event Participants</p>
    <p class="content">Create / Read  Event Participants</p>
  </div>
</div>

<div class="card">
  <div class="inside">
    <div class="circle">5</div>
  </div> 
  <div class="text" onclick="location.href='/black-list'">
    <p class="header">Black List</p>
    <p class="content">View Black Listed Users</p>
  </div>
</div>
  
</div>

<?php view("partials/footer.php") ?>

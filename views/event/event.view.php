<?php  view("partials/head.php",['title'=>$title,'subTitle'=>$subTitle]) ?>

<div class="table-container">
        <div class="table-header">
            <div class="search-wrapper">
                <input id="event_title" type="text" name="name" placeholder="Search Name">
                <label class="label">Start Date </label>
                <input id="start_date" type="date" name="start_date">
                <label class="label">End Date </label>
                <input id="end_date" type="date" name="end_date">
                <select id="location-select">
                    <option value="">--Select location--</option>
                </select>
                <button class="action-btn" type="button" onclick="performEventSearch()">Search</button>

            </div>
            <div class="view-options">
                <button onclick="location.href='/event/0'" type="button" class="action-btn new-btn">New Event</button>
            </div>
        </div>
        <table id="main-table">
            <thead id="table-head">
                <tr>
                    <th data-column="id" >ID </th>
                    <th data-column="Name" >Name </th>
                    <th data-column="location_id" >Location </th>
                    <th data-column="start_date" >Start Date </th>
                    <th data-column="end_date" >End Date </th>
                    <th data-column="end_date" >Actions </th>

                </tr>
            </thead>
            <tbody id="table-body">
                
            </tbody>
            
        </table>
        <div class="view-options">
                <label for="rows-select">Show rows:</label>
                <select id="rows-select">
                    <option value="5">5</option>
                    <option value="10">10</option>
                    <option value="20">20</option>
                </select>
            </div>

    </div>
    <div class="center">
        <div class="pagination" id="pagination-controls">

        </div>
    </div>
<script  src="/resources/script.js"></script>
<?php  view('partials/footer.php')  ?>

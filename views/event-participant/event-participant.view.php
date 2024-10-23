<?php view("partials/head.php",['title'=>$title,'subTitle'=>$subTitle]) ?>

<div class="table-container">
        <div class="table-header">
            <!-- <div class="search-wrapper">
            <select id="location-select">
                    <option value="">--Select location--</option>
                </select>                
                <input id="event_title" type="text" name="event_title" placeholder="Search Event Title">
                <button class="action-btn" type="button" onclick="performEventParticipantSearch()">Search</button>

            </div> -->
            <div class="view-options">
                <button onclick="location.href='/event-participant/0'" type="button" class="action-btn new-btn">New Event Registeration</button>
            </div>
        </div>
        <table id="main-table">
            <thead id="table-head">
                <tr>
                    <th data-column="Name" >Event Title</th>
                    <th data-column="address" >Location Name </th>
                    <th data-column="capacity" >Location Address </th>
                    <th data-column="end_date" >Participant Number</th>
                    <th data-column="end_date" >occupancy Rate</th>

                    <th data-column="end_date" >Show Participant</th>


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
<?php view("partials/footer.php") ?>

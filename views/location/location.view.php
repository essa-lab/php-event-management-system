<?php view("partials/head.php",['title'=>$title,'subTitle'=>$subTitle]) ?>

<div class="table-container">
        <div class="table-header">
            <div class="search-wrapper">
                <input id="location_name" type="text" name="name" placeholder="Search Location Name">
                <input id="address" type="text" name="address" placeholder="Search address">
                <input id="capacity" type="number" name="capacity" placeholder="Search  minimum capacity">
                <button class="action-btn" type="button" onclick="performLocationSearch()">Search</button>

            </div>
            <div class="view-options">
                <button onclick="location.href='/location/0'" type="button" class="action-btn new-btn">New Event</button>
            </div>
        </div>
        <table id="main-table">
            <thead id="table-head">
                <tr>
                    <th data-column="id" >ID </th>
                    <th data-column="Name" >Location Name </th>
                    <th data-column="address" >Address </th>
                    <th data-column="capacity" >Capacity </th>
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
<?php view("partials/footer.php") ?>

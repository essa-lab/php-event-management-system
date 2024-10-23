<?php view("partials/head.php",['title'=>$title,'subTitle'=>$subTitle]) ?>

<div class="table-container">
        <div class="table-header">
            <div class="search-wrapper">
                <input id="name" type="text" name="name" placeholder="Search Name">
                <input id="phone_number" type="text" name="address" placeholder="Search phone number">
                <button class="action-btn" type="button" onclick="performParticipantSearch()">Search</button>

            </div>
            <div class="view-options">
                <button onclick="location.href='/participant/0'" type="button" class="action-btn new-btn">New Participant</button>
            </div>
        </div>
        <table id="main-table">
            <thead id="table-head">
                <tr>
                    <th data-column="id" >ID </th>
                    <th data-column="Name" >Name </th>
                    <th data-column="address" >Phone Number </th>
                    <th data-column="address" >Action </th>

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

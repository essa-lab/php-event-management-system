<?php  view("partials/head.php",['title'=>$title,'subTitle'=>$subTitle]) ?>

<div class="table-container">
        <div class="table-header">
            <div class="search-wrapper">
                <input id="name" type="text" name="name" placeholder="Search Name">
                <label class="label">Blocked</label>
                <input id="is_blocked" type="checkbox" name="is_blocked">
                <button class="action-btn" type="button" onclick="performUserSearch()">Search</button>

            </div>
            <div class="view-options">
                <button onclick="location.href='/user/0'" type="button" class="action-btn new-btn">New Event</button>
            </div>
        </div>
        <table id="main-table">
            <thead id="table-head">
                <tr>
                    <th data-column="id" >ID </th>
                    <th data-column="Name" >Name </th>
                    <th data-column="ip" >IP </th>

                    <th data-column="blocked_at" >Blocked At</th>
                    <th data-column="blocked_at" >Block Action</th>

                    <th data-column="action" >Action </th>

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

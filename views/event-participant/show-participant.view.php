<?php view("partials/head.php",['title'=>$title,'subTitle'=>$subTitle]) ?>

<div class="table-container">
        <div class="table-header">
            <div class="view-options">
                <button onclick="location.href='/event-participant'" type="button" class="action-btn delete-btn">Back</button>
            </div>
        </div>
        <table id="main-table">
            <thead id="table-head">
                <tr>
                    <th data-column="address" > Name </th>
                    <th data-column="capacity" >Phone Number</th>

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

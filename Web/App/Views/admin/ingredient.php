<?php require ($_SERVER['DOCUMENT_ROOT'] . "/Public/inc/header.php") ?>


<div class="container-fluid py-5" style="width: 100%;">
    <div class="text-center">
        <h1>Manager Ingredient</h1>
    </div>

    <div class="row g-0 justify-content-center">


        <div class="row">
            <div class="col"></div> <!-- Empty column to push content to the right -->
            <div class="col-auto">
                <a href="/ingredient/add" class="btn btn-success" tabindex="-1" role="button">Add new ingredient</a>
            </div>
        </div>

        </form>
    </div>
</div>

<!-- TABLE -->
<div class="row g-0 py-1">
    <div class="table-responsive">
        <table class="table table-bordered">
            <tr>
                <th scope="col" class="col-1">ID</th>
                <th scope="col" class="col-3">Name</th>
                <th scope="col" class="col-3">Category</th>
                <th scope="col" class="col-2">Measurement unit</th>
                <th scope="col" class="col-3">Actions</th>
            </tr>
            <tbody class="ingredientTableBody">
                <!-- Dữ liệu được load trong file ajax-ingredients -->
            </tbody>
        </table>
        <div class="row">
            <div id="pagination" class="row justify-content-center mt-3"></div>
        </div>
    </div>
</div>
</div>

<div class="d-md-flex justify-content-center py-3 mb-5">
    <a href="/manager" class="btn btn-secondary me-md-2" tabindex="-1" role="button" style="width: 10%;">Back</a>
</div>
</div>

</div>
<script src="/Public/js/libs/jquery/jquery-3.6.0.min.js"></script>
<script src="/Public/js/ajax-ingredients-manager.js"></script>
<script src="/Public/js/show-pagination.js"></script>


<? require ($_SERVER['DOCUMENT_ROOT'] . "/Public/inc/footer.php") ?>
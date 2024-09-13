<?php require_once ($_SERVER['DOCUMENT_ROOT'] . '/Public/inc/header.php'); ?>
<!DOCTYPE html>
<html lang="en">

<style>
    .header-space {
        height: 40px;
    }
</style>

<body>
    <div class="header-space"></div>
    <div class="container">
        <div class="row" style="width: 100%;">
            <h3 class="d-flex justify-content-center">Easy recipes for your meal</h3>
            <div class="d-flex flex-wrap justify-content-start" id="recipeContainer">
            </div>
        </div>
    </div>
    <div class="form d-flex justify-content-center py-3 mb-5">
        <button id="show" class="btn btn-primary" style="width: 100px">Load more</button>
    </div>
    <script src="/Public/js/libs/jquery/jquery-3.6.0.min.js"></script>
    <script src="/Public/js/ajax-recipes.js"></script>
    <script>
        $(document).ready(function () {
            $('#recipeContainer').on('click', '.card', function () {
                // Lấy dữ liệu từ thuộc tính data-details của thẻ card được bấm vào
                var idDetails = $(this).find('.card-details').data('details');

                window.location.href = "/recipe/detail?id=" + idDetails;
            });
        });
    </script>

</html>


<?php require_once ($_SERVER['DOCUMENT_ROOT'] . '/Public/inc/footer.php'); ?>
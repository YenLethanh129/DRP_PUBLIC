<?php require_once ($_SERVER['DOCUMENT_ROOT'] . '/Public/inc/header.php'); ?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Recipes</title>
    <style>
        .header-space {
            height: 40px;
        }
    </style>

<body>
    <div class="header-space"></div>
    <div class="container">
        <h3 class="row justify-content-center">Result for
            <?= $data['value'] ?>
        </h3>
        <div class="row justify-content-start row-cols-4 mb-5" id="recipeContainer">
            <? foreach ($data['recipe'] as $recipe): ?>
                <div class="card col" style="width: 22.5%; margin: 1rem 1.25%; cursor: pointer; padding: 0">
                    <img src="<?= $recipe->getImgUrl() ? "/Public/uploads/recipes/" . $recipe->getImgUrl() : "/Public/images/image_not_found.png"; ?>"
                        alt="<?php echo $recipe->getName(); ?>" class="card-img-top"
                        style="object-fit: cover; height:12rem; width: 100%">
                    <div class="card-content" style="height:10rem">
                        <div class="card-body" style="height:9rem; overflow: hidden">
                            <h5 class="card-title limited-title">
                                <?= $recipe->getName() ?>
                            </h5>
                            <p class="card-text limited-text">
                                <?= $recipe->getDescription() ?>
                            </p>
                            <div class="card-details" style="display: none;"></div>
                            <div class="card-footer d-flex align-items-center"
                                style="border: none; background-color: white; padding: 0;">
                                <i class="fa-solid fa-clock-rotate-left"></i>
                                <p style="margin: 0;padding-left: 8px;">
                                    <?= $recipe->getPreparationTime() ?> mins
                                </p>
                            </div>
                            <div class="rating"></div>
                        </div>
                    </div>
                </div>
            <? endforeach; ?>
        </div>
    </div>
    <script src="/Public/js/libs/jquery/jquery-3.6.0.min.js"></script>
    <script src="/Public/js/ajax-recipes.js"></script>
    <script>
        $(document).ready(function () {
            $('#recipeContainer').on('click', '.card', function () {
                // Lấy dữ liệu từ thuộc tính data-details của thẻ card được bấm vào
                var recipeId = <?= json_encode($recipe->getId()) ?>;

                window.location.href = "/recipe/detail?id=" + recipeId;
            });
        });
    </script>

</html>


<?php require_once ($_SERVER['DOCUMENT_ROOT'] . '/Public/inc/footer.php'); ?>
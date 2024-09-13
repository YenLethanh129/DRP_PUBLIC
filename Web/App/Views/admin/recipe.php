<? require ($_SERVER['DOCUMENT_ROOT'] . "/Public/inc/header.php") ?>

<link rel="stylesheet" href="/Public/css/dataTables.min.css">


<div class="container-fluid py-5" style="width: 100%;">
    <div class="text-center">
        <h1>Manager recipe</h1>
    </div>

    <div class="row">
        <div class="col"></div> 
        <div class="col-auto">
            <a href="/recipe/add" class="btn btn-success" tabindex="-1" role="button">Add new recipe</a>
        </div>
    </div>




    <table class="table table-bordered" id="recipe-table">
        <thead>
            <tr>
                <th>ID</th>
                <th>Name</th>
                <th>Description</th>
                <th>Image</th>
                <th>Preparation Time Min</th>
                <th>Cooking Time Min</th>
                <th>Directions</th>
                <th>Meal Type 1</th>
                <th>Meal Type 2</th>
                <th>Meal Type 3</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            <?php
            if (!is_array($recipes)) {
                $recipes = [$recipes];
            }
            foreach ($recipes as $recipe): ?>
                <tr>
                    <td>
                        <?= $recipe->getId() ?>
                    </td>
                    <td>
                        <?= $recipe->getName() ?>
                    </td>
                    <td>
                        <?= $recipe->getDescription() ?>
                    </td>
                    <td>
                        <img src="<?= $recipe->getImgUrl() ? "/Public/uploads/recipes/" . $recipe->getImgUrl() : "/Public/images/image_not_found.png"; ?>"
                            alt="<?php echo $recipe->getName(); ?>" style="width: 200px; height: 200px; ">
                    </td>
                    <td>
                        <?= $recipe->getPreparationTime() ?>
                    </td>
                    <td>
                        <?= $recipe->getCookingTime() ?>
                    </td>
                    <td>
                        <?= $recipe->getDirection() ?>
                    </td>
                    <td>
                        <?= $recipe->getCourse() ?>
                    </td>
                    <td>
                        <?= $recipe->getMeal() ?>
                    </td>
                    <td>
                        <?= $recipe->getMethod() ?>
                    </td>
                    <td>
                        <div class="row g-1">
                            <? if ($recipe->getActive()): ?>
                                <form class="set-active-form col-auto">
                                    <input type="hidden" name="id" value="<?= $recipe->getId() ?>">
                                    <input type="hidden" name="isActive" value="0">
                                    <button class="btn btn-danger" type="submit">Not Active</button>
                                </form>
                            <? else: ?>
                                <form class="set-active-form col-auto">
                                    <input type="hidden" name="id" value="<?= $recipe->getId() ?>">
                                    <input type="hidden" name="isActive" value="1">
                                    <button class="btn btn-success" type="submit">Active</button>
                                </form>
                            <? endif; ?>
                            <a href="/manager/recipe/update?id=<?= $recipe->getId() ?>" class="btn btn-secondary col-auto"
                                role="button" style="200px">Edit</a>
                        </div>
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
    <div class="d-md-flex justify-content-center py-3 mb-5">
        <a href="/manager" class="btn btn-secondary me-md-2" tabindex="-1" role="button" style="width: 10%;">Back</a>
    </div>
</div>

<? require ($_SERVER['DOCUMENT_ROOT'] . "/Public/inc/footer.php") ?>

<!-- Import Lib for DataTable -->
<script src="/Public/js/libs/jquery/jquery-1.11.1.js"></script>
<script src="/Public/js/libs/jquery/dataTables.min.js"></script>
<script src="/Public/js/recipes-manager.js"></script>
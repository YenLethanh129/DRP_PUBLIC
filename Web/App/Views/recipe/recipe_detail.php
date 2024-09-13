<?php require_once($_SERVER['DOCUMENT_ROOT'] . '/Public/inc/header.php'); ?>

<div class="recipe_detail mb-3">
    <div class="container mt-3" style="width:50%">
        <div class="row p-3 mb-3" style="background-color: white; border-radius: 4px;">
            <div class="d-flex flex-wrap flex-column justify-content-center" style="width: 100%;">
                <h2 class=""><?php echo $data->getName() ?></h2>
                <p class=""><?php echo $data->getDescription() ?></p>
                <div class="author-info d-flex align-items-center">
                    <img src="https://i.pinimg.com/564x/8f/1a/b1/8f1ab1e2ef48c2a26de7df6e977930bd.jpg" alt="">
                    <div class="des">
                        <h5>By Mary Maris</h5>
                        <span>Updated March 13, 2024</span>
                    </div>
                </div>

                <img src="/Public/uploads/recipes/<?echo $data->getImgUrl() ?? "image_not_found.png" ?>" alt="<?php echo $data->getName() ?>" style="width: 100%; aspect-ratio: 4/3; object-fit: cover">
                <div class="table-info mb-3">
                    <div class="title-table">RECIPE</div>
                    <div class="recipe-name"> <?php echo $data->getName() ?> </div>
                    <div class="d-flex">
                        <div class="time d-flex flex-column justify-content-between m-3" style="width: 25%">
                            <div class="pre-time">
                                <div class="time-title">Prep time</div>
                                <div class="time-detail"> <?php echo $data->getPreparationTime() ?> mins</div>
                            </div>
                            <div class="cook-time">
                                <div class="time-title">Cook time</div>
                                <div class="time-detail"> <?php echo $data->getCookingTime() ?> mins</div>
                            </div>
                            <div class="total-time">
                                <div class="time-title">Total time</div>
                                <div class="time-detail"> <?php echo $data->getPreparationTime() + $data->getCookingTime() ?> mins</div>
                            </div>
                        </div>
                        <div class="ingredients" style="height: auto;">
                            <h5 class="time-title ms-3 mt-3">Ingredients</h5>
                            <div class=" m-3">
                                <? $index = 1;?>
                                <? foreach ($data->getIngredientComponets() as $ingredient) : ?>
                                    <p><?php echo $index++ . ". " . $ingredient['ingredientName'] . " - " .  $ingredient['quantity'] . " " . $ingredient['unit']; ?></p>
                                <? endforeach; ?>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="intruction mb-3">
                    <h3>How to make it</h3>
                    <p>
                        <?php echo $data->getDirection() ?>
                    </p>
                </div>
            </div>
        </div>
    </div>
</div>

<?php require_once($_SERVER['DOCUMENT_ROOT'] . '/Public/inc/footer.php'); ?>
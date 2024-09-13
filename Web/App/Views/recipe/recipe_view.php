<div class="content">
    
    <?php foreach($data as $recipe): ?>
        <div class="flip-card">
            <div class="flip-card-inner">
                <div class="flip-card-front">
                    <img src="/Public/uploads/recipes/<?echo $mainRecipe->getImgUrl() ?? "image_not_found.png" ; ?>" alt="<?php echo $recipe->getName(); ?>">
                </div>
                <div class="flip-card-back">
                    <h2><?php echo $recipe->getName(); ?></h2>
                    <p><?php echo $recipe->getDescription(); ?></p>
                    <p><?php echo $recipe->getCookingTime(); ?></p>
                </div>
            </div>
        </div>
    <?php endforeach; ?>
</div>
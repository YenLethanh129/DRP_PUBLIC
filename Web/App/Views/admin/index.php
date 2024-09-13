<?php require_once($_SERVER['DOCUMENT_ROOT'] . '/Public/inc/header.php'); ?>

<div class="container minspace py-3 mt-4">
  <div class="row">
    <div class="col-md-4">
      <div class="advert">
        <div class="link">    
            <a href="/manager/user">
              <img src="/Public/images/account.png" class="img-thumbnail mb-2" style="height:415px; aspect-ratio: 1/1; object-fit: cover;" alt="Ảnh user">
            </a>
            <h3 class="text-center">Manager User!</h3>
          </div>
      </div>
    </div>
    <div class="col-md-4">
      <div class="advert">
        <div class="link">
          <a href="/manager/recipe">
            <img src="/Public/images/recipe.png" class="img-thumbnail mb-2" style="height:415px; aspect-ratio: 1/1; object-fit: cover;" alt="ảnh recipe">
          </a>
          <h3 class="text-center">Manager Recipe!</h3>
        </div>
      </div>
    </div>
    <div class="col-md-4">
      <div class="advert">
        <div class="link">
            <a href="/manager/ingredient">
              <img src="/Public/images/ingredient.jpg" class="img-thumbnail mb-2" style="height:415px; aspect-ratio: 1/1; object-fit: cover;" alt="ảnh ingredient">
            </a>
            <h3 class="text-center">Manager Ingredient!</h3>
        </div>
      </div>
    </div>
  </div>
</div>

<?php require_once($_SERVER['DOCUMENT_ROOT'] . '/Public/inc/footer.php'); ?>

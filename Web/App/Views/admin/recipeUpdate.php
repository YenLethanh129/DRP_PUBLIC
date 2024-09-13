<?php require $_SERVER['DOCUMENT_ROOT'] . "/Public/inc/header.php"; ?>

    <div class="container py-5">
        <div class="text-center">
            <h1>Manager Update Recipe</h1>
        </div>

        <div class="row g-5 py-4">
            <form id= "recipe-form" style="width: 50vw; margin: 0 auto; padding: 20px; border: 1px solid #e1ebfa; border-radius: 10px; box-shadow: 0 0 10px 0 #e1ebfa; margin-top: 50px; margin-bottom: 50px;">
                <input type="hidden" class="form-control" id="id" name="id" value="<?= $data['recipes']->getId() ?>">
                <div class="mb-3">
                    <label for="name" class="col-sm-5 col-form-label">Name</label>
                    <div class="col-sm-15">
                        <input type="text" class="form-control" id="name" name="name" value="<?= $data['recipes']->getName() ?>">
                    </div>
                </div>
                <div class="mb-3">
                    <label for="description" class="col-sm-5 col-form-label">Description</label>
                    <div class="col-sm-15">
                        <textarea class="form-control" id="description" name="description"> <?= $data['recipes']->getDescription() ?></textarea>
                    </div>
                </div>
                <div class="mb-3">
                    <label for="preparation_time" class="col-sm-5 col-form-label">Preparation Time Min</label>
                    <div class="col-sm-15">
                        <input type="number" class="form-control" id="preparation_time" name="preparation_time" value="<?= $data['recipes']->getPreparationTime() ?>">
                    </div>
                </div>
                <div class="mb-3">
                    <label for="cooking_time" class="col-sm-5 col-form-label">Cooking Time Min</label>
                    <div class="col-sm-15">
                        <input type="number" class="form-control" id="cooking_time" name="cooking_time" value="<?= $data['recipes']->getCookingTime() ?>">
                    </div>
                </div>
                <div class="mb-3">
                    <label for="directions" class="col-sm-5 col-form-label">Directions</label>
                    <div class="col-sm-15">
                        <textarea class="form-control" id="directions" name="directions"><?= $data['recipes']->getDirection() ?></textarea>
                    </div>
                </div>
                <div class="mb-3">
                    <label for="course" class="col-sm-5 col-form-label">Meal Type 1 (Last: <?= $data['recipes']->getCourse() ?>)</label>
                    <div class="col-sm-15">
                        <select class="form-select" id="course" name="course">
                            <?php foreach ($data['courses'] as $course) :?>
                            <option value="<?=$course['id']?>" <?= $course['id'] == $data['recipes']->getCourse() ? 'selected' : '' ?>><?=$course['type_name']?></option>
                            <?php endforeach;?>
                        </select>
                    </div>
                </div>
                <div class="mb-3">
                    <label for="meal" class="col-sm-5 col-form-label">Meal Type 2 (Last: <?= $data['recipes']->getMeal() ?>)</label>
                    <div class="col-sm-15">
                        <select class="form-select" id="meal" name="meal" aria-label="Select meal type">
                            <?php foreach($data['meals'] as $meal) :?>
                            <option value="<?=$meal['id']?>" <?= $meal['id'] == $data['recipes']->getMeal() ? 'selected' : '' ?>><?=$meal['type_name']?></option>
                            <?php endforeach;?>
                        </select>
                    </div>
                </div>
                <div class="mb-3">
                    <label for="method" class="col-sm-5 col-form-label">Meal Type 3 (Last: <?= $data['recipes']->getMethod() ?>)</label>
                    <div class="col-sm-15">
                        <select class="form-select" id="method" name="method" aria-label="Select meal type">
                            <?php foreach($data['methods'] as $method):  ?>
                            <option value="<?=$method['id']?>" <?= $method['id'] == $data['recipes']->getMethod() ? 'selected' : '' ?>><?=$method['method_name']?></option>
                            <?php endforeach;?>
                        </select>
                    </div>
                </div>
                <div class="input-group mb-3">
                    <label class="input-group-text" for="image">Upload your image</label>
                    <input type="file" class="form-control" id="file" name="file">
                </div>
                <div class="d-grid gap-2">
                    <button class="btn btn-success" name="update" type="submit">Update</button>
                </div>
            </form>
        </div>

        <div class="d-md-flex justify-content-center py-3">
            <a href="/manager/recipe" class="btn btn-secondary me-md-2" tabindex="-1" role="button">Back</a>
        </div>      
    </div>

<?php require $_SERVER['DOCUMENT_ROOT'] . "/Public/inc/footer.php"; ?>
<!-- Import bootstrap -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
<!-- Import Jquery Ajax -->
<script src="/Public/js/libs/jquery/jquery-3.6.0.min.js">
</script>
<script>
  $(document).ready(function() {
    $('#recipe-form').submit(function(event) {
      event.preventDefault();

      var formData = $(this).serialize();

      $.ajax({
        type: 'POST',
        url: '/manager/recipe/update',
        data: formData,
        dataType: 'json', 
        success: function(response) {
     
          alert(response.message);
          
        },
        error: function(xhr, status, error) {
          console.error(error);
        }
      });
    });
  });
</script>
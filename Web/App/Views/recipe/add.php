<? require_once ($_SERVER['DOCUMENT_ROOT'] . "/Public/inc/header.php"); ?>
<!DOCTYPE html>
<html lang="en">

<style>
  .add-recipe-frm {
    display: flex;
    flex-direction: column;
    justify-content: center;
    align-items: center;
    margin: 10 auto;
    height: auto;
  }

  .form-select {
    width: 100%;
    padding: 10px;
    margin: 10px 0;
  }

  .error-message {
    color: #ff4d4d;
    font-size: 14px;
  }

  /* input[type="number"] {
    -moz-appearance: textfield;
    -webkit-appearance: textfield;
  } */
</style>

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Add Recipes</title>
</head>

<body>
  <h2 style="text-align: center; margin-top: 50px;">Add Your Creative Recipe</h2>

  <form id="recipe-form"
    style="width: 50vw; margin: 0 auto; padding: 20px; border: 1px solid #e1ebfa; border-radius: 10px; box-shadow: 0 0 10px 0 #e1ebfa; margin-top: 50px; margin-bottom: 50px;">
    <div class="form-floating mb-3">
      <input type="text" class="form-control" id="name" name="name" placeholder="Enter name of recipe">
      <label for="name">Recipe name</label>
    </div>

    <div class="input-group mb-2">

      <div class="form-floating">
        <input type="number" class="form-control" id="preparation_time" name="preparation_time"
          placeholder="How long to make?">
        <label for="preparation_time">Preparation time</label>
      </div>

      <span class="input-group-text">minutes</span>
      <div class="form-floating">
        <input type="number" class="form-control" id="cooking_time" name="cooking_time" placeholder="How long to make?">
        <label for="cooking_time">Cooking time</label>
      </div>
      <span class="input-group-text">minutes</span>
    </div>

    <div class="input-group mb-2">
      <select class="form-select" id="course" name="course" aria-label="Select meal type">
        <option value="" selected disabled hidden>Select meal recipe for</option>
        <? foreach ($data[0]->validCourse as $course): ?>
          <option value="<?= $course['id'] ?>">
            <?= $course['type_name']; ?>
          </option>
        <? endforeach; ?>
      </select>

      <select class="form-select" id="meal" name="meal" aria-label="Select meal type">
        <option value="" selected disabled hidden>Select meal type</option>
        <? foreach ($data[0]->validMeal as $meal): ?>
          <option value="<?= $meal['id'] ?>">
            <?= $meal['type_name']; ?>
          </option>
        <? endforeach; ?>
      </select>

      <select class="form-select" id="method" name="method" aria-label="Select meal type">
        <option value="" selected disabled hidden>Select meal category</option>
        <? foreach ($data[0]->validMethod as $method): ?>
          <option value="<?= $method['id'] ?>">
            <?= $method['method_name']; ?>
          </option>
        <? endforeach; ?>
      </select>
    </div>

    <div class="input-group input-group-sm mb-3">
      <span class="input-group-text">Direction</span>
      <textarea class="form-control" id="directions" name="directions" aria-label="With textarea"></textarea>
    </div>

    <div class="input-group input-group-sm mb-3">
      <span class="input-group-text">Description</span>
      <textarea class="form-control" id="description" name="description" aria-label="With textarea"></textarea>
    </div>

    <div id="ingredientComponents"></div>

    <div class="input-group mb-3">
      <label class="input-group-text" for="image">Upload your image</label>
      <input type="file" class="form-control" id="file" name="file">
    </div>

    <button type="button" class="btn btn-outline-secondary" id="addIngredientBtn"
      style="padding: 10px; margin-top: 10px; margin-bottom:15px">Add Ingredient</button>


    <div>
      <button type="submit" class="btn btn-outline-primary btn-lg"
        style="padding: 10px; margin-top: 20px">Submit</button>
    </div>
  </form>

  <div class="d-md-flex justify-content-center py-3 mb-5">
    <a href="/manager" class="btn btn-secondary me-md-2" tabindex="-1" role="button" style="width: 10%;">Back</a>
  </div>

  <? require_once ($_SERVER['DOCUMENT_ROOT'] . "/Public/inc/footer.php"); ?>

  <!-- Include jQuery library -->
  <script src="/Public/js/libs/jquery/jquery-3.5.1.min.js"></script>
  <!-- Include jQuery Validate plugin -->
  <script src="/Public/js/libs/jquery/jquery-1.19.2.min.js"></script>
  <script src="/Public/js/validate-recipes.js"></script>

  <script>
    // Function to add select element with options and input for quantity
    function addIngredientSelect() {

      // Create container div with input-group class
      var container = document.createElement('div');
      container.classList.add('form', 'mb-3');

      var legend = document.createElement('legend');
      legend.textContent = 'Ingredient';

      var ingreCat = document.createElement('div');
      ingreCat.classList.add('input-group', 'mb-1');

      // Create select element for ingredient
      var select = document.createElement('select');
      select.classList.add('form-select', 'form-select');
      select.name = 'ingredient_id[]';

      // Add placeholder option
      var placeholderOption = document.createElement('option');
      placeholderOption.value = '';
      placeholderOption.selected = true;
      placeholderOption.disabled = true;
      placeholderOption.hidden = true;
      placeholderOption.textContent = 'Select ingredient';
      select.appendChild(placeholderOption);

      // Add options from data
      var ingredients = <?php echo json_encode($data[0]->validIngredients); ?>;
      ingredients.forEach(function (ingredient) {
        var option = document.createElement('option');
        option.value = ingredient.id;
        option.textContent = ingredient.name;
        select.appendChild(option);
      });

      // Create input element for quantity
      var quantityInput = document.createElement('input');
      quantityInput.classList.add('form-control');
      quantityInput.type = 'number';
      quantityInput.placeholder = 'Quantity';
      quantityInput.name = 'quantity[]';


      // Create select element for unit
      var unitSelect = document.createElement('select');
      unitSelect.classList.add('form-select', 'form-select');
      unitSelect.name = 'unit[]';

      var unitPlaceholderOption = document.createElement('option');
      unitPlaceholderOption.value = '';
      unitPlaceholderOption.selected = true;
      unitPlaceholderOption.disabled = true;
      unitPlaceholderOption.hidden = true;
      unitPlaceholderOption.textContent = 'Select unit';
      unitSelect.appendChild(unitPlaceholderOption);

      // Add options for units
      var units = <?php echo json_encode($data[0]->validMeasurementUnit); ?>;
      units.forEach(function (unit) {
        var option = document.createElement('option');
        option.value = unit.id;
        option.textContent = unit.detail;
        unitSelect.appendChild(option);
      });

      // Create remove button
      var removeButton = document.createElement('button');
      removeButton.classList.add('btn', 'btn-outline-secondary');
      removeButton.style.marginTop = '15px';
      removeButton.textContent = 'Remove';
      removeButton.addEventListener('click', function () {
        container.remove();
      });

      // Append select, span, quantity input, and remove button to container
      container.appendChild(legend);
      ingreCat.appendChild(select);
      ingreCat.appendChild(unitSelect); // Adding unit select here
      container.appendChild(ingreCat);
      container.appendChild(quantityInput);
      container.appendChild(removeButton);

      // Add container to ingredient container
      document.getElementById('ingredientComponents').appendChild(container);
    }


    // Event listener for button click
    document.getElementById('addIngredientBtn').addEventListener('click', function () {
      addIngredientSelect();
    });
  </script>

  <script>
    $(document).ready(function () {
      $('#recipe-form').submit(function (event) {
        // Ngăn chặn hành vi mặc định của form
        event.preventDefault();

        // Lấy dữ liệu form
        var formData = $(this).serialize();

        // Gửi dữ liệu form đi bằng AJAX
        $.ajax({
          type: 'POST',
          url: '/recipe/add',
          data: formData,
          dataType: 'json',
          success: function (response) {
            if (response.success) {
              alert(response.message);

            } else {
              alert(response.message);
            }
          },
          error: function (xhr, status, error) {
            // Xử lý lỗi AJAX nếu có
            console.error(error);
          }
        });
      });
    });
  </script>
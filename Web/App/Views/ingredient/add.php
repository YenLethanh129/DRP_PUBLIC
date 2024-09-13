<? require_once($_SERVER['DOCUMENT_ROOT'] . "/Public/inc/header.php"); ?>
<style>
  .error-message {
    color: #ff4d4d;
    font-size: 14px;
  }
</style>

<div style="display: flex; justify-content: center;">
  <h2 class="m-5">Ingredient Form</h2>
</div>

<form id="ingredient-form" method="post" style="width: 80vw; margin: 0 auto; padding: 20px; border: 1px solid #e1ebfa; border-radius: 10px; box-shadow: 0 0 10px 0 #e1ebfa; margin-top: 50px; margin-bottom: 50px;">
  <div style="display: flex; justify-content: center;">
    <h4 class="m-2">General information</h2>
  </div>

  <div class="row mb-3 justify-content-center ">
    <div class="col-sm-3">
      <label class="visually-hidden" for="name">Name:</label><br>
      <input class="form-control px-2" type="text" id="name" name="name" placeholder="Enter name of ingredient"><br>
    </div>

    <div class="col-sm-3">
      <label class="visually-hidden" for="category">Category:</label><br>
      <select class="form-select px-2" id="category" name="category">
        <option value="" disabled selected hidden>Select category for ingredient</option>
        <? foreach ($data[0]->validCategories as $opts) : ?>
          <option value="<?= $opts['id'] ?>"><?= $opts['detail'] ?></option>
        <? endforeach; ?>
      </select>
    </div>

    <div class="col-sm-3">
      <label class="visually-hidden" for="measurement_unit"></label><br>
      <select class="form-select px-2" id="measurement_unit" name="measurement_unit">
        <option value="" disabled selected hidden>Select unit for ingredient</option>
        <? foreach ($data[0]->validMeasurements as $opts) : ?>
          <option value="<?= $opts['id'] ?>"><?= $opts['detail'] ?></option>
        <? endforeach; ?>
      </select>
    </div>

    <div class="col-sm-3">
      <label class="visually-hidden" for="measurement_unit"></label><br>
      <input class="form-control px-2" type="text" placeholder="Have a good day sir!" aria-label="Disabled input example" disabled>
    </div>
  </div>

  <div style="display: flex; justify-content: center;">
    <h4 class="m-2">Nutrition components</h4>
  </div>

  <div class="row mb-3 justify-content-center">
      <?php $count = 0; ?>
      <?php foreach ($data[0]->validNutrition as $opts) : ?>
      <?php if ($count % 4 == 0) : ?>
  </div>

  <div class="row justify-content-center">
    <?php endif; ?>
    <div class="col-6 col-md-3">
      <label for="<?= $opts['id'] ?>">Enter value of <?= $opts['detail'] ?></label>
      <input class="form-control px-2" type="number" id="<?= $opts['id'] ?>" name="nutritionComponents[<?= $opts['id'] ?>]" step="0.01"><br>
    </div>
    <?php $count++; ?>
    <?php endforeach; ?>
  </div>



  <div class="text-center">
    <button type="submit" class="btn btn-primary">Add</button>
  </div>
</form>
<div class="d-md-flex justify-content-center py-3 mb-5">
        <a href="/manager" class="btn btn-secondary me-md-2" tabindex="-1" role="button" style="width: 10%;">Back</a>
    </div>
<!-- Include jQuery library -->
<script src="/Public/js/libs/jquery/jquery-3.5.1.min.js"></script>
 <script src="/Public/js/libs/jquery/jquery-1.19.2.min.js"></script> 
<script src="/Public/js/validate-ingredients.js"></script>

<script>
  $(document).ready(function() {
    $('#ingredient-form').submit(function(event) {
      // Ngăn chặn hành vi mặc định của form
      event.preventDefault();

      // Lấy dữ liệu form
      var formData = $(this).serialize();

      // Gửi dữ liệu form đi bằng AJAX
      $.ajax({
        type: 'POST',
        url: '/ingredient/add',
        data: formData,
        dataType: 'json',
        success: function(response) {
          if (response.success) {
            alert(response.message);

          } else {
            alert(response.message);
          }
        },
        error: function(xhr, status, error) {
          // Xử lý lỗi AJAX nếu có
          console.error(error);
        }
      });
    });
  });
</script>
<? require_once($_SERVER['DOCUMENT_ROOT'] . "/Public/inc/footer.php"); ?>
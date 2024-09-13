<? require_once($_SERVER['DOCUMENT_ROOT'] . '/Public/inc/header.php'); ?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Ingredients</title>
  <style>
    .container {
      margin-top: 20px;
    }

    h4 {
      margin-bottom: 20px;
      color: #6c757d;
      text-align: center;
    }

    .table {
      box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
      margin-left: auto;
      margin-right: auto;
    }

    th {
      background-color: #6c757d;
      color: white;
    }

    td,
    th {
      text-align: center;
      vertical-align: middle;
    }
  </style>
</head>

<body>
  <div class="container minspace">
    <h3 class="text-center">Ingredient manager</h3>
    <table class="table">
      <thead>
        <tr>
          <th scope="col">ID</th>
          <th scope="col">Name</th>
          <th scope="col">Category</th>
          <th scope="col">Measurement unit</th>
        </tr>
      </thead>
      <tbody class="ingredientTableBody">
      </tbody>
    </table>
    <div class="row">
      <div id="pagination" class="row justify-content-center mt-3"></div>
    </div>
  </div>
  <script src="/Public/js/libs/jquery/jquery-3.6.0.min.js"></script>
  <script src="/Public/js/ajax-ingredients.js"></script>
  <script src="/Public/js/show-pagination.js"></script>

</body>

</html>


<? require_once($_SERVER['DOCUMENT_ROOT'] . '/Public/inc/footer.php'); ?>
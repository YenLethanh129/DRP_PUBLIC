// Hàm xử lý hiển thị công thức dựa trên dữ liệu
function viewRecipes(data) {
  // Parse JSON data into JavaScript object
  var recipes = JSON.parse(data);

  // Container để chứa các thẻ công thức
  var recipeContainer = $(".d-flex.flex-wrap");

  // Duyệt qua mỗi công thức và thêm vào container
  $.each(recipes, function (index, recipe) {
    // Tạo thẻ div chứa thông tin của mỗi công thức
    var recipeDiv = $(
      '<div class="card col-md-8" style="width: 22.5%; margin: 1rem 1.25%; cursor: pointer;">' +
        '<img src="' +
        (recipe.image_url
          ? "/Public/uploads/recipes/" + recipe.image_url
          : "/Public/images/image_not_found.png") +
        '" class="card-img-top" alt="Picture of meal" style="object-fit: cover; height:12rem;">' +
        '<div class="card-content" style="height:10rem">' +
        '<div class="card-body"  style="height:9rem; overflow: hidden">' +
        '<h5 class="card-title">' +
        recipe.name +
        "</h5>" +
        '<p class="card-text">' +
        recipe.description +
        "</p>" +
        "</p>"  
        + 
        // Data attribute để lưu trữ thông tin chi tiết của công thức
        '<div class="card-details" style="display: none;" ' +
        '</div>' +
        '<div class="card-footer d-flex align-items-center" style="border: none; background-color: white; padding: 0;">' +
        '<i class="fa-solid fa-clock-rotate-left"></i>' +
        '<p style="margin: 0;padding-left: 8px;">' +
        recipe.preparation_time +
        '"mins"</p>' +
        '</div>' +
        '<div class="rating"></div>' + // Thẻ div để chứa rating
        '</div>' +
        '</div>' +
      '</div>'
    );

    // Xuất thông tin chi tiết của công thức thành chuỗi JSON
    var idDetails = JSON.stringify(recipe.recipe_id);

    // Thêm dữ liệu vào thuộc tính data-details của thẻ card
    recipeDiv.find(".card-details").attr("data-details", idDetails);
    // Thêm thẻ div vào container
    recipeContainer.append(recipeDiv);

  });
}

var page = 1;

$(function () {
  getRecipes();
});

$("#show").click(function () {
  page++;
  getRecipes(page);
});

function getRecipes(page = 1) {
  $("#show").text("Next");
  $.ajax({
    type: "GET",
    url: "/recipes/?page=" + page,
    dataType: "json",
    success: function (recipes) {
      // Hiển thị công thức
      viewRecipes(recipes);
      var recipesPerPage = 12; // Số lượng công thức hiển thị trên mỗi trang

      // Trong hàm getRecipes:
      if (recipes.length < recipesPerPage) {
        $("#show").fadeOut(0);
      }
    },
  });
}

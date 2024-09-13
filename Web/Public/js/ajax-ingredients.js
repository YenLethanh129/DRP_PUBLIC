function viewIngredient(ingredients) {


    // Xóa dữ liệu cũ trong bảng
    $(".ingredientTableBody").empty();
  
    // Duyệt qua mảng ingredients để thêm dữ liệu mới vào bảng
    $.each(ingredients, function (index, ingredient) {
      // Xây dựng hàng của bảng
      var row =
        "<tr>" +
        "<td>" +
        ingredient.id +
        "</td>" +
        "<td>" +
        ingredient.name +
        "</td>" +
        "<td>" +
        ingredient.category +
        "</td>" +
        "<td>" + 
        ingredient.measurementUnit + 
        "</td>" + 
        "</tr>";
  
      // Thêm hàng vào tbody của bảng
      $(".ingredientTableBody").append(row);
    });
  }
  
  var page = 1;
  var totalPage =  1; 
  
  $(function () {
    getIngredient();
  });
  
  function getIngredient(page = 1) {
    $.ajax({
      type: "GET",
      url: "/ingredients/?page=" + page,
      dataType: "json",
      success: function (data) {
        console.log(data.ingredients);
        viewIngredient(data.ingredients);
      
        // Hiển thị các nút trang
        showPagination(data.totalPage, page);
      },
    });
  }
  
  // Đổi trang khi người dùng chọn trang khác
  function changePage(page) {
    getIngredient(page);
  }
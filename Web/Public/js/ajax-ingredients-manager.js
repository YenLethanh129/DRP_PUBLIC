function viewIngredient(ingredients) {
  // Xóa dữ liệu cũ trong bảng
  $(".ingredientTableBody").empty();

  // Duyệt qua mảng ingredients để thêm dữ liệu mới vào bảng
  $.each(ingredients, function (index, ingredient) {
    // Xây dựng hàng của bảng
    var row =
      "<tr>" +
      "<td>" + ingredient.id + "</td>" +
      "<td>" + ingredient.name + "</td>" +
      "<td>" + ingredient.category + "</td>" +
      "<td>" + ingredient.measurementUnit + "</td>" +
      // Các thuộc tính cho cột actions 
      "<td>" +
      "<form class='set-active-form d-inline-block'>" +
      "<input type='hidden' name='id' value='" + ingredient.id + "'>" +
      "<input type='hidden' name='isActive' value='" + (ingredient.isActive ? '0' : '1') + "'>" +
      "<button class='btn " + (ingredient.isActive ? 'btn-danger' : 'btn-success') + " me-1' style='width: 120px' type='submit'>" +
      (ingredient.isActive ? 'Deactivate' : 'Activate') +
      "</button>" +
      "</form>" +
      "<form class='delete-form d-inline-block' >" +
      "<input type='hidden' name='id' value='" + ingredient.id + "'>" +
      "<button class='btn btn-danger me-1' type='submit'>Delete</button>" +
      "</form>" +
      "<a href='/manager/ingredient/update?id=" + ingredient.id + "' class='btn btn-secondary d-inline-block me-1 mt-1' role='button'>Edit</a>" +
      "</td>"
    "</tr>";

    // Thêm hàng vào tbody của bảng
    $(".ingredientTableBody").append(row);
  });
}

var page = 1;
var totalPage = 1;

$(function () {
  getIngredient();
});

function getIngredient(page = 1) {
  $.ajax({
    type: "GET",
    url: "/ingredients-all/?page=" + page,
    dataType: "json",
    success: function (data) {

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

// Đổi trang thái cho active button
$(document).on('submit', '.set-active-form', function (event) {
  event.preventDefault();

  var formData = $(this).serialize();

  var button = $(this).find('button[type="submit"]'); 

  $.ajax({
    type: 'POST',
    url: '/manager/ingredient',
    data: formData,
    dataType: 'json',
    success: function (response) {
      if (response.success) {
        alert(response.message);
        button.toggleClass('btn-danger btn-success');

        var buttonText = button.hasClass('btn-danger') ? 'Deactivate' : 'Activate';
        button.text(buttonText);
      } else {
        alert(response.message);
      }
    },
    error: function (xhr, status, error) {
      console.error(error);
    }
  });
});

// Thông báo khi xoá ingredient
$(document).on('submit', '.delete-form', function (event) {
  event.preventDefault();

  var formData = $(this).serialize();
  var button = $(this).find('button[type="submit"]'); 

  // Hiển thị cảnh báo trước khi xóa
  if (confirm("Are you sure to delete this ingredient?")) {
    $.ajax({
      type: 'POST',
      url: '/manager/ingredient/delete',
      data: formData,
      dataType: 'json',
      success: function (response) {
        if (response.success) {
          alert(response.message);
          // Tải lại trang sau khi xóa thành công
          location.reload();
        } else {
          alert(response.message);
        }
      },
      error: function (xhr, status, error) {
        console.error(error);
      }
    });
  }
});

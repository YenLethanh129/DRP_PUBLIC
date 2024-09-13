
function showPagination(totalPage, currentPage) {
    var paginationHtml =
      "<nav aria-label='Page navigation'><ul class='pagination'>";
  
    // Nút Start Page
    paginationHtml +=
      "<li class='page-item'><a class='page-link' href='#' onclick='changePage(" +
      1 +
      ")'>Start Page</a></li>";
  
    // Tính số trang bắt đầu và kết thúc
    var startPage = Math.max(1, currentPage - 2);
    var endPage = Math.min(totalPage, startPage + 4);
    var startPageAdjustment = Math.max(1, endPage - 4);
  
    // Nút Previous
    paginationHtml +=
      "<li class='page-item'><a class='page-link' href='#' onclick='changePage(" +
      (currentPage - 1) +
      ")'>Previous</a></li>";
  
    // Các nút trang
    for (var i = startPageAdjustment; i <= endPage; i++) {
      paginationHtml +=
        "<li class='page-item " +
        (i === currentPage ? "active" : "") +
        "'><a class='page-link' href='#' onclick='changePage(" +
        i +
        ")'>" +
        i +
        "</a></li>";
    }
  
    // Nút Next
    paginationHtml +=
      "<li class='page-item'><a class='page-link' href='#' onclick='changePage(" +
      (currentPage + 1) +
      ")'>Next</a></li>";
  
    // Nút End Page
    paginationHtml +=
      "<li class='page-item'><a class='page-link' href='#' onclick='changePage(" +
      totalPage + 
      ")'>End Page</a></li>";
  
    paginationHtml += "</ul></nav>";
  
    $("#pagination").html(paginationHtml);
  }
  

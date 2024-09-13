$(document).ready(function () {
    $('#recipe-table').DataTable({
        "paging": true,
        "lengthChange": true,
        "lengthMenu": [[5, 10, 25, -1], [5, 10, 25, "All"]],
        "searching": true,
        "ordering": true, 
        "info": true, 
        "autoWidth": false, 
        "responsive": true,
        "language": {
            "emptyTable": "No data available in table",
            "info": "Showing _START_ to _END_ of _TOTAL_ recipes",
            "infoEmpty": "Showing 0 to 0 of 0 recipes",
            "infoFiltered": "(filtered from _MAX_ total recipes)",
            "lengthMenu": "Show _MENU_ recipes",
            "search": "Search:",
            "zeroRecords": "No matching records found"
        },
        "columnDefs": [
            {
                "targets": [2, 6], // Indexes of columns to limit text length
                "render": function (data, type, row) {
                    // Limit text length to 50 character
                    return type === 'display' && data.length > 100 ?
                        '<span title="' + data + '">' + data.substr(0, 100) + '...</span>' :
                        data;
                }
            }
        ]
    });
});


// Đổi trang thái cho active button
$(document).on('submit', '.set-active-form', function (event) {
    event.preventDefault();
  
    var formData = $(this).serialize();
  
    var button = $(this).find('button[type="submit"]'); // Get the button element
  
    $.ajax({
      type: 'POST',
      url: '/manager/recipe',
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
  
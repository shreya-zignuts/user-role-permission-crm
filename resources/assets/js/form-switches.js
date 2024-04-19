/**
 * Treeview (jquery)
 */

'use strict';

function handleToggle(id, route) {
  var status = $('.switch-input[data-id="' + id + '"]').prop('checked') ? 1 : 0;

  Swal.fire({
    title: 'Are you sure?',
    text: "You won't be able to revert this!",
    icon: 'warning',
    showCancelButton: true,
    confirmButtonText: 'Yes, toggle it!',
    customClass: {
      confirmButton: 'btn btn-primary me-3',
      cancelButton: 'btn btn-label-secondary'
    },
    buttonsStyling: false
  }).then(function (result) {
    if (result.isConfirmed) {
      $.ajax({
        type: 'GET',
        dataType: 'json',
        url: route + id, // Construct URL based on the route and id
        data: {
          status: status,
          id: id
        },
        success: function (data) {
          console.log(data.success);
          Swal.fire({
            icon: 'success',
            title: 'Changed!',
            text: 'Toggle status for role is changed',
            customClass: {
              confirmButton: 'btn btn-success'
            }
          }).then(function () {
            window.location.reload();
          });
        },
        error: function (xhr, status, error) {
          console.error(xhr.responseText);
          Swal.fire({
            icon: 'error',
            title: 'Oops...',
            text: 'Something went wrong!',
            customClass: {
              confirmButton: 'btn btn-danger'
            }
          });
        }
      });
    }
  });
}

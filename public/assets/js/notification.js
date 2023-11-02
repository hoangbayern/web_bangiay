"use strict";
export const notification = (function () {
  const module = {};
  const Swal = window.Swal;

  module.confirm = function (message = "You won't be able to revert this!") {
    return Swal.fire({
      title: "Are you sure?",
      text: message,
      icon: "warning",
      showCancelButton: true,
      confirmButtonColor: "#3085d6",
      cancelButtonColor: "#d33",
      confirmButtonText: "Yes"
    });
  };

  module.success = function (type, message) {
    Swal.fire({
      icon: "success",
      type,
      title: "Success!",
      text: message
    });
  };

  module.error = function (message) {
    Swal.fire({
      icon: "error",
      type: "error",
      title: "Error!",
      text: message
    });
  };

  return module;
})(window.jQuery, document, window);

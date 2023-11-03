"use strict";
import { main } from "./main.js";
import { notification } from "./notification.js";

export const user = (function () {
  const module = {};

  module.openModal = function (element) {
    const url = $(element).attr("href");
    $.get(url, function (response) {
      $("#modal").html(response.html);
      $("#modal-form").modal("show");
    }, "json");
  };

  module.save = function (element) {
    const url = element.attr("action");
    const data = new FormData(element[0]);
    main.sendAjax(url, "POST", data).then(function (response) {
      notification.success("Success!", response.message);
        element[0].reset();
    }).catch(function (errors) {
      main.renderError(errors);
    });
  };

  module.delete = function (element) {
    const url = element.attr("href");
    notification.confirm().then((result) => {
      if (result.isConfirmed) {
        main.sendAjax(url, "DELETE").then(function () {
          main.lists().catch();
          notification.success("Deleted!", "Data has been deleted successfully.");
        }).catch(function () {
          notification.error("Data has been deleted failed.");
        });
      }
    });
  };

  return module;
})(window.jQuery, window, document);

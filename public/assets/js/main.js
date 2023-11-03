$.ajaxSetup({
  headers: {
    "X-CSRF-TOKEN": $("meta[name=\"csrf-token\"]").attr("content")
  }
});

export const main = (function () {
  const DELAY_TIMEOUT = 500;
  const module = {};

  module.debounce = function (func, delay = DELAY_TIMEOUT) {
    let timer;
    return function () {
      clearTimeout(timer);
      timer = setTimeout(() => {
        func.apply(this, arguments);
      }, delay);
    };
  };

  module.paginateActive = function () {
    const paginate = $(".pagination .active span");
    console.log(paginate.val());
  };

  module.renderError = function (errors) {
    this.removeError();
    const errorsObj = JSON.parse(errors.responseText).errors;
    for (const key in errorsObj) {
      $(`#input-${key}`).addClass("is-invalid");
      $(`#${key}-error`).text(errorsObj[key][0]);
    }
    $(".is-invalid").first().focus();
  };

  module.removeError = function () {
    $(".is-invalid").toggleClass("is-invalid");
    $(".error").html("");
  };

  module.sendAjax = function (url, method = "GET", data = null) {
    return $.ajax({
      url,
      data,
      method,
      typeData: "json",
      processData: false,
      contentType: false,
      async: false
    });
  };

  module.lists = async function (url = null) {
    const form = $("#form-search");
    const link = url ?? form.attr("action");
    const data = form.serialize();
    await this.getLists(link, "GET", data);
  };

  module.getLists = async function (url, method = "GET", data = "") {
    await this.sendAjax(url, method, data).then((response) => {
      $("#table-data").html(response.html);
    });
  };

  return module;
})(window.jQuery, document, window);

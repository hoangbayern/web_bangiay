import { main } from "./main.js";
import { user } from "./user.js";
import { image } from "./image.js";

main.lists().catch();

$(document).on("input", ".is-invalid", function () {
    $(this).removeClass("is-invalid");
});

$(document).on("click", ".pagination a", function (event) {
  event.preventDefault();
  main.lists($(this).attr("href")).catch();
});

$(document).on("keyup", ".name", main.debounce(function () {
  main.lists().catch();
}));

$(document).on("change", ".category", main.debounce(function () {
  main.lists().catch();
}));

$(document).on("keyup", ".price-from", main.debounce(function () {
  main.lists().catch();
}));

$(document).on("keyup", ".price-to", main.debounce(function () {
  main.lists().catch();
}));

$(document).on("change", ".category", main.debounce(function () {
  main.lists().catch();
}));

$(document).on("click", ".btn-open-modal", function (event) {
  user.openModal($(this));
  event.preventDefault();
});

$(document).ready(function(event) {
    $(".btn-save").click(function() {
        user.save($("#form-data"));
        event.preventDefault();
    });
});

$(document).on("click", ".btn-delete", function (event) {
  user.delete($(this));
  event.preventDefault();
});

$(document).on("change", ".input-image", function () {
  $(this).removeClass("is-invalid");
  image.load($(this), $(".image-preview"));
});

main.paginateActive();

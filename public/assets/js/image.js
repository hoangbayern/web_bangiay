"use strict";
export const image = (function () {
  const module = {};

  module.load = function (element, elementPreview) {
    const file = $(element)[0].files[0];
    const reader = new FileReader();
    reader.readAsDataURL(file);
    reader.onload = () => {
      const url = URL.createObjectURL(file);
      elementPreview.attr("src", url);
    };
  };

  return module;
})(window.jQuery, document, window);

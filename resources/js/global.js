const AOS = require("aos");
require("select2");

jQuery(document).ready(function ($) {
  const selectOptions = {
    minimumResultsForSearch: Infinity,
    placeholder: "Talent category you are entering *",
  };
  $("select").select2(selectOptions);
});

jQuery(window).on("load", function () {
  AOS.init({
    duration: 700,
    once: true,
  });
});

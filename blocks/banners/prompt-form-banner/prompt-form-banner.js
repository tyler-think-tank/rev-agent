jQuery(document).on("submit", "#prompt-form", function (e) {
  e.preventDefault();
  if (
    /[-a-zA-Z0-9@:%._\+~#=]{1,256}\.[a-zA-Z]{2,6}\b([-a-zA-Z0-9@:%_\+.~#?&//=]*)$/g.test(
      jQuery("#input-prompt").val()
    )
  ) {
    jQuery.ajax({
      url: "https://zymplify-beta.com/ssu",
      type: "POST",
      dataType: "json",
      data: {
        ws_d: jQuery("#input-prompt").val(),
      },
      success: function (result) {
        window.location.href = "https://zymplify-beta.com/ssu";
      },
    });
  } else {
    alert("Please enter your Goal");
    return false;
  }
});

jQuery(document).on("ready", function () {
  jQuery(".prompt-form--predefined-item").on("click", function () {
    var value = jQuery(this)
      .find(".prompt-form--predefined-item-prompt > span")
      .text();
    jQuery("#input-prompt").val(value);
  });
});

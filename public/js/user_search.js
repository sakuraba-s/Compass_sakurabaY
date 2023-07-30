$(function () {
  $('.search_conditions').click(function () {
    $(this).next().slideToggle(300);

    // $('.search_conditions_inner').slideToggle(300);
    $(this).toggleClass("open", 300);
  

  });

  $('.subject_edit_btn').click(function () {
    // $('.subject_inner').slideToggle(300);
    $(this).next().slideToggle(300);
    $(this).toggleClass("open", 300);

  });
});

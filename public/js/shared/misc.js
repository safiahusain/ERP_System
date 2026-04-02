// 👉 MENU TOGGLE (Parent click)
$('#sidebar .menu-toggle').on('click', function (e) {
  e.preventDefault();

  let target = $($(this).attr('href'));

  if (target.hasClass('show')) {
    target.removeClass('show');
    $(this).attr('aria-expanded', 'false');
  } else {
    // accordion behavior
    $('#sidebar .collapse').removeClass('show');
    $('#sidebar .menu-toggle').attr('aria-expanded', 'false');

    target.addClass('show');
    $(this).attr('aria-expanded', 'true');
  }

  // active highlight
  $('#sidebar .nav-item').removeClass('active');
  $(this).parent('.nav-item').addClass('active');
});


// 👉 NORMAL LINKS
$('#sidebar .nav-link').not('.menu-toggle').on('click', function () {

  $('#sidebar .nav-link').removeClass('active');
  $('#sidebar .nav-item').removeClass('active');

  $(this).addClass('active');
  $(this).parent('.nav-item').addClass('active');
});



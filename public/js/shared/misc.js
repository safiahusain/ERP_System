(function ($) {
  'use strict';
  $(function () {

    var current = window.location.pathname;

    // Reset everything first
    $('#sidebar .collapse').removeClass('show');
    $('#sidebar a[data-toggle="collapse"]').attr('aria-expanded', 'false');

    // Auto active detection
    $('#sidebar .nav-link').each(function () {

      var link = $(this).attr('href');

      if (link && current.indexOf(link) !== -1 && link !== '#') {

        $(this).addClass('active');

        var parents = $(this).parents('.collapse');

        parents.each(function () {
          $(this).addClass('show');
          $(this).prev('.nav-link')
            .attr('aria-expanded', 'true');
        });

      }

    });

    // Prevent refresh on sidebar click
    $('#sidebar .nav-link').on('click', function (e) {

      var link = $(this).attr('href');

      if (link === '#' || link === '' || $(this).attr('data-toggle') === 'collapse') {
        e.preventDefault(); // stop page refresh
      }

      // active class switch
      $('#sidebar .nav-link').removeClass('active');
      $(this).addClass('active');

    });

  });
})(jQuery);

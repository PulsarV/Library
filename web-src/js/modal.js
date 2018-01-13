$(function() {
  var body = $('body');
  var entity = body.find('table').attr('data-entity');

  $('.add-button').on('click', function() {
    var route = $(this).attr('data-rname');
    $.ajax({
      url: Routing.generate(route),
      method: 'GET',
      dataType: 'html'
    })
    .done(function(data) {
      showModalWindow($(data));
    });
  });

  $('.edit-button').on('click', function() {
    var route = $(this).attr('data-rname');
    var id = $(this).attr('data-id');
    var params = {};
    params[entity] = id;

    $.ajax({
      url: Routing.generate(route, params),
      method: 'GET',
      dataType: 'html'
    })
    .done(function(data) {
      showModalWindow($(data));
    });
  });

  $('.delete-button').on('click', function() {
    var route = $(this).attr('data-rname');
    var id = $(this).attr('data-id');
    var params = {};
    params[entity] = id;

    $.ajax({
      url: Routing.generate(route, params),
      method: 'GET',
      dataType: 'html'
    })
    .done(function(data) {
      showModalWindow($(data));
    });
  });

  body.on('shown.bs.modal', function (e) {
    var tagSelector = $(this).find(("#app_bundle_book_type_tags"));
    $(tagSelector).chosen({
       search_contains: true,
       placeholder_text_multiple: '  Select tags'
    });

    var modal = $(e.target);

    modal.find('form').on('submit', function(e) {
      e.preventDefault();
      var form = $(this);
      $.ajax({
        type: form.attr('method'),
        url: form.attr('action'),
        data: form.serialize(),
        dataType: 'html'
      }).done(function(data) {
        hideModalWindow(modal);
        if (data === 'SUCCESS') {
          location.reload();
        } else {
          showModalWindow($(data));
        }
      });
    });

  });

  body.on('hidden.bs.modal', '.modal', function () {
    $(this).removeData('bs.modal');
    $(this).remove();
  });

  function showModalWindow(modal) {
    modal.modal('show');
  }

  function hideModalWindow(modal) {
    modal.modal('hide');
  }
});

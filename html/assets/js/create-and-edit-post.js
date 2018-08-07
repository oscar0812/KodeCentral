var quill = new Quill('#editor-container', {
  modules: {
    formula: true,
    syntax: true,
    toolbar: '#toolbar-container'
  },
  placeholder: 'Write your mind off...',
  theme: 'snow'
});

// set the contents of the editor if editing an already submitted post
preload = $('#preload-content');

preload.find('code').each(function() {
  // add highlighting to each code block
  // parents html will be w.e html code had, and also has ql-syntax class
  $(this).parent().addClass('ql-syntax').html($(this).html());
});

$(quill.root).html(preload.html().trim());
// remove it once we get data out, to reduce html page size
preload.remove();

$(function() {
  $('#show-lib').on('click', function() {
    $(this).remove();
    $('#lib-row').removeClass('invisible');
    return false;
  });

  // choosing a library
  library_select = $('#library-select');
  append_select = $('#position-select');

  if (library_select.val() != "All") {
    append_select.prop('disabled', false);
    libraryChange();
  }

  library_select.on('change', libraryChange);

  function libraryChange() {
    name = $(library_select).val();

    if (name == "All") {
      // if all, then dont show a position, just add to back
      append_select.prop('disabled', true);
      append_select.selectpicker('refresh');
      return;
    }

    append_select.prop('disabled', false);

    url = $(library_select).data('posts-url');

    // remove all previously set options
    append_select.find('option').remove();

    // go and fetch the posts for this library and put them in #position-select
    $.ajax({
      type: "POST",
      data: {
        library: name
      },
      url: url,
      dataType: "json",
      success: function(data) {
        // append to #positon-select as: First-> Beginning of library,
        // Second + -> after title
        append_select.append($('<option>').text("In the beginning").val("-1"));

        current = "-1";
        runner = "-1";
        // list of posts under this library
        $.each(data, function(link, title) {
          if (link != library_select.data('current-url')) {
            // found the current post, remove it from the positioning
            current = link;
            append_select.append($('<option>').text("After " + title).val(link));
          } else {
            runner = current;
          }
        });

        append_select.val(runner);
        append_select.selectpicker('refresh');
      }
    });
  }

  // creating a new library
  $('#library-form').on('submit', function(e) {
    ajaxForm(e.target, function(data) {
      if (data['success']) {
        // append a new library, then choose it and refresh the dropdown
        library_select.append($('<option>').text(data['msg']).val(data['msg']));
        library_select.val(data['msg']);
        library_select.selectpicker('refresh');
        $('#library-modal').modal('toggle');

        Snackbar.show({
          actionTextColor: '#00ff00',
          text: "Successfully created library \"" + data['msg'] + "\""
        });
      } else {
        Snackbar.show({
          actionTextColor: '#ff0000',
          text: data['msg']
        });
      }
    })
    return false;
  })

  // creating a new post
  // if cookie was set, then user saved
  if (typeof Cookies.get(window.location.href) != 'undefined') {
    $(quill.root).html(Cookies.get(window.location.href));
  }

  // save a cookie with the text if save button is clicked
  $('#save-button').on('click', function() {
    Cookies.set(window.location.href, $(quill.root).html(), {
      expires: 1
    });

    Snackbar.show({
      actionTextColor: '#00ff00',
      text: "Text saved"
    });
    return false;
  });

  $('#create-form').on('submit', function(e) {
    title = $('#title').val();
    root = $(quill.root).clone();
    html = root.html();
    categories = $('#categories-select').val();

    if (title.trim() == "") {
      shake($('#title').parent());
      return false;
    }

    if (categories.length == 0) {
      shake($('#categories-select').parent());
      return false;
    }

    // for some odd reason empty text is the following on the WYSIWYG
    empty_text = "<p><br></p>";

    if (html == empty_text || html == "") {
      shake($(quill.root));
      return false;
    }

    code = root.find('.ql-syntax');
    code.removeClass('.ql-syntax');
    code.each(function() {
      // grab the code blocks from here and convert to what hightlight.js
      // likes
      text = $(this).text();
      $(this).empty();
      $(this).removeAttr('class').removeAttr('spellcheck');

      code_block = $('<code>').text(text);
      $(this).wrapInner(code_block);
    });

    $.ajax({
      type: "POST",
      data: {
        title: title,
        text: root.html(),
        categories: categories,
        library_name: library_select.val(),
        library_index: append_select.val()
      },
      url: "",
      dataType: "json",
      success: function(data) {

        if (data['success']) {
          // submitted, so stop saving the current text state
          Cookies.remove(window.location.href);
          if (typeof data['redirect'] != 'undefined') {
            // if the logic is to redirect, then do it
            window.location.href = data['redirect'];
            return;
          }

          color = '#00ff00';
        } else {
          color = '#ff0000';
        }

        Snackbar.show({
          actionTextColor: color,
          text: data['text']
        });

      }
    });

    return false;
  });
});

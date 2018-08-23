hljs.initHighlightingOnLoad();

$(function() {
  // show larger image in modal when image is clicked
  $('#post-text img').each(function() {
    // let image shrink when parent is shrinking
    $(this).addClass('img-fluid');
    link = $(this).parent();
    if (link.prop("tagName") != 'A') {
      // if image isnt surrounded in a link
      link = $(this).wrap($('<a href="' + $(this).attr('src') + '">').attr('target', '_blank')).parent();
    }
    // need this in order to show in dialog
    link.attr('c', true).attr('data-lightbox', 'gallery');
    $(this).parent().wrap($('<div class="zoom-img">'));

  });

  // load all the posts this person has seen
  cookie = Cookies.get('history');
  cookie = typeof cookie == 'undefined' ? '[]' : cookie;
  arr = $.parseJSON(cookie);

  link = $('body').attr('data-hyperlink');
  title = $('body').attr('data-title');

  archives = $('#archives');
  template = archives.find('.invisible').eq(0);

  in_list = false;
  arr.forEach(function(e) {
    if (e.link == link) {
      // already in list, just update the date
      e.date = new Date();
      in_list = true;
    } else {
      // now that were here, just append to the list
      copy = template.clone().removeClass('invisible').attr('href', e.link);
      copy.find('span').text(e.title);
      template.before(copy);
    }
  });

  // try to store this page on the page visited history
  if (!in_list) {
    arr.push({
      link: link,
      title: title,
      date: new Date()
    });
  }

  // sort by date, with newest date on top
  arr.sort(function(x, y) {
    var a = new Date(x.date),
      b = new Date(y.date);
    return b - a;
  });

  if (arr.length > 10) {
    arr.length = 10;
  }

  Cookies.set('history', JSON.stringify(arr), {
    expires: 30
  });

  comments = $('#comment-body');

  $('#show-hide-comments').on('click', function() {
    icon = $(this).find('.zmdi');
    animationDone = 'webkitAnimationEnd mozAnimationEnd MSAnimationEnd onanimationend animationend';
    commentBlock = comments.parent();
    if (icon.hasClass('zmdi-eye')) {

      commentBlock.removeClass('invisible');
      commentBlock.removeClass('fadeOutRight');

      commentBlock.addClass('fadeInLeftTiny').one(animationDone, function() {
        // clicking to show comments
        icon.removeClass('zmdi-eye');
        icon.addClass('zmdi-eye-off');
      });
    } else {
      // clicking to hide comments
      commentBlock.removeClass('fadeInLeftTiny');

      commentBlock.addClass('fadeOutRight').one(animationDone, function() {
        $(this).addClass('invisible');
        icon.removeClass('zmdi-eye-off');
        icon.addClass('zmdi-eye');
      });
    }
    return false;
  });

  $('#comment-form').on('submit', function(e) {

    ajaxForm(e.target, function(data) {
      // comment is being posted
      if (data['success']) {
        info = $('#user-info');
        // get the template
        template = $('#comment-template').clone().
        addClass('ms-icon-feature').removeClass('invisible');

        // set the comment text
        template.find('.ms-icon-feature-content>p').text(data['text']);

        // clear the textarea
        $('textarea[name="text"]').val('');

        // add the comment to the comment section
        comments.prepend(template);

        $('#comment-number').text(parseInt($('#comment-number').text()) + 1);
      }
    });
    return false;
  });
});

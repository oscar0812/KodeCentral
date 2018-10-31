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
    $(this).parent().wrap($('<div>'));

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

  // block adblockers
  // Function called if AdBlock is not detected
  function adBlockNotDetected() {
    //console.log('AdBlock is not enabled');
  }
  // Function called if AdBlock is detected
  function adBlockDetected() {
    console.log('AdBlock is enabled');
    // remove text
    $('body .container .col-lg-8').remove();
    $("#ad-modal").modal('show');
  }

  // Recommended audit because AdBlock lock the file 'blockadblock.js'
  // If the file is not called, the variable does not exist 'blockAdBlock'
  // This means that AdBlock is present
  if (typeof blockAdBlock === 'undefined') {
    adBlockDetected();
  } else {
    blockAdBlock.onDetected(adBlockDetected);
    blockAdBlock.onNotDetected(adBlockNotDetected);
  }
});

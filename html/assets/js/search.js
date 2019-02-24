function getIndicesOf(searchStr, str, caseSensitive) {
  var searchStrLen = searchStr.length;
  if (searchStrLen == 0) {
    return [];
  }
  var startIndex = 0,
    index, indices = [];
  if (!caseSensitive) {
    str = str.toLowerCase();
    searchStr = searchStr.toLowerCase();
  }
  while ((index = str.indexOf(searchStr, startIndex)) > -1) {
    indices.push(index);
    startIndex = index + searchStrLen;
  }
  return indices;
}

var decodeEntities = (function() {
  // this prevents any overhead from creating the object each time
  var element = document.createElement('div');

  function decodeHTMLEntities(str) {
    if (str && typeof str === 'string') {
      // strip script/html tags
      str = str.replace(/<script[^>]*>([\S\s]*?)<\/script>/gmi, '');
      str = str.replace(/<\/?\w(?:[^"'>]|"[^"]*"|'[^']*')*>/gmi, '');
      element.innerHTML = str;
      str = element.textContent;
      element.textContent = '';
    }

    return str;
  }

  return decodeHTMLEntities;
})();

function addPeriods(indices, searchThis, finalText) {
  // replace the textArea text with highlight...highlight... (etc)

  if (indices.length == 0) {
    // none found in the post text, maybe just in post title
    return finalText.substring(0, 90) + "...";
  }

  if (indices.length == 1) {
    indices.push(indices[0]);
  }

  length = 80;

  // only care about first 2 finds
  diff = indices[1] - indices[0];

  beg = indices[0];
  end = indices[1] + searchThis.length;

  if (diff < length) {
    length -= diff;
    // just one string
    beg -= length / 2;
    end += length / 2;

    if (beg < 0) {
      // too much to left
      end -= beg;
      beg = 0;
      return finalText.substring(beg, end) + "...";
    } else if (end > finalText.length) {
      // to much to right
      beg -= (end - finalText.length);
      end = finalText.length;
      return "..." + finalText.substring(beg, end);
    } else {
      // right in the middle
      return "..." + finalText.substring(beg, end) + "...";
    }
  } else {
    length = 40;

    end = beg + searchThis.length + (length / 2);
    beg -= length / 2;
    // sepereate by a bunch of text
    all = "";
    if (beg < 0) {
      // too much to left
      end -= beg;
      beg = 0;
    } else {
      all = "...";
    }
    all += (finalText.substring(beg, end) + "...");

    beg = indices[1] - searchThis.length - length / 2;
    end = indices[1] + searchThis.length + length / 2;

    all += (finalText.substring(beg, end) + "...");

    return all;
  }
}


$(function() {
  button = $('#search-button');
  template = $('#template');
  paste = $('#paste');

  function goFetchPosts(searchThis) {
    if (searchThis == '') return;

    button.attr('disabled', true);
    paste.children().remove();
    button.find('span').text('Searching...');

    $.ajax({
      type: "POST",
      data: {
        text: searchThis
      },
      url: "",
      dataType: "json",
      success: function(data) {
        button.attr('disabled', false);
        button.find('span').text('Search');

        $.each(data, function(i, post) {
          copy = template.clone().removeClass('invisible');
          copy.attr('data-url', post['Hyperlink']);
          copy.find('.post-title').text(post['Title']);

          textArea = copy.find('.post-text');
          // remove html codes such as &nbsp; from post text
          mainText = decodeEntities(post['Text']);
          // add periods before and after the hightlight
          indices = getIndicesOf(searchThis, mainText);
          mainText = addPeriods(indices, searchThis, mainText);

          textArea.text(mainText);
          $(copy).highlight(searchThis);

          copy.find('.post-date').text(post['PostedDate']);

          paste.prepend(copy);
        });

        // change url in case of reload
        beginning = [location.protocol, '//', location.host, location.pathname].join('');
        newUrl = beginning + "?text=" + searchThis;
        window.history.pushState(null, '', newUrl);
      }
    });
  }

  searchThis = $('#main-text');
  goFetchPosts(searchThis.val());

  button.on('click', function() {
    goFetchPosts(searchThis.val());
  });

  // when enter is pressed, trigger the button click
  searchThis.on('keyup', function(e) {
    if (e.keyCode === 13) {
      button.click();
    }
  });

});

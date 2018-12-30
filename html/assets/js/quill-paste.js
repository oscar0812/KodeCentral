// paste handler
// if link, check if image, then show the image,
// if not image, just make it a clickable link
$(function() {
  quill.clipboard.addMatcher(Node.TEXT_NODE, function(node, delta) {
    var regex = /https?:\/\/[^\s]+/g;
    if (typeof(node.data) !== 'string') return;
    var matches = node.data.match(regex);

    if (matches && matches.length > 0) {
      var ops = [];
      var str = node.data;

      matches.forEach(function(match) {
        var split = str.split(match);
        if (match.match(/\.(png|jpg|jpeg|gif|svg)$/) != null) {
          var beforeLink = split.shift();
          ops.push({
            insert: beforeLink
          });
          ops.push({
            insert: {
              image: match
            },
            attributes: {
              link: match
            }
          });

          str = split.join(match);
        } else {
          //if link is not an image
          var beforeLink = split.shift();
          ops.push({
            insert: beforeLink
          });
          ops.push({
            insert: match,
            attributes: {
              link: match
            }
          });
          str = split.join(match);
        }
      });
      ops.push({
        insert: str
      });
      delta.ops = ops;
    }
    return delta;
  });
});

// Delete the ACF Beautiful Flexible popup if only one layout
jQuery(document).ready(function ($) {
    var flexible_content_open = acf.fields.flexible_content._open;
    acf.fields.flexible_content._open = function (e) {
        var $popup = $(this.$el.children('.tmpl-popup').html());
        if ($popup.find('a').length == 1) {
            // Only one layout
            acf.fields.flexible_content.add($popup.find('a').attr('data-layout'));
            return false;
        }
        return flexible_content_open.apply(this, arguments);
    }
});

// Transform a link into a div for styling purpose
jQuery('body').on('click', 'a[data-name="add-layout"]', function () {
    setTimeout(function () {
        $(".acf-fc-popup a").each(function () {
            var html = "<div>" + $(this).text() + "</div>";
            $(this).html(html);
        });
    }, 0);
});
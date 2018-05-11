jQuery(document).ready(function ($) {
    try {
        // ACF Flexible Content: Ajouter une class à la modal de sélection de Layouts
        var flexible_content_position = acf.fields.flexible_content.position_popup;
        acf.fields.flexible_content.position_popup = function ($popup, $bouton) {
            // Continuer l'exécution normalement
            return flexible_content_position.apply(this, arguments);
        }
    } catch (e) {
    }
});

jQuery(document).ready(function ($) {
    try {
        // ACF Flexible Content: Supprimer la popup si il n'y a qu'un seul Layout
        var flexible_content_open = acf.fields.flexible_content._open;
        acf.fields.flexible_content._open = function (e) {
            var $popup = $(this.$el.children('.tmpl-popup').html());
            // On compte le nombre de layouts
            if ($popup.find('a').length == 1) {
                acf.fields.flexible_content.add($popup.find('a').attr('data-layout'));
                return false;
            }
            // Si plus d'un layout, continuer l'exécution normalement
            return flexible_content_open.apply(this, arguments);
        }
    } catch (e) {
    }
});

jQuery(document).ready(function ($) {
    $('a[data-name="add-layout"]').on('click', function () {
        setTimeout(function () {
            $(".acf-fc-popup a").each(function () {
                var html = "<div>" + $(this).text() + "</div>";
                $(this).html(html);
            });
        }, 0);
    });
});
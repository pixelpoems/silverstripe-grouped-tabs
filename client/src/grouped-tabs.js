(function ($) {
    $(document).off('tabsactivate.groupedtabs').on('tabsactivate.groupedtabs', function (e, ui) {
        if (ui.newPanel && ui.newPanel.length) {
            ui.newPanel.siblings('.tab-pane').hide().attr('aria-hidden', 'true');
        }
    });

    $(document).off('click.groupedtabs').on('click.groupedtabs', '.tab-group-item a', function (e) {
        e.preventDefault();
        e.stopPropagation();
        var href = this.hash;
        var groupLi = $(this).closest('.tab-group');
        var groupA = groupLi.find('a.tab-group-title');
        if (!groupLi.hasClass('ui-tabs-active')) {
            groupA[0].click();
        }
        var target = $(href);
        if (target.length) {
            target.closest('.tab-content').find('> .tab-pane').hide().attr('aria-hidden', 'true');
            target.show().removeAttr('aria-hidden');
            target.closest('.panel--scrollable').scrollTop(0);
        }
    });
}(jQuery));

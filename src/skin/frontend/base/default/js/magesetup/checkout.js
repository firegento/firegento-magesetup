document.observe('dom:loaded', function () {
    // make sure that the tax details are expanded by default
    if (typeof Review !== 'undefined') {
        Checkout.prototype.gotoSection = Checkout.prototype.gotoSection.wrap(function (parent, section, reloadProgressBlock) {
            parent(section, reloadProgressBlock);
            if (section !== 'review') {
                return;
            }
            var summaryTotals = $$('.summary-total');
            for (var i = 0; i < summaryTotals.length; i++) {
                summaryTotals[i].click();
            }
        });
    }
});

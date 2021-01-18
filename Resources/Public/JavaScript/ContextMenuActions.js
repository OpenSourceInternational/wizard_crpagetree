define(["require", "jquery", "TYPO3/CMS/Backend/Viewport"], function (require, jQuery, backendViewport) {
    "use strict";
    return function () {
        return require.pagesNewTree = function () {
            var url = jQuery(this).data("page-new-tree-url");
            url && backendViewport.ContentContainer.setUrl(url);
        }, require
    }()
});

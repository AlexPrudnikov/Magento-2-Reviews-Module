
/**
 * Copyright © Magento, Inc. All rights reserved.
 * See COPYING.txt for license details.
 */

define([
    'jquery',
    'matchMedia',
    'mage/tabs',
    'domReady!'
], function ($, mediaCheck) {
    'use strict';

    mediaCheck({
        media: '(min-width: 768px)',

        /**
         * Switch to Desktop Version.
         */
        entry: function () {
            /* The function that toggles page elements from desktop to mobile mode is called here */

            let panelHeader = document.querySelector('.panel.header');
            let blockSearch = document.querySelector('.block-search');
            let blockMinicart = document.querySelector('.minicart-wrapper');
            let blockHeaderLinks = document.querySelector('.header.links');
            let blockHeaderWrapperLogo = document.querySelector('.header-wrapper-logo');

            panelHeader.insertBefore(blockSearch, blockHeaderLinks.nextSibling);

            if(blockHeaderWrapperLogo.nextSibling === null) {
                panelHeader.appendChild(blockMinicart);
            } else {
                panelHeader.insertBefore(blockMinicart, blockHeaderWrapperLogo.nextSibling);
            }

        },

        /**
         * Switch to Mobile Version.
         */
        exit: function () {
             console.log('Hello World');
            /* The function that toggles page elements from desktop to mobile mode is called here */
            let blockSearch = document.querySelector('.block-search');
            let blockMinicart = document.querySelector('.minicart-wrapper');
            let headerContent = document.querySelector('.content');
            let logo = document.querySelector('.logo');

            headerContent.insertBefore(blockMinicart, logo.nextSibling);
            headerContent.insertBefore(blockSearch, blockMinicart.nextSibling);
        }
    });
});

define([
    'underscore',
    'Magento_Ui/js/grid/columns/select'
], function (_, Column) {
    'use strict';

    return Column.extend({
        defaults: {
        	customerStyle: {
        		0: 'red',
        		1: 'green'
        	},

            bodyTmpl: 'Companyinfo_Review/ui/grid/cells/text'
        },

        getStatusStyle: function (row) {
            let custClass = this.customerStyle[row.status];
            return custClass;
        }
    });
});
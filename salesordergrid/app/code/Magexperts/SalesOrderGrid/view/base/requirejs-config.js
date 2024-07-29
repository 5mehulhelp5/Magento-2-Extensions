var config = {
    map: {
        '*': {
            'ui/template/grid/paging-total':
                'Magexperts_SalesOrderGrid/template/grid/paging-total'
        }
    },
    'config': {
        'mixins': {
            'Magento_Ui/js/grid/provider': {
                'Magexperts_SalesOrderGrid/js/grid/provider': true
            }
        }
    }
};

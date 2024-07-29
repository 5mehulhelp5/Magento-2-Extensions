require(
    [
        'jquery',
        'mage/translate',
        'jquery/validate'
    ],
    function ($) {
        $.validator.addMethod(
            'aittfa-ip-validate',
            function (v) {
                if (v !== '') {
                    let ipList = v.split(' ');
                    if (ipList.length > 0) {
                        for (let ip of ipList) {
                            let chunk = ip.split('.');
                            if (chunk.length !== 4) {
                                return false;
                            }
                            for (let char of chunk) {
                                if (isNaN(char) || Number(char) < 0 || Number(char) > 255) {
                                    return false;
                                }
                            }
                        }
                    }
                }
                return true;
            },
            $.mage.__('Invalid field value.')
        );
    }
);

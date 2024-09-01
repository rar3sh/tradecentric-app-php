import {config} from '@vue/test-utils';
import moment from 'moment';

config.global.mocks = {
    $formatDate: function (value) {
        return 'YYYY-MM-DD HH:mm';
    }
}

config.global.provide = {
    moment: moment
}

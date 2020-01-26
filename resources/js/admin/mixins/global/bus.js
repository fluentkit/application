import Vue from 'vue';

const Bus = new Vue();

export default {
    methods: {
        $bus () {
            return Bus;
        }
    }
}

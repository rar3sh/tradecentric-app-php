<template>
    <div id="charts_container">

        <!-- FILTER   -->
        <div class="container">
            <div class="container-fluid">
                CHART
            </div>
        </div>

    </div>
</template>


<script>
import axios from 'axios'

export default {
    name: 'Charts',
    components: {  },
    data () {
        return {

        }
    },
    methods: {
        async getOrdersPerDay () {
            try {
                // this.currentOrder = await axios.get('/api/orders/' + orderId)
            } catch (error) {
                console.log(error)
            }
        },
    },
    computed: {

    },
    mounted () {
        this.getOrdersPerDay()
    }
}
</script>

<style scoped>

</style>

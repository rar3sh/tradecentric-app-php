<template>
    <div id="charts_container" style="width:100%; height:400px;"></div>
</template>

<script>
import axios from 'axios'
import Highcharts from 'highcharts/highstock'

export default {
    name: 'Charts',
    methods: {
        async getOrdersPerDay () {
            try {
                const data = await axios.get('/api/charts/orders-per-day')
                console.log(data)
                Highcharts.chart('charts_container', {
                    chart: {
                        type: 'column'
                    },
                    title: {
                        text: 'PURCHASE ORDERS RECEIVED PER DAY'
                    },
                    xAxis: {
                        categories: data.data.days
                    },
                    yAxis: {
                        title: {
                            text: 'Orders count'
                        }
                    },
                    series: [
                        {
                            name: 'Orders in this day',
                            data: data.data.count
                        }
                    ]
                })
            } catch (error) {
                console.log(error)
            }
        },
    },
    mounted () {
        this.getOrdersPerDay()
    }
}
</script>

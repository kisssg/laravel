<template>
    <div>
        <chart :chartdata="chartdata" :options="options"></chart>
        <button v-on:click="showdata()">QC</button>
        <button v-on:click="showdata(1)">Date</button>
    </div>
</template>
<script>
    export default{
        data: () => ({
                chartdata: null,
                options: {
                    scales: {
                        xAxes: [
                            {stacked: true}
                        ]
                    }
                }
            }),
        mounted() {
        },
        methods: {
            showdata(type) {
                let uri = '/project/chartdata?type='+type;
                axios.get(uri).then((response) => {
                    console.log(response.data);
                    this.chartdata = response.data;
                }).catch(error => {
                    console.log(error);
                });
            }
        }
    }
</script>
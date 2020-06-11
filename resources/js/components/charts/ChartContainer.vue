<template>
    <div>
        <chart :chartdata="chartdata" :options="options"></chart>
    </div>
</template>
<script>
    export default{
        data: () => ({
                chartdata: null,
                options: {
                    scales: {
                        xAxes: [{
                                ticks: {
                                    beginAtZero: true
                                }
                            },
                            {stacked: true}
                        ]
                    }
                }
            }),
        mounted() {
            let uri = '/project/chartdata';
            axios.get(uri).then((response) => {
                console.log(response.data);
                this.chartdata = response.data;
            }).catch(error => {
                console.log(error);
            });
        }
    }
</script>
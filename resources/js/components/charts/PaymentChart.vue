<template>
    <div>
        <bar-chart :chartdata="chartdata" :options="options" class="height:300px;"></bar-chart>
    </div>
</template>
<script>
    export default{
        props:['id'],
        data: () => ({
                chartdata: null,
                options: {
                    responsive: true,
				tooltips: {
					mode: 'index',
                                        position:"nearest"
				},
                    scales: {
                        xAxes: [
                            {stacked: true}
                        ],
                        yAxes: [{
                            id: 'left-y-axis',
                            type: 'linear',
                            position: 'left'
                                }, {
                            id: 'right-y-axis',
                            type: 'linear',
                            position: 'right'
                            }]
                    }
                }
            }),
        mounted() {
            this.showdata();
        },
        methods: {
            showdata(type) {
                let uri = '/payment/' + this.id;
                axios.get(uri).then((response) => {
                    console.log(this.owner);
                    this.chartdata = response.data;
                }).catch(error => {
                    console.log(error);
                });
            }
        }
    }
</script>
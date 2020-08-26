<template>
    <div class="height:100px;width:100%">
        <bar-chart :chartdata="chartdata" :options="options" ></bar-chart>
    </div>
</template>
<script>
    export default{
        props:['id'],
        data: () => ({
                chartdata: null,
                options: {
                    responsive: true, //resize the chart canvas when its container does
                    maintainAspectRatio:false, //maintain the original canvas aspect ratio when resizing(width/height)
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
                    this.chartdata = response.data;
                }).catch(error => {
                    console.log(error);
                });
            }
        }
    }
</script>
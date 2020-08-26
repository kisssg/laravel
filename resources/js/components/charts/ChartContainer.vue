<template>
    <div>
        <div class="text-center">
            <input type='text' placeholder='owner' v-model='owner'/>
            <input type='date' v-model='start' /> - <input type="date" v-model='end'/>
            <button v-on:click="showdata(1)">By date</button>
            <button v-on:click="showdata(0)">By owner</button>
        </div>
        <chart :chartdata="chartdata" :options="options"></chart>
    </div>
</template>
<script>
    export default{
        props:['project'],
        data: () => ({
                owner:"",
                start:null,
                end:null,
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
                let uri = '/project/'+this.project+'/chartdata?type='+type+'&start='+this.start+'&end='+this.end+'&owner='+this.owner;
                axios.get(uri).then((response) => {
                    this.chartdata = response.data;
                }).catch(error => {
                    console.log(error);
                });
            }
        }
    }
</script>
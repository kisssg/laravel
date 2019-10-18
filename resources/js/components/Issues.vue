<template>
     <div class='card' style="max-width: 15rem; min-width: 15rem;">
        <div class='card-header'>Collector info</div>
            <div class='card-body'>
     {{collector.name_cn}}
     {{collector.name_en}}<br>
     工号：{{collector.employee_id}}<br>
     Homer:{{collector.cfc_hm_id}}<br>
     区域城市:{{collector.area +' '+ collector.city}} <br>     
     {{collector.email}}
            </div>
            <div class='card-footer'></div>
    </div>
    </template>
    <script>
    export default {
        props:['id'],
        data() {  
        return {
                collector:null,                   
        }  
        },  
        watch: {  
        id(newValue, oldValue) {  
        console.log('watch' + newValue);
                this.showLLI(newValue,this);
        }  
        },
methods:{
    showLLI(id,vm){ 
            axios.get('/collector/get?id='+id).then(res=>{
                console.log(res.data[0]);
                vm.collector=res.data[0];
            });
}
}
    }
    </script>
    <style scoped>
        html, body {
            background-color: #fff;
            color: #636b6f;
            font-family: 'Raleway', sans-serif;
            font-weight: 100;
            height: 100vh;
            margin: 0;
        }

        .full-height {
            height: 100vh;
        }

        .flex-center {
            align-items: center;
            display: flex;
            justify-content: center;
        }

        .position-ref {
            position: relative;
        }

        .top-right {
            position: absolute;
            right: 10px;
            top: 18px;
        }

        .content {
            text-align: center;
        }

        .title {
            font-size: 84px;
        }

        .links > a {
            color: #636b6f;
            padding: 0 25px;
            font-size: 12px;
            font-weight: 600;
            letter-spacing: .1rem;
            text-decoration: none;
            text-transform: uppercase;
        }

        .m-b-md {
            margin-bottom: 30px;
        }
    </style>

<template>
<div>
 <select @change="update">
                <option
                        v-for="col in colors"
                        :value="col"
                        :key="col"
                        :selected="col === color ? 'selected' : ''"
                >{{ col | properCase }}</option>

            </select>
</div>
</template>
<script>
        export default {
    computed: {
      image() {
        return `/images/${this.color}.png`;
      }
    },
    methods: {
      update(val) {
        this.$emit('update', this.id, val.target.selectedOptions[0].value);
      },
      del() {
        this.$emit('delete', this.id);
      }
    }, 
    props: ['id', 'color', 'name','colors'],
    data:function(){
        return{
            colors  :['red', 'green' ,'black'],
        }
    },
    filters: {
      properCase(string) {
        return string.charAt(0).toUpperCase() + string.slice(1);
      }
    }
  }
    </script>
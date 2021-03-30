<template>
    <div>
        <v-select
            :handle="config.handle"
            :value="value"
            :options="countries"
            :multiple="true"
            :searchable="true"
            :taggable="true"
            @input="update"
        ></v-select>
    </div>
</template>

<script>
    export default {
        mixins: [Fieldtype],

        data() {
            return {
                countries: this.meta.countries
            }
        },
    };
</script>

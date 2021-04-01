<template>
    <div>
        <v-select
            :handle="config.handle"
            :value="value"
            :options="types"
            :multiple="false"
            :searchable="false"
            :taggable="false"
            @input="update"
        ></v-select>
    </div>
</template>

<script>
    export default {
        mixins: [Fieldtype],

        data() {
            return {
                types: this.meta.types,
            }
        },
    };
</script>

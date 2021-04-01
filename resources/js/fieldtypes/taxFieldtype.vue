<template>
    <div>
        <select-input
            :handle="config.handle"
            :value="value"
            :options="types"
            @input="update"
        ></select-input>
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

<template>
    <div>
        <select-input
            :handle="config.handle"
            :value="value"
            :options="taxes"
            @input="update"
        ></select-input>
    </div>
</template>

<script>
    export default {
        mixins: [Fieldtype],

        data() {
            return {
                taxes: this.meta.shippings,
            }
        },
    };
</script>

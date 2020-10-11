<template>
    <div>
        <select-input
            :handle="config.handle"
            :value="value"
            :options="countries"
            @input="update"
        ></select-input>
    </div>
</template>

<script>
    export default {
        mixins: [Fieldtype],

        data() {
            return {
                countries: this.meta.countries,
            }
        },
    };
</script>

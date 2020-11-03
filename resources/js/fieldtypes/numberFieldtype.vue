<template>
    <div>
        <text-input type="number" min="0" placeholder="0.00" :value="value" @input="update" />
    </div>
</template>

<script>
    export default {
        mixins: [Fieldtype],

        data() {
            return {}
        },
    };
</script>

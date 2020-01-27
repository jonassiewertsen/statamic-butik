<template>
    <div>
        <text-input type="number" :prepend="currencySymbol" min="0" placeholder="0.00" :value="value" @input="update" />
    </div>
</template>

<script>
    export default {
        mixins: [Fieldtype],

        data() {
            return {
                currencySymbol: this.meta.currencySymbol,
            }
        },
    };
</script>
<template>
    <stack :narrow="narrow">
        <div class="h-full bg-grey-30 p-4 overflow-auto">
            <header class="pb-3 py-1 border-b border-grey-30 text-lg font-medium flex items-center justify-between">
                Shipping
                <button type="button" class="btn-close" @click="close">×</button>
            </header>

            <div>
                <publish-form
                    :title="title"
                    :action="action"
                    :method="method"
                    :blueprint="blueprint"
                    :meta="meta"
                    :values="values"
                    @saved="saved"
                ></publish-form>
            </div>
        </div>
    </stack>
</template>

<script>
    export default {
        props: {
            blueprint: Array,
            meta: Array,
            values: Array,
            method: { default: 'post' },
            title: String,
            action: String,
            narrow: Boolean,
        },

        methods: {
            close() {
                this.$emit('closed', true)
            },

            saved() {
                this.$emit('saved', true)
            }
        }
    }
</script>

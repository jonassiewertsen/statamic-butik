<template>
    <div class="flex justify-center">
        <button @click="click" :class="classes" class="flex inline-flex items-center px-3 py-1 rounded-full shadow-sm text-grey-70 text-sm hover:text-blue outline-none">
            <svg class="mr-1" xmlns="http://www.w3.org/2000/svg" width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><line x1="12" y1="5" x2="12" y2="19"></line><line x1="5" y1="12" x2="19" y2="12"></line></svg>
            {{ label }}
        </button>
    </div>
</template>

<script>
    export default {
        props: {
            label: {
                type: String,
                default: '',
            },
            classes: {
                type: String,
                default: 'bg-white',
            },
        },

        methods: {
            click() {
                this.$emit('clicked', true)
            }
        }
    }
</script>

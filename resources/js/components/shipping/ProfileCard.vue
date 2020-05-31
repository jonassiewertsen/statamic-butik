<template>
    <div class="card mb-2">
        <header class="flex justify-between items-center">
            <h2 class="mb-2">{{ title }}</h2>
            <button @click="manage(slug)" class="flex items-center text-xs text-grey-70 hover:text-blue outline-none">
                Manage
                <svg class="ml-1" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7"></path><path d="M18.5 2.5a2.121 2.121 0 0 1 3 3L12 15l-4 1 1-4 9.5-9.5z"></path></svg>
            </button>
        </header>

        <p v-if="isDefault(slug)" class="text-grey-70 mb-2">
            Your starting point for shipping rates.
        </p>

        <h3 class="mb-1 font-bold">Rates for</h3>

        <ul>
            <li v-if="zones.length > 0" v-for="zone in zones" class="mb-1 flex items-center">
                <svg class="mr-1 text-grey-70" xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="10"></circle><line x1="2" y1="12" x2="22" y2="12"></line><path d="M12 2a15.3 15.3 0 0 1 4 10 15.3 15.3 0 0 1-4 10 15.3 15.3 0 0 1-4-10 15.3 15.3 0 0 1 4-10z"></path></svg>
                {{ zone.title }}
            </li>
        </ul>
        <span v-if="zones.length === 0" class="flex items-center text-xs text-grey-70">
                No Shipping Zones created.
                <a class="ml-sm text-blue hover:underline" href="#">Create</a>
            </span>
    </div>
</template>

<script>
    export default {
        props: {
            title: {
                type: String,
                default: '',
            },
            slug: {
                type: String,
                default: '',
            },
            zones: {
                type: Array,
                default: [],
            },
        },

        methods: {
            manage(slug) {
                this.$emit('manage', slug)
            },

            isDefault(slug) {
                return slug === 'default'
            }
        }
    }
</script>

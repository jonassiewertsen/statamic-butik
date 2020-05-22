<template>
    <div>
        <profile-card v-for="profile in shippingProfiles"
            :title="profile.title"
            :slug="profile.slug"
            :zones="profile.zones"
        ></profile-card>

        <div class="flex justify-center pt-1">
            <button @click="showCreateStack = true" class="bg-white flex inline-flex items-center px-3 py-1 rounded-full shadow-sm text-grey-70 text-sm hover:text-blue">
                <svg class="mr-1" xmlns="http://www.w3.org/2000/svg" width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><line x1="12" y1="5" x2="12" y2="19"></line><line x1="5" y1="12" x2="19" y2="12"></line></svg>
                Create a new shipping profile
            </button>
        </div>

        <create-stack
            v-if="this.showCreateStack"
            :action="createShippingProfileRoute"
            :title="createShippingProfileTitle"
            :blueprint="shippingProfileBlueprint"
            :meta="shippingProfileMeta"
            :values="shippingProfileValues"
            @closed="showCreateStack = false"
            @saved="shippingProfileSaved"
        ></create-stack>
    </div>
</template>

<script>
    import axios from 'axios'
    import CreateStack from "./../stacks/CreateStack"
    import ProfileCard from "./ProfileCard"

    export default {
        props: {
            createShippingProfileTitle: String,
            createShippingProfileRoute: String,
            indexShippingProfileRoute: String,
            shippingProfileBlueprint: Array,
            shippingProfileValues: Array,
            shippingProfileMeta: Array,
        },

        components: {
            CreateStack,
            ProfileCard,
        },

        data() {
            return {
                showCreateStack: false,
                shippingProfiles: [],
            }
        },

        mounted() {
            this.fetchShippingProfiles()
        },

        methods: {
            fetchShippingProfiles() {
                axios.get(this.indexShippingProfileRoute)
                    .then(response => {
                        this.shippingProfiles = response.data
                    }).catch(error => {
                        this.$toast.error(error)
                })
            },

            shippingProfileSaved() {
                this.showCreateStack = false
                this.fetchShippingProfiles()
            }
        }
    }
</script>

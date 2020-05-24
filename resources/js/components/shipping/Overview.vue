<template>
    <div>
        <profile-card v-for="profile in shippingProfiles" key="profile.slug"
            :title="profile.title"
            :slug="profile.slug"
            :zones="profile.zones"
            @manage="openManageStack"
        ></profile-card>

        <create-button
            :label="'Create a new shipping profile'"
            @clicked="createShippingProfileOpen = true"
        ></create-button>

        <create-stack narrow
            v-if="createShippingProfileOpen"
            :action="createShippingProfileRoute"
            :title="createShippingProfileTitle"
            :blueprint="shippingProfileBlueprint"
            :meta="shippingProfileMeta"
            :values="shippingProfileValues"
            @closed="createShippingProfileOpen = false"
            @saved="shippingProfileSaved"
        ></create-stack>

        <create-stack
            v-if="createShippingZoneOpen"
            :action="createShippingZoneRoute"
            :title="createShippingZoneTitle"
            :blueprint="shippingZoneBlueprint"
            :meta="shippingZoneMeta"
            :values="shippingZoneUpdatedValues"
            @closed="createShippingZoneOpen = false"
            @saved="shippingZoneSaved"
        ></create-stack>

        <manage-stack
            v-if="showManageStack"
            :slug="showManageStack"
            @closed="showManageStack = null"
            @deleteShippingProfile="deleteShippingProfile"
            @openShippingZone="createShippingZoneOpen = true"
        ></manage-stack>
    </div>
</template>

<script>
    import axios from 'axios'
    import CreateStack from "./../stacks/CreateStack"
    import ProfileCard from "./ProfileCard"
    import ManageStack from "./ManageStack";
    import CreateButton from "../../partials/CreateButton";

    export default {
        props: {
            createShippingProfileTitle: String,
            createShippingProfileRoute: String,
            deleteShippingProfileRoute: String,
            indexShippingProfileRoute: String,
            shippingProfileBlueprint: Array,
            shippingProfileValues: Array,
            shippingProfileMeta: Array,
            createShippingZoneTitle: String,
            createShippingZoneRoute: String,
            shippingZoneBlueprint: Array,
            shippingZoneValues: Array,
            shippingZoneMeta: Array,
        },

        components: {
            CreateButton,
            CreateStack,
            ManageStack,
            ProfileCard,
        },

        data() {
            return {
                createShippingProfileOpen: false,
                createShippingZoneOpen: false,
                shippingZoneUpdatedValues: [],
                showManageStack: null,
                shippingProfiles: [],
            }
        },

        mounted() {
            this.fetchShippingProfiles()
            this.shippingZoneUpdatedValues = this.shippingZoneValues
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
                this.createShippingProfileOpen = false
                this.fetchShippingProfiles()
            },

            shippingZoneSaved() {
                this.createShippingZoneOpen = false
                this.fetchShippingProfiles()
            },

            openManageStack(slug) {
                this.updateShippingZoneSlug(slug)
                this.showManageStack = slug
            },

            updateShippingZoneSlug(slug) {
                this.shippingZoneUpdatedValues.shipping_profile_slug = slug
            },

            deleteShippingProfile(slug) {
                axios.delete(`${this.indexShippingProfileRoute}/${slug}`)
                    .then(() => {
                        this.showManageStack = null
                        this.fetchShippingProfiles()
                    })
                    .catch(error => {
                        this.$toast.error(error)
                    })
            }
        }
    }
</script>

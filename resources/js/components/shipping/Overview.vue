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
            @clicked="showCreateShippingProfileStack = true"
        ></create-button>

        <create-stack narrow
            v-if="showCreateShippingProfileStack"
            :action="shippingProfileRoute"
            :title="shippingProfileCreateTitle"
            :blueprint="shippingProfileBlueprint"
            :meta="shippingProfileMeta"
            :values="shippingProfileValues"
            @closed="showCreateShippingProfileStack = false"
            @saved="shippingProfileSaved"
        ></create-stack>

        <create-stack
            v-if="showCreateShippingZoneStack"
            :action="shippingZoneRoute"
            :title="shippingZoneCreateTitle"
            :blueprint="shippingZoneBlueprint"
            :meta="shippingZoneMeta"
            :values="shippingZoneUpdatedValues"
            @closed="showCreateShippingZoneStack = false"
            @saved="shippingZoneSaved"
        ></create-stack>

        <manage-stack
            v-if="showShippingProfileManageStack"
            :slug="showShippingProfileManageStack"
            :shippingProfileRoute="shippingProfileRoute"
            @closed="showShippingProfileManageStack = null"
            @deleteShippingProfile="deleteShippingProfile"
            @openShippingZone="showCreateShippingZoneStack = true"
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
            shippingProfileCreateTitle: String,
            shippingProfileRoute: String,
            shippingProfileBlueprint: Array,
            shippingProfileValues: Array,
            shippingProfileMeta: Array,
            shippingZoneCreateTitle: String,
            shippingZoneRoute: String,
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
                showCreateShippingProfileStack: false,
                showCreateShippingZoneStack: false,
                showShippingProfileManageStack: null,
                shippingZoneUpdatedValues: [],
                shippingProfiles: [],
            }
        },

        mounted() {
            this.fetchShippingProfiles()
            this.shippingZoneUpdatedValues = this.shippingZoneValues
        },

        methods: {
            fetchShippingProfiles() {
                axios.get(this.shippingProfileRoute)
                    .then(response => {
                        this.shippingProfiles = response.data
                    }).catch(error => {
                        this.$toast.error(error)
                    })
            },

            shippingProfileSaved() {
                this.showCreateShippingProfileStack = false
                this.fetchShippingProfiles()
            },

            shippingZoneSaved() {
                this.showCreateShippingZoneStack = false
                this.fetchShippingProfiles()
            },

            openManageStack(slug) {
                this.updateShippingZoneSlug(slug)
                this.showShippingProfileManageStack = slug
            },

            updateShippingZoneSlug(slug) {
                this.shippingZoneUpdatedValues.shipping_profile_slug = slug
            },

            deleteShippingProfile(slug) {
                axios.delete(`${this.shippingProfileRoute}/${slug}`)
                    .then(() => {
                        this.showShippingProfileManageStack = null
                        this.fetchShippingProfiles()
                    })
                    .catch(error => {
                        this.$toast.error(error)
                    })
            }
        }
    }
</script>

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

        <manage-stack
            v-if="showShippingProfileManageStack"
            :slug="showShippingProfileManageStack"
            @closed="closeShippingProfileManageStack"

            :shippingProfileRoute="shippingProfileRoute"
            @deleteShippingProfile="deleteShippingProfile"

            :shippingZoneRoute="shippingZoneRoute"
            :shippingZoneCreateTitle="shippingZoneCreateTitle"
            :shippingZoneBlueprint="shippingZoneBlueprint"
            :shippingZoneMeta="shippingZoneMeta"
            :shippingZoneValues="shippingZoneValues"

            :shippingRateRoute="shippingRateRoute"
            :shippingRateCreateTitle="shippingRateCreateTitle"
            :shippingRateBlueprint="shippingRateBlueprint"
            :shippingRateMeta="shippingRateMeta"
            :shippingRateValues="shippingRateValues"
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

            shippingRateCreateTitle: String,
            shippingRateRoute: String,
            shippingRateBlueprint: Array,
            shippingRateValues: Array,
            shippingRateMeta: Array,
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
                showShippingProfileManageStack: null,
                shippingProfiles: [],
            }
        },

        mounted() {
            this.fetchShippingProfiles()
        },

        methods: {
            refresh() {
                this.fetchShippingProfiles()
            },

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
                this.refresh()
            },

            openManageStack(slug) {
                this.showShippingProfileManageStack = slug
            },

            closeShippingProfileManageStack() {
                this.showShippingProfileManageStack = null
                this.refresh()
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

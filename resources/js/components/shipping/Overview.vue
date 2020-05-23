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
            @clicked="showCreateStack = true"
        ></create-button>

        <create-stack narrow
            v-if="showCreateStack"
            :action="createShippingProfileRoute"
            :title="createShippingProfileTitle"
            :blueprint="shippingProfileBlueprint"
            :meta="shippingProfileMeta"
            :values="shippingProfileValues"
            @closed="showCreateStack = false"
            @saved="shippingProfileSaved"
        ></create-stack>

        <manage-stack
            v-if="showManageStack"
            :slug="showManageStack"
            @closed="showManageStack = null"
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
            indexShippingProfileRoute: String,
            shippingProfileBlueprint: Array,
            shippingProfileValues: Array,
            shippingProfileMeta: Array,
        },

        components: {
            CreateButton,
            CreateStack,
            ManageStack,
            ProfileCard,
        },

        data() {
            return {
                showCreateStack: false,
                showManageStack: null,
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
            },

            openManageStack(slug) {
                this.showManageStack = slug
            }
        }
    }
</script>

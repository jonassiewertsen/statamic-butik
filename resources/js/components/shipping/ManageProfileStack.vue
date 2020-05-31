<template>
    <stack>
        <div class="h-full bg-white p-4 overflow-auto">
            <header class="pb-5 py-2 border-grey-30 text-lg font-medium flex items-center justify-between">
                <div class="flex items-center">
                    <h2>Manage {{ profile.title }} Shipping</h2>
                    <create-button
                        @clicked="showCreateShippingZoneStack = true"
                        :label="'Create shipping zone'"
                        :classes="'bg-grey-20 ml-4'"
                    ></create-button>
                </div>

                <button type="button" class="btn-close" @click="close">×</button>
            </header>

            <section v-for="zone in profile.zones" class="mb-6">
                <header class="mb-1 flex items-start leading-none">
                    <svg class="mr-2 text-grey-70" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="10"></circle><line x1="2" y1="12" x2="22" y2="12"></line><path d="M12 2a15.3 15.3 0 0 1 4 10 15.3 15.3 0 0 1-4 10 15.3 15.3 0 0 1-4-10 15.3 15.3 0 0 1 4-10z"></path></svg>
                    <section>
                        <h3 class="block text-2xl">
                            {{ zone.title }}
                            <button @click="showShippingZoneManageStack = zone" class="align-bottom hover:text-blue inline-flex ml-1 text-grey-40 outline-none">
                                <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 20 20"><path d="M17.414 2.586a2 2 0 00-2.828 0L7 10.172V13h2.828l7.586-7.586a2 2 0 000-2.828z"></path><path fill-rule="evenodd" d="M2 6a2 2 0 012-2h4a1 1 0 010 2H4v10h10v-4a1 1 0 112 0v4a2 2 0 01-2 2H4a2 2 0 01-2-2V6z" clip-rule="evenodd"></path></svg>
                            </button>
                        </h3>
                        <ul class="flex leading-loose text-grey-70">
                            <li v-for="country in zone.countries">{{ country.name }}/</li>
                        </ul>
                    </section>
                </header>

                <div class="max-w-md mt-4 ml-5 -pl-1">
                    <table v-if="zone.rates.length > 0" class="w-full leading-loose text-grey-70">
                        <tr class="text-left border-b-2 text-grey-80">
                            <th class="font-medium py-2 pl-1">Rate name</th>
                            <th class="font-medium py-2">Minimum amount</th>
                            <th class="font-medium py-2">Price</th>
                            <th class="font-medium py-2"></th>
                        </tr>
                        <tr v-for="rate in zone.rates" class="border-b hover:bg-grey-10">
                            <td class="py-2 pl-1">{{ rate.title }}</td>
                            <td class="py-2">{{ rate.minimum }}</td>
                            <td class="py-2">{{ rate.price }}</td>
                            <td class="text-right hover:text-grey-80 pr-1">
                                <dropdown-list class="flex justify-end">
                                    <dropdown-item
                                        :text="__('Delete')"
                                        class="warning"
                                        @click="confirmRateDeletion = rate.id" />
                                </dropdown-list>
                            </td>
                        </tr>
                    </table>
                    <div v-else class="bg-orange border-l-8 mb-1 px-4 py-2 text-grey-80">
                        No rates have been created yet.
                    </div>

                    <create-button
                        :label="'Add rate'"
                        :classes="'bg-grey-20 mt-2 mr-auto'"
                        @clicked="openCreateShippingRateStack(zone.id)"
                    ></create-button>

                </div>
            </section>

            <hr class="mt-6 mb-3">

            <button @click="confirmProfileDeletion = true" class="btn-danger">Delete shipping profile</button>

            <confirmation-modal danger
                v-if="confirmProfileDeletion"
                buttonText="Delete shipping profile"
                title="Delete"
                bodyText="Are you sure you want delete this shipping profile?"
                @confirm="deleteShippingProfile"
                @cancel="confirmProfileDeletion = false"
            ></confirmation-modal>

            <confirmation-modal danger
                v-if="confirmRateDeletion !== false"
                buttonText="Delete shipping rate"
                title="Delete"
                bodyText="Are you sure you want delete this shipping rate?"
                @confirm="deleteShippingRate(confirmRateDeletion)"
                @cancel="confirmRateDeletion = false"
            ></confirmation-modal>

            <form-stack
                v-if="showCreateShippingZoneStack"
                :action="shippingZoneRoute"
                :title="shippingZoneCreateTitle"
                :blueprint="shippingZoneBlueprint"
                :meta="shippingZoneMeta"
                :values="shippingZoneUpdatedValues"
                @closed="showCreateShippingZoneStack = false"
                @saved="shippingZoneSaved"
            ></form-stack>

            <form-stack
                v-if="showCreateShippingRateStack"
                :action="shippingRateRoute"
                :title="shippingRateCreateTitle"
                :blueprint="shippingRateBlueprint"
                :meta="shippingRateMeta"
                :values="shippingRateUpdatedValues"
                @closed="showCreateShippingRateStack = false"
                @saved="shippingRateSaved"
            ></form-stack>

            <manage-zone-stack
                v-if="showShippingZoneManageStack !== false"
                :zone="showShippingZoneManageStack"
                :route="shippingZoneRoute"
                @closed="closeShippingZoneManageStack()"
            ></manage-zone-stack>
        </div>
    </stack>
</template>

<script>
    import ManageZoneStack from "./ManageZoneStack";
    import CreateButton from "../../partials/CreateButton";
    import FormStack from "../stacks/Form"
    import axios from "axios";

    export default {
        components: { ManageZoneStack, CreateButton, FormStack },

        props: {
            slug: {
                type: String,
                default: null,
            },
            shippingProfileRoute: {
                type: String,
                default: null,
            },
            shippingZoneRoute: {
                type: String,
                default: null,
            },
            shippingZoneCreateTitle: {
                type: String,
                default: null,
            },
            shippingZoneBlueprint: {
                type: Array,
                default: [],
            },
            shippingZoneMeta: {
                type: Array,
                default: [],
            },
            shippingZoneValues: {
                type: Array,
                default: [],
            },
            shippingRateCreateTitle: {
                type: String,
                default: '',
            },
            shippingRateRoute: {
                type: String,
                default: ''
            },
            shippingRateBlueprint: {
                type: Array,
                default: [],
            },
            shippingRateValues: {
                type: Array,
                default: [],
            },
            shippingRateMeta: {
                type: Array,
                default: [],
            },
        },

        data() {
            return {
                showCreateShippingZoneStack: false,
                showCreateShippingRateStack: null,
                showShippingZoneManageStack: false,
                shippingZoneUpdatedValues: [],
                shippingRateUpdatedValues: [],
                confirmProfileDeletion: false,
                confirmRateDeletion: false,
                profile: [],
            }
        },

        mounted() {
            this.refresh()
            this.shippingZoneUpdatedValues = this.shippingZoneValues
            this.shippingRateUpdatedValues = this.shippingRateValues
            this.updateShippingZoneSlug()
        },

        methods: {

            close() {
                this.$emit('closed', true)
            },

            saved() {
                this.$emit('saved', true)
            },

            fetchShippingProfile(slug) {
                axios.get(`${this.shippingProfileRoute}/${slug}`)
                    .then(response => {
                        this.profile = response.data
                    }).catch(error => {
                    this.$toast.error(error)
                })
            },

            refresh() {
                this.fetchShippingProfile(this.slug)
            },

            updateShippingZoneSlug() {
                this.shippingZoneUpdatedValues.shipping_profile_slug = this.slug
            },

            shippingZoneSaved() {
                this.showCreateShippingZoneStack = false
                this.refresh()
            },

            shippingRateSaved() {
                this.showCreateShippingRateStack = false
                this.refresh()
            },

            deleteShippingProfile() {
                this.$emit('deleteShippingProfile', this.slug)
                this.confirmProfileDeletion = false
            },

            deleteShippingRate(id) {
                axios.delete(`${this.shippingRateRoute}/${id}`)
                    .then(() => {
                        this.refresh()
                        this.confirmRateDeletion = false
                    })
                    .catch(error => {
                        this.$toast.error(error)
                    })
            },

            openCreateShippingRateStack(id) {
                this.shippingRateUpdatedValues.shipping_zone_id = id
                this.showCreateShippingRateStack = id;
            },

            closeShippingZoneManageStack() {
                this.refresh()
                this.showShippingZoneManageStack = false
            }
        }
    }
</script>

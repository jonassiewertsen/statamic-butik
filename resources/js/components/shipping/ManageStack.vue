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
                        <h3 class="block text-2xl">{{ zone.title }}</h3>
                        <ul class="flex leading-loose text-grey-70">
                            <li v-for="country in zone.countries">{{ country.name }}/</li>
                        </ul>
                    </section>
                </header>

                <div class="max-w-md mt-4 ml-5 -pl-1">
                    <table v-if="zone.rates.length > 0" class="w-full leading-loose text-grey-70">
                        <tr class="text-left border-b-2 text-grey-80">
                            <th class="w-5/12 font-medium py-2 pl-1">Rate name</th>
                            <th class="w-4/12 font-medium py-2">Conditions</th>
                            <th class="w-2/12 font-medium py-2">Price</th>
                            <th class="w-1/12 font-medium py-2"></th>
                        </tr>
                        <tr v-for="rate in zone.rates" class="border-b hover:bg-grey-10">
                            <td class="py-2 pl-1">{{ rate.title }}</td>
                            <td class="py-2">{{ (rate.minimum / 100).toFixed(2)  }} - {{ (rate.maximum / 100).toFixed(2) }}</td>
                            <td class="py-2">{{ (rate.price / 100).toFixed(2) }}</td>
                            <td class="text-right hover:text-grey-80 pr-1">
                                <dropdown-list class="flex justify-end">
                                    <dropdown-item
                                        :text="__('Delete')"
                                        class="warning"
                                        @click="deleteShippingRate(rate.id)" />
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

            <button @click="confirmDeletion = true" class="btn-danger">Delete shipping profile</button>

            <confirmation-modal
                danger
                v-if="confirmDeletion"
                title="Delete"
                buttonText="Delete shipping profile"
                bodyText="Are you sure you want delete this shipping profile?"
                @confirm="deleteShippingProfile"
                @cancel="confirmDeletion = false"
            ></confirmation-modal>

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

            <create-stack
                v-if="showCreateShippingRateStack"
                :action="shippingRateRoute"
                :title="shippingRateCreateTitle"
                :blueprint="shippingRateBlueprint"
                :meta="shippingRateMeta"
                :values="shippingRateUpdatedValues"
                @closed="showCreateShippingRateStack = false"
                @saved="shippingRateSaved"
            ></create-stack>
        </div>
    </stack>
</template>

<script>
    import CreateButton from "../../partials/CreateButton";
    import CreateStack from "./../stacks/CreateStack"
    import axios from "axios";
    export default {
        components: { CreateButton, CreateStack },

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
                shippingZoneUpdatedValues: [],
                shippingRateUpdatedValues: [],
                confirmDeletion: false,
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

            close() {
                this.$emit('closed', true)
            },

            saved() {
                this.$emit('saved', true)
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
                this.confirmDeletion = false
            },

            deleteShippingRate(id) {
                console.log(`${this.shippingRateRoute}/${id}`)
                axios.delete(`${this.shippingRateRoute}/${id}`)
                    .then(() => {
                        this.refresh()
                    })
                    .catch(error => {
                        this.$toast.error(error)
                    })
            },

            openCreateShippingRateStack(id) {
                this.shippingRateUpdatedValues.shipping_zone_id = id
                this.showCreateShippingRateStack = id;
            }
        }
    }
</script>

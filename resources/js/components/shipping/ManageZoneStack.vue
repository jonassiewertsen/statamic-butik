<template>
    <stack>
        <div class="h-full bg-grey-30 p-4 overflow-auto">
            <header class="pb-5 py-2 border-grey-30 text-lg font-medium flex items-center justify-between">
                <div class="flex items-center">
                    <h2>Manage {{ zone.title }} shipping zone</h2>
                </div>

                <button type="button" class="btn-close" @click="close">×</button>
            </header>

            <publish-form
                    :action="`${this.route}/${this.zone.id}`"
                    :title="'Update general information'"
                    :blueprint="blueprint"
                    :meta="meta"
                    :method="'patch'"
                    :values="values"
                    @saved="close"
            ></publish-form>

            <h1 class="mb-3 mt-4">Countries</h1>

            <section class="card">
                <table class="data-table">
                    <tbody>
                    <tr v-for="country in countries">
                        <th class="pl-2 py-1 w-1/4">{{ country.name }}</th>
                        <td>
                            <toggle-input @input="update(country)" v-model="country.current_zone"
                                          :read-only="! country.can_be_attached && ! country.current_zone"></toggle-input>
                        </td>
                    </tr>
                    </tbody>
                </table>
            </section>

            <hr class="mt-6 mb-3">

            <button @click="confirmZoneDeletion = true" class="btn-danger">Delete shipping zone</button>

            <confirmation-modal danger
                                v-if="confirmZoneDeletion"
                                buttonText="Delete shipping zone"
                                title="Delete"
                                bodyText="Are you sure you want delete this shipping zone? All connected rates will be deleted as well. "
                                @confirm="deleteShippingZone"
                                @cancel="confirmZoneDeletion = false"
            ></confirmation-modal>
        </div>
    </stack>
</template>

<script>
    import CreateButton from "../../partials/CreateButton";
    import FormStack from "../stacks/Form"
    import axios from "axios";

    export default {
        components: {CreateButton, FormStack},

        props: {
            zone: {
                type: Array,
                default: [],
            },
            route: {
                type: String,
                default: '',
            },
            blueprint: {
                type: Array,
                default: [],
            },
            meta: {
                type: Array,
                default: [],
            },
            values: {
                type: Array,
                default: [],
            },
            countryShippingZoneRoute: {
                type: String,
                default: null,
            }
        },

        data() {
            return {
                confirmZoneDeletion: false,
                countries: [],
            }
        },

        mounted() {
            this.values.title = this.zone.title
            this.values.type = this.zone.type
            this.fetchCountries()
        },

        methods: {

            close() {
                this.$emit('closed', true)
            },

            saved() {
                this.$emit('saved', true)
            },

            createRoute(appendix) {
                return this.countryShippingZoneRoute.replace('xxx', appendix)
            },

            fetchCountries() {
                axios.get(this.createRoute(this.zone.id))
                    .then((response) => {
                        this.countries = response.data
                    })
                    .catch(error => {
                        this.$toast.error(error)
                    })
            },

            deleteShippingZone() {
                axios.delete(`${this.route}/${this.zone.id}`)
                    .then(() => {
                        this.close()
                    })
                    .catch(error => {
                        this.$toast.error(error)
                    })
            },

            update(country) {
                if (country.current_zone) {
                    this.addCountry(country)
                } else {
                    this.removeCountry(country)
                }
            },

            addCountry(country) {
                let route = this.createRoute(`${this.zone.id}/add/${country.slug}`)

                axios.post(route)
                    .then(() => {
                        this.$toast.success(__('Saved'))
                    })
                    .catch(error => {
                        this.$toast.error(error)
                    })
            },

            removeCountry(country) {
                let route = this.createRoute(`${this.zone.id}/remove/${country.slug}`)

                axios.delete(route)
                    .then(() => {
                        this.$toast.success(__('Removed'))
                    })
                    .catch(error => {
                        this.$toast.error(error)
                    })
            }
        }
    }
</script>

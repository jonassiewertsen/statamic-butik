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
                :title="'Update title'"
                :blueprint="blueprint"
                :meta="meta"
                :method="'patch'"
                :values="values"
                @saved="close"
            ></publish-form>

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
        components: { CreateButton, FormStack },

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
            }
        },

        data() {
            return {
                confirmZoneDeletion: false,
            }
        },

        mounted() {
            this.values.title = this.zone.title
        },

        methods: {

            close() {
                this.$emit('closed', true)
            },

            saved() {
                this.$emit('saved', true)
            },

            updateShippingZone() {
                axios.delete(`${this.route}/${this.zone.id}`)
                    .then(() => {
                        this.close()
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
        }
    }
</script>

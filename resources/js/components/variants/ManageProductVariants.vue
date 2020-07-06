<template>
    <div class="flex mt-6">
        <section class="flex-grow">
            <header class="flex mb-3 justify-between">
                <h1>Variants</h1>
                <create-button
                    :label="'New variant'"
                    :classes="'bg-white'"
                    @clicked="openCreateVariantStack"
                ></create-button>
            </header>

            <div class="publish-section">
                <table class="data-table">
                    <tbody>
                    <tr v-for="variant in variants" :class="{ 'bg-grey-30 opacity-75': ! variant.available }">
                        <td class="text-base">
                            {{ variant.title }}
                        </td>
                        <td>
                            <span class="flex items-center text-xs">
                                Price:
                                <svg v-if="variant.inherit_price" class="h-6 ml-1" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24"><path d="M10.082 9.5A4.47 4.47 0 0 0 6.75 8h-1.5a4.5 4.5 0 0 0 0 9h1.5a4.474 4.474 0 0 0 3.332-1.5M13.918 9.5A4.469 4.469 0 0 1 17.25 8h1.5a4.5 4.5 0 1 1 0 9h-1.5a4.472 4.472 0 0 1-3.332-1.5M6.75 12.499h10.5" fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"></path></svg>
                                <span v-else class="text-base ml-1">{{ variant.price }}</span>
                            </span>
                        </td>
                        <td>
                            <span class="flex items-center text-xs">
                                Stock:
                                <svg v-if="variant.inherit_stock" class="h-6 ml-1" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24"><path d="M10.082 9.5A4.47 4.47 0 0 0 6.75 8h-1.5a4.5 4.5 0 0 0 0 9h1.5a4.474 4.474 0 0 0 3.332-1.5M13.918 9.5A4.469 4.469 0 0 1 17.25 8h1.5a4.5 4.5 0 1 1 0 9h-1.5a4.472 4.472 0 0 1-3.332-1.5M6.75 12.499h10.5" fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"></path></svg>
                                <span v-else class="text-base ml-1">{{ variant.stock }}</span>
                            </span>
                        </td>
                        <td>
                            <toggle-input v-model="variant.available"></toggle-input>
                        </td>
                        <td>
                            <dropdown-list class="flex justify-end">
                                <dropdown-item
                                    :text="__('Edit')"
                                    @click="editVariant(variant)"/>
                                <dropdown-item
                                    :text="__('Delete')"
                                    class="warning"
                                    @click="deleteVariant(variant)"/>
                            </dropdown-list>
                        </td>
                    </tr>
                    <tr v-if="! variants || variants.length === 0">
                        <td colspan="3">No variants have been created yet.</td>
                    </tr>
                    </tbody>
                </table>
            </div>
        </section>

        <div class="hidden xl:block ml-2" style="width: 300px;">
            <!-- a little nasty something, so our container wont't fill up all the space -->
        </div>

        <form-stack
            name="variant stack"
            v-if="showVariantStack"
            :action="action"
            title="Variants"
            method="post"
            :blueprint="variantBlueprint"
            :meta="variantMeta"
            :values="stackValues"
            @closed="showVariantStack = false"
            @saved="closeVariantStack"
        ></form-stack>
    </div>
</template>

<script>
    import FormStack from "../stacks/Form"
    import axios from "axios";

    export default {
        components: { FormStack },

        props: {
            action: {
                type: String,
                default: '',
            },
            productSlug: {
                type: String,
                default: '',
            },
            variantIndexRoute: {
                type: String,
                default: '',
            },
            variantManageRoute: {
                type: String,
                default: '',
            },
            variantBlueprint: {
                type: Array,
                default: [],
            },
            variantMeta: {
                type: Array,
                default: [],
            },
            variantValues: {
                type: Array,
                default: [],
            }
        },

        data() {
            return {
                variants: {
                    type: Array,
                    default: [],
                },
                stackValues: {
                    type: Array,
                    default: [],
                },
                formMethod: 'post',
                showVariantStack: false,
            }
        },

        mounted() {
            this.stackValues = this.variantValues
            this.variants = this.fetchVariants()
        },

        methods: {
            openCreateVariantStack() {
                this.stackValues.product_slug = this.productSlug
                this.showVariantStack = true
            },

            closeVariantStack() {
                this.fetchVariants()
                this.showVariantStack = false
            },

            fetchVariants() {
                axios.get(this.variantIndexRoute)
                    .then(response => {
                        this.variants = response.data
                    }).catch(error => {
                        this.$toast.error(error)
                })
            },

            deleteVariant(variant) {
                console.log(variant)
                axios.delete(`${this.variantManageRoute}/${variant.id}`)
                    .then(response => {
                        this.$toast.success(__('Removed'))
                        this.fetchVariants()
                    }).catch(error => {
                        this.$toast.error(error)
                    })
            },
        }
    }
</script>


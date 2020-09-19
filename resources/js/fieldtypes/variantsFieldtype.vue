<template>
    <div class="flex">
        <section class="flex-grow">
            <header class="flex justify-end -mt-5 mb-2 w-full">
                <create-button
                    :label="'New variant'"
                    :classes="'bg-grey-30 z-0'"
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
                                    @click="openEditVariantStack(variant)"
                                ></dropdown-item>
                                <dropdown-item
                                    :text="__('Delete')"
                                    class="warning"
                                    @click="deleteVariant(variant)"
                                ></dropdown-item>
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

        <form-stack
            name="variant stack"
            v-if="showVariantStack"
            :action="stackAction"
            title="Variants"
            :blueprint="variantBlueprint"
            :meta="variantMeta"
            :method="stackMethod"
            :values="stackValues"
            @closed="showVariantStack = false"
            @saved="closeVariantStack"
        ></form-stack>
    </div>
</template>

<script>
    import FormStack from "../components/stacks/Form"
    import axios from "axios";

    export default {
        mixins: [Fieldtype],

        components: { FormStack },

        data() {
            return {
                action: this.meta.action,
                variants: this.meta.variants,
                variantIndexRoute: this.meta.variantIndexRoute,
                variantManageRoute: this.meta.variantManageRoute,
                variantBlueprint: this.meta.variantBlueprint,
                variantMeta: this.meta.variantMeta,
                variantValues: this.meta.variantValues,
                productSlug: this.meta.productSlug,
                showVariantStack: false,
                stackAction: null,
                stackMethod: 'post',
                stackValues: null,
            }
        },

        mounted() {
            this.fetchVariants()
        },

        methods: {
            fetchVariants() {
                console.log('fetch')
                axios.get(this.variantIndexRoute)
                    .then(response => {
                        console.log(response.data)
                        this.variants = response.data
                    }).catch(error => {
                        this.$toast.error(error)
                    })
            },

            openCreateVariantStack() {
                this.stackValues = this.variantValues
                this.stackValues.product_slug = this.productSlug
                this.stackMethod = 'post'
                this.stackAction = this.action
                this.showVariantStack = true
            },

            openEditVariantStack(variant) {
                this.stackValues = variant
                // We need to transform a , into a dot, to preprocess the values correct
                this.stackValues.price = variant.price.replace(',', '.')
                this.stackAction = `${this.action}/${variant.id}`
                this.stackMethod = 'patch'
                this.showVariantStack = true
            },

            closeVariantStack() {
                this.fetchVariants()
                this.showVariantStack = false
            },

            deleteVariant(variant) {
                axios.delete(`${this.variantManageRoute}/${variant.id}`)
                    .then(response => {
                        this.$toast.success(__('Removed'))
                        this.fetchVariants()
                    }).catch(error => {
                    this.$toast.error(error)
                })

                this.fetchVariants()
            },
        }
    }
</script>

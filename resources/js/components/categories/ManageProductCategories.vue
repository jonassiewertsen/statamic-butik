<template>
    <div class="flex mt-6 mb-6">
        <section class="flex-grow">
            <header class="flex justify-between mb-3">
                <h1>Categories</h1>
                <create-button
                    :label="'New category'"
                    :classes="'bg-white'"
                    @clicked="showNewCategory = ! showNewCategory"
                ></create-button>
            </header>

            <div v-if="showNewCategory" class="flex card mb-3">
                <input v-model="categoryName" class="input-text">
                <button @click="addCategory" class="btn-primary ml-2">{{ __('Save') }}</button>
            </div>

            <div class="publish-section">
                <table class="data-table">
                    <tbody>
                    <tr v-for="category in updatedCategories" :class="{ 'bg-grey-30 opacity-75': ! category.is_attached }">
                        <td class="pl-2 py-1 text-base">{{ category.name }}</td>
                        <td>
                            <toggle-input v-model="category.is_attached" @input="update(category)"></toggle-input>
                        </td>
                        <td>
                            <dropdown-list class="flex justify-end">
                                <dropdown-item
                                        :text="__('Delete')"
                                        class="warning"
                                        @click="deleteCategory(category)"/>
                            </dropdown-list>
                        </td>
                    </tr>
                    <tr v-if="updatedCategories.length === 0">
                        <td>No Categories have been created yet.</td>
                    </tr>
                    </tbody>
                </table>
            </div>
        </section>

        <div class="hidden xl:block ml-2" style="width: 300px;">
            <!-- a little nasty something, so our container wont't fill up all the space -->
        </div>
    </div>
</template>

<script>
    import axios from "axios";

    export default {
        props: {
            categories: {
                type: Array,
                default: [],
            },
            productSlug: {
                type: String,
                default: '',
            },
            categoryAttachRoute: {
                type: String,
                default: ''
            },
            categoryManageRoute: {
                type: String,
                default: ''
            },
            categoryName: {
                type: String,
                default: ''
            }
        },

        mounted() {
          this.updatedCategories = this.categories
        },

        data() {
            return {
                updatedCategories: [],
                showNewCategory: false,
            }
        },

        methods: {
            update(category) {
                if (category.is_attached) {
                    this.attachCategory(category)
                } else {
                    this.detachCategory(category)
                }
            },

            attachCategory(category) {
                axios.post(this.createAttachRoute(category))
                    .then(() => {
                        this.$toast.success(__('Saved'))
                    })
                    .catch(error => {
                        this.$toast.error(error)
                    })
            },

            detachCategory(category) {
                axios.delete(this.createAttachRoute(category))
                    .then(() => {
                        this.$toast.success(__('Saved'))
                    })
                    .catch(error => {
                        this.$toast.error(error)
                    })
            },

            deleteCategory(category) {
                axios.delete(this.categoryDeleteRoute(category))
                    .then(() => {
                        this.$toast.success(__('Deleted'))
                    })
                    .catch(error => {
                        this.$toast.error(error)
                    })

                this.categories.splice(category.slug, 1)
            },

            addCategory() {
                axios.post(this.categoryManageRoute, {
                        name: this.categoryName,
                        slug: this.categoryName.toLowerCase(),
                    })
                    .then(() => {
                        this.$toast.success(__('Saved'))
                    })
                    .catch(error => {
                        this.$toast.error(error)
                    })

                // Add the category to the list
                this.updatedCategories.push({
                    is_attached: false,
                    name: this.categoryName,
                    slug: this.categoryName.toLowerCase()
                })

                // Reset our name input
                this.categoryName = ''
            },

            createAttachRoute(category) {
                let route = this.categoryAttachRoute
                route = route.replace('x-category', category.slug)
                route = route.replace('x-product', this.productSlug)
                return route
            },

            categoryDeleteRoute(category) {
                return `${this.categoryManageRoute}/${category.slug}`
            }
        }
    }
</script>

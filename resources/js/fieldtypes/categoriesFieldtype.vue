<template>
    <div class="flex">
        <section v-if="! isCreateRoute" class="flex-grow">
            <header class="flex justify-end -mt-5 mb-2 w-full">
                <create-button
                    :label="'New category'"
                    :classes="'bg-grey-30 z-0'"
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
                    <tr v-for="category in categories" :class="{ 'bg-grey-30 opacity-75': ! category.is_attached }">
                        <td class="pl-2 py-1 text-base">{{ category.name }}</td>
                        <td>
                            <toggle-input v-model="category.is_attached" @input="update(category)"></toggle-input>
                        </td>
                        <td>
                            <dropdown-list class="flex justify-end">
                                <dropdown-item
                                    :text="__('Edit')"
                                    @click="openEditCategoryStack(category)"
                                ></dropdown-item>
                                <dropdown-item
                                    :text="__('Delete')"
                                    class="warning"
                                    @click="deleteCategory(category)"/>
                            </dropdown-list>
                        </td>
                    </tr>
                    <tr v-if="! categories || categories.length === 0">
                        <td colspan="3">No Categories have been created yet.</td>
                    </tr>
                    </tbody>
                </table>
            </div>
        </section>
        <section v-else class="w-full">
            <div class="publish-section">
                <table class="data-table">
                    <tbody>
                        <tr>
                            <td>You can create categories, after saving the product.</td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </section>

        <form-stack
            name="category stack"
            v-if="showCategoryStack"
            title="Edit this category"
            :action="categoryAction"
            :blueprint="categoryBlueprint"
            :meta="categoryMeta"
            :method="categoryMethod"
            :values="categoryValues"
            @closed="showCategoryStack = false"
            @saved="closeCategoryStack"
        ></form-stack>

    </div>
</template>

<script>
import axios from "axios";
import FormStack from "../components/stacks/Form";

export default {
    mixins: [Fieldtype],

    components: { FormStack },

    data() {
        return {
            categories: [],
            categoryIndexRoute: this.meta.categoryIndexRoute,
            categoryAttachRoute: this.meta.categoryAttachRoute,
            categoryManageRoute: this.meta.categoryManageRoute,
            productSlug: this.meta.productSlug,
            categoryName: '',
            showNewCategory: false,
            isCreateRoute: this.meta.isCreateRoute,
            showCategoryStack: false,
            categoryBlueprint: this.meta.categoryBlueprint,
            categoryValues: this.meta.categoryValues,
            categoryMeta: this.meta.categoryMeta,
            categoryMethod: 'patch',
        }
    },

    mounted() {
        if (! this.isCreateRoute) {
            this.categories = this.fetchCategories()
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

        fetchCategories() {
            axios.get(this.categoryIndexRoute)
                .then((response) => {
                    this.categories = response.data
                })
                .catch(error => {
                    this.$toast.error(error)
                })
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
                    this.fetchCategories()
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
                slug: this.categoryName.toLowerCase().replaceAll(' ', '-'),
            })
                .then(() => {
                    this.fetchCategories()
                    this.$toast.success(__('Saved'))
                })
                .catch(error => {
                    this.$toast.error(error)
                })

            // Add the category to the list
            this.categories.push({
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
        },

        openEditCategoryStack(category) {
            this.categoryValues = category
            this.categoryAction = `${this.categoryManageRoute}/${category.slug}`
            this.showCategoryStack = true
        },

        closeCategoryStack() {
            this.fetchCategories()
            this.showCategoryStack = false
        },
    }
}
</script>

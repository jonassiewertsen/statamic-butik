<template>
    <div class="flex">
        <section class="flex-grow">
            <header class="flex mb-3">
                <h1>Categories</h1>
                <create-button
                    :label="'New category'"
                    :classes="'bg-white ml-3'"
                    @clicked=""
                ></create-button>
            </header>

            <div class="publish-section">
                <table class="data-table">
                    <tbody>
                    <tr v-for="category in updatedCategories">
                        <th class="pl-2 py-1 w-1/4">{{ category.name }}</th>
                        <td>
                            <toggle-input v-model="category.is_attached" @input="update(category)"></toggle-input>
                        </td>
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
            route: {
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
                axios.post(this.createRoute(category))
                    .then(() => {
                        this.$toast.success(__('Saved'))
                    })
                    .catch(error => {
                        this.$toast.error(error)
                    })
            },

            detachCategory(category) {
                axios.delete(this.createRoute(category))
                    .then(() => {
                        this.$toast.success(__('Saved'))
                    })
                    .catch(error => {
                        this.$toast.error(error)
                    })
            },

            createRoute(category) {
                let route = this.route
                route = route.replace('x-category', category.slug)
                route = route.replace('x-product', this.productSlug)
                return route
            },
        }
    }
</script>

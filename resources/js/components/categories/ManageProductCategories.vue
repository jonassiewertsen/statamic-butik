<template>
    <section>
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
                <tr v-for="category in categories">
                    <th class="pl-2 py-1 w-1/4">{{ category.name }}</th>
                    <td>
                        <toggle-input @input=""></toggle-input>
                    </td>
                </tr>
                </tbody>
            </table>
        </div>
    </section>
</template>

<script>
    export default {
        props: {
            'categories': {
                type: Array,
                default: [],
            },
            'productSlug': {
                type: String,
                default: '',
            }
        },
    }
</script>

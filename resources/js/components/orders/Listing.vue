<template>
    <data-list :columns="columns" :sort="false" :rows="rows">
        <div class="card p-0" slot-scope="{ filteredRows: rows }">
            <data-list-table :rows="rows">
                <template slot="cell-id" slot-scope="{ row: collection }">
                    <a :href="collection.show_url">{{ collection.id }}</a>
                </template>
                <template slot="actions" slot-scope="{ row: collection, index }">
                    <dropdown-list>
                        <dropdown-item :text="__('Show')" :redirect="collection.show_url" />
                    </dropdown-list>
                </template>
            </data-list-table>
        </div>
    </data-list>
</template>

<script>
    import DeletesListingRow from '../DeletesListingRow.js'

    export default {

        mixins: [DeletesListingRow],

        props: [
            'initial-rows',
            'columns',
        ],

        data() {
            return {
                rows: this.initialRows
            }
        }

    }
</script>

<template>
    <data-list :columns="columns" :rows="rows">
        <div class="card p-0" slot-scope="{ filteredRows: rows }">
            <data-list-table :rows="rows">
                <template slot="cell-available" slot-scope="{ row: collection }">
                    <div v-if="collection.available" class="bg-green block h-3 w-2 mx-auto rounded-full"></div>
                    <div v-else class="bg-red block h-3 w-2 mx-auto rounded-full"></div>
                </template>
                <template slot="cell-title" slot-scope="{ row: collection }">
                    <a :href="collection.edit_url">{{ collection.title }}</a>
                </template>
                <template slot="cell-stock_unlimited" slot-scope="{ row: collection }">
                    <div class="ml-4">
                        <div v-if="collection.stock_unlimited" class="bg-green block h-3 w-2 rounded-full"></div>
                        <div v-else class="bg-grey-50 block h-3 w-2 rounded-full"></div>
                    </div>
                </template>
                <template slot="cell-stock" slot-scope="{ row: collection }">
                    <div class="mr-2">
                        <div v-if="collection.stock_unlimited">. . .</div>
                        <div v-else>{{ collection.stock }}</div>
                    </div>
                </template>
                <template slot="actions" slot-scope="{ row: collection, index }">
                    <dropdown-list>
                        <dropdown-item :text="__('Edit')" :redirect="collection.edit_url" />
                        <dropdown-item
                            v-if="collection.deleteable"
                            :text="__('Delete')"
                            class="warning"
                            @click="confirmDeleteRow(collection.slug, index)" />
                    </dropdown-list>

                    <confirmation-modal
                        v-if="deletingRow !== false"
                        :title="deletingModalTitle"
                        :bodyText="__('Are you sure you want to delete this product?')"
                        :buttonText="__('Delete')"
                        :danger="true"
                        @confirm="deleteRow('/cp/butik/products')"
                        @cancel="cancelDeleteRow"
                    >
                    </confirmation-modal>
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

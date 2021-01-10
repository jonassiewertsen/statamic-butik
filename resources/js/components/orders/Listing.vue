<template>
    <div>
        <div v-if="initializing" class="card loading">
            <loading-graphic />
        </div>

        <slot v-if="! loading && ! searchQuery && items.length === 0" name="no-results" />

        <data-list
            v-else-if="! initializing"
            :columns="columns"
            :rows="items"
            :sort="false"
            :sort-column="sortColumn"
            :sort-direction="sortDirection"
        >
            <div slot-scope="{ hasSelections }">
                <div class="relative p-0 card">
                    <div class="data-list-header min-h-16">
                        <data-list-filters
                            :search-query="searchQuery"
                            @search-changed="searchChanged"
                            @reset="filtersReset"
                        />
                    </div>

                    <div v-show="items.length === 0" class="p-3 text-center text-grey-50" v-text="__('No results')" />

                    <data-list-bulk-actions
                        :url="bulkActionsUrl"
                        @started="actionStarted"
                        @completed="actionCompleted"
                    />

                    <data-list-table
                        v-if="items.length"
                        :allow-bulk-actions="true"
                        :allow-column-picker="true"
                        :column-preferences-key="preferencesKey('columns')"
                        @sorted="sorted"
                    >
                        <template slot="cell-datestamp" slot-scope="{ row: submission, value }">
                            <a :href="submissionUrl(submission)" class="text-blue">{{ value }}</a>
                        </template>
                        <template slot="actions" slot-scope="{ row: submission, index }">
                            <dropdown-list>
                                <dropdown-item :text="__('View')" :redirect="submissionUrl(submission)" />
                                <data-list-inline-actions
                                    :item="submission.id"
                                    :url="runActionUrl"
                                    :actions="submission.actions"
                                    @started="actionStarted"
                                    @completed="actionCompleted"
                                />
                            </dropdown-list>
                        </template>
                    </data-list-table>
                </div>

                <data-list-pagination
                    class="mt-3"
                    :resource-meta="meta"
                    :per-page="perPage"
                    @page-selected="selectPage"
                    @per-page-changed="changePerPage"
                />
            </div>
        </data-list>
    </div>

</template>

<script>
import DeletesListingRow from '../DeletesListingRow.js'
export default {
    mixins: [DeletesListingRow, Listing],
    props: [
        'initial-rows',
        'columns',
    ],
    data() {
        return {
            rows: this.initialRows,
            requestUrl: cp_url('/butik/api/orders/get'),
        }
    },
    methods: {
        submissionUrl() {
            return cp_url('#');
        }
    }
}
</script>


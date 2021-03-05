<template>
    <div>
        <div v-if="initializing" class="card loading">
            <loading-graphic />
        </div>

        <data-list
            v-if="! initializing"
            :columns="columns"
            :rows="items"
            :sort="false"
            :sort-column="sortColumn"
            :sort-direction="sortDirection"
        >
            <div slot-scope="{ hasSelections }">
                <div class="card p-0 relative">
                    <div class="data-list-header">
                        <data-list-filters
                            :filters="filters"
                            :active-preset="activePreset"
                            :active-preset-payload="activePresetPayload"
                            :active-filters="activeFilters"
                            :active-filter-badges="activeFilterBadges"
                            :active-count="activeFilterCount"
                            :search-query="searchQuery"
                            :saves-presets="true"
                            :preferences-prefix="preferencesPrefix"
                            @filter-changed="filterChanged"
                            @search-changed="searchChanged"
                            @saved="$refs.presets.setPreset($event)"
                            @deleted="$refs.presets.refreshPresets()"
                            @restore-preset="$refs.presets.viewPreset($event)"
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
                        :loading="loading"
                        :allow-bulk-actions="true"
                        :allow-column-picker="true"
                        :column-preferences-key="preferencesKey('columns')"
                        @sorted="sorted"
                    >
                        <template slot="cell-name" slot-scope="{ row: order, value }">
                            <a :href="showUrl(order)">{{ value }}</a>
                        </template>
                        <template slot="actions" slot-scope="{ row: order, index }">
                            <dropdown-list>
                                <dropdown-item :text="__('View')" :redirect="showUrl(order)" />
                                <data-list-inline-actions
                                    :item="order.id"
                                    :url="runActionUrl"
                                    :actions="order.actions"
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

export default {
    mixins: [Listing],

    props: {
        ordersRequestUrl: '',
        showRoute: '',
    },

    data() {
        return {
            rows: this.initialRows,
            requestUrl: this.ordersRequestUrl,
            preferencesPrefix: 'butik.orders',
        }
    },

    methods: {
        showUrl(order) {
            return this.showRoute.replace('XXX', order.id)
        }
    },
}
</script>


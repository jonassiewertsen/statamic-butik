<template>
    <stack>
        <div class="h-full bg-white p-4 overflow-auto">
            <header class="pb-5 py-2 border-grey-30 text-lg font-medium flex items-center justify-between">
                <div class="flex items-center">
                    <h2>Manage Shipping Zones</h2>
                    <create-button
                        @clicked="openShippingZone"
                        :label="'Create shipping zone'"
                        :classes="'bg-grey-20 ml-4'"
                    ></create-button>
                </div>

                <button type="button" class="btn-close" @click="close">×</button>
            </header>

            <section>
                <header class="mb-1 flex items-start leading-none">
                    <svg class="mr-2 text-grey-70" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="10"></circle><line x1="2" y1="12" x2="22" y2="12"></line><path d="M12 2a15.3 15.3 0 0 1 4 10 15.3 15.3 0 0 1-4 10 15.3 15.3 0 0 1-4-10 15.3 15.3 0 0 1 4-10z"></path></svg>
                    <section>
                        <h3 class="block text-2xl">Zonen Name</h3>
                        <ul class="leading-loose text-grey-70">
                            <li>Deutschland</li>
                        </ul>
                    </section>
                </header>

                <div class="max-w-md mt-4 ml-5 -pl-1">
                    <table class="w-full leading-loose text-grey-70">
                        <tr class="text-left border-b-2 text-grey-80">
                            <th class="w-5/12 font-medium py-2 pl-1">Rate name</th>
                            <th class="w-4/12 font-medium py-2">Conditions</th>
                            <th class="w-2/12 font-medium py-2">Price</th>
                            <th class="w-1/12 font-medium py-2"></th>
                        </tr>
                        <tr class="border-b hover:bg-grey-10">
                            <td class="py-2 pl-1">Standard</td>
                            <td class="py-2">€ 0,00 - € 50,00</td>
                            <td class="py-2">€ 4,99</td>
                            <td class="text-right hover:text-grey-80 pr-1">
                                <button>
                                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-more-horizontal"><circle cx="12" cy="12" r="1"></circle><circle cx="19" cy="12" r="1"></circle><circle cx="5" cy="12" r="1"></circle></svg>
                                </button>
                            </td>
                        </tr>
                        <tr class="border-b hover:bg-grey-10">
                            <td class="py-2 pl-1">Standard</td>
                            <td class="py-2">€ 0,00 - € 50,00</td>
                            <td class="py-2">€ 4,99</td>
                            <td class="text-right hover:text-grey-80 pr-1">
                                <button>
                                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-more-horizontal"><circle cx="12" cy="12" r="1"></circle><circle cx="19" cy="12" r="1"></circle><circle cx="5" cy="12" r="1"></circle></svg>
                                </button>
                            </td>                        </tr>
                        <tr class="border-b hover:bg-grey-10">
                            <td class="py-2 pl-1">Standard</td>
                            <td class="py-2">€ 0,00 - € 50,00</td>
                            <td class="py-2">€ 4,99</td>
                            <td class="text-right hover:text-grey-80 pr-1">
                                <button>
                                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-more-horizontal"><circle cx="12" cy="12" r="1"></circle><circle cx="19" cy="12" r="1"></circle><circle cx="5" cy="12" r="1"></circle></svg>
                                </button>
                            </td>
                        </tr>
                    </table>

                    <create-button
                        :label="'Add rate'"
                        :classes="'bg-grey-20 mt-2 mr-auto'"
                        @clicked=""
                    ></create-button>

                </div>
            </section>

        </div>
    </stack>
</template>

<script>
    import CreateButton from "../../partials/CreateButton";
    export default {
        components: {CreateButton},
        props: ['slug'],

        methods: {
            close() {
                this.$emit('closed', true)
            },

            saved() {
                this.$emit('saved', true)
            },

            openShippingZone() {
                this.$emit('openShippingZone', true)
            },
        }
    }
</script>

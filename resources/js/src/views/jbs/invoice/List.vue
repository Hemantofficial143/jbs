<template>
    <div>
        <AddCustomer
            :is-add-new-customer-sidebar-active.sync="addCustomerSidebar"
            @refetch-data="getCustomer"
            ref="addCustomerSidebar"
        />
        <!-- Table Container Card -->
        <b-card
            no-body
            class="mb-0"
        >

            <div class="m-2">

                <!-- Table Top -->
                <b-row>
                    <!-- Search -->
                    <b-col
                        cols="12"
                        md="6"
                        lg="12"
                    >
                        <div class="d-flex align-items-center justify-content-end">
                            <b-form-input
                                v-model="searchQuery"
                                class="d-inline-block mr-1"
                                placeholder="Search..."
                            />
                            <b-button
                                variant="primary"
                                @click="addCustomerSidebar = true"
                            >
                                <span class="text-nowrap">Add Invoice</span>
                            </b-button>
                        </div>
                    </b-col>
                </b-row>

            </div>

            <b-table
                ref="refUserListTable"
                class="position-relative"
                :items="records"
                responsive
                :fields="header"
                show-empty
                empty-text="No matching records found"
            >
                <template #cell(customer)="data">
                    {{ data.item.customer.name }}
                </template>
                <template #cell(actions)="data">
                    <b-button :to="{ name : 'invoices-preview',params : {id : data.item.id}}"  variant="flat-primary">
                        PDF
                    </b-button>
                    <b-button @click="$router.push({ name : 'invoices-edit',params : {id : data.item.id}})"  variant="flat-primary">
                        <feather-icon icon="ListIcon" />
                    </b-button>
                    <b-button @click="editCustomer(data.item)"  variant="flat-primary">
                        <feather-icon icon="EditIcon" />
                    </b-button>
                    <b-button @click="deleteCustomer(data.item)"  variant="flat-danger">
                        <feather-icon icon="TrashIcon" />
                    </b-button>
                </template>

            </b-table>
        </b-card>
    </div>
</template>

<script>
import {
    BCard,
    BRow,
    BCol,
    BFormInput,
    BButton,
    BTable,
    BMedia,
    BAvatar,
    BLink,
    BBadge,
    BDropdown,
    BDropdownItem,
    BPagination,
} from 'bootstrap-vue'
import vSelect from 'vue-select'
import store from '@/store'
import { ref, onUnmounted } from '@vue/composition-api'
import { avatarText } from '@core/utils/filter'
import AddCustomer from './AddSidebar.vue'

export default {
    components: {
        AddCustomer,
        BCard,
        BRow,
        BCol,
        BFormInput,
        BButton,
        BTable,
        BMedia,
        BAvatar,
        BLink,
        BBadge,
        BDropdown,
        BDropdownItem,
        BPagination,

        vSelect,
    },
    data() {
        return {
            searchQuery : null,
            addCustomerSidebar : false,
            records : [
            ],
            header: [
                {
                    key: 'invoice_number',
                    label : 'Mobile',
                    sortable: true
                },
                {
                    key: 'customer',
                    label : 'customer',
                    sortable: true
                },
                {
                    key: 'address',
                    label : 'Address',
                    sortable: true
                },
                {
                    key: 'invoice_date',
                    label : 'Created Date',
                    sortable: true
                },
                { key: 'actions' },
            ]
        }
    },
    methods : {
        deleteCustomer(data){
            this.deleteSwal('customer').then(response => {
                this.$http.post(`customer/delete/${data.id}`).then(response => {
                    if(response.success){
                        this.getCustomer()
                    }
                })
            })
        },
        editCustomer(data){
            this.$refs.addCustomerSidebar.setUpdateData(data)
            this.addCustomerSidebar = true
        },
        getCustomer(){
            this.$http.post('invoice/get').then(response => {
                if(response.success){
                    this.records = response.data
                }
            })
        }
    },
    mounted(){
        this.getCustomer()
    }
}
</script>

<style lang="scss" scoped>
.per-page-selector {
    width: 90px;
}
</style>

<style lang="scss">
@import '~@resources/scss/vue/libs/vue-select.scss';
</style>

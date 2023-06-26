<template>
    <section class="invoice-preview-wrapper">

        <b-row class="invoice-add">

            <!-- Col: Left (Invoice Container) -->
            <b-col
                cols="12"
                xl="9"
                md="8"
            >
                <b-form @submit.prevent>
                    <b-card
                        no-body
                        class="invoice-preview-card"
                    >
                        <!-- Header -->
                        <b-card-body class="invoice-padding pb-0">

                            <div class="d-flex justify-content-between flex-md-row flex-column invoice-spacing mt-0">

                                <!-- Header: Left Content -->
                                <div>
                                    <div class="logo-wrapper">
                                        <logo/>
                                        <h3 class="text-primary invoice-logo">
                                            Vuexy
                                        </h3>
                                    </div>
                                    <b-card-text class="mb-25">
                                        Office 149, 450 South Brand Brooklyn
                                    </b-card-text>
                                    <b-card-text class="mb-25">
                                        San Diego County, CA 91905, USA
                                    </b-card-text>
                                    <b-card-text class="mb-0">
                                        +1 (123) 456 7891, +44 (876) 543 2198
                                    </b-card-text>
                                </div>

                                <!-- Header: Right Content -->
                                <div class="invoice-number-date mt-md-0 mt-2">
                                    <div class="d-flex align-items-center justify-content-md-end mb-1">
                                        <h4 class="invoice-title">
                                            Invoice
                                        </h4>
                                        <b-input-group class="input-group-merge invoice-edit-input-group disabled">
                                            <b-input-group-prepend is-text>
                                                <feather-icon icon="HashIcon"/>
                                            </b-input-group-prepend>
                                            <b-form-input
                                                id="invoice-data-id"
                                                v-model="invoice.invoice_number"
                                                disabled
                                            />
                                        </b-input-group>
                                    </div>
                                    <div class="d-flex align-items-center mb-1">
                                        <span class="title">
                                          Date:
                                        </span>
                                        <b-input-group class="input-group-merge invoice-edit-input-group disabled">
                                            <b-input-group-prepend is-text>
                                                <feather-icon icon="CalendarIcon"/>
                                            </b-input-group-prepend>
                                            <b-form-input
                                                id="invoice-data-date"
                                                v-model="invoice.invoice_date"
                                                disabled
                                            />
                                        </b-input-group>
                                    </div>

                                </div>
                            </div>
                        </b-card-body>

                        <!-- Spacer -->
                        <hr class="invoice-spacing">

                        <!-- Invoice Client & Payment Details -->
                        <b-card-body
                            class="invoice-padding pt-0"
                        >
                            <b-row class="invoice-spacing">


                                <b-col
                                    cols="12"
                                    xl="6"
                                    class="mb-lg-1"
                                >
                                    <h6 class="mb-2">
                                        Invoice To:
                                    </h6>

                                    <!-- Selected Client -->
                                    <div
                                        v-if="invoice.customer"
                                        class="mt-1"
                                    >
                                        <h6 class="mb-25">
                                            {{ invoice.customer.name }}
                                        </h6>
                                        <!--                                        <b-card-text class="mb-25">
                                                                                    {{ invoiceData.client.company }}
                                                                                </b-card-text>-->
                                        <b-card-text class="mb-25">
                                            {{ invoice.customer.address }}
                                        </b-card-text>
                                        <b-card-text class="mb-25">
                                            {{ invoice.customer.mobile }}
                                        </b-card-text>
                                        <b-card-text class="mb-0">
                                            {{ invoice.customer.email }}
                                        </b-card-text>
                                    </div>
                                </b-col>

                                <!-- Col: Payment Details -->
                                <b-col
                                    xl="6"
                                    cols="12"
                                    class="mt-xl-0 mt-2 justify-content-end d-xl-flex d-block"
                                >
                                    <!--                                    <div>
                                                                            <h6 class="mb-2">
                                                                                Payment Details:
                                                                            </h6>
                                                                            <table>
                                                                                <tbody>
                                                                                <tr>
                                                                                    <td class="pr-1">
                                                                                        Total Due:
                                                                                    </td>
                                                                                    <td><span class="font-weight-bold">$12,110.55</span></td>
                                                                                </tr>
                                                                                <tr>
                                                                                    <td class="pr-1">
                                                                                        Bank name:
                                                                                    </td>
                                                                                    <td>American Bank</td>
                                                                                </tr>
                                                                                <tr>
                                                                                    <td class="pr-1">
                                                                                        Country:
                                                                                    </td>
                                                                                    <td>United States</td>
                                                                                </tr>
                                                                                <tr>
                                                                                    <td class="pr-1">
                                                                                        IBAN:
                                                                                    </td>
                                                                                    <td>ETD95476213874685</td>
                                                                                </tr>
                                                                                <tr>
                                                                                    <td class="pr-1">
                                                                                        SWIFT code:
                                                                                    </td>
                                                                                    <td>BR91905</td>
                                                                                </tr>
                                                                                </tbody>
                                                                            </table>
                                                                        </div>-->
                                </b-col>
                            </b-row>
                        </b-card-body>

                        <!-- Items Section -->
                        <b-card-body class="invoice-padding form-item-section">
                            <div
                                ref="form"
                                class="repeater-form"
                                :style="{height: trHeight}"
                            >
                                <b-row
                                    v-for="(item, index) in invoice.items"
                                    :key="index"
                                    ref="row"
                                    class="pb-2"
                                >

                                    <!-- Item Form -->
                                    <!-- ? This will be in loop => So consider below markup for single item -->
                                    <b-col cols="12">
                                        <div class="d-none d-lg-flex">
                                            <b-row class="flex-grow-1 px-1">
                                                <!-- Single Item Form Headers -->
                                                <b-col
                                                    cols="12"
                                                    lg="4"
                                                >
                                                    Item
                                                </b-col>
                                                <b-col
                                                    cols="12"
                                                    lg="1"
                                                >
                                                    Type
                                                </b-col>
                                                <b-col
                                                    cols="12"
                                                    lg="1"
                                                >
                                                    Height
                                                </b-col>
                                                <b-col
                                                    cols="12"
                                                    lg="1"
                                                >
                                                    Width
                                                </b-col>
                                                <b-col
                                                    cols="12"
                                                    lg="2"
                                                >
                                                    Rate
                                                </b-col>
                                                <b-col
                                                    cols="12"
                                                    lg="1"
                                                >
                                                    Qty
                                                </b-col>
                                                <b-col
                                                    cols="12"
                                                    lg="2"
                                                >
                                                    Total
                                                </b-col>
                                            </b-row>
                                            <div class="form-item-action-col"/>
                                        </div>
                                        <div class="d-flex border rounded">
                                            <b-row class="flex-grow-1 p-2">


                                                <!--Item Name-->
                                                <b-col
                                                    cols="12"
                                                    lg="4"
                                                >
                                                    <label class="d-inline d-lg-none">Item</label>
                                                    <b>{{invoice.items[index].item_name }}</b>
                                                </b-col>

                                                <!--Type-->
                                                <b-col
                                                    cols="12"
                                                    lg="1"
                                                >
                                                    <label class="d-inline d-lg-none">Type</label>
                                                    <b>{{invoice.items[index].type }}</b>
                                                </b-col>

                                                <!--Height-->
                                                <b-col
                                                    cols="12"
                                                    lg="1"
                                                >
                                                    <label class="d-inline d-lg-none">Height</label>
                                                    <b>{{ invoice.items[index].height != null ?
                                                        invoice.items[index].height : '-' }}</b>
                                                </b-col>

                                                <!--Width-->
                                                <b-col
                                                    cols="12"
                                                    lg="1"
                                                >
                                                    <label class="d-inline d-lg-none">Width</label>
                                                    <b>{{ invoice.items[index].width != null ?
                                                        invoice.items[index].width : '-' }}</b>
                                                </b-col>

                                                <!--Rate-->
                                                <b-col
                                                    cols="12"
                                                    lg="2"
                                                >
                                                    <label class="d-inline d-lg-none">Rate</label>
                                                    <b>₹ {{ invoice.items[index].rate }}</b>

                                                </b-col>

                                                <!--Qty-->
                                                <b-col
                                                    cols="12"
                                                    lg="1"
                                                >
                                                    <label class="d-inline d-lg-none">Qty</label>
                                                    <b>{{ invoice.items[index].qty }}</b>

                                                </b-col>

                                                <!--Total Amount-->
                                                <b-col
                                                    cols="12"
                                                    lg="2"
                                                >
                                                    <label class="d-inline d-lg-none">Total</label>
                                                    <b>₹ {{ currency(invoice.items[index].total) }}</b>

                                                </b-col>

                                                <!--Description-->
                                                <b-col
                                                    cols="12"
                                                    lg="4"
                                                >
                                                    <label class="d-inline d-lg-none">Description</label>
                                                    <small class="mt-1">{{ invoice.items[index].item_description
                                                        }}</small>

                                                </b-col>

                                            </b-row>
                                            <div
                                                class="d-flex flex-column justify-content-between border-left py-50 px-25"
                                            >
                                                <feather-icon
                                                    size="16"
                                                    icon="XIcon"
                                                    class="cursor-pointer"
                                                    @click="removeItem(invoice.items[index],index)"
                                                />
<!--                                                <feather-icon
                                                    :id="`form-item-settings-icon-${index}`"
                                                    size="16"
                                                    icon="SettingsIcon"
                                                    class="cursor-pointer"
                                                />-->
                                            </div>
                                        </div>
                                    </b-col>
                                </b-row>

                                <b-row>
                                    <validation-observer
                                        ref="addItemValidator"
                                    >
                                        <b-col cols="12">
                                            <div class="d-none d-lg-flex">
                                                <b-row class="flex-grow-1 px-1">
                                                    <!-- Single Item Form Headers -->
                                                    <b-col
                                                        cols="12"
                                                        lg="4"
                                                    >
                                                        Item
                                                    </b-col>
                                                    <b-col
                                                        cols="12"
                                                        lg="1"
                                                    >
                                                        Type
                                                    </b-col>
                                                    <b-col
                                                        cols="12"
                                                        lg="1"
                                                    >
                                                        Height
                                                    </b-col>
                                                    <b-col
                                                        cols="12"
                                                        lg="1"
                                                    >
                                                        Width
                                                    </b-col>
                                                    <b-col
                                                        cols="12"
                                                        lg="2"
                                                    >
                                                        Rate
                                                    </b-col>
                                                    <b-col
                                                        cols="12"
                                                        lg="1"
                                                    >
                                                        Qty
                                                    </b-col>
                                                    <b-col
                                                        cols="12"
                                                        lg="2"
                                                    >
                                                        Total
                                                    </b-col>
                                                </b-row>
                                                <div class="form-item-action-col"/>
                                            </div>
                                            <div class="d-flex border rounded">
                                                <b-row class="flex-grow-1 p-2">


                                                    <!--Item Name-->
                                                    <b-col
                                                        cols="12"
                                                        lg="4"
                                                    >
                                                        <label class="d-inline d-lg-none">Item</label>
                                                        <validation-provider
                                                            #default="{ errors }"
                                                            name="Item name"
                                                            rules="required"
                                                        >
                                                            <b-form-input v-model="add.item_name"/>
                                                            <small class="text-danger">{{ errors[0] }}</small>
                                                        </validation-provider>

                                                    </b-col>

                                                    <!--Type-->
                                                    <b-col
                                                        cols="12"
                                                        lg="1"
                                                    >
                                                        <label class="d-inline d-lg-none">Type</label>
                                                        <validation-provider
                                                            #default="{ errors }"
                                                            name="Measure type"
                                                            rules="required"
                                                        >
                                                            <b-form-select
                                                                v-model="add.type"
                                                                type="number"
                                                                :options="['PW','SF','RF']"
                                                                class="mb-2"
                                                            />
                                                            <small class="text-danger">{{ errors[0] }}</small>
                                                        </validation-provider>

                                                    </b-col>

                                                    <!--Height-->
                                                    <b-col
                                                        cols="12"
                                                        lg="1"
                                                    >
                                                        <label class="d-inline d-lg-none">Height</label>

                                                        <validation-provider
                                                            #default="{ errors }"
                                                            name="height"
                                                            :rules="`${heightDisabled ? null : 'required'}`"
                                                        >
                                                            <b-form-input v-model="add.height"
                                                                          :disabled="heightDisabled"
                                                            />
                                                            <small class="text-danger">{{ errors[0] }}</small>
                                                        </validation-provider>

                                                    </b-col>

                                                    <!--Width-->
                                                    <b-col
                                                        cols="12"
                                                        lg="1"
                                                    >
                                                        <label class="d-inline d-lg-none">Width</label>

                                                        <validation-provider
                                                            #default="{ errors }"
                                                            name="height"
                                                            :rules="`${widthDisabled ? null : 'required'}`"
                                                        >
                                                            <b-form-input v-model="add.width"
                                                                          :disabled="widthDisabled"
                                                            />
                                                            <small class="text-danger">{{ errors[0] }}</small>
                                                        </validation-provider>

                                                    </b-col>

                                                    <!--Rate-->
                                                    <b-col
                                                        cols="12"
                                                        lg="2"
                                                    >
                                                        <label class="d-inline d-lg-none">Rate</label>
                                                        <validation-provider
                                                            #default="{ errors }"
                                                            name="rate"
                                                            rules="required"
                                                        >
                                                            <b-input-group
                                                                prepend="₹"
                                                                class="input-group-merge"
                                                            >
                                                                <b-form-input type="number" step="0.1" v-model="add.rate"/>
                                                            </b-input-group>
                                                            <small class="text-danger">{{ errors[0] }}</small>
                                                        </validation-provider>

                                                    </b-col>

                                                    <!--Qty-->
                                                    <b-col
                                                        cols="12"
                                                        lg="1"
                                                    >
                                                        <label class="d-inline d-lg-none">Qty</label>
                                                        <validation-provider
                                                            #default="{ errors }"
                                                            name="quantity"
                                                            rules="required"
                                                        >
                                                            <b-form-input type="number" step="0.1" v-model="add.qty"/>
                                                            <small class="text-danger">{{ errors[0] }}</small>
                                                        </validation-provider>

                                                    </b-col>

                                                    <!--Total Amount-->
                                                    <b-col
                                                        cols="12"
                                                        lg="2"
                                                    >
                                                        <label class="d-inline d-lg-none">Rate</label>
                                                         {{add.total != null ? `₹ ${currency(add.total)}` : null}}

                                                    </b-col>

                                                    <!--Description-->
                                                    <b-col
                                                        cols="12"
                                                        lg="4"
                                                    >
                                                        <label class="d-inline d-lg-none">Description</label>
                                                        <b-form-textarea
                                                            v-model="add.item_description"
                                                            class="mb-2 mb-lg-0"
                                                        />
                                                    </b-col>
                                                </b-row>

<!--                                                <div
                                                    class="d-flex flex-column justify-content-between border-left py-50 px-25"
                                                >
                                                    <feather-icon
                                                        size="16"
                                                        icon="XIcon"
                                                        class="cursor-pointer"
                                                        @click="removeItem(index)"
                                                    />
                                                    <feather-icon
                                                        :id="`form-item-settings-icon-${index}`"
                                                        size="16"
                                                        icon="SettingsIcon"
                                                        class="cursor-pointer"
                                                    />

                                                </div>-->
                                            </div>
                                        </b-col>
                                        <b-col cols="12">
                                            <b-button
                                                class="mt-1"
                                                v-ripple.400="'rgba(255, 255, 255, 0.15)'"
                                                size="sm"
                                                variant="primary"
                                                @click="saveItem"
                                            >
                                                Save Item
                                            </b-button>
                                        </b-col>
                                    </validation-observer>
                                </b-row>

                            </div>
                            <!--                            <b-button
                                                            v-ripple.400="'rgba(255, 255, 255, 0.15)'"
                                                            size="sm"
                                                            variant="primary"
                                                            @click="addNewItemInItemForm"
                                                        >
                                                            Add Item
                                                        </b-button>-->
                        </b-card-body>

                        <!-- Invoice Description: Total -->
                        <b-card-body class="invoice-padding pb-0">
                            <b-row>

                                <!-- Col: Sales Persion -->
                                <b-col
                                    cols="12"
                                    md="6"
                                    class="mt-md-0 mt-3 d-flex align-items-center"
                                    order="2"
                                    order-md="1"
                                >
                                    <!--                                    <label
                                                                            for="invoice-data-sales-person"
                                                                            class="text-nowrap mr-50"
                                                                        >Sales Person:</label>
                                                                        <b-form-input
                                                                            id="invoice-data-sales-person"
                                                                            v-model="invoiceData.salesPerson"
                                                                            placeholder="Edward Crowley"
                                                                        />-->
                                </b-col>

                                <!-- Col: Total -->
                                <b-col
                                    cols="12"
                                    md="6"
                                    class="mt-md-6 d-flex justify-content-end"
                                    order="1"
                                    order-md="2"
                                >
                                    <div class="invoice-total-wrapper">
                                        <div class="invoice-total-item">
                                            <p class="invoice-total-title">
                                                Subtotal:
                                            </p>
                                            <p class="invoice-total-amount">
                                                ₹ {{ totalAmount }}
                                            </p>
                                        </div>
                                        <hr class="my-50">
                                        <div class="invoice-total-item">
                                            <p class="invoice-total-title">
                                                Total:
                                            </p>
                                            <p class="invoice-total-amount">
                                                ₹ {{ totalAmount }}
                                            </p>
                                        </div>
                                    </div>
                                </b-col>
                            </b-row>
                        </b-card-body>

                        <!-- Spacer -->
                        <hr class="invoice-spacing">

                        <!-- Note -->
                        <b-card-body class="invoice-padding pt-0">
                            <span class="font-weight-bold">Note: </span>
                            <b-form-textarea v-model="invoiceData.note"/>
                        </b-card-body>
                    </b-card>
                </b-form>
            </b-col>

            <!-- Right Col: Card -->
            <b-col
                cols="12"
                md="4"
                xl="3"
                class="invoice-actions mt-md-0 mt-2"
            >

                <!-- Action Buttons -->
                <b-card>



                    <b-button
                        v-ripple.400="'rgba(113, 102, 240, 0.15)'"
                        variant="outline-primary"
                        class="mb-75"
                        block
                        @click="$router.push({name : 'invoices-preview',params : {id : $route.params.id }})"
                    >
                        <feather-icon icon="FileTextIcon" />
                        Preview
                    </b-button>


                    <b-button
                        v-ripple.400="'rgba(113, 102, 240, 0.15)'"
                        variant="outline-primary"
                        block
                    >
                        <feather-icon icon="SaveIcon" />
                        Save
                    </b-button>
                </b-card>

            </b-col>
        </b-row>
    </section>
</template>

<script>
import Logo from '@core/layouts/components/Logo.vue'
import { ref, onUnmounted } from '@vue/composition-api'
import { heightTransition } from '@core/mixins/ui/transition'
import Ripple from 'vue-ripple-directive'
import store from '@/store'
import {
    BRow,
    BCol,
    BCard,
    BCardBody,
    BButton,
    BCardText,
    BForm,
    BFormGroup,
    BFormInput,
    BInputGroup,
    BInputGroupPrepend,
    BFormTextarea,
    BFormCheckbox,
    BPopover,
    VBToggle,
    BFormSelect
} from 'bootstrap-vue'
import vSelect from 'vue-select'
import flatPickr from 'vue-flatpickr-component'
import invoiceStoreModule from './invoiceStoreModule'
import axiosIns from '../../../libs/axios'
import { ValidationProvider, ValidationObserver } from 'vee-validate'
import { required, email } from '@validations'

export default {
    components: {
        ValidationProvider,
        ValidationObserver,
        BFormSelect,
        BRow,
        BCol,
        BCard,
        BCardBody,
        BButton,
        BCardText,
        BForm,
        BFormGroup,
        BFormInput,
        BInputGroup,
        BInputGroupPrepend,
        BFormTextarea,
        BFormCheckbox,
        BPopover,
        flatPickr,
        vSelect,
        Logo,
    },
    directives: {
        Ripple,
        'b-toggle': VBToggle,
    },
    mixins: [heightTransition],
    mounted() {
        this.fetchInvoiceData()
        this.initTrHeight()
    },
    created() {
        window.addEventListener('resize', this.initTrHeight)
    },

    destroyed() {
        window.removeEventListener('resize', this.initTrHeight)
    },
    watch: {
        'add.type'() {
            this.calculateTotalAmount()
        },
        'add.height'() {
            this.calculateTotalAmount()
        },
        'add.width'() {
            this.calculateTotalAmount()
        },
        'add.rate'() {
            this.calculateTotalAmount()
        },
        'add.qty'() {
            this.calculateTotalAmount()
        },
    },
    computed: {
        heightDisabled() {
            return this.add.type != null && (this.add.type == 'PW' || this.add.type == 'RF')
        },
        widthDisabled() {
            return this.add.type != null && this.add.type == 'PW'
        },
        totalAmount(){
            let $amount = 0
            if(this.invoice != null){
                if(this.invoice.items.length > 0){
                    let $calculatedArray = this.invoice.items.map(record => record.total)
                    $amount = $calculatedArray.reduce((partialSum, a) => partialSum + a, 0);
                }
            }
            return this.currency($amount);
        }
    },
    data() {
        return {
            invoice: null,
            add: {
                item_name: null,
                item_description: null,
                type: null,
                height: null,
                width: null,
                rate: null,
                qty: null,
                total: null,
            }
        }
    },
    methods: {
        saveItem() {

            this.$refs.addItemValidator.validate()
                .then(response => {
                    if (response) {
                        axiosIns.post(`/invoice-item/store/${this.$route.params.id}`, this.add)
                            .then(response => {
                                if (response.success) {
                                    this.showToaster(response.message, response.success)
                                    this.invoice.items.push(response.data)
                                    this.add = {
                                        item_name: null,
                                        item_description: null,
                                        type: null,
                                        height: null,
                                        width: null,
                                        rate: null,
                                        qty: null,
                                        total: null,
                                    }
                                }
                            })
                    }
                })

        },
        calculateTotalAmount() {
            let $amount = 0
            if (this.add.type != null) {
                switch (this.add.type) {
                    case 'PW':
                        $amount = this.add.qty * this.add.rate
                        break
                    case 'SF':
                        let inches = (this.add.width * this.add.height) / 144
                        $amount = (inches * this.add.rate) * this.add.qty
                        break
                    case 'RF':
                        $amount = ((this.add.width / 12) * this.add.rate) * this.add.qty
                        break
                }
            }
            this.add.total = $amount
        },
        fetchInvoiceData() {
            axiosIns.post(`invoice/show/${this.$route.params.id}`)
                .then(response => {
                    this.invoice = response.data
                })
        },
        addNewItemInItemForm() {
            this.$refs.form.style.overflow = 'hidden'
            this.invoice.items.push(JSON.parse(JSON.stringify(this.itemFormBlankItem)))
        },
        removeItem(data,index) {
            this.deleteSwal('invoice item').then(response => {
                if(response){
                    axiosIns.post(`invoice-item/delete/${data.id}`).then(response => {
                        if(response.success){
                            this.showToaster(response.message,response.success)
                            this.invoice.items.splice(index,1)
                        }
                    })
                }
            })
        },
        initTrHeight() {
            this.trSetHeight(null)
            this.$nextTick(() => {
                this.trSetHeight(this.$refs.form.scrollHeight)
            })
        },
    },
    setup() {
        const INVOICE_APP_STORE_MODULE_NAME = 'app-invoice'

        // Register module
        if (!store.hasModule(INVOICE_APP_STORE_MODULE_NAME)) {
            store.registerModule(INVOICE_APP_STORE_MODULE_NAME, invoiceStoreModule)
        }

        // UnRegister on leave
        onUnmounted(() => {
            if (store.hasModule(INVOICE_APP_STORE_MODULE_NAME)) store.unregisterModule(INVOICE_APP_STORE_MODULE_NAME)
        })

        const clients = ref([])
        store.dispatch('app-invoice/fetchClients')
            .then(response => {
                clients.value = response.data
            })

        const itemFormBlankItem = {
            item: null,
            cost: 0,
            qty: 0,
            description: '',
        }

        const invoiceData = ref({
            id: 5037,
            client: null,

            // ? Set single Item in form for adding data
            items: [JSON.parse(JSON.stringify(itemFormBlankItem))],

            salesPerson: '',
            note: 'It was a pleasure working with you and your team. We hope you will keep us in mind for future freelance projects. Thank You!',
            paymentMethod: null,
        })

        const itemsOptions = [
            {
                itemTitle: 'App Design',
                cost: 24,
                qty: 1,
                description: 'Designed UI kit & app pages.',
            },
            {
                itemTitle: 'App Customization',
                cost: 26,
                qty: 1,
                description: 'Customization & Bug Fixes.',
            },
            {
                itemTitle: 'ABC Template',
                cost: 28,
                qty: 1,
                description: 'Bootstrap 4 admin template.',
            },
            {
                itemTitle: 'App Development',
                cost: 32,
                qty: 1,
                description: 'Native App Development.',
            },
        ]

        const updateItemForm = (index, val) => {
            const {
                cost,
                qty,
                description
            } = val
            invoiceData.value.items[index].cost = cost
            invoiceData.value.items[index].qty = qty
            invoiceData.value.items[index].description = description
        }

        const paymentMethods = ['Bank Account', 'PayPal', 'UPI Transfer']

        return {
            invoiceData,
            clients,
            itemsOptions,
            updateItemForm,
            itemFormBlankItem,
            paymentMethods,
        }
    },
}
</script>

<style lang="scss">
@import '~@resources/scss/vue/libs/vue-select.scss';
@import '~@resources/scss/vue/libs/vue-flatpicker.scss';

.invoice-add-wrapper {
    .add-new-client-header {
        padding: $options-padding-y $options-padding-x;
        color: $success;

        &:hover {
            background-color: rgba($success, 0.12);
        }
    }
}
</style>

<style lang="scss" scoped>
@import '~@resources/scss/base/pages/app-invoice.scss';
@import '~@resources/scss/base/components/variables-dark';

.form-item-section {
    background-color: $product-details-bg;
}

.form-item-action-col {
    width: 27px;
}

.repeater-form {
    // overflow: hidden;
    transition: 0.35s height;
}

.v-select {
    &.item-selector-title,
    &.payment-selector {
        background-color: #fff;

        .dark-layout & {
            background-color: unset;
        }
    }
}

.dark-layout {
    .form-item-section {
        background-color: $theme-dark-body-bg;

        .row .border {
            background-color: $theme-dark-card-bg;
        }
    }
}
</style>

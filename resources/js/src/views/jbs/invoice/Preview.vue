<template>
    <section class="invoice-preview-wrapper">

        <!-- Alert: No item found -->



        <b-row
            v-if="invoiceData"
            class="invoice-preview"
        >

            <!-- Col: Left (Invoice Container) -->
            <b-col
                cols="12"
                xl="9"
                md="8"
            >
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
                                    <h3 class="text-primary invoice-logo ml-0" >
                                        JANGID FURNITURE
                                    </h3>
                                </div>
                            </div>

                            <!-- Header: Right Content -->
                            <div class="mt-md-0 mt-2">
                                <h4 class="invoice-title mb-1">
                                    Invoice:
                                    <span class="invoice-number">#{{ invoiceData.invoice_number }}</span>
                                </h4>

                                <div class="invoice-date-wrapper">
                                    <p class="invoice-date-title">
                                        Date Issued:
                                    </p>
                                    <p class="invoice-date">
                                        {{ invoiceData.invoice_date }}
                                    </p>
                                </div>
                            </div>
                        </div>
                    </b-card-body>

                    <!-- Spacer -->
                    <hr class="invoice-spacing">

                    <!-- Invoice Client & Payment Details -->
                    <b-card-body
                        v-if="invoiceData.customer"
                        class="invoice-padding pt-0"
                    >
                        <b-row class="invoice-spacing">

                            <!-- Col: Invoice To -->
                            <b-col
                                cols="12"
                                xl="6"
                                class="p-0"
                            >
                                <h6 class="mb-2">
                                    Invoice To:
                                </h6>
                                <h6 class="mb-25">
                                    {{ invoiceData.customer.name }}
                                </h6>
                                <p class="card-text mb-25">
                                    {{ invoiceData.address }}
                                </p>
                                <p class="card-text mb-25">
                                    {{ invoiceData.customer.mobile }}
                                </p>
                                <p class="card-text mb-0">
                                    {{ invoiceData.customer.email }}
                                </p>
                            </b-col>

                            <!-- Col: Payment Details -->
                            <b-col
                                xl="6"
                                cols="12"
                                class="p-0 mt-xl-0 mt-2 d-flex justify-content-xl-end"
                            >

                                <div class="text-right">
                                    <h6 class="mb-2">
                                        Invoice From:
                                    </h6>
                                    <table>
                                        <tbody>
                                        <tr>
                                            <td>
                                                <h6>{{invoiceData.user.name}}</h6>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>
                                                <h6>{{invoiceData.user.address}}</h6>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>
                                                <h6>{{invoiceData.user.mobile}}</h6>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>
                                                <h6>{{invoiceData.user.email}}</h6>
                                            </td>
                                        </tr>
                                        </tbody>
                                    </table>
                                </div>

                            </b-col>
                        </b-row>
                    </b-card-body>

                    <!-- Invoice Description: Table -->
                    <b-table
                        responsive
                        :items="invoiceData.items"
                        :fields="['item', 'type', 'height','width','rate','qty', 'total']"
                    >
                        <template #cell(type)="data">
                            <b-card-text class="font-weight-bold mb-25" >
                                {{ data.item.type }} <br>
                                <template v-if="data.item.type != 'PW'">
                                    ( {{getType(data.item,data.item.type)}} )
                                </template>
                            </b-card-text>
                        </template>
                        <template #cell(total)="data">
                            <b-card-text class="font-weight-bold mb-25">
                            ₹ {{ currency(data.item.total) }}
                            </b-card-text>
                        </template>
                        <template #cell(rate)="data">
                            <b-card-text class="font-weight-bold mb-25" style="width: 70px">
                                ₹ {{ currency(data.item.rate) }}
                            </b-card-text>
                        </template>
                        <template #cell(qty)="data">
                            <b-card-text class="font-weight-bold mb-25" style="width: 20px">
                                {{ data.item.qty }}
                            </b-card-text>
                        </template>
                        <template #cell(item)="data">
                            <b-card-text style="width: 250px">
                                <b-card-text class="font-weight-bold mb-25">
                                    {{ data.item.item_name }}
                                </b-card-text>
                                <b-card-text class="text-wrap">
                                    {{ data.item.item_description }}
                                </b-card-text>
                            </b-card-text>
                        </template>
                        <template #cell(height)="data" >
                            <b-card-text class="font-weight-bold mb-25 text-center">
                                {{ data.item.height != null ? data.item.height : '-' }}
                            </b-card-text>
                        </template>
                        <template #cell(width)="data" >
                            <b-card-text class="font-weight-bold mb-25 text-center">
                                {{ data.item.width != null ? data.item.width : '-' }}
                            </b-card-text>
                        </template>

                    </b-table>

                    <!-- Invoice Description: Total -->
                    <b-card-body class="invoice-padding pb-0">
                        <b-row>

                            <!-- Col: Sales Persion -->
                            <b-col
                                cols="12"
                                md="6"
                                class="mt-md-0 mt-3"
                                order="2"
                                order-md="1"
                            >
<!--                                <b-card-text class="mb-0">
                                    <span class="font-weight-bold">Salesperson:</span>
                                    <span class="ml-75">Alfie Solomons</span>
                                </b-card-text>-->
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
                                            ₹ {{ currency(invoiceData.total_amount)}}
                                        </p>
                                    </div>

                                    <hr class="my-50">
                                    <div class="invoice-total-item">
                                        <p class="invoice-total-title">
                                            Total:
                                        </p>
                                        <p class="invoice-total-amount">
                                            ₹ {{ currency(invoiceData.total_amount)}}
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
                        <span>It was a pleasure working with you and your team. We hope you will keep us in mind for future freelance
              projects. Thank You!</span>
                    </b-card-body>
                </b-card>
            </b-col>

            <!-- Right Col: Card -->
            <b-col
                cols="12"
                md="4"
                xl="3"
                class="invoice-actions"
            >
                <b-card>

                    <b-button
                        v-ripple.400="'rgba(186, 191, 199, 0.15)'"
                        variant="outline-primary"
                        class="mb-75"
                        block
                        :to="{ name: 'invoices-edit', params: { id: $route.params.id } }"
                    >
                        <feather-icon icon="EditIcon" />
                        Edit
                    </b-button>
                    <b-button
                        v-ripple.400="'rgba(186, 191, 199, 0.15)'"
                        variant="outline-primary"
                        class="mb-75"
                        block
                        @click="printInvoice"
                    >
                        <feather-icon icon="PrinterIcon" />
                        Print
                    </b-button>
                </b-card>
            </b-col>
        </b-row>

        <invoice-sidebar-send-invoice />
        <invoice-sidebar-add-payment />
    </section>
</template>

<script>
import { ref, onUnmounted,onMounted } from '@vue/composition-api'
import store from '@/store'
import router from '@/router'

import {
    BTfoot,
    BRow, BCol, BCard, BCardBody, BTable,BTableLite, BCardText, BButton, BAlert, BLink, VBToggle,
} from 'bootstrap-vue'
import Logo from '@core/layouts/components/Logo.vue'
import Ripple from 'vue-ripple-directive'
import axiosIns from '../../../libs/axios'

export default {
    directives: {
        Ripple,
        'b-toggle': VBToggle,
    },
    components: {
        BTfoot,
        BTable,
        BRow,
        BCol,
        BCard,
        BCardBody,
        BTableLite,
        BCardText,
        BButton,
        BAlert,
        BLink,
        Logo,
    },
    methods : {
        getType(record,type){
            let $val = 0
            switch (type){
                case 'RF':
                    $val = record.width / 12
                    break
                case 'SF':
                    $val = (record.width * record.height) / 144
                    break
            }
            return this.currency($val)
        }
    },
    setup() {

        const invoiceData = ref(null)
        const paymentDetails = ref({})

        // Invoice Description
        // ? Your real data will contain this information
        const invoiceDescription = [
            {
                taskTitle: 'Native App Development',
                taskDescription: 'Developed a full stack native app using React Native, Bootstrap & Python',
                rate: '$60.00',
                hours: '30',
                total: '$1,800.00',
            },
            {
                taskTitle: 'UI Kit Design',
                taskDescription: 'Designed a UI kit for native app using Sketch, Figma & Adobe XD',
                rate: '$60.00',
                hours: '20',
                total: '$1200.00',
            },
        ]

        const INVOICE_APP_STORE_MODULE_NAME = 'app-invoice'



        onMounted(() => {
            axiosIns.post(`/invoice/show/${router.currentRoute.params.id}`).then(response => {
                if(response.success){
                    invoiceData.value = response.data
                }
            })
        })
        // UnRegister on leave
        onUnmounted(() => {
            if (store.hasModule(INVOICE_APP_STORE_MODULE_NAME)) store.unregisterModule(INVOICE_APP_STORE_MODULE_NAME)
        })


        /* store.dispatch('app-invoice/fetchInvoice', { id: router.currentRoute.params.id })
            .then(response => {
                invoiceData.value = response.data.invoice
                paymentDetails.value = response.data.paymentDetails
            })
            .catch(error => {
                if (error.response.status === 404) {
                    invoiceData.value = undefined
                }
            }) */

        const printInvoice = () => {
            window.print()
        }

        return {
            invoiceData,
            paymentDetails,
            invoiceDescription,
            printInvoice,
        }
    },
}
</script>

<style lang="scss" scoped>
@import "~@resources/scss/base/pages/app-invoice.scss";
</style>

<style lang="scss">
@media print {

    // Global Styles
    body {
        background-color: transparent !important;
    }
    nav.header-navbar {
        display: none;
    }
    .main-menu {
        display: none;
    }
    .header-navbar-shadow {
        display: none !important;
    }
    .content.app-content {
        margin-left: 0;
        padding-top: 2rem !important;
    }
    footer.footer {
        display: none;
    }
    .card {
        background-color: transparent;
        box-shadow: none;
    }
    .customizer-toggle {
        display: none !important;
    }

    // Invoice Specific Styles
    .invoice-preview-wrapper {
        .row.invoice-preview {
            .col-md-8 {
                max-width: 100%;
                flex-grow: 1;
            }

            .invoice-preview-card {
                .card-body:nth-of-type(2) {
                    .row {
                        > .col-12 {
                            max-width: 50% !important;
                        }

                        .col-12:nth-child(2) {
                            display: flex;
                            align-items: flex-start;
                            justify-content: flex-end;
                            margin-top: 0 !important;
                        }
                    }
                }
            }
        }

        // Action Right Col
        .invoice-actions {
            display: none;
        }
    }
}
</style>

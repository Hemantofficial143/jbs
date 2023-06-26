<template>
    <b-sidebar
        id="add-new-user-sidebar"
        :visible="isAddNewCustomerSidebarActive"
        bg-variant="white"
        sidebar-class="sidebar-lg"
        shadow
        backdrop
        no-header
        right
        @hidden="resetSidebar"
        @change="(val) => $emit('update:is-add-new-customer-sidebar-active', val)"
    >
        <template #default="{ hide }">
            <!-- Header -->
            <div class="d-flex justify-content-between align-items-center content-sidebar-header px-2 py-1">
                <h5 class="mb-0">
                    {{  userData.id == undefined ? 'Add' : 'Edit' }} Invoice
                </h5>

                <feather-icon
                    class="ml-1 cursor-pointer"
                    icon="XIcon"
                    size="16"
                    @click="hide"
                />

            </div>

            <!-- BODY -->
            <validation-observer
                #default="{ handleSubmit }"
                ref="refFormObserver"
            >
                <!-- Form -->
                <b-form
                    class="p-2"
                    @submit.prevent="handleSubmit(onSubmit)"
                    @reset.prevent="resetSidebar"
                >

                    <!-- Customer -->
                    <validation-provider
                        #default="validationContext"
                        name="Customer"
                        rules="required"
                    >
                        <b-form-group
                            label="Customer"
                            label-for="Customer"
                            :state="getValidationState(validationContext)"
                        >
                            <v-select
                                v-model="userData.customer"
                                :dir="$store.state.appConfig.isRTL ? 'rtl' : 'ltr'"
                                :options="customers"
                                :clearable="false"
                                label="name"
                            />
                            <b-form-invalid-feedback :state="getValidationState(validationContext)">
                                {{ validationContext.errors[0] }}
                            </b-form-invalid-feedback>
                        </b-form-group>
                    </validation-provider>

                    <b-form-group
                        label="Date"
                        label-for="date"
                    >
                        <flat-pickr
                            class="form-control"
                            v-model="userData.date"
                        />
                    </b-form-group>

                    <!-- Address -->
                    <validation-provider
                        #default="validationContext"
                        name="Address"
                        rules="required"
                    >
                        <b-form-group
                            label="Address"
                            label-for="address"
                        >
                            <b-form-textarea
                                id="address"
                                v-model="userData.address"
                                :state="getValidationState(validationContext)"
                                trim
                                placeholder="Address"
                            />

                            <b-form-invalid-feedback>
                                {{ validationContext.errors[0] }}
                            </b-form-invalid-feedback>
                        </b-form-group>
                    </validation-provider>



                    <!-- Form Actions -->
                    <div class="d-flex mt-2">
                        <b-button
                            v-ripple.400="'rgba(255, 255, 255, 0.15)'"
                            variant="primary"
                            class="mr-2"
                            type="submit"
                        >
                            {{  userData.id == undefined ? 'Add' : 'Update' }}
                        </b-button>
                        <b-button
                            v-ripple.400="'rgba(186, 191, 199, 0.15)'"
                            type="button"
                            variant="outline-secondary"
                            @click="hide"
                        >
                            Cancel
                        </b-button>
                    </div>

                </b-form>
            </validation-observer>
        </template>
    </b-sidebar>
</template>

<script>
import { BSidebar, BForm, BFormGroup, BFormInput, BFormInvalidFeedback, BButton,BFormTextarea ,BFormDatepicker } from 'bootstrap-vue'
import flatPickr from 'vue-flatpickr-component'

import { ValidationProvider, ValidationObserver } from 'vee-validate'
import { ref } from '@vue/composition-api'
import { required, alphaNum, email } from '@validations'
import formValidation from '@core/comp-functions/forms/form-validation'
import Ripple from 'vue-ripple-directive'
import vSelect from 'vue-select'
import countries from '@/@fake-db/data/other/countries'
import store from '@/store'
import axiosIns from '../../../libs/axios'

export default {
    components: {
        flatPickr,
        BFormDatepicker,
        BFormTextarea,
        BSidebar,
        BForm,
        BFormGroup,
        BFormInput,
        BFormInvalidFeedback,
        BButton,
        vSelect,
        // Form Validation
        ValidationProvider,
        ValidationObserver,
    },
    directives: {
        Ripple,
    },
    model: {
        prop: 'isAddNewCustomerSidebarActive',
        event: 'update:is-add-new-customer-sidebar-active',
    },
    props: {
        isAddNewCustomerSidebarActive: {
            type: Boolean,
            required: true,
        },
    },
    data() {
        return {
            required,
            alphaNum,
            email,
            countries,
            customers : []
        }
    },

    async created() {
        const getProfile = await axiosIns.post('customer/get')
        this.customers = getProfile.data
    },
    setup(props, { emit }) {
        const blankUserData = {
            customer: null,
            date : null,
            address : null
        }

        const userData = ref(JSON.parse(JSON.stringify(blankUserData)))
        const resetuserData = () => {
            userData.value = JSON.parse(JSON.stringify(blankUserData))
        }

        const setUpdateData = (data) => {
            data = JSON.parse(JSON.stringify(data))
            userData.value = {
                id: data.id,
                customer: data.customer,
                date: data.invoice_date,
                address : data.address
            }
        }



        const onSubmit = () => {

            let URL = null
            if(userData.value.id != undefined){
                URL = `invoice/update/${userData.value.id}`
            }else{
                URL = "invoice/store"
            }
            axiosIns.post(URL,userData.value).then(response => {
                if(response.success){
                    emit('refetch-data')
                    resetuserData()
                    emit('update:is-add-new-customer-sidebar-active', false)
                }
            })
        }

        const resetSidebar = () => {
            userData.value = JSON.parse(JSON.stringify(blankUserData))
        }



        const { refFormObserver, getValidationState, resetForm } = formValidation(resetuserData)

        return {
            resetSidebar,
            userData,
            onSubmit,
            setUpdateData,
            refFormObserver,
            getValidationState,
            resetForm,
        }
    },
}
</script>

<style lang="scss">
@import '~@resources/scss/vue/libs/vue-select.scss';

#add-new-user-sidebar {
    .vs__dropdown-menu {
        max-height: 200px !important;
    }
}
</style>

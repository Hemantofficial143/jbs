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
            {{ userData.id === undefined ? 'Add' : 'Edit' }} Customer
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

          <!-- Name -->
          <validation-provider
            #default="validationContext"
            name="Name"
            rules="required"
          >
            <b-form-group
              label="Name"
              label-for="name"
            >
              <b-form-input
                id="full-name"
                v-model="userData.name"
                autofocus
                :state="getValidationState(validationContext)"
                trim
                placeholder="John Doe"
              />

              <b-form-invalid-feedback>
                {{ validationContext.errors[0] }}
              </b-form-invalid-feedback>
            </b-form-group>
          </validation-provider>


          <!-- Email -->
          <validation-provider
            #default="validationContext"
            name="Email"
            rules="required|email"
          >
            <b-form-group
              label="Email"
              label-for="email"
            >
              <b-form-input
                id="email"
                v-model="userData.email"
                :state="getValidationState(validationContext)"
                trim
                placeholder="someone@email.com"
              />

              <b-form-invalid-feedback>
                {{ validationContext.errors[0] }}
              </b-form-invalid-feedback>
            </b-form-group>
          </validation-provider>


            <!-- Mobile -->
            <validation-provider
                #default="validationContext"
                name="Mobile"
                rules="required"
            >
                <b-form-group
                    label="Mobile"
                    label-for="mobile"
                >
                    <b-form-input
                        id="email"
                        v-model="userData.mobile"
                        :state="getValidationState(validationContext)"
                        trim
                        placeholder="XXXXXXXXXX"
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
                {{ userData.id === undefined ? 'Add' : 'Update' }}
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
import { BSidebar, BForm, BFormGroup, BFormInput, BFormInvalidFeedback, BButton,BFormTextarea } from 'bootstrap-vue'
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
    }
  },
  setup(props, { emit }) {
    const blankUserData = {
        name: null,
        email: null,
        mobile: null,

    }

    const userData = ref(JSON.parse(JSON.stringify(blankUserData)))
    const resetuserData = () => {
      userData.value = JSON.parse(JSON.stringify(blankUserData))
    }

    const setUpdateData = (data) => {
        data = JSON.parse(JSON.stringify(data))
        userData.value = {
            id: data.id,
            name: data.name,
            email: data.email,
            mobile: data.mobile,


        }
    }



    const onSubmit = () => {

        let URL = null
        if(userData.value.id != undefined){
            URL = `customer/update/${userData.value.id}`
        }else{
            URL = "customer/store"
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

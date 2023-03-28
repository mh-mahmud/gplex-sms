<template>
    <div class="m-grid__item m-grid__item--fluid m-wrapper">
        <js-plugin :js-plugin="data.js_plugin"></js-plugin>
        <breadcrumb :breadcrumb-data="data.breadcrumb"></breadcrumb>
        <div class="row m-content">
            <div class="col-lg-12">
                <!--begin::Portlet-->
                <div class="m-portlet">
                    <div class="m-portlet__head">
                        <div class="m-portlet__head-caption">
                            <div class="m-portlet__head-title">
                                <span class="m-portlet__head-icon m--hide">
                                    <i class="la la-gear"></i>
                                </span>
                                <h3 class="m-portlet__head-text">
                                    Contact Settings
                                </h3>
                            </div>
                        </div>
                    </div>
                    <!--begin::Form-->
                    <form class="m-form" @submit.prevent="addContactSettings">
                        <div class="m-portlet__body">
                            <div class="m-form__section m-form__section--first">

                                
                                

                                <!-- start copy from here -->
                                <div class="form-group m-form__group row">
                                    <label class="col-lg-3 col-form-label"  for="custom_0_name">Custom Name:</label>
                                    <div class="col-lg-6">
                                        <input data-vv-as="Custom Name" name="custom_0_name" v-validate="'max:30'"  v-model="contact.custom_0_name" type="text" class="form-control m-input" placeholder="">
                                    </div>    
                                </div>
                                <div class="form-group m-form__group row">
                                    <label class="col-lg-3 col-form-label"  for="custom_1_name">Custom Name 1 :</label>
                                    <div class="col-lg-6">
                                        <input data-vv-as="Custom Name 1" name="custom_1_name" v-validate="'max:30'"  v-model="contact.custom_1_name" type="text" class="form-control m-input" placeholder="">
                                    </div>    
                                </div>
                                <div class="form-group m-form__group row">
                                    <label class="col-lg-3 col-form-label"  for="custom_2_name">Custom Name 2 :</label>
                                    <div class="col-lg-6">
                                        <input data-vv-as="Custom Name 2" name="custom_2_name" v-validate="'max:30'"  v-model="contact.custom_2_name" type="text" class="form-control m-input" placeholder="">
                                    </div>    
                                </div>
                                <div class="form-group m-form__group row">
                                    <label class="col-lg-3 col-form-label"  for="custom_3_name">Custom Name 3 :</label>
                                    <div class="col-lg-6">
                                        <input data-vv-as="Custom Name 3" name="custom_3_name" v-validate="'max:30'"  v-model="contact.custom_3_name" type="text" class="form-control m-input" placeholder="">
                                    </div>    
                                </div>
                                <div class="form-group m-form__group row">
                                    <label class="col-lg-3 col-form-label"  for="custom_4_name">Custom Name 4 :</label>
                                    <div class="col-lg-6">
                                        <input data-vv-as="Custom Name 4" name="custom_4_name" v-validate="'max:30'"  v-model="contact.custom_4_name" type="text" class="form-control m-input" placeholder="">
                                    </div>    
                                </div>
                                <div class="form-group m-form__group row">
                                    <label class="col-lg-3 col-form-label"  for="custom_5_name">Custom Name 5 :</label>
                                    <div class="col-lg-6">
                                        <input data-vv-as="Custom Name 5" name="custom_5_name" v-validate="'max:30'"  v-model="contact.custom_5_name" type="text" class="form-control m-input" placeholder="">
                                    </div>    
                                </div>
                                <div class="form-group m-form__group row">
                                    <label class="col-lg-3 col-form-label"  for="custom_6_name">Custom Name 6 :</label>
                                    <div class="col-lg-6">
                                        <input data-vv-as="Custom Name 6" name="custom_6_name" v-validate="'max:30'"  v-model="contact.custom_6_name" type="text" class="form-control m-input" placeholder="">
                                    </div>    
                                </div>
                                <div class="form-group m-form__group row">
                                    <label class="col-lg-3 col-form-label"  for="custom_7_name">Custom Name 7 :</label>
                                    <div class="col-lg-6">
                                        <input data-vv-as="Custom Name 7" name="custom_7_name" v-validate="'max:30'"  v-model="contact.custom_7_name" type="text" class="form-control m-input" placeholder="">
                                    </div>    
                                </div>
                                <div class="form-group m-form__group row">
                                    <label class="col-lg-3 col-form-label"  for="custom_8_name">Custom Name 8 :</label>
                                    <div class="col-lg-6">
                                        <input data-vv-as="Custom Name 8" name="custom_8_name" v-validate="'max:30'"  v-model="contact.custom_8_name" type="text" class="form-control m-input" placeholder="">
                                    </div>    
                                </div>
                                <div class="form-group m-form__group row">
                                    <label class="col-lg-3 col-form-label"  for="custom_9_name">Custom Name 9 :</label>
                                    <div class="col-lg-6">
                                        <input data-vv-as="Custom Name 9" name="custom_9_name" v-validate="'max:30'"  v-model="contact.custom_9_name" type="text" class="form-control m-input" placeholder="">
                                    </div>    
                                </div>

                                <!-- end custom settings -->
                                
                            </div>
                        </div>
                        <div class="m-portlet__foot m-portlet__foot--fit">
                            <div class="m-form__actions m-form__actions">
                                <button type="submit" class="btn btn-primary">Submit</button>
                            </div>
                        </div>
                    </form>
                    <!--end::Form-->
                </div>
                <!--end::Portlet-->

            </div>
        </div>
    </div>   
</template>

<script>
import AppComponent from '../../components/AppComponent'
import Vue from 'vue'
import vSelect from 'vue-select'
import 'vue-select/dist/vue-select.css';

Vue.component('v-select', vSelect)
export default {
  extends: AppComponent,
  data() {
    return {
      options: [],
      contact: {},
      settingsData: {},
      countries: {},
      validationErrors: {},
      data:{}
    };
  },
  mounted(){
      this.createSettings();
      this.bindCurrentRoute("ContactSettings");
  },
  methods: {
    preventOnEnter(event){        
        event.preventDefault();       
    },
    fetchOptions (search, loading) {
        loading(true);
        var url = `api/search-list?q=${escape(search)}`;
        axios.get(url).then((res) => 
        {          
            //this.options = res.data.data;
            this.options = this.$processVselectData(res.data.data,'name','id');
            //console.log(this.options);                                 
            loading(false);
        })
        .catch(function (error) {
            console.log(error.response);
            loading(false);
        });
    },
    onChange(event) {
        var code = event.target.value;
        this.getCountryPhoneCode(code);
    },
    getCountryPhoneCode(code){      

        axios.get('api/country-phone-code/'+code).then((res) => 
        { 
            this.contact.phone = res.data;            
        })
        .catch(function (error) {
            console.log(error.response);
        });
    },    
    createSettings(){

        var url = 'api/contact-settings';
        console.log(url);
        axios.get(url).then((res) => 
        {
            if(res.data.settingsData) {
                this.contact = res.data.settingsData;
            }
            else {
                this.contact = {
                    custom_0_name: '',
                    custom_1_name: '',
                    custom_2_name: '',
                    custom_3_name: '',
                    custom_4_name: '',
                    custom_5_name: '',
                    custom_6_name: '',
                    custom_7_name: '',
                    custom_8_name: '',
                    custom_9_name: '',
                }
            }
            this.data = res.data;
            // this.options = this.$processVselectData(res.data.groups,'name','id');
            this.$setDocumentTitle(this.data.title);
        })
        .catch(function (error) {
            console.log(error.response);
        });

    },
    // Add/Update Contact
    addContactSettings() {
        this.$validator.validateAll().then((result) => { 
            if(result == true){
                if(typeof commonLib != 'undefined'){
                    commonLib.blockUI({target: ".m-content",animate: true,overlayColor: 'none'});
                }
                var vm = this;
                axios.post('api/create-settings', this.contact).then((res) => 
                {
                    commonLib.iniToastrNotification(res.data.response_msg.type, res.data.response_msg.title, res.data.response_msg.message);
                    if(res.data.response_msg.type == 'success'){
                        //this.contact = {};
                        this.$router.push({name:'ContactSettings'});
                    }
                    commonLib.unblockUI(".m-content");
                })
                .catch(function (error) {
                    vm.validationErrors = error.response.data;
                    commonLib.unblockUI(".m-content");
                });  
                 
            }

        }); 
      
    }
  }
};
</script>

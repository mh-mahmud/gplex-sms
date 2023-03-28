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
                  Disposition Form
                </h3>
              </div>
            </div>
          </div>
          <!--begin::Form-->
          <form class="m-form" @submit.prevent="addDisposition">
            <div class="m-portlet__body">
              <div class="m-form__section m-form__section--first">
                <div class="form-group m-form__group row" :class="errors.has('disposition_type') || validationErrors.disposition_type ? 'has-error' : ''">
                  <label class="col-lg-3 col-form-label">Disposition Type:<span class="required">*</span></label>
                  <div class="col-lg-6">
                    <select data-vv-as="Disposition Type" name="disposition_type" v-validate="'required'"  v-model="disposition.disposition_type" class="form-control m-input">
                      <option value="R">Request</option>
                      <option value="Q">Query</option>
                      <option value="C">Complain</option>
                    </select>
                    <span class="m-form__help" v-if="errors.has('disposition_type') || validationErrors.disposition_type">
                                            {{ errors.first('disposition_type') || validationErrors.disposition_type[0] }}
                                        </span>
                  </div>
                </div>
                <div class="form-group m-form__group row" :class="errors.has('title') || validationErrors.title ? 'has-error' : ''">
                  <label id="disposition_title" class="col-lg-3 col-form-label"  for="disposition_title">Disposition Tittle:<span class="required">*</span></label>
                  <div class="col-lg-6">
                    <input data-vv-as="Disposition Tittle" name="title" v-validate="'required|min:3|max:50'"  v-model="disposition.title" type="text" class="form-control m-input" placeholder="Enter Disposition Title">
                    <span class="m-form__help" v-if="errors.has('first_name') || validationErrors.title">
                                            {{ errors.first('title') || validationErrors.title[0] }}
                                        </span>
                  </div>
                </div>
                <div class="form-group m-form__group row" :class="errors.has('responsible_party') || validationErrors.responsible_party ? 'has-error' : ''">
                  <label id="responsible_party" class="col-lg-3 col-form-label"  for="responsible_party">Responsible Party:</label>
                  <div class="col-lg-6">
                    <input data-vv-as="Responsible Party" name="responsible_party" v-validate="'max:25'"  v-model="disposition.responsible_party" type="text" class="form-control m-input" placeholder="Enter Responsible Party">
                    <span class="m-form__help" v-if="errors.has('responsible_party') || validationErrors.responsible_party">
                                            {{ errors.first('responsible_party') || validationErrors.responsible_party[0] }}
                                        </span>
                  </div>
                </div>
                <div class="form-group m-form__group row" :class="errors.has('type') || validationErrors.status ? 'has-error' : ''">
                  <label class="col-lg-3 col-form-label">Status:<span class="required">*</span></label>
                  <div class="col-lg-6">
                    <select data-vv-as="Status" name="status" v-validate="'required|min:1'"  v-model="disposition.status" class="form-control m-input" >
                      <option value="Y">Active</option>
                      <option value="N">Inactive</option>
                    </select>
                    <span class="m-form__help" v-if="errors.has('user_status') || validationErrors.user_status">
                                            {{ errors.first('user_status') || validationErrors.user_status[0] }}
                                        </span>
                  </div>
                </div>
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
  import AppComponent from '../../components/AppComponent';
  import Vue from 'vue';
  import vSelect from 'vue-select';
  import 'vue-select/dist/vue-select.css';

  Vue.component('v-select', vSelect);
  export default {
    extends: AppComponent,
    data() {
      return {
        disposition: {},
        validationErrors: {},
        data:{}
      };
    },
    mounted(){
      if(this.$route.params.id){
        let id = this.$route.params.id;
        this.getDispositionById(id);
        this.bindCurrentRoute("DispositionList");
      }
    },
    methods: {
      preventOnEnter(event){
        event.preventDefault();
      },
      create(){

        var url = 'api/dispositions/create';

        axios.get(url).then((res) =>
        {
          this.data = res.data;
          this.options = this.$processVselectData(res.data.groups,'name','id');
          this.$setDocumentTitle(this.data.title);
        })
                .catch(function (error) {
                  console.log(error.response);
                });
      },
      getDispositionById(id){

        let vm = this;
        var refUrl = 'api/dispositions/'+id+'/edit';
        if(typeof commonLib != 'undefined'){
          commonLib.blockUI({target: ".m-content",animate: true,overlayColor: 'none'});
        }
        axios.get(refUrl).then((res) =>
        {
          this.disposition = res.data.data;
          this.data = res.data;
          this.$setDocumentTitle(this.data.title);
          commonLib.unblockUI(".m-content");
        })
        .catch(function (error) {
          console.log(error.response);
          commonLib.unblockUI(".m-content");
        });
      },
      // Add/Update Contact
      addDisposition() {
        this.$validator.validateAll().then((result) => {
          if(result == true){
            if(typeof commonLib != 'undefined'){
              commonLib.blockUI({target: ".m-content",animate: true,overlayColor: 'none'});
            }
            var vm = this;
            if(this.$route.params.id){
              axios.put("api/dispositions/"+this.$route.params.id, this.disposition).then((res) =>
              {
                this.user = {};
                commonLib.iniToastrNotification(res.data.response_msg.type, res.data.response_msg.title, res.data.response_msg.message);
                this.$router.push({name:'DispositionList'});
                commonLib.unblockUI(".m-content");
              })
              .catch(function (error) {
                vm.validationErrors = error.response.data;
                commonLib.unblockUI(".m-content");
              });
            }else {
              axios.post('api/dispositions', this.disposition).then((res) =>
              {
                commonLib.iniToastrNotification(res.data.response_msg.type, res.data.response_msg.title, res.data.response_msg.message);
                if(res.data.response_msg.type == 'success'){
                  this.disposition = {};
                  this.$router.push({name:'DispositionList'});
                }
                commonLib.unblockUI(".m-content");
              })
              .catch(function (error) {
                vm.validationErrors = error.response.data;
                commonLib.unblockUI(".m-content");
              });
            }


          }

        });

      }
    }
  };
</script>

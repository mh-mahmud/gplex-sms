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
                  Message Settings
                </h3>
              </div>
            </div>
          </div>
          <!--begin::Form-->
          <form class="m-form" @submit.prevent="addContactSettings">
            <div class="m-portlet__body">
              <div class="m-form__section m-form__section--first">

                <!--**********************************
                              Tabs Start Here
                 ***********************************-->
                <div class="">
                  <div class="panel with-nav-tabs panel-default">

                    <div class="panel-heading">
                      <ul class="nav nav-tabs">
                        <li><a href="#tabone" data-toggle="tab" class="active show">Tab One</a></li>
                        <li><a href="#tabtwo" data-toggle="tab">Tab Two</a></li>
                      </ul>
                    </div>

                    <div class="panel-body">
                      <div class="tab-content">

                        <div class="tab-pane fade in active show" id="tabone">
                          <h1>Tab One</h1>
                          <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Accusantium beatae blanditiis
                            doloremque dolores est eveniet ipsum modi necessitatibus nihil quibusdam, quisquam rem
                            reprehenderit sunt? Dolorem eum fugit quibusdam rerum voluptates?</p>
                        </div>

                        <div class="tab-pane fade" id="tabtwo">
                          <h1>Tab Two</h1>
                          <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Error, veniam.</p>
                        </div>

                      </div>
                    </div>
                  </div>
                </div>
                <!--Tabs End Here-->


                <div class="form-group m-form__group row">
                  <label class="col-lg-3 col-form-label" for="custom_0_name">Custom Field 1:</label>
                  <div class="col-lg-6">
                    <input data-vv-as="Custom Name" name="custom_0_name" v-validate="'max:30'"
                           v-model="contact.custom_0_name" type="text" class="form-control m-input" placeholder="">
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

<style lang="css">
.panel {
  margin-bottom: 20px;
  background-color: #fff;
  border: 1px solid #ddd;
  border-radius: 4px;
  -webkit-box-shadow: 0 1px 1px rgba(0, 0, 0, .05);
  box-shadow: 0 1px 1px rgba(0, 0, 0, .05);
}

.panel-body{
  padding: 0 1rem;
}

.with-nav-tabs.panel-default .nav-tabs > li > a.active,
.with-nav-tabs.panel-default .nav-tabs > li > a.active:hover,
.with-nav-tabs.panel-default .nav-tabs > li > a.active:focus {
  color: #555;
  background-color: #fff;
  border-color: #ddd;
  border-bottom-color: transparent;
}

.nav-tabs > li > a.active,
.nav-tabs > li > a.active:hover,
.nav-tabs > li > a.active:focus {
  color: #555;
  cursor: default;
  background-color: #fff;
  border: 1px solid #ddd;
  border-bottom-color: transparent;
}

.panel .panel-heading {
  padding: 5px 5px 0 5px;
}

.panel.with-nav-tabs .nav-tabs {
  border-bottom: none;
}

.panel.with-nav-tabs .nav-justified {
  margin-bottom: -1px;
}

.panel-default > .panel-heading {
  color: #333;
  background-color: #f5f5f5;
  border-color: #ddd;
}

//TODO: Bootstrap Overwrite
.nav > li {
  position: relative;
  display: block;
}

.nav > li > a {
  position: relative;
  display: block;
  padding: 10px 15px;
}

.nav-tabs > li > a {
  text-decoration: none;
  margin-right: 2px;
  line-height: 1.42857143;
  border: 1px solid transparent;
  border-radius: 4px 4px 0 0;
}

/********************************************************************/
/*** PANEL DEFAULT ***/
.with-nav-tabs.panel-default .nav-tabs > li > a,
.with-nav-tabs.panel-default .nav-tabs > li > a:hover,
.with-nav-tabs.panel-default .nav-tabs > li > a:focus {
  color: #777;
}

.with-nav-tabs.panel-default .nav-tabs > .open > a,
.with-nav-tabs.panel-default .nav-tabs > .open > a:hover,
.with-nav-tabs.panel-default .nav-tabs > .open > a:focus,
.with-nav-tabs.panel-default .nav-tabs > li > a:hover,
.with-nav-tabs.panel-default .nav-tabs > li > a:focus {
  color: #777;
  background-color: #ddd;
  border-color: transparent;
}

.with-nav-tabs.panel-default .nav-tabs > li.active > a,
.with-nav-tabs.panel-default .nav-tabs > li.active > a:hover,
.with-nav-tabs.panel-default .nav-tabs > li.active > a:focus {
  color: #555;
  background-color: #fff;
  border-color: #ddd;
  border-bottom-color: transparent;
}

</style>

<script>
import AppComponent from '../../components/AppComponent'
import Vue from 'vue'
import vSelect from 'vue-select'
import 'vue-select/dist/vue-select.css';
import 'bootstrap/dist/css/bootstrap.css';

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
      data: {}
    };
  },
  mounted() {
    this.createSettings();
    this.bindCurrentRoute("ContactSettings");
  },
  methods: {
    preventOnEnter(event) {
      event.preventDefault();
    },
    fetchOptions(search, loading) {
      loading(true);
      var url = `api/search-list?q=${escape(search)}`;
      axios.get(url).then((res) => {
        //this.options = res.data.data;
        this.options = this.$processVselectData(res.data.data, 'name', 'id');
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
    getCountryPhoneCode(code) {

      axios.get('api/country-phone-code/' + code).then((res) => {
        this.contact.phone = res.data;
      })
          .catch(function (error) {
            console.log(error.response);
          });
    },
    createSettings() {

      var url = 'api/contact-settings';
      console.log(url);
      axios.get(url).then((res) => {
        if (res.data.settingsData) {
          this.contact = res.data.settingsData;
        } else {
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
        if (result == true) {
          if (typeof commonLib != 'undefined') {
            commonLib.blockUI({target: ".m-content", animate: true, overlayColor: 'none'});
          }
          var vm = this;
          axios.post('api/create-settings', this.contact).then((res) => {
            commonLib.iniToastrNotification(res.data.response_msg.type, res.data.response_msg.title, res.data.response_msg.message);
            if (res.data.response_msg.type == 'success') {
              //this.contact = {};
              this.$router.push({name: 'ContactSettings'});
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


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

            <div class="m-portlet__body">
              <div class="m-form__section m-form__section--first">

                <!--**********************************
                              Tabs Start Here
                 ***********************************-->
                <div class="">
                  <div class="panel with-nav-tabs panel-default">

                    <div class="panel-heading">
                      <ul class="nav nav-tabs">
                        <li><a href="#tabone" data-toggle="tab" class="active show" @click="activeStopMessages"><span :class="{'font-weight-bold' : activeStopMessage}">Stop Message</span></a></li>
                        <li><a href="#tabtwo" data-toggle="tab" @click="activeAutoMessages"><span :class="{'font-weight-bold' : activeAutoMessage}">Auto Reply</span></a></li>
                      </ul>
                    </div>

                    <div class="panel-body">
                      <div class="tab-content">

                        <div class="tab-pane fade in active show" id="tabone">
                          <form class="m-form" @submit.prevent="stopMessageSettings">
                            <div class="form-group m-form__group row">
                              <label class="col-lg-1 col-form-label float-lg-right">Message:</label>
                              <div class="col-lg-5">
                                <textarea id="s-msg" data-vv-as="Message" name="opt_out_text"
                                          v-validate="'required|max:150'" v-model="opt_out_text"
                                          style="height:150px;resize: none;" type="text"
                                          class="form-control m-input mb-2"
                                          placeholder="Enter Stop Message"></textarea>
                                <span class="limiter">{{ calculateSMSParts }}</span>
                              </div>
                              <label class="col-lg-1 col-form-label">Status:</label>
                              <div class="col-lg-5 col-form-label">
                                <label :tabindex="5" class="m-radio m-radio--solid m-radio--state-success mb-0 tab-focus-lb">
                                  Always Send
                                  <input type="radio" name="opt_txt_send_option" v-model="opt_txt_send_option" value="A">
                                  <span></span>
                                </label>
                                <label :tabindex="6" class="m-radio m-radio--solid m-radio--state-success mb-0 tab-focus-lb">
                                  Send for the first text
                                  <input type="radio" name="opt_txt_send_option" v-model="opt_txt_send_option" value="F">
                                  <span></span>
                                </label>
                              </div>
                            </div>

                            <div class="m-portlet__foot m-portlet__foot--fit">
                              <div class="m-form__actions m-form__actions">
                                <button type="submit" class="btn btn-primary">Save</button>
                              </div>
                            </div>
                          </form>
                        </div>

                        <div class="tab-pane fade" id="tabtwo">
                          <form class="m-form" @submit.prevent="autoReplySettings">
                            <div class="form-group m-form__group row">
                              <label class="col-lg-1 col-form-label">Message:</label>
                              <div class="col-lg-5">
                                <textarea id="a-msg" data-vv-as="Message" name="reply_text"
                                          v-validate="'required|max:160'" v-model="reply_text"
                                          style="height:150px;resize: none;" type="text"
                                          class="form-control m-input mb-2"
                                          placeholder="Enter Auto Reply Message"></textarea>
                                <span class="limiter">{{ calculateSMSParts }}</span>
                              </div>
                              <label class="col-lg-1 col-form-label">Status:</label>
                              <div class="col-lg-5 col-form-label">
                                <label :tabindex="5" class="m-radio m-radio--solid m-radio--state-success mb-0 tab-focus-lb">
                                  Active
                                  <input type="radio" name="auto_reply_status" v-model="auto_reply_status" value="Y">
                                  <span></span>
                                </label>
                                <label :tabindex="6" class="m-radio m-radio--solid m-radio--state-success mb-0 tab-focus-lb">
                                  Inactive
                                  <input type="radio" name="auto_reply_status" v-model="auto_reply_status" value="N">
                                  <span></span>
                                </label>
                              </div>
                            </div>

                            <div class="m-portlet__foot m-portlet__foot--fit">
                              <div class="m-form__actions m-form__actions">
                                <button type="submit" class="btn btn-primary">Save</button>
                              </div>
                            </div>
                          </form>
                        </div>

                      </div>
                    </div>
                  </div>
                </div>
                <!--Tabs End Here-->




              </div>
            </div>
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

/*//TODO: Bootstrap Overwrite*/
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

Vue.component('v-select', vSelect);
export default {
  extends: AppComponent,
  data() {
    return {
      options: [],
      contact: {},
      settingsData: {},
      countries: {},
      validationErrors: {},
      activeStopMessage: true,
      activeAutoMessage: false,
      opt_out_text: "",
      opt_txt_send_option: "",
      reply_text: "",
      auto_reply_status: "",
      data: {}
    };
  },
  computed: {
    calculateSMSParts() {
      var
              smsType,
              smsLength = 0,
              smsCount = -1,
              charsLeft = 0,
              text = this.activeStopMessage ? this.opt_out_text : this.reply_text,
              isUnicode = false;

      for (var charPos = 0; charPos < text.length; charPos++) {
        switch (text[charPos]) {
          case "\n":
          case "[":
          case "]":
          case "\\":
          case "^":
          case "{":
          case "}":
          case "|":
          case "€":
            smsLength += 2;
            break;

          default:
            smsLength += 1;
        }

        //!isUnicode && text.charCodeAt(charPos) > 127 && text[charPos] != "€" && (isUnicode = true)
        if (text.charCodeAt(charPos) > 127 && text[charPos] != "€")
          isUnicode = true;
      }

      if (isUnicode) {
        smsType = this.data.sms_text_lengths_unicode;//lengths.unicode;
        this.data.sms_text_size = 201;
      } else {
        smsType = this.data.sms_text_lengths_ascii;//lengths.ascii;
        this.data.sms_text_size = 150;
      }

      for (var sCount = 0; sCount < this.data.sms_text_part; sCount++) {

        //this.cutStrLength = smsType[sCount];
        if (smsLength <= smsType[sCount]) {

          smsCount = sCount + 1;
          charsLeft = smsType[sCount] - smsLength;
          break
        }
      }

      //if(this.cut) e.val(text.substring(0, this.cutStrLength));
      smsCount == -1 && (smsCount = this.data.sms_text_part, charsLeft = 0);

      if (typeof smsCount === 'undefined') {
        smsCount = 0;
      }

      return "Characters: " + smsLength + "/" + this.data.sms_text_size;

    },
    charactersLeft() {
      var char = this.message.length,
              limit = this.data.sms_text_size;
      var remaining = limit - char;
      if(char > limit)
        char = limit;

      return "Characters: " + char + "/" + limit;
    }
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
    activeStopMessages(){
      this.activeStopMessage = true;
      this.activeAutoMessage = false;
    },
    activeAutoMessages(){
      this.activeStopMessage = false;
      this.activeAutoMessage = true;
    },
    createSettings() {

      var url = 'api/message-settings';
      console.log(url);
      axios.get(url).then((res) => {
        if (res.data) {
          this.opt_out_text= res.data.stopMessage != null ? res.data.stopMessage.opt_out_text : "";
          this.opt_txt_send_option= res.data.stopMessage != null ? res.data.stopMessage.opt_txt_send_option : "";
          this.reply_text= res.data.autoMessage != null ? res.data.autoMessage.reply_text : "";
          this.auto_reply_status= res.data.autoMessage != null ? res.data.autoMessage.auto_reply_status : "";
        } else {
          this.opt_out_text= "";
          this.opt_txt_send_option= "";
          this.reply_text= "";
          this.auto_reply_status= "";
        }
        this.data = res.data;
        // this.options = this.$processVselectData(res.data.groups,'name','id');
        this.$setDocumentTitle(this.data.title);
      })
          .catch(function (error) {
            console.log(error.response);
          });

    },
    // Add/Update stop message
    stopMessageSettings() {
          if (typeof commonLib != 'undefined') {
            commonLib.blockUI({target: ".m-content", animate: true, overlayColor: 'none'});
          }
          var vm = this;
          this.contact.opt_out_text= this.opt_out_text;
          this.contact.opt_txt_send_option= this.opt_txt_send_option;
          axios.post('api/update-stop-message', this.contact).then((res) => {
            commonLib.iniToastrNotification(res.data.response_msg.type, res.data.response_msg.title, res.data.response_msg.message);
            if (res.data.response_msg.type == 'success') {
              //this.contact = {};
              this.$router.push({name: 'AutoMessage'});
            }
            commonLib.unblockUI(".m-content");
          })
              .catch(function (error) {
                vm.validationErrors = error.response.data;
                commonLib.unblockUI(".m-content");
              });
    },
    // Add/Update auto reply
    autoReplySettings() {

          if (typeof commonLib != 'undefined') {
            commonLib.blockUI({target: ".m-content", animate: true, overlayColor: 'none'});
          }
          this.contact.reply_text= this.reply_text;
          this.contact.auto_reply_status= this.auto_reply_status;
          axios.post('api/update-auto-message', this.contact).then((res) => {
            commonLib.iniToastrNotification(res.data.response_msg.type, res.data.response_msg.title, res.data.response_msg.message);
            if (res.data.response_msg.type == 'success') {
              //this.contact = {};
              this.$router.push({name: 'AutoMessage'});
            }
            commonLib.unblockUI(".m-content");
          })
              .catch(function (error) {
                vm.validationErrors = error.response.data;
                commonLib.unblockUI(".m-content");
              });
    }
  }
};
</script>


<template>
  <div id="disposition-modal" class="modal fade" role="dialog">
    <div class="modal-dialog modal-lg">
      <!-- Modal content-->
      <div class="modal-content">
        <div class="modal-header">
          <h5>Disposition Modal</h5>
          <button type="button" class="close" data-dismiss="modal">&times;</button>
        </div>
        <div class="modal-body">
          <div class="row">
            <div class="col-sm-12">
              <form class="m-form" @submit.prevent="addDisposition" autocomplete="off">
                <div class="form-group">
                  <div class="row">
                    <div class="g-disposition-type mb-3">
                      <label>Disposition Type:</label>
                      <select data-vv-as="Disposition Type" name="disposition_id" v-validate="'required'" v-model="formData.disposition_id" class="form-control m-input">
                        <option v-for="(item, index) in modalData.DispositionType" :value="index" :key="index">{{item}}</option>
                      </select>
                      <span class="m-form__help text-danger" v-if="errors.has('disposition_id') || validationErrors.disposition_id">
                         {{ errors.first('disposition_id') || validationErrors.disposition_id[0] }}
                      </span>
                    </div>
                    <textarea name="disposition" id="dispositionText" cols="30" rows="5" v-validate="'required|max:255'"  v-model="formData.disposition" v-on:keyup="remainCharacter" class="form-control" placeholder="Write here..."></textarea>
                    <span class="m-form__help text-danger" v-if="errors.has('disposition') || validationErrors.disposition">
                       {{ errors.first('disposition') || validationErrors.disposition[0] }}
                    </span>
                    <span class="m-form__help  pull-right" v-if="dispositionTextLeft != 255">
                       Characters: {{dispositionTextLeft}}/255
                    </span>
                  </div>

                  <button type="submit" class="btn btn-success mt-2 float-right">Submit</button>
                </div>
              </form>
            </div>
          </div>
          <div v-if="tableData.length > 0" class="table-responsive my-3 floating-scroll">
            <table class="table table-bordered" style="width: 1880px !important;">
              <thead>
                <tr role="row" style="text-align: center">
                  <th>Date</th>
                  <th>Disposition Type</th>
                  <th>Note</th>
                </tr>
              </thead>
              <tbody>
                <tr v-for="(item, index) in modalData.data" v-bind:key="index" style="text-align: center">
                  <td>{{item.tstamp}}</td>
<!--                  <td>{{item.tstamp   | formatTimestampDate('MM/DD/YYYY hh:mm A') }}</td>-->
                  <td>{{item.title}}</td>
                  <td >{{item.note}}</td>
                </tr>
              </tbody>
            </table>
          </div>
          <div v-if="tableData.length > 0" class="row pull-right"><a @click.prevent="removeBackdrop()" href="#"><span class="breadcrumb-title">More</span></a></div>
        </div>
      </div>

    </div>
  </div>

</template>

<script>
import AppComponent from '../../components/AppComponent';
export default {
  components:{
    AppComponent
  },
  data() {
    return {
      formData:{},
      disposition: "",
      dispositionTextLeft: 255,
      validationErrors: {},
      modalData:{},
      tableData:{},
      modalPagination:{},
    }
  },
  mounted(){
    this.baseUrl = BASE_URL;
    this.closeModal("#disposition-modal");
    this.showModal("#disposition-modal");
    this.getAllDisposition();
  },
  props: ["dispositionData"],
  methods: {

    showModal(refid){
      let self = this;
      $(refid).on("shown.bs.modal", function(){
        self.formData = self.dispositionData;
        axios.get('api/all-dispositions/'+self.formData.clientNumber).then((res) =>
        {
          console.log(res.data);
          self.modalData = res.data;
          self.tableData = res.data.data;
          if(blockUI.show == true && typeof commonLib != 'undefined'){
            commonLib.unblockUI(targetElm);
          }
        })
        .catch(function (error) {
          self.validationErrors = error;
          commonLib.unblockUI("#disposition-modal");
        });
        self.validationErrors = {};
      });
    },
    getAllDisposition(){

    },
    closeModal(refid){
      let self = this;
      $(refid).on("hidden.bs.modal", function(){
        self.formData = {};
        self.validationErrors = {};
        $("body").removeAttr("style");
      });
    },
    addDisposition(){
      this.$validator.validateAll().then((result) => {
        if(result == true){
          if(typeof commonLib != 'undefined'){
            commonLib.blockUI({target: "#disposition-modal",animate: true,overlayColor: 'none'});
          }
          let self = this;
          console.log(self.formData);
          axios.post('api/add-disposition', self.formData).then((res) =>
          {
            self.formData = {};
            self.validationErrors = {};
            commonLib.iniToastrNotification(res.data.response_msg.type, res.data.response_msg.title, res.data.response_msg.message);
            commonLib.unblockUI("#disposition-modal");
            self.hideModal('#disposition-modal');
          })
          .catch(function (error) {
            self.validationErrors = error.response.data;
            commonLib.unblockUI("#disposition-modal");
          });

        }

      });
    },
    hideModal(refid){
      $(refid).modal('hide');
      $(".modal-backdrop").remove();
    },
    removeBackdrop(){
      $("#disposition-modal").modal('hide');
      $(".modal-backdrop").remove();
      this.$router.push('disposition-log');

      console.log('calling');
    },
    remainCharacter(){
      this.dispositionTextLeft = 255 - this.formData.disposition.length;
    }
  }
}
</script>

<style scoped>

</style>

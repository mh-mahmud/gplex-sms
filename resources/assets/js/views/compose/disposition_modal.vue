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
              <form action="">
                <div class="form-group">
                  <textarea name="" id="" cols="30" rows="5" class="form-control" placeholder="Write here..."></textarea>
                  <button type="submit" class="btn btn-success mt-2 float-right">Submit</button>
                </div>
              </form>
            </div>
          </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
        </div>
      </div>

    </div>
  </div>

</template>

<script>
import AppComponent from '../../components/AppComponent';
export default {
  name: 'disposition-modal',
  extends: AppComponent,
  data() {
    return {
    }
  },
  mounted(){
    this.baseUrl = BASE_URL;
    this.closeModal("#disposition-modal");
    this.showModal("#disposition-modal");
  },
  methods: {
    closeModal(refid){
      $(refid).on('hidden.bs.modal', function () {
      });


    },
    showModal(refid){
      $(refid).on('shown.bs.modal', function () {
      });
    }
  }
}
</script>

<style scoped>

</style>

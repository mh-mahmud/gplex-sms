<template>
    <div class="m-grid__item m-grid__item--fluid m-wrapper">
        <js-plugin :js-plugin="data.js_plugin"></js-plugin>
        <!-- BreadCrumb	-->
        <breadcrumb :breadcrumb-data="data.breadcrumb"></breadcrumb>	        
        <div class="m-content">
            <div class="m-portlet m-portlet--mobile">
                <div class="m-portlet__head">
                    <div class="m-portlet__head-caption">
                        <div class="m-portlet__head-title">
                            <h3 class="m-portlet__head-text"> 
                                Disposition List
                            </h3>
                        </div>
                    </div>
                </div>
                <div class="m-portlet__body">
                    <div class="m-accordion vue-accordion">
                        <!--begin::Item--> 
                        <div class="m-accordion__item m-accordion__item--success">
                            <div v-b-toggle.collapse1 class="m-accordion__item-head">
                                <span class="m-accordion__item-icon"><i class="fa flaticon-search-1"></i></span>
                                <span class="m-accordion__item-title">Search</span>
                                <span class="m-accordion__item-mode"></span>    
                            </div>
                            <b-collapse id="collapse1" class="vue-accordion-body">
                                
                                <b-card>
                                    <!-- search form -->
                                    <div class="m-form m-form--fit">
                                        <div class="row">
                                            <div class="col-md-3 m--margin-bottom-10-tablet-and-mobile">
                                                <label>Disposition Type:</label>
                                                <select data-vv-as="Status" name="status" v-model="searchKey.disposition_type" class="form-control m-input">
                                                    <option value="">All</option>
                                                    <option v-for="(item, index) in data.DispositionType" :value="index" :key="index">{{item}}</option>
                                                </select>
                                            </div>
                                        </div>
                                        
                                        <div class="mt-4"></div>
                                        <div class="row">
                                            <div class="col-lg-12">
                                                <button class="btn btn-brand m-btn m-btn--icon"  @click="makeSearchQueryStr(),fetchDisposition()" id="m_search">
                                                    <span>
                                                        <i class="la la-search"></i>
                                                        <span>Search</span>
                                                    </span>
                                                </button>
                                                &nbsp;&nbsp;
                                                <button class="btn btn-secondary m-btn m-btn--icon" @click="fetchDisposition('api/dispositions?page=1'),resetsearchKey()" id="m_reset">
                                                    <span>
                                                        <i class="la la-close"></i>
                                                        <span>Reset</span>
                                                    </span>
                                                </button>
                                            </div>
                                        </div>
                                    </div>

                                    <!-- search form -->
                                </b-card>

                            </b-collapse>
                                
                        </div>   
                        <!--end::Item--> 
                    </div> 
                    <!--begin: Datatable -->
                    <div id="m_table_1_wrapper" class="dataTables_wrapper container-fluid dt-bootstrap4 no-footer">
                        <div class="row">
                            <div class="col-sm-12">
                                <table class="table table-striped- table-bordered table-hover table-checkable dataTable no-footer dtr-inline collapsed sortable" id="m_table_1" role="grid" aria-describedby="m_table_1_info" style="width: 1044px;">
                                    <thead>
                                        <tr role="row" style="text-align: center">
                                            <th>Ser.</th>                                            
                                            <th>Account</th>
                                            <th>Type</th>
                                            <th>Disposition</th>
                                            <th>Responsible Party</th>
                                            <th>Status</th>                                            
                                            <th colspan="2">Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr v-for="(disposition, index) in data.data" style="text-align: center">
                                            <td>{{index+1}}</td>
                                            <td>{{ disposition.account_id }} </td>
                                            <td>{{ data.DispositionType[disposition.disposition_type] }}</td>
                                            <td>{{disposition.title }}</td>
                                            <td>{{ disposition.responsible_party }}</td>
                                            <td><span class="badge">{{ data.status[disposition.status] }}</span></td>
                                            <td>
                                                <router-link href="#" v-bind:to="{name: 'DispositionAdd', params: {id:disposition.disposition_id }}" class="text-info" data-toggle="m-tooltip" title="Edit">
                                                    <i class='fa fa-edit'></i>
                                                </router-link>
                                            
                                                <a @click.prevent="deleteDisposition(disposition.disposition_id ,index)" class="text-danger" href="#" data-toggle="m-tooltip" title="Delete">
                                                    <i class='fa fa-trash'></i>
                                                </a>
                                                    
                                            </td>
                                        </tr>
                                        
                                    </tbody>
                                </table>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-sm-12 col-md-5">
                                <div class="dataTables_info" id="m_table_1_info" role="status" aria-live="polite">Showing {{pagination.from}} to {{pagination.to}} of {{pagination.total}} entries</div>
                            </div>
                            <div class="col-sm-12 col-md-7 dataTables_pager">
                                
                                <div class="dataTables_paginate paging_simple_numbers" id="m_table_1_paginate">
                                    <vue-pagination  :pagination="pagination" @paginate="fetchDisposition()" :offset="4"> </vue-pagination>
                                </div>
                            </div>
                        </div>
                    </div>

                </div>
            </div>
            <!-- END EXAMPLE TABLE PORTLET-->		        
        </div>
    </div>
</template>

<script>
import AppComponent from '../../components/AppComponent'
export default {
  extends: AppComponent,
    data() {
        return {
            searchKey: {                
                'disposition_type': '',
            },
            searchQueryStr: '',
            data: {},
            pagination: {},
        }
    },
    mounted() { 
        this.fetchDisposition();
        this.bindCurrentRoute();
    },
    methods: {
        Reload(){
            this.fetchDisposition();
        },
        resetsearchKey(){
            this.searchKey = {
                'disposition_type': '',
            }            
        },
        makeSearchQueryStr(){ 
            this.pagination.current_page = 1;
            this.bindSearchQueryStr();
        },
        bindSearchQueryStr(){ 
            var queryStr = "";            
            jQuery.each(this.searchKey, function(key, value) { 
                if(value.length > 0){
                    queryStr += "&"+key+"="+value;
                }            
            });
            this.searchQueryStr = queryStr;
        },
        // Fetch List
        fetchDisposition(page_url) {
            this.$validator.validateAll().then((result) => {
                if(result == true){
                    page_url = page_url || 'api/dispositions?page='+this.pagination.current_page+this.searchQueryStr;
                    this.getPagiData(page_url);
                }
            });
        },

        deleteDisposition(id, index){
            var self = this;
            this.$deletePagiItem(self.data.data, index, self.pagination, 'Are you sure you want to delete this disposition?', 'api/dispositions/' + id);
        }
    },

}
</script>

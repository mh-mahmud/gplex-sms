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
                                Disposition History
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
                                            <div class="col-lg-6 m--margin-bottom-10-tablet-and-mobile">
                                                <label>Start Range:</label>
                                                <div class="input-daterange form-group input-group" :class="errors.has('start_time') || errors.has('end_time') ? 'has-error' : ''" id="m_datepicker">
                                                    <date-picker data-vv-as="Start Time"  name="start_time" v-validate="'required'" v-model="searchKey.start_time"
                                                                 :config="datepickerOpt" class="form-control m-input date-time-picker" placeholder="From" autocomplete="off"></date-picker>
                                                    <span class="m-form__help" v-if="errors.has('start_time')">
                                                        {{ errors.first('start_time')}}
                                                    </span>
                                                    <div class="input-group-append">
                                                        <span class="input-group-text"><i class="la la-ellipsis-h"></i></span>
                                                    </div>
                                                    <date-picker data-vv-as="End Time" name="end_time" v-validate="'required'"  v-model="searchKey.end_time"
                                                                 :config="datepickerOpt" class="form-control m-input date-time-picker" placeholder="To" autocomplete="off"></date-picker>
                                                    <span class="m-form__help" v-if="errors.has('end_time')">
                                                        {{ errors.first('end_time')}}
                                                    </span>
                                                </div>
                                            </div>
                                            <div class="col-md-3 m--margin-bottom-10-tablet-and-mobile">
                                                <label>Client Number:</label>
                                                <input type="text" class="form-control m-input" v-model="searchKey.cli" placeholder="Client Number"/>
                                            </div>
                                            <div class="col-md-3 m--margin-bottom-10-tablet-and-mobile">
                                                <label>Disposition Type:</label>
                                                <select data-vv-as="Status" name="status" v-model="searchKey.disposition_type" class="form-control m-input">
                                                    <option value="">All</option>
                                                    <option v-for="(item, index) in data.dispositionType" :value="index" :key="index">{{item}}</option>
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
                                                <button class="btn btn-secondary m-btn m-btn--icon" @click="fetchDisposition('api/disposition-log?page=1&start_time='+start_time+'&end_time='+end_time),resetsearchKey()" id="m_reset">
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
                                            <th>Date</th>
                                            <th>Call ID</th>
                                            <th>Client Number</th>
                                            <th>Disposition Type</th>
                                            <th>Note</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr v-for="(disposition, index) in data.data" style="text-align: center">
                                            <td>{{disposition.tstamp  | formatTimestampDate('MM/DD/YYYY hh:mm A') }}</td>
                                            <td>{{disposition.callid}}</td>
                                            <td>{{disposition.cli | formatPhone}}</td>
                                            <td>{{disposition.title}}</td>
                                            <td >{{disposition.note}}</td>
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
            datepickerOpt:{format: 'MM/DD/Y HH:mm',useCurrent: 'day',showClear: true,showClose: true},
            searchKey: {
                'start_time': moment().format('MM/DD/Y')+" 00:00",
                'end_time': moment().format('MM/DD/Y HH:mm'),
                'cli': '',
                'disposition_type': '',
            },
            searchQueryStr: '',
            start_time: moment().format('YYYY-MM-DD')+" 00:00",
            end_time: moment().format('YYYY-MM-DD HH:mm'),
            data: {},
            sortKey: 'tstamp',
            pagination: {},
        }
    },
    mounted() {
        this.makeSearchQueryStr();
        this.fetchDisposition();
        this.bindCurrentRoute();
        this.baseUrl = BASE_URL;
    },
    methods: {
        Reload(){
            this.fetchDisposition();
        },
        resetsearchKey(){
            this.searchKey = {
                'start_time': moment().format('MM/DD/Y')+" 00:00",
                'end_time': moment().format('MM/DD/Y HH:mm'),
                'cli': '',
                'disposition_type': '',
            }            
        },
        makeSearchQueryStr(){
            this.pagination.current_page = 1;
            this.bindSearchQueryStr();
        },
        bindSearchQueryStr(){
            var queryStr = "";

            // console.log(this.searchKey);
            jQuery.each(this.searchKey, function(key, value) {
                if(key=='start_time' || key=='end_time'){
                    if(value != null && moment(value, 'MM/DD/YYYY HH:mm',true).isValid()){
                        queryStr += "&"+key+"="+moment(value, 'MM/DD/YYYY HH:mm').format('YYYY-MM-DD HH:mm');
                    }

                }else if(value.length > 0){
                    queryStr += "&"+key+"="+value;
                }
            });
            this.searchQueryStr = queryStr;
        },
        // Fetch List
        fetchDisposition(page_url) {
            this.$validator.validateAll().then((result) => {
                if(result == true){
                    page_url = page_url || 'api/disposition-log?page='+this.pagination.current_page+this.searchQueryStr;
                    this.getPagiData(page_url);
                }
            });
        },
    },

}
</script>

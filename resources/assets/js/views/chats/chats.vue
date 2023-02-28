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
                                Chats: New Window
                            </h3>
                        </div>
                    </div>
                    
                </div>
                <div class="m-portlet__body">                    
                    <!--begin: Datatable -->
                    <div id="m_table_1_wrapper" class="dataTables_wrapper container-fluid dt-bootstrap4 no-footer">
                        <div class="row">
                            <div class="col-lg-6">
                                Hello
                            </div>
                            <div class="col-lg-6">
                                World
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
            data:{}
        };
    },
    mounted(){              
        this.chatsView();         
        this.bindCurrentRoute("Chats");
    },
    methods: {
        chatsView(){
            var url = 'api/chats';
            axios.get(url).then((res) => 
            { 
                this.data = res.data;
                this.$setDocumentTitle(this.data.title);
            })
            .catch(function (error) {
                console.log(error.response);
            });
        },
    }
};
</script>
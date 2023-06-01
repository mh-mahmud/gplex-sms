<template>
    <div class="m-grid__item m-grid__item--fluid m-wrapper">
        <js-plugin :js-plugin="data.js_plugin"></js-plugin>
        <!-- BreadCrumb	-->
        <breadcrumb :breadcrumb-data="data.breadcrumb"></breadcrumb>	        
        <div class="m-content">
            <div class="row">
                <!-- inbox part start -->
                <div class="col-lg-8">
                    <div class="m-portlet m-portlet--mobile">
                        <div class="m-portlet__head">
                            <div class="m-portlet__head-caption">
                                <div class="m-portlet__head-title">
                                    <h3 class="m-portlet__head-text"> 
                                        Inbox
                                        
                                    </h3>
                                </div>
                            </div>
                        </div>
                        <div class="m-portlet__body">
                            
                            <div class="m-messenger m-messenger--message-arrow m-messenger--skin-light">
                                <div class="m-messenger__messages mCustomScrollbar _mCS_22 mCS-autoHide">
                                    <div id="mCSB_22" class="mCustomScrollBox mCS-minimal-dark mCSB_vertical mCSB_outside" tabindex="0" style="max-height: none;">
                                        <div id="mCSB_22_container" class="mCSB_container" style="position:relative; top:0; left:0;" dir="ltr">
                                            <div class="m-messenger__wrapper" v-for="msg in data.data">
                                                <div class="m-messenger__message" :class="msg.direction == 'O' ? 'm-messenger__message--out' :'m-messenger__message--in'">                                                    
                                                    <div class="m-messenger__message-body">
                                                        <div class="m-messenger__message-arrow"></div>
                                                        <div class="m-messenger__message-content">
                                                            <div class="m-messenger__message-username">
                                                                {{msg.sms_from}}
                                                            </div>
                                                            <div class="m-messenger__message-text" style="word-break: break-all" v-html="msg.sms_text"></div>
                                                        </div>
                                                        <!-- <span class="badge badge-right">{{ data.status[msg.status] }}</span> -->
                                                    </div>
                                                </div>

                                                <div :class="msg.direction == 'O' ? 'm-messenger-datetime-right' : 'm-messenger-datetime-left'">{{msg.log_time | formatDate("ddd, MMM YY HH:mm A")}}</div>
                                            </div>
                                        
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="type_msg">
                                <div class="input_msg_write">                                    
                                <textarea id="s-msg" type="text" class="write_msg" v-model="message" v-validate="'required|max:'+data.sms_text_size" placeholder="Type a message"></textarea>
                                <span class="m-form__help" v-if="message.length > data.sms_text_size" style="color: #c12222">
                                            The Message field may not be greater than {{data.sms_text_size}} characters.
                                </span><br />
                                <span class="limiter">{{calculateSMSParts}}</span>
                                <span>
                                    <a id="insert-tag" href="javascript:void(0)" @click.prevent="showTag()"
                                       class="pull-right"><i class="bi bi-tags-fill" style="font-size: 1.0rem;"></i><span><label
                                            style="cursor:pointer;">Tag</label></span>

                                    </a>
                                    <span class="list-group tag-list pull-right">
                                    <div data-toggle="tooltip" data-placement="top" title="Insert tag" class="g-tooltip-area" data-original-title="Insert tag">
                                        <ul id="tag-list" class="list-group tag-list" style="display: none; z-index: 1;">
                                            <li class="list-group-item" @click.prevent="addContactItem('first_name')" ><a  href="#">First name</a></li>
                                            <li class="list-group-item" @click.prevent="addContactItem('last_name')" ><a  href="#">Last name</a></li>
                                            <li class="list-group-item" @click.prevent="addContactItem('company')" ><a  href="#">Company</a></li>
                                            <li class="list-group-item" @click.prevent="addContactItem('street')" ><a  href="#">Street</a></li>
                                            <li class="list-group-item" @click.prevent="addContactItem('suite')" ><a  href="#">Suite</a></li>
                                            <li class="list-group-item" @click.prevent="addContactItem('city')" ><a  href="#">City</a></li>
                                            <li class="list-group-item" @click.prevent="addContactItem('state')" ><a  href="#">State</a></li>
                                            <li class="list-group-item" @click.prevent="addContactItem('zip')" ><a  href="#">zip</a></li>

                                            <!--   <li  v-if="data.settings.custom_0_name" class="list-group-item"><a @click.prevent="addContactItem('custom_0')"  href="#">{{data.settings.custom_0_name}}</a></li>-->
                                            <!--   <li  v-if="data.settings.custom_1_name" class="list-group-item"><a @click.prevent="addContactItem('custom_1')"  href="#">{{data.settings.custom_1_name}}</a></li>-->
                                            <!--   <li  v-if="data.settings.custom_2_name" class="list-group-item"><a @click.prevent="addContactItem('custom_2')"  href="#">{{data.settings.custom_2_name}}</a></li>-->
                                            <!--   <li  v-if="data.settings.custom_3_name" class="list-group-item"><a @click.prevent="addContactItem('custom_3')"  href="#">{{data.settings.custom_3_name}}</a></li>-->
                                            <!--   <li  v-if="data.settings.custom_4_name" class="list-group-item"><a @click.prevent="addContactItem('custom_4')"  href="#">{{data.settings.custom_4_name}}</a></li>-->
                                            <!--   <li  v-if="data.settings.custom_5_name" class="list-group-item"><a @click.prevent="addContactItem('custom_5')"  href="#">{{data.settings.custom_5_name}}</a></li>-->
                                            <!--   <li  v-if="data.settings.custom_6_name" class="list-group-item"><a @click.prevent="addContactItem('custom_6')"  href="#">{{data.settings.custom_6_name}}</a></li>-->
                                            <!--   <li  v-if="data.settings.custom_7_name" class="list-group-item"><a @click.prevent="addContactItem('custom_7')"  href="#">{{data.settings.custom_7_name}}</a></li>-->
                                            <!--   <li  v-if="data.settings.custom_8_name" class="list-group-item"><a @click.prevent="addContactItem('custom_8')"  href="#">{{data.settings.custom_8_name}}</a></li>-->
                                            <!--   <li  v-if="data.settings.custom_9_name" class="list-group-item"><a @click.prevent="addContactItem('custom_9')"  href="#">{{data.settings.custom_9_name}}</a></li>-->
                                        </ul>
                                    </div>
                                </span>
                                </span>
                                <button class="msg_send_btn" @click="sendMessage()" type="button"><i class="fa fa-paper-plane-o" aria-hidden="true"></i></button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- inbox part end -->

                <!-- detail part start -->
                <div class="col-lg-4">
                    <div class="m-portlet m-portlet--mobile">
                        <div class="m-portlet__head">
                            <div class="m-portlet__head-caption">
                                <div class="m-portlet__head-title">
                                    <h3 class="m-portlet__head-text"> 
                                        Details
                                        
                                    </h3>
                                </div>
                            </div>
                        </div>
                        <div class="m-portlet__body">
                            <div class="m-widget28">
                                <div class="m-widget28__container">
                                    <div class="m-widget28__tab tab-content">
                                        <div class="m-widget28__tab-container tab-pane active">
                                            <div class="m-widget28__tab-items">
                                                <div class="m-widget28__tab-item">
                                                    <span>DID</span> <span>{{ from | formatPhone}}</span>
                                                </div> 
                                                <div class="m-widget28__tab-item">
                                                    <span>Client Number</span> <span>{{ to | formatPhone}}</span>
                                                </div> 
                                                <div class="m-widget28__tab-item">
                                                    <span>Total Inbound</span> <span>{{ (data.inbound[0]) ? data.inbound[0].Total : 0 }}</span>
                                                </div> 
                                                <div class="m-widget28__tab-item">
                                                    <span>Total Outbound</span> <span>{{ (data.outbound[0]) ? data.outbound[0].Total : 0 }}</span>
                                                </div>
                                                <div class="m-widget28__tab-item">
                                                    <span>Status</span>
                                                    <span>{{ data.contactStatus == "O" ? 'Close' : data.contactStatus == "I" ? 'Open' : 'N/A' }}</span>
                                                    <span>
                                                        <div v-if="data.contactStatus == 'I'"
                                                             class="g-close-box active btn btn-sm btn-success"
                                                             title="Opt-Out"
                                                             @click="dataCloseHandler">
                                                            Close
                                                        </div>
                                                    <div v-if="data.contactStatus == 'O'"
                                                         class="g-close-box active btn btn-sm btn-success"
                                                         title="Opt-In"
                                                         @click="dataCheckHandler">
                                                        Open
                                                    </div>
                                                    </span>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- detail part end -->
            <!-- END EXAMPLE TABLE PORTLET-->		        
            </div>
        </div>
    </div>
</template>

<script>
import AppComponent from '../../components/AppComponent'

export default {
  extends: AppComponent,
    data() {
        return {
            base_url: 'api/inbox-list/'+this.from+'/'+this.to,
            persons: [],
            scheduleShow: false,
            compose: {to : []},
            message: '',
            from: '',
            to: '',
            date: null,         
            data: {
                inbound : [],
                outbound : []
            },
            pagination: {},
        }
    },
    computed: {
        calculateSMSParts(){
        var
            smsType,
            smsLength = 0,
            smsCount = -1,
            charsLeft = 0,
            text = this.message,
            isUnicode = false;

            for(var charPos = 0; charPos < text.length; charPos++){
                switch(text[charPos]){
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
                if(text.charCodeAt(charPos) > 127 && text[charPos] != "€")
                isUnicode = true;
            }

            if(isUnicode){
                smsType = this.data.sms_text_lengths_unicode;//lengths.unicode;
                this.data.sms_text_size = 201;
            }
            else{
                smsType = this.data.sms_text_lengths_ascii;//lengths.ascii;
                this.data.sms_text_size = 459;
            }

            for(var sCount = 0; sCount < this.data.sms_text_part; sCount++){

                //this.cutStrLength = smsType[sCount];
                if(smsLength <= smsType[sCount]){

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

            return "Characters: " + smsLength + "/" + this.data.sms_text_size + " | " + "Parts: " + smsCount + "/" + this.data.sms_text_part;

    },
    charactersLeft() {
        var char = this.message.length,
            limit = this.data.sms_text_size;
        var remaining = limit - char;
          if(char > limit)
            char = limit;

        return "Characters: " + char + "/" + limit;
      },
      partsLeft() {
          var parts = this.message.length,limit = this.data.sms_text_part,part_size = this.data.sms_text_part_size;
          parts = Math.ceil(parts/part_size);
          var remaining = limit - parts;
          if(parts > limit)
            parts = limit;

        return "Parts: " + parts + "/" + limit;
      }
  },
    mounted() { 
        if(this.$route.params.from && this.$route.params.to){ 
            this.from = this.$route.params.from;
            this.to = this.$route.params.to;
            //console.log('From : '+this.from + 'To:'+ this.to);
            this.fetchInbound();
            this.bindCurrentRoute();
            this.scroll();
            document.addEventListener('click', this.hideTag);
        }
    },
    methods: {
        // Fetch List
        scroll () {
            var vm = this;
            let page = 1;
            window.onscroll = () => {
                if($(window).scrollTop() == 0){
                    //console.log('here'); 
                    page = page + 1;                   
                    if(page <= this.pagination.last_page){
                        //console.log(this.pagination.last_page);
                        commonLib.blockUI({target: ".m-content", animate: true, overlayColor: 'none', top:'45%'});
                        axios.get('api/inbox-list/'+this.from+'/'+this.to+'?page='+page)
                        .then(res => {
                            //this.data = res.data;
                            //console.log(res.data.data);                            
                            let html = '';
                            let class1,class2,log_time,sms_from,sms_to,sms_text,direction;
                            let arr = $.map(res.data.data.reverse(), function(elm, index) {
                                class1 = (elm['direction']=='O') ? 'm-messenger__message--out' :'m-messenger__message--in';
                                class2 = (elm['direction']=='O') ? 'm-messenger-datetime-right' :'m-messenger-datetime-left';
                                log_time = vm.getDate(elm['log_time'],"ddd, MMM YY HH:mm A");sms_from = elm['direction'];sms_text = elm['sms_text'];
                                html += '<div class="m-messenger__wrapper"><div class="m-messenger__message '+class1+'"><div class="m-messenger__message-body"><div class="m-messenger__message-arrow"></div> <div class="m-messenger__message-content"><div class="m-messenger__message-username"></div> <div style="word-break: break-all" class="m-messenger__message-text">'+sms_text+'</div></div></div></div> <div class="'+class2+'">'+log_time+'</div></div>';
                            });                       
                            $("#mCSB_22_container").prepend(html);
                            commonLib.unblockUI(".m-content");
                        })
                        .catch( function(error) {
                            commonLib.iniToastrNotification("warning", "Warning", "Data could not be loaded.");
                            commonLib.unblockUI(".m-content");
                        }); 
                    }
                }
                
            };
        },
        getFormateDate(date){
            return this.$getFormateDate(date);
        },
        getDate(date, format){
            return moment(String(date)).format(format)
        },
        pushMessage(log_time){
            this.data.data.push({log_time: log_time, did:this.from,client:this.to,sms_text: this.message,status:'P',direction:'O'});
        },
        sendMessage() {
                    if(this.message.length > this.data.sms_text_size){
                        return;
                    }
                    var vm = this;
                    this.compose.to = this.to;
                    this.compose.from = this.from;
                    this.compose.message = this.message;
                    this.compose.scheduleShow = this.scheduleShow;
                    axios.post('api/reply-create', this.compose).then((res) => 
                    {
                        commonLib.iniToastrNotification(res.data.response_msg.type, res.data.response_msg.title, res.data.response_msg.message);
                        if(res.data.response_msg.type == 'success'){
                            var localTime = new Date().toLocaleString("en-US", {timeZone: this.data.timezone});                       
                            this.pushMessage(localTime);
                            //this.fetchInbound();
                            this.compose = {};
                            this.message = "";
                        }
                        commonLib.unblockUI(".m-content");
                    })
                    .catch(function (error) {
                        vm.validationErrors = error.response.data;
                        commonLib.unblockUI(".m-content");
                    });
        },

        dataCheckHandler() {
            console.log("Working Check Handler = " + this.to);
            let url = `api/open-leads/${this.to}`;
            if (this.to) {
                commonLib.blockUI({target: ".m-content", animate: true, overlayColor: 'none', top: '45%'});
                axios.get(url).then((res) => {
                    commonLib.iniToastrNotification(res.data.response_msg.type, res.data.response_msg.title, res.data.response_msg.message);
                    commonLib.unblockUI(".m-content");
                    this.data.contactStatus = 'I';
                })
                    .catch(function (error) {
                        console.log(error.response);
                    });
            }
        },

        dataCloseHandler() {
            console.log("Working Close Handler = " + this.to);

            let url = `api/close-leads/${this.to}`;
            if (this.to) {
                commonLib.blockUI({target: ".m-content", animate: true, overlayColor: 'none', top: '45%'});
                axios.get(url).then((res) => {
                    commonLib.iniToastrNotification(res.data.response_msg.type, res.data.response_msg.title, res.data.response_msg.message);
                    commonLib.unblockUI(".m-content");
                    this.data.contactStatus = 'O';
                })
                    .catch(function (error) {
                        console.log(error.response);
                    });
            }

        },
        
        fetchInbound(page_url) {            
            page_url = page_url || 'api/inbox-list/'+this.from+'/'+this.to+'?page='+this.pagination.current_page;
            this.getPagiDataReverse(page_url);
        },

        addContactItem(item) {
            console.log(item);
            // let currentMessage = currentElement.innerText || currentElement.textContent;
            let cursorPosition = $("textarea#s-msg").prop('selectionStart');
            let currentMessage = $('textarea#s-msg').val();
            console.log(currentMessage);
            console.log(cursorPosition);
            currentMessage = currentMessage.substring(0,cursorPosition) + '{'+item+'}' + currentMessage.substring(cursorPosition);
            console.log(currentMessage);
            $('textarea#s-msg').val(currentMessage);
            $('#tag-list').hide();
        },

        showTag() {
            $('#tag-list').toggle();
        },
        hideTag(e) {
            // Get the element that was clicked
            const clickedElement = e.target;
            // Get the element that contains the #tag-list element
            const tagListContainer = $('#insert-tag').parent();
            // Check if the clicked element is outside the tag list container
            if (!tagListContainer.is(clickedElement) && tagListContainer.has(clickedElement).length === 0) {
                $('#tag-list').hide();
            }
        },
    },
    beforeMount() {
        //this.getInitialUsers();
    },
    beforeDestroy() {
        // Remove event listener from the document object
        document.removeEventListener('click', this.hideTag);
    }

}
</script>

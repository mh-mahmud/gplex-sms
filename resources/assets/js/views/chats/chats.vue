<template>
    <div class="m-grid__item m-grid__item--fluid m-wrapper">
        <js-plugin :js-plugin="data.js_plugin"></js-plugin>
        <!-- BreadCrumb -->
        <!-- <breadcrumb :breadcrumb-data="data.breadcrumb"></breadcrumb> -->
        <div class="m-content" ref="fullscreen">
            <div class="m-portlet m-portlet--mobile">
                <div class="m-portlet__head">
                    <div class="m-portlet__head-caption">
                        <div class="m-portlet__head-title">

                            <div class="g-chattop-header">
                                <h3 class="m-portlet__head-text mb-0">
                                    Chats: New Window
                                </h3>
                                <button class="btn btn-sm btn-default invisible" @click="toggleFullScreen"><i
                                        class="bi bi-arrows-fullscreen"></i>
                                </button>
                            </div>


                        </div>
                    </div>

                </div>
                <div class="m-portlet__body">
                    <!--begin: Datatable -->
                    <div id="m_table_1_wrapper" class="dataTables_wrapper container-fluid dt-bootstrap4 no-footer">

                        <!--**********************************
                                      New Chat Window
                         ***********************************-->

                        <div class="row">
                            <div class="col-md-12">
                                <div class="g-chat-area">

                                    <div class="g-chat-header">
                                        <div class="new-chat-open">
                                            <i class="bi bi-chat-right-text-fill"></i> <strong>Chat List</strong>
                                            <!--                      <div class="search-container">-->
                                            <!--                        <i class="bi bi-search search-icon"></i>-->
                                            <!--                        <input type="text" v-model="search" v-on:keyup="onSearch" placeholder="Search...">-->
                                            <!--                      </div>-->
                                        </div>

                                        <div class="g-open-chat-header">
                                            <div class="g-open-chat-h-main">
                                                <div class="g-chat-user-profile">
                                                    <img :src="imageUrl" alt="">
                                                    <div class="g-chat-u-name">
                                                        <div class="g-chat-u-meta">
                                                            <strong class="mb-0">{{ chatHeadFirstName }}
                                                                {{ chatHeadLastName }}</strong>
                                                            <small>{{ chatHeadPhone }}</small>
                                                        </div>
                                                        <div v-if="chatHeadPhone"
                                                             @click.prevent="bindDispositionData(chatHeadPhone, callid)"
                                                             class="g-chat-notes" data-toggle="modal"
                                                             data-target="#disposition-modal">
                                                            <small v-if="chatHeadPhone">Note</small>
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="g-chat-user-property">

                                                    <!--                          <div class="search-container">-->
                                                    <!--                            <i class="bi bi-search search-icon"></i>-->
                                                    <!--                            <input type="text" placeholder="Search...">-->
                                                    <!--                          </div>-->
                                                    <div v-if="chatHeadFirstName && chatFlag == 'open'"
                                                         class="g-close-box active btn btn-sm btn-success"
                                                         @click="dataCloseHandler">
                                                        <i class="bi bi-x-lg"></i>
                                                    </div>
                                                    <div v-if="chatHeadFirstName && chatFlag == 'close'"
                                                         class="g-close-box active btn btn-sm btn-success"
                                                         @click="dataCheckHandler">
                                                        <i class="bi bi-check2"></i>
                                                    </div>

                                                </div>

                                            </div>
                                        </div>
                                    </div>


                                    <div class="g-chat-body">

                                        <!--      Left List Item-->
                                        <div class="g-chat-left">
                                            <div id="open-chat">
                                                <ul @scroll="scrollCustomBottom">
                                                    <li class="chat-box" v-for="(item, key) in openData"
                                                        :data-target="'content-'+key"
                                                        v-on:click="greet(item); selectItem(key)"
                                                        :class="{active: activeIndex === key}">
                                                        <div class="g-left-u-profile">
                                                            <div class="g-chat-left-u-image">
                                                                <img :src="imageUrl" alt="">
                                                            </div>
                                                            <div class="g-chat-left-u-meta">
                                                                <strong class="mb-0">{{
                                                                    item.first_name ? item.first_name : item.phone
                                                                    }}
                                                                    {{ item.last_name }} </strong>
                                                                <small v-if="item.sms_text">{{
                                                                    item.sms_text.substr(0, 15)
                                                                    }}</small>
                                                                <small :id="'serving-' + key" class="serving"
                                                                       style="display: none"><span class="text-right"
                                                                                                   style="color: #3cffed;">Serving...</span></small>
                                                            </div>
                                                            <div v-if="item.status == 'U'" :id="'alert-' + key"
                                                                 class=""><span class="text-right"><i
                                                                    class="bi bi-bell-fill" style="color: #f70606;"></i></span>
                                                            </div>
                                                        </div>
                                                    </li>
                                                </ul>
                                            </div>


                                            <div id="close-chat">
                                                <ul>

                                                    <li class="chat-box" v-for="(item2, key2) in closeData"
                                                        :data-target="'content-'+key2"
                                                        v-on:click="greet(item2)">
                                                        <div class="g-left-u-profile">
                                                            <div class="g-chat-left-u-image">
                                                                <img :src="imageUrl" alt="">
                                                            </div>
                                                            <div class="g-chat-left-u-meta">
                                                                <strong class="mb-0">{{ item2.first_name }}
                                                                    {{ item2.last_name }}</strong>
                                                                <small v-if="item2.sms_text">{{
                                                                    item2.sms_text.substr(0, 15)
                                                                    }}</small>
                                                            </div>
                                                        </div>
                                                    </li>


                                                </ul>
                                            </div>


                                            <div class="g-button-group">
                                                <button id="open-btn" class="btn btn-sm">Open</button>
                                                <button id="close-btn" class="btn btn-sm">Close</button>
                                            </div>
                                        </div>

                                        <!--Right Chat Area-->
                                        <div class="g-chat">

                                            <div class="g-chat-history" id="g-chat-history"
                                                 v-chat-scroll @v-chat-scroll-top-reached="scrollAtTop">

                                                <div id="content-1" class="content active" v-for="msg in chatInfo.data">
                                                    <div class="g-chat-main">
                                                        <!-- <div class="text-center">
                                                          <small class="text-white">
                                                            Feb 22, 2023
                                                          </small>
                                                        </div> -->
                                                        <div class=""
                                                             :class="msg.direction == 'O' ? 'chat-msg-content' :'chat-msg-content msg-other'">
                                                            <div class="chat-msg">
                                                                {{ msg.sms_text }}


                                                                <time>
                                  <span style="font-size:10px" v-if="msg.direction=='O'">
                                    <i v-if="msg.userid">{{ msg.userid }} - </i>
                                  </span>
                                                                    {{
                                                                    msg.log_time | formatDate("ddd, MMM YY HH:mm A")
                                                                    }}
                                                                </time>
                                                            </div>
                                                            <div class="chat-msg-image">
                                                                <img :src="msg.direction == 'O' ? imageUrl : 'https://picsum.photos/50/50'"
                                                                     alt="">
                                                            </div>
                                                        </div>
                                                    </div>


                                                </div>

                                                <!-- show user this instant message -->
                                                <div id="content-2" class="content active">
                                                    <div class="g-chat-main" v-if="instantSmsData.text">
                                                        <div class="chat-msg-content">
                                                            <div class="chat-msg">
                                                                {{ instantSmsData.text }}
                                                                <time datetime="6:00">{{
                                                                    instantSmsData.timesend
                                                                    }}
                                                                </time>
                                                            </div>
                                                            <div class="chat-msg-image">
                                                                <img :src="imageUrl" alt="">
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>

                                            </div>


                                            <div class="g-chat-message">
                                                <!-- <form action=""> -->

                                                <!--                                                <label for="s-msg" class="w-100">-->
                                                <!--                          <textarea data-vv-as="Message" name="message" v-model="message" class="form-control" cols="30"-->
                                                <!--                                    rows="5" placeholder="Write...." id="s-msg"></textarea>-->
                                                <!--                                                </label>-->



                                                <!--New Contenteditable TextArea-->

                                                <div id="s-msg" class="text-editable tag-item" v-model="message" contenteditable="true">

                                                </div>


                                                <div class="g-chat-message-bottom">
                                                    <div class="g-chat-attachment">
                                                        <!-- <select v-model="selectedValue" id="template" name="template"
                                                                class="form-control form-control-sm" @change="onChangeTemplate(this.value)">
                                                          <option value="" selected>-- Choose Template --</option>
                                                          <option v-for="(value,key) in templateData"
                                                                  :value="value.message">
                                                            {{ value.name }}
                                                          </option>
                                                        </select> -->


                                                        <a href="javascript:void(0)"
                                                           @click.prevent="bindModalData(data)" data-toggle="modal"
                                                           data-target="#template-modal" class="btn btn-sm btn-default"
                                                           title="Insert Template"><i
                                                                class="bi bi-file-earmark-text-fill"></i></a>

                                                        <div class="g-date-picker">
                                                            <input type="date">
                                                        </div>

                                                        <div v-if="chatHeadPhone" data-toggle="tooltip"
                                                             data-placement="top" title="Insert tag"
                                                             class="g-tooltip-area"
                                                             data-original-title="Insert tag">
                                                            <button @click="showTag()" id="btn-insert-tag"
                                                                    title="Insert tag" type="button"
                                                                    class="btn btn-sm btn-default">
                                                                <i class="bi bi-tags-fill"></i>
                                                            </button>
                                                            <ul id="tag-list" class="list-group tag-list"
                                                                style="display: none">
                                                                <li v-if="contactData.first_name"
                                                                    class="list-group-item"><a
                                                                        @click.prevent="addContactItem('first_name')"
                                                                        href="#">First name</a></li>
                                                                <li v-if="contactData.last_name"
                                                                    class="list-group-item"><a
                                                                        @click.prevent="addContactItem('last_name')"
                                                                        href="#">Last name</a></li>
                                                                <li v-if="contactData.company" class="list-group-item">
                                                                    <a @click.prevent="addContactItem('company')"
                                                                       href="#">Company</a></li>
                                                                <li v-if="contactData.street" class="list-group-item"><a
                                                                        @click.prevent="addContactItem('street')"
                                                                        href="#">Street</a></li>
                                                                <li v-if="contactData.suite" class="list-group-item"><a
                                                                        @click.prevent="addContactItem('suite')"
                                                                        href="#">Suite</a></li>
                                                                <li v-if="contactData.city" class="list-group-item"><a
                                                                        @click.prevent="addContactItem('city')"
                                                                        href="#">City</a></li>
                                                                <li v-if="contactData.state" class="list-group-item"><a
                                                                        @click.prevent="addContactItem('state')"
                                                                        href="#">State</a></li>
                                                                <li v-if="contactData.zip" class="list-group-item"><a
                                                                        @click.prevent="addContactItem('zip')" href="#">zip</a>
                                                                </li>

                                                                <li v-if="contactData.custom_0" class="list-group-item">
                                                                    <a @click.prevent="addContactItem(contactData.custom_0)"
                                                                       href="#">{{ settings.custom_0_name }}</a></li>
                                                                <li v-if="contactData.custom_1" class="list-group-item">
                                                                    <a @click.prevent="addContactItem(contactData.custom_1)"
                                                                       href="#">{{ settings.custom_1_name }}</a></li>
                                                                <li v-if="contactData.custom_2" class="list-group-item">
                                                                    <a @click.prevent="addContactItem(contactData.custom_2)"
                                                                       href="#">{{ settings.custom_2_name }}</a></li>
                                                                <li v-if="contactData.custom_3" class="list-group-item">
                                                                    <a @click.prevent="addContactItem(contactData.custom_3)"
                                                                       href="#">{{ settings.custom_3_name }}</a></li>
                                                                <li v-if="contactData.custom_4" class="list-group-item">
                                                                    <a @click.prevent="addContactItem(contactData.custom_4)"
                                                                       href="#">{{ settings.custom_4_name }}</a></li>
                                                                <li v-if="contactData.custom_5" class="list-group-item">
                                                                    <a @click.prevent="addContactItem(contactData.custom_5)"
                                                                       href="#">{{ settings.custom_5_name }}</a></li>
                                                                <li v-if="contactData.custom_6" class="list-group-item">
                                                                    <a @click.prevent="addContactItem(contactData.custom_6)"
                                                                       href="#">{{ settings.custom_6_name }}</a></li>
                                                                <li v-if="contactData.custom_7" class="list-group-item">
                                                                    <a @click.prevent="addContactItem(contactData.custom_7)"
                                                                       href="#">{{ settings.custom_7_name }}</a></li>
                                                                <li v-if="contactData.custom_8" class="list-group-item">
                                                                    <a @click.prevent="addContactItem(contactData.custom_8)"
                                                                       href="#">{{ settings.custom_8_name }}</a></li>
                                                                <li v-if="contactData.custom_9" class="list-group-item">
                                                                    <a @click.prevent="addContactItem(contactData.custom_9)"
                                                                       href="#">{{ settings.custom_9_name }}</a></li>
                                                            </ul>
                                                        </div>

                                                    </div>


                                                    <button @click="sendMessage()" class="btn btn-primary btn-sm">SEND
                                                    </button>


                                                </div>
                                                <!-- </form> -->

                                            </div>


                                        </div>


                                        <div v-if="chatHeadPhone" class="g-chat-right">
                                            <div class="table-responsive">
                                                <table class="table table-bordered table-sm table-striped mb-0">
                                                    <thead>
                                                    <tr class="text-center">
                                                        <th colspan="3">Contact Details</th>
                                                    </tr>
                                                    </thead>
                                                    <tbody>
                                                    <tr>
                                                        <td>First Name</td>
                                                        <td>
                                                            <input :data-vv-as="chatHeadFirstName" name="first_name"
                                                                   v-model="contactData.first_name" type="text"
                                                                   class="form-control m-input">
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td>Last Name</td>
                                                        <td>
                                                            <input :data-vv-as="chatHeadLastName" name="last_name"
                                                                   v-model="contactData.last_name" type="text"
                                                                   class="form-control m-input">
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td>Phone</td>
                                                        <td>
                                                            <input :data-vv-as="chatHeadPhone" name="phone"
                                                                   v-model="contactData.phone" type="text"
                                                                   class="form-control m-input">
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td>Company</td>
                                                        <td>
                                                            <input :data-vv-as="contactData.company" name="company"
                                                                   v-model="contactData.company" type="text"
                                                                   class="form-control m-input">
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td>Street</td>
                                                        <td>
                                                            <input :data-vv-as="contactData.street" name="street"
                                                                   v-model="contactData.street" type="text"
                                                                   class="form-control m-input">
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td>Suite</td>
                                                        <td>
                                                            <input :data-vv-as="contactData.suite" name="suite"
                                                                   v-model="contactData.suite" type="text"
                                                                   class="form-control m-input">
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td>City</td>
                                                        <td>
                                                            <input :data-vv-as="contactData.city" name="city"
                                                                   v-model="contactData.city" type="text"
                                                                   class="form-control m-input">
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td>State</td>
                                                        <td>
                                                            <input :data-vv-as="contactData.state" name="state"
                                                                   v-model="contactData.state" type="text"
                                                                   class="form-control m-input">
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td>Zip</td>
                                                        <td>
                                                            <input :data-vv-as="contactData.zip" name="zip"
                                                                   v-model="contactData.zip" type="text"
                                                                   class="form-control m-input">
                                                        </td>
                                                    </tr>
                                                    <tr v-if="(settings.custom_0_name !='')">
                                                        <td>{{ settings.custom_0_name }}</td>
                                                        <td>
                                                            <input :data-vv-as="contactData.custom_0" name="custom_0"
                                                                   v-model="contactData.custom_0" type="text"
                                                                   class="form-control m-input">
                                                        </td>
                                                    </tr>
                                                    <tr v-if="(settings.custom_1_name !='')">
                                                        <td>{{ settings.custom_1_name }}</td>
                                                        <td>
                                                            <input :data-vv-as="contactData.custom_1" name="custom_1"
                                                                   v-model="contactData.custom_1" type="text"
                                                                   class="form-control m-input">
                                                        </td>
                                                    </tr>
                                                    <tr v-if="(settings.custom_2_name !='')">
                                                        <td>{{ settings.custom_2_name }}</td>
                                                        <td>
                                                            <input :data-vv-as="contactData.custom_2" name="custom_2"
                                                                   v-model="contactData.custom_2" type="text"
                                                                   class="form-control m-input">
                                                        </td>
                                                    </tr>
                                                    <tr v-if="(settings.custom_3_name !='')">
                                                        <td>{{ settings.custom_3_name }}</td>
                                                        <td>
                                                            <input :data-vv-as="contactData.custom_3" name="custom_3"
                                                                   v-model="contactData.custom_3" type="text"
                                                                   class="form-control m-input">
                                                        </td>
                                                    </tr>
                                                    <tr v-if="(settings.custom_4_name !='')">
                                                        <td>{{ settings.custom_4_name }}</td>
                                                        <td>
                                                            <input :data-vv-as="contactData.custom_4" name="custom_4"
                                                                   v-model="contactData.custom_4" type="text"
                                                                   class="form-control m-input">
                                                        </td>
                                                    </tr>
                                                    <tr v-if="(settings.custom_5_name !='')">
                                                        <td>{{ settings.custom_5_name }}</td>
                                                        <td>
                                                            <input :data-vv-as="contactData.custom_5" name="custom_5"
                                                                   v-model="contactData.custom_5" type="text"
                                                                   class="form-control m-input">
                                                        </td>
                                                    </tr>
                                                    <tr v-if="(settings.custom_6_name !='')">
                                                        <td>{{ settings.custom_6_name }}</td>
                                                        <td>
                                                            <input :data-vv-as="contactData.custom_6" name="custom_6"
                                                                   v-model="contactData.custom_6" type="text"
                                                                   class="form-control m-input">
                                                        </td>
                                                    </tr>
                                                    <tr v-if="(settings.custom_7_name !='')">
                                                        <td>{{ settings.custom_7_name }}</td>
                                                        <td>
                                                            <input :data-vv-as="contactData.custom_7" name="custom_7"
                                                                   v-model="contactData.custom_7" type="text"
                                                                   class="form-control m-input">
                                                        </td>
                                                    </tr>
                                                    <tr v-if="(settings.custom_8_name !='')">
                                                        <td>{{ settings.custom_8_name }}</td>
                                                        <td>
                                                            <input :data-vv-as="contactData.custom_8" name="custom_8"
                                                                   v-model="contactData.custom_8" type="text"
                                                                   class="form-control m-input">
                                                        </td>
                                                    </tr>
                                                    <tr v-if="(settings.custom_9_name !='')">
                                                        <td>{{ settings.custom_9_name }}</td>
                                                        <td>
                                                            <input :data-vv-as="contactData.custom_9" name="custom_9"
                                                                   v-model="contactData.custom_9" type="text"
                                                                   class="form-control m-input">
                                                        </td>
                                                    </tr>

                                                    <!--                          </tr>-->

                                                    <!--                            <td><small><button @click="updateContact()" class="btn btn-primary btn-sm">Update Contact</button></small></td>-->
                                                    <!--                          </tr>-->


                                                    <tr>
                                                        <td><small>&nbsp;</small></td>
                                                        <td><small>
                                                            <button @click="updateContact()"
                                                                    class="btn btn-primary btn-sm">Update Contact
                                                            </button>
                                                        </small></td>
                                                    </tr>

                                                    </tbody>
                                                </table>
                                            </div>
                                        </div>

                                    </div>


                                </div>

                            </div>
                        </div>


                        <!--            End Chat Window-->

                        <!-- template modal -->
                        <template-modal v-bind:modal-data="modalData"></template-modal>



                        <!--            Disposition Modal-->
                        <disposition-modal v-bind:disposition-data="dispositionData"></disposition-modal>




                        <!--            Disposition Modal-->
                        <disposition-modal v-bind:disposition-data="dispositionData"></disposition-modal>



                    </div>
                </div>
            </div>
            <!-- END EXAMPLE TABLE PORTLET-->
        </div>
    </div>
</template>

<style lang="scss" scoped>

    /*============================
         CrossBrowser ScrollBar
      ============================*/
    * {
        scrollbar-width: thin;
        scrollbar-color: rgba(104, 106, 102, 0.5), rgba(0, 0, 0, 0.099);
    }

    ::-webkit-scrollbar {
        width: 5px; /* for vertical scrollbars */
        height: auto; /* for horizontal scrollbars */
    }

    ::-webkit-scrollbar-track {
        background: rgba(0, 0, 0, 0.099);
    }

    ::-webkit-scrollbar-thumb {
        background: rgba(104, 106, 102, 0.5);
        border-radius: 30px;
    }

    .m-input {
        height: 25px;
        font-size: 12px;
    }

    /*============================
             New Chat Area
      ============================*/
    .m-portlet__head-title {
        width: 100%;
        height: auto !important;
    }

    .g-chattop-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
    }

    .g-chat-area {
        min-height: 65vh;
        background-color: #fafafa;
    }

    .g-chat-header {
        display: flex;
        height: 45px;
    }

    .new-chat-open {
        width: 25%;
        background-color: darken(#fafafa, 5%);
        color: #484848;
        display: flex;
        align-items: center;
        gap: 0.3rem;
        padding: 0.3rem;
        border-right: 1px solid darken(#fafafa, 15%);
        border-bottom: 1px solid #f8f8f8;
        font-size: 13px;
        white-space: nowrap;
    }

    .g-open-chat-header {
        background-color: darken(#fafafa, 5%);
        flex-grow: 1;
        width: 100%;
    }

    .g-open-chat-h-main {
        display: flex;
        align-items: center;
        height: 100%;
        padding-left: 0.3rem;;
    }

    .g-chat-user-profile {
        display: flex;
        align-items: center;
        gap: 10px;
        height: 100%;

        img {
            width: 38px;
            height: 38px;
            border-radius: 50%;
        }
    }

    .g-chat-u-name {
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 5px;

        strong {
            line-height: 1.4;
            font-size: 13px;
        }

        small {
            line-height: 1;
        }
    }

    .g-chat-u-meta {
        display: flex;
        flex-direction: column;
        justify-content: center;
        align-items: center;
    }

    .g-chat-notes {
        small {
            background-color: #329e8c;
            color: #ffffff;
            padding: 0.2rem;
            border-radius: 0.5rem;
            line-height: 1;
            vertical-align: middle;
            cursor: pointer;
            transition: all 0.4s ease-in-out;

            &:hover {
                background-color: darken(#329e8c, 10%);
            }
        }

    }

    .g-chat-user-property {
        margin-left: auto;
        margin-right: 25%;
        display: flex;
        justify-content: center;
        align-items: center;
        gap: 5px;
    }


    /*============================
             Search
      ============================*/
    .search-container {
        position: relative;
        margin-left: auto;
    }

    .search-icon {
        position: absolute;
        top: 50%;
        left: 10px;
        transform: translateY(-50%);
        font-size: 1rem;
        color: #ccc;
        cursor: pointer;
        transition: all 0.3s ease;
    }

    .search-container input[type="text"] {
        width: 0;
        max-width: 0;
        padding: 12px 20px;
        margin: 8px 0;
        box-sizing: border-box;
        border: none;
        border-bottom: 2px solid transparent;
        transition: all 0.3s ease;
        background-color: transparent;
    }

    .search-container input[type="text"]:focus {
        outline: none;
        border-bottom: 2px solid #329e8c;
    }

    .search-container.active .search-icon {
        left: 10px;
        color: #329e8c;
    }

    .search-container.active input[type="text"] {
        max-width: 150px;
        width: 100%;
        margin-left: 10px;
    }


    /*============================
            Chat Body
      ============================*/
    .g-chat-body {
        display: flex;
        height: calc(65vh - 30px);
    }

    .g-chat-left {
        width: 232px;
        background-color: #444753;
        flex-basis: 20%;
        position: relative;
        border-bottom-left-radius: 10px;
        border-bottom-right-radius: 10px;

        ul {
            margin: 0;
            padding: 0;
            list-style: none;
            height: calc(100% - 30px);
            overflow-y: auto;
        }

        ul li {
            cursor: pointer;
            padding: 0.3rem;
            display: block;
            transition: all 0.4s ease-in-out;
            color: darken(#ffffff, 25%);

            &:hover {
                background-color: #555555;
                color: #ffffff;
            }

        }
    }

    /*============================
             New Chat Area
      ============================*/
    .g-chat-area {
        min-height: 65vh;
        background-color: #fafafa;
    }

    .chat-box {
        padding: 13px !important;
        border-bottom: 1px solid #333;
    }

    .g-chat-header {
        display: flex;
        height: 45px;
    }

    .new-chat-open {
        width: 25%;
        background-color: darken(#fafafa, 5%);
        color: #484848;
        display: flex;
        align-items: center;
        gap: 0.3rem;
        padding: 0.3rem;
        border-right: 1px solid darken(#fafafa, 15%);
        border-bottom: 1px solid #f8f8f8;
        font-size: 13px;
        white-space: nowrap;
    }

    .g-open-chat-header {
        background-color: darken(#fafafa, 5%);
        flex-grow: 1;
        width: 100%;
    }

    .g-open-chat-h-main {
        display: flex;
        align-items: center;
        height: 100%;
        padding-left: 0.3rem;;
    }

    .g-chat-user-profile {
        display: flex;
        align-items: center;
        gap: 10px;
        height: 100%;

        img {
            width: 38px;
            height: 38px;
            border-radius: 50%;
        }
    }

    .g-chat-u-name {
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 5px;

        strong {
            line-height: 1.4;
            font-size: 13px;
        }

        small {
            line-height: 1;
        }
    }

    .g-chat-u-meta {
        display: flex;
        flex-direction: column;
        justify-content: center;
        align-items: center;
    }

    .g-chat-notes {
        small {
            background-color: #329e8c;
            color: #ffffff;
            padding: 0.2rem;
            border-radius: 0.5rem;
            line-height: 1;
            vertical-align: middle;
            cursor: pointer;
            transition: all 0.4s ease-in-out;

            &:hover {
                background-color: darken(#329e8c, 10%);
            }
        }

    }

    .g-chat-user-property {
        margin-left: auto;
        margin-right: 25%;
    }


    /*============================
             Search
      ============================*/
    .search-container {
        position: relative;
        margin-left: auto;
    }

    .search-icon {
        position: absolute;
        top: 50%;
        left: 10px;
        transform: translateY(-50%);
        font-size: 1rem;
        color: #ccc;
        cursor: pointer;
        transition: all 0.3s ease;
    }

    .search-container input[type="text"] {
        width: 0;
        max-width: 0;
        padding: 12px 20px;
        margin: 8px 0;
        box-sizing: border-box;
        border: none;
        border-bottom: 2px solid transparent;
        transition: all 0.3s ease;
        background-color: transparent;
    }

    .search-container input[type="text"]:focus {
        outline: none;
        border-bottom: 2px solid #329e8c;
    }

    .search-container.active .search-icon {
        left: 10px;
        color: #329e8c;
    }

    .search-container.active input[type="text"] {
        max-width: 150px;
        width: 100%;
        margin-left: 10px;
    }


    /*============================
            Chat Body
      ============================*/
    .g-chat-body {
        display: flex;
    }

    .g-chat-left {
        width: 232px;
        background-color: #444753;
        flex-basis: 20%;
        position: relative;
        height: calc(65vh - 30px);

        ul {
            margin: 0;
            padding: 0;
            list-style: none;
            height: calc(100% - 30px);
            overflow-y: auto;
        }

        ul li {
            cursor: pointer;
            padding: 0.3rem;
            display: block;
            transition: all 0.4s ease-in-out;
            color: darken(#ffffff, 25%);

            &:hover {
                background-color: #555555;
                color: #ffffff;
            }

            &.active {
                background-color: #b39240;
                color: #ffffff;

                &:hover {
                    color: inherit;
                }
            }
        }
    }

    .g-button-group {
        position: absolute;
        bottom: 0;
        left: 0;
        display: flex;
        justify-content: space-around;
        align-items: center;
        width: 100%;

        button {
            width: 100%;
            background-color: #646879;
            color: #ffffff;
        }

        button#open-btn {
            background-color: #329e8c;
        }
    }

    .g-chat {
        flex: 2;
        width: 100%;
        background-color: #ffffff;
        padding: 1rem;
    }

    .content {
        transition: all 0.4s ease;
        display: none;
        opacity: 0;
        visibility: hidden;
    }

    .content.active {
        transition: all 0.4s ease;
        display: block;
        opacity: 1;
        visibility: visible;
    }


    /*============================
             Left List Item
      ============================*/
    .g-left-u-profile {
        display: flex;
        gap: 5px;
        align-items: center;
        height: 40px;
    }

    .g-chat-left-u-image {
        img {
            width: 40px;
            height: 40px;
            border-radius: 50%;
            object-fit: cover;
            -o-object-fit: cover;
        }
    }

    .g-chat-left-u-meta {
        display: flex;
        flex-direction: column;

        strong {
            line-height: 1.2;
            font-size: 0.9rem;
        }

        small {
            line-height: 1;
        }
    }


    /*============================
             Main Chat Format
      ============================*/
    .g-chat {

    }

    .g-chat-history {
        width: auto;
        margin: auto auto 0.5rem;
        height: calc(65vh - 215px);
        overflow-y: auto;
        padding: 1rem;
    }

    .chat-msg-content {
        display: flex;
        gap: 0.5rem;
        align-items: flex-end;
        margin-bottom: 1rem;
        justify-content: flex-end;

        .chat-msg {
            background-color: #dcdee7;
            border-radius: 0.3rem;
            padding: 0.5rem;
            position: relative;
            max-width: 86%;
            min-width: 60%;

            time {
                font-size: 12px;
                display: block;
                float: right;
                width: 100%;
            }
        }

        .chat-msg-image {
            img {
                width: 40px;
                height: 40px;
                border-radius: 50%;
                object-fit: cover;
            }

        }
    }

    .chat-msg-content {
        &.msg-other {
            display: flex;
            gap: 0.5rem;
            align-items: flex-end;
            margin-bottom: 1rem;
            flex-direction: row-reverse;
            clear: both;

            & .chat-msg {
                background-color: #e8e8e8;
                color: #434652;
                clear: both;
                max-width: 86%;
                min-width: 60%;


                time {
                    font-size: 12px;
                    display: block;
                    width: 100%;
                    float: right;
                    clear: both;
                }
            }
        }
    }

    .g-chat-message {
        background-color: #f8f8f8;
        padding: 0.5rem;
        border-radius: 5px;
        position: relative;
        margin-left: -0.5rem;
        margin-right: -0.5rem;
        box-shadow: rgba(0, 0, 0, 0.16) 0 1px 4px;
    }

    .g-chat-message-bottom {
        display: flex;
        justify-content: space-between;
        align-items: center;
    }

    .g-chat-attachment {
        display: flex;
        justify-content: center;
        align-items: center;
        flex-shrink: 0;
        gap: 10px;
        font-size: 1rem;

        label > input[type=file] {
            visibility: hidden;
            width: 0;
        }

        i {
            cursor: pointer;
            color: #329e8c;
            font-weight: bold;
            display: inline-block;
            padding: 0.1rem;
            font-size: 1.3rem;
        }

        a {
            flex-shrink: 0;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 7px;

        }
    }



    /*============================
            Chat Right Parts
      ============================*/
    .g-chat-right {
        background-color: #eaeaea;
        flex-basis: 20%;
        overflow-y: auto;
    }


    #open-chat, #close-chat {
        display: none;
    }

    #open-chat {
        display: block;
        height: 100%;
        overflow-y: auto;
    }

    #close-chat {
        height: 100%;
        overflow-y: auto;
    }

    .g-date-picker {
        position: relative;

        &::before {
            content: "";
            position: absolute;
            background-color: #ffffff;
            width: 15px;
            height: 30px;
            left: 2px;
            top: 2px;
            bottom: 2px;
        }

        input {
            width: 35px;
            height: 35px;
            appearance: none;
            border: 1px solid #dddddd;
            border-radius: 4px;

            &::-webkit-calendar-picker-indicator {
                position: relative;
                right: 8px;
                color: green;
                cursor: pointer;
            }

            /**
         * @script clear current chat
         * */
        }


    }

    .list-group-item:last-child {
        margin-bottom: 0;
        border-bottom-right-radius: .25rem;
        border-bottom-left-radius: .25rem;
        display: block;
        min-width: 130px;
        text-align: center;
    }


    /*============================
             CheckBox
      ============================*/
    .g-check-box, .g-close-box {
        display: none;
    }

    .g-close-box.active {
        display: block;
    }

    /*============================
             For Tag list
      ============================*/
    .g-tooltip-area {
        position: relative;
    }

    .tag-list {
        line-height: 1;
        position: absolute;
        max-height: 250px;
        height: auto;
        overflow-y: auto;
        left: auto;
        top: auto;
        bottom: 35px;
    }

    .tag-item > span{
        padding: 1px 5px;
        height: 22px;
        margin: 0 2px;
        font-size: 13px;
        line-height: 14px;
        position: relative;
        display: inline-block;
        vertical-align: middle;
        max-width: 98%;
        overflow: hidden;
        border: 2px solid #d8e6f5;
        border-radius: 13px;
        background-color: #fff;
        color: #025d86;
        font-weight: 700;
        text-decoration: none;
        white-space: nowrap;
        cursor: default;
        text-overflow: ellipsis;
    }

    .tag-list > li > a {
        font-size: 13px;
        font-weight: 600;
        color: #015d85;
        text-decoration: none;
    }

    .tag-list > li:hover {
        background-color: #329d8b;

        & a {
            color: #ffffff;
        }
    }

    //overwrite rule
    .list-group-item {
        position: relative;
        display: block;
        padding: .25rem 0.5rem;
        margin-bottom: -1px;
        background-color: #fff;
        border: 1px solid rgba(0, 0, 0, .125);
    }


    /*============================
          New Content Editable
      ============================*/
    .text-editable {
        background-color: #ffffff;
        margin-bottom: 1rem;
        min-height: 100px;
        padding: 0.5rem;
        border-radius: 5px;
        box-shadow: rgba(0, 0, 0, 0.16) 0 1px 4px;

        &:focus-visible {
            outline: 1px solid #329d8b;
        }
    }

</style>

<script>

    import Vue from 'vue';
    import VueChatScroll from 'vue-chat-scroll';

    Vue.use(VueChatScroll);
    import AppComponent from '../../components/AppComponent';
    import TemplateModal from '../compose/template_modal';
    import DispositionModal from "../compose/disposition_modal.vue";


    export default {
        extends: AppComponent,
        components: {
            DispositionModal,
            TemplateModal
        },
        data() {
            return {
                data: {},
                modalData: {},
                dispositionData: {},
                chatInfo: {},
                contactData: {},
                prevSmsData: {},
                selectedValue: {}, // First option will be selected by default
                templateData: {},
                openData: {},
                settings: {},
                openDataForSearch: {},
                closeData: {},
                message: "",
                instantSmsData: {},
                scheduleShow: false,
                compose: {to: []},
                chatHeadFirstName: null,
                chatHeadLastName: null,
                chatHeadPhone: null,
                chatHeadCompany: null,
                chatHeadSmsText: null,
                chatBoxMessage: "",
                isActive: false,
                activeIndex: -1,
                search: "",
                imageUrl: BASE_URL + '/public/assets/app/media/img/users/user-avatar.png',
                interval: null,
                lastUpdate: "",
                currentDate: "",
                chatFlag: "open"
            };
        },
        mounted() {
            this.fullScreen = this.$refs.fullscreen;
            this.chatsView();
            this.bindCurrentRoute("Chats");
            this.interval = setInterval(() => this.openChatsView(), 9000);

            const leftItems = document.querySelectorAll('.g-chat-left li');
            const contentItems = document.querySelectorAll('.g-chat .content');
            // Get all the td elements
            const tds = document.querySelectorAll('td');
            const searchIcons = document.querySelectorAll('.search-icon');
            // For Toggle Hide And Show
            // Get the button and div elements
            const openBtn = document.getElementById("open-btn");
            const closeBtn = document.getElementById("close-btn");
            const openChat = document.getElementById("open-chat");
            const closeChat = document.getElementById("close-chat");
            const closeBox = document.querySelector(".g-close-box");
            const checkBox = document.querySelector(".g-check-box");
            const selectTemplate = document.getElementById("template");

            // Add event listener to the document object
            document.addEventListener('click', this.hideTag);


            leftItems.forEach(item => {
                item.addEventListener('click', () => {
                    // Remove active class from all list items
                    leftItems.forEach(item => item.classList.remove('active'));

                    // Add active class to clicked item
                    item.classList.add('active');

                    // Show corresponding content item and hide others
                    contentItems.forEach(content => {
                        if (content.id === item.dataset.target) {
                            content.classList.add('active');
                            console.log("Hi bro");
                        } else {
                            content.classList.remove('active');
                            console.log("papana");
                        }
                    });
                });
            });

            tds.forEach((td) => {
                // Check if it's the last or third td
                if (td === td.parentNode.lastElementChild || td === td.parentNode.children[2]) {
                    //Cursor Pointer Style
                    td.style.cursor = 'pointer'

                    // Add a click event listener
                    td.addEventListener('click', () => {
                        // Get the second td element
                        const secondTd = td.parentNode.children[1];

                        // Make it contenteditable
                        secondTd.contentEditable = true;
                        secondTd.focus();
                    });
                }
            });

            searchIcons.forEach(function (searchIcon) {
                searchIcon.addEventListener('click', function () {
                    const searchContainer = searchIcon.parentElement;
                    searchContainer.classList.toggle('active');
                });
            });

            // Add click event listeners to the buttons
            openBtn.addEventListener("click", () => {
                openChat.style.display = "block";
                closeChat.style.display = "none";
                openBtn.style.backgroundColor = "#329e8c";
                closeBtn.style.backgroundColor = "#5a5e6d";
                this.chatFlag = "open";
                this.clearCurrentCaht();
                // checkBox.style.display = "none";
                // closeBox.style.display = "block";
            });

            closeBtn.addEventListener("click", () => {
                openChat.style.display = "none";
                closeChat.style.display = "block";
                closeBtn.style.backgroundColor = "#329e8c";
                openBtn.style.backgroundColor = "#5a5e6d";
                this.chatFlag = "close";
                this.clearCurrentCaht();
                // closeBox.style.display = "none";
                // checkBox.style.display = "block";
            });


        },
        destroyed() {
            clearInterval(this.interval)
        },
        methods: {
            /**
             * @script  For Close Handler
             * */

            dataCloseHandler() {
                console.log("Working Close Handler = " + this.chatHeadPhone);

                let url = `api/close-leads/${this.chatHeadPhone}`;
                if (this.chatHeadPhone) {
                    commonLib.blockUI({target: ".m-content", animate: true, overlayColor: 'none', top: '45%'});
                    axios.get(url).then((res) => {
                        // console.log(this.openData);
                        let openResult = {[this.chatHeadPhone]: this.openData[this.chatHeadPhone]};
                        let result = {...this.closeData, ...openResult};
                        this.closeData = result;
                        this.$delete(this.openData, this.chatHeadPhone);
                        commonLib.iniToastrNotification(res.data.response_msg.type, res.data.response_msg.title, res.data.response_msg.message);
                        commonLib.unblockUI(".m-content");
                        this.clearCurrentCaht();

                    })
                        .catch(function (error) {
                            console.log(error.response);
                        });
                }

            },
            /**
             * @script  For Check Handler
             * */
            dataCheckHandler() {
                console.log("Working Check Handler = " + this.chatHeadPhone);
                let url = `api/open-leads/${this.chatHeadPhone}`;
                if (this.chatHeadPhone) {
                    commonLib.blockUI({target: ".m-content", animate: true, overlayColor: 'none', top: '45%'});
                    axios.get(url).then((res) => {
                        // console.log(this.openData);
                        let closeResult = {[this.chatHeadPhone]: this.closeData[this.chatHeadPhone]};
                        let result = {...this.openData, ...closeResult};
                        this.openData = result;
                        this.$delete(this.closeData, this.chatHeadPhone);
                        commonLib.iniToastrNotification(res.data.response_msg.type, res.data.response_msg.title, res.data.response_msg.message);
                        commonLib.unblockUI(".m-content");
                        this.clearCurrentCaht();

                    })
                        .catch(function (error) {
                            console.log(error.response);
                        });
                }


            },

            /**
             * @script  Initialize when chat history scroll reached at bottom
             * */
            scrollAtBottom(event) {
                const element = event.target
                if (element.scrollHeight - element.scrollTop === element.clientHeight) {
                    // do something when scrolled to the bottom
                    alert('Im at bottom');
                }
            },
            /**
             * @script  Initialize when chat history scroll reached at bottom
             * */
            scrollCustomBottom(event) {
                const element = event.target
                if (element.scrollHeight - element.scrollTop === element.clientHeight) {
                    // do something when scrolled to the bottom
                    let lastValue = this.openData[Object.keys(this.openData).pop()].log_time;
                    // console.log(lastValue);
                    let url = `api/previous-chats/${lastValue}`;
                    if (this.lastUpdate) {
                        axios.get(url).then((res) => {
                            // console.log(this.openData);
                            if (typeof res.data.lastUpdate !== 'undefined') {
                                let result = res.data.openChat;
                                result = {...this.openData, ...result};
                                this.lastUpdate = res.data.lastUpdate;
                                this.openData = result;
                            }
                        })
                            .catch(function (error) {
                                console.log(error.response);
                            });
                    }
                }
            },


            /**
             * @script  Initialize when chat history scroll reached at top
             * */
            scrollAtTop() {
                console.log('I am at top');
            },


            /**
             * @script array object based search
             * */
            onSearch() {
                if (this.search && this.search !== '') {
                    let chatData = this.openData;
                    console.log(chatData);
                    let result = chatData.filter((item) => {
                        if (item.first_name.toLowerCase().includes(this.search.toLowerCase())) {
                            return item
                        }
                    })
                    console.log(result);
                }

            },

            toggleFullScreen() {
                if (!document.fullscreenElement) {
                    this.fullScreen.requestFullscreen();
                    this.fullscreen.style.height = '100vh';
                } else {
                    document.exitFullscreen();
                }
            },
            selectItem: function (index) {
                // remove active state from previously active item
                if (this.activeIndex !== -1) {
                    this.$set(this.openData[this.activeIndex], 'isActive', false);
                }

                // toggle active state of clicked item
                this.$set(this.openData[index], 'isActive', !this.openData[index].isActive);
                this.activeIndex = index;
            },
            chatsView() {
                var url = 'api/chats';
                axios.get(url).then((res) => {
                    this.data = res.data;
                    this.templateData = res.data.templateInfoNew;
                    this.openData = res.data.openChat;
                    this.settings = res.data.settings;
                    this.openDataForSearch = res.data.openChat;
                    this.closeData = res.data.closeChat;
                    this.lastUpdate = res.data.lastUpdate;
                    console.log(this.openData);
                    console.log(this.closeData);
                    this.$setDocumentTitle(this.data.title);
                })
                    .catch(function (error) {
                        console.log(error.response);
                    });
            },
            openChatsView() {
                let url = `api/open-chats/${this.lastUpdate}`;
                let self = this;
                if (this.lastUpdate) {
                    axios.get(url).then((res) => {
                        // console.log(this.openData);
                        if (typeof res.data.lastUpdate !== 'undefined') {
                            let result = res.data.openChat;
                            result = {...result, ...this.openData};
                            this.lastUpdate = res.data.lastUpdate;
                            this.openData = result;
                            // console.log(this.openData);
                            let newResult = res.data.openChat;
                            $.each(newResult, function (index, value) {
                                self.openData[index] = value;
                            });
                        }
                    })
                        .catch(function (error) {
                            console.log(error.response);
                        });
                }

            },


            onChangeTemplate(event) {
                // console.log(this.selectedValue);
                const chatBox = document.getElementById("s-msg");
                chatBox.value = this.selectedValue;
                // this.chatBoxMessage = this.selectedValue;
            },

            /**
             * @script clear current chat
             * */

            clearCurrentCaht() {
                this.chatInfo = {};
                this.chatHeadPhone = null;
                this.chatHeadFirstName = null;
                this.chatHeadLastName = null;
                this.activeIndex = -1;
                if ($('#tag-list').css('display') != 'none') {
                    $('#tag-list').hide();
                }
            },


            greet: function (itemInfo) {

                this.chatHeadFirstName = itemInfo.first_name;
                this.chatHeadLastName = itemInfo.last_name;
                this.chatHeadPhone = itemInfo.phone;
                this.chatHeadCompany = itemInfo.company;
                this.chatHeadSmsText = itemInfo.sms_text;
                this.callid = itemInfo.callid;

                // contact data
                this.contactData = {
                    custom_data: true,
                    id: itemInfo.id,
                    first_name: itemInfo.first_name,
                    last_name: itemInfo.last_name,
                    phone: itemInfo.phone,
                    company: itemInfo.company,
                    street: itemInfo.street,
                    zip: itemInfo.zip,
                    suite: itemInfo.suite,
                    city: itemInfo.city,
                    state: itemInfo.state,
                    phone_type: 'M',
                    custom_0: itemInfo.custom_0,
                    custom_1: itemInfo.custom_1,
                    custom_2: itemInfo.custom_2,
                    custom_3: itemInfo.custom_3,
                    custom_4: itemInfo.custom_4,
                    custom_5: itemInfo.custom_5,
                    custom_6: itemInfo.custom_6,
                    custom_7: itemInfo.custom_7,
                    custom_8: itemInfo.custom_8,
                    custom_9: itemInfo.custom_9

                };

                $('#' + 'alert-' + itemInfo.phone).hide();
                $('.serving').hide();
                $('#' + 'serving-' + itemInfo.phone).show();
                var url = `api/chat-info/${itemInfo.phone}`;
                axios.get(url).then((res) => {
                    this.chatInfo = res.data;
                    this.prevSmsData = res.data;
                    this.instantSmsData = {};
                    this.message = "";

                }).catch(function (error) {
                    console.log(error.response);
                });

            },

            updateContact() {

                var contact = this.contactData;
                var contact_id = contact.id;
                if (contact.first_name == '' || contact.first_name == null) {
                    alert("First name is required");
                    return;
                }
                console.log(this.contactData);
                //return;

                // Update
                this.$validator.validateAll().then((result) => {

                    if (result == true) {
                        if (typeof commonLib != 'undefined') {
                            commonLib.blockUI({target: ".m-content", animate: true, overlayColor: 'none'});
                        }
                        let vm = this;


                        if (contact_id === null) {

                            axios.post('api/contacts', this.contactData).then((res) => {
                                commonLib.iniToastrNotification(res.data.response_msg.type, res.data.response_msg.title, res.data.response_msg.message);
                                if (res.data.response_msg.type == 'success') {
                                    //this.$router.push({name:'Chats'});
                                    //alert("Contact saved successfully");
                                }
                                commonLib.unblockUI(".m-content");
                            })
                                .catch(function (error) {
                                    vm.validationErrors = error.response.data;
                                    commonLib.unblockUI(".m-content");
                                });
                        } else {
                            this.contactData._method = 'PUT';
                            axios.post("api/contacts/" + contact_id, this.contactData).then((res) => {
                                commonLib.iniToastrNotification(res.data.response_msg.type, res.data.response_msg.title, res.data.response_msg.message);
                                if (res.data.response_msg.type == 'success') {
                                    //this.$router.push({name:'Chats'});
                                    //alert("Contact updated successfully");
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

            },

            sendMessage() {
                let phoneValue;
                let didValue;
                // var localTime = new Date().toLocaleString("en-US", {timeZone: this.data.timezone});
                var localTime = new Date().toLocaleString("en-US", {timeZone: 'America/Los_Angeles'});
                const smsBoxData = document.getElementById("s-msg").value;

                if (smsBoxData.length <= 0) {
                    return;
                }

                if (!this.chatHeadPhone) {
                    alert("Please select a contact from sidebar");
                    return;
                }

                if (this.prevSmsData.data[0]) {
                    phoneValue = this.prevSmsData.data[0].client_number;
                    didValue = this.prevSmsData.data[0].did;
                } else {
                    phoneValue = this.chatHeadPhone;
                    didValue = "19723182200";
                }

                // SEND SMS DATA
                this.instantSmsData = {
                    text: smsBoxData,
                    timesend: localTime
                };


                /*if(this.message.length > this.data.sms_text_size){
                    return;
                }*/
                var vm = this;
                this.compose.to = phoneValue;
                this.compose.from = didValue;
                this.compose.message = smsBoxData;
                this.compose.scheduleShow = this.scheduleShow;
                axios.post('api/reply-create', this.compose).then((res) => {

                    commonLib.iniToastrNotification(res.data.response_msg.type, res.data.response_msg.title, res.data.response_msg.message);
                    console.log(res.data.response_msg);
                    if (res.data.response_msg.type == 'success') {

                        this.selectedValue = {};
                        const chatBox = document.getElementById("s-msg");
                        chatBox.value = "";

                        this.message = "";
                        console.log("All done from now");
                    }
                    commonLib.unblockUI(".m-content");
                })
                    .catch(function (error) {
                        console.log("All end from now");
                        /*vm.validationErrors = error.response.data;
                        commonLib.unblockUI(".m-content");*/
                    });
            },

            // bind data to use on modal
            bindModalData(data) {
                this.modalData = data;
            },

            // bind data to use on modal
            bindDispositionData(clientNumber, clientCallid) {
                console.log(clientNumber);
                console.log(clientCallid);
                this.dispositionData = {
                    clientNumber: clientNumber,
                    clientCallid: clientCallid
                };
                console.log(this.modalData);
            },

            showTag() {
                $('#tag-list').toggle();
            },


            hideTag(e) {
                // Get the element that was clicked
                const clickedElement = e.target;

                // Get the element that contains the #tag-list element
                const tagListContainer = $('#btn-insert-tag').parent();

                // Check if the clicked element is outside the tag list container
                if (!tagListContainer.is(clickedElement) && tagListContainer.has(clickedElement).length === 0) {
                    $('#tag-list').hide();
                }

            },


            addContactItem(item) {
                let currentElement = document.getElementById('s-msg');
                let currentMessage = currentElement.innerText || currentElement.textContent;
                let mySpan = document.createElement("span");
                mySpan.innerHTML = item;
                mySpan.setAttribute('contenteditable', 'false'); // make the span tag non-editable
                currentElement.appendChild(mySpan);
                currentElement.appendChild(document.createElement("br")); // add a non-editable line break
                let range = document.createRange();
                range.setStartAfter(mySpan.nextElementSibling); // set the range after the br tag
                range.collapse(true); // collapse the range to the end
                let sel = window.getSelection();
                sel.removeAllRanges();
                sel.addRange(range); // set the focus to the end of the range
                $('#tag-list').hide();
            }


            // addContactItem(item) {
            //     let currentElement = document.getElementById('s-msg');
            //     let currentMessage = currentElement.innerText || currentElement.textContent;
            //     let mySpan = document.createElement("span");
            //     mySpan.innerHTML = item;
            //     currentElement.appendChild(mySpan);
            //     currentElement.appendChild(document.createTextNode('\u00A0')); // add a text node
            //     let range = document.createRange();
            //     range.setStartAfter(mySpan); // set the range after the span element
            //     range.collapse(true); // collapse the range to the end
            //     let sel = window.getSelection();
            //     sel.removeAllRanges();
            //     sel.addRange(range); // set the focus to the end of the range
            //     $('#tag-list').hide();
            // }


        },

        beforeDestroy() {
            // Remove event listener from the document object
            document.removeEventListener('click', this.hideTag);
        }
    };


</script>

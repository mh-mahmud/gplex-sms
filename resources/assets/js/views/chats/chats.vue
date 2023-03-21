<template>
  <div class="m-grid__item m-grid__item--fluid m-wrapper">
    <js-plugin :js-plugin="data.js_plugin"></js-plugin>
    <!-- BreadCrumb -->
    <breadcrumb :breadcrumb-data="data.breadcrumb"></breadcrumb>
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
                      <i class="bi bi-chat-right-text-fill"></i> <strong>New Chat</strong>
                      <div class="search-container">
                        <i class="bi bi-search search-icon"></i>
                        <input type="text" v-model="search" v-on:keyup="onSearch" placeholder="Search...">
                      </div>
                    </div>

                    <div class="g-open-chat-header">
                      <div class="g-open-chat-h-main">
                        <div class="g-chat-user-profile">
                          <img :src="imageUrl" alt="">
                          <div class="g-chat-u-name">
                            <div class="g-chat-u-meta">
                              <strong class="mb-0">{{ chatHeadFirstName }} {{ chatHeadLastName }}</strong>
                              <small>{{ chatHeadPhone }}</small>
                            </div>
                            <!-- <div class="g-chat-notes">
                              <small>2 notes</small>
                            </div> -->
                          </div>
                        </div>

                        <div class="g-chat-user-property">
                          <div class="search-container">
                            <i class="bi bi-search search-icon"></i>
                            <input type="text" placeholder="Search...">
                          </div>

                        </div>

                      </div>
                    </div>
                  </div>


                  <div class="g-chat-body">

                    <!--      Left List Item-->
                    <div class="g-chat-left">
                      <div id="open-chat">
                        <ul>

                          <li class="chat-box" v-for="(item, key) in openData" :data-target="'content-'+key"
                              v-on:click="greet(item); selectItem(key)" :class="{active: activeIndex === key}">
                            <div class="g-left-u-profile">
                              <div class="g-chat-left-u-image">
                                <img :src="imageUrl" alt="">
                              </div>
                              <div class="g-chat-left-u-meta">
                                <strong class="mb-0">{{ item.first_name }} {{ item.last_name }}</strong>
                                <small v-if="item.sms_text">{{ item.sms_text.substr(0, 15) }}</small>
                              </div>
                            </div>
                          </li>


                        </ul>
                      </div>


                      <div id="close-chat">
                        <ul>

                          <li class="chat-box" v-for="(item2, key2) in closeData" :data-target="'content-'+key2"
                              v-on:click="greet(item2)">
                            <div class="g-left-u-profile">
                              <div class="g-chat-left-u-image">
                                <img :src="imageUrl" alt="">
                              </div>
                              <div class="g-chat-left-u-meta">
                                <strong class="mb-0">{{ item2.first_name }} {{ item2.last_name }}</strong>
                                <small v-if="item2.sms_text">{{ item2.sms_text.substr(0, 15) }}</small>
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
                           v-chat-scroll
                           @v-chat-scroll-top-reached="reachedBottom">

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
                                <time datetime="6:00">{{ msg.log_time | formatDate("ddd, MMM YY HH:mm A") }}</time>
                              </div>
                              <div class="chat-msg-image">
                                <img :src="msg.direction == 'O' ? imageUrl : 'https://picsum.photos/50/50'" alt="">
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
                                <time datetime="6:00">{{ instantSmsData.timesend }}</time>
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
                        <label for="s-msg" class="w-100">
                          <textarea data-vv-as="Message" name="message" v-model="message" class="form-control" cols="30"
                                    rows="5" placeholder="Write...." id="s-msg"></textarea>
                        </label>

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


                            <a href="javascript:void(0)" @click.prevent="bindModalData(data)" data-toggle="modal"
                               data-target="#template-modal" class="btn btn-sm btn-default"><i
                                class="m-menu__link-icon flaticon-list" style="font-size: 1.0rem;"></i><span><label
                                style="cursor:pointer;margin-bottom: 0">Insert Template</label></span></a>

                            <div class="g-date-picker">
                              <i class="bi bi-calendar-week"></i>

                              <date-picker v-model="date" @dp-hide="doSomethingOnHide" @dp-change="doSomethingOnChange"
                                           :config="{format: 'DD-MM-YYYY'}">

                              </date-picker>
                            </div>

                          </div>


                          <button @click="sendMessage()" class="btn btn-secondary btn-sm">SEND</button>


                        </div>
                        <!-- </form> -->

                      </div>


                    </div>


                    <div v-if="chatHeadPhone" class="g-chat-right">
                      <div class="table-responsive">
                        <table class="table table-bordered table-sm table-striped">
                          <thead>
                          <tr class="text-center">
                            <th colspan="3">Contact Details</th>
                          </tr>
                          </thead>
                          <tbody>
                          <tr>
                            <td><small>First Name</small></td>
                            <td><small>{{ chatHeadFirstName }}</small></td>
                            <td><small class="bi bi-pencil-square"></small></td>
                          </tr>
                          <tr>
                            <td><small>Last Name</small></td>
                            <td><small>{{ chatHeadLastName }}</small></td>
                            <td><small class="bi bi-pencil-square"></small></td>
                          </tr>
                          <tr>
                            <td><small>Phone</small></td>
                            <td><small>{{ chatHeadPhone }}</small></td>
                            <td><small class="bi bi-pencil-square"></small></td>
                          </tr>
                          <tr>
                            <td><small>Company</small></td>
                            <td><small>{{ chatHeadCompany }}</small></td>
                            <td><small class="bi bi-pencil-square"></small></td>
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
  height: 44vh;
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
  top: 0.5rem;
  position: relative;
  margin-left: -0.5rem;
  margin-right: -0.5rem;
  box-shadow: rgba(0, 0, 0, 0.16) 0 1px 4px;
}

.g-chat-message-bottom {
  display: flex;
  justify-content: space-between;
  align-items: center;
  margin-top: 0.5rem;
}

.g-chat-attachment {
  display: flex;
  justify-content: center;
  align-items: center;
  flex-shrink: 0;
  gap: 10px;

  label > input[type=file] {
    visibility: hidden;
    width: 0;
  }

  i {
    font-size: 1.2rem;
    cursor: pointer;
    color: #329e8c;
    font-weight: bold;
    display: inline-block;
    padding: 0.2rem;
  }

  a {
    flex-shrink: 0;
    display: flex;
    align-items: center;
    justify-content: center;
    padding: 8px;

  }
}


/*============================
        Chat Right Parts
  ============================*/
.g-chat-right {
  background-color: #eaeaea;
  flex-basis: 20%;
}


#open-chat, #close-chat {
  display: none;
}

#open-chat {
  display: block;
  height: calc(100% - 5px);
  overflow-y: auto;
}

#close-chat {
  height: calc(100% - 5px);
  overflow-y: auto;
}

.g-date-picker {
  position: relative;

  i {
    position: absolute;
    right: 5px;
    top: 50%;
    transform: translateY(-50%);
  }
}

</style>

<script>

import Vue from 'vue';
import VueChatScroll from 'vue-chat-scroll';

Vue.use(VueChatScroll);
import AppComponent from '../../components/AppComponent';
import TemplateModal from '../compose/template_modal';


export default {
  extends: AppComponent,
  components: {
    TemplateModal
  },
  data() {
    return {
      data: {},
      modalData: {},
      chatInfo: {},
      prevSmsData: {},
      selectedValue: {}, // First option will be selected by default
      templateData: {},
      openData: {},
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
      lastUpdate: ""
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
    const selectTemplate = document.getElementById("template");


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
    });

    closeBtn.addEventListener("click", () => {
      openChat.style.display = "none";
      closeChat.style.display = "block";
      closeBtn.style.backgroundColor = "#329e8c";
      openBtn.style.backgroundColor = "#5a5e6d";
    });


  },
  destroyed() {
    clearInterval(this.interval)
  },
  methods: {
    reachedBottom() {

    },

    onSearch() {
      if (this.search && this.search !== '') {
        this.openData = this.openData.filter((item) => {
          if (item.first_name.toLowerCase().includes(this.search.toLowerCase())) {
            return item
          }
        })

      } else {
        this.openData = this.openDataForSearch;
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
      if (this.lastUpdate) {
        axios.get(url).then((res) => {
          // console.log(this.openData);
          if (typeof res.data.lastUpdate !== 'undefined') {
            let result = res.data.openChat;
            result = {...result, ...this.openData};
            this.lastUpdate = res.data.lastUpdate;
            this.openData = result;
          }
          // console.log(this.openData);
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


    greet: function (itemInfo) {
      console.log(itemInfo);
      this.chatHeadFirstName = itemInfo.first_name;
      this.chatHeadLastName = itemInfo.last_name;
      this.chatHeadPhone = itemInfo.phone;
      this.chatHeadCompany = itemInfo.company;
      this.chatHeadSmsText = itemInfo.sms_text;

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

    /*pushMessage(log_time){
        this.data.data.push({log_time: log_time, did:this.from,client:this.to,sms_text: this.message,status:'P',direction:'O'});
    },*/

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


  }
};


</script>

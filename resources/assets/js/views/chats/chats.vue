<template>
  <div class="m-grid__item m-grid__item--fluid m-wrapper">
    <js-plugin :js-plugin="data.js_plugin"></js-plugin>
    <!-- BreadCrumb -->
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
                        <input type="text" placeholder="Search...">
                      </div>
                    </div>

                    <div class="g-open-chat-header">
                      <div class="g-open-chat-h-main">
                        <div class="g-chat-user-profile">
                          <img src="https://picsum.photos/50/50" alt="">
                          <div class="g-chat-u-name">
                            <div class="g-chat-u-meta">
                              <strong class="mb-0">Alkarim Hasan</strong>
                              <small>015565598345</small>
                            </div>
                            <div class="g-chat-notes">
                              <small>2 notes</small>
                            </div>
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

                          <li v-for="(item, key) in openData" :data-target="'content-'+key" v-on:click="greet(item)">
                            <div class="g-left-u-profile">
                              <div class="g-chat-left-u-image">
                                <img src="https://picsum.photos/50/50" alt="">
                              </div>
                              <div class="g-chat-left-u-meta">
                                <strong class="mb-0">{{ item.first_name }} {{ item.last_name }}</strong>
                                <small>{{ item.phone }}</small>
                              </div>
                            </div>
                          </li>


                        </ul>
                      </div>


                      <div id="close-chat">
                        <ul>

                          <li v-for="(item2, key2) in closeData" :data-target="'content-'+key2">
                            <div class="g-left-u-profile">
                              <div class="g-chat-left-u-image">
                                <img src="https://picsum.photos/50/50" alt="">
                              </div>
                              <div class="g-chat-left-u-meta">
                                <strong class="mb-0">{{ item2.first_name }} {{ item2.last_name }}</strong>
                                <small>{{ item2.phone }}</small>
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

                      <div class="g-chat-history" id="g-chat-history">

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
                                <img src="https://picsum.photos/50/50" alt="">
                              </div>
                            </div>
                          </div>
                        </div>

                      </div>


                      <div class="g-chat-message">
                        <form action="">
                          <label for="s-msg" class="w-100">
                            <textarea class="form-control" name="" cols="30" rows="2" placeholder="Write...."
                                      id="s-msg"></textarea>
                          </label>

                          <div class="g-chat-message-bottom">
                            <div class="g-chat-attachment">
                              <select v-model="selectedValue" id="template" name="template"
                                      class="form-control form-control-sm" @change="onChangeTemplate(this.value)">
                                <option value="" selected>-- Choose Template --</option>
                                <option v-for="(value,key) in templateData"
                                        :value="value.message">
                                  {{ value.name }}
                                </option>
                              </select>
                            </div>

                            <button class="btn btn-secondary btn-sm">SEND</button>
                          </div>
                        </form>

                      </div>


                    </div>


                    <div class="g-chat-right">
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
                            <td><small>Momin Riyadh</small></td>
                            <td><small class="bi bi-pencil-square"></small></td>
                          </tr>
                          <tr>
                            <td><small>Last Name</small></td>
                            <td><small>Support</small></td>
                            <td><small class="bi bi-pencil-square"></small></td>
                          </tr>
                          <tr>
                            <td><small>Email</small></td>
                            <td><small>email@email.com</small></td>
                            <td><small class="bi bi-pencil-square"></small></td>
                          </tr>
                          <tr>
                            <td><small>Company</small></td>
                            <td><small>GSL</small></td>
                            <td><small class="bi bi-pencil-square"></small></td>
                          </tr>
                          <tr>
                            <td><small>Country</small></td>
                            <td><small>United States</small></td>
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

          </div>
        </div>
      </div>
      <!-- END EXAMPLE TABLE PORTLET-->
    </div>
  </div>
</template>

<style lang="scss" scoped>
@import url("https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.3/font/bootstrap-icons.css");

/*============================
     CrossBrowser ScrollBar
  ============================*/
* {
  scrollbar-width: thin;
  scrollbar-color: rgba(112, 141, 63, 0.5), rgba(0, 0, 0, 0.099);
}

::-webkit-scrollbar {
  width: 5px; /* for vertical scrollbars */
  height: auto; /* for horizontal scrollbars */
}

::-webkit-scrollbar-track {
  background: rgba(0, 0, 0, 0.099);
}

::-webkit-scrollbar-thumb {
  background: rgba(115, 144, 66, 0.5);
  border-radius: 30px;
}


/*============================
         New Chat Area
  ============================*/
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
  background-color: #ffffff;
  padding: 0.5rem;
  border-radius: 5px;
  top: 0.5rem;
  position: relative;
  margin-left: -0.5rem;
  margin-right: -0.5rem;
}

.g-chat-message-bottom {
  display: flex;
  justify-content: space-between;
  align-items: center;
  margin-top: 0.5rem;
}

.g-chat-attachment {
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
}

</style>

<script>
import AppComponent from '../../components/AppComponent'

export default {
  extends: AppComponent,
  data() {
    return {
      data: {},
      chatInfo: {},
      selectedValue: {}, // First option will be selected by default
      templateData: {},
      openData: {},
      closeData: {},
      items: [
        {id: 1, title: 'Item 1', target: 'content1'},
        {id: 2, title: 'Item 2', target: 'content2'},
        {id: 3, title: 'Item 3', target: 'content3'},
      ],
      contents: [
        {id: 'content1', text: 'Content 1'},
        {id: 'content2', text: 'Content 2'},
        {id: 'content3', text: 'Content 3'},
      ],
    };
  },
  mounted() {
    this.chatsView();
    this.bindCurrentRoute("Chats");

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
  methods: {
    chatsView() {
      var url = 'api/chats';
      axios.get(url).then((res) => {
        this.data = res.data;
        this.templateData = res.data.templateInfoNew;
        this.openData = res.data.openChat;
        this.closeData = res.data.closeChat;
        console.log(this.openData);
        console.log(this.closeData);
        this.$setDocumentTitle(this.data.title);
      })
          .catch(function (error) {
            console.log(error.response);
          });
    },

    onChangeTemplate(event) {
      console.log(this.selectedValue);
      const chatBox = document.getElementById("s-msg");
      chatBox.value = this.selectedValue;
    },


    greet: function (itemInfo) {
      console.log(itemInfo);

      var url = `api/chat-info/${itemInfo.phone}`;
      axios.get(url).then((res) => {
        this.chatInfo = res.data;
      }).catch(function (error) {
        console.log(error.response);
      });

    }

  }
};


</script>

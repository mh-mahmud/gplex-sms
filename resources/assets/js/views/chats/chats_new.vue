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

                      <!-- start here -->

                      <div class="chat-container clearfix" style="height: 841px;">
                        <div class="chat-aside">
                          <div class="chat-header">
                            <section class="new-chat">
                              <button id="btn-start-new-chat" class="start-new-chat">
                                <i class="tmi30 tmi30-buble-chat-plus tmi30-18px"></i> New Chat </button>
                              <a class="hide-form a-hide-form" style="display: none;">Cancel</a>
                              <ul class="chat-contact-list-controls">
                                <li>
                                  <button title="Search chats" id="btn-show-chat-search" class="control">
                                    <i class="tmi30 tmi30-loupe tmi30-15px"></i>
                                  </button>
                                </li>
                                <li class="dropdown">
                                  <button data-toggle="dropdown" title="Chats actions" id="btn-show-chat-settings" class="control dropdown-toggle">
                                    <i class="tmi30 tmi30-gear tmi30-15px"></i>
                                  </button>
                                  <ul class="dropdown-menu tmi30-ul pull-right">
                                    <li style="">
                                      <a href="#">
                                        <i class="tmi30 tmi30-li tmi30-pencil tmi30-12px"></i> Edit chats </a>
                                    </li>
                                    <li>
                                      <a href="#">
                                        <i class="tmi30 tmi30-li tmi30-envelope-open tmi30-12px"></i> Mark all as read </a>
                                    </li>
                                    <li>
                                      <a href="#">
                                        <i class="tmi30 tmi30-li tmi30-close tmi30-12px"></i> Close all read chats </a>
                                    </li>
                                    <li>
                                      <a href="#notificationSettingsModal" data-toggle="modal">
                                        <i class="tmi30 tmi30-li tmi30-notifications-active tmi30-12px"></i> Notifications settings </a>
                                    </li>
                                    <li>
                                      <a href="#callsSettingsModal" data-toggle="modal">
                                        <i class="tmi30 tmi30-li tmi30-handset tmi30-12px"></i> Calls settings </a>
                                    </li>
                                    <li>
                                      <a href="#">
                                        <i class="tmi30 tmi30-li tmi30-eye tmi30-10px" style="padding: 5px 0px 0px 6px;"></i> Show only unread chats </a>
                                    </li>
                                    
                                    <li>
                                      <a href="#" onclick="document.getElementById('show-tutorial-chat-wistia').click();">
                                        <i class="fa fa-video-camera" style="position: absolute; left: 1em; width: 2.14286em; top: 0.892857em; text-align: center;"></i> Watch tutorial </a>
                                    </li>
                                  </ul>
                                </li>
                              </ul>
                            </section>
                            <section class="search" style="display: none;">
                              <a class="hide-form a-hide-form">Cancel</a>
                              <form action="" class="form-contacts-search">
                                <input autofocus="autofocus" type="text" id="input-chat-search" placeholder="Search chats..." autocomplete="off" maxlength="80" class="form-control-search">
                              </form>
                            </section>
                            <section class="settings" style="display: none;">
                              <a class="hide-form a-hide-form">Cancel</a>
                              <label class="select-all-label">
                                <span class="check-item">
                                  <input type="checkbox" data-custom="true" id="select-all" class="form-control" value="">
                                  <span class="check-icon"></span>
                                </span> &nbsp;Select All&nbsp;
                                
                              </label>
                            </section>
                          </div>
                          <div class="chat-subline">
                            <div class="new-chat-search" style="display: none;">
                              <div>
                                <div class="to-label">To:</div>
                                <div class="wrapper-contact-search">
                                  <input autofocus="autofocus" id="input-chat-new-contact-serach" type="text" placeholder="Type number or name" autocomplete="off" class="input-contact-search">
                                </div>
                                <button id="start-chat-button" disabled="disabled" class="btn btn-success btn-sm btn-start-chat">Start</button>
                                
                              </div>
                            </div>
                            <div class="chat-settings" style="display: none;">
                              <div class="main-actions ">
                                <button disabled="disabled" href="#" class="btn-chat-settings narrow">
                                  <i class="tmi30 tmi30-envelope"></i> Mark as unread </button>
                                <button disabled="disabled" href="#" class="btn-chat-settings narrow">
                                  <i class="tmi30 tmi30-close tmi30-12px"></i> Close </button>
                                <button disabled="disabled" href="#" class="btn-chat-settings narrow">
                                  <i class="ftmi30 tmi30-trash tmi30-12px"></i> Delete </button>
                              </div>
                            </div>
                            <div class="chat-closed-actions" style="display: none;">
                              <div class="main-actions ">
                                <button disabled="disabled" href="#" class="btn-chat-settings narrow">
                                  <i class="ftmi30 tmi30-trash tmi30-12px"></i> Delete </button>
                                <button disabled="disabled" href="#" class="btn-chat-settings narrow">
                                  <i class="tmi30 tmi30-checked "></i> Reopen </button>
                              </div>
                            </div>
                          </div>
                          <div class="chats-thread-content">
                            <div id="chat-contact-list" data-simplebar-direction="vertical" class="chat-contact-list">
                              <div class="simplebar-track horizontal" style="visibility: visible;">
                                <div class="simplebar-scrollbar" style="left: 2px; width: 10px;"></div>
                              </div>
                              <div class="simplebar-track vertical" style="visibility: hidden;">
                                <div class="simplebar-scrollbar"></div>
                              </div>
                              <div id="chat-contact-list-scroll-content" class="simplebar-scroll-content" style="width: auto; height: auto;">
                                <div id="chat-contact-list-content" class="simplebar-content">
                                  
                                  <div class="chat-contact-item clearfix active">
                                    <span class="check-item">
                                      <input type="checkbox" data-custom="true" id="chats_list_checkbox_28263657" class="form-control" value="28263657">
                                      <span class="check-icon"></span>
                                    </span>
                                    <i class="avatar avatar-7 ">MM</i>
                                    <div class="statuses-actions-wrap">
                                      <div class="statuses-actions">
                                        <div class="time">28 Feb <i title="Pinned chat" class="tmi30 tmi30-pin tmi30-12px text-muted" style="display: none;"></i>
                                        </div>
                                      </div>
                                      <div class="name"> Masudul </div>
                                    </div>
                                    <div>
                                      <div class="statuses-actions">
                                        <div id="chatAtionsMenu28263657" class="btn-group chat-actions">
                                          <a type="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" class="dropdown-toggle">
                                            <span class="caret caret-sm"></span>
                                          </a>
                                          <ul class="dropdown-menu tmi30-ul">
                                            
                                            <li>
                                              <a href="#">
                                                <i class="tmi30 tmi30-li tmi30-pin tmi30-12px"></i> Pin </a>
                                            </li>
                                            <li style="display: none;">
                                              <a href="#">
                                                <i class="tmi30 tmi30-li tmi30-pin-off tmi30-12px"></i> Unpin </a>
                                            </li>
                                            <li>
                                              <a href="#">
                                                <i class="tmi30 tmi30-li tmi30-volume-crossed tmi30-12px"></i> Mute </a>
                                            </li>
                                            
                                            <li>
                                              <a href="#">
                                                <i class="tmi30 tmi30-li tmi30-email-mark-as-unread tmi30-12px" style="font-size: 15px; left: 10px; top: 10px;"></i> Mark as unread </a>
                                            </li>
                                            <li>
                                              <a href="#">
                                                <i class="tmi30 tmi30-li tmi30-trash  tmi30-12px"></i> Delete chat </a>
                                            </li>
                                            <li>
                                              <a href="#">
                                                <i class="tmi30 tmi30-li tmi30-close  tmi30-12px"></i> Close chat </a>
                                            </li>
                                          </ul>
                                        </div>
                                        
                                      </div>
                                      <div title="" class="last-message">
                                        <span></span>
                                      </div>
                                    </div>
                                  </div>
                                  <div class="chat-contact-item clearfix">
                                    <span class="check-item">
                                      <input type="checkbox" data-custom="true" id="chats_list_checkbox_28101799" class="form-control" value="28101799">
                                      <span class="check-icon"></span>
                                    </span>
                                    <i class="avatar avatar-5 ">TS</i>
                                    <div class="statuses-actions-wrap">
                                      <div class="statuses-actions">
                                        <div class="time">26 Feb <i title="Pinned chat" class="tmi30 tmi30-pin tmi30-12px text-muted" style="display: none;"></i>
                                        </div>
                                      </div>
                                      <div class="name"> TextMagic Support </div>
                                    </div>
                                    <div>
                                      <div class="statuses-actions">
                                        <div id="chatAtionsMenu28101799" class="btn-group chat-actions">
                                          <a type="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" class="dropdown-toggle">
                                            <span class="caret caret-sm"></span>
                                          </a>
                                          <ul class="dropdown-menu tmi30-ul">
                                            
                                            <li>
                                              <a href="#">
                                                <i class="tmi30 tmi30-li tmi30-pin tmi30-12px"></i> Pin </a>
                                            </li>
                                            <li style="display: none;">
                                              <a href="#">
                                                <i class="tmi30 tmi30-li tmi30-pin-off tmi30-12px"></i> Unpin </a>
                                            </li>
                                            <li>
                                              <a href="#">
                                                <i class="tmi30 tmi30-li tmi30-volume-crossed tmi30-12px"></i> Mute </a>
                                            </li>
                                            
                                            
                                            <li>
                                              <a href="#">
                                                <i class="tmi30 tmi30-li tmi30-email-mark-as-unread tmi30-12px" style="font-size: 15px; left: 10px; top: 10px;"></i> Mark as unread </a>
                                            </li>
                                            <li>
                                              <a href="#">
                                                <i class="tmi30 tmi30-li tmi30-trash  tmi30-12px"></i> Delete chat </a>
                                            </li>
                                            <li>
                                              <a href="#">
                                                <i class="tmi30 tmi30-li tmi30-close  tmi30-12px"></i> Close chat </a>
                                            </li>
                                          </ul>
                                        </div>
                                        
                                        
                                      </div>
                                      <div title="😊" class="last-message">
                                        <span>
                                          <span class="emoji-wrap" contenteditable="false">
                                            <img src="data:image/gif;base64,R0lGODlhAQABAIAAAAAAAP///yH5BAEAAAAALAAAAAABAAEAAAIBRAA7" contenteditable="false" style="display: inline-block; width: 22px; height: 22px; background-image: url(&quot;https://unpkg.com/emoji-datasource-apple@4.0.4/img/apple/sheets-256/64.png&quot;); background-size: 5200%; background-position: 58.8235% 66.6667%;">😊 </span>
                                        </span>
                                      </div>
                                    </div>
                                  </div>
                                  
                                </div>
                              </div>
                            </div>
                            <div id="chat-search-result-contact-list" data-simplebar-direction="vertical" class="chat-contact-list" style="display: none;">
                              <div class="simplebar-track horizontal" style="visibility: hidden;">
                                <div class="simplebar-scrollbar"></div>
                              </div>
                              <div class="simplebar-track vertical" style="visibility: hidden;">
                                <div class="simplebar-scrollbar"></div>
                              </div>
                              <div class="simplebar-scroll-content" style="width: auto; height: auto;">
                                <div id="chat-contact-list-scroll-content" class="simplebar-content"></div>
                              </div>
                            </div>
                            
                            <div class="chat-contact-tabs">
                              <ul class="nav nav-chat-tabs">
                                <li class="active">
                                  <a id="thread-tabs-l1-open" href="#">Open</a>
                                </li>
                                <li class="">
                                  <a id="thread-tabs-l1-close" href="#">Closed</a>
                                </li>
                              </ul>
                            </div>
                          </div>
                        </div>
                        <div class="chat-main">
                          <div role="alert" class="alert alert-form-send alert-warning" style="display: none;">
                            <button type="button" class="close">
                              <i class="tmi30 tmi30-close"></i>
                            </button>
                            <i class="fa  fa-warning"></i>
                            <span></span>
                          </div>
                          <div class="messages-chat-header">
                            <a href="#" class="back-left">
                              <i class="tmi30 tmi30-arrow-left-s tmi30-18px"></i>
                            </a>
                            <video id="localAudio" style="display: none;">
                              <source src="" type="audio/mpeg">
                            </video>
                            <video id="remoteAudio" style="display: none;">
                              <source src="" type="audio/mpeg">
                            </video>
                            <div style="display: none;">
                              <div class="chat-messages-select">
                                <a href="#" class="hide-form a-hide-form">Cancel</a>
                                <label class="select-all-label">
                                  <span class="check-item">
                                    <input type="checkbox" data-custom="true" id="select-all" class="form-control" value="">
                                    <span class="check-icon"></span>
                                  </span> &nbsp;Select All&nbsp;
                                  
                                </label>
                              </div>
                              <div class="chat-messages-settings">
                                <div class="messages-actions">
                                  <div>
                                    <button href="#" disabled="disabled" data-clipboard-target="" id="copyToClipboardAll" title="" type="button" class="btn-chat-settings" data-original-title="Copied!">
                                      <i class="tmi30 tmi30-card-two-o tmi30-14px"></i>
                                      <span>Copy</span>
                                    </button>
                                    <button href="#" disabled="disabled" type="button" class="btn-chat-settings">
                                      <i class="tmi30 tmi30-box-arrow-down tmi30-14px"></i>
                                      <span>Download</span>
                                    </button>
                                    <button href="#" disabled="disabled" type="button" class="btn-chat-settings">
                                      <i class="tmi30 tmi30-trash tmi30-14px"></i>
                                      <span>Delete</span>
                                    </button>
                                  </div>
                                </div>
                              </div>
                            </div>
                            <div class="chat-messages-search" style="display: none;">
                              <a class="hide-form a-hide-form">Cancel</a>
                              <form action="#" class="form-contacts-search">
                                <input type="text" autofocus="autofocus" id="input-messages-search" placeholder="Search messages..." maxlength="80" autocomplete="off" class="form-control-search">
                              </form>
                            </div>
                            <div class="chat-messages-date" style="display: none;">
                              <a class="hide-form a-hide-form">Cancel</a>
                              <form action="#" class="form-inline">
                                <div class="form-group form-group-date">
                                  <label for="messagesStartDate">From:</label>
                                  <div id="messagesStartDate" data-date-end-date="5 Mar 2023" data-date-format="d M yyyy" data-date-autoclose="true" class="input-group date">
                                    <input type="text" readonly="readonly" class="form-control input-sm">
                                    <div class="input-group-addon">
                                      <span class="tmi30 tmi30-schedule tmi30-12px"></span>
                                    </div>
                                  </div>
                                </div>
                                <div class="form-group form-group-date">
                                  <label for="messagesEndDate">To:</label>
                                  <div id="messagesEndDate" data-date-end-date="5 Mar 2023" data-date-format="d M yyyy" data-date-autoclose="true" class="input-group date">
                                    <input type="text" readonly="readonly" class="form-control input-sm">
                                    <div class="input-group-addon">
                                      <span class="tmi30 tmi30-schedule tmi30-12px"></span>
                                    </div>
                                  </div>
                                </div>
                              </form>
                            </div>
                            <div class="chat-messages-header">
                              <div class="chat-messages-contact">
                                <div class="contact-data">
                                  <a target="_blank" href="/online/contacts/234904768" title="Masudul" class="avatar-link">
                                    <i class="avatar avatar-7 ">MM</i>
                                  </a>
                                  <div class="avatar-title">
                                    <div class="contact-name">
                                      <a target="_blank" href="/online/contacts/234904768" title="Masudul"> Masudul </a>
                                      <div class="contact-number">+19727407202</div>
                                    </div>
                                    
                                  </div>
                                </div>
                                
                              </div>
                              <ul class="chat-messages-controls">
                                <li>
                                  <button data-toggle="tooltip" data-placement="top" data-original-title="Call now" title="" class="control a-show-search dropdown-toggle">
                                    <i class="fa fa-phone" style="font-size: 16px; margin-top: 3px;"></i>
                                  </button>
                                </li>
                                <li style="display: none;">
                                  <button data-toggle="tooltip" data-placement="top" data-original-title="End call" title="" class="control a-show-search">
                                    <i class="fa fa-phone fa-14pt" style="transform: rotate(135deg); font-size: 16px; margin-top: 1px;"></i>
                                  </button>
                                </li>
                                <li style="width: 21px; margin-left: 7px;">
                                  <button data-toggle="tooltip" data-placement="top" data-original-title="Mark as unread" title="" class="btn-messages-search control a-show-search">
                                    <i class="tmi30 tmi30-email-mark-as-unread" style="font-size: 17px;"></i>
                                  </button>
                                </li>
                                
                                <li>
                                  <button data-toggle="tooltip" data-placement="top" data-original-title="Search this chat" title="" class="btn-messages-search control a-show-search">
                                    <i class="tmi30 tmi30-loupe tmi30-15px"></i>
                                  </button>
                                </li>
                                <li data-toggle="tooltip" data-placement="top" data-original-title="Chat actions" title="" class="dropdown">
                                  <button title="Messages actions" data-toggle="dropdown" class="control dropdown-toggle">
                                    <i class="tmi30 tmi30-gear tmi30-15px"></i>
                                  </button>
                                  <ul class="dropdown-menu pull-right tmi30-ul">
                                    
                                    <li>
                                      <a href="#">
                                        <i class="tmi30 tmi30-li tmi30-circle-add tmi30-12px"></i> Add note </a>
                                    </li>
                                    
                                    <li>
                                      <a href="#chatSenderSettingsModal" data-toggle="modal">
                                        <i class="tmi30 tmi30-li tmi30-phone-gear tmi30-12px"></i> Sender settings </a>
                                    </li>
                                    <li>
                                      <a target="_blank" href="/online/contacts/234904768">
                                        <i class="tmi30 tmi30-li tmi30-template-person tmi30-12px"></i>View contact </a>
                                    </li>
                                    
                                    <li>
                                      <a href="#">
                                        <i class="tmi30 tmi30-li tmi30-circle-blocked tmi30-12px"></i> Block contact </a>
                                    </li>
                                    
                                    <li>
                                      <a href="#">
                                        <i class="tmi30 tmi30-li tmi30-circle-close tmi30-12px"></i> Unsubscribe contact </a>
                                    </li>
                                    <li>
                                      <a href="#">
                                        <i class="tmi30 tmi30-li tmi30-trash tmi30-12px"></i> Delete chat </a>
                                    </li>
                                    <li>
                                      <a href="#">
                                        <i class="tmi30 tmi30-li tmi30-12px tmi30-close"></i> Close chat </a>
                                    </li>
                                    
                                  </ul>
                                </li>
                                <li data-toggle="tooltip" data-placement="top" data-original-title="Chat notifications" title="" id="button-for-mute-options" class="dropdown">
                                  <button title="Notification settings" data-toggle="dropdown" class="control dropdown-toggle">
                                    <i class="tmi30 tmi30-volume tmi30-15px"></i>
                                  </button>
                                  <ul class="dropdown-menu pull-right tmi30-ul mute-options">
                                    <li class="active">
                                      <a href="#">
                                        <i class="tmi30 tmi30-li tmi30-volume tmi30-12px"></i> Unmuted </a>
                                    </li>
                                    <li class="">
                                      <a href="#">
                                        <i class="tmi30 tmi30-li tmi30-clock tmi30-12px"></i>
                                        <span>Mute for 1h</span>
                                        
                                      </a>
                                    </li>
                                    <li class="">
                                      <a href="#">
                                        <i class="tmi30 tmi30-li tmi30-clock tmi30-12px"></i>Mute for 8h
                                        
                                      </a>
                                    </li>
                                    <li class="">
                                      <a href="#">
                                        <i class="tmi30 tmi30-li tmi30-clock tmi30-12px"></i>Mute for 2 days
                                        
                                      </a>
                                    </li>
                                    <li class="">
                                      <a href="#">
                                        <i class="tmi30 tmi30-li tmi30-volume-crossed tmi30-12px"></i>Mute </a>
                                    </li>
                                  </ul>
                                </li>
                                <li>
                                  <button data-toggle="tooltip" data-placement="top" data-original-title="Mark as closed" title="" class="control">
                                    <i class="tmi30 tmi30-close"></i>
                                  </button>
                                </li>
                                
                              </ul>
                            </div>
                          </div>
                          <div id="chat-messages-container" data-simplebar-direction="vertical" data-changes="1" class="chat-messages-container">
                            <div class="progress-bar-container" style="display: none;">
                              <div class="progress-bar-inner" style="width: 0%;"></div>
                            </div>
                            <div class="dragover-overlay" style="display: none;">
                              <div class="file-area">
                                <div class="text-container">
                                  <i class="tmi tmi30-chain"></i>
                                  <div class="title">Insert download link</div>
                                  <div class="subtitle">A clickable link to the file will be added to your message.</div>
                                </div>
                              </div>
                              <div class="file-area">
                                <div class="text-container">
                                  <i class="tmi tmi30-add-picture"></i>
                                  <div class="title">Send MMS</div>
                                  <div class="subtitle">A multimedia message will be sent to your recipient's phone.</div>
                                </div>
                              </div>
                            </div>
                            <div class="chat-spinner-wrapper" style="display: none;">
                              <div class="chat-spinner">
                                <i class="tmi30 message-status-out wait tmi30-spin"></i> Loading...
                              </div>
                            </div>
                            <div class="chat-spinner lg" style=""> There are no messages in this chat. </div>
                            <div class="simplebar-track horizontal">
                              <div class="simplebar-scrollbar"></div>
                            </div>
                            <div class="simplebar-track vertical">
                              <div class="simplebar-scrollbar"></div>
                            </div>
                            <div data-changes="1" class="chat-messages__wrapper" style="">
                              <div id="simplebar-content-123" class="simplebar-scroll-content" style="overflow: auto;">
                                <div class="simplebar-content">
                                  <div class="messages-group__date" style="display: none;">
                                    <span>
                                      <i class="tmi30 spinner-big tmi30-spin"></i>
                                    </span>
                                  </div>
                                </div>
                              </div>
                            </div>
                          </div>
                          
                          <div id="chat-form-send" class="chat-form-send">
                            <div id="form-control-container" class="form-control-container">
                              <div>
                                <div contenteditable="true" tabindex="29" class="form-control-content text-editor"></div>
                                <span class="placeholder">Type your message</span>
                                <div class="echo-text rawtext">
                                  <pre id="text-editor-copy-element-replacer"></pre>
                                </div>
                              </div>
                            </div>
                            
                            <div class="attach-detail attach-schedule clearfix" style="display: none;">
                              <div class="sumbit-column">
                                <a href="#" tabindex="31" class="hide-form hide-schedule-form">Cancel</a>
                                <br>
                                <button disabled="disabled" type="button" id="btn-schedule" tabindex="40" class="btn btn-warning btn-solid pull-right send-button-action">Schedule</button>
                              </div>
                              <div class="datetime-column">
                                <div class="form-group">
                                  <label class="col-sm-2 control-label">Send date</label>
                                  <div class="col-sm-10 control-column">
                                    <div class="time-column">
                                      <div class="form-control-inline size-3">
                                        <input id="schedule-time-hours" type="text" maxlength="2" tabindex="11" class="form-control input-sm">
                                      </div>
                                      <div class="form-control-inline">:</div>
                                      <div class="form-control-inline size-3">
                                        <input id="schedule-time-minutes" type="text" maxlength="2" tabindex="12" class="form-control input-sm">
                                      </div>
                                      <div class="form-control-inline size-6">
                                        <select id="schedule-ampm" tabindex="12" class="form-control input-sm">
                                          <option value="AM">AM</option>
                                          <option value="PM">PM</option>
                                        </select>
                                      </div>
                                    </div>
                                    <div class="date-column">
                                      <div data-date-start-date="5 Mar 2023" data-date-format="d M yyyy" data-date-autoclose="true" class="input-group date">
                                        <input type="text" id="scheduleStartDate" readonly="readonly" tabindex="10" class="form-control input-sm">
                                        <div class="input-group-addon">
                                          <span class="tmi30 tmi30-schedule tmi30-12px"></span>
                                        </div>
                                      </div>
                                    </div>
                                  </div>
                                </div>
                                <div class="form-group">
                                  <label class="col-sm-2 control-label"> Timezone </label>
                                  <div class="col-sm-10 control-column">

                                  </div>
                                </div>
                              </div>
                            </div>

                          </div>
                        </div>
                        <div>
                          <div id="vueNewAttachment" tabindex="-1" role="dialog" aria-hidden="true" class="modal fade new-attachment-modal">
                            <div class="modal-dialog modal-lg">
                              <div class="modal-content">
                                <div class="modal-header">
                                  <h3 class="modal-title">Attach a file</h3>
                                  <button type="button" class="close">×</button>
                                </div>
                                <div class="modal-body">
                                  <div class="rich-btn-group-select">
                                    <a href="#" class="btn btn-group-default btn-template">
                                      <i class="tmi tmi30-chain"></i>
                                      <div class="title">Insert download link</div>
                                      <div class="subtitle">A clickable link to the file will be added to your message.</div>
                                    </a>
                                    <a href="#" class="btn btn-group-default btn-template">
                                      <div class="badge">NEW</div>
                                      <i class="tmi tmi30-add-picture"></i>
                                      <div class="title">Send MMS</div>
                                      <div class="subtitle">A multimedia message will be sent to your recipient's phone.</div>
                                      <div class="subtitle" style="display: none;">To activate this feature</div>
                                      <div class="text-center" style="display: none;">
                                        <a href="/online/reply-options/buy-number/false/US#tollfree" target="_blank" class="btn btn-success btn-solid ">Buy a toll-free number</a>
                                      </div>
                                    </a>
                                  </div>
                                </div>
                              </div>
                            </div>
                          </div>
                          <div id="vueMmsUploadModal" tabindex="-1" role="dialog" aria-hidden="true" class="modal fade mms-upload-modal">
                            <div class="modal-dialog modal-lg">
                              <div class="modal-content">
                                <div class="modal-header">
                                  <h3 class="modal-title">Attach a file - MMS</h3>
                                  <button type="button" class="close">×</button>
                                </div>
                                <form action="" id="attachMmsFileForm" method="post" enctype="multipart/form-data">
                                  <div class="modal-body form-horizontal">
                                    <div class="alert alert-warning" style="display: none;"></div>
                                    <div id="progressContainer" class="form-group">
                                      <label for="attachMmsFileChoose" class="control-label col-sm-3">Upload a file you want to send via MMS</label>
                                      <div class="col-sm-6">
                                        <input id="attachMmsFileChoose" name="file" type="file" class="form-control">
                                        <span class="help-block">View <a tabindex="0" role="button" data-toggle="popover" data-trigger="hover" data-placement="bottom" title="" href="#" data-content=".json, .ogv, .oga, .ogx, .ogg, .rtf, .zip, .tar, .xml, .gz, .bz2, .gz, .smil, .m4a, .m4p, .m4b, .m4r, .mp1, .mp2, .mp3, .m1a, .m2a, .mpa, .oga, .flac, .webm, .wav, .amr, .3ga, .3gp, .bmp, .dib, .gif, .jpg, .jpeg, .pjpeg, .png, .svg, .tiff, .tif, .webp, .ico, .css, .csv, .html, .cal, .txt, .vcf, .vcard, .wap, .xml, .avi, .mp4, .m4v, .mpg, .mpeg, .m1v, .mpv, .ogv, .ogx, .ogg, .spx, .ogm, .mov, .qt, .webm, .wmv, .flv" data-original-title="Supported file formats">supported formats </a> for sending MMS messages. </span>
                                      </div>
                                    </div>
                                    <hr class="modal-divider">
                                    <ul class="list-disc">
                                      <li>You can send images via MMS that are up to 3.5 MB and other files up to 525 KB in size.</li>
                                      <li>A multimedia message (MMS) will be sent to your recipient's phone including the attached file.</li>
                                      <li>Attachments will be stored on TextMagic's servers.</li>
                                    </ul>
                                  </div>
                                </form>
                                <div class="modal-footer">
                                  <a href="#" class="btn btn-link text-muted pull-left">Cancel</a>
                                  <button id="progressButton" type="submit" class="btn btn-lg btn-success btn-solid">
                                    <span class="btn-spinner" style="display: none;">
                                      <svg xmlns:xlink="http://www.w3.org/1999/xlink" xmlns="http://www.w3.org/2000/svg" height="16" width="16" viewBox="0 0 13 13" style="animation: 3s linear 0s infinite normal none running spin; transform: translate(0px, -50%);">
                                        <path stroke-linejoin="miter" stroke-linecap="round" stroke-width="0.7" stroke="white" fill="none" fill-rule="evenodd" d="M 6.28 0.17 L 6.28 2.97 M 10.21 1.6 L 8.41 3.74 M 12.29 5.22 L 9.54 5.71 M 11.57 9.34 L 9.15 7.94 M 8.37 12.02 L 7.41 9.4 M 4.19 12.02 L 5.14 9.4 M 0.99 9.34 L 3.41 7.94 M 0.26 5.22 L 3.01 5.71 M 2.35 1.6 L 4.15 3.74"></path>
                                      </svg>
                                    </span> Upload file </button>
                                </div>
                              </div>
                            </div>
                          </div>
                          <div id="vueAttachUploadModal" tabindex="-1" role="dialog" aria-hidden="true" class="modal fade attach-upload-modal">
                            <div class="modal-dialog modal-lg">
                              <div class="modal-content">
                                <div class="modal-header">
                                  <h3 class="modal-title">Attach a file - Insert download link</h3>
                                  <button type="button" class="close">×</button>
                                </div>
                                <form action="" id="attachLinkFileForm" method="post" enctype="multipart/form-data">
                                  <div class="modal-body form-horizontal">
                                    <div class="alert alert-warning" style="display: none;"></div>
                                    <div id="progressContainer" class="form-group">
                                      <label for="attachLinkFileChoose" class="control-label col-sm-3">Attach a file you want to send via SMS</label>
                                      <div class="col-sm-6">
                                        <input id="attachLinkFileChoose" name="file" type="file" class="form-control">
                                        <span class="help-block">Supports .jpg, .gif, .png, .pdf, .txt, .csv, .doc, .docx, .xls, .xlsx, .ppt, .pptx &amp; .vcf file formats</span>
                                      </div>
                                    </div>
                                    <hr class="modal-divider">
                                    <ul class="list-disc">
                                      <li>You can upload files that are up to 10 MB in size.</li>
                                      <li>A clickable hyperlink will be included in your SMS where recipients can view / download your file.</li>
                                      <li>Attachments will be stored on TextMagic's servers.</li>
                                    </ul>
                                  </div>
                                </form>
                                <div class="modal-footer">
                                  <a href="#" class="btn btn-link text-muted pull-left">Cancel</a>
                                  <button id="progressButton" type="submit" class="btn btn-lg btn-success btn-solid">
                                    <span class="btn-spinner" style="display: none;">
                                      <svg xmlns:xlink="http://www.w3.org/1999/xlink" xmlns="http://www.w3.org/2000/svg" height="16" width="16" viewBox="0 0 13 13" style="animation: 3s linear 0s infinite normal none running spin; transform: translate(0px, -50%);">
                                        <path stroke-linejoin="miter" stroke-linecap="round" stroke-width="0.7" stroke="white" fill="none" fill-rule="evenodd" d="M 6.28 0.17 L 6.28 2.97 M 10.21 1.6 L 8.41 3.74 M 12.29 5.22 L 9.54 5.71 M 11.57 9.34 L 9.15 7.94 M 8.37 12.02 L 7.41 9.4 M 4.19 12.02 L 5.14 9.4 M 0.99 9.34 L 3.41 7.94 M 0.26 5.22 L 3.01 5.71 M 2.35 1.6 L 4.15 3.74"></path>
                                      </svg>
                                    </span> Attach file </button>
                                </div>
                              </div>
                            </div>
                          </div>
                          <div id="vueFilePreviewUploadModal" tabindex="-1" role="dialog" aria-hidden="true" class="modal fade file-upload-prview-modal">
                            <div class="modal-dialog modal-lg">
                              <div class="modal-content">
                                <div class="modal-header">
                                  <h3 class="modal-title">File uploaded</h3>
                                  <button type="button" aria-hidden="true" class="close">×</button>
                                </div>
                                <div class="modal-body">
                                  <div class="row row-condensed">
                                    <figure data-file="preview" class="col-md-6 text-center">
                                      
                                      
                                      
                                      
                                      
                                    </figure>
                                    <div class="col-md-6">
                                      <div class="table-responsive panel panel-default">
                                        <table class="table table-info table-bordered">
                                          <tbody>
                                            <tr>
                                              <th class="first-row-td">File name:</th>
                                              <td data-file="name" class="first-row-td"></td>
                                            </tr>
                                            <tr>
                                              <th>File size:</th>
                                              <td data-file="size">NaN</td>
                                            </tr>
                                            <tr style="display: none;">
                                              <th>Direct link:</th>
                                              <td data-file="link">
                                                <a target="_blank" href="https://my.textmagic.com/undefined">https://my.textmagic.com/undefined</a>
                                              </td>
                                            </tr>
                                            <tr>
                                              <th class="last-row-td">Upload status:</th>
                                              <td data-file="status">
                                                <span class="label label-success">SUCCESS</span>
                                              </td>
                                            </tr>
                                          </tbody>
                                        </table>
                                      </div>
                                    </div>
                                  </div>
                                </div>
                                <div class="modal-footer">
                                  <a data-dismiss="modal" class="btn btn-link text-muted pull-left">Cancel</a>
                                  <input type="submit" value="Insert download link" class="btn btn-lg btn-success btn-solid" style="display: none;">
                                  <input type="submit" value="Attach file" class="btn btn-lg btn-success btn-solid">
                                </div>
                              </div>
                            </div>
                          </div>
                          <div id="vueMmsPreviewModal" tabindex="-1" role="dialog" aria-hidden="true" class="modal fade file-upload-prview-modal mms-preview">
                            <div class="modal-dialog modal-lg">
                              <div class="modal-content">
                                <div class="modal-header">
                                  <h3 class="modal-title">Attachment preview</h3>
                                  <button type="button" aria-hidden="true" class="close">×</button>
                                </div>
                                <div class="modal-body">
                                  <div class="row row-condensed">
                                    <figure data-file="preview" dataversion="0" class="col-md-12 text-center">
                                      
                                      <div class="preview-container">
                                        <div class="preview-title">Please download the file to view it</div>
                                        <div class="preview-subtitle">Currently, the preview of the files in <strong></strong> format is not available. Please download the original file to open it. </div>
                                        <div class="file-box">
                                          <div class="file-ext"></div>
                                        </div>
                                        <div class="file-name"></div>
                                      </div>
                                      
                                    </figure>
                                  </div>
                                </div>
                                <div class="modal-footer">
                                  <a data-dismiss="modal" class="btn btn-link text-muted pull-left">Cancel</a>
                                  <a href="" type="submit" class="btn btn-lg btn-success btn-solid">Download</a>
                                </div>
                              </div>
                            </div>
                          </div>
                          <div id="vueNotesModal" tabindex="-1" role="dialog" aria-hidden="true" class="modal fade">
                            <div class="modal-dialog">
                              <div class="modal-content">
                                <div class="modal-header">
                                  <h3 class="modal-title">Notes for </h3>
                                  <button type="button" aria-hidden="true" class="close"> × </button>
                                </div>
                                <div class="modal-body modal-notes form-horizontal">
                                  <div class="row">
                                    <div class="col-md-12">
                                      <div class="btn-group">
                                        <a class="btn btn-group-success btn-add-note">
                                          <i class="fa tmi30-circle-add tmi30-12px"></i> Add a new note </a>
                                      </div>
                                    </div>
                                    <div class="col-md-12">
                                      
                                      <div class="panel panel-default panel-contact-note-empty text-center text-muted">
                                        <i>This contact does not have any notes. Please add a new note using the button above.</i>
                                      </div>
                                    </div>
                                  </div>
                                </div>
                              </div>
                            </div>
                          </div>
                          <div id="vueMessagePreviewModal" tabindex="-1" role="dialog" aria-hidden="true" class="modal fade">
                            <div class="modal-dialog">
                              <div class="modal-content">
                                <div class="modal-header">
                                  <h3 class="modal-title">Message preview</h3>
                                  <button type="button" aria-hidden="true" class="close">×</button>
                                </div>
                                <div class="modal-body">
                                  <div role="alert" data-widget="forced-alert" class="panel help-block panel-info light-alert internal-warning">
                                  You are about to send a bulk session; please review your message carefully and confirm.
                                </div>
                                  <div id="message-preview-table-content" class="table-responsive panel panel-default" style="min-height: 300px;">
                                    <table class="table table-info table-bordered">
                                      <tbody>
                                        <tr>
                                          <th>From:</th>
                                          <td data-widget="sender-id">EeeDelivere</td>
                                        </tr>
                                        <tr>
                                          <th>To:</th>
                                          <td data-widget="contact-data">
                                            <span data-widget="recipient" class="badge badge-info">Charles Conway (+9991234567)</span>
                                            <br>
                                          </td>
                                        </tr>
                                        <tr>
                                          <th>Message content:</th>
                                          <td data-widget="message-text">
                                            <span>
                                              <span data-v-7f853594="" class="emoji-mart-emoji" style="display: none;">
                                                <span data-v-7f853594="" style="display: inline-block; width: 16px; height: 16px; background-image: url(&quot;https://unpkg.com/emoji-datasource-apple@4.0.4/img/apple/sheets-256/64.png&quot;); background-size: 5200%; background-position: 15.6863% 37.2549%;"></span>
                                              </span>
                                            </span> !!!!
                                          </td>
                                        </tr>
                                        <tr>
                                          <th>Total characters:</th>
                                          <td data-widget="total-chars">193 characters </td>
                                        </tr>
                                        <tr>
                                          <th>Message parts:</th>
                                          <td data-widget="total-parts">2 parts</td>
                                        </tr>
                                        <tr>
                                          <th>Cost of this message:</th>
                                          <td> <span data-widget="single-cost">0.021</span>
                                          </td>
                                        </tr>
                                        <tr data-widget="total-cost-row">
                                          <th>Total session cost:</th>
                                          <td>
                                            <span data-widget="approx-prefix"></span> <span data-widget="total-cost" data-msg-cost="newMsgText">315.50</span>
                                            <br>
                                            <span data-widget="approx-warning" class="help-block" style="margin-bottom: 0px;">Approximate cost is displayed because you have tags in your message.</span>
                                          </td>
                                        </tr>
                                      </tbody>
                                    </table>
                                  </div>
                                </div>
                                <div class="modal-footer">
                                  <a data-dismiss="modal" class="btn btn-link text-muted pull-left">
                                    <i class="fa fa-reply"></i>Back to editing </a>
                                </div>
                              </div>
                            </div>
                          </div>
                        </div>
                      </div>

                      <!-- end here -->

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



<script>
import AppComponent from '../../components/AppComponent'

export default {
  extends: AppComponent,
  data() {
    return {
      data: {},
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
  },
  methods: {
    chatsView() {
      var url = 'api/chats';
      axios.get(url).then((res) => {
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

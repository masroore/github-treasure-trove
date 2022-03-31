<template>
  <div class="py-2">
    <div class="message-container">
      <audio id="outgoingcall" muted>
        <source :src="'incomming.mp3'" type="audio/ogg">
        <source :src="'incomming.mp3'" type="audio/mpeg">
      </audio>
      <audio id="incommingcall" muted>
        <source :src="'outgoing_ringtone.mp3'" type="audio/ogg">
        <source :src="'outgoing_ringtone.mp3'" type="audio/mpeg">
      </audio>
      <audio id="messagetone" muted>
        <source :src="'bell.mp3'" type="audio/ogg">
        <source :src="'bell.mp3'" type="audio/mpeg">
      </audio>
      <div class="container">
        <div class="card" style="height: calc(100vh - 105px);">
          <div class="heading px-3 py-3 border-bottom">
            <h3>Messages</h3>
          </div>
          <div class="outer-content">
            <div class="m-box sidebar scrollable">
              <div class="msg-header sticky">
                <form action="" class="form mb-0">
                  <!-- Searh -->
                  <div class="form-group float-none">
                    <i class="fa fa-search"></i>
                    <input
                      type="text"
                      class="form-control"
                      placeholder="Search"
                      v-model="searchFriend"
                    />
                  </div>
                  <!-- Searh -->
                </form>
              </div>
              <div class="user-lists">
                <!-- show User -->
                <div class="" v-if="showUsers">
                  <div
                    class="
                      user-list-item
                      d-flex
                      align-items-center
                      py-3 px-2
                      border-bottom
                    "
                    :key="friends.conversation_id"
                    :id="friends.conversation_id"
                    v-for="friends in orderedUsers"
                    @click="getSingleChat(friends)"
                  >
                    <div class="box">
                      <template v-if="userdata.id == friends.sender_id">
                        <template v-if="friends.receiver_info.profile_image != null">
                          <img
                            :src="
                              'assets/images/user/profile/' +
                              friends.receiver_info.profile_image
                            "
                            alt=""
                          />
                        </template>
                        <template v-else>
                          <img src="assets/images/user-login.png" alt="" />
                        </template>
                      </template>
                      <template v-else>
                        <template v-if="friends.sender_info.profile_image != null">
                          <img
                            :src="
                              'assets/images/user/profile/' +
                              friends.sender_info.profile_image
                            "
                            alt=""
                          />
                        </template>
                        <template v-else>
                          <img src="assets/images/user-login.png" alt="" />
                        </template>
                      </template>
                    </div>
                    <div class="box w-100 pl-2">
                      <div
                        class="inner-box d-flex justify-content-between mb-1"
                      >
                        <template v-if="userdata.id == friends.sender_id">
                          <h6 class="">
                            {{ friends.receiver_info.first_name }} 
                            {{ friends.receiver_info.last_name }}
                          </h6>
                        </template>
                        <template v-else>
                          <h6 class="">
                            {{ friends.sender_info.first_name }} 
                            {{ friends.sender_info.last_name }}
                          </h6>
                        </template>
                        <div
                          :class="'lastMessageDate-' + friends.conversation_id"
                        >
                          <small
                            class="text-muted"
                            v-if="friends.message_id != 0"
                            >{{
                              istoday(friends.last_message.message_date)
                            }}</small
                          >
                        </div>
                      </div>
                      <div :class="'lastMessage-' + friends.conversation_id">
                        <span>{{ friends.project_info.job_title }}</span>
                        <!-- <template v-if="userdata.id == friends.sender_id">
                          <p
                            :id="'f_typing' + friends.receiver_id"
                            v-if="friends.message_id != 0"
                          >
                            {{ friends.last_message.message_desc }}
                          </p>
                        </template>
                        <template v-else>
                          <p
                            :id="'f_typing' + friends.sender_id"
                            v-if="friends.message_id != 0"
                          >
                            {{ friends.last_message.message_desc }}
                          </p>
                        </template> -->
                      </div>
                      <p class="mb-0 text-right newMsg" :id="'newMsg'+friends.conversation_id" style="color: red; display: none; font-size: 14px;"><span>0</span></p>
                    </div>
                  </div>
                </div>
                <!-- /Show User -->
                <!-- Search User -->
                <div class="" v-if="searchUser">
                  <div
                    class="
                      user-list-item
                      d-flex
                      align-items-center
                      py-3 px-2
                      border-bottom
                    "
                    :key="friends.conversation_id"
                    :id="friends.conversation_id"
                    v-for="friends in filteredUserlist"
                    @click="getSingleChat(friends)"
                  >
                    <div class="box">
                      <template v-if="userdata.id == friends.sender_id">
                        <template v-if="friends.receiver_info.profile_image != null">
                          <img
                            :src="
                              'assets/images/user/profile/' +
                              friends.receiver_info.profile_image
                            "
                            alt=""
                          />
                        </template>
                        <template v-else>
                          <img src="assets/images/user-login.png" alt="" />
                        </template>
                      </template>
                      <template v-else>
                        <template v-if="friends.sender_info.profile_image != null">
                          <img
                            :src="
                              'assets/images/user/profile/' +
                              friends.sender_info.profile_image
                            "
                            alt=""
                          />
                        </template>
                        <template v-else>
                          <img src="assets/images/user-login.png" alt="" />
                        </template>
                      </template>
                    </div>
                    <div class="box w-100 pl-2">
                      <div
                        class="inner-box d-flex justify-content-between mb-1"
                      >
                        <template v-if="userdata.id == friends.sender_id">
                          <h6 class="">
                            {{ friends.receiver_info.first_name }}
                          </h6>
                        </template>
                        <template v-else>
                          <h6 class="">
                            {{ friends.sender_info.first_name }}
                            
                          </h6>
                        </template>
                        <div
                          :class="'lastMessageDate-' + friends.conversation_id"
                        >
                          <small
                            class="text-muted"
                            v-if="friends.message_id != 0"
                            >{{
                              istoday(friends.last_message.message_date)
                            }}</small
                          >
                        </div>
                      </div>
                      <div :class="'lastMessage-' + friends.conversation_id">
                        <span>{{ friends.project_info.job_title }}</span>
                        <!-- <template v-if="userdata.id == friends.sender_id">
                          <p
                            :id="'f_typing' + friends.receiver_id"
                            v-if="friends.message_id != 0"
                          >
                            {{ friends.last_message.message_desc }}
                          </p>
                        </template>
                        <template v-else>
                          <p
                            :id="'f_typing' + friends.sender_id"
                            v-if="friends.message_id != 0"
                          >
                            {{ friends.last_message.message_desc }}
                          </p>
                        </template> -->
                      </div>
                    </div>
                  </div>
                </div>
                <!-- /Search User -->
              </div>
            </div>
            <div class="m-box main-area" id="single_chat">
              <center id="selectConversation" class="mt-5 pt-5 mt-sm-5 pt-sm-5">
                <img
                  :src="'images/chat.png'"
                  width="180"
                  alt=""
                />
                <h3 class="mt-3 empty-heading" style="font-weight: 410">
                  Select a Conversation
                </h3>
                <p class="lead">
                  Try selecting a conversation or searching for someone
                  specific.
                </p>
              </center>
              <div id="startchat" class="m-box" style="display: none">
                <p class="closeMsg d-lg-none d-md-none"><i class="fa fa-chevron-left"></i></p>
                <div class="msg-header sticky">
                  <div class="user-info" id="user_info">
                    <h6><strong class="text-reset">{{ friendName }}</strong>   <a :href="'job-detail/'+projectId">(<span>{{ projectName }}</span>)</a></h6>
                    <p>{{ friendStatus }}</p>
                  </div>
                  <div class="other d-flex align-items-center">
                  <button class="btn"  @click="videostartCall(singleChatUser,'audio')"><i class="fas fa-phone"></i></button>
                  <button class="btn"  @click="videostartCall(singleChatUser,'video')">
                    <i class="fas fa-video" aria-hidden="true"></i>
                  </button>
               <!--    <div class="dropdown">
                    <button
                      class="btn"
                      type="button"
                      id="dropdownMenuButton"
                      data-toggle="dropdown"
                      aria-haspopup="true"
                      aria-expanded="false"
                    >
                      <i class="fa fa-ellipsis-h"></i>
                    </button>
                    <div
                      class="dropdown-menu"
                      aria-labelledby="dropdownMenuButton"
                    >
                      <a class="dropdown-item" href="#">Action</a>
                      <a class="dropdown-item" href="#">Another action</a>
                      <a class="dropdown-item" href="#">Something else here</a>
                    </div>
                  </div> -->
                </div>
                </div>

                <div class="msg-body chat-widget-conversation">
                  <div class="msg-text-box right" v-for="chat in singleChate" v-if="chat.message_sender == userdata.id">
                    <div class="panel d-flex align-items-start">
                      
                      <div class="box rounded w-100 bg-light p-1 px-2">
                        <div class="d-flex justify-content-between">
                          <small class="text-uppercase">{{
                            istoday(chat.message_date)
                          }}</small>
                          <h6>
                            {{ chat.sender_info.first_name }}
                            {{ chat.sender_info.last_name }}
                          </h6>
                          
                        </div>
                        <template v-if="chat.message_file">
                          <div class="text-end">
                            <a :href="'images/chat_images/'+chat.message_file" target="_blank" v-if="chat.message_type == 1">
                              <img
                                :src="'images/chat_images/' + chat.message_file"
                                alt="..."
                                class="img-thumbnail"
                                width="100"
                              />
                            </a>
                            <video width="320" height="240" controls v-if="chat.message_type == 3">
                              <source :src="'images/chat_images/'+chat.message_file" type="video/mp4">
                              <source :src="'images/chat_images/'+chat.message_file" type="video/ogg">
                            </video>
                            <p v-if="chat.message_type == 2" class="mw-100 fw-bold">{{chat.message_file}}</p>
                          </div>
                          <a
                            :href="'images/chat_images/' + chat.message_file"
                            download
                            class="d-block mt-2 ml-1 text-end"
                            style="color: rgb(0 153 255)"
                          >
                            <i class="fa fa-download"></i> message-{{
                              chat.message_file
                            }}
                          </a>
                        </template>
                        <p class="text-end w-100 mw-100">{{ chat.message_desc }}</p>
                        <!-- <p>
                        Lorem ipsum, dolor sit amet consectetur adipisicing
                        elit. Aperiam, mollitia!
                      </p> -->
                      </div>
                      <div class="box">
                        <template v-if="chat.sender_info.profile_image">
                          <img
                            :src="
                              'assets/images/user/profile/' +
                              chat.sender_info.profile_image
                            "
                            alt=""
                          />
                        </template>
                        <template v-else>
                          <img src="assets/images/user-login.png" alt="" />
                        </template>
                      </div>
                    </div>
                  </div>
                  <div class="msg-text-box left" v-else>
                    <div class="panel d-flex align-items-start">
                      <div class="box">
                        <template v-if="chat.sender_info.profile_image">
                          <img
                            :src="
                              'assets/images/user/profile/' +
                              chat.sender_info.profile_image
                            "
                            alt=""
                          />
                        </template>
                        <template v-else>
                          <img src="assets/images/user-login.png" alt="" />
                        </template>
                      </div>
                      <div class="box rounded w-100">
                        <div class="d-flex justify-content-between">
                          <h6>
                            {{ chat.sender_info.first_name }}
                            {{ chat.sender_info.last_name }}
                          </h6>
                          <small class="text-uppercase">{{
                            istoday(chat.message_date)
                          }}</small>
                        </div>
                        <template v-if="chat.message_file">
                          <div>
                            <a :href="'images/chat_images/'+chat.message_file" target="_blank" v-if="chat.message_type == 1">
                              <img
                                :src="'images/chat_images/' + chat.message_file"
                                alt="..."
                                class="img-thumbnail"
                                width="100"
                              />
                            </a>
                            <video width="320" height="240" controls v-if="chat.message_type == 3">
                              <source :src="'images/chat_images/'+chat.message_file" type="video/mp4">
                              <source :src="'images/chat_images/'+chat.message_file" type="video/ogg">
                            </video>
                            <p v-if="chat.message_type == 2">{{chat.message_file}}</p>
                          </div>
                          <a
                            :href="'images/chat_images/' + chat.message_file"
                            download
                            class="d-block mt-2 ml-1"
                            style="color: rgb(0 153 255)"
                          >
                            <i class="fa fa-download"></i> message-{{
                              chat.message_file
                            }}
                          </a>
                        </template>
                        <p>{{ chat.message_desc }}</p>
                        <!-- <p>
                        Lorem ipsum, dolor sit amet consectetur adipisicing
                        elit. Aperiam, mollitia!
                      </p> -->
                      </div>
                    </div>
                  </div>
                  <!-- <div class="past-date">
                  <div class="dropdown-divider"></div>
                  <h6 class="text-uppercase">
                    <small class="bg-white shadow-sm rounded p-2 px-3"
                      >DEC 22, 2020</small>
                  </h6>
                </div> -->
                </div>

                <div class="msg-footer align-items-center py-4 px-3">
                  <span v-show="typing" class="typing"
                    >{{ friendName }} is typing ...</span
                  >
                  <div id="myProgress" class="myProgress" style="display: none">
                    <div id="myBar" class="myBar"></div>
                  </div>
                  <div id="image"></div>
                  <div class="d-flex w-100 border rounded align-items-center rounded-pill">
                    <div class="footer-box">
                      <span class="form-field-file">
                        <label
                          for="cv-arquivo"
                          aria-label="Attach file"
                          class="btn1 mt-2 ml-2"
                        >
                          <i class="fa fa-paperclip" aria-hidden="true"></i>
                        </label>

                        <input
                          type="file"
                          @change="move()"
                          name="cv-arquivo"
                          ref="msg_file"
                          id="cv-arquivo"
                          class="field-file"
                        />
                      </span>
                    </div>
                    <div class="footer-box">
                      <input
                        type="text"
                        v-model="message"
                        v-on:keyup="removecross()"
                        class="form-control border-0"
                        @keyup.enter="sendMessage()"
                      />
                      <emoji-picker @emoji="append" :search="search">
                        <div
                          class="emoji-invoker"
                          slot="emoji-invoker"
                          slot-scope="{ events: { click: clickEvent } }"
                          @click.stop="clickEvent"
                        >
                          <svg height="24" viewBox="0 0 24 24" width="24" xmlns="http://www.w3.org/2000/svg">
                            <path d="M0 0h24v24H0z" fill="none"/>
                            <path d="M11.99 2C6.47 2 2 6.48 2 12s4.47 10 9.99 10C17.52 22 22 17.52 22 12S17.52 2 11.99 2zM12 20c-4.42 0-8-3.58-8-8s3.58-8 8-8 8 3.58 8 8-3.58 8-8 8zm3.5-9c.83 0 1.5-.67 1.5-1.5S16.33 8 15.5 8 14 8.67 14 9.5s.67 1.5 1.5 1.5zm-7 0c.83 0 1.5-.67 1.5-1.5S9.33 8 8.5 8 7 8.67 7 9.5 7.67 11 8.5 11zm3.5 6.5c2.33 0 4.31-1.46 5.11-3.5H6.89c.8 2.04 2.78 3.5 5.11 3.5z"/>
                          </svg>
                        </div>
                        <div slot="emoji-picker" slot-scope="{ emojis, insert, display }">
                          <div class="emoji-picker" :style="{ top: display.y + 'px', left: display.x + 'px' }">
                            <div class="emoji-picker__search">
                              <input type="text" v-model="search" v-focus>
                            </div>
                            <div>
                              <div v-for="(emojiGroup, category) in emojis" :key="category">
                                <h5>{{ category }}</h5>
                                <div class="emojis">
                                  <span
                                    v-for="(emoji, emojiName) in emojiGroup"
                                    :key="emojiName"
                                    @click="insert(emoji)"
                                    :title="emojiName"
                                  >{{ emoji }}</span>
                                </div>
                              </div>
                            </div>
                          </div>
                        </div>
                      </emoji-picker>
                    </div>
                    <div class="footer-box">
                      <button class="btn custom-btn rounded-pill me-1 px-4" @click="sendMessage()">
                        Send
                      </button>
                    </div>
                  </div>
                </div>
              </div>
            </div>
            <div class="m-box inner-content details-pane d-none d-sm-block">
              <!-- <div class="inner-header">
                <h4>about</h4>
              </div> -->
              <div class="details-pane-body text-center mx-auto" v-if="showDetails">
                <div class="avatar " >
                  <template v-if="friendImage">
                    <img
                      :src="
                        'assets/images/user/profile/' + friendImage
                      " 
                      alt=""
                    />
                  </template>
                  <template v-else>
                    <img src="assets/images/user-login.png" alt="" />
                  </template>
                </div>

                <div class="name-and-text">
                  <h5>{{ friendName }}</h5>
                  <h6><strong>@{{ userName }}</strong></h6>
                  <!-- <p>top buyer | top rated seller</p> -->
                </div>
                <div class="all-doc-lists" v-if="check_image == 1">
                  <h5>All documents</h5>
                  <div class="doc-list-item">
                    <template v-for="chat in singleChate">
                      <template v-if="chat.message_type == '1'">
                        <a target="_blank" :href="'images/chat_images/'+chat.message_file" class="doc-item">
                          <img :src="'images/chat_images/'+chat.message_file" alt="" />
                        </a>
                      </template>
                    </template>
                  </div>
                </div>
              </div>
            </div>
                          <!-- O2O VIDEO CALL RECEIVER -->

            
          </div>
        </div>
      </div>
    </div>
    <div class="modal fade" id="videocallReceiver" aria-hidden="true" aria-labelledby="exampleModalToggleLabel" tabindex="-1">
      <div class="modal-dialog modal-dialog-centered">
        <div class="modal-body bg-secondary border-secondary rounded p-3">
          <div class="audiocall1 call-modal">
            <div class="center-con text-center" style="margin-bottom:120px">
              <div class="profile incomingName align-self-center" id="userImagename">
                
              </div>
              <div class="mt-4" style="margin-bottom: 100px;">
                <span class="title2" id="incomingName"></span><br>
                <h6>Incoming...</h6>
              </div>

              <ul class="list-inline d-flex justify-content-center">
                <li class="mr-2">
                  <button class="icon-btn btn-success button-effect btn-lg is-animating" @click="o2oreceiveCall()" data-bs-dismiss="modal">
                    <i class="fa fa-phone"></i>
                  </button>
                </li>
                <li>
                  <button class="icon-btn btn-danger button-effect btn-lg is-animating cancelcall" @click="o2ostopKCall(3)">
                    <i class="fa fa-phone-slash"></i>
                  </button>
                </li>
              </ul>
            </div>

          </div>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
import VueSocketio from "vue-socket.io";
import socketio from "socket.io-client";
import EmojiPicker from 'vue-emoji-picker';
import moment from "moment";
Vue.use(EmojiPicker);
var socket = socketio.connect('https://961freelancer.com');
export default {
  props: ["userdata"],
  name: "App",
  components: { EmojiPicker },
  data: function () {
    return {
      friendList: [],
      singleChate: {},
      friendId: "",
      friendName: "",
      friendImage: "",
      friendCountry: "",
      friendLanguage: "",
      friendStatus: "",
      projectName: "",
      projectId: "",
      userName: "",
      searchFriend: "",
      post: "",
      message: "",
      check_image: "",
      conversation_id: "",
      showUsers: true,
      searchUser: false,
      typing: false,
      showDetails: false,
      search: '',
      singleChatUser: '',
      callType:'',
      timer: undefined,
      elapsedcallTime: 0,
      calltimer: undefined,
      singlefriend: '',
      callData: '',
      callDisable:false,
      oncallFriend: {},
      callstatus: 0,
      msgCount: 0
    };
  },
  sockets: {
    connect: function () {
      console.log("socket connected successfully");
    },

    disconnect() {
      console.log("socket disconnected");
    },

    alphastarttyping(data) {
      // this.typing = true;
      console.log('Start Typing', data);
      if (data.selectFrienddata == this.userdata.id) {
        const post2 = this.friendList
          .filter((obj) => {
            // if (data.selectFrienddata === obj.sender_id) {
              return data.selectFrienddata === obj.sender_id;
            // } else {
              // return data.selectFrienddata === obj.receiver_id;
            // }
          })
          .pop();
        console.log("post2",post2);
        if (post2) {
          if (this.friendId == data.UserId && post2.sender_id == data.UserId) {
            this.typing = true;
            console.log('insiode if');
          } else if (
            this.friendId == data.UserId &&
            post2.receiver_id == data.UserId
          ) {
            this.typing = true;
          }
          $("#f_typing" + data.UserId).html(
            '<span style="color: green;"> is typing ...</span>'
          );
          this.typing = false;
        }
      }
    },

    alphastoptyping(data) {
      this.typing = false;
      if (data.friendId == this.user_id) {
        console.log("stop typing friend", data.friendId);
        console.log("stop typing user", data.UserId);
        // alert("chenck");
        console.log("stop typing", data);

        if (data.selectFrienddata.last_message) {
          // setTimeout(() => $('#f_typing'+data.UserId).html('demo'+data.selectFrienddata.last_message.message_desc), 3000);
          $("#f_typing" + data.UserId).html(
            data.selectFrienddata.last_message.message_desc
          );
        } else {
          $("#f_typing" + data.UserId).html("type");
        }
      }
    },
    peekReceiverUserStatus(data) {
      console.log(data);
        axios.get("messsageCount/" + this.user_id).then(function(res) {
              $('.messageCount').html(res.data);
        })

    },
    peekReceiveupdateCallStatus(data) {
      console.log(data);
      if(data.friendId == this.userdata.id && data.call == 'call'){
          this.callData=data; 
          var x = document.getElementById("outgoingcall");
          
          x.play();
          x.muted = false;
          x.loop = true;
          this.checkcallstart();
       
          $('#videocallReceiver').modal();
          $('#videocallReceiver').show(); // show incomingCall Modal here
          $('#videocallReceiver').addClass('show'); // show incomingCall Modal here
          $('#incomingName').html(data.userName);
         var hostname=this.hostname;
          if(data.userImage){
            
             $('#userImagename').html('<img class="bg-img" src="assets/images/user/profile/'+data.userImage+'" alt="Avatar" />');
          }else{
            if(data.userName){
              var matchess = data.userName.match(/\b(\w)/g); // ['J','S','O','N']
              var matches = matchess.slice(0, 2);
              var acronym = matches.join(''); // JSON
              $('#userImagename').html('<span>'+acronym+'</span>');
            }
            
          }


      }else if(data.friendId == this.userdata.id && data.call == 'close'){
           $('#o2ovideocall').modal('hide');
              $('#videocallReceiver').modal('hide');
              $('#videocallReceiver').removeClass('show');
              $('#videocallReceiver').css('display','none');
              this.isO2Ocall=false;
              var x = document.getElementById("outgoingcall"); console.log(x);
              x.pause();
              x.muted = true;
              var incoming = document.getElementById("incommingcall");
              incoming.pause();
              incoming.muted = true;

              this.checkreset();
              this.checkcallstop();
                    //this.singlefriend= this.oncallFriend;
              this.o2ostatus = false;
              this.callDisable=false;

      }else if(data.friendId == this.userdata.id || data.userId == this.userdata.id && data.call == 'close'){
          this.callDisable=false;
      }
      const myData = this.friendList.filter((obj) => {
        return data.userId === obj._id;
      }).pop();
      if (myData) {
        myData.callStatus = data.status;
      }
      const friendData = this.friendList.filter((obj) => {
        return data.friendId === obj._id;
      }).pop();
      if (friendData) {
        friendData.callStatus = data.status;
      }


    },
  },
  mounted() {
    // console.log(this.userdata);
    // this.user_id = '1';
    this.user_id = this.userdata.id;
    this.profile_image = this.userdata.profile_image;
    this.first_name = this.userdata.first_name;
    this.last_name = this.userdata.last_name;
    this.user_names = this.userdata.username;
    this.friendlistss();

    socket.on(
      "birdsreceivemsg",
      function (data) {
        console.log("socket data", data);
        if (data.message_receiver == this.userdata.id) {
          if (this.conversation_id == data.conversation_id) {
            this.singleChate.push(data);
            axios.post('seenMessage',{'sender_id':this.userdata.id,'receiver_id':this.friendId,'conversation_id':this.conversation_id})
             .then(responce => {
              // console.log(responce.data);

             // this.singleChate = responce.data;
            })
          }
          var messagetone = document.getElementById("messagetone");
          messagetone.play();
          messagetone.muted = false;
          axios.get("messsageCount/" + this.user_id).then((responce) => {
            // console.log(responce,'nooooooooootiiiiiiiiiifiiiiiiicaiiin');
            $('.messageCount').html(responce.data);
          });
         
          //   this.userdec = this.friendList.filter((obj_friend) => {
          //     console.log(data.conversation_id,obj_friend.conversation_id);
          //     return data.conversation_id === obj_friend.conversation_id;
          // }).pop();

          this.userdec = this.friendList
            .filter((obj_friend) => {
              return data.conversation_id === obj_friend.conversation_id;
            })
            .pop();
          console.log("filter_user", this.userdec);
          // setTimeout(() => this.userdec.time = new Date().toISOString(), 3000);
          this.userdec.time = new Date().toISOString();
          // $(".user-list-item.active").removeClass("active");
          // $("#" + this.userdec.conversation_id).addClass("active");
            // var msgCount = 0;
          if(this.conversation_id != this.userdec.conversation_id){
            this.msgCount += 1;
              // console.log(responce,'nooooooooootiiiiiiiiiifiiiiiiicaiiin');
            $("#newMsg" + this.userdec.conversation_id).show();
            // $("#newMsg" + this.userdec.conversation_id).html(this.msgCount);
            
            
          }
          // this.userdec.last_message.message_desc = data.message_desc;
          // // var time2 = moment().format('hh:mm A');
          // console.log('.lastMessageDate-'+data.conversation_id);
          // var msg=data.message_desc;
          // var time2 = moment().format('hh:mm A');
          // setTimeout(() => $('.lastMessage-'+this.conversation_id).html('<p>'+msg+'</p>'), 2000);
          // $('.lastMessageDate-'+data.conversation_id).html('<small class="text-muted text-uppercase"> TODAY AT '+time2+'</small>');
          // var time2 = moment().format('hh:mm A');
          //   $('.lastMessageDate-'+data.conversation_id).html('<small class="text-muted text-uppercase"> TODAY AT '+time2+'</small>');
          // $('.lastMessage-'+this.userdec.conversation_id).html('<p>data ape'+data.message_desc+'</p>');

          // console.log("check notfication",$('.notificationMessage-'+data.conversation_id).text());
          var height = 0;
          $(".chat-widget-conversation").each(function (i, value) {
            height += parseInt($(this).height());
          });
          height += 20000;
          $(".chat-widget-conversation").animate({ scrollTop: height });
        }
      }.bind(this)
    );
  },
  watch: {
    searchFriend() {
      if (this.searchFriend.length > 0) {
        this.showUsers = false;
        this.searchUser = true;
      } else {
        this.showUsers = true;
        this.searchUser = false;
      }
    },
    // message: _.debounce(function () {
    //   this.$socket.emit("alphastopTyping", {
    //     selectFrienddata: this.singleChatUser,
    //     friendId: this.friendId,
    //     UserId: this.user_id,
    //   });
    // }, 1500),
    callstatus() {
      if (this.callstatus > 30) {
        this.o2ostopKCall(3);
        // this.stopScreenShare();
       
        // var incoming = document.getElementById("incommingcall");
        //  incoming.pause();
        //  incoming.muted = true;
        $('body').removeClass('modal-open');
        $('.modal-backdrop').remove();
        $('#o2ovideocall').modal('hide');
        $('#o2oaudiocall').modal('hide');


      }
    },
  },
  computed: {
    filteredUserlist() {
      return this.friendList.filter((post) => {
        // console.log(post.sender_info.first_name.toLowerCase().includes(this.searchFriend.toLowerCase()));
        if (post.sender_id == this.user_id) {
          return post.receiver_info.first_name
            .toLowerCase()
            .includes(this.searchFriend.toLowerCase());
        } else {
          return post.sender_info.first_name
            .toLowerCase()
            .includes(this.searchFriend.toLowerCase());
        }
      });
    },
    orderedUsers: function () {
      return _.orderBy(this.friendList, "time", "desc");
    },
    formattedElapsedTime() {
      const date = new Date(null);
      date.setSeconds(this.elapsedTime / 1000);
      const utc = date.toUTCString();
      return utc.substr(utc.indexOf(":") - 2, 8);
    },

    checkcallTime() {
      const date = new Date(null);
      date.setSeconds(this.elapsedcallTime / 1000);
      const utc = date.toUTCString();
      this.callstatus = utc.substr(-6, 3);
      return utc.substr(-6, 3);
    },
  },
  methods: {
    istoday: function (date) {
      return moment(date).calendar();
    },
    removecross() {
      this.$socket.emit("alphamsgtyping", {
        selectFrienddata: this.friendId,
        UserId: this.user_id,
      });
    },
    friendlistss: function () {
      // console.log("asdasd");
      axios.get("friendsList/" + this.user_id).then((responce) => {
        this.friendList = responce.data;
        console.log(this.friendList);
        var url = window.location.href;
        console.log(url);
        var conversations = url.substring(url.lastIndexOf("=") + 1);
        var conversation_id = conversations.split("#/")[0];
        // console.log('conversation_id',conversation_id);
        if (conversation_id) {
          const post = this.friendList
            .filter((obj) => {
              return conversation_id == obj.conversation_id;
            })
            .pop();
          if (post) {
            $('.user-list-item.active').removeClass("active");
            $("#" + post.conversation_id).addClass("active");
            setInterval(function(){ 
              $('.user-list-item').removeClass("active");
              $("#" + post.conversation_id).addClass("active"); 
            }, 2000);
            // $('#1212577981').addClass('active');
            this.getSingleChat(post);
            var height = 0;
            // var container = this.$el.querySelector("#startchat");
            // $("#startchat").animate({ scrollTop: container.scrollHeight + 7020}, "fast");
            // console.log(container);
            $(".chat-widget-conversation").each(function (i, value) {
              height += parseInt($(this).height());
            });
            height += 20000;
            $(".chat-widget-conversation").animate({ scrollTop: height });
          }
        }
      });
    },
    getSingleChat: function (single) {

      this.$socket.emit('peekUpdateUserSelection', {
        selectedUser: '',
        userId: this.user_id
      });

      this.singleChatUser = single;
      this.showDetails = true;
      console.log(this.singleChatUser);
      $(".user-list-item.active").removeClass("active");
      $("#" + this.singleChatUser.conversation_id).addClass("active");
      $("#newMsg" + this.singleChatUser.conversation_id).hide();
      $("#selectConversation").hide();
      $("#startchat").show();
      $("#single_chat").show();
      var height = 0;
      $(".chat-widget-conversation").each(function (i, value) {
        height += parseInt($(this).height());
      });
      height += 20000;
      $(".chat-widget-conversation").animate({ scrollTop: height });

      // console.log(this.singleChatUser);
      if (this.singleChatUser.sender_id == this.user_id) {
        // this.userImage=this.singleChatUser.sender_info.profileimage;
        this.friendName =
          this.singleChatUser.receiver_info.first_name +
          " " + this.singleChatUser.receiver_info.last_name;
        this.conversation_id = this.singleChatUser.conversation_id;
        this.friendId = this.singleChatUser.receiver_id;
        this.friendImage = this.singleChatUser.receiver_info.profile_image;
        this.friendCountry = this.singleChatUser.receiver_info.country;
        this.friendStatus = this.singleChatUser.receiver_info.user_status;
        this.projectName = this.singleChatUser.project_info.job_title;
        this.projectId = this.singleChatUser.project_info.job_id;
        this.userName = this.singleChatUser.receiver_info.username;
        // this.message_status=this.singleChatUser.message_status;
        //console.log(this.friendImage);
      } else {
        this.friendName = this.singleChatUser.sender_info.first_name + " " + this.singleChatUser.sender_info.last_name;
        this.conversation_id = this.singleChatUser.conversation_id;
        this.friendId = this.singleChatUser.sender_id;
        this.friendImage = this.singleChatUser.sender_info.profile_image;
        this.friendCountry = this.singleChatUser.sender_info.country;
        this.friendStatus = this.singleChatUser.sender_info.user_status;
        this.projectName = this.singleChatUser.project_info.job_title;
        this.projectId = this.singleChatUser.project_info.job_id;
        this.userName = this.singleChatUser.sender_info.username;
        // this.userImage=this.singleChatUser.receiver_info.profileimage;
        // this.message_status=this.singleChatUser.message_status;
        //console.log(this.friendImage);
      }
      axios
        .post("singleChat", {
          conversation_id: single.conversation_id
        })
        .then(
          (responce) => {
            console.log(responce.data);
            this.singleChate = responce.data;
            var checkimage = responce.data
              .filter((obj) => {
                return "1" == obj.message_type;
              })
              .pop();
            if (checkimage != undefined) {
              this.check_image = "1";
            } else {
              this.check_image = "0";
            }
            // axios.get("friendData/" + this.friendId).then(
            //   (responce) => {
            //     this.friendLanguage = responce.data.languages;
            //   },
            //   function (err) {
            //     console.log("err", err);
            //     // alert("error");
            //   }
            // );
          },
          function (err) {
            console.log("err", err);
            // alert("error");
          }
        );
       
        axios.post('seenMessage',{'sender_id':this.userdata.id,'receiver_id':this.friendId,'conversation_id':this.conversation_id})
         .then(responce => {
          // console.log(responce.data);

         // this.singleChate = responce.data;
        })
    },
    sendMessage: function () {

      var config = {
        header: {
          "Content-Type": "multipart/form-data",
        },
      };
      var d = new Date($.now());
      var time =
        d.getFullYear() +
        "-" +
        (d.getMonth() + 1) +
        "-" +
        d.getDate() +
        " " +
        d.getHours() +
        ":" +
        d.getMinutes() +
        ":" +
        d.getSeconds();
      // console.log(this.friendId);
      $("#image").text("");
      let meeting_file = this.$refs.msg_file.files;
      var meetingformDatas = new FormData();
      meetingformDatas.append("file", meeting_file[0]);
      meetingformDatas.append("message_sender", this.user_id);
      meetingformDatas.append("message_receiver", this.friendId);
      meetingformDatas.append("message", this.message);
      meetingformDatas.append("conversation_id", this.conversation_id);
      meetingformDatas.append("message_date", time);
      // meetingformDatas.append('message_status',this.message_status);

      
      var message_type = 0;
      var filename = "";
      if (meeting_file.length > 0) {
        var message_type = 1;
        filename = meeting_file[0].name;
        // console.log(meeting_file[0]['type']);
        if (
          meeting_file[0]["type"] === "image/jpeg" ||
          meeting_file[0]["type"] === "image/png" ||
          meeting_file[0]["type"] === "image/jpg" ||
          meeting_file[0]["type"] === "image/gif"
        ) {
          var message_type = "1";
        } 
        else if(meeting_file[0]["type"] === "application/pdf"){
          var message_type = "2";
        }
        else {
          var message_type = "3";
        }
      }
      var profile_image = "";
      if (this.profile_image != null) {
        profile_image = this.profile_image;
      }

      //
      var obj = {
        message_sender: this.user_id,
        message_receiver: this.friendId,
        message_desc: this.message,
        message_file: filename,
        message_type: message_type,
        sender_info: {
          img: profile_image,
          id: this.user_id,
          first_name: this.first_name,
          last_name: this.last_name,
          profile_image: this.profile_image
        },
        // message_type: message_type,
        conversation_id: this.conversation_id,
        // message_status: this.message_status,
        created_at: time,
      };
      //console.log(filename+'hghghgh');
      // meetingformDatas.append('meetingformDatas', obj);
      // console.log(obj);
      // socket.emit('message', obj);

      axios.post("send-message", meetingformDatas, config).then((responce) => {
        this.singleChate.push(obj);
        var height = 0;
        $(".chat-widget-conversation").each(function (i, value) {
          height += parseInt($(this).height());
        });
        height += 20000;
        $(".chat-widget-conversation").animate({ scrollTop: height });
        this.$socket.emit("message", obj);
        this.$socket.emit("alphastopTyping", {
          selectFrienddata: this.friendId,
          UserId: this.user_id,
        });
        // var time = moment().format('hh:mm A');

        this.userdec = this.friendList
          .filter((obj_friend) => {
            return this.conversation_id === obj_friend.conversation_id;
          })
          .pop();
        // console.log("filter_user",this.userdec);
        this.userdec.time = new Date().toISOString();
        this.userdec.last_message.message_desc = this.message;
        var time2 = moment().format("hh:mm A");
        console.log(".lastMessageDate-" + this.conversation_id);
        var msg = this.message;
        // console.log(msg);
        // setTimeout(() => $('.lastMessage-'+this.conversation_id).html('<p>'+msg+'</p>'), 2000);
        $(".lastMessageDate-" + this.conversation_id).html(
          '<small class="text-muted"> TODAY AT ' +
            time2 +
            "</small>"
        );

        // this.userdec = this.friendList.filter((obj_friend) => {
        //   // console.log(obj_friend.sender_id);
        // if (obj_friend.sender_id == this.userdata.id) {
        //   return this.friendId === obj_friend.receiver_id;
        // }else {
        //   return this.friendId === obj_friend.sender_id;
        // }
        // if (obj_friend.receiver_id == this.userdata.id) {
        //   return this.friendId === obj_friend.sender_id;
        // }else {
        //   return this.friendId === obj_friend.receiver_id;
        // }
        // }).pop();
        // // console.log(this.userdec);
        // this.userdec.time = new Date().toISOString();
        // $('.lastMessageDate-'+this.conversation_id).html('<small class="text-muted text-uppercase"> TODAY AT '+time+'</small>');
        // console.log(this.conversation_id);
        // $('.lastMessage-'+this.conversation_id).html('<p>'+this.message+'</p>');

        this.message = "";
        this.$refs.msg_file.value = null;
      });
    },

    move: function () {
      var i = 0;
      $("#image").text("");
      if (i == 0) {
        i = 1;
        $("#myProgress").show();
        var elem = document.getElementById("myBar");
        var input = document.getElementById("cv-arquivo");
        var filename = input.files.item(0).name;
        var output = document.getElementById("image");
        var width = 1;
        var id = setInterval(frame, 1);
        function frame() {
          if (width >= 100) {
            $("#myProgress").hide();
            clearInterval(id);
            i = 0;
            output.innerHTML = filename;
          } else {
            width++;
            elem.style.width = width + "%";
          }
        }
      }
    },
    append(emoji) {
        this.message += emoji
    },
    // One2one Video Call
    videostartCall(friends, statuscall) {
      console.log(friends);
      this.callType = statuscall;
      this.singlefriend = friends;

      this.$socket.emit('peekUpdateCallStatus', {
        userId: this.userdata.id,
        userFirstName: this.userdata.first_name,
        friendId: this.friendId,
        friendName: this.friendName,
        userImage: this.userdata.profile_image,
        status: 1,
        statuscall: statuscall,
        call:'call',
        job_id: this.projectId,
        project_name: this.singlefriend.project_info.job_title 
    
      });
      window.open('/messages#/o2ocall?userName='+this.userdata.username+'&friendName='+this.userName+'&userId='+this.userdata.id+'&friendId='+this.friendId+'&receiveUser=no&callStatus='+statuscall+'&projectId='+this.singlefriend.job_id+'&projectName='+this.singlefriend.project_info.job_title, '_blank');


    }, 
    o2oreceiveCall() {
       this.isO2Ocall=false;

      var x = document.getElementById("outgoingcall");
      x.pause();
      x.muted = true;
      // startCall();
      // this.reset();
      // this.start();
      this.checkreset();
      this.checkcallstop();
      this.reset();
      this.stop();
      var o2oobg = {
        reciverid:this.userdata.id,
        friendId: this.callData.userId,
      }
       var projectIds = this.callData.job_id;
      this.$socket.emit('peekO2OstarTimer', o2oobg);
      $('#videocallReceiver').modal('hide');
      $('#videocallReceiver').removeClass('show');
      //    const post = this.friendList.filter((obj) => {
      //   return this.callData.projectId === obj.project_id;
      // }).pop();
      // this.oncallFriend = post;
       
      this.callDisable=true;
      window.open('/messages#/o2ocall?userName='+this.callData.userFirstName+'&friendName='+this.callData.friendName+'&userId='+this.callData.friendId+'&friendId='+this.callData.userId+'&receiveUser=yes&callId='+this.callData.callId+'&callStatus='+this.callData.statuscall+'&projectId='+projectIds+'&projectName='+this.callData.project_name,'_blank');
       

      // this.$router.push('/o2oCall?userName='+this.callData.userName+'&friendName='+this.callData.friendName+'&userId='+this.callData.friendId+'&friendId='+this.callData.userId+'&receiveUser=yes&callId='+this.callData.callId);
     
    
    
    },

    //o2o-stop
    o2ostopKCall(status) {

      //this.audio.pause();
      $('#o2ovideocall').modal('hide');
      $('#videocallReceiver').modal('hide');
      this.isO2Ocall=false;
      var x = document.getElementById("outgoingcall"); console.log(x);
      x.pause();
      x.muted = true;
      var incoming = document.getElementById("incommingcall");
      incoming.pause();
      incoming.muted = true;

      this.checkreset();
      this.checkcallstop();
            //this.singlefriend= this.oncallFriend;
      this.o2ostatus = false;

      // $('#showcallModel' + this.oncallFriend._id).show();

      var o2oobg = {
        friendId: this.callData.userId,
        // friendId: this.oncallFriend._id,
        stoperId: this.userdata.id
      }
      console.log(o2oobg);
      // alert('ddd');
      this.$socket.emit('peekO2OcloseReceiverPanal', o2oobg);

      this.reset();
      this.stop();
    
      this.oncallFriend = {};
    },
    checkcallstart() {
      this.calltimer = setInterval(() => {
        this.elapsedcallTime += 1000;
      }, 1000);
    },
    checkcallstop() {
      clearInterval(this.calltimer);
    },
    checkreset() {
      this.elapsedcallTime = 0;
    },
    start() {
      this.timer = setInterval(() => {
        this.elapsedTime += 1000;
      }, 1000);
    },
    stop() {
      clearInterval(this.timer);
    },
    reset() {
      this.elapsedTime = 0;
    },
  },
};

jQuery(document).ready(function($){
    var height = 0;
    $(".chat-widget-conversation").each(function(i, value){
      height += parseInt($(this).height());
    });
    height += 20000;
    $(".chat-widget-conversation").animate({scrollTop: height});

    var login_seller_id = "<?= $login_seller_id; ?>";
    var seller_id = "<?= $seller_id; ?>";
    var message_group_id = "<?= $message_group_id ?>";

    $(document).off('submit').on('submit','#insert-message-form', function(event){
      event.preventDefault();
      sendMessage();
      $(this).off('submit'); 
    });

    $(document).on('click', '.closeMsg', function(e){
      event.preventDefault();
      $(".m-box.sidebar").show();
      $(".m-box.main-area").hide();
    });

    $('.closeMsg').on('click', function(){
      $(this).parents('.m-box.main-area').removeClass('position-relative');
      $('.user-list-item').removeClass('active');
    });

    if ( $(window).width() > 767) {
     // Add your javascript for large screens here 
    }else {
      $('.m-box.main-area').hide();
      $('.heading').hide();
      $(document).on('click', '.user-list-item', function(){
        $('.user-list-item').removeClass('active');
        $(this).addClass('active');
        $('.m-box.main-area').addClass('position-relative');
        $('.m-box.sidebar').hide();
        $('.m-box.main-area').show();
        // $('.specfic.col-md-8').attr("class","specfic col-md-12");
        $('.m-box.sidebar').hide();
      });

      $(document).on('click', '#user_info', function(){
        $('.details-pane').toggleClass('d-none');
      });
    }
});
</script>
<style>
.message-container {
  padding: 20px 0;
}

.message-container ::-webkit-scrollbar {
  width: 4px;
}

.message-container ::-webkit-scrollbar-track {
  background: #f5f5f5;
}

.message-container ::-webkit-scrollbar-thumb {
  background: #ed1c24;
}

.message-container ::-webkit-scrollbar-thumb:hover {
  background: #00a651;
}

.message-container .heading h3 {
  font-size: 20px;
}

.message-container .outer-content {
  width: 100%;
  height: 500px;
  background: #ffffff;
  border-radius: 3px;
  display: -ms-grid;
  display: grid;
  -ms-grid-columns: 3fr 6fr 3fr;
  grid-template-columns: 3fr 6fr 3fr;
}

.message-container .outer-content .inner-content {
  width: 100%;
  height: 100%;
}

.message-container .outer-content .inner-content:nth-child(2) {
  border-left: 1px solid rgba(0, 0, 0, 0.1);
  border-right: 1px solid rgba(0, 0, 0, 0.1);
}

.message-container .outer-content .m-box {
  height: 500px;
}

.message-container .outer-content .active {
  border-left: 3px solid #ed1c24;
  background: rgba(0, 0, 0, 0.02);
}

.message-container .outer-content .sidebar {
  border-right: 1px solid rgba(0, 0, 0, 0.1);
}

.message-container .outer-content .sidebar .user-lists {
  /*overflow-y: auto;*/
  /*overflow-x: hidden;*/
  position: relative;
}

.message-container .outer-content .sidebar .user-lists img {
  width: 40px;
  height: 40px;
  border-radius: 50%;
}

.message-container .outer-content .sidebar .user-lists h6 {
  font-size: 13px;
}

.user-list-item .inner-box small.text-muted {
  font-size: 11px;
}

.message-container .outer-content .sidebar .user-lists p {
  font-size: 13px;
}

.message-container .outer-content .sidebar .msg-header {
  padding: 15px 10px;
  background: #ffffff;
  -webkit-box-shadow: 0px 3px 5px rgba(0, 0, 0, 0.05);
  box-shadow: 0px 3px 5px rgba(0, 0, 0, 0.05);
}

.message-container .outer-content .sidebar .msg-header .form-group {
  position: relative;
  margin-bottom: 0 !important;
}

.message-container .outer-content .sidebar .msg-header .form-group i.fa-search {
  position: absolute;
  top: 50%;
  left: 10px;
  -webkit-transform: translateY(-50%);
  transform: translateY(-50%);
  opacity: 0.6;
}

.message-container .outer-content .sidebar .msg-header .form-group input {
  padding-left: 30px;
  min-height: 40px;
}

.message-container .outer-content .main-area {
  position: relative;
  background: #fff;
}

.message-container .outer-content .main-area .msg-header {
  padding: 15px;
  background: #ffffff;
  display: -webkit-box;
  display: -ms-flexbox;
  display: flex;
  -webkit-box-pack: justify;
  -ms-flex-pack: justify;
  justify-content: space-between;
  height: 70px;
  -webkit-box-shadow: 0px 3px 5px rgba(0, 0, 0, 0.05);
  box-shadow: 0px 3px 5px rgba(0, 0, 0, 0.05);
}

.message-container .outer-content .main-area .msg-header .user-info h6 {
  text-transform: capitalize;
  font-size: 16px;
  margin-bottom: 4px;
}

.message-container .outer-content .main-area .msg-header .user-info p {
  font-size: 13px;
  text-transform: capitalize;
}

.message-container .outer-content .main-area .other .btn {
  width: 30px;
  height: 30px;
  border-radius: 3px;
  display: -webkit-box;
  display: -ms-flexbox;
  display: flex;
  -webkit-box-pack: center;
  -ms-flex-pack: center;
  justify-content: center;
  color: #ed1c24;
  margin-left: 6px;
  -webkit-transition: all 0.3s ease-in-out;
  transition: all 0.3s ease-in-out;
  background: rgba(3, 164, 80, 0.1);
}

.message-container .outer-content .main-area .other .btn:hover {
  color: #ffffff;
  background: #00a651;
}

.message-container .outer-content .main-area .other .btn i.fa {
  font-size: 14px;
}

.message-container .outer-content .main-area .msg-body {
  height: calc(100% - 120px);
  padding: 20px;
  overflow-y: auto;
}

.message-container .outer-content .main-area .msg-body .past-date {
  position: relative;
  text-align: center;
  margin: 40px 0;
}

.message-container .outer-content .main-area .msg-body .past-date h6 {
  position: absolute;
  top: 50%;
  left: 50%;
  -webkit-transform: translate(-50%, -50%);
  transform: translate(-50%, -50%);
}

.message-container .outer-content .main-area .msg-body .msg-text-box {
  margin-bottom: 30px;
}

.message-container .outer-content .main-area .msg-body .msg-text-box img {
  width: 45px;
  height: 45px;
  border-radius: 50%;
}

.message-container .outer-content .main-area .msg-body .msg-text-box .box {
  background: transparent;
}

.message-container
  .outer-content
  .main-area
  .msg-body
  .msg-text-box
  .box
  small {
  color: #62646a;
}

.message-container .outer-content .main-area .msg-body .msg-text-box .box h6 {
  font-size: 15px;
  text-transform: capitalize;
}

.message-container .outer-content .main-area .msg-body .msg-text-box .box p {
  max-width: 90%;
  font-size: 13px;
  margin-top: 10px;
  color: #333;
}

.message-container
  .outer-content
  .main-area
  .msg-body
  .msg-text-box
  .box:first-child {
  margin-right: 15px;
}

.message-container .outer-content .main-area .msg-footer {
  position: absolute;
  bottom: 0;
  width: 100%;
  background: #ffffff;
  display: -webkit-box;
  display: -ms-flexbox;
  display: flex;
  -webkit-box-align: center;
  -ms-flex-align: center;
  align-items: center;
  -webkit-box-shadow: 0 -2px 3px rgba(0, 0, 0, 0.05);
  box-shadow: 0 -2px 3px rgba(0, 0, 0, 0.05);
}

.message-container
  .outer-content
  .main-area
  .msg-footer
  .footer-box:nth-child(2) {
  padding: 0 15px 0 20px;
  width: 100%;
}

.message-container
  .outer-content
  .main-area
  .msg-footer
  .footer-box:nth-child(2)
  input {
  min-height: 40px;
  box-shadow: none;
  padding-left: 2rem;
}

.message-container .outer-content .main-area .msg-footer .footer-box .btn {
  color: #ffffff;
  background: #ed1c24;
  height: 40px;
}

.message-container .outer-content .details-pane {
  overflow-y: auto;
  border-left: 1px solid rgba(0, 0, 0, 0.1);
}

.message-container .outer-content .details-pane .details-pane-body {
  padding: 0 25px;
}

.message-container .outer-content .details-pane .details-pane-body .avatar {
  width: 80px;
  height: 80px;
  border-radius: 50%;
  overflow: hidden;
  margin: 20px auto;
}

.message-container .outer-content .details-pane .details-pane-body .avatar img {
  width: 100%;
  height: 100%;
}

.message-container
  .outer-content
  .details-pane
  .details-pane-body
  .name-and-text {
  text-align: center;
}

.message-container
  .outer-content
  .details-pane
  .details-pane-body
  .name-and-text
  h5 {
  font-size: 15px;
  margin-bottom: 10px;
}

.message-container
  .outer-content
  .details-pane
  .details-pane-body
  .name-and-text
  p {
  font-size: 12px;
  text-transform: capitalize;
}

.message-container .outer-content .details-pane .details-pane-body .table {
  margin-top: 15px;
}

.message-container
  .outer-content
  .details-pane
  .details-pane-body
  .table
  tr
  td {
  font-size: 12px;
  padding: 5px 0;
  text-transform: capitalize;
  border: 0;
}

.message-container
  .outer-content
  .details-pane
  .details-pane-body
  .table
  tr
  td:last-child {
  text-align: right;
}

.message-container
  .outer-content
  .details-pane
  .details-pane-body
  .table
  tr:first-child
  td:last-child
  span {
  color: #ffc107;
  font-weight: 500;
}

.message-container
  .outer-content
  .details-pane
  .details-pane-body
  .all-doc-lists {
  margin: 20px 0;
}

.message-container
  .outer-content
  .details-pane
  .details-pane-body
  .all-doc-lists
  h5 {
  font-size: 15px;
  text-transform: capitalize;
}

.message-container
  .outer-content
  .details-pane
  .details-pane-body
  .all-doc-lists
  .doc-list-item {
  display: -ms-grid;
  display: grid;
  -ms-grid-columns: (1fr) [2];
  grid-template-columns: repeat(2, 1fr);
  grid-gap: 10px;
  margin-top: 10px;
}

.message-container
  .outer-content
  .details-pane
  .details-pane-body
  .all-doc-lists
  .doc-list-item
  .doc-item {
  width: 100%;
  height: 70px;
  border-radius: 10px;
  overflow: hidden;
}

.message-container
  .outer-content
  .details-pane
  .details-pane-body
  .all-doc-lists
  .doc-list-item
  .doc-item
  img {
  width: 100%;
  height: 100%;
}

.message-container .dropdown {
  text-align: right;
}

.message-container .dropdown .nav-link {
  padding: 0;
}

.message-container .dropdown .dropdown-menu {
  right: 0 !important;
  left: unset !important;
  -webkit-transform: unset !important;
  transform: unset !important;
  top: 30px !important;
}
.scrollable {
  height: 100%;
  overflow-y: auto;
}

.sticky {
  position: -webkit-sticky;
  position: sticky;
  top: 0;
  z-index: 1;
}
.user-list-item {
  cursor: pointer;
}
.img-thumbnail {
  padding: 0.25rem;
  background-color: #fff;
  border: 1px solid #dee2e6;
  border-radius: 0.25rem !important;
  height: 100px !important;
  width: 100px !important;
}
.typing {
  position: absolute;
  top: -1px;
  left: 50px;
}
.myProgress {
  width: 100%;
  background-color: #ddd;
  position: absolute;
  top: 5px;
  width: 90%;
}

.myBar {
  width: 1%;
  height: 10px;
  background-color: #007bff;
}
#image {
  position: absolute;
  top: 0px;
}
.form-field-file .field-file {
  display: none;
}

.form-field-file i.fa {
  font-size: 18px;
}

.form-field-file .btn1 {
  border: none;
  -webkit-transition: all 1s;
  transition: all 1s;
  cursor: pointer;
}

.emoji-invoker {
  position: absolute;
  top: 2.4rem;
  left: 3.5rem;
  width: 1.5rem;
  height: 1.5rem;
  border-radius: 50%;
  cursor: pointer;
  transition: all 0.2s;
}
.emoji-invoker:hover {
  transform: scale(1.1);
}
.emoji-invoker > svg {
  fill: #b1c6d0;
}

.emoji-picker {
  position: absolute;
  z-index: 1;
  font-family: Montserrat;
  border: 1px solid #ccc;
  width: 16rem;
  height: 20rem;
  overflow-y: scroll;
  padding: 1rem;
  box-sizing: border-box;
  border-radius: 0.5rem;
  background: #fff;
  box-shadow: 1px 1px 8px #c7dbe6;
  top: -296px !important;
  left: 16px !important;
  font-size: 14px;
  overflow-x: hidden;
}
.emoji-picker__search {
  display: flex;
  margin-bottom: 15px;
}
.emoji-picker__search > input {
  flex: 1;
  border-radius: 10rem;
  border: 1px solid #ccc;
  padding: 0.5rem 1rem;
  outline: none;
  font-size: 0.7rem;
}
.emoji-picker h5 {
  margin-bottom: 0;
  color: #b1b1b1;
  text-transform: uppercase;
  font-size: 0.8rem;
  cursor: default;
}
.emoji-picker .emojis {
  display: flex;
  flex-wrap: wrap;
  justify-content: space-between;
}
.emoji-picker .emojis:after {
  content: "";
  flex: auto;
}
.emoji-picker .emojis span {
  padding: 0.2rem;
  cursor: pointer;
  border-radius: 5px;
}
.emoji-picker .emojis span:hover {
  background: #ececec;
  cursor: pointer;
}
.profile.incomingName{
  height: 200px;
  width: 200px;
  border-radius: 50%;
  margin: 0 auto;
}
.profile.incomingName img{
  width: 100%;
  border-radius: 50%;
  height: 100%;
}
#videocallReceiver .modal-dialog{
  pointer-events: all;
}
.message-container .outer-content .m-box {
    height: calc(100vh - 172px);
}
.newMsg span{
  background: red;
  border-radius: 50%;
  padding: 2px;
  font-size: 5px;
}

/* .msg-body .msg-text-box.right .panel {
      -webkit-box-orient: horizontal;
      -webkit-box-direction: reverse;
      -ms-flex-direction: row-reverse;
      flex-direction: row-reverse;
  }
  .msg-body .msg-text-box.right .panel .box:first-child {
    margin-left: 15px;
}
.msg-body .msg-text-box.right .panel .box {
    max-width: 450px;
}
.msg-body .msg-text-box.right .panel .box:last-child {
    background: #007bff;
}
.msg-body .msg-text-box.right .panel .box:last-child p, .msg-body .msg-text-box.right .panel .box:last-child h6 {
    color: #ffffff;
}
.message-container .outer-content .main-area .msg-body .msg-text-box.right .box small {
    color: #ffffff;
} */
@media(max-width: 767px){
  .message-body{
    width: 100%;
  }
  .details-pane{
    position: absolute;
    background: white;
    height: 100%;
    top: 50px;
  }
  .message-container .outer-content{
    display: block;
  }
  .chat-widget-conversation {
    height: calc(100vh - 267px) !important;
    min-height: calc(100vh - 238px);
    padding: 8px !important;
  }
  .message-container .outer-content .main-area .msg-footer{
    position: fixed;
    bottom: 0;
    width: 94%;
    border-radius: 0;
  }
  .message-container .outer-content .main-area .msg-header{
    height: 90px;
  }
  .closeMsg{
    position: absolute;
    z-index: 123;
    font-size: 20px;
    top: 40px;
  }
}
</style>

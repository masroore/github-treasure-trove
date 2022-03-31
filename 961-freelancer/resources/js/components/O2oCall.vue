<template>
	<div style="height:calc(100vh - 120px);">
  <vue-jitsi-meet
    ref="jitsiRef"
    domain="meet.jit.si"
    :options="jitsiOptions"
  ></vue-jitsi-meet>
  </div>
</template>
<script>
import VueSocketio from "vue-socket.io";
import socketio from "socket.io-client";
import { JitsiMeet } from '@mycure/vue-jitsi-meet';
import moment from "moment";
var socket = socketio.connect('https://961freelancer.com:22000/');
export default {
   components: {
    VueJitsiMeet: JitsiMeet
  },
  props: [
  	"userdata"
  ],
  name: "App",
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
      userEmail: "",
      searchFriend: "",
      post: "",
      message: "",
      check_image: "",
      conversation_id: "",
      showUsers: true,
      searchUser: false,
      typing: false,
      showDetails: false,
      videoCallActive: false,
      parameters: {},
      projectRoom: '',
      elapsedcallTime: 0,
      calltimer: undefined,
      callstatus: 0,
      callReceiveStatus:false,
      callCommingStatus:0,
      callingStatus:true,
      callDisable:true,
    };
  },
  sockets: {
    connect: function () {
      console.log("socket connected successfully");
      console.log();
    },

    disconnect() {
      console.log("socket disconnected");
    },
    peekO2OReceiverPanal(data) {
      if (data.friendId == this.userId) {    
        this.onStopCall();
      }
    },
    peekO2OreceivestarTimer(data) {

    if (data.reciverid == this.friendId || data.friendId == this.userId) {
        this.checkreset();
        this.checkcallstart();
        this.callReceiveStatus=true;
      }
  	},

  },
   
  mounted() {
	  this.projectRoom = this.$route.query.projectName;
	  this.friendName=this.$route.query.friendName;
	  this.userId = this.$route.query.userId;
	  this.friendId = this.$route.query.friendId;
	  if(this.$route.query.callStatus == 'video'){
	    this.callingStatus = false;
	  }else{
	    this.callingStatus = true;
	  } 
	  if(this.$route.query.receiveUser == 'yes'){
	    this.checkcallstart();
	    this.callReceiveStatus = true;
	  }
  },
  watch: {
    callstatus() {
      console.log(this.checkcallTime);
    },
  },
  computed: {
  
 jitsiOptions () {
   
            return {
              roomName: this.projectRoom,
              noSSL: false,
              userInfo: {
                email: this.userdata.email,
                displayName: this.userdata.first_name,
              },
              configOverwrite: {
                enableNoisyMicDetection: false,
                disableSimulcast: true,
                prejoinPageEnabled: false,
                disableDeepLinking: true,
                startWithVideoMuted: this.callingStatus,
              },
              interfaceConfigOverwrite: {
                 TOOLBAR_BUTTONS: [
                  'microphone', 'camera', 'closedcaptions', 'desktop', 'fullscreen',
                  'fodeviceselection', 'hangup', 'profile', 'etherpad', 'sharedvideo', 'settings', 'raisehand',
                  'videoquality', 'filmstrip', 'feedback', 'stats',
                  'tileview', 'videobackgroundblur', 'download', 'help', 'mute-everyone',
              	],

	              AUDIO_LEVEL_PRIMARY_COLOR: 'rgba(255,255,255,0.4)',
	              AUDIO_LEVEL_SECONDARY_COLOR: 'rgba(255,255,255,0.2)',
	              AUTO_PIN_LATEST_SCREEN_SHARE: 'remote-only',
	              BRAND_WATERMARK_LINK: ' ',
	              CLOSE_PAGE_GUEST_HINT: false, // A html text to be shown to guests on the close page, false disables 

	              CONNECTION_INDICATOR_AUTO_HIDE_ENABLED: true,
	              CONNECTION_INDICATOR_AUTO_HIDE_TIMEOUT: 5000,
	              CONNECTION_INDICATOR_DISABLED: false,
	              DEFAULT_BACKGROUND: '#474747',
	              DEFAULT_LOCAL_DISPLAY_NAME: 'me',
	              DEFAULT_LOGO_URL: 'https://stun.peekvideochat.com/images/watermark.png',
	              DEFAULT_REMOTE_DISPLAY_NAME: 'Loading',
	              DISABLE_DOMINANT_SPEAKER_INDICATOR: false,
	              DISABLE_FOCUS_INDICATOR: false,
	              DISABLE_JOIN_LEAVE_NOTIFICATIONS: false,
	              DISABLE_PRESENCE_STATUS: false,
	              DISABLE_RINGING: false,
	              DISABLE_TRANSCRIPTION_SUBTITLES: false,
	              DISABLE_VIDEO_BACKGROUND: false,
	              DISPLAY_WELCOME_PAGE_CONTENT: false,
	              DISPLAY_WELCOME_PAGE_TOOLBAR_ADDITIONAL_CONTENT: false,
	              ENABLE_DIAL_OUT: true,
	              ENABLE_FEEDBACK_ANIMATION: false, // Enables feedback star animation.
	              FILM_STRIP_MAX_HEIGHT: 120,
	              filmStripOnly: false,
	              GENERATE_ROOMNAMES_ON_WELCOME_PAGE: false,
	              HIDE_INVITE_MORE_HEADER: true,
	              INITIAL_TOOLBAR_TIMEOUT: 20000,
	              JITSI_WATERMARK_LINK: 'http://peekinternational.com/',
	              LANG_DETECTION: true, // Allow i18n to detect the system language
	              LIVE_STREAMING_HELP_LINK: 'http://peekinternational.com/', // Documentation reference for the live streaming feature.
	              LOCAL_THUMBNAIL_RATIO: 16 / 9, // 16:9

	              MAXIMUM_ZOOMING_COEFFICIENT: 1.3,

	              MOBILE_APP_PROMO: false,
	              // NATIVE_APP_NAME: 'Als Web Cam',
	              OPTIMAL_BROWSERS: [ 'chrome', 'chromium', 'firefox', 'nwjs', 'electron', 'safari' ],
	              POLICY_LOGO: null,
	              // PROVIDER_NAME: 'Als Web Cam',
	              RECENT_LIST_ENABLED: false,
	              REMOTE_THUMBNAIL_RATIO: 1, // 1:1
	              SETTINGS_SECTIONS: [ 'devices', 'language', 'moderator', 'profile', 'calendar' ],
	              SHOW_BRAND_WATERMARK: false,
	              SHOW_CHROME_EXTENSION_BANNER: false,
	              SHOW_DEEP_LINKING_IMAGE: false,
	              SHOW_JITSI_WATERMARK: false,
	              SHOW_POWERED_BY: false,
	              SHOW_PROMOTIONAL_CLOSE_PAGE: false,
	              SHOW_WATERMARK_FOR_GUESTS: true, // if watermark is disabled by default, it can be shown only for guests
	              SUPPORT_URL: 'http://peekinternational.com/',
	              TOOLBAR_ALWAYS_VISIBLE: true,
	              disableDeepLinking: true,
	              TOOLBAR_TIMEOUT: 60000,
	              UNSUPPORTED_BROWSERS: [],
	              VERTICAL_FILMSTRIP: true,
	              VIDEO_LAYOUT_FIT: 'both',
	              VIDEO_QUALITY_LABEL_DISABLED: false,
	              makeJsonParserHappy: 'even if last key had a trailing comma'

              },
              onload: this.onIFrameLoad
            };
           
          },

   
  },
   	methods: {
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
	 		onIFrameLoad () {
        this.$refs.jitsiRef.addEventListener('participantJoined', this.onParticipantJoined);
        this.$refs.jitsiRef.addEventListener('videoConferenceLeft', this.onStopCall);
     	},
     	onParticipantJoined (e) {
   	    // alert('join');
   	  },
   	  onStopCall(){
   	    this.callDisable = false;
   	   var o2oobg = {
          friendId: this.friendId,
          userId: this.userId
        }

       

          this.$socket.emit('peekUpdateCallStatus', {
              userId: this.userId,
              userName: this.userName,
              friendId: this.friendId,
              friendName: '',
              status: 0,
              call:'close'
              
            });
          var status=0;
          if(this.callReceiveStatus == true){
               this.callCommingStatus=5;
          }else{
               this.callCommingStatus=3;
          }

          
           this.$socket.emit('peekO2OcloseReceiverPanal', o2oobg);
            // this.$router.push('/');
            // window.location.href = "/";
          window.close();
          this.checkreset();
          this.checkcallstop();

   	  },
   	},
  };

  </script>
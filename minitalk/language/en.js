var LANGNAME = "English";
var LANG = {};

LANG.time = {};
LANG.time.fulltext = "{year}-{month}-{date} {hour}:{minute}:{second}";
LANG.time.full = "{year}-{month}-{date} {hour}:{minute}:{second}";
LANG.time.time = "{hour}:{minute}:{second}";

LANG.title = "Minitalk6";
LANG.privateTitle = "{nickname}’s private channel";

LANG.me = "I";
LANG.personCount = "{count}name";

LANG.status = {};
LANG.status.online = "Online";
LANG.status.away = "Away";
LANG.status.otherwork = "Do not disturb";
LANG.status.working = "Boondoggling";
LANG.status.pray = "...";
LANG.status.offline = "Offline";

LANG.tool = {};
LANG.tool.bold = "Bold";
LANG.tool.italic = "Italic";
LANG.tool.underline = "Underlined";
LANG.tool.scroll = "Fix scroll";
LANG.tool.clear = "Clear all the chat";
LANG.tool.mute = "Mute";
LANG.tool.push = "Push notification";
LANG.tool.privchannel = "Private channel";
LANG.tool.autofocus = "Auto-focus";
LANG.tool.emoticon = "Emoticon";
LANG.tool.color = "Font color";

LANG.usermenu = {};
LANG.usermenu.myinfo = "Change profile";
LANG.usermenu.whisper = "Whisper message";
LANG.usermenu.call = "Call";
LANG.usermenu.privchannel = "Invite to my private channel";
LANG.usermenu.showip = "Show the IP";
LANG.usermenu.banip = "Block the IP";
LANG.usermenu.banmsg = "Block the chat a while";
LANG.usermenu.opper = "Allocate as admin";
LANG.usermenu.deopper = "Unblock admin";
LANG.usermenu.police = "Report the user";
LANG.usermenu.talkfocus = "Highlight the user’s word";
LANG.usermenu.talkunfocus = "Unblock the highlight";
LANG.usermenu.talkban = "Devoice";
LANG.usermenu.talkunban = "Unblock devoice";

LANG.errorcode = {};
LANG.errorcode.code101 = "The channel has not been created yet. Please contact the administrator.";
LANG.errorcode.code201 = "Every server is offline. Accessing again later.";
LANG.errorcode.code202 = "The authentication to use the Minitalk server is not approved yet. Please check the remaining duration and your request to access the server again.";
LANG.errorcode.code203 = "The period to access the Minitalk server is expired.";
LANG.errorcode.code204 = "The max connections number of the Minitalk server has exceeded. Please try again later.";
LANG.errorcode.code301 = "You cannot use the nickname.";
LANG.errorcode.code302 = "The nickname is being used now.";
LANG.errorcode.code303 = "The nickname is duplicated, so you access as a new nickname.";
LANG.errorcode.code304 = "Changing the same nickname of other user who has lower role.";
LANG.errorcode.code305 = "Your account has been logged into on another page, so your current access is deactivated";
LANG.errorcode.code306 = "You can’t change your nickname in a private channel.";
LANG.errorcode.code314 = "Another user with higher level will use your current nickname. Yours is initicated.";
LANG.errorcode.code315 = "Another access occurred in the other window. Deactivating current access.";
LANG.errorcode.code401 = "You do not have permission.";
LANG.errorcode.code402 = "Your IP is blocked by the administrator.";
LANG.errorcode.code403 = "This ID is in the blocking IP list, so you cannot use the chat.";
LANG.errorcode.code404 = "Cannot find a user with the nickname.";
LANG.errorcode.code501 = "The channel has exceeded the maximum number of allowed connection. Please retry again later.";
LANG.errorcode.code601 = "You cannot use the private channel in the browser you are using. Please use the latest version of web browsers such as IE(8 or higher), Firefox, Chrome, or Safari.";
LANG.errorcode.code997 = "Cannot verify the identity. You cannot login.";
LANG.errorcode.code998 = "Cannot verify the identify. Please refresh the page again, or try valid access.";
LANG.errorcode.code999 = "Invalid access. Please refresh the page again, or try valid access.";

LANG.error = {};
LANG.error.storage = "You cannot use the local repository of the browser. Please use the latest browser such as Chrome, Safari, Firefox, or IE(8 or higher).";
LANG.error.notSupportBrowser = "The function is not available in the browser you are using.";
LANG.error.notAllowFontSetting = "You do not have permission to change font.";
LANG.error.notAllowChat = "You don’t have right to join the chat";
LANG.error.connectFail = "An unexpected error happened during access to the server.";
LANG.error.reconnectFail = "Tried to access the chat server again, but failed. Trying access again in 10 seconds.";
LANG.error.disconnect = "Access disconnected.";
LANG.error.nolistenProtocol = "Undefined the event listener to receive the event for name of protocol {protocol}.";
LANG.error.reservedProtocol = "The name of protocol {protocol} cannot be used as the reserved protocol by MiniTalk.";
LANG.error.whisperMe = "You cannot send whispers to yourself.";
LANG.error.whisperCommandError = "You can send whispers as /w(blank)a user’s nickname(blank)word.";
LANG.error.callCommandError = "You can call a user as /call(blank)the user’s nickname.";
LANG.error.loginCommandError = "You can be the channel admin as /login(blank)channel password.";
LANG.error.allowPush = "Please allow the Push to use the Push notification of the browser.";
LANG.error.popup = "Pop-up is blocked. Please allow it and try again.";
LANG.error.loginError = "Channel passwords do not match. Please try again.";

LANG.confirm = {};
LANG.confirm.clearlog = "Do you want to delete the previous chat list saved in the server?";

LANG.action = {};
LANG.action.checkServer = "Searching the available chat server.";
LANG.action.connecting = "Accessing the chat server.";
LANG.action.connected = "You entered the server and joined the channel {channel}.";
LANG.action.waitReconnect = "Trying access the chat server again after {count} seconds.";
LANG.action.loadingUserList = "Loading the participants.";
LANG.action.loadedUserCount = "Loaded {count} participants.";
LANG.action.joinUser = "{nickname} joined the chat.";
LANG.action.leaveUser = "{nickname} finished the chat.";
LANG.action.changeNickname = "{before} changed the nickname to {after}.";
LANG.action.changeStatus = "{nickname} changed the status to {status}.";
LANG.action.showip = "{nickname}’s IP is {ip}.";
LANG.action.banip = "{from} blocked the IP of {to}.";
LANG.action.opper = "{from} allocated {to} the Admin role.";
LANG.action.deopper = "{from} disabled the Admin role of {to}.";
LANG.action.autoHideUser = "Hiding the user list because the concurrent user is over 200. Click ‘See the user list’ again to see the list.";
LANG.action.useFixedScroll = "The scroll of the chat is fixed from no own. Click the button again to make the chat be scrolled automatically.";
LANG.action.useAutoScroll = "Scrolled automatically when a new word is added.";
LANG.action.useSound = "Turns the notification sound on about if you are called or invited to a private channel.";
LANG.action.muteSound = "Turns the notification sound off about if you are called or invited to a private channel.";
LANG.action.clearLog = "Deleted all chat records.";
LANG.action.call = "You called {nickname}.";
LANG.action.callNotify = "{nickname} called you.";
LANG.action.usePush = "You get a browser notice when other user calls or invites you to private channel.";
LANG.action.stopPush = "You do not get a browser notice when other user calls or invites you to private channel.";
LANG.action.createPrivateChannel = "No private channel activated, so a new private channel will be created. The user will be invited automatically after you enter your private channel.";
LANG.action.joinPrivateChannel = "Joining to the private channel of {nickname}.";
LANG.action.inviteUser = "You invited {nickname} to your private channel.";
LANG.action.inviteNotify = "{nickname} invited you to the private channel.";
LANG.action.inviteNotifyLayer = "{nickname} invited you to the private channel at {time}.<br />Click this button to join or decline the invitation.";
LANG.action.inviteConfirm = "Accept chat invitation? If you want to join, click ‘OK’.";
LANG.action.inviteReject = "{nickname} declined your invitation to your private channel.";
LANG.action.inviteRejected = "You declined invitation to the private channel by {nickname}.";
LANG.action.banmsg = "{from} blocked words by {to} for 60 seconds.";
LANG.action.banedmsg = "{from} blocked my word for 60 seconds. You cannot talk for the moment.";
LANG.action.banedtime = "You are being blocked to chat for a while. Chat again after {second}.";
LANG.action.login = "Logging-in. Please wait.";
LANG.action.logged = "Achieved the Admin role successfully. It remains before your reaccess.";

LANG.whisper = {};
LANG.whisper.from = "Whisper by {nickname}";
LANG.whisper.to = "Whisper to {nickname}";
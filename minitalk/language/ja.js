var LANGNAME = "日本語";
var LANG = {};

LANG.time = {};
LANG.time.fulltext = "{year}年 {month}月 {date}日 {hour}時 {minute}分 {second}秒";
LANG.time.full = "{year}-{month}-{date} {hour}:{minute}:{second}";
LANG.time.time = "{hour}:{minute}:{second}";

LANG.title = "ミニトーク6";
LANG.privateTitle = "{nickname}様の個人チャンネル";

LANG.me = "自分";
LANG.personCount = "{count}人";

LANG.status = {};
LANG.status.online = "オンライン";
LANG.status.away = "ROM";
LANG.status.otherwork = "作業中";
LANG.status.working = "根落ち中";
LANG.status.pray = "...";
LANG.status.offline = "オフライン";

LANG.tool = {};
LANG.tool.bold = "BOLD";
LANG.tool.italic = "ITALIC";
LANG.tool.underline = "underline";
LANG.tool.scroll = "スクロール固定";
LANG.tool.clear = "画面掃除";
LANG.tool.mute = "ミュート";
LANG.tool.push = "呼び出し";
LANG.tool.privchannel = "個人チャンネル";
LANG.tool.autofocus = "自動フォーカス";
LANG.tool.emoticon = "絵文字";
LANG.tool.color = "文字色";

LANG.usermenu = {};
LANG.usermenu.myinfo = "情報変更";
LANG.usermenu.whisper = "PM転送";
LANG.usermenu.call = "呼び出し";
LANG.usermenu.privchannel = "個人チャンネル招待";
LANG.usermenu.showip = "IP確認";
LANG.usermenu.banip = "IP遮断";
LANG.usermenu.banmsg = "CHAT一時遮断";
LANG.usermenu.opper = "管理者にする";
LANG.usermenu.deopper = "一般ユーザにする";
LANG.usermenu.police = "ユーザ通報";
LANG.usermenu.talkfocus = "ユーザ会話強調";
LANG.usermenu.talkunfocus = "ユーザ会話強調を解除";
LANG.usermenu.talkban = "ユーザ会話遮断";
LANG.usermenu.talkunban = "ーザ会話遮断を解除";

LANG.errorcode = {};
LANG.errorcode.code101 = "チャンネルが開設されませんでした。 管理者にお問合せお願いします。";
LANG.errorcode.code201 = "すべてのサーバーがオフラインです。 しばらく後、再び接続を試みます。";
LANG.errorcode.code202 = "ミニトークサーバーに承認されませんでした。 接続可能期間やミニトークサーバー接続申込みを確認してください。";
LANG.errorcode.code203 = "ミニトークサーバー接続、利用期間が満了しました。";
LANG.errorcode.code204 = "ミニトークサーバーの最大接続者を超過しているため接続できません。 しばらく後、再びチャレンジしてください。";
LANG.errorcode.code301 = "このニックネームは使用できません。";
LANG.errorcode.code302 = "このニックネームは現在使用中です。";
LANG.errorcode.code303 = "ニックネームが重複しているため新しいニックネームで接続します。";
LANG.errorcode.code304 = "同じニックネームを使用している権限が低い他のユーザーのニックネームを変更しています。";
LANG.errorcode.code305 = "別のウインドウで接続中です。 現在の接続を解除しています。";
LANG.errorcode.code306 = "個人チャンネルではニックネームを変更することはできません。";
LANG.errorcode.code314 = "権限が高いユーザーが現在のニックネームを使用しようとしてるため、当ニックネームを初期化します。";
LANG.errorcode.code315 = "別のウインドウで接続を試み、現在の接続を解除します。";
LANG.errorcode.code401 = "권権限がありません。";
LANG.errorcode.code402 = "管理者によって接続が遮断されました。";
LANG.errorcode.code403 = "このIPは接続不可IPリストにあり、当チャットを利用することはできません。";
LANG.errorcode.code404 = "このニックネームのユーザーが見つかりません。";
LANG.errorcode.code501 = "ミニトークサーバーの最大接続者を超過しているため接続できません。 しばらく後、再びチャレンジしてください。";
LANG.errorcode.code601 = "現在使用しているブラウザでは個人チャンネルを利用することはできません。 IE8以上、FireFox、ClomeやSafaliなど最新のブラウザを使用してください。";

LANG.errorcode.code997 = "インターネットユーザーを確認することができず、ログインできません。";
LANG.errorcode.code998 = "インターネットユーザーを確認できません。 ページをリロードしたり、正常な方法で接近してください。";
LANG.errorcode.code999 = "誤った処理です。 ページをリロードしたり、正常な方法で再接続してください。";

LANG.error = {};
LANG.error.storage = "ブラウザのローカルストレージを使用できません。 IE8以上、FireFox、ClomeやSafaliなど最新のブラウザを使用するか、個人情報保護ブラウジングを終了した後接続をしてみてください。";

LANG.error.notSupportBrowser = "現在使用しているブラウザではサポートされていない機能です。";
LANG.error.notAllowFontSetting = "フォント設定権限がありません。";
LANG.error.notAllowChat = "チャットの参加権がありません。";
LANG.error.connectFail = "チャットサーバに接続してエラーが発生しました。 10秒後、再び接続を試みます。";
LANG.error.reconnectFail = "チャットサーバに接続できませんでした。 10秒後、再び接続を試みます。";
LANG.error.disconnect = "サーバとの接続が切れました。";
LANG.error.nolistenProtocol = "{protocol}プロトコル名はイベントを受信するイベントリスナが定義されていません。";
LANG.error.reservedProtocol = "{protocol}プロトコル名はミニトークによって予約されたプロトコルで使用できません。";
LANG.error.whisperMe = "自分自身にプライベートメッセージを送ることはできません。";
LANG.error.whisperCommandError = "/w(空白)受けとる方のニックネームは(空白)でプライベートメッセージを送ることができます。";
LANG.error.callCommandError = "/call(空白)呼び出しを受けられる人のニックネームの形でインターネットユーザーを呼び出すことができます。";
LANG.error.loginCommandError = "/login(空白)チャンネルパスワードと同様のパスワードでチャンネル管理者権限を得ることができます。";
LANG.error.allowPush = "ブラウザの通知権限の承認が可能です。";
LANG.error.popup = "ポップアップが遮断されています。 ポップアップ許可をした後、再びチャレンジしてください。";
LANG.error.loginError = "チャンネルパスワードと一致しません。 チャンネルパスワードを再確認してください。";

LANG.confirm = {};
LANG.confirm.clearlog = "サーバーに保存された対話記録も削除しますか？";

LANG.action = {};
LANG.action.checkServer = "接続可能なチャットサーバを探しています。";
LANG.action.connecting = "チャットサーバに接続中です。";
LANG.action.connected = "チャットサーバに接続して{channel}チャンネルに参加しました。";
LANG.action.waitReconnect = "{count}秒後にチャットサーバに再接続を試みます。";
LANG.action.loadingUserList = "接続者リストを招いています。";
LANG.action.loadedUserCount = "総{count}名義接続者リストを招待しました。";
LANG.action.joinUser = "{nickname}さんがチャットに参加しました。";
LANG.action.leaveUser = "{nickname}さんがチャットを終了しました。";
LANG.action.changeNickname = "{before}さんがチャット名を{after}に変更しました。";
LANG.action.changeStatus = "{nickname}さんが自分のステイタスを{status}に変更しました。";
LANG.action.showip = "{nickname}さんのIPは{ip}です。";
LANG.action.banip = "{from}さんが{to}さんのIPを遮断しました。";
LANG.action.opper = "{from}さんが{to}さんに管理者権限を付与しました。";
LANG.action.deopper = "{from}さんが{to}さんの管理者権限を解除しました。";
LANG.action.autoHideUser = "接続者数が200人を越えたため接続者リストを隠します。 再び接続者のリストを見るためには、接続者リスト見るボタンをクリックしてください。";
LANG.action.useFixedScroll = "チャットのスクロールが今から固定されます。 自動的にスクロールなることを願ったらスクロール固定ボタンをもう一度クリックしてください。";
LANG.action.useAutoScroll = "チャットの内容が追加されるたびにスクロールが自動的に調節されます。";
LANG.action.useSound = "他のユーザーが呼び出したり、個人チャンネルに招待した際の通知音を有効にします。";
LANG.action.muteSound = "他のユーザーが呼び出したり、個人チャンネルに招待した際の通知音を無効にします。";
LANG.action.clearLog = "チャット対話記録をすべて捨消去しました。";
LANG.action.call = "{nickname}様を呼び出しました。";
LANG.action.callNotify = "{nickname}さんが呼び出しました。";
LANG.action.usePush = "他のユーザーが呼び出したり、個人チャンネルに招待したときにブラウザのお知らせメッセージを受けます。";
LANG.action.stopPush = "他のユーザーが呼び出したり、個人チャンネルに招待したときにブラウザのお知らせメッセージを受けない。。";
LANG.action.createPrivateChannel = "活動中の個人チャンネルがないため、新たに個人チャンネルを作ります。 個人チャンネルに接続した後、自動的に該当ユーザーを個人チャンネルに招待します。";
LANG.action.joinPrivateChannel = "{nickname}さんの個人チャンネルに参加します。";
LANG.action.inviteUser = "{nickname}様を個人チャンネルに招待しました。";
LANG.action.inviteNotify = "{nickname}さんが個人チャンネルに招待しました。";
LANG.action.inviteNotifyLayer = "{nickname}さんが{time}に個人チャンネルに招待しました。<br/>当該個人チャンネルに参加したり、招待を断わる場合にはここをクリックしてください。";
LANG.action.inviteConfirm = "個人チャンネル招待を承認しますか。 確認をクリックすると、当個人チャンネルに参加します。";
LANG.action.inviteReject = "{nickname}さんが個人チャンネル招待を断りました。";
LANG.action.inviteRejected = "{nickname}さんの個人チャンネル招待を断りました。";
LANG.action.banmsg = "{from}様{to}さんのチャットを一時遮断(60秒)しました。";
LANG.action.banedmsg = "{from}さんが私のチャットを一時遮断しました。 60秒の間、チャットが禁止されます。";
LANG.action.banedtime = "チャット一時遮断のうちです。 {second}秒後に再びチャットをすることができます。";
LANG.action.login = "ログイン中です。 少々お待ちください。";
LANG.action.logged = "ログインに成功しました。管理者権限を獲得しました。 管理者権限は再接続する前まで維持されます。";


LANG.whisper = {};
LANG.whisper.from = "{nickname}さんから";
LANG.whisper.to = "{nickname}さんに";
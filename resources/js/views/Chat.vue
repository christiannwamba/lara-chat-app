<template>
    <div class="booker">
        <nav-bar :name="this.username" :avatar="this.avatar" />
        <div class="chat">
            <div class="container">
                <div class="msg-header">
                    <div class="active">
                        <h5>#General</h5>
                    </div>
                </div>

                <div class="chat-page">
                    <div class="msg-inbox">
                        <div class="chats" id="chats">
                            <div class="msg-page" id="msg-page">

                                <div
                                    v-if="loadingMessages"
                                    class="loading-messages-container"
                                >
                                    <spinner :size="100"/>
                                    <span class="loading-text">
                            Loading Messages
                          </span>
                                </div>
                                <div class="text-center img-fluid empty-chat" v-else-if="!groupMessages.length" >
                                    <div class="empty-chat-holder">
                                        <img src="../../assets/empty-state.svg" class="img-res" alt="empty chat image">
                                    </div>

                                    <div>
                                        <h2> No new message? </h2>
                                        <h6 class="empty-chat-sub-title">
                                            Send your first message below.
                                        </h6>
                                    </div>
                                </div>

                                <div v-else>
                                    <div v-for="message in groupMessages" v-bind:key="message.id">
                                        <div class="received-chats" v-if="message.sender.uid !== uid">
                                            <div class="received-chats-img">
                                                <img v-bind:src="message.sender.avatar" alt="" class="avatar">
                                            </div>

                                            <div class="received-msg">
                                                <div class="received-msg-inbox">
                                                    <p><span>{{ message.sender.uid }}</span><br>{{ message.data.text }}</p>
                                                </div>
                                            </div>
                                        </div>


                                        <div class="outgoing-chats" v-else>
                                            <div class="outgoing-chats-msg">
                                                <p>{{ message.data.text }}</p>
                                            </div>

                                            <div class="outgoing-chats-img">
                                                <img v-bind:src="message.sender.avatar" alt="" class="avatar">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="msg-bottom">
                        <form class="message-form" v-on:submit.prevent="sendGroupMessage">
                            <div class="input-group">
                                <input type="text" class="form-control message-input" placeholder="Type something" v-model="chatMessage" required>
                                <spinner
                                    v-if="sendingMessage"
                                    class="sending-message-spinner"
                                    :size="30"
                                />
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    // @ is an alias to /src
    import { CometChat } from "@cometchat-pro/chat";
    import NavBar from "../components/NavBar.vue";
    import Spinner from "../components/Spinner.vue";

    export default {
        name: "home",
        components: {
            NavBar,
            Spinner
        },
        data() {
            return {
                username: "",
                avatar: "",
                uid: "",
                sendingMessage: false,
                chatMessage: "",
                loggingOut: false,
                groupMessages: [],
                loadingMessages: false
            };
        },
        mounted() {
            this.loadingMessages = true
            var listenerID = "UNIQUE_LISTENER_ID";

            const messagesRequest = new CometChat.MessagesRequestBuilder()
                .setLimit(100)
                .build()
            messagesRequest.fetchPrevious().then(
                messages => {
                    console.log("Message list fetched:", messages);
                    console.log("this.groupMessages", this.groupMessages)
                    this.groupMessages = [
                        ...this.groupMessages,
                        ...messages
                    ];
                    this.loadingMessages = false
                    this.$nextTick(() => {
                        this.scrollToBottom();
                    })
                },
                error => {
                    console.log("Message fetching failed with error:", error);
                }
            );

            CometChat.addMessageListener(
                listenerID,
                new CometChat.MessageListener({
                    onTextMessageReceived: textMessage => {
                        console.log("Text message received successfully", textMessage);
                        // Handle text message
                        console.log(this.groupMessages)
                        this.groupMessages = [
                            ...this.groupMessages,
                            textMessage
                        ];
                        this.loadingMessages = false
                        this.$nextTick(() => {
                            this.scrollToBottom();
                        })
                    }
                })
            );
        },

        created() {
            this.getLoggedInUser();
        },
        methods: {
            getLoggedInUser() {
                CometChat.getLoggedinUser().then(
                    user => {
                        this.username = user.name;
                        this.avatar = user.avatar;
                        this.uid = user.uid;
                    },
                    error => {
                        this.$router.push({
                            name: "homepage"
                        });
                        console.log(error);
                    }
                );
            },

            scrollToBottom() {
                const chat = document.getElementById("msg-page");
                chat.scrollTo(0, chat.scrollHeight + 30);
            },

            sendGroupMessage() {
                this.sendingMessage = true;
                var receiverID = process.env.MIX_COMMETCHAT_GUID;
                var messageText = this.chatMessage;
                var receiverType = CometChat.RECEIVER_TYPE.GROUP;

                var textMessage = new CometChat.TextMessage(
                    receiverID,
                    messageText,
                    receiverType
                );

                CometChat.sendMessage(textMessage).then(
                    message => {
                        console.log("Message sent successfully:", message);
                        this.chatMessage = "";
                        this.sendingMessage = false;
                        this.$nextTick(() => {
                            this.scrollToBottom()
                        })
                    },
                    error => {
                        console.log("Message sending failed with error:", error);
                    }
                );
            }
        }
    };
</script>

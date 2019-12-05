<template>
    <div class="login-page">
        <div class="login">
            <div class="login-container auth-container">
                <div class="login-form-column">
                    <form v-on:submit.prevent="authLoginAppUser">
                        <h3>Hello!</h3>
                        <div class="form-wrapper">
                            <label>Username</label>
                            <input type="text" name="username" id="username" v-model="username" placeholder="Enter your username" class="form-control" required>
                        </div>

                        <div class="form-wrapper">
                            <label for="password">Password</label>
                            <input type="password" name="password" id="password" v-model="password" placeholder="******" class="form-control" required>
                        </div>
                        <button type="submit">LOG IN &nbsp;&nbsp;<span v-if="showSpinner" class="fa fa-spin fa-spinner"></span> </button>
                    </form>

                    <div class="text-center m-t-50 link-reg">
                        <p v-on:click="redirectToRegister">Don't have an account? <span>Register</span></p>
                    </div>
                </div>

                <div class="login-image-column">
                    <div class="image-holder">
                        <img src="../../assets/login-illustration.svg" alt="">
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    import { CometChat } from "@cometchat-pro/chat";
    export default {
        data() {
            return {
                username: "",
                password: '',
                showSpinner: false,
                token: '',
            };
        },
        methods: {
            authLoginAppUser() {
                let userData = {
                    username: this.username,
                    password: this.password
                };

                if (this.username && this.password) {
                    axios.post(`http://localhost:8000/api/login`, userData).then(response => {
                        this.logUserInToCometChat(response.data.token)
                    }).catch(error => {
                        alert(error.response.data.message);
                        console.log(error.response.data.message);
                    })
                } else {
                    alert('Please check your credentials');
                }
            },

            logUserInToCometChat(token) {
                this.showSpinner = true;
                CometChat.login(token).then(
                    () => {
                        this.showSpinner = false;
                        console.log("successfully login user");
                        this.$router.push({
                            name: 'chat',
                            params: {username: this.username, authenticated: true}
                        });
                    },
                    error => {
                        this.showSpinner = false;
                        alert("Whops. Something went wrong. This commonly happens when you enter a username that doesn't exist. Check the console for more information")
                        console.log("Login failed with error:", error.code);
                    }
                );
            },
            redirectToRegister() {
                this.$router.push({name: 'register'});
            }
        }
    };
</script>

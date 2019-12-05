# Build a chat app with Laravel and Vue

Read the full tutorial here:

>> Not yet published

This application detailed the step by step guide on how to build a modern group chat application using Laravel, Vue.js and CometChat.


## Technology

This demo uses:
* [CometChat](https://cometchat.com/)
* [Laravel](https://laravel.com/)
* [Vuejs](https://vuejs.org/)


## Prerequisite
Before proceeding to build 
This tutorial assumes you have:
* A PHP development environment setup.
* Git installed. Follow this [link to download Git](https://git-scm.com/) if otherwise
* A global installation of composer, which will be used to install all dependencies for the project.
    *  Note: Mac users can install composer using homebrew.
      
       brew install composer 
       
* Node.js & NPM - Node.JS and Node Package Manager. You can [download it here](https://nodejs.org/en/), if not installed.


## Running the demo
To run the demo follow these steps:

1. Head to the [CometChat dashboard](https://app.cometchat.com/) (you'll need to create a free account if you haven't already)
2. From the dashboard, create a new app called "vue-group-chat" or use any name you prefer
3. Once created, click the button **Explore**
4. Click **API Keys** on the left-hand-side and note the automatically-generated Full access API Key and the application ID as well
5. Go to the **Groups** tab and note the GUID of the group automatically created by CometChat
6. Download the repository [here](https://github.com/yemiwebby/vue-group-chat-app/archive/master.zip) or by running `git clone https://github.com/yemiwebby/vue-group-chat-app.git`
7. Run `composer install` to install all the dependencies for the backend (Laravel)
8. Run `npm install` to install all the dependencies for the frontend (Vuejs)
9. Create a `.env` file with the root folder of the project, then copy the content `.env.example` and paste it in the newly created file.
10. Next, locate the following variables within the `.env` file and replace the placeholders with the appropriate credentials:

```
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=YOUR_DB_NAME
DB_USERNAME=YOUR_DB_USERNAME
DB_PASSWORD=YOUR_DB_PASSWORD

MIX_COMMETCHAT_API_KEY=YOUR_COMMETCHAT_API_KEY
MIX_COMMETCHAT_APP_ID=YOUR_COMMETCHAT_APP_ID
MIX_COMMETCHAT_GUID=YOUR_COMMETCHAT_GUID
```

11. Next, run the following command to create tables for your database:

```bash
php artisan migrate
```

12. Open the project in two separate terminal. From one of the terminals, run `php artisan serve` to start the backend and `npm run watch` from the other to start the frontend application in watch mode.

13. You can go ahead and register two different users. Once you are done, log in from two different browsers with the credentials of the users created and start a chat session.

## Useful links
* 🏠 [CometChat Homepage](https://www.cometchat.com/pro)
* 🚀 [Create your free account](https://app.cometchat.com/#/apps)
* 📚 [Documentation](https://prodocs.cometchat.com/docs)
* 👾 [GitHub](https://github.com/CometChat-Pro)

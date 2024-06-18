const Pusher = require("pusher-js");

// Pusher configuration
const pusherOptions = {
    appId: "1821182",
    key: "your_pusheec2eb9b08241d01989far_app_key",
    secret: "4c759a88de0d5b57b552",
    cluster: "eu", // Ensure you provide the correct cluster value
    encrypted: true, // or false, depending on your Pusher app setup
    // Add other options as needed
};

const pusher = new Pusher(pusherOptions.key, pusherOptions);
console.log("test");
// Now use the `pusher` instance in your Echo configuration
const Echo = require("laravel-echo").default;

const echoOptions = {
    broadcaster: "pusher",
    client: pusher, // Provide the Pusher client instance
    authEndpoint: "/broadcasting/auth",
    // Add other Echo options as needed
};

const EchoInstance = new Echo(echoOptions);

const userId = 2;
EchoInstance.private(`user.${userId}`).notification((notification) => {
    console.log(notification);
});

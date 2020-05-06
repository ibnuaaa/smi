<!DOCTYPE html>
<html>

<head>
    <script src="https://www.gstatic.com/firebasejs/4.13.0/firebase-app.js"></script>
    <script src="https://www.gstatic.com/firebasejs/4.13.0/firebase-messaging.js"></script>
    <script>
        firebase.initializeApp({
            apiKey: "AIzaSyCOOa63viwIemDaKWebZytbip94ZytFTHU",
            authDomain: "eoffice-171e6.firebaseapp.com",
            databaseURL: "https://eoffice-171e6.firebaseio.com",
            projectId: "eoffice-171e6",
            storageBucket: "eoffice-171e6.appspot.com",
            messagingSenderId: "654327881786",
            appId: "1:654327881786:web:aeba11dd67c499b87d9503",
            measurementId: "G-ZKX1Z0491C"
        })
        const messaging = firebase.messaging();
        function initFirebaseMessagingRegistration() {
            messaging
                .requestPermission()
                .then(function () {
                    messageElement.innerHTML = "Got notification permission";
                    console.log("Got notification permission");
                    return messaging.getToken();
                })
                .then(function (token) {
                console.log('token', token)
                    // print the token on the HTML page
                    tokenElement.innerHTML = "Token is " + token;
                })
                .catch(function (err) {
                    errorElement.innerHTML = "Error: " + err;
                    console.log("Didn't get notification permission", err);
                });
        }
        messaging.onMessage(function (payload) {
            console.log("Message received. ", JSON.stringify(payload));
            notificationElement.innerHTML = notificationElement.innerHTML + " " + payload.data.notification;
        });
        messaging.onTokenRefresh(function () {
            messaging.getToken()
                .then(function (refreshedToken) {
                    console.log('Token refreshed.');
                    tokenElement.innerHTML = "Token is " + refreshedToken;
                }).catch(function (err) {
                    errorElement.innerHTML = "Error: " + err;
                    console.log('Unable to retrieve refreshed token ', err);
                });
        });
    </script>
</head>

<body>
    <h1>This is a test page</h1>
    <div id="token" style="color:lightblue"></div>
    <div id="message" style="color:lightblue"></div>
    <div id="notification" style="color:green"></div>
    <div id="error" style="color:red"></div>
    <script>
        messageElement = document.getElementById("message")
        tokenElement = document.getElementById("token")
        notificationElement = document.getElementById("notification")
        errorElement = document.getElementById("error")
    </script>
    <button onclick="initFirebaseMessagingRegistration()">Enable Firebase Messaging</button>

</html>

"use strict"

const rememberMe = document.querySelector("#rememberMe");

// Add an event listener to check when the checkbox is clicked or the form is submitted
rememberMe.addEventListener("change", () => {
    // Calculate expiration date (30 days from today)
    const expires = new Date();
    expires.setDate(expires.getDate() + 30);

    // Set the cookie based on whether the checkbox is checked
    if (rememberMe.checked) {
        // If the checkbox is checked, set the cookie with the name "rememberMe" and the value "true"
        document.cookie = `rememberMe=true; expires=${expires.toUTCString()}; path=/`;
        console.log("You want to be remembered");
    } else {
        // If the checkbox is not checked, set the cookie with the name "rememberMe" and the value "false"
        document.cookie = `rememberMe=false; expires=${expires.toUTCString()}; path=/`;
        console.log("You don't want to be remembered");
    }
});

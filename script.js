document.getElementById("verificationForm").addEventListener("submit", function(event) {
    event.preventDefault();
    var email = document.getElementById("emailInput").value;
    verifyEmail(email);
});

function verifyEmail(email) {
    fetch("verify_email.php?email=" + encodeURIComponent(email))
        .then(response => response.text())
        .then(result => {
            document.getElementById("verificationResult").innerText = result;
        })
        .catch(error => {
            console.error('Error:', error);
            document.getElementById("verificationResult").innerText = "An error occurred. Please try again later.";
        });
}

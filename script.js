function verifyEmail() {
    var email = document.getElementById('email').value.trim();
    if (email === '') {
        alert('Please enter an email.');
        return;
    }

    // Assuming you're sending an AJAX request to verify_email.php
    var xhr = new XMLHttpRequest();
    xhr.open('GET', 'verify_email.php?email=' + encodeURIComponent(email), true);
    xhr.onreadystatechange = function () {
        if (xhr.readyState === 4) {
            if (xhr.status === 200) {
                var result = xhr.responseText;
                document.getElementById('verificationResult').innerText = result;
            } else {
                alert('Error: ' + xhr.statusText);
            }
        }
    };
    xhr.send();
}

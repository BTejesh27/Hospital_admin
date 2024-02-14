const loginForm = document.querySelector('.login-container');
const registrationForm = document.querySelector('.registrationForm');
const msg = document.getElementById("msg");
const show=document.querySelector(".show");

let otp = '';

function toggleRegistrationForm() {
    
    if (loginForm.style.display !== 'none') {
        loginForm.style.display = 'none';
        registrationForm.style.display = 'block';
    } else {
        loginForm.style.display = 'block';
        registrationForm.style.display = 'none';
    }
}

function sendSMS() {
    const accountSid = 'ACa2c1ef075dd1173e25115d16b8822a1f';
    const authToken = '28affecee0ff74ea8d20e93a27be8403';
    const twilioUrl = `https://api.twilio.com/2010-04-01/Accounts/${accountSid}/Messages.json`;
    
    const phoneNumber = '+91' + document.getElementById('phoneNumber').value;
    const bodyParams = new URLSearchParams();
    
    show.style.display == 'none' ? show.style.display = 'block' : show.style.display = 'none';
    // Generate OTP
    otp = '';
    for (let i = 0; i < 6; i++) {
        otp += Math.floor(Math.random() * 10);
    }

    bodyParams.append('From', '+16592574643');
    bodyParams.append('To', phoneNumber);
    bodyParams.append('Body', 'Your OTP is: ' + otp);
    
    fetch(twilioUrl, {
        method: 'POST',
    headers: {
        'Authorization': 'Basic ' + btoa(`${accountSid}:${authToken}`),
        'Content-Type': 'application/x-www-form-urlencoded'
        },
        body: bodyParams
    })
    .then(response => response.json())
    .then(data => {
        console.log('SMS sent successfully:', data);
        // alert('SMS sent successfully!');
    })
    .catch(error => {
        console.error('Error sending SMS:', error);
        alert('Failed to send SMS. Please try again later.');
    });
}
            
function validateOtp() {
    const check = document.getElementById('OTP').value;
    const reg_btn=document.querySelector(".reg_btn");
    
    check == otp ? reg_btn.style.display = 'block' : msg.innerHTML = "Invalid OTP";
}
// document.addEventListener('DOMContentLoaded', function () {
//     const loginForm = document.getElementById('login-form');
//     const errorMessage = document.getElementById('error-message');

//     if (loginForm) {
//         loginForm.addEventListener('submit', function (e) {
//             // Only prevent default if validation fails
//             if (!loginForm.checkValidity()) {
//                 e.preventDefault();
//                 errorMessage.textContent = 'Please fill in all required fields';
//                 errorMessage.style.display = 'block';
//             }
//         });
//     }

//     // Password validation for registration
//     const password = document.getElementById('password');
//     const confirmPassword = document.getElementById('confirmPassword');
//     const passwordMatch = document.getElementById('passwordMatch');
//     const registerForm = document.getElementById('register-form');

//     if (password && confirmPassword && passwordMatch) {
//         const validatePassword = () => {
//             if (confirmPassword.value === '') {
//                 passwordMatch.textContent = '';
//                 return;
//             }

//             const match = password.value === confirmPassword.value;
//             passwordMatch.style.color = match ? 'green' : 'red';
//             passwordMatch.textContent = match ? 'Passwords match' : 'Passwords do not match';

//             if (registerForm) {
//                 const submitButton = registerForm.querySelector('button[type="submit"]');
//                 if (submitButton) {
//                     submitButton.disabled = !match;
//                 }
//             }
//         };

//         password.addEventListener('input', validatePassword);
//         confirmPassword.addEventListener('input', validatePassword);
//     }

//     // Close modal when clicking outside
//     const modal = document.getElementById('successModal');
//     if (modal) {
//         window.onclick = function (event) {
//             if (event.target == modal) {
//                 window.location.href = modal.querySelector('button').getAttribute('onclick').split("'")[1];
//             }
//         }
//     }
// });
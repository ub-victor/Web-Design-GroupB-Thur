const loginBtn = document.getElementById('loginBtn');
        const exitBtn = document.getElementById('exitBtn');
        const errorMsg = document.getElementById('errorMsg');
        const usernameInput = document.getElementById('username');
        const passwordInput = document.getElementById('password');

        loginBtn.addEventListener('click', function() {
            const username = usernameInput.value;
            const password = passwordInput.value;

            
            if (username === '' || password === '') {
                errorMsg.textContent = 'One field miss';
                return;
            }

            
            if (username === 'victoire' && password === '27269') {
               
                window.location.href = 'exam.html';
            } else {
                errorMsg.textContent = 'Please enter the correct values as you denied';
            }
        });

        exitBtn.addEventListener('click', function() {
            usernameInput.value = '';
            passwordInput.value = '';
            errorMsg.textContent = '';
        });
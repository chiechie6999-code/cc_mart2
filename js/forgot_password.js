function fetchQuestions() {
    const username = document.getElementById('username').value;
    const questionsContainer = document.getElementById('questions-container');

    if (username.length > 0) {
        fetch('get_questions.php', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/x-www-form-urlencoded',
            },
            body: 'username=' + encodeURIComponent(username)
        })
        .then(response => response.json())
        .then(data => {
            if (data) {
                document.getElementById('question_1_label').textContent = data.question1;
                document.getElementById('question_2_label').textContent = data.question2;
                document.getElementById('question_3_label').textContent = data.question3;
                questionsContainer.style.display = 'block';
            } else {
                questionsContainer.style.display = 'none';
            }
        });
    } else {
        questionsContainer.style.display = 'none';
    }
}
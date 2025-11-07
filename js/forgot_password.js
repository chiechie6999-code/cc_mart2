function fetchQuestions() {
    const username = document.getElementById('username').value;
    const questionsContainer = document.getElementById('questions-container');

    if (username.trim() === '') {
        questionsContainer.style.display = 'none';
        return;
    }

    fetch('php/get_questions.php?username=' + encodeURIComponent(username))
        .then(response => response.json())
        .then(data => {
            if (data.error) {
                alert(data.error);
                questionsContainer.style.display = 'none';
            } else {
                document.getElementById('question_1_label').textContent = data.auth_question_1;
                document.getElementById('question_2_label').textContent = data.auth_question_2;
                document.getElementById('question_3_label').textContent = data.auth_question_3;
                questionsContainer.style.display = 'block';
            }
        })
        .catch(error => {
            console.error('Error fetching questions:', error);
            questionsContainer.style.display = 'none';
        });
}

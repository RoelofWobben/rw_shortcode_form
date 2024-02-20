var all_forms = document.querySelectorAll('[data-shortcode="contact_form"] > form');

all_forms.forEach((form) => {
    form.addEventListener('submit', (e) => {
        e.preventDefault();

        // array that holds all the validation errors 

        var error_messages = [];

        // find the subject field of the form 

        var subject = form.subject.value;
        var email = form.email.value;
        var message = form.message.value;  


        if (subject.length < 3) {
            error_messages.push('Subject has to be more then 3 characters');
        }

        var validRegex = /^[a-zA-Z0-9.!#$%&'*+/=?^_`{|}~-]+@[a-zA-Z0-9-]+(?:\.[a-zA-Z0-9-]+)*$/;

        if (!email.match(validRegex)) {
            error_messages.push('Please input a valid email adress'); 
        }

        if (message.length < 2) {

            error_messages.push('Message has to be more then 2 characters'); 
        }



        // show the error messages

        // Select the user-feedback div
        const userFeedbackDiv = document.querySelector('.user_feedback');

        // Create a new div to hold the error messages
        const errorDiv = document.createElement('div');
        errorDiv.classList.add('error');

        // Append the error div to the user-feedback div
        userFeedbackDiv.appendChild(errorDiv);

        // Select the error div
        const errorDivElement = document.querySelector('.error');

        // Clear any existing content in the error div
        errorDivElement.innerHTML = '';

        // Loop through the error messages array and create HTML elements for each message
        error_messages.forEach(errorMessage => {
            // Create a new <p> element
            const errorParagraph = document.createElement('p');

            // Set the text content of the <p> element to the current error message
            errorParagraph.textContent = errorMessage;

            // Append the <p> element to the error div
            errorDivElement.appendChild(errorParagraph);
        });
    })
})


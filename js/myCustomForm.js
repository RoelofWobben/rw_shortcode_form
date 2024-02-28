var all_forms = document.querySelectorAll('[data-shortcode="contact_form"] > form');

/**
* Function to send form data to the backend
* @param {FormData} data - The form data
* @param {string} url - The backend URL
* @returns {Promise} The response from the backend
*/
async function send_to_backend(data, url) {
    var response = await fetch(url, {
        method: 'POST',
        body: data
    })
    var data = await response.json();
    if (typeof(data) == 'object') {
        
    }
}

/**
* Loop through all forms on the page
*/
all_forms.forEach((form) => {

    /**
    *  @type {HTMLDivElement}
    */

    var userFeedbackDiv = document.querySelector('.user_feedback'); 

    /**
    * Function to reset user feedback
    */

    var resetUserFeedback = function resetUserFeedback() {
        userFeedbackDiv.classList.add('hidden');
        while (userFeedbackDiv.firstChild) {
            userFeedbackDiv.removeChild(userFeedbackDiv.firstChild);
        }
    };

    /**
    * Function to show error messages
    * @param {Array} messages - The error messages
    */
    var showErrorMessages = function showErrorMessages(messages) {


        /**
        * Create a new div to hold the error messages
        */
        const errorDiv = document.createElement('div');
        errorDiv.classList.add('error');

        // Append the error div to the user-feedback div
        userFeedbackDiv.appendChild(errorDiv);

        /**
        * Select the error div
        */
        const errorDivElement = form.querySelector('.error');




        /**
        * Loop through the error messages array and create HTML elements for each message
        */
        messages.forEach(message => {
            // Create a new <p> element
            const errorParagraph = document.createElement('p');

            // Set the text content of the <p> element to the current error message
            errorParagraph.textContent = message;

            // Append the <p> element to the error div
            errorDivElement.appendChild(errorParagraph);
        });
    };


    /**
    * Event listener for form submission
    */
    form.addEventListener('submit', (e) => {
        e.preventDefault();
        resetUserFeedback();

        var error_messages = [];

        /**
        * Create FormData from the form
        */
        var formdata = new FormData(form);


        /**
        * Get the subject, email, and message from the form data
        */
        var subject = formdata.get("subject");
        var email = formdata.get("email");
        var message = formdata.get('message'); 
        /**
               
        
        
        * Validate the subject
        */
        if (subject.length < 3) {
            console.log("invalid subject");
            error_messages.push('Subject has to be more then 3 characters');
        }

        var validRegex = /^[a-zA-Z0-9.!#$%&'*+/=?^_`{|}~-]+@[a-zA-Z0-9-]+(?:\.[a-zA-Z0-9-]+)*$/;
        
        
        if (!email.match(validRegex)) {
            error_messages.push('Please input a valid email adress');
        }

        /**
        * Validate the message
        */
        if (message.length < 2) {

            error_messages.push('Message has to be more then 2 characters');
        }

        /**
        * If there are error messages, show them
        */
        if (error_messages.length) {
            showErrorMessages(error_messages);
            userFeedbackDiv.classList.remove('hidden');
            return
        }

        /**
        * Send the form data to the backend
        */
        var backend_response = send_to_backend(formdata, form.action);
    })
})


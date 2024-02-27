var all_forms = document.querySelectorAll('[data-shortcode="contact_form"] > form');

function showErrorMessages(messages, form) {
    // show the error messages

        // Select the user-feedback div
        const userFeedbackDiv = form.querySelector('.user_feedback');

        // Create a new div to hold the error messages
        const errorDiv = document.createElement('div');
        errorDiv.classList.add('error');

        // Append the error div to the user-feedback div
        userFeedbackDiv.appendChild(errorDiv);

        // Select the error div
        const errorDivElement = form.querySelector('.error');

        // Clear any existing content in the error div
        errorDivElement.innerHTML = '';

        // Loop through the error messages array and create HTML elements for each message
        messages.forEach(message => {
            // Create a new <p> element
            const errorParagraph = document.createElement('p');

            // Set the text content of the <p> element to the current error message
            errorParagraph.textContent = message;

            // Append the <p> element to the error div
            errorDivElement.appendChild(errorParagraph);
        });
}


async function send_to_backend(data, url) {
    var response = await fetch( url, {
        method: 'POST', 
        body: data
    })
    var data = await response.json(); 
    await console.log(data); 
}

all_forms.forEach((form) => {

    const userFeedbackDiv = form.querySelector('.user_feedback');
    userFeedbackDiv.classlist.add('hidden'); 
    
    form.addEventListener('submit', (e) => {
        e.preventDefault();

        /**
         *  @type {HTMLDivElement}
         */

        

        while (userFeedbackDiv.firstChild) {
            userFeedbackDiv.removeChild(userFeedbackDiv.firstChild); 
        } 
        
        var error_messages = [];

        var formdata = new FormData(form);

        // find the subject field of the form 

        var subject = formdata.get("subject");
        var email = formdata.get("email"); 
        var message = formdata.get("message");   


        if (subject.length < 3) {
            console.log("invalid subject"); 
            error_messages.push('Subject has to be more then 3 characters');
        }

        var validRegex = /^[a-zA-Z0-9.!#$%&'*+/=?^_`{|}~-]+@[a-zA-Z0-9-]+(?:\.[a-zA-Z0-9-]+)*$/;

        if (!email.match(validRegex)) {
            error_messages.push('Please input a valid email adress'); 
        }

        if (message.length < 2) {

            error_messages.push('Message has to be more then 2 characters'); 
        }

        if (error_messages.length) {
             showErrorMessages(error_messages, form);
             userFeedbackDiv.classList.remove('hidden'); 
             return
        }
        
        var backend_response = send_to_backend(formdata, form.action); 
    })
})




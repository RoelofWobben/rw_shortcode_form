var all_forms = document.querySelectorAll('[data-shortcode="contact_form"] > form');

/**
* Function to send form data to the backend
* @param {FormData} data - The form data
* @param {string} url - The backend URL
*/
async function send_to_backend(data, url) {
	var response = await fetch(url, {
		method: 'POST',
		body: data
	})
	return response.json();
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
	* @return void
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
	* @params {string} type - the type of Error messages
	* @return void 
	*/
	var showMessages = function showMessages(messages, type = "error") {

		/**
		* Create a new div to hold the error 
		* @type {HTMLDivElement}
		*/
		const errorDiv = document.createElement('div');
		
		errorDiv.classList.add(type);

		// Append the error div to the user-feedback div
		userFeedbackDiv.appendChild(errorDiv);

		messages.forEach(message => {
			/**
			 * @type {HTMLDivElement}
			 */
			const errorParagraph = document.createElement('p');

			// Set the text content of the <p> element to the current error message
			errorParagraph.textContent = message;

			// Append the <p> element to the error div
		});
		errorDiv.appendChild(errorParagraph);
	};


	/**
	* Event listener for form submission
	*/
	form.addEventListener('submit', async (e) => {
		e.preventDefault();
		resetUserFeedback();

		var button = e.submitter;
		button.setAttribute('disabled', "");
		
		/**
		 * @type array<string>
		 */ 
		var error_messages = [];

		/**
		* Create FormData from the form
		* @type {FormData}
		*/
		var formdata = new FormData(form);


		/**
		* Get the subject, email, and message from the form data
		*/
		var subject = formdata.get("subject");
		var email = formdata.get("email");
		var message = formdata.get('message');
		
		if (subject.length < 3) {
			error_messages.push(feedback_message.subject_error);
		}

		var validRegex = /^[a-zA-Z0-9.!#$%&'*+/=?^_`{|}~-]+@[a-zA-Z0-9-]+(?:\.[a-zA-Z0-9-]+)*$/;


		if (!email.match(validRegex)) {
			error_messages.push(feedback_message.email_error);
		}

		
		if (message.length < 2) {

			error_messages.push(feedback_message.message_error);
		}

		if (error_messages.length) {
			showMessages(error_messages);
			userFeedbackDiv.classList.remove('hidden');
			button.removeAttribute('disabled');
			return
		}



		/**
		* Call to the backend 
		*  @param {FormData} formdata- The form data
		*  @param {string} form.action - the action of the form 
		*/
		var backend_response = await send_to_backend(formdata, form.action);

		if (backend_response['success']) {
			showMessages([feedback_message.success_message], "success");
			form.reset();
		} else {
			// take all the messages out of the array of object
			let messages = backend_response.data.map(item => item.message);
			// show the messages 
			showMessages(messages, "Error");
		}

		button.removeAttribute('disabled');
	})
})


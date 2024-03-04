/**
 * @typedef {Object} ServerError
 * @property {String} code
 * @property {String} message
 * 
 * @typedef {Object} ServerResponse
 * @property {Boolean} success
 * @property {?Array.<ServerError>} data
 */



/**
 * @type NodeListOf<HTMLFormElement>
 */
var all_forms = document.querySelectorAll('[data-shortcode="contact_form"] > form');

/**
* Call to the backend
* @param {FormData} data - The form data
* @param {string} url - The backend URL
* @return {Promise<ServerResponse>} 
*/
async function send_to_backend(data, url) {
	var response = await fetch(url, {
		method: 'POST',
		body: data
	})
	return response.json();
}




var all_forms = document.querySelectorAll('[data-shortcode="contact_form"] > form');

/**
* Call to backend
* @param {FormData} data - The form data
* @param {string} url - The backend URL
* @return {Promise | Object} 
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
* @param {HTMLFormElement}  form
*/
all_forms.forEach((form) => {

	/**
	*  @type {HTMLDivElement}
	*/
	var userFeedbackDiv = document.querySelector('.user_feedback');

	/**
	* Function to reset user feedback
	* @return {void}
	*/
	var resetUserFeedback = function resetUserFeedback() {
		userFeedbackDiv.classList.add('hidden');
		while (userFeedbackDiv.firstChild) {
			userFeedbackDiv.removeChild(userFeedbackDiv.firstChild);
		}
	};

	/**
	* Function to show messages
	* @param {Array} messages - The error messages
	* @param {string} type - the type of Error messages
	* @return {void} 
	*/
	var showMessages = function showMessages(messages, type = "error") {

		/**
		* Create a new div to hold the error 
		* @type {HTMLDivElement}
		*/
		const errorDiv = document.createElement('div');

		errorDiv.classList.add(type);

		messages.forEach(message => {
			/**
			 * @type {HTMLParagraphElement}
			 */
			const errorParagraph = document.createElement('p');

			errorParagraph.textContent = message;

			errorDiv.appendChild(errorParagraph);
		});
		userFeedbackDiv.appendChild(errorDiv);

	};


	/**
	* Event listener for form submission
	* @param {SubmitEvent} e  
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
		 * @type {ServerResponse}
		 */
		var backend_response = await send_to_backend(formdata, form.action);

		if (backend_response['success']) {
			showMessages([feedback_message.success_message], "success");
			form.reset();
		} else {
			let messages = backend_response.data.map(item => item.message);
			showMessages(messages, "Error");
		}

		button.removeAttribute('disabled');
	})
})


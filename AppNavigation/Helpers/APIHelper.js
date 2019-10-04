const DEFAULT_HEADERS = {
  	Accept: 'application/json',
  	'Content-Type': 'application/json',
};

const POST_HEADERS = {
   	'Content-Type': 'application/x-www-form-urlencoded'
};

export default class APIHelper {
	static completeUrl(url) {
	    return `${global.apiUrl}${url}`;
	}

	static async get(url) {
	    const completedUrl = APIHelper.completeUrl(url);
	    const response = await fetch(completedUrl, { headers: DEFAULT_HEADERS })
	      	.catch((error) => console.error(error));

	    if (APIHelper.invalidResponse(response)) {
	      	return false;
	    }
	    return response.json();
	}

	static async post(url) {
		const completedUrl = APIHelper.completeUrl(url);

		var details = {};

		var formBody = [];
		for (var property in details) {
		  var encodedKey = encodeURIComponent(property);
		  var encodedValue = encodeURIComponent(details[property]);
		  formBody.push(encodedKey + "=" + "'" + encodedValue + "'");
		}
		formBody = formBody.join("&");

		const response = await fetch(completedUrl, {
	    	method: 'POST',
	    	headers: POST_HEADERS,
	    	body: formBody
	    }).catch((error) => console.error(error));

	    if (APIHelper.invalidResponse(response)) {
	      	return false;
	    }
	    return response.json();
	}

	static invalidResponse(response) {
	    return response === undefined || response.status < 200 || response.status >= 400;
	}
}
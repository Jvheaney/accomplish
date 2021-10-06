const API_URL = "https://kilostudios.com/accomplish/endpoints/";

//Networking
export const apiCall = async function(endpoint, data){
  var formBody = [];
  for (var property in data) {
    var encodedKey = encodeURIComponent(property);
    var encodedValue = encodeURIComponent(data[property]);
    formBody.push(encodedKey + "=" + encodedValue);
  }
  formBody = formBody.join("&");
  return fetch(API_URL + endpoint, {
    method: 'POST',
    headers: {
      'Content-Type': 'application/x-www-form-urlencoded;charset=UTF-8'
    },
    body: formBody,
  }).then((response) => response.json())
    .then((responseJson) => {

      //Basic error handling
      if(responseJson != null && !responseJson.success ){
        alert("There seems to be a server error, please try again later.");
      }

      return responseJson;
  })
  .catch((error) => {
    console.error(error);
    alert("We're sorry, there seems to be an error. Please try again later.")
  });
}

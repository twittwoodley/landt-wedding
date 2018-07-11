import $ from 'jquery';

class frontEndUpload {
    constructor() {
    	this.events();
    }

    events() {
    	$(".photo-upload").on("click", this.uploadImage);
    }

    uploadImage() {
    	var newGallery = {
    	'title': $(".photo-input").val()
    	}
    	$.ajax({
      	beforeSend: (xhr) => {
        xhr.setRequestHeader('X-WP-Nonce', themeData.nonce);
      },
      url: themeData.root_url + '/wp-json/wp/v2/gallery/',
      type: 'POST',
      data: newGallery,
      success: (response) => {
      	console.log(response)
      },
      error: (response) => {
      	console.log(response)
      }
  });
   }
}

export default frontEndUpload;
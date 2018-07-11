import $ from 'jquery';

class frontEndUpload {
    constructor() {
    	this.events();
    }

    events() {
    	$(".photo-upload").on("click", this.tester);
    }

    tester() {
    	var image = $('.photo-select')
    	console.log(image)
    }

    uploadImage() {
    	var title = $('.photo-input').val();
    	var form  = new FormData();
       	var image = $('.photo-select')[0].files[0]; //We have only one file and this is how we get it
    	
    	form.append('image', image);
        form.append('title', title);



    	$.ajax({
      	beforeSend: (xhr) => {
        xhr.setRequestHeader('X-WP-Nonce', themeData.nonce);
      },
      url: themeData.root_url + '/wp-json/wp/v2/gallery/',
      type: 'POST',
      data: form,
      processData: false, //Very important
      contentType:false, //Very important

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
import $ from 'jquery';

class DeleteImage {
	constructor() {
		this.events();
	}

	events() {
		$(".delete-image").on('click', this.confirmDelete.bind(this));
	}

	confirmDelete(e) {
		var thisImage = $(e.target).closest(".gallery-image-thumb");
		thisImage.find(".confirm-container").addClass("confirm-container-active");
		thisImage.find('.cancel-delete').on('click', this.cancelDelete.bind(this));
		thisImage.find('.confirm-delete').on('click', this.deletePhoto.bind(this));
	}

	cancelDelete(e) {
		$(".confirm-container").removeClass("confirm-container-active");
	}

	//methods
	deletePhoto(e) {
		var imageToBeDeleted = $(e.target).closest(".gallery-image-thumb");
		$.ajax({
			beforeSend: (xhr) => {
				xhr.setRequestHeader('X-WP-Nonce', themeData.nonce);
			},
			url: themeData.root_url + '/wp-json/wedding/v1/deleteimage',
			data: {'photoId': imageToBeDeleted.attr('data-id')},
			type: 'DELETE',
			success: (response) => {
				imageToBeDeleted.slideUp();
				console.log(response);
			},
			error: (response) => {
				console.log(response);
			},
		}); 
	}
}

export default DeleteImage;

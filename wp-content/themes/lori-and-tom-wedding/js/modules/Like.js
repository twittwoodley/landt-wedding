import $ from 'jquery';

class Like {
	constructor() {
		this.events();
	}

	events() {
		$(".gallery-container").on('click', ".like-box", this.clickDispatcher.bind(this));
		$(".song-list-cont").on('click', ".like-box", this.clickDispatcher.bind(this));
	}
	//Methods

	clickDispatcher(e) {
		var currentLikeBox = $(e.target).closest(".like-box");

		if(currentLikeBox.attr("data-exists") == "yes") {
			this.deleteLike(currentLikeBox);
		} 
		else {
			this.createLike(currentLikeBox);
		}
	}

	createLike(currentLikeBox) {
		$.ajax({
			beforeSend: (xhr) => {
				xhr.setRequestHeader('X-WP-Nonce', themeData.nonce);
			},
			url: themeData.root_url + '/wp-json/wedding/v1/managelike',
			type: 'POST',
			data: {'photoId': currentLikeBox.data('photoid')},
			success: (response) => {
				currentLikeBox.attr('data-exists', 'yes');
				var likeCount = parseInt(currentLikeBox.find('.like-count').html(), 10);
				likeCount++;
				currentLikeBox.find('.like-count').html(likeCount);
				currentLikeBox.attr('data-like', response);
				console.log(response);
			},
			error: (response) => {
				console.log(response);
			},
		}); 
	}

	deleteLike(currentLikeBox) {
		$.ajax({
			beforeSend: (xhr) => {
				xhr.setRequestHeader('X-WP-Nonce', themeData.nonce);
			},
			url: themeData.root_url + '/wp-json/wedding/v1/managelike',
			data: {'like': currentLikeBox.attr('data-like')},
			type: 'DELETE',
			success: (response) => {
				currentLikeBox.attr('data-exists', 'no');
				var likeCount = parseInt(currentLikeBox.find('.like-count').html(), 10);
				likeCount--;
				currentLikeBox.find('.like-count').html(likeCount);
				currentLikeBox.attr('data-like', '');
				console.log(response);
			},
			error: (response) => {
				console.log(response);
			},
		}); 
	}
}

export default Like;
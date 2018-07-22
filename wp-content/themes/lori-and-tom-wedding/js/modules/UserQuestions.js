import $ from 'jquery';

class UserQuestions {
	constructor() {
		this.events();
	}

	events() {
		//Question 
		$('#allQuestions').on('click', '.delete-question' ,this.deleteQuestion);
		$('#allQuestions').on('click', '.edit-question' ,this.editQuestion.bind(this));
		$('#allQuestions').on('click', '.save-question',this.updateQuestion.bind(this));
		$('#allQuestions').on('click', '.reply-question',this.replyQuestion.bind(this));
		$('.submit-question').on('click', this.createQuestion.bind(this));

		//Reply
		$('#allQuestions').on('click', '.edit-reply' ,this.editReply.bind(this));
		$('#allQuestions').on('click', '.delete-reply' ,this.deleteReply.bind(this));
		$('#allQuestions').on('click', '.save-reply' ,this.updateReply.bind(this));
		$('#allQuestions').on('click', '.submit-reply',this.submitReply.bind(this));
	}

	editQuestion(e) {
		var thisQuestion = $(e.target).parents("li");
		if (thisQuestion.data("state") == "editable") {
			this.makeQuestionReadonly(thisQuestion);
		} else {
			this.makeQuestionEditable(thisQuestion);
		}
	}

	makeQuestionEditable(thisQuestion) {
		thisQuestion.find('.edit-question').html('<i class="fa fa-times" aria-hidden="true"></i>');
		thisQuestion.find('.edit-cancel-text').html('Cancel');
		thisQuestion.find(".question-field").attr('contenteditable', 'true').addClass('edit-question-active');
		thisQuestion.find(".save-question").addClass("save-question-visible");
		thisQuestion.data("state", "editable");
		thisQuestion.find('.question-field').focus();
	}

	makeQuestionReadonly(thisQuestion) {
		thisQuestion.find('.edit-question').html('<i class="fa fa-edit" aria-hidden="true"></i>');
		thisQuestion.find('.edit-cancel-text').html('Edit');
		thisQuestion.find(".question-field").removeAttr('contenteditable', 'false').removeClass('edit-question-active');
		thisQuestion.find(".save-question").removeClass("save-question-visible");
		thisQuestion.data("state", "cancel");
	}

	editReply(e) {
		var thisReply = $(e.target).parents(".reply-container");
		if (thisReply.data("state") == "editable") {
			this.makeReplyReadonly(thisReply);
		} else {
			this.makeReplyEditable(thisReply);
		}
	}

	makeReplyEditable(thisReply) {
		thisReply.find('.edit-reply').html('<i class="fa fa-times" aria-hidden="true"></i>');
		thisReply.find('.edit-cancel-text').html('Cancel');
		thisReply.find(".reply-text").attr('contenteditable', 'true').addClass('edit-question-active');
		thisReply.find(".save-reply").addClass("save-question-visible");
		thisReply.data("state", "editable");
		thisReply.find('.reply-text').focus();
	}

	makeReplyReadonly(thisReply) {
		thisReply.find('.edit-reply').html('<i class="fa fa-edit" aria-hidden="true"></i>');
		thisReply.find('.edit-cancel-text').html('Edit');
		thisReply.find(".reply-text").removeAttr('contenteditable', 'false').removeClass('edit-question-active');
		thisReply.find(".save-reply").removeClass("save-question-visible");
		thisReply.data("state", "cancel");
	}

	replyQuestion(e) {
		var thisQuestion = $(e.target).parents("li");
		thisQuestion.find('.reply-input-cont').addClass('show-reply-cont');
		thisQuestion.find('.reply-input').focus();
	}

	deleteQuestion(e) {
		var thisQuestion = $(e.target).parents("li");
		$.ajax({
			beforeSend: (xhr) => {
				xhr.setRequestHeader('X-WP-Nonce', themeData.nonce);
			},
			url: themeData.root_url + '/wp-json/wp/v2/question/' + thisQuestion.attr('data-id'),
			type: 'DELETE',
			success: (response) => {
				thisQuestion.slideUp();	
				console.log('You deleted a post')
				console.log(response);
			},
			error: (response) => {
				console.log('Sozzer Geeza')
				console.log(response);
			}
		});
	}

	updateQuestion(e) {
		var thisQuestion = $(e.target).parents("li");

		var updatedQuestion = {
			'title': thisQuestion.find(".question-field").html()
		}

		$.ajax({
			beforeSend: (xhr) => {
				xhr.setRequestHeader('X-WP-Nonce', themeData.nonce);
			},
			url: themeData.root_url + '/wp-json/wp/v2/question/' + thisQuestion.attr('data-id'),
			type: 'POST',
			data: updatedQuestion,
			success: (response) => {
				this.makeQuestionReadonly(thisQuestion);
				console.log('You updated a post')
				console.log(response);
			},
			error: (response) => {
				console.log('Sozzer Geeza')
				console.log(response);
			}
		});
	}

	createQuestion(e) {
		var newQuestion = {
			'title': $(".new-question-input").val(),
			'status': 'publish'
		}

		$.ajax({
			beforeSend: (xhr) => {
				xhr.setRequestHeader('X-WP-Nonce', themeData.nonce);
			},
			url: themeData.root_url + '/wp-json/wp/v2/question/',
			type: 'POST',
			data: newQuestion,
			success: (response) => {
				$('.new-question-input').val('');
				$(`
					<li class="question-li" data-id="${response.id}">
						<div class="question-wrap">
							<h4 class="question-field">${response.title.raw}</h4>
								<div class="question-reply-and-buttons">
									<div class="reply-input-cont">
										<input class="reply-input">
										<span class="submit-reply">Submit</span>
									</div>
									<div class="question-buttons">
										<span class="reply-question"><i class="fa fa-reply" aria-hidden="true"></i></span>
										<span class="edit-question"><i class="fa fa-edit" aria-hidden="true"></i></span>
										<span class="delete-question"><i class="fa fa-trash-alt" aria-hidden="true"></i></span>
										<span class="save-question"><i class="fa fa-upload" aria-hidden="true"></i></span>
								</div>
							</div>
						</div>
						<span class="question-meta reply-meta">Posted by you just now</span>
					<ul class="reply-ul">
					</ul>
					<hr class="question-break">
					`).prependTo("#allQuestions").hide().slideDown();

				console.log('You updated a post')
				console.log(response);
			},
			error: (response) => {
				console.log('Sozzer Geeza')
				console.log(response);
			}
		});
	}

		submitReply(e) {
		var thisReply = $(e.target).parents("li");
		var newReply = {
			'title': thisReply.find(".reply-input").val(),
			'status': 'publish',
			'parent': thisReply.attr('data-id')
		}

		$.ajax({
			beforeSend: (xhr) => {
				xhr.setRequestHeader('X-WP-Nonce', themeData.nonce);
			},
			url: themeData.root_url + '/wp-json/wp/v2/question/',
			type: 'POST',
			data: newReply,
			success: (response) => {
				$(e.target).parents('li').find('.reply-input').val('');
				$(`
					<li class="question-li reply-container" data-id="${response.id}">
						<p class="reply-text">${response.title.raw}</p>
						<div class="question-buttons reply-buttons">
							<span class="edit-reply"><i class="fa fa-edit" aria-hidden="true"></i></span>
							<span class="delete-reply"><i class="fa fa-trash-alt" aria-hidden="true"></i></span>
							<span class="save-reply"><i class="fa fa-upload" aria-hidden="true"></i></span>
						</div>
						<span class="reply-meta">Posted by you just now</span>
						<hr>
					</li>
					`).prependTo(thisReply.find(".reply-ul")).hide().slideDown();

				console.log('You updated a post')
				console.log(response);
			},
			error: (response) => {
				console.log('Sozzer Geeza')
				console.log(response);
			}
		});
	}

	deleteReply(e) {
		var thisReply = $(e.target).parents(".reply-container");
		$.ajax({
			beforeSend: (xhr) => {
				xhr.setRequestHeader('X-WP-Nonce', themeData.nonce);
			},
			url: themeData.root_url + '/wp-json/wp/v2/question/' + thisReply.attr('data-id'),
			type: 'DELETE',
			success: (response) => {
				thisReply.slideUp();	
				console.log('You deleted a post')
				console.log(response);
			},
			error: (response) => {
				console.log('Sozzer Geeza')
				console.log(response);
			}
		});
	}

	updateReply(e) {
		var thisReply = $(e.target).parents("li");

		var updatedReply = {
			'title': thisReply.find(".reply-text").html()
		}

		$.ajax({
			beforeSend: (xhr) => {
				xhr.setRequestHeader('X-WP-Nonce', themeData.nonce);
			},
			url: themeData.root_url + '/wp-json/wp/v2/question/' + thisReply.attr('data-id'),
			type: 'POST',
			data: updatedReply,
			success: (response) => {
				this.makeQuestionReadonly(thisReply);
				console.log('You updated a post')
				console.log(response);
			},
			error: (response) => {
				console.log('Sozzer Geeza')
				console.log(response);
			}
		});
	}

}

export default UserQuestions;
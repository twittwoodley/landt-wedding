import $ from 'jquery';

class UserQuestions {
	constructor() {
		this.events();
	}

	events() {
		$('#allQuestions').on('click', '.delete-question' ,this.deleteQuestion);
		$('#allQuestions').on('click', '.edit-question' ,this.editQuestion.bind(this));
		$('#allQuestions').on('click', '.save-question',this.updateQuestion.bind(this));
		$('#allQuestions').on('click', '.reply-question',this.replyQuestion.bind(this));
		$('#allQuestions').on('click', '.submit-reply',this.submitReply.bind(this));
		$('.submit-question').on('click', this.createQuestion.bind(this));
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
		thisQuestion.find('.edit-question').html('<i class="fa fa-times" aria-hidden="true"></i>Cancel')
		thisQuestion.find(".question-field").removeAttr('readonly').addClass('edit-question-active');
		thisQuestion.find(".save-question").addClass("save-question-visible");
		thisQuestion.data("state", "editable");
	}

	makeQuestionReadonly(thisQuestion) {
		thisQuestion.find('.edit-question').html('<i class="fa fa-edit" aria-hidden="true"></i>Edit')
		thisQuestion.find(".question-field").attr('readonly', "readonly").removeClass('edit-question-active');
		thisQuestion.find(".save-question").removeClass("save-question-visible");
		thisQuestion.data("state", "cancel");
	}

	replyQuestion(e) {
		var thisQuestion = $(e.target).parents("li");
		thisQuestion.find('.reply-input-cont').addClass('show-reply-cont');
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
			'title': thisQuestion.find(".question-field").val()
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
					<li data-id="${response.id}">
						<span class="edit-question"><i class="fa fa-edit" aria-hidden="true"></i>Edit</span>
						<span class="delete-question"><i class="fa fa-trash-alt" aria-hidden="true"></i>Delete</span>
						<span class="save-question"><i class="fa fa-upload" aria-hidden="true"></i>Save</span>
						<input readonly value="${response.title.raw}" class="question-field">
					</li>
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
		var newQuestion = {
			'title': $(".reply-input").val(),
			'status': 'publish',
			'parent': 256
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
					<li data-id="${response.id}">
						<span class="edit-question"><i class="fa fa-edit" aria-hidden="true"></i>Edit</span>
						<span class="delete-question"><i class="fa fa-trash-alt" aria-hidden="true"></i>Delete</span>
						<span class="save-question"><i class="fa fa-upload" aria-hidden="true"></i>Save</span>
						<input readonly value="${response.title.raw}" class="question-field">
					</li>
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

}

export default UserQuestions;
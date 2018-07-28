import $ from 'jquery';

class Gallery {
	
	constructor() {
		this.events();
	}

	events() {
		$(".image-enlarge-link").on("click", this.addExitLogo.bind(this));
		}

	addExitLogo() {
		$("body").find('.lb-close').addClass('fa fa-times');
		$("body").find('.lb-caption').addClass('hidden');
	}
	//Methods
}

export default Gallery;
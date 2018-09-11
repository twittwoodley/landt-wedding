import $ from 'jquery';

class Header {
	
	constructor() {
		this.events();
	}

	events() {
		$(".mobile-menu-btn").on("click", this.toggleMobileNav.bind(this));
		}

	toggleMobileNav() {
		$(".nav-list").toggleClass("show-nav");
	}
	//Methods
}

export default Header;
import $ from 'jquery';

class genericJS {
	constructor() {			
		this.events();
	}

	events() {
		$( document ).ready(function() {
			console.log('yeah');
		});
	}
}


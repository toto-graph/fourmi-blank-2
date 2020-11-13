(function ($, window, document, undefined) { 'use strict';

    class NavMobile {

    	constructor() {
    		this.$elements = $('[data-nav-mobile-component="1"]');
            this.$triggers = $('[data-nav-mobile-trigger="1"]');

            this.$triggers.on('click', this.toggle.bind(this));
    	}

        toggle(e) {
            this.$elements.toggleClass('-active');
        }

    }

	new NavMobile();

})(jQuery, window, document);

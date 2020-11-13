(function ($, window, document, undefined) { 'use strict';

	const $window = $(window);

	class Aside {

		constructor() {
			this.$container = $('.main-aside');
			this.active = false;

			$window.on('scroll', this.onWindowScroll.bind(this));
			this.onWindowScroll();
		}

		onWindowScroll() {
			var scroll = $window.scrollTop();

			if (scroll > 10 && !this.active) {
				this.$container.addClass('-active');
				this.active = true;
			}
			else if (this.active && scroll <= 10) {
				this.$container.removeClass('-active');
				this.active = false;
			}
		}

	}

	new Aside();

})(jQuery, window, document);

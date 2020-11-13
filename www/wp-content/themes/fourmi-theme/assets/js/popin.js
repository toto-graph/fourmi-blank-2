(function ($, window, document, undefined) { 'use strict';

	class Popin {

		constructor(el) {
			this.$container = $(el);
			this.$overlay = this.$container.find('.popin-overlay');
			this.$close = this.$container.find('.popin-close');
			this.trigger = this.$container.attr('data-trigger');
			this.$triggers = $('a[href="' + this.trigger + '"]');
			this.active = false;
			
			this.$triggers.on('click', this.open.bind(this));
			this.$close.on('click', this.close.bind(this));
			this.$overlay.on('click', this.close.bind(this));
		}

		open(e) {
			e && e.preventDefault && e.preventDefault();
			this.active = true;
			this.$container.addClass('-active');
			$('html').css({ overflow: 'hidden' });
		}

		close(e) {
			e && e.preventDefault && e.preventDefault();
			this.active = false;
			this.$container.removeClass('-active');
			$('html').css({ overflow: 'auto' });
		}

	}

	$('.popin').each(function() {
		new Popin(this);
	});

})(jQuery, window, document);

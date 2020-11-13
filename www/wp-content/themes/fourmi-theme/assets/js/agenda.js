(function ($, window, document, undefined) { 'use strict';

	class Agenda {

		constructor(el) {
			this.$container = $(el);
			this.$openCalendar = this.$container.find('.agenda-calendar-open');
			this.$closeCalendar = this.$container.find('.agenda-calendar-close');
			this.$events = $('.agenda-list-item');

			this.$openCalendar.hide();

			if (window.innerWidth <= 768) {
				this.close();
			}

			this.$openCalendar.on('click', this.open.bind(this));
			this.$closeCalendar.on('click', this.close.bind(this));
		}

		open() {
			this.$container.removeClass('-full');
			this.$openCalendar.hide();
			this.$closeCalendar.show();
		}

		close() {
			this.$container.addClass('-full');
			this.$openCalendar.show();
			this.$closeCalendar.hide();
			this.$events.addClass('-show');
		}

	}

	$('.agenda').each(function() {
		new Agenda(this);
	});

})(jQuery, window, document);

(function ($, window, document, undefined) { 'use strict';

	class Search {

		constructor() {
			this.$resultsContainer = $('.main-search-results');
			this.$close = this.$resultsContainer.find('.main-search-results-close');
			this.$input = $('.main-aside-search-input');
			this.$loader = $('.main-search-results-loader');
			this.$wrapper = $('.main-search-results-wrapper');
			this.active = false;
			this.value = '';
			this.typing = 0;
			this.typingFunction = this.waitForTypingEnd.bind(this);

			this.$input.on('keydown', this.onTypeInput.bind(this));
			this.$close.on('click', this.close.bind(this));
		}

		onTypeInput(e) {
			if (e.keyCode == 27 || this.$input.val() == '') {
				this.close();
			}
			else {
				if (!this.active) {
					this.open();
				}

				clearTimeout(this.typing);
				this.typing = setTimeout(this.typingFunction, 300);
			}
		}

		waitForTypingEnd() {
			var value = this.$input.val().trim();

			if (this.value != value) {
				this.value = value;

				this.getAjaxResults();
			}
		}

		getAjaxResults() {
			this.$wrapper.html('');
			this.$loader.show();

			if (this.value.trim() == '') {
				this.close();
			}
			else {
				$.ajax({
					url: ajax_url,
					type: "GET",
					data: {
					  'action': 'fourmi_get_search_ajax',
					  's': this.value,
					},
				}).done(this.displaySearchResults.bind(this));
			}
		}

		displaySearchResults(data) {
			this.$loader.hide();
			this.$wrapper.html(data);
			loadSVGs(this.$wrapper);
		}

		open() {
			this.active = true;
			this.$resultsContainer.addClass('-active');
			$('html').css({ overflow: 'hidden' });
		}

		close() {
			this.active = false;
			this.$resultsContainer.removeClass('-active');
			$('html').css({ overflow: 'auto' });
		}

	}

	new Search();

})(jQuery, window, document);

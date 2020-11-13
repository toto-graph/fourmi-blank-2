(function ($, window, document, undefined) { 'use strict';

    class GalleryImages {

        constructor(el) {
            this.$container = $(el);

            this.initGallery();
        }

        initGallery() {
        	this.$container.justifiedGallery({
				rowHeight : 200,
				maxRowHeight: 300,
				lastRow : 'nojustify',
				margins : 15,
				selector: '.image',
				captions: false
        	});
        }

    }

	$('.gallery-images').each(function() {
        new GalleryImages(this);
    });

})(jQuery, window, document);

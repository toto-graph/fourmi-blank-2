(function ($, window, document, undefined) { 'use strict';

    class SliderImages {

        constructor(el) {
            this.$container = $(el);
            this.$swiper = this.$container.find('.swiper-container');
            this.$slides = this.$swiper.find('.swiper-slide');
            this.$prev = this.$container.find('.swiper-navigation-button-prev');
            this.$next = this.$container.find('.swiper-navigation-button-next');

            this.initSwiper();
        }

        initSwiper() {
            this.swiper = new Swiper(this.$swiper[0], {
                slidesPerView: 1,
                spaceBetween: 30,
                loop: true,
                navigation: {
                  nextEl: this.$next[0],
                  prevEl: this.$prev[0],
                },
                breakpoints: {
                    768: {
                        slidesPerView: 'auto',
                    }
                }
            });
        }

    }

	$('.slider-images').each(function() {
        new SliderImages(this);
    });

})(jQuery, window, document);

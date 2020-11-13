(function ($, window, document, undefined) { 'use strict';

    /* Remove special chars not handled by Aromatica font */
    moment.updateLocale('fr', {
        'months': [
            'janvier',
            'fevrier',
            'mars',
            'avril',
            'mai',
            'juin',
            'juillet',
            'aout',
            'septembre',
            'octobre',
            'novembre',
            'decembre'
        ]
    });

    class EventsCalendar {

    	constructor(el) {
    		this.$container = $(el);
            this.$template = this.$container.find('.clndr-template');
            this.template = this.$template.html();
            this.id = this.$container.attr('data-id');
            this.events = calendarEvents[this.id];
            this.$events = $('.agenda-list-item');

            this.initCalendar();
    	}

        initCalendar() {
    		this.calendar = this.$container.clndr({
                template: this.template,
                events: this.events,
                forceSixRows: true,
                clickEvents: {
                    click: this.onClickEvent.bind(this),
                },
                doneRendering: this.updateEventsDisplayed.bind(this),
            });

            this.updateEventsDisplayed();
        }

        onClickEvent(target) {
            if (target.events.length > 0) {
                var $container = $(target.element);
                var $tooltip = $('<div class="clndr-tooltip">');

                for (var i in target.events) {
                    var $event = $('<a class="clndr-tooltip-item">');
                    $event.attr('href', target.events[i].link);
                    $event.append('<em class="clndr-tooltip-item-time">'+ target.events[i].time +'</em>');
                    $event.append('<em class="clndr-tooltip-item-title">'+ target.events[i].title +'</em>');

                    $event.appendTo($tooltip);
                }

                $tooltip.appendTo($container);
                setTimeout(function() {
                    $('body').one('click', function() {
                        $tooltip.remove();
                    });
                }, 100);
            }
        }

        updateEventsDisplayed() {
            if (!this.calendar) return;

            var month = this.calendar.month.format('MM-YYYY');

            this.$events.css({ display: 'none' });
            this.$events.filter('[data-month="' + month + '"]').css({ display: 'flex' });
        }

    }

    $('.calendar-events').each(function() {
    	new EventsCalendar(this);
    });

})(jQuery, window, document);

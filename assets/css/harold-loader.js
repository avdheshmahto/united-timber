/**
 * Plugin: Harold Loader
 * Author: Peter Morrison
 * Created: 2014-09-24
 * Updated: 2014-09-25
 * Version: 0.1.0
*/

(function($) 
{

    $.fn.harold = function(options) 
    {

        // Plugin defaults
        var defaults = 
        {
            background: '#44AEE3', 
            fadeSpeed: 200,
            left: 0,
            loader: '.progress',
            padding: 2,
            position: 'fixed',
            top: 0,
            width: $(window).width(),
            padding: 2
        };

        // Plugin settings.
        var settings = $.extend(
        {
            background: defaults.background,
            fadeSpeed: defaults.fadeSpeed,
            left: defaults.left,
            loader: defaults.loader,
            padding: defaults.padding,
            position: defaults.position,
            top: defaults.top,
            width: defaults.width
        }, options);

        // Progress bar CSS background.
        var background = settings.background;

        // Progress bar and content fade in speed.
        var fadeSpeed = settings.fadeSpeed;

        // Progress bar CSS spacing from left of window.
        var left = settings.left;

        // Progress bar element identifier, class or id.
        var loader = settings.loader;

        // Progress bar CSS padding.
        var padding = settings.padding;

        // Progress bar CSS position.
        var position = settings.position;

        // Progress bar CSS spacing from top of window.
        var top = settings.top;

        // Progress bar load to window width.
        var width = settings.width;

        // Content element class or id selector.
        var selector = this.selector;

        // Set the CSS styling of the loader.
        $(loader).css(
        {
            'background': background,
            'left': left, 
            'padding-top': padding,
            'padding-right': 0,
            'padding-bottom': padding,
            'padding-left': 0,
            'position': position,
            'top': top
        });

        /**
         * Harold inializer.
        */
        init = function(selector)
        {
            $(selector).click(function(event) {
                event.preventDefault();
            });

            $(selector).click(function() {
                var href = $(this).attr('href');

                $(loader).stop().animate({width: $(window).width()}, fadeSpeed).fadeOut(fadeSpeed, function() {
                    window.location.href = href;
                });
            });
        }

        // Initialize the progress loader.
        init(selector);
    };

}(jQuery));
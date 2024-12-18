(function ($) {
    // Ensure WordPress Iris exists
    if (!$.a8c || !$.a8c.iris) {
        console.error('Iris color picker is not available');
        return;
    }

    // Extend Iris to set the GeneratePress palette globally
    const originalCreate = $.a8c.iris.prototype._create;

    $.a8c.iris.prototype._create = function () {
        // Set the custom palette globally
        if (window.generatePressPalette && Array.isArray(window.generatePressPalette)) {
            this.options.palettes = window.generatePressPalette;
        }
        originalCreate.call(this); // Call the original method
    };

    console.log('GeneratePress Palette successfully injected into Iris.');
})(jQuery);

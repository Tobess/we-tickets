+function ($) {
    $(function () {
        $(document).on('click', '[ui-tab]>ul.nav>li>a', function (e) {
            e.preventDefault();
            var $this = $(e.target);
            $this.attr('ui-toggle') || ($this = $this.closest('[ui-toggle]'));
            var $target = $($this.attr('target')) || $this;
            $target.toggleClass($this.attr('ui-toggle'));
        });
    });
}(jQuery);
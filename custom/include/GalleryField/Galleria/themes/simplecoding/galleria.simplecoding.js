(function($) {
    Galleria.addTheme({
        name: 'simplecoding',
        author: 'Statsenko Vladimir, http://www.simplecoding.org',
        version: 1,
        css: 'galleria.simplecoding.css',
        defaults: {
            transition: 'fade',
            imagecrop: false,
            _my_color: 'black'
        },
        init: function(options) {

            //добавляем заголовок
            this.addElement('title');
            this.prependChild('container', 'title');

            //добавляем кнопку "Закрыть"
            this.addElement('close');
            this.prependChild('container', 'close');
            this.$('close').html('<a href="#">&nbsp;</a>');

            var overlay = $('<div id="overlay"></div>');
            overlay.add('.galleria-close').click(this.proxy(function(e) {
				if(this.isFullscreen())
					this.exitFullscreen();
                this.$('container').toggleClass('hidden');
                overlay.toggleClass('hidden');
                e.stopPropagation();

                $('#openGallery').css('display', '');

                return false;
            }));

//        this.$('container')
//            .css('background-color', options._my_color)
//            .parent().parent().append(overlay);

            // bind a loader animation:
            this.bind(Galleria.LOADSTART, function(e) {
                if (!e.cached) {
                    this.$('loader').show();
                }
            });
            this.bind(Galleria.LOADFINISH, function(e) {
                this.$('loader').hide();
                var imageData = this.getData();
                this.$('title').html(imageData.title);
            });
        }
    });
}(jQuery));

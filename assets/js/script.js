document.addEventListener('DOMContentLoaded', function() {
    var readMoreToggles = document.querySelectorAll('.compadoReadMoreToggle');

    readMoreToggles.forEach(function(toggle) {
        var targetId = toggle.getAttribute('data-target');
        var hiddenContainer = document.getElementById(targetId);
        var openButton = hiddenContainer.querySelector('.compado-plan-btn-open');
        var closedButton = document.querySelector('.compado-plan-btn-closed');
        hiddenContainer.style.maxHeight = '0';

        toggle.addEventListener('click', function() {
            if (hiddenContainer.style.maxHeight !== '0px') {
                hiddenContainer.style.maxHeight = '0';

                openButton.style.display = 'none';
                closedButton.style.display = 'block';
                this.innerHTML = 'Read More <i class="fa fa-chevron-down"></i>';
            } else {
                hiddenContainer.style.maxHeight = hiddenContainer.scrollHeight + 'px';
                openButton.style.display = 'block';
                closedButton.style.display = 'none';
                this.innerHTML = 'Read Less <i class="fa fa-chevron-up"></i>';
            }
        });
    });

    var carousels = document.querySelectorAll('.compado-carousel');

    carousels.forEach(function(carousel) {
        var images = carousel.querySelectorAll('.img');
        var dots = carousel.querySelectorAll('.dot');

        function updateCarousel(index) {
            images.forEach(function(image, idx) {
                image.classList.toggle('active', index === idx);
            });
            dots.forEach(function(dot, idx) {
                dot.classList.toggle('active', index === idx);
            });
        }

        dots.forEach(function(dot, idx) {
            dot.addEventListener('click', function() {
                updateCarousel(idx);
            });
        });
    });
});
